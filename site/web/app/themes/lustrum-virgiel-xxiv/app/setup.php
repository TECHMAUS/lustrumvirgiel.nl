<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

	if (is_page_template('views/template-lustrumsubevenement.blade.php')) {
		wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyD2FwMll8vmbqPOmOyY2eiNswW2-qR4t6s&callback=initMap', array(), '3', true );
		wp_enqueue_script( 'google-map-init', asset_path('scripts/googlemaps.js'), ['google-map', 'jquery'], '0.3', true );
	}
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');
	add_theme_support('soil-google-analytics', 'UA-105674126-1');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

	/**
	 * Enable the use of a custom logo
	 * @link https://developer.wordpress.org/themes/functionality/custom-logo/
	 */
	add_theme_support( 'custom-logo' );

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 860, 430 );

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
	$config_sidebar = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3><div class="widget-title has-shadow z-depth-1">',
        'after_title'   => '</div></h3>'
    ];
	$config_footer = [
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3><div class="widget-title">',
		'after_title'   => '</div></h3>'
	];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config_sidebar);
	register_sidebar([
        'name'          => __('Lustrum Opening', 'sage'),
        'id'            => 'sidebar-event-opening'
    ] + $config_sidebar);
	register_sidebar([
        'name'          => __('Lustrum Gala', 'sage'),
        'id'            => 'sidebar-event-gala'
    ] + $config_sidebar);
	register_sidebar([
        'name'          => __('Lustrum Wintersport', 'sage'),
        'id'            => 'sidebar-event-wintersport'
    ] + $config_sidebar);
	register_sidebar([
        'name'          => __('Lustrum Lustrumweek', 'sage'),
        'id'            => 'sidebar-event-lustrumweek'
    ] + $config_sidebar);
	register_sidebar([
        'name'          => __('Lustrum Lustrum Productie', 'sage'),
        'id'            => 'sidebar-event-lustrum-productie'
    ] + $config_sidebar);
	register_sidebar([
	    'name'          => __('Lustrum Piekweek', 'sage'),
	    'id'            => 'sidebar-event-piekweek'
	] + $config_sidebar);
    register_sidebar([
        'name'          => __('Footer 1e column', 'sage'),
        'id'            => 'sidebar-footer-1'
    ] + $config_footer);
	register_sidebar([
		'name'          => __('Footer 2e column', 'sage'),
		'id'            => 'sidebar-footer-2'
	] + $config_footer);
	register_sidebar([
		'name'          => __('Footer 3e column', 'sage'),
		'id'            => 'sidebar-footer-3'
	] + $config_footer);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });

	// Community translations can be found at https://github.com/roots/sage-translations
	load_theme_textdomain('sage', get_template_directory() . '/lang');
});

add_action( 'load-themes.php', function (){
	global $pagenow;

	// gets the author role
	$role = get_role( 'author' );

	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){ // Test if theme is activated
		// Theme is activated

		// This only works, because it accesses the class instance.
		// would allow the author to edit others' posts for current theme only
		$role->add_cap( 'edit_pages' );
		$role->add_cap( 'edit_published_pages' );
		$role->remove_cap( 'publish_posts' );
	}
	else {
		// Theme is deactivated
		// Remove the capability when theme is deactivated
		$role->remove_cap( 'edit_pages' );
		$role->remove_cap( 'edit_published_pages' );
		$role->add_cap( 'publish_posts' );
	}
});

$envs = [
	'development' => 'https://lustrumvirgiel.dev',
	'staging'     => 'https://staging.lustrumvirgiel.nl',
	'production'  => 'https://lustrumvirgiel.nl'
];
define('ENVIRONMENTS', serialize($envs));
