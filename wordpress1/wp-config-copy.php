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
define('DB_NAME', 'chasc_db456');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'BfXAaI386IaL }@?6`KOY~v(W*U~Votqiz)<`GoVudGy[ioU%}H2|$mfo:hQf:l1');
define('SECURE_AUTH_KEY',  'wJ+s3GaudLM3kB{7>e1cq=3[O4;Q,l~2gq17p8^6v!@ZZ^[?>fRp#e__!{z>HP~r');
define('LOGGED_IN_KEY',    '9?hmbz)<ZXI4dW$xbY7@6@ }098%L.:lC`tV(^xL-j>`JEFObn:^!klFWH>-<<#b');
define('NONCE_KEY',        'y)?E$;cR^s*x(L;qXSP9m9M13y(Hkx_eEB{u~,d+&HJj[zKNqC3#/q5},${$.1;B');
define('AUTH_SALT',        'Wi0kig|q@9zrc])QdXDxW97D9@:Al!=E{Y.y75IZBOm$]2J[5vg5v@x+)j0$~[`c');
define('SECURE_AUTH_SALT', 'GZL~8irXHB]{j-X_%u26n4z *w}z4MRbwfYi=_Leaf2I=|yR4,tgT0t|3kv|qUv;');
define('LOGGED_IN_SALT',   '#!gvO<p32n-vumGj# W5 ROkfKd1sgR3X,hD,tnPoQNPDuaTxD@$NR9{KM,(F_b$');
define('NONCE_SALT',       'qJOlx|hms#d 7Rq*-[bqf~VGn8 >T?.O|ZwS+a@5w}j:-nUur;jcXLBz3XZ63K%h');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_159chasc_';

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
