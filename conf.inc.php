<?php
header("Access-Control-Allow-Origin: *");
date_default_timezone_set("Asia/Bangkok");
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WisniorWeb */

// define( 'DB_NAME', 'nisa' );
// define( 'DB_HOST', 'localhost' );
// define( 'DB_USER', 'root' );
// define( 'DB_PASSWORD', 'mySsimanh#3' );
// define( 'TB_PREFIX', '' );
// define( 'ROOT_DOMAIN', 'http://simanh.psu.ac.th/nisa/');

define( 'DB_NAME', 'nisa' );
define( 'DB_USER', 'rmis5' );
define( 'DB_PASSWORD', 'rmis5' );
define( 'DB_HOST', '157.230.46.106' );
define( 'TB_PREFIX', '' );
define( 'ROOT_DOMAIN', 'http://localhost/nisa/' );

// Define system parameters
$sysdate = date('Y-m-d');
$sysdatetime = date('Y-m-d H:i:s');
$sysdateu = date('U');
$sysdateyear = date('Y');
$ip = $_SERVER['REMOTE_ADDR'];

?>
