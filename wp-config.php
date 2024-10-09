<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'cool-kids-network' );

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
define( 'AUTH_KEY',         '&rrLK//_uD-$Jh,tDf)&=5vBc,B%`ADkc,kSUO&7+_#(i$7AS*8_-8$? cB>l`8`' );
define( 'SECURE_AUTH_KEY',  '_U<f_g$I03`FNL+#H9;YMEwK6Rvb.Gboo/2F&-9yuSp4Y6].` ;}aYhz5|ewJ+jb' );
define( 'LOGGED_IN_KEY',    'wLT-qpsSHG1KN@N+(hmpe@z=.qkz]mG--qjHIK3_pu*,bH?t2@Dt2:C| uZX3L>6' );
define( 'NONCE_KEY',        'mV(>Kz?0Y3]=_Gv)UJ)D>ALc$H(+xf0M0pW,w]JUO_|!?l)ZnUe~-dC8d:pGfY(J' );
define( 'AUTH_SALT',        'Tc+#DcoG;I;+|wR0+_xau/xGH4]:G6n@X I/$SsDs|::17#9 NQQZb)K`8`-N]2?' );
define( 'SECURE_AUTH_SALT', '6M}Da+$pjghSk72CD7i!G}y}J6Y~sedN=3=_8~0W-qyv*&)wHU|00/zyK8kS?#|)' );
define( 'LOGGED_IN_SALT',   '4>WR*Ttc_YLgU+@in5sd%q}2{mgL^l}E5eOeK>ktt#9rnA~6p;`)UYoL]9~*zY/E' );
define( 'NONCE_SALT',       '/}qs_=H5@)@[lFs9h18FeI#Aa4G?uK(I:[g*sR[dP]^zzZr8g(h(;9:m7k,2P`% ' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
