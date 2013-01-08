<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-1-12 11:21:14
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__goodstype';
$gourl  = 'goodstype.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加商品分类
if($action == 'add')
{
	if(!isset($attrids)) $attrids = '';

	$parentstr = $doaction->GetParentStr();

	if($attrids != '')
	{
		$attrstr = implode(',', $attrids);
	}
	else
	{
		$attrstr = '-1';
	}
	
	$sql = "INSERT INTO `$tbname` (parentid, parentstr, classname, attrstr, picurl, linkurl, orderid, checkinfo) VALUES ('$parentid', '$parentstr', '$classname', '$attrstr', '$picurl', '$linkurl', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//修改商品分类
else if($action == 'update')
{
	$parentstr = $doaction->GetParentStr();


	//更新所有关联parentstr
	if($parentid != $repid)
	{

		$childtbname = '#@__goods';


		//更新本类parentstr
		$dosql->ExecNoneQuery("UPDATE `$v` SET parentid='".$parentid."', parentstr='".$parentstr."' WHERE classid=".$id);


		//更新下级parentstr
		$doaction->UpParentStr($id, $childtbname, 'parentstr', 'classid');
	}


	//获取商品属性
	if($attrids != '')
	{
		$attrstr = implode(',', $attrids);
	}
	else
	{
		$attrstr = '-1';
	}


	$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', classname='$classname', attrstr='$attrstr', picurl='$picurl', linkurl='$linkurl', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>