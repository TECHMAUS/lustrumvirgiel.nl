<?php

namespace App;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
	public function recent_posts() {
		$sq = null;
		$nq = null;

		/** Grab the sticky post ID's */
		$sticky = get_option('sticky_posts');

		/** Query the sticky posts */
		$args = array(
			'post__in'          => $sticky,
			'posts_per_page'    => 2,
			'post_type'         => 'post'
		);
		$sq = new \WP_Query($args);

		/** Count the number of post returned by this query */
		$sq_count = $sq->post_count;


		/** Check to see if any non-sticky posts need to be output */
		if($sq_count < 2) :

			$num_posts = 2 - $sq_count;

			/** Query the non-sticky posts */
			$sticky = get_option('sticky_posts');
			$args = array(
				'post__not_in'      => $sticky,
				'posts_per_page'    => $num_posts,
				'post_type'         => 'post'
			);
			$nq = new \WP_Query($args);


		endif;

		//create new empty query and populate it with the other two
		$wp_query = new \WP_Query();
		$wp_query->posts = array_merge( $sq->posts, $nq->posts );

		//populate post_count count for the loop to work correctly
		$wp_query->post_count = $sq->post_count + $nq->post_count;

		return $wp_query;
	}
}
