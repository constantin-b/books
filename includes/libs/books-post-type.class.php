<?php
/**
 * @author  CodeFlavors
 * @project books
 */

namespace Books;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Books_Post_Type {

	/**
	 * Constructor
	 */
	public function __construct(){
		add_action( 'init', [$this, 'register_post_type'] );
		add_filter( 'post_updated_messages', [$this, 'updated_messages'] );
	}

	/**
	 * Register a custom post type called "book".
	 *
	 * @see get_post_type_labels() for label keys.
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Books', 'Post type general name', 'books' ),
			'singular_name'         => _x( 'Book', 'Post type singular name', 'books' ),
			'menu_name'             => _x( 'Books', 'Admin Menu text', 'books' ),
			'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'books' ),
			'add_new'               => __( 'Add New', 'books' ),
			'add_new_item'          => __( 'Add New Book', 'books' ),
			'new_item'              => __( 'New Book', 'books' ),
			'edit_item'             => __( 'Edit Book', 'books' ),
			'view_item'             => __( 'View Book', 'books' ),
			'all_items'             => __( 'All Books', 'books' ),
			'search_items'          => __( 'Search Books', 'books' ),
			'parent_item_colon'     => __( 'Parent Books:', 'books' ),
			'not_found'             => __( 'No books found.', 'books' ),
			'not_found_in_trash'    => __( 'No books found in Trash.', 'books' ),
			'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'books' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'books' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'books' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'books' ),
			'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'books' ),
			'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'books' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'books' ),
			'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'books' ),
			'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'books' ),
			'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'books' ),
		);

		$args = [
			'menu_icon'          => 'dashicons-book',
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'book' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'show_in_rest'       => true,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'],
		];

		register_post_type( 'book', $args );

		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Genres', 'taxonomy general name', 'books' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'books' ),
			'search_items'      => __( 'Search Genres', 'books' ),
			'all_items'         => __( 'All Genres', 'books' ),
			'parent_item'       => __( 'Parent Genre', 'books' ),
			'parent_item_colon' => __( 'Parent Genre:', 'books' ),
			'edit_item'         => __( 'Edit Genre', 'books' ),
			'update_item'       => __( 'Update Genre', 'books' ),
			'add_new_item'      => __( 'Add New Genre', 'books' ),
			'new_item_name'     => __( 'New Genre Name', 'books' ),
			'menu_name'         => __( 'Genre', 'books' ),
		);

		$args = [
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'genre' ),
			'show_in_rest'       => true,
		];

		register_taxonomy( 'genre', [ 'book' ], $args );

		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = [
			'name'                       => _x( 'Writers', 'taxonomy general name', 'books' ),
			'singular_name'              => _x( 'Writer', 'taxonomy singular name', 'books' ),
			'search_items'               => __( 'Search Writers', 'books' ),
			'popular_items'              => __( 'Popular Writers', 'books' ),
			'all_items'                  => __( 'All Writers', 'books' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Writer', 'books' ),
			'update_item'                => __( 'Update Writer', 'books' ),
			'add_new_item'               => __( 'Add New Writer', 'books' ),
			'new_item_name'              => __( 'New Writer Name', 'books' ),
			'separate_items_with_commas' => __( 'Separate writers with commas', 'books' ),
			'add_or_remove_items'        => __( 'Add or remove writers', 'books' ),
			'choose_from_most_used'      => __( 'Choose from the most used writers', 'books' ),
			'not_found'                  => __( 'No writers found.', 'books' ),
			'menu_name'                  => __( 'Writers', 'books' ),
		];

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'writer' ),
			'show_in_rest'       => true,
		);

		register_taxonomy( 'writer', 'book', $args );


		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = [
			'name'                       => _x( 'Publisher', 'taxonomy general name', 'books' ),
			'singular_name'              => _x( 'Publisher', 'taxonomy singular name', 'books' ),
			'search_items'               => __( 'Search Publishers', 'books' ),
			'popular_items'              => __( 'Popular Publishers', 'books' ),
			'all_items'                  => __( 'All Publishers', 'books' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Publisher', 'books' ),
			'update_item'                => __( 'Update Publisher', 'books' ),
			'add_new_item'               => __( 'Add New Publisher', 'books' ),
			'new_item_name'              => __( 'New Publisher Name', 'books' ),
			'separate_items_with_commas' => __( 'Separate publishers with commas', 'books' ),
			'add_or_remove_items'        => __( 'Add or remove publishers', 'books' ),
			'choose_from_most_used'      => __( 'Choose from the most used publisher', 'books' ),
			'not_found'                  => __( 'No publishers found.', 'books' ),
			'menu_name'                  => __( 'Publishers', 'books' ),
		];

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'publisher' ),
			'show_in_rest'       => true,
		);

		register_taxonomy( 'publisher', 'book', $args );

		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = [
			'name'                       => _x( 'Collection', 'taxonomy general name', 'books' ),
			'singular_name'              => _x( 'Collection', 'taxonomy singular name', 'books' ),
			'search_items'               => __( 'Search Collections', 'books' ),
			'popular_items'              => __( 'Popular Collections', 'books' ),
			'all_items'                  => __( 'All Collections', 'books' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Collection', 'books' ),
			'update_item'                => __( 'Update Collection', 'books' ),
			'add_new_item'               => __( 'Add New Collection', 'books' ),
			'new_item_name'              => __( 'New Collection Name', 'books' ),
			'separate_items_with_commas' => __( 'Separate collections with commas', 'books' ),
			'add_or_remove_items'        => __( 'Add or remove collections', 'books' ),
			'choose_from_most_used'      => __( 'Choose from the most used collection', 'books' ),
			'not_found'                  => __( 'No collections found.', 'books' ),
			'menu_name'                  => __( 'Collections', 'books' ),
		];

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'collection' ),
			'show_in_rest'       => true,
		);

		register_taxonomy( 'collection', 'book', $args );
	}

	public function updated_messages(){
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['book'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Book updated.', 'books' ),
			2  => __( 'Custom field updated.', 'books' ),
			3  => __( 'Custom field deleted.', 'books' ),
			4  => __( 'Book updated.', 'books' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Book restored to revision from %s', 'books' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Book published.', 'books' ),
			7  => __( 'Book saved.', 'books' ),
			8  => __( 'Book submitted.', 'books' ),
			9  => sprintf(
				__( 'Book scheduled for: <strong>%1$s</strong>.', 'books' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', 'books' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Book draft updated.', 'books' ),
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View book', 'books' ) );
			$messages['book'][1] .= $view_link;
			$messages['book'][6] .= $view_link;
			$messages['book'][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link      = sprintf( '<a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview book', 'books' ) );
			$messages[ $post_type ][8] .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}
}