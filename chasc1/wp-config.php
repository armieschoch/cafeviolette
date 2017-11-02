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
define('AUTH_KEY',         'x,iffebJ`bb:Y>1!M:Y> t$q1Upc+{c+T6wl)zVn*%{`)mK~5;8kKp|2E+F6q0]G');
define('SECURE_AUTH_KEY',  ',|S?)L BW}SlKauvDLnv+C>1TFV&C^EqVqRu]dIcJwt#9,&(ke4;2#ZEII}`J]lz');
define('LOGGED_IN_KEY',    'zvhGPPLQudzNtyb;^TFUu;k/Udq uM|EN;X~imu4q{N0)eT`zqtilCkxUjqWmL&A');
define('NONCE_KEY',        '$@8a*^}+#%g1>hnf!HtyB1IJY3KX/.Sy^#ChvOnv,!J{O h@U7dOL4*4O~2P9Oje');
define('AUTH_SALT',        'TyxiiIa1NgIlH^>;ta[CRRJx@Vv$wF^[H(K.7H_Bkj+6$46nzc9]a/DgoSXLaUm$');
define('SECURE_AUTH_SALT', '$d;&X`xyk%c_6y(>$Sc!:_#^8-M-aJjpMeL$YI}z`0R6o|Y~nz_NS@= OtIQGSXw');
define('LOGGED_IN_SALT',   '#qj5fUiI=an}IxnwtQfL[=!xksMZ;gD7.#2%09_8cXEhz``2OW<fpv=r22b2}q1V');
define('NONCE_SALT',       'QUCJ95RX?<IrwrBCSUw_[7Fj3QZ{][t`+9_MzXO<5oiaA<:tE2l$t,u+& [`tL|j');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
