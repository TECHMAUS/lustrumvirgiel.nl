<?php

namespace App;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
	public function recent_posts() {
		$args = array(
			'posts_per_page'        => 2,
			'ignore_sticky_posts'   => 1,
		);
		$latest_posts = new \WP_Query($args);
		return $latest_posts;
	}
}
