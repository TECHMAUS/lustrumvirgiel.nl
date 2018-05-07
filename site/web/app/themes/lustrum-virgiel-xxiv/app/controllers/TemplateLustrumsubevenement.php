<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateLustrumsubevenement extends Controller
{
	public function relatedPosts()
	{
		$tags = get_field('event_tag');
		$tag_ids = array();

		if (!empty ($tags)) :
			foreach($tags as $individual_tag) {
				$tag_ids[] = $individual_tag;
			}

			$args = array(
				'posts_per_page'=> 3, // Number of related posts to display.
				'ignore_sticky'=> 1,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy'  =>  'post_tag',
						'terms'     =>  $tag_ids,
					)
				),
			);

			$the_query = new \WP_Query( $args );
			return $the_query;

		else:

			$the_query = new \WP_Query();
			return $the_query;

		endif;
	}

	public function daysUntilEvent()
	{
		$today = date('Y-m-d');
		$today = strtotime($today);
		$finish = get_field('activity_start_time');
		$finish = strtotime($finish);
		//difference
		$diff = $finish - $today;

		$daysleft=floor($diff/(60*60*24));
		return "$daysleft";
	}

	public function quickFactsDate()
	{
		$start = get_field('activity_start_time');
		$start = strtotime($start);
		$start_date = date('j-m-Y', $start);

		if (!empty(get_field('activity_end_time'))) :

			$end = get_field('activity_end_time');
			$end = strtotime($end);
			$end_date = date('j-m-Y', $end);

		endif;

		if (isset($end)) :

			if ($start_date == $end_date) :
				return date_i18n('D j F Y, G:i', $start) . ' &ndash; ' . date_i18n('G:i \u\u\r', $end);

			else :
				return date_i18n('D j F Y, G:i \u\u\r', $start) . ' &mdash;<br>' . date_i18n('D j F Y, G:i \u\u\r', $end);

			endif;

		else :
			return date_i18n('D j F Y, G:i \u\u\r', $start);

		endif;
	}

	public function eventLocation()
	{
		return get_field('event_location');
	}

	public function featuredVideoTitle()
	{
		return get_field('featured_video_title');
	}

	public function featuredVideoLink()
	{
		return get_field('featured_video_link');
	}

	public static function artistName()
	{
		return get_sub_field('artist_name');
	}

	public static function artistLink()
	{
		return get_sub_field('artist_link');
	}

	public static function parentPageID()
	{
		return wp_get_post_parent_id(get_the_ID());
	}

	public function ticketFact()
	{
		if (get_field('sold_out')) :
			return '<span class="tag is-black is-uppercase has-text-weight-bold">Uitverkocht!</span>';
		else :
			return get_field('quick_facts_3d');
		endif;
	}

	public static function artistImage()
	{
		$image = get_sub_field('artist_image');

		if (!empty($image)) :
			return $image['sizes']['medium'];

		endif;
	}
}
