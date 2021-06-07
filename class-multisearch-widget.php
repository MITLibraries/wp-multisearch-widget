<?php
/**
 * Class that defines the multisearch widget.
 *
 * @package Multisearch Widget
 * @since 0.3.0
 */

namespace mitlib;

/**
 * Defines base widget.
 */
class Multisearch_Widget extends \WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'multisearch-widget',
			'description' => __( 'Search widget for multiple targets', 'multisearch' ),
		);
		parent::__construct( 'multisearch', __( 'MultiSearch', 'multisearch' ), $widget_ops );
	}

	/**
	 * Render_js() builds the script tag used by the search interface.
	 *
	 * @param array $instance See WP_Widget in Developer documentation.
	 * @link https://developer.wordpress.org/reference/classes/wp_widget/
	 */
	private function render_js( $instance ) {
		/**
		 * This should be an external JS file, but I'm not sure how to get instance values from Wordpress into
		 * a JS file without passing it through the PHP interpreter.
		 */
		echo "<script type='text/javascript'>";
		if ( $instance['linked_domains'] ) {
			$domains = explode( ',', $instance['linked_domains'] );
			echo '// function to check linked domains on form submit
				function hasLinkedFormAction( element, index, array ) { return this.includes( element ) }
				// Linked domains as a variable for consulting later
				var linked_domains = [';
			foreach ( $domains as &$item ) {
				echo "'" . esc_attr( trim( $item ) ) . "',";
			}
			echo "];
				// Decorate submitted forms
				jQuery('form').submit(function() {
					if( linked_domains.some( hasLinkedFormAction, this.action ) ) {
						ga('discovery.linker:decorate', this );
					}
				});";
		}
		echo "// Register analytics target
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create',
				'" . esc_attr( $instance['ga_property'] ) . "',
				'auto',
				{'name':'discovery', 'allowLinker': true}
			);";
		if ( $instance['linked_domains'] ) {
			echo "ga('discovery.require', 'linker');
				ga('discovery.linker:autoLink', linked_domains);\n";
		}
		echo "ga('discovery.send', 'pageview');
		</script>";
	}

	/**
	 * Widget() builds the output
	 *
	 * @param array $args See WP_Widget in Developer documentation.
	 * @param array $instance See WP_Widget in Developer documentation.
	 * @link https://developer.wordpress.org/reference/classes/wp_widget/
	 */
	public function widget( $args, $instance ) {
		// Identify which templates are needed based on instance variable.
		$all_template = 'templates/tab-all-eds.php';
		$books_template = 'templates/tab-books-eds.php';
		$articles_template = 'templates/tab-articles-eds.php';
		$articles_tab_name = 'Journals + articles';
		$more_template = 'templates/tab-more-eds.php';
		if ( 'alma' == $instance['targets'] ) {
			$all_template = 'templates/tab-all-alma.php';
			$books_template = 'templates/tab-books-alma.php';
			$articles_template = 'templates/tab-articles-alma.php';
			$articles_tab_name = 'Articles + chapters';
			$more_template = 'templates/tab-more-alma.php';
		}

		// Strip initial arguments.
		$args = null;

		// Register / enqueue javascript.
		// First we add the responsive tabs plugin.
		wp_register_script(
			'responsivetabs-js',
			plugin_dir_url( __FILE__ ) . 'libs/jquery.responsiveTabs.min.js',
			array( 'jquery' ),
			'1.6.1',
			false
		);
		// Second, we add this plugin's javascript.
		wp_register_script(
			'multisearch-js',
			plugin_dir_url( __FILE__ ) . 'wp-multisearch-widget.js',
			array( 'responsivetabs-js' ),
			'1.4.1',
			false
		);
		// Finally, we enquey only this plugin's javascript (which brings everything else in).
		wp_enqueue_script( 'multisearch-js' );

		// Register / enqueue styles.
		wp_register_style( 'responsivetabs-css', plugin_dir_url( __FILE__ ) . 'libs/responsive-tabs.css', '', '1.6.1' );
		wp_register_style(
			'multisearch-tabs',
			plugin_dir_url( __FILE__ ) . 'wp-multisearch-widget.css',
			array( 'responsivetabs-css' ),
			'1.3.0'
		);
		wp_enqueue_style( 'multisearch-tabs' );

		// Render markup.
		echo '<noscript><p>It appears that your browser does not support javascript.</p>';
		include( 'templates/form_nojs.html' );
		echo '</noscript>';
		echo '<div id="multisearch" class="' . esc_attr( $this->widgetClasses( $instance ) ) . ' nojs">';
		echo '<h2 id="searchtabsheader" class="sr">Search the MIT libraries</h2>
			<ul id="search_tabs_nav" aria-labelledby="searchtabsheader">
				<li><a id="tab-all" href="#search-all"><span>All</span></a></li>
				<li><a id="tab-books" href="#search-books"><span>Books + media</span></a></li>
				<li><a id="tab-articles" href="#search-articles"><span>'
				. esc_html( $articles_tab_name )
				. '</span></a></li>
				<li><a id="tab-more" href="#search-more"><span>More...</span></a></li>
			</ul>';
		echo '<div id="search-all" aria-labelledby="tab-all">';
			include( $all_template );
		echo '</div>';
		echo '<div id="search-books" aria-labelledby="tab-books">';
			include( $books_template );
		echo '</div>';
		echo '<div id="search-articles" aria-labelledby="tab-articles">';
			include( $articles_template );
		echo '</div>';
		echo '<div id="search-more" aria-labelledby="tab-more">';
			include( $more_template );
		echo '</div>';
		if ( $instance['banner_text'] ) {
			$allowed = array(
				'a' => array(
					'class' => array(),
					'href' => array(),
					'style' => array(),
				),
				'p' => array(
					'class' => array(),
					'style' => array(),
				),
				'style' => array(),
			);
			echo '<div class="wrap-banner-text no-js-hidden">';
			echo wp_kses( $instance['banner_text'], $allowed );
			echo '</div>';
		}
		echo '</div>';

		// Render the script tag for this widget.
		$this->render_js( $instance );
	}

	/**
	 * Back-end widget form
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$ga_property = $instance['ga_property'];
		$banner_text = $instance['banner_text'];
		$linked_domains = $instance['linked_domains'];
		$targets = $instance['targets'];
		if ( '' == $instance['targets'] ) {
			$targets = 'eds';
		}
		$bento_url = $instance['bento_url'];
		if ( '' == $instance['bento_url'] ) {
			$bento_url = 'https://lib.mit.edu/';
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ga_property' ) ); ?>">
				<?php esc_attr_e( 'Google Analtyics Property' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'ga_property' ) ); ?>"
				type="text"
				name="<?php echo esc_attr( $this->get_field_name( 'ga_property' ) ); ?>"
				value="<?php echo esc_html( $ga_property ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'linked_domains' ) ); ?>">
				<?php esc_attr_e( 'Linked Domains' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'linked_domains' ) ); ?>"
				type="text"
				name="<?php echo esc_attr( $this->get_field_name( 'linked_domains' ) ); ?>"
				value="<?php echo esc_html( $linked_domains ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'banner_text' ) ); ?>">
				<?php esc_attr_e( 'Banner Text (limited HTML allowed)' ); ?>
			</label>
			<textarea
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'banner_text' ) ); ?>"
				type="text"
				rows="5"
				name="<?php echo esc_attr( $this->get_field_name( 'banner_text' ) ); ?>"><?php
				echo esc_html( $banner_text );
			?></textarea>
		</p>
		<p>Which set of search targets should be shown?</p>
		<ul>
			<li>
				<label>
					<input
						type="radio"
						name="<?php echo esc_attr( $this->get_field_name( 'targets' ) ); ?>"
						value="eds"
						<?php
						if ( 'eds' == $targets ) {
							echo "checked='checked'";
						}
						?>
					>
					EDS and Barton
				</label>
			</li>
			<li>
				<label>
					<input
						type="radio"
						name="<?php echo esc_attr( $this->get_field_name( 'targets' ) ); ?>"
						value="alma"
						<?php
						if ( 'alma' == $targets ) {
							echo "checked='checked'";
						}
						?>
					>
					Alma and Primo
				</label>
			</li>
		</ul>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'bento_url' ) ); ?>">
				<?php esc_attr_e( 'Bento URL' ); ?> (formatted like "https://lib.mit.edu/")
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'bento_url' ) ); ?>"
				type="text"
				name="<?php echo esc_attr( $this->get_field_name( 'bento_url' ) ); ?>"
				value="<?php echo esc_html( $bento_url ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['ga_property'] = $new_instance['ga_property'];
		$instance['banner_text'] = $new_instance['banner_text'];
		$instance['linked_domains'] = $new_instance['linked_domains'];
		$instance['targets'] = $new_instance['targets'];
		$instance['bento_url'] = $new_instance['bento_url'];
		return $instance;
	}

	/**
	 * The classes applied to the widget depend on if the banner_text property
	 * is set.
	 *
	 * @param array $instance The widget being rendered.
	 */
	private function widgetClasses( $instance ) {
		$class = 'wrap-search';
		if ( $instance['banner_text'] ) {
			$class = 'wrap-search banner';
		}
		return $class;
	}
}
