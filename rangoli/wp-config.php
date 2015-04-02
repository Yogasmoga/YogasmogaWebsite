<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'staging');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'yogasmoga2.ctfwon1h9dxc.us-east-1.rds.amazonaws.com');

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
define('AUTH_KEY',         'Djf$tyuz/ Qzv+IN<4%X%6U+syKO%9Bbv{.k|KDvWyP7}|z)E||bD`I2hEIu,A5P');
define('SECURE_AUTH_KEY',  '(}j3vu d7*_vpENxUG&LF3_p&L-{my}1|dtA+7O(s4sf?:^VdG<jzeP DZT9z`&d');
define('LOGGED_IN_KEY',    'T:Civlr|pwu[H6,gjo[D>8pM-oZE|_C! ,djs:x%>MlebnQ5+*r?O.s%/YjkIZz:');
define('NONCE_KEY',        'R,@-H$Xar+9H8<L=8n?!ic!sZ@-<m&(n:w(;rf#+:,t%P!;;8.wJlK|oq*3,v~`z');
define('AUTH_SALT',        '`%O6MLCJWb-cKgUUZEs|Yc*3}kA8XxibDvs$zy/,S;Eyj+:gmEN+$#%% 4`r*<=p');
define('SECURE_AUTH_SALT', '0-ZHeCn@-;-{MVykF|+M5JM&Jq|nr;Bp4HP:_A3|~#tt)ux)3*wnFHDmi[DX+}mZ');
define('LOGGED_IN_SALT',   'TR7S>|rsk_4/]8rD=V3|z~j|s<+dhZ}&c[iEEX%H[;u$!&T:u?tn8<R;_/to4Jh.');
define('NONCE_SALT',       'O#MhZ}rOJTBgEHL`G$&.rWp%OY-%UssoB@Lq-P3wa|J`f<yY-7azk-x+*+,hcV S');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rangoli_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
