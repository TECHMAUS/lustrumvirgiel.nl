<?php

namespace App\Controllers;

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
	    if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {
	        if (is_shop()) {
		        return 'Lustrumshop';
	        }
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

	public static function wps_yoast_breadcrumb_bulma() {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$breadcrumb = yoast_breadcrumb(
				'<nav class="breadcrumb has-succeeds-separator has-text-weight-bold is-uppercase" aria-label="breadcrumbs"><ul class="is-marginless"><li>',
				'</li></ul></nav>',
				false
			);
			echo str_replace( '»', '</li><li>', $breadcrumb );
		} else {
			echo '<ul class="breadcrumb"><li>Missing function "yoast_breadcrumb"</li></ul>';
		}
	}

	public static function authorEmail()
	{
		$email = the_author_meta($field = 'user_email');
		return antispambot( $email );
	}

	public static function pageSlug()
	{
		return get_post_field('post_name');
	}

	public static function published_products() {
		$args = array(
			'post_type'      => 'product'
		);
		$sq   = new \WP_Query( $args );

		if ($sq->post_count > 0 ) {
			return true;
		}
		else {
			return false;
		}
	}
}
