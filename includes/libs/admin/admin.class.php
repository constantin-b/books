<?php

namespace Books\Admin;

use Books\Admin\Menu\Menu_Pages;
use Books\Admin\Menu\Settings_Page;
use Books\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Admin
 * @package Fratres\Admin
 */
class Admin {
	/**
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * @var Menu_Pages
	 */
	private $menu_pages;

	/**
	 * Admin constructor.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;

		add_action( 'wp_loaded', [ $this, 'init' ], -20 );
	}

	/**
	 * Initiate admin
	 */
	public function init(){
		$this->register_menu();
	}

	/**
	 * Admin menu callback
	 */
	public function register_menu() {
		$this->menu_pages = new Menu_Pages(
			new Settings_Page(
				$this,
				__( 'SK Plugin', 'books' ),
				__( 'SK Plugin', 'books' ),
				'sk-settings',
				null,
				'manage_options'
			)
		);
	}

	/**
	 * @return Plugin
	 */
	public function get_plugin() {
		return $this->plugin;
	}

	/**
	 * @return Menu_Pages
	 */
	public function get_menu_pages() {
		return $this->menu_pages;
	}
}