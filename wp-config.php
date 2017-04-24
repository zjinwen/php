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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'u364299180_ygaru');

/** MySQL database username */
define('DB_USER', 'u364299180_aqule');

/** MySQL database password */
define('DB_PASSWORD', 'ahaLuXeVyG');

/** MySQL hostname */
define('DB_HOST', 'mysql');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '4EMAu9tMEgfpQqZuk0kTb565Poy9bkECrmQhI3CWCY8oqHgcx81fCieTOOT8QINT');
define('SECURE_AUTH_KEY',  'kwSM1HkXzA3CUERNhLkTrCqx0ieeaFHstV9ABdlObKpxbOC4MNp0WFmdUjul5E5c');
define('LOGGED_IN_KEY',    'EQdbbcEJSQfLEcUGYjrSHDE7V2QfHRpfGS54aXilMuvquZbdkc7VfqKd4xWytsF2');
define('NONCE_KEY',        'JiteWzTc6duKlTGslQ1jpxe7XeK3zzutyoOeDaTHYEO232QWHVczQm2XZDogcaba');
define('AUTH_SALT',        'VUkwGr9I7Nv27o1VT0TJfI8xZPtzb3S24mE1oqe77MIZ2ySuawySxQJHUxGkMvLV');
define('SECURE_AUTH_SALT', 'WjSKwXEoHwUu4GmAJX9Ien5gawjvRRpcg3jppmqqZcgrvqJjlPg8RlaYHu0Z6gX0');
define('LOGGED_IN_SALT',   'm9eEQjWJ1M50GHUDkNElFBmWl8cN9xFJcNcUUmwtMvaG1yl2aDWSr8R57TGWusJx');
define('NONCE_SALT',       'AQDN4zKuwBC7O6EuYhQMgkmWhi8gpKLhVUWyOMgiN7sfiPmb3NlqtXNw1uGZi1KF');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tswk_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
