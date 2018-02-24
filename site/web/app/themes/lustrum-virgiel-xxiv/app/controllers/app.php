<?php

namespace App;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function currentUrl() {
	    global $wp;
	    return home_url(add_query_arg(array(),$wp->request));
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

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

	public static function wps_yoast_breadcrumb_bulma() {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$breadcrumb = yoast_breadcrumb(
				'<nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs"><ul class="is-marginless"><li>',
				'</li></ul></nav>',
				false
			);
			echo str_replace( '»', '</li><li>', $breadcrumb );
		} else {
			echo '<ul class="breadcrumb"><li>Missing function "yoast_breadcrumb"</li></ul>';
		}
	}

	public function related_posts()
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
