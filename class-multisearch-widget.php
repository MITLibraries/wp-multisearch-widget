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
	 * Widget() builds the output
	 *
	 * @param array $args See WP_Widget in Developer documentation.
	 * @param array $instance See WP_Widget in Developer documentation.
	 * @link https://developer.wordpress.org/reference/classes/wp_widget/
	 */
	public function widget( $args, $instance ) {
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
			'0.1.0',
			false
		);
		// Finally, we enquey only this plugin's javascript (which brings everything else in).
		wp_enqueue_script( 'multisearch-js' );

		// Register / enqueue styles.
		wp_register_style( 'responsivetabs-css', plugin_dir_url( __FILE__ ) . 'libs/responsive-tabs.css' );
		wp_register_style(
			'multisearch-tabs',
			plugin_dir_url( __FILE__ ) . 'wp-multisearch-widget.css',
			array( 'responsivetabs-css' )
		);
		wp_enqueue_style( 'multisearch-tabs' );

		// Render markup.
		echo '<noscript><p>It appears that your browser does not support javascript.</p>';
		include( 'templates/form_nojs.html' );
		echo '</noscript>';
		echo '<div id="multisearch" class="wrap-search nojs">';
		echo '<nav aria-labelledby="search-widget-header">
			<h2 id="search-widget-header" class="sr">Search the MIT libraries</h2>
			<ul>
			<li><a href="#search-all"><span>All</span></a></li>
			<li><a href="#search-books"><span>Books + media</span></a></li>
			<li><a href="#search-articles"><span>Journals + articles</span></a></li>
			<li><a href="#search-more"><span>More...</span></a></li>
			</ul>
			</nav>';
		echo '<div id="search-all">';
		include( 'templates/tab-all.php' );
		echo '</div>';
		echo '<div id="search-books">';
		include( 'templates/tab-books.php' );
		echo '</div>';
		echo '<div id="search-articles">';
		include( 'templates/tab-articles.php' );
		echo '</div>';
		echo '<div id="search-more">';
		include( 'templates/tab-more.php' );
		echo '</div>';
		echo '</div>';

		// Google analytics script (this has to be here so we can pull GA property from server).
		echo "<script type='text/javascript'>
			// Register analytics target
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','discovery');
			discovery('create', '" . esc_attr( $instance['ga_property'] ) . "', 'auto');
			discovery('send', 'pageview');
		</script>";
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
		return $instance;
	}
}
