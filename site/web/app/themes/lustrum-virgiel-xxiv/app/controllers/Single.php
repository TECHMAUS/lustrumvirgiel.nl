<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Single extends Controller
{
	public function relatedPosts()
	{
		global $post;
		$tags = wp_get_post_tags($post->ID);
		$categories = wp_get_post_categories($post->ID);
		$post_total = 3;

		if ( !empty($tags) ) {
			$tag_ids = array();
			foreach($tags as $individual_tag) {
				$tag_ids[] = $individual_tag->term_id;
			}

			$args = array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=> $post_total, // Number of related posts to display.
				'ignore_sticky'=> 1
			);

			$tag_query = new \WP_Query( $args );

			if ($tag_query->post_count <= $post_total ) :

				$num_posts = $post_total - $tag_query->post_count;
				$cat_ids = array();

				foreach($categories as $individual_category) {
					$cat       = get_category( $individual_category );
					$cat_ids[] = $cat->term_id;
				}

				$args = array(
					'category__in' => $cat_ids,
					'post__not_in' => array($post->ID),
					'posts_per_page'=> $post_total, // Number of related posts to display.
					'ignore_sticky'=> 1
				);

				$cat_query = new \WP_Query( $args );

				//create new empty query and populate it with the other two
				$wp_query        = new \WP_Query();
				$wp_query->posts = array_merge( $tag_query->posts, $cat_query->posts );

				//populate post_count count for the loop to work correctly
				$wp_query->post_count = $tag_query->post_count + $cat_query->post_count;

				return $wp_query;

			else :

				return $tag_query;

			endif;
		}

		elseif ( !empty($categories) ) {
			$cat_ids = array();
			foreach($categories as $individual_category) {
				$cat       = get_category( $individual_category );
				$cat_ids[] = $cat->term_id;
			}

			$args = array(
				'category__in' => $cat_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=> $post_total, // Number of related posts to display.
				'ignore_sticky'=> 1
			);

			$cat_query = new \WP_Query( $args );

			return $cat_query;
		}

		else {
			$the_query = new \WP_Query();
			return $the_query;
		}
	}
}
