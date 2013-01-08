<?php	require(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2011-11-8 21:19:21
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__site';
$gourl  = 'site.php';
$action = isset($action) ? $action : '';


//添加新站点
if($action == 'add')
{

	$r = $dosql->GetOne("SELECT `id` FROM `$tbname` WHERE `sitekey`='$site_key'");
	if(isset($r['id']))
	{
		ShowMsg('该站点标识已存在！', '-1');
		exit();
	}

	$sql = "INSERT INTO `$tbname` (`sitename`, `sitekey`) VALUES ('$site_name', '$site_key')";
	if($dosql->ExecNoneQuery($sql))
	{
		$newsiteid = $dosql->GetLastID();
		$data_str = "INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_webname_$site_key','网站名称','0','string','$webname','1');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_weburl_$site_key','网站地址','0','string','$weburl','2');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_webpath_$site_key','网站目录','0','string','$webpath','3');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_author_$site_key','网站作者','0','string','PHPMyWind Team','4');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_generator_$site_key','程序引擎','0','string','PHPMyWind CMS','5');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_keyword_$site_key','关键字设置','0','string','','6');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_description_$site_key','网站描述','0','bstring','','7');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_copyright_$site_key','版权信息','0','bstring','Copyright © 2010 - 2012 phpMyWind.com All Rights Reserved','8');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_icp_$site_key','备案编号','0','string','','9');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_webswitch_$site_key','启用站点','0','bool','Y','10');
		INSERT INTO `#@__webconfig` VALUES('$newsiteid','cfg_switchshow_$site_key','关闭说明','0','bstring','对不起，网站维护，请稍后登陆。<br />网站维护期间对您造成的不便，请谅解！','11');";

		$querys = explode(';', $data_str);
		foreach($querys as $sql)
		{
			if(trim($sql) == '') continue;
			$dosql->ExecNoneQuery($sql);
		}

		echo '<script type="text/javascript">window.top.location.reload();</script>';
		exit();
	}
}


//修改站点
else if($action == 'update')
{
	$r = $dosql->GetOne("SELECT `id` FROM `$tbname` WHERE `sitekey`='$site_key'");
	if(isset($r['id']) && $r['id'] != $id)
	{
		ShowMsg('该站点标识已存在！', '-1');
		exit();
	}

	$sql = "UPDATE `$tbname` SET `sitename`='$site_name', `sitekey`='$site_key' WHERE id=$id";

	if($dosql->ExecNoneQuery($sql))
	{
		echo '<script type="text/javascript">window.top.location.reload();</script>';
		exit();
	}
}


//删除站点
else if($action == 'del')
{
	if($id == 1)
	{
		ShowMsg('抱歉，不能删除默认站点！','-1');
		exit();
	}

	if($dosql->ExecNoneQuery("DELETE FROM `$tbname` WHERE `id`=$id"))
	{

		//设置区分站点的表名
		$tbnames = array('admanage','adtype','diymenu','infoclass',
						 'infoimg','infolist','job','maintype',
						 'message','nav','soft','vote','webconfig',
						 'weblink','weblinktype');
		
		//删除所有该站点信息
		foreach($tbnames as $tbn)
		{
			$dosql->ExecNoneQuery("DELETE FROM `#@__$tbn` WHERE `siteid`=$id");
		}

    	echo '<script type="text/javascript">window.top.location.reload();</script>';
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