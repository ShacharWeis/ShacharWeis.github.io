<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;

$env = new Dotenv(dirname(__DIR__));
try {
    $env->load();
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}
if (!function_exists( 'hostURL')) {
    /**
     * Returns the host url including server protocol
     *
     * @return string
     */
    function hostURL()
    {
        return serverProtocol() . $_SERVER['HTTP_HOST'];
    }
}
if (!function_exists('serverProtocol')) {
    /**
     * Returns the http protocol part of the request URL
     *
     * @return string
     */
    function serverProtocol()
    {
        if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            return 'https://';
        }
        if($_SERVER['SERVER_PORT'] === 443) {
            return 'https://';
        }
        return 'http://';
    }
}
if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable with default fallback.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return value($default);
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }
        if (strlen($value) > 1 && stringStartsWith($value, '"') && stringEndsWith($value, '"')) {
            return substr($value, 1, -1);
        }
        return $value;
    }
}
if (!function_exists('stringStartsWith')) {
    /**
     * Return boolean if the haystack has a needle as the first character
     *
     * @param $haystack
     * @param $needles
     * @return bool
     */
    function stringStartsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string)$needle) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('stringEndsWith')) {
    /**
     * Return boolean if the haystack has a needle as the last character
     *
     * @param $haystack
     * @param $needles
     * @return bool
     */
    function stringEndsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string)$needle) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
define('WPENV', env('WPENV', 'production'));

/**
 * Define WP Home and Site URL based on the requesting URL.
 * This allows for easier moving between local, staging, and production
 * environments without having to worry about adjusting the database.
 */
define('WP_HOME', hostURL() . '/blog');
define('WP_SITEURL', hostURL() . '/blog');

/**
 * Authentication Keys and Salts from ENV file. For now this has to be set
 * manually, but an automated system is being worked on.
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
 * Database settings. Collate is set to Wordpress default, and charset is
 * set to best support enhanced unicode.
 */
define('DB_NAME', env('DB_NAME', 'wordpressium'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASSWORD', env('DB_PASSWORD', 'root'));
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

/**
 * Set the database table prefix, defaulting to "yoursite"
 */
$table_prefix = env('DB_PREFIX', 'ys_');

/**
 * Whether or not to allow access to the repair administration view. This
 * should be left to false, unless there is a dire need to repair an error.
 * This is set via the ENV file to avoid having to search for its initial
 * declaration.
 */
define('WP_ALLOW_REPAIR', env('ALLOW_REPAIR', false));

/**
 * Wordpress by default saves everything for all time. The following settings
 * tell Wordpress to handle garbage collection automatically. This limits the
 * number of post revisions saved to 5 and will automatically remove trash items
 * older than 30 days. This also enables the media library trash instead of
 * automatically deleting files, but only saves the most recent revisions of
 * an image to ensure that multiple versions aren't being saved and wasting space.
 */
define('WP_POST_REVISIONS', 5);
define('EMPTY_TRASH_DAYS', 30);
define('MEDIA_TRASH', true);
define('IMAGE_EDIT_OVERWRITE', true);

/**
 * Wordpress leaves a particularly nasty exploit by default which is the editor.
 * This disables the editor while also allowing Wordpress to complete minor
 * security updates and localization updates.
 */
define('DISALLOW_FILE_EDIT', true);
define('WP_AUTO_UPDATE_CORE', 'minor');

/**
 * Wordpress insists on outputting its logging to the public folder which is a
 * security hole in and of itself. This enables the same level of logging, while
 * also disabling Wordpress logging. It also sets up debug display based on the
 * previously defined environment.
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', false);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '../log/wordpress.log');
switch (WPENV) {
    case 'local':
    case 'development':
    case 'dev':
        define('WP_DEBUG_DISPLAY', true);
        break;
    default:
        define('WP_DEBUG_DISPLAY', false);
        break;
}
/**
 * Environment specific non debug settings. There are several things that while
 * are fine in your working environments, should probably be locked down when
 * you are in production, for safety, speed, and user experience. This uses the
 * constant WPENV which is set above and that will default to production when
 * nothing is set. Defaults are not reset, and only things that are modifications
 * are set here.
 *
 * NOTE: DISALLOW_FILE_MODS Is set for production to avoid end users installing
 * anything that could modify the environment and break a production environment.
 */
switch (WPENV) {
    case 'local':
    case 'development':
    case 'dev':
        define('SAVEQUERIES', true);
        define('SCRIPT_DEBUG', true);
        break;
    default:
        break;
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
