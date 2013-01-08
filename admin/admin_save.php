<?php	require(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-7-2 17:29:21
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__admin';
$gourl  = 'admin.php';
$action = isset($action) ? $action : '';


//添加管理员
if($action == 'add')
{
	if(preg_match("/[^0-9a-zA-Z_@!\.-]/",$username) || preg_match("/[^0-9a-zA-Z_@!\.-]/",$password))
	{
		ShowMsg('用户名或密码非法！请使用[0-9a-zA-Z_@!.-]内的字符！', '-1');
		exit();
	}
	
	if($dosql->GetOne("SELECT id FROM `$tbname` WHERE username='$username'"))
	{
		ShowMsg('用户名已存在！', '-1');
		exit();
	}

	$password  = md5(md5($password));
	$loginip   = '127.0.0.1';
	$logintime = time();

	$sql = "INSERT INTO `$tbname` (username, password, loginip, logintime, levelname, checkadmin) VALUES ('$username', '$password', '$loginip', '$logintime', '$levelname', '$checkadmin')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改管理员
else if($action == 'update')
{
	if($id == 1 and $checkadmin != 'true')
	{
		ShowMsg('抱歉，不能更改创始账号状态！','-1');
		exit();
	}

	if($password == '')
	{
		$sql = "UPDATE `$tbname` SET levelname='$levelname', checkadmin='$checkadmin' WHERE id=$id";
	}
	else
	{
		$oldpwd   = md5(md5($oldpwd));
		$password = md5(md5($password));

		$r = $dosql->GetOne("SELECT `password` FROM `#@__admin` WHERE id=$id");
		if($r['password'] != $oldpwd)
		{
			ShowMsg('抱歉，旧密码错误！','-1');
			exit();
		}
		
		$sql = "UPDATE `$tbname` SET password='$password', levelname='$levelname', checkadmin='$checkadmin' WHERE id=$id";
	}

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改管理员审核状态
else if($action == 'check')
{
	if($id == 1)
	{
		ShowMsg('抱歉，不能更改创始账号状态！','-1');
		exit();
	}

	if($checkadmin == 'true')
	{
		$sql = "UPDATE `$tbname` SET checkadmin='false' WHERE id=$id";
	}
	if($checkadmin == 'false')
	{
		$sql = "UPDATE `$tbname` SET checkadmin='true' WHERE id=$id";	
	}

	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//删除管理员
else if($action == 'del')
{
	if($id == 1)
	{
		ShowMsg('抱歉，不能删除创始账号！','-1');
		exit();
	}

	if($dosql->ExecNoneQuery("DELETE FROM `$tbname` WHERE id=$id"))
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