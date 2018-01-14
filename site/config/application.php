<?php

/** @var string Directory containing all of the site's files */
$root_dir = dirname(__DIR__);

/** @var string Document Root */
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
    $dotenv->load();
    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}

/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
define('WP_ENV', env('WP_ENV') ?: 'production');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

/**
 * URLs
 */
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL'));

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

/**
 * DB settings
 */
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
define('DISALLOW_FILE_EDIT', true);

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}

/**
 * Envira Gallery
 */
define('ENVIRA_LICENSE_KEY', env('ENVIRA_LICENSE_KEY'));

/**
 * WP Offload S3
 */
define( 'DBI_AWS_ACCESS_KEY_ID', env('DBI_AWS_ACCESS_KEY_ID') );
define( 'DBI_AWS_SECRET_ACCESS_KEY', env('DBI_AWS_SECRET_ACCESS_KEY') );
define( 'WPOS3_SETTINGS', serialize( array(
	// S3 bucket to upload files
	'bucket' => 'cdn.lustrumvirgiel.nl',
	// S3 bucket region (e.g. 'us-west-1' - leave blank for default region)
	'region' => 'eu-west-1',
	// Automatically copy files to S3 on upload
	'copy-to-s3' => true,
	// S3 URL format to use ('path', 'cloudfront')
	'domain' => 'cloudfront',
	// Custom domain if 'domain' set to 'cloudfront'
	'cloudfront' => 'cdn.lustrumvirgiel.nl',
	// Enable object prefix, useful if you use your bucket for other files
	'enable-object-prefix' => true,
	// Object prefix to use if 'enable-object-prefix' is 'true'
	'object-prefix' => 'wp-content/uploads/',
	// Organize S3 files into YYYY/MM directories
	'use-yearmonth-folders' => true,
	// Serve files over HTTPS
	'force-https' => true,
	// Remove the local file version once offloaded to S3
	'remove-local-file' => false,
	// Append a timestamped folder to path of files offloaded to S3
	'object-versioning' => true,
) ) );
