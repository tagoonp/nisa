<?php
header("Access-Control-Allow-Origin: *");
date_default_timezone_set("Asia/Bangkok");
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WisniorWeb */

// define( 'DB_NAME', 'rmis5' );
// define( 'DB_USER', 'root' );
// define( 'DB_PASSWORD', 'mandymorenn' );
// define( 'DB_HOST', 'localhost' );
// define( 'TB_PREFIX', '' );
// define( 'ROOT_DOMAIN', 'http://localhost/rmis5/' );

define( 'DB_NAME', 'nisa' );
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'rmis5' );
define( 'DB_PASSWORD', 'rmis5' );
define( 'TB_PREFIX', '' );
define( 'ROOT_DOMAIN', 'https://fxplor.com/nisa/');

// define( 'DB_NAME', 'nisa' );
// define( 'DB_USER', 'rmis5' );
// define( 'DB_PASSWORD', 'rmis5' );
// define( 'DB_HOST', '157.230.46.106' );
// define( 'TB_PREFIX', '' );
// define( 'ROOT_DOMAIN', 'http://localhost/rmis5/' );

// Define system parameters
$sysdate = date('Y-m-d');
$sysdatetime = date('Y-m-d H:i:s');
$sysdateu = date('U');
$sysdateyear = date('Y');
$ip = $_SERVER['REMOTE_ADDR'];

?>
