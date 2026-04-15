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
define( 'DB_NAME', '1504' );

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
define( 'AUTH_KEY',         'Ensnf<SC_2DvgKYmH/A[zrs Y#P`E@!i?|~HCN`1.8{$5J=8}FN+()$RF11P=pJ@' );
define( 'SECURE_AUTH_KEY',  'ZfaORE5:u4CKz!$3( ^w;z9C],vCjubdDLw[7Q7QN$p9(Lv%!m&~NQ}YFna[yKM|' );
define( 'LOGGED_IN_KEY',    ')i&_ynWLNW6L=-*PaS!6F[l<tP|Kogkq6(_u> t:-OzKY=hIc_(R:r1#z^8WnomD' );
define( 'NONCE_KEY',        '<5tnv4@[]P6Y:_u+E{u5E_61/mitcF!3Ty7q9&J@7NNP2v]-eL)csH p+F:cZi*[' );
define( 'AUTH_SALT',        'vA.|E1(KTz4{)S7OULXi7s;=N.sa-;tw^p9g@3QG!vHR?e/lH;mQFh&rc+23 wfX' );
define( 'SECURE_AUTH_SALT', ':H.>5FwE4OF3TKArCj?Odiz2!d.y|V$|ZnMi6s:h&^b=*]p2ujF2%506/LHf3374' );
define( 'LOGGED_IN_SALT',   'Ds-a7)lN<XC#4Y3?AFX/Ue0[0932oC*z-19Ku`]Ds]:)xz=~|W9F%FmkA-Nkdmuq' );
define( 'NONCE_SALT',       'nxN3dI8lClU(pHUEFd*q/6b=Yp1n_Fe|_4piR0*2-pG_;>V8^^N!rU7e}!A4^6,j' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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

/* Multisite Configuration */
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'localhost' );
define( 'PATH_CURRENT_SITE', '/15-04/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
