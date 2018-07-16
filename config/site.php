<?php

$root_dir = dirname(__DIR__);
$webroot_dir = $root_dir . '/public_html';

// This will load .env in the root
Dotenv::load($root_dir);
Dotenv::required(array('DB_NAME', 'DB_USER', 'DB_PASSWORD'));

$env = empty(getenv('WP_ENV')) ? 'production' : getenv('WP_ENV');
require_once(__DIR__ . '/env.' . $env . '.php');

define('WP_ENV', $env);
if($env != 'development') {
	// If we are not developing we need a URL
	Dotenv::required(array('WP_HOME'));
}

/* Generate these at https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org */
define('AUTH_KEY', '');
define('SECURE_AUTH_KEY',  '');
define('LOGGED_IN_KEY',    '');
define('NONCE_KEY', '');
define('AUTH_SALT', '');
define('SECURE_AUTH_SALT', '');
define('LOGGED_IN_SALT', '');
define('NONCE_SALT', '');

// Setup the database
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
$table_prefix = getenv('DB_PREFIX') ? getenv('DB_PREFIX') : 'wp_';

// Setup URLs
if(getenv('WP_HOME')) {
	define('WP_HOME', getenv('WP_HOME'));
	define('WP_SITEURL', getenv('WP_SITEURL') ? getenv('WP_SITEURL') : getenv('WP_HOME') . '/wp');
} else {
	$ssl = false;
	if(isset($_SERVER['HTTPS']) && (
		strtolower($_SERVER['HTTPS']) == 'on' ||
		$_SERVER['HTTPS'] == '1'
		)) {
		$ssl = true;
	}

	$port = false;
	if($_SERVER['SERVER_PORT'] == '443') {
		$ssl = true;
	} else if($ssl && $_SERVER['SERVER_PORT'] != '443') {
		$port = true;
	} else if(! $ssl && $_SERVER['SERVER_PORT'] != '80') {
		$port = true;
	}

	define('WP_HOME', ($ssl ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . ($port ? ':' . $_SERVER['SERVER_PORT'] : ''));

	define('WP_SITEURL', WP_HOME . '/wp');

}

// Set the default theme
define('WP_DEFAULT_THEME', 'gg');

// Make sure the wp-content dir points to our site dir
define('WP_CONTENT_DIR', $webroot_dir . '/site');
define('WP_CONTENT_URL', WP_HOME . '/site');

// Disable the automatic updater, this should be done manually
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', true);
define('DISALLOW_FILE_EDIT', true);
