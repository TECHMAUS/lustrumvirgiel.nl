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
}
