<?php
/**
 * @author  CodeFlavors
 * @project books
 */

namespace Books;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Elementor {

	public function __construct(){
		// Showing related posts by current post category in Posts Widget
		add_action(
			'elementor_pro/posts/query/my_custom_filter',
			function( $query ) {



				// Get current post category
				$current_post_id = get_queried_object_id();
				$current_cat = get_the_category( $current_post_id );

				if( empty( $current_cat ) ) {
					return;
				}

				// Modify the query
				$query->set( 'category__in', [ $current_cat[0]->term_id ] );

				// Make sure we don't get current post
				$not_in = $query->get( 'post__not_in' );
				$not_in[] = $current_post_id;

				// Modify the query
				$query->set( 'post__not_in', $not_in );
			}
		);
	}

}