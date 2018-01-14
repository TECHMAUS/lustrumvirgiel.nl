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

	if (is_single() || is_front_page() || is_page_template('views/template-lustrumevenement.blade.php')) {
		$classes[] = 'has-hero';
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
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
    return '&hellip;';
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
		is_front_page(),
		is_home(),
		is_archive(),
		is_search(),
		is_single(),
		is_page_template('default'),
		// ... more types
	]);

	return $display;
});

add_filter('next_posts_link_attributes', function () {
	return 'class="prev-post button button-piekweek has-text-white is-pulled-right"';
});

add_filter('previous_posts_link_attributes', function () {
	return 'class="next-post button button-piekweek has-text-white is-pulled-left"';
});

add_filter('the_content', function ($content) {
	return preg_replace_callback('~<table.*?</table>~is', function($match) {
		return '<div class="table-overflow">' . $match[0] . '</div>';
	}, $content);
});