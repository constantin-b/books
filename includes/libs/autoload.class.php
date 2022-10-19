<?php
namespace Books;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Autoloader.
 *
 * @since 2.0
 */
class Autoload {

	/**
	 * Classes map.
	 *
	 * Maps classes to file names.
	 *
	 * @since 1.6.0
	 * @access private
	 * @static
	 *
	 * @var array Classes used.
	 */
	private static $classes_map;

	/**
	 * Run autoloader.
	 *
	 * Register a function as `__autoload()` implementation.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 */
	public static function run() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	/**
	 * @return array
	 */
	public static function get_classes_map() {
		if ( ! self::$classes_map ) {
			self::init_classes_map();
		}

		return self::$classes_map;
	}

	private static function init_classes_map() {
		self::$classes_map = [
		];
	}

	/**
	 * Load class.
	 *
	 * For a given class name, require the class file.
	 *
	 * @since 1.6.0
	 * @access private
	 * @static
	 *
	 * @param string $relative_class_name Class name.
	 */
	private static function load_class( $relative_class_name ) {
		$classes_map = self::get_classes_map();

		if ( isset( $classes_map[ $relative_class_name ] ) ) {
			$filename = namespace\PATH . $classes_map[ $relative_class_name ];
		}else{
			$file = str_replace( '\\', DIRECTORY_SEPARATOR, str_replace( '_', '-', strtolower( $relative_class_name ) ) ) . '.class.php';
			$filename = namespace\PATH . 'includes/libs/' . $file;
		}

		if ( is_readable( $filename ) ) {
			require_once $filename;
		}
	}

	/**
	 * Autoload.
	 *
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.6.0
	 * @access private
	 * @static
	 *
	 * @param string $class Class name.
	 */
	private static function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ . '\\' ) ) {
			return;
		}

		$relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );
		$final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;

		if ( ! class_exists( $final_class_name ) ) {
			self::load_class( $relative_class_name );
		}
	}
}
