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
define( 'DB_NAME', 'wordpress_base' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'r}c: TVm7VD{zfgygTJ!9Ld)>aH)^H8u[N829{ AhAS~>wM_MY1K t`~%xiZjmCl' );
define( 'SECURE_AUTH_KEY',  'hfcC2HM{;IibD]9xa94)<M= @@U5?nP^!K9beBkgG#TYg_Z0d.pS[a?9}]JDzY,3' );
define( 'LOGGED_IN_KEY',    'zWK< LUYW%uBa*y`*F{LN{xc---m=8BKyZvb}e-(ae^5I}4#sa<`Og@|OuhCy?_j' );
define( 'NONCE_KEY',        '?gqHbh#]}?E C;Sq(jhcg4X(xgpWxqf<4hK72!znk||]E%O{E-Kwem&`_hFzN73s' );
define( 'AUTH_SALT',        '~9l,}|lpPwS9R+j9MdC =+O%0-g_@%B8<J~i=W7;:-:5B}T%LiAipDBS<*W2f!QF' );
define( 'SECURE_AUTH_SALT', 'Kucox7g7@e9VHcSi8I0-quHg<r-SVE<V3WTkAICZ?bOQ/`xiT+uk-jUncv}Rog]@' );
define( 'LOGGED_IN_SALT',   '_f5:*wwnFv&(=&TxPPqw,Seo8m#e(t=x-J&}#NNys@2|o[!g!A4s/u,x@9ykvU(3' );
define( 'NONCE_SALT',       '-^NR gD.|KN-DFwo>jhSb7pV7J^!t%(?pyEs2r)+t$QY*?C?TPmU5=<qv!e)VFtX' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
