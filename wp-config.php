<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ';pE #qk?27!xXN?rAGgMN`Yxv; R{9g9vuEzyYhU5DkY;0yNQW}-efk q!mu^`op' );
define( 'SECURE_AUTH_KEY',  '6 2H%5qcSAVV%hQ^Ic(Ofc<CVa+_FC97tj|-h85sj(B|[|N7T*,+(~p3=|fbH)(!' );
define( 'LOGGED_IN_KEY',    'cDK:67j*Jx0Arzj(5O&.r&|<QlBf`.ZS$sSxtm?X3HhAqr`,g&MYWSY!{eQjb?v ' );
define( 'NONCE_KEY',        'jfSvak@u?EMhtVRon?4)>lJ-bRO7[wLQ7}IO1ksal`Z+?kE5LZW:yX-Am5xhB$:%' );
define( 'AUTH_SALT',        'xerN$tjnzb!.kUYJt3eA1Y}cB)p^_NOzZnP!rz(?nD]wOvxIkLY#]L(5_q./1/KN' );
define( 'SECURE_AUTH_SALT', 'GC[2!gaz2*+mpnaZOt >Fho$[$+tg&w/zT5=a%<]&?zP@:/x#N_#6Vl^!up@[^*m' );
define( 'LOGGED_IN_SALT',   '`bMRvP5,X`u;CX.w*FD+8L)`f5|V%4gm[2<Dq>u7sjY)pD:}@o.*QTC0{yjY72mk' );
define( 'NONCE_SALT',       'R+K`X||:PMqKh.r*b?G%lJ>$|3zPODhLACm(nnP=!]=Z64$<9=pF/=b%)DWTGZ81' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';