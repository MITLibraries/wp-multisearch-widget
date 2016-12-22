<?php
/**
 * Plugin Name: Multisearch Widget
 * Plugin URI: https://github.com/MITLibraries/wp-multisearch-widget
 * Description: This plugin provides a widget that provides searches against multiple targets.
 * Version: 0.1.0
 * Author: Matt Bernhardt
 * Author URI: https://github.com/matt-bernhardt
 * License: GPL2
 *
 * @package Multisearch Widget
 * @author Matt Bernhardt
 * @link https://github.com/MITLibraries/wp-multisearch-widget
 */

/**
 * Multisearch Widget is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Multisearch Widget is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Multisearch Widget. If not, see {URI to Plugin License}.
 */

namespace mitlib;

// Don't call the file directly!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		$instance = null;

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
		wp_register_style( 'multisearch-tabs', plugin_dir_url( __FILE__ ) . 'wp-multisearch-widget.css', array( 'responsivetabs-css' ) );
		wp_enqueue_style( 'multisearch-tabs' );

		// Render markup.
		echo '<noscript><p>It appears that your browser does not support javascript.</p>';
		include( 'templates/form_worldcat.html' );
		echo '</noscript>';
		echo '<div id="multisearch" class="nojs">';
		echo '<ul>
			<li><a href="#search-all"><span>All</span></a></li>
			<li><a href="#search-books"><span>Books + Media</span></a></li>
			<li><a href="#search-articles"><span>Journals + Articles</span></a></li>
			<li><a href="#search-more"><span>More...</span></a></li>
			</ul>';
		echo '<div id="search-all">';
		include( 'templates/tab_all.html' );
		echo '</div>';
		echo '<div id="search-books">';
		include( 'templates/tab_books.html' );
		echo '</div>';
		echo '<div id="search-articles">';
		include( 'templates/tab_articles.html' );
		echo '</div>';
		echo '<div id="search-more">';
		include( 'templates/tab_more.html' );
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Back-end widget form
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$instance = ''; // We can't have an empty method, for Reasons.
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
		$old_instance = ''; // Discard old values.
		return $new_instance;
	}
}

/**
 * Registers base widget.
 */
function register_multisearch_widget() {
	register_widget( 'mitlib\Multisearch_Widget' );
}
add_action( 'widgets_init', 'mitlib\register_multisearch_widget' );
