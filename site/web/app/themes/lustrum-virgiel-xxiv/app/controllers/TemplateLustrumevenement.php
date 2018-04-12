<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateLustrumevenement extends Controller
{
	public static function days_until() {
		$today = date('m/d/Y');
		$today = strtotime($today);
		$finish = get_field('quick_facts_date_start');
		$finish = strtotime($finish);
		//difference
		$diff = $finish - $today;

		$daysleft=floor($diff/(60*60*24));
		return "$daysleft";
	}

	public function relatedPosts()
	{
		global $post;
		$categories = get_field('event_category');

		if ($categories) {
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

	public function eventVideo()
	{
		$bg_video = get_field('event_background_video');
		return $bg_video;
	}
}
