<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');
	
/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-1-12 13:21:54
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__goodsattr';
$gourl  = 'goodsattr.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//保存商品属性
if($action == 'save')
{
	if($classnameadd != '')
	{
		$dosql->ExecNoneQuery("INSERT INTO `$tbname` (classname, orderid, checkinfo) VALUES ('$classnameadd', '$orderidadd', '$checkinfoadd')");
	}

	if(isset($id))
	{
		$ids = count($id);
		for($i=0; $i<$ids; $i++)
		{
			$dosql->ExecNoneQuery("UPDATE `$tbname` SET orderid='$orderid[$i]', classname='$classname[$i]' WHERE id=$id[$i]");
		}
	}

	header("location:$gourl");
	exit();
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>