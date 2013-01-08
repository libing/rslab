<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2011-5-5 20:06:22
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__infoclass';


//跳转地址
if($cfg_curmode == 'small')
{
	if(!isset($tid))
	{
		//id一般是通过管理页面得到
		if(isset($id)) $tid = $id;
		//parentid一般是通过修改页面得到
		else $tid = $parentid;
		//获取顶部id
		$r = $dosql->GetOne("SELECT parentstr FROM `$tbname` WHERE id=$tid");
		$r2 = explode(',',$r['parentstr']);
		if($r2[1] != '') $tid = $r2[1];
	}
	$gourl = 'infoclass_user.php?tid='.$tid;
}
else
{
	$gourl = 'infoclass.php';
}


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加栏目
if($action == 'add')
{
	$parentstr = $doaction->GetParentStr();
	if(!isset($adminmenu)) $adminmenu = '';
	if(!isset($menulevel)) $menulevel = 0;

	$sql = "INSERT INTO `$tbname` (siteid, parentid, parentstr, infotype, classname, linkurl, picurl, seotitle, keywords, description, orderid, checkinfo, adminmenu, menulevel) VALUES ('$cfg_siteid', '$parentid', '$parentstr', '$infotype', '$classname', '$linkurl', '$picurl', '$seotitle', '$keywords', '$description', '$orderid', '$checkinfo', '$adminmenu', '$menulevel')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改栏目
else if($action == 'update')
{
	$parentstr = $doaction->GetParentStr();
	if(!isset($adminmenu)) $adminmenu = '';
	if(!isset($menulevel)) $menulevel = 0;


	//更新所有关联parentstr
	if($parentid != $repid)
	{

		$childtbname = array('#@__infolist','#@__infoimg','#@__soft');


		//更新本类parentstr
		foreach($childtbname as $k=>$v)
		{
			$dosql->ExecNoneQuery("UPDATE `$v` SET parentid='".$parentid."', parentstr='".$parentstr."' WHERE classid=".$id);
		}


		//更新下级parentstr
		$doaction->UpParentStr($id, $childtbname, 'parentstr', 'classid');
	}


	//来自小后台的提交不允许更改
	//是否为管理菜单与菜单管理级别
	if($cfg_curmode != 'small')
	{
		$sql = "UPDATE `$tbname` SET siteid='$cfg_siteid', parentid='$parentid', parentstr='$parentstr', infotype='$infotype', classname='$classname', linkurl='$linkurl', picurl='$picurl', seotitle='$seotitle', keywords='$keywords', description='$description', orderid='$orderid', checkinfo='$checkinfo', adminmenu='$adminmenu', menulevel='$menulevel' WHERE id=$id";
	}
	else
	{
		$sql = "UPDATE `$tbname` SET siteid='$cfg_siteid', parentid='$parentid', parentstr='$parentstr', infotype='$infotype', classname='$classname', linkurl='$linkurl', picurl='$picurl', seotitle='$seotitle', keywords='$keywords', description='$description', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
	}

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}

	
//删除栏目
else if($action == 'delclass')
{
	//删除栏目的单页信息
	$dosql->ExecNoneQuery("DELETE FROM `#@__info` WHERE classid=$id");
	$dosql->ExecNoneQuery("DELETE FROM `$tbname` WHERE (id=$id Or parentstr LIKE '%,$id,%')");

	header("location:$gourl");
	exit();
}


//删除全选栏目
else if($action == 'delallclass')
{
	//删除栏目的单页信息
	foreach($checkid as $k => $v)
	{
		$dosql->ExecNoneQuery("DELETE FROM `#@__info` WHERE classid=$v");
		$dosql->ExecNoneQuery("DELETE FROM `$tbname` WHERE (id=$v OR parentstr LIKE '%,$v,%')");
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