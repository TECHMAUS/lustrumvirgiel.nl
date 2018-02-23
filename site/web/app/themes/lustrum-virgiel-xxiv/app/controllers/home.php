<?php

namespace App;

use Sober\Controller\Controller;

class Home extends Controller {
	public function recent_posts_blog() {
		$posts_total = 8;

		/** Query the sticky posts */
		$args = array(
			'posts_per_page' => $posts_total,
			'post_type'      => 'post'
		);
		return new \WP_Query( $args );
	}
}
