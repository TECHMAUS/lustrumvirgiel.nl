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

	public function eventLocation()
	{
		$location = get_field('event_location');
		return $location;
	}
}
