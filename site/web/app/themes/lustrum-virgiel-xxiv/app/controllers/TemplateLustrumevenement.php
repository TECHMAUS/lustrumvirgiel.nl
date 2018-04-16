<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateLustrumevenement extends Controller
{
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
		return get_field('event_background_video');
	}

	public static function activityPage()
	{
		return get_sub_field('related_activity_page');
	}

	public static function activityTitle()
	{
		return get_sub_field('activity_title');
	}

	public static function activityImage()
	{
		$image = get_sub_field('activity_image');

		if (!empty($image)) :
			return $image['sizes']['medium'];

		endif;
	}

	public static function activityDate($event_object)
	{
		$start = get_field('activity_start_time', $event_object->ID);
		$end = get_field('activity_end_time', $event_object->ID);

		$start = strtotime($start);
		$start_day = date('j', $start);

		if (!empty($end)) :
			$end = strtotime($end);
			$end_day = date('j', $end);

			if ($start_day != $end_day) :
				return date_i18n('j', $start) . '&ndash;' . date_i18n('j', $end);

			else :
				return date_i18n('d', $start);

			endif;

		else :
			return date_i18n('d', $start);

		endif;
	}

	public static function activityMonth($event_object)
	{
		$start = get_field('activity_start_time', $event_object->ID);
		$start = strtotime($start);

		return date_i18n('M', $start);
	}
}
