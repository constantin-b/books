<?php
/*
 * Plugin Name: Books
 * Plugin URI:
 * Description: Book management plugin
 * Author: Constantin Boiangiu
 * Version: 1.0
 * Author URI:
 * Text Domain: books
 * Domain Path: /languages
 */

namespace Books;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( __NAMESPACE__ . '\FILE', __FILE__ );
define( __NAMESPACE__ . '\PATH', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\URL', plugin_dir_url( __FILE__ ) );
define( __NAMESPACE__ . '\VERSION', '1.0' );

define( __NAMESPACE__ . '\WP_VERSION', '5.0' );
define( __NAMESPACE__ . '\PHP_VERSION', '5.6' );

if ( ! version_compare( PHP_VERSION, namespace\PHP_VERSION, '>=' ) ) {
	add_action(
		'admin_notices',
		function (){
			/* translators: %s: PHP version */
			$message = sprintf(
				esc_html__( 'The plugin requires PHP version %s+, plugin is currently NOT RUNNING.', 'books' ),
				namespace\PHP_VERSION
			);
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}
	);
} elseif ( ! version_compare( get_bloginfo( 'version' ), namespace\WP_VERSION, '>=' ) ) {
	add_action(
		'admin_notices',
		function(){
			/* translators: %s: WordPress version */
			$message = sprintf(
				esc_html__( 'The plugin requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'books' ),
				namespace\WP_VERSION
			);
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}
	);
}else{
	require_once namespace\PATH . 'includes/libs/plugin.class.php';
}