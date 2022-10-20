<?php

namespace Books;

use Books\Admin\Admin;
use Books\Options\Options;
use Books\Options\Options_Factory;

if( !defined('ABSPATH') ){
	die();
}

/**
 * Class Plugin
 * @package Fratres
 */
class Plugin {
	/**
	 * Holds the plugin instance.
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * @var DB
	 */
	private $db;

	/**
	 * @var Admin\Admin
	 */
	private $admin;

	/**
	 * @var Options
	 */
	private $options;

	/**
	 * Clone.
	 *
	 * Disable class cloning and throw an error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object. Therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'books' ), '2.0' );
	}

	/**
	 * Wakeup.
	 *
	 * Disable unserializing of the class.
	 *
	 * @access public
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'books' ), '2.0' );
	}

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @access public
	 * @static
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();

			/**
			 * Fires when plugin was fully loaded and instantiated.
			 *
			 * @since 1.0.0
			 */
			do_action( 'books_loaded' );
		}

		return self::$instance;
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		// start the autoloader
		$this->register_autoloader();
		//$this->register_admin();

		new Books_Post_Type();
		new Elementor();
	}

	/**
	 * Register the autoloader
	 */
	private function register_autoloader() {
		require namespace\PATH . 'includes/libs/autoload.class.php';
		Autoload::run();
	}

	/**
	 * Register admin area
	 */
	private function register_admin() {
		if( is_admin() ) {
			$this->admin = new Admin( $this );
		}
	}

	/**
	 * @return Admin\Admin
	 */
	public function get_admin() {
		return $this->admin;
	}

	/**
	 * Returns plugin options array
	 *
	 * @return array
	 */
	public function get_options(){
		$options = $this->get_options_obj();
		return $options->get_options();
	}

	/**
	 * Return plugin options
	 *
	 * @return Options
	 */
	private function get_options_obj(){
		if( !$this->options ){
			$this->set_plugin_options();
		}

		return $this->options;
	}

	/**
	 * Set plugin options
	 */
	private function set_plugin_options() {
		$defaults = [

		];

		/**
		 * Options filter
		 *
		 * @param array $defaults Default options array
		 */
		$defaults = apply_filters(
			'books-plugin\options_default',
			$defaults
		);

		$this->options = Options_Factory::get( '_books_plugin_settings', $defaults );
	}
}

Plugin::instance();