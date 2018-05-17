<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller {
	public function recent_posts() {
		/** Grab the sticky post ID's */
		$sticky      = get_option( 'sticky_posts' );
		$posts_total = 4;

		/** Query the sticky posts */
		$args = array(
			'post__in'       => $sticky,
			'posts_per_page' => $posts_total,
			'ignore_sticky_posts' => 1,
			'post_type'      => 'post'
		);
		$sq   = new \WP_Query( $args );

		/** Count the number of post returned by this query */
		if ( $sq->post_count == $posts_total ) :
			$wp_query = $sq;

			return $wp_query;

		elseif ( $sq->post_count < $posts_total ) :

			$num_posts = $posts_total - $sq->post_count;

			/** Query the non-sticky posts */
			$args = array(
				'post__not_in'   => $sticky,
				'posts_per_page' => $num_posts,
				'post_type'      => 'post'
			);
			$nq   = new \WP_Query( $args );

			//create new empty query and populate it with the other two
			$wp_query        = new \WP_Query();
			$wp_query->posts = array_merge( $sq->posts, $nq->posts );

			//populate post_count count for the loop to work correctly
			$wp_query->post_count = $sq->post_count + $nq->post_count;

			return $wp_query;

		else:

			$args     = array(
				'posts_per_page' => $posts_total,
				'post_type'      => 'post'
			);
			$wp_query = new \WP_Query( $args );

			return $wp_query;

		endif;
	}
}
