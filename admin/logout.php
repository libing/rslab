<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2011-4-19 15:04:15
person: Feng
**************************
*/


$_SESSION = array();
session_destroy();
header('location:login.php');
exit();

?>