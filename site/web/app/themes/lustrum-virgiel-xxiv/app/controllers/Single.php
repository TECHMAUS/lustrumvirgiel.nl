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

		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) {
				$tag_ids[] = $individual_tag->term_id;
			}

			$args = array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=>3, // Number of related posts to display.
				'ignore_sticky'=>1
			);

			$the_query = new \WP_Query( $args );

			return $the_query;
		}

		elseif ($categories) {
			$cat_ids = array();
			foreach($categories as $individual_category) {
				$cat       = get_category( $individual_category );
				$cat_ids[] = $cat->term_id;
			}

			$args = array(
				'category__in' => $cat_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=>3, // Number of related posts to display.
				'ignore_sticky'=>1
			);

			$the_query = new \WP_Query( $args );

			return $the_query;
		}

		else {
			$the_query = new \WP_Query();
			return $the_query;
		}
	}
}
