<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-8-28 13:45:46
person: Feng
**************************
*/


//初始化变量
$b_url = 'templates/html/default.html';
$s_url = 'templates/html/default_user.html';


/*
 * 浏览状态，$_SESSION['adminlevel']
 *
 * 0 超级管理员 1 普通管理员 2 文章管理员 
 * 10 包含所有身份(切换身份的虚拟值)
*/

if($_SESSION['adminlevel'] == 0 or
   $_SESSION['adminlevel'] == 10)
{
	if(isset($c) && $c=='preview')
	{
		require_once($s_url);
		$_SESSION['adminlevel'] = 10;
	}
	else
	{
		require_once($b_url);
		$_SESSION['adminlevel'] = 0;
	}
}

else
{
	require_once($s_url);
}
?>