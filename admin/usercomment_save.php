<?php	require(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-10-8 17:32:29
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__usercomment';
$gourl  = 'usercomment.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//无条件返回
header("location:$gourl");
exit();
?>