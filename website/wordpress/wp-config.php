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
define('DB_NAME', 'project');

/** MySQL database username */
define('DB_USER', 'kan');

/** MySQL database password */
define('DB_PASSWORD', '151102');

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
define('AUTH_KEY',         '5qVkx0]+No|c>--yk[.`E0V+Fgyf?!YC@u>ocOH2,!Np6>8&7oN&:p}pcXDH;llG');
define('SECURE_AUTH_KEY',  'u)<eGEQ>Onpc+ZY=J;viryF~jSE~!-q>wBImWrP;C,$;>ETV@}TR6og&n;*VX%K0');
define('LOGGED_IN_KEY',    'u!ueX%7Opf^:zBCf}xtc-+?3M!}9-Un1f{.aq~]UW@NSk[F?wLUg8mE,` pZy1LU');
define('NONCE_KEY',        'wM{5b8z8daBL `jn;(fcL4;qd<^D$:w#~iu2/zJNuQaRNsij[#Jl)ctYN-(y:08)');
define('AUTH_SALT',        '2r(~B.nm1>_/-r+Df8F:X.n04bUT=]4hV~V;S<Fwh#=>pAKt01>)=n8MUMn52@ 4');
define('SECURE_AUTH_SALT', '<;x)Jd8zvy!pK3>@yTLMU$txL?1ZlrB&QbW]hl55)CD3h!*Dkb~+D%KbX{+IP.TU');
define('LOGGED_IN_SALT',   '^/if#T>;px%QhA_xM`HK0!H]l I)RvM;v7XYBm]HwR;vz- e4K1N&t}I%YaA{&RJ');
define('NONCE_SALT',       '@,!5yD=ztK,s2KRZw?Zp}-o$&b+UZZ3i(}71 b^amv&GM/0X,(nBv&$Sv_1syWX{');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
