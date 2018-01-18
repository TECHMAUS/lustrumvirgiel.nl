<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

/*===================================================================================
* Add global options
* =================================================================================*/

/**
 *
 * The page content surrounding the settings fields. Usually you use this to instruct non-techy people what to do.
 *
 */
function theme_settings_page(){
	?>
	<div class="wrap">
		<h1>Contact Info</h1>
		<p>This information is used around the website, so changing these here will update them across the website.</p>
		<form method="post" action="options.php">
			<?php
			settings_fields("section");
			do_settings_sections("theme-options");
			submit_button();
			?>
		</form>
	</div>

<?php }

/**
 *
 * Next comes the settings fields to display. Use anything from inputs and textareas, to checkboxes multi-selects.
 *
 */

// Facebook
function display_contact_facebook_element(){ ?>

	<input type="url" name="contact_facebook" placeholder="Volledige link naar Facebook" value="<?php echo get_option('contact_facebook'); ?>" size="35">

<?php }

// Instagram
function display_contact_instagram_element(){ ?>

	<input type="url" name="contact_instagram" placeholder="Volledige link naar Instagram" value="<?php echo get_option('contact_instagram'); ?>" size="35">

<?php }

// Vimeo
function display_contact_vimeo_element(){ ?>

	<input type="url" name="contact_vimeo" placeholder="Volledige link naar Vimeo" value="<?php echo get_option('contact_vimeo'); ?>" size="35">

<?php }

// YouTube
function display_contact_youtube_element(){ ?>

	<input type="url" name="contact_youtube" placeholder="Volledige link naar YouTube" value="<?php echo get_option('contact_youtube'); ?>" size="35">

<?php }

/**
 *
 * Here you tell WP what to enqueue into the <form> area. You need:
 *
 * 1. add_settings_section
 * 2. add_settings_field
 * 3. register_setting
 *
 */

function display_custom_info_fields(){

	add_settings_section("section", "Company Information", null, "theme-options");

	add_settings_field("contact_facebook", "Link naar Facebook", "display_contact_facebook_element", "theme-options", "section");
	add_settings_field("contact_instagram", "Link naar Instagram", "display_contact_instagram_element", "theme-options", "section");
	add_settings_field("contact_vimeo", "Link naar Vimeo", "display_contact_vimeo_element", "theme-options", "section");
	add_settings_field("contact_youtube", "Link naar Youtube", "display_contact_youtube_element", "theme-options", "section");

	register_setting("section", "contact_facebook");
	register_setting("section", "contact_instagram");
	register_setting("section", "contact_vimeo");
	register_setting("section", "contact_youtube");


}

add_action("admin_init", "display_custom_info_fields");

/**
 *
 * Tie it all together by adding the settings page to wherever you like. For this example it will appear
 * in Settings > Contact Info
 *
 */

function add_custom_info_menu_item(){

	add_options_page("Contact Info", "Contact Info", "manage_options", "contact-info", "theme_settings_page");

}

add_action("admin_menu", "add_custom_info_menu_item");

add_filter('dynamic_sidebar_params', 'my_dynamic_sidebar_params');

function my_dynamic_sidebar_params( $params ) {

	// get widget vars
	$widget_id = $params[0]['widget_id'];

	// add image to after_widget
	$image = get_field('widget_icon', 'widget_' . $widget_id);

	if( $image ) {

		$params[0]['before_title'] = $params[0]['before_title'] . '<span class="icon lazy" data-src="' . $image . '"></span>';
	}

	// return
	return $params;

}