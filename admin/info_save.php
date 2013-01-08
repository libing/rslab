<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-7-27 13:31:06
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__info';
$action = isset($action) ? $action : '';

if($cfg_curmode != 'small')
{
	$gourl = 'info.php';
}
else
{
	$gourl = 'info_update.php?id='.$classid;	
}


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//修改单页信息
if($action == 'update')
{
	if(!isset($mainid)) $mainid = '-1';

	$row = $dosql->GetOne("SELECT parentid FROM `#@__infoclass` WHERE id=$classid");
	$parentid = $row['parentid'];

	$parentstr = $doaction->GetParentStr();
	$posttime = GetMkTime($posttime);


	//自定义字段处理
	$fieldname  = '';
	$fieldvalue = '';
	$fieldstr   = '';
	$dosql->Execute("SELECT * FROM `#@__diyfield` WHERE infotype=0 AND checkinfo=true ORDER BY orderid ASC");

	while($row = $dosql->GetArray())
	{
		$k = $row['fieldname'];
		$v = isset($_POST[$row['fieldname']]) ? $_POST[$row['fieldname']] : '';

		if(!empty($row['fieldcheck']))
		{
			if(!preg_match($row['fieldcheck'], $v))
			{
				ShowMsg($row['fieldcback']);
				exit();
			}
		}

		if($row['fieldtype'] == 'datetime')
		{
			$v = GetMkTime($v);
		}
		if($row['fieldtype'] == 'fileall' or $row['fieldtype'] == 'checkbox')
		{
			@$v = implode(',',$v);
		}
		$fieldname  .= ", $k";
		$fieldvalue .= ", '$v'";
		$fieldstr   .= ", $k='$v'";
	}


	$row2 = $dosql->GetOne("SELECT id FROM `#@__info` WHERE classid=$classid AND mainid=$mainid");
	if(empty($row2))
	{
		$sql = "INSERT INTO `$tbname` (classid, mainid, content, picurl, posttime {$fieldname}) VALUES ('$classid', '$mainid', '$content', '$picurl', '$posttime' {$fieldvalue})";
	}
	else
	{
		$sql = "UPDATE `$tbname` SET classid='$classid', mainid='$mainid', content='$content', picurl='$picurl', posttime='$posttime' {$fieldstr} WHERE classid=$classid AND mainid=$mainid";
	}

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