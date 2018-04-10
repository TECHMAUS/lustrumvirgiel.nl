<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateLustrumsubevenement extends Controller
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
}
