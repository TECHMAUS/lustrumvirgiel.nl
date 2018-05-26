<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

	if (is_page_template('views/template-lustrumsubevenement.blade.php')) {
		global $post;
		$parents = get_post_ancestors( $post->ID );

		$id = ($parents) ? $parents[0]: $post->ID;
		/* Get the parent and set the $class with the page slug (post_name) */
		$parent = get_post( $id );
		$classes[] = $parent->post_name;
	}

	if (!is_admin() && is_single() ) {
		global $post;
		foreach((get_the_category($post->ID)) as $category) {
			// add category slug to the $classes array
			$classes[] = 'category-' . $category->category_nicename;
		}
	}

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Filter the except length to 24 words (bravo).
 */
add_filter( 'excerpt_length', function () {
	return 24;
} , 999 );

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Tell WordPress how to find the compiled path of comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );
    return template_path(locate_template(["views/{$comments_template}", $comments_template]) ?: $comments_template);
});

/**
 * Enable the sidebar
 */
add_filter('sage/display_sidebar', function ($display) {
	static $display;

	isset($display) || $display = in_array(true, [
		// The sidebar will be displayed if any of the following return true
		is_search(),
		is_single(),
		is_page() && !is_page_template(array('views/template-lustrumevenement.blade.php', 'views/template-lustrumsubevenement.blade.php')) && !is_front_page(),
		// ... more types
	]);

	return $display;
});

add_filter('next_posts_link_attributes', function () {
	return 'class="prev-post pagination-previous chevron-left"';
});

add_filter('previous_posts_link_attributes', function () {
	return 'class="next-post pagination-next chevron-right"';
});

add_filter('the_content', function ($content) {
	return preg_replace_callback('~<table.*?</table>~is', function($match) {
		return '<div class="table-overflow">' . $match[0] . '</div>';
	}, $content);
});



add_filter( 'woocommerce_breadcrumb_defaults', function () {
	return array(
		'delimiter'   => '',
		'wrap_before' => '<nav class="breadcrumb has-succeeds-separator has-text-weight-bold is-uppercase" aria-label="breadcrumbs"><ul class="is-marginless">',
		'wrap_after'  => '</ul></nav>',
		'before'      => '<li><span>',
		'after'       => '</span></li>',
		'home'        => _x( 'Lustrumshop', 'breadcrumb', 'woocommerce' ),
	);
} );

add_filter('woocommerce_show_page_title', '__return_false');
add_filter( 'wc_product_sku_enabled', '__return_false' );

add_filter( 'woocommerce_product_tabs', function ( $tabs ) {

	unset( $tabs['reviews'] ); 			// Remove the reviews tab
	unset( $tabs['additional_information'] );  	// Remove the additional information tab

	return $tabs;

} );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a href="<?php echo wc_get_cart_url() ?>" class="mdi mdi-cart mdi-24px has-text-white shopping-cart-header" title="Bekijk je winkelwagen"><span class="cart-counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span><?php echo WC()->cart->get_cart_total() ?></a>
	<?php
	$fragments['a.shopping-cart-header'] = ob_get_clean();
	return $fragments;
} );

add_filter( 'woocommerce_breadcrumb_home_url', function () {
	return get_permalink( wc_get_page_id( 'shop' ) );
} );

add_filter( 'woocommerce_enqueue_styles', function ( $enqueue_styles ) {
//	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	return $enqueue_styles;
} );

