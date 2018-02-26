<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Single extends Controller
{
	public function relatedPosts()
	{
		global $post;

		$tags = wp_get_post_terms($post->ID, 'post_tag');
		$tag_ids = array();

		if (!empty ($tags)) :
			foreach($tags as $individual_tag) {
				$tag_ids[] = $individual_tag->term_id;
			}
		endif;

		$categories = wp_get_post_terms($post->ID, 'category');
		$cat_ids = array();

		if (!empty ($categories)) :
			foreach($categories as $individual_category) {
				$cat_ids[] = $individual_category->term_id;
			}
		endif;

		$args = array(
			'post__not_in' => array($post->ID),
			'posts_per_page'=> 3, // Number of related posts to display.
			'ignore_sticky'=> 1,
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy'  =>  'category',
					'terms'     =>  $cat_ids,
				),
				array(
					'taxonomy'  =>  'post_tag',
					'terms'     =>  $tag_ids,
				)
			),
		);

		$the_query = new \WP_Query( $args );

		return $the_query;
	}
}
