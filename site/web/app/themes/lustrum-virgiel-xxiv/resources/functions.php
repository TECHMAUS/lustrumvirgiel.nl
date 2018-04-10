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

function my_acf_init() {

	acf_update_setting('google_api_key', 'AIzaSyD2FwMll8vmbqPOmOyY2eiNswW2-qR4t6s');
}

add_action('acf/init', 'my_acf_init');

if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_5a4bee6f3ac72',
		'title' => 'Home - Action Banner',
		'fields' => array(
			array(
				'key' => 'field_5a4bef530dc6e',
				'label' => 'Actionbanner tekst',
				'name' => 'action_banner_text',
				'type' => 'text',
				'instructions' => 'Tekst die wordt weergegeven op de actionbanner direct onder de heroafbeelding.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4befa20dc6f',
				'label' => 'Actionbanner knop',
				'name' => 'action_banner_button-text',
				'type' => 'text',
				'instructions' => 'Tekst die in de knop van de actionbanner wordt weergegeven.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '25',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4befda0dc70',
				'label' => 'Actionbanner url',
				'name' => 'action_banner_button-url',
				'type' => 'page_link',
				'instructions' => 'De pagina waar de knop heen moet verwijzen.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '25',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
				),
				'taxonomy' => array(
				),
				'allow_null' => 0,
				'allow_archives' => 1,
				'multiple' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page',
					'operator' => '==',
					'value' => '5',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a4bf4e69dcf6',
		'title' => 'Home - Quick Links',
		'fields' => array(
			array(
				'key' => 'field_5a4bf4efe47e8',
				'label' => 'Quick Links Introduction',
				'name' => 'home_quick_links_introduction',
				'type' => 'repeater',
				'instructions' => 'Knoppen die worden weergegeven onder de introductietekst op de homepagina.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Knop toevoegen',
				'sub_fields' => array(
					array(
						'key' => 'field_5a4bf530e47e9',
						'label' => 'Tekst knop',
						'name' => 'button_name',
						'type' => 'text',
						'instructions' => 'Tekst die in de knop wordt weergeven',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a4bf566e47ea',
						'label' => 'Knop link',
						'name' => 'button_link',
						'type' => 'page_link',
						'instructions' => 'Pagina waar de knop heen moet verwijzen.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
						),
						'taxonomy' => array(
						),
						'allow_null' => 0,
						'allow_archives' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_5a4bf596e47eb',
						'label' => 'Knop stijl',
						'name' => 'button_style',
						'type' => 'select',
						'instructions' => 'Voeg eventueel een Lustrumkleur toe aan de knop.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'button-gala' => 'Gala',
							'button-wintersport' => 'Wispo',
							'button-lustrumweek' => 'Lustrumweek',
							'button-piekweek' => 'Piekweek',
						),
						'default_value' => array(
						),
						'allow_null' => 1,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
				),
			),
			array(
				'key' => 'field_5a4dfb17fcff4',
				'label' => 'Quick Links News',
				'name' => 'home_quick_links_news',
				'type' => 'repeater',
				'instructions' => 'Knoppen die worden weergegeven onder de recente nieuwsberichten op de homepagina.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Knop toevoegen',
				'sub_fields' => array(
					array(
						'key' => 'field_5a4dfb17fcff5',
						'label' => 'Tekst knop',
						'name' => 'button_name',
						'type' => 'text',
						'instructions' => 'Tekst die in de knop wordt weergeven',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a4dfb17fcff6',
						'label' => 'Knop link',
						'name' => 'button_link',
						'type' => 'page_link',
						'instructions' => 'Pagina waar de knop heen moet verwijzen.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
						),
						'taxonomy' => array(
						),
						'allow_null' => 0,
						'allow_archives' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_5a4dfb17fcff7',
						'label' => 'Knop stijl',
						'name' => 'button_style',
						'type' => 'select',
						'instructions' => 'Voeg eventueel een Lustrumkleur toe aan de knop.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'button-gala' => 'Gala',
							'button-wintersport' => 'Wispo',
							'button-lustrumweek' => 'Lustrumweek',
							'button-piekweek' => 'Piekweek',
						),
						'default_value' => array(
						),
						'allow_null' => 1,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
				),
			),
			array(
				'key' => 'field_5a4dfb3efcff8',
				'label' => 'Quick Links Media',
				'name' => 'home_quick_links_featured_media',
				'type' => 'repeater',
				'instructions' => 'Knoppen die worden weergegeven onder de uitgelichte media op de homepagina.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Knop toevoegen',
				'sub_fields' => array(
					array(
						'key' => 'field_5a4dfb3efcff9',
						'label' => 'Tekst knop',
						'name' => 'button_name',
						'type' => 'text',
						'instructions' => 'Tekst die in de knop wordt weergeven',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a4dfb3efcffa',
						'label' => 'Knop link',
						'name' => 'button_link',
						'type' => 'page_link',
						'instructions' => 'Pagina waar de knop heen moet verwijzen.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
						),
						'taxonomy' => array(
						),
						'allow_null' => 0,
						'allow_archives' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_5a4dfb3efcffb',
						'label' => 'Knop stijl',
						'name' => 'button_style',
						'type' => 'select',
						'instructions' => 'Voeg eventueel een Lustrumkleur toe aan de knop.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'button-gala' => 'Gala',
							'button-wintersport' => 'Wispo',
							'button-lustrumweek' => 'Lustrumweek',
							'button-piekweek' => 'Piekweek',
						),
						'default_value' => array(
						),
						'allow_null' => 1,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page',
					'operator' => '==',
					'value' => '5',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a4d3ef8cb7ad',
		'title' => 'Home - Titles',
		'fields' => array(
			array(
				'key' => 'field_5a4d3f034e929',
				'label' => 'Laatste Nieuws',
				'name' => 'news_title',
				'type' => 'text',
				'instructions' => 'Titel van \'Laatste nieuws\' sectie.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'Laatste nieuws',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4d3f2a4e92a',
				'label' => 'Uitgelichte Media',
				'name' => 'featured_media_title',
				'type' => 'text',
				'instructions' => 'Titel van \'Uitgelichte media\' sectie.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'Uitgelichte media',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page',
					'operator' => '==',
					'value' => '5',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a4d4d32d836e',
		'title' => 'Home - Uitgelichte Media',
		'fields' => array(
			array(
				'key' => 'field_5a4d4d3d7b0f4',
				'label' => 'Content',
				'name' => 'featured_media_content',
				'type' => 'wysiwyg',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
				'delay' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page',
					'operator' => '==',
					'value' => '5',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a4f66d9114ac',
		'title' => 'Jaaroverzicht - Tijdlijn',
		'fields' => array(
			array(
				'key' => 'field_5a4f6a2d4747c',
				'label' => 'Tijdlijn Header',
				'name' => 'timeline_text_start',
				'type' => 'text',
				'instructions' => 'De tekst die wordt weergegeven aan het begin van de tijdlijn.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'Aspirant Lustrumganger',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4f6a944747d',
				'label' => 'Tijdlijn Footer',
				'name' => 'timeline_text_end',
				'type' => 'text',
				'instructions' => 'De tekst die wordt weergegeven aan het einde van de tijdlijn.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'Tijdreiziger!',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4f687d9828e',
				'label' => 'Evenementen',
				'name' => 'events',
				'type' => 'repeater',
				'instructions' => 'De evenementen om weer te geven in de tijdlijn op de pagina \'Jaaroverzicht\'.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'block',
				'button_label' => 'Evenement toevoegen',
				'sub_fields' => array(
					array(
						'key' => 'field_5a4f68929828f',
						'label' => 'Naam evenement',
						'name' => 'event_title',
						'type' => 'text',
						'instructions' => 'De weer te geven titel van het Evenement',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '40',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a4f68f798290',
						'label' => 'Ondertitel Evenement',
						'name' => 'event_subtitle',
						'type' => 'text',
						'instructions' => 'De ondertitel die wordt weergegeven onder de titel van het evenement.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '60',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a4f692798291',
						'label' => 'Omschrijving evenement',
						'name' => 'event_description',
						'type' => 'text',
						'instructions' => 'De omschrijving over het evenement.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '"',
						'append' => '"',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a4f695598292',
						'label' => 'Link naar evenement',
						'name' => 'event_link',
						'type' => 'page_link',
						'instructions' => 'De pagina waar de knop onder het evenement heen moet verwijzen.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '40',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
						),
						'taxonomy' => array(
						),
						'allow_null' => 0,
						'allow_archives' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_5a4f69b898293',
						'label' => 'Logo evenement',
						'name' => 'event_image',
						'type' => 'image',
						'instructions' => 'Het logo wat wordt weergeven op de tijdlijn bij het evenement.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '30',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_5a4f69eb98294',
						'label' => 'Evenement kleur',
						'name' => 'event_color',
						'type' => 'color_picker',
						'instructions' => 'De kleur die de achtergrond van de titel heeft bij het evenement.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '30',
							'class' => '',
							'id' => '',
						),
						'default_value' => '#000000',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page',
					'operator' => '==',
					'value' => '196',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a4fc30258272',
		'title' => 'Lustrumevenementen',
		'fields' => array(
			array(
				'key' => 'field_5a50b05796ef2',
				'label' => 'Ondertitel',
				'name' => 'event_subtitle',
				'type' => 'text',
				'instructions' => 'Ondertitel die wordt weergegeven bovenaan de pagina. LET Op: de ondertitel op de \'jaaroverzicht\'-pagina staat hier los van!',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a93308f758ce',
				'label' => 'Categorie',
				'name' => 'event_tag',
				'type' => 'taxonomy',
				'instructions' => 'Selecteer de nieuwscategorieën die gekoppeld zijn aan dit event, dit wordt o.a. gebruik bij het weergeven van gerelateerds nieuwsberichten.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'taxonomy' => 'post_tag',
				'field_type' => 'checkbox',
				'allow_null' => 0,
				'add_term' => 1,
				'save_terms' => 0,
				'load_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
			array(
				'key' => 'field_5a4fc309718a6',
				'label' => 'Statdatum',
				'name' => 'quick_facts_date_start',
				'type' => 'date_picker',
				'instructions' => 'Wordt gebruikt om een aftelklok op de pagina weer te geven.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd/m/Y',
				'return_format' => 'm/d/Y',
				'first_day' => 1,
			),
			array(
				'key' => 'field_5acd42c16b5b9',
				'label' => 'Locatie',
				'name' => 'event_location',
				'type' => 'google_map',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'center_lat' => '',
				'center_lng' => '',
				'zoom' => '',
				'height' => '',
			),
			array(
				'key' => 'field_5a4fc8e0f586a',
				'label' => 'Eerste Fact',
				'name' => 'quick_facts_1d',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'Datum',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4fc32b718a7',
				'label' => 'Tweede Fact',
				'name' => 'quick_facts_2d',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'Locatie',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4fc337718a8',
				'label' => 'Derde Fact',
				'name' => 'quick_facts_3d',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'Voor wie?',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5a4fc33f718a9',
				'label' => 'Vierde Fact',
				'name' => 'quick_facts_4d',
				'type' => 'user',
				'instructions' => 'De commissie die verantwoordelijk is voor het evenement.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'role' => '',
				'allow_null' => 1,
				'multiple' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'views/template-lustrumevenement.blade.php',
				),
			),
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'views/template-lustrumsubevenement.blade.php',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a92ddc4cc870',
		'title' => 'Media overzichtspagina',
		'fields' => array(
			array(
				'key' => 'field_5a92de5178e2b',
				'label' => 'Media pagina onderwerpen',
				'name' => 'media_overview_subjects',
				'type' => 'repeater',
				'instructions' => 'Dit zijn de hoofd-onderwerpen die worden weergeven op de media overzichtspagina.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Evenement toevoegen',
				'sub_fields' => array(
					array(
						'key' => 'field_5a92ded678e2c',
						'label' => 'Onderwerp',
						'name' => 'title',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '20',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a92e2af1bf15',
						'label' => 'Items',
						'name' => 'items',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '80',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => '',
						'sub_fields' => array(
							array(
								'key' => 'field_5a92e2f51bf16',
								'label' => 'Item soort',
								'name' => 'item_family',
								'type' => 'radio',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array(
									'embed' => 'embed',
									'pagina' => 'pagina',
								),
								'allow_null' => 0,
								'other_choice' => 0,
								'save_other_choice' => 0,
								'default_value' => '',
								'layout' => 'horizontal',
								'return_format' => 'value',
							),
							array(
								'key' => 'field_5a92e4661bf17',
								'label' => 'Pagina link',
								'name' => 'page_link',
								'type' => 'post_object',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => array(
									array(
										array(
											'field' => 'field_5a92e2f51bf16',
											'operator' => '==',
											'value' => 'pagina',
										),
									),
								),
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'post_type' => array(
									0 => 'page',
								),
								'taxonomy' => array(
								),
								'allow_null' => 0,
								'multiple' => 0,
								'return_format' => 'object',
								'ui' => 1,
							),
							array(
								'key' => 'field_5a92e4971bf18',
								'label' => 'Embed link',
								'name' => 'embed_link',
								'type' => 'oembed',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => array(
									array(
										array(
											'field' => 'field_5a92e2f51bf16',
											'operator' => '==',
											'value' => 'embed',
										),
									),
								),
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'width' => '',
								'height' => '',
							),
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'views/template-media-overview.blade.php',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'the_content',
			1 => 'excerpt',
		),
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a91bf323189d',
		'title' => 'Nieuws filtering',
		'fields' => array(
			array(
				'key' => 'field_5a91cfe540f7b',
				'label' => 'Nieuws filter categoriën',
				'name' => 'news_filter_cats',
				'type' => 'taxonomy',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'taxonomy' => 'category',
				'field_type' => 'checkbox',
				'allow_null' => 0,
				'add_term' => 1,
				'save_terms' => 0,
				'load_terms' => 0,
				'return_format' => 'object',
				'multiple' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page',
					'operator' => '==',
					'value' => '258',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a723354eaab9',
		'title' => 'Posts',
		'fields' => array(
			array(
				'key' => 'field_5a723358eaf9b',
				'label' => 'FB comments',
				'name' => 'disable_fb_comments',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Uit',
				'ui_off_text' => 'Aan',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a4d41008d601',
		'title' => 'Widgets - Icon',
		'fields' => array(
			array(
				'key' => 'field_5a4d410c46ccb',
				'label' => 'Widget Icon',
				'name' => 'widget_icon',
				'type' => 'image',
				'instructions' => 'Icoon dat wordt weergegeven voor de widget titel.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => 48,
				'min_height' => 48,
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'widget',
					'operator' => '==',
					'value' => 'all',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

endif;