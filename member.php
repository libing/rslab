<?php	require_once(dirname(__FILE__).'/include/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-9-27 15:40:34
person: Feng
**************************
*/


//检测是否启用会员
if($cfg_member == 'N')
{
	ShowMsg('抱歉，本站没有启用会员功能！','-1');
	exit();
}


//初始化参数
$c = isset($c) ? $c : 'login';
$a = isset($a) ? $a : '';
$d = isset($d) ? $d : '';
if(!empty($_COOKIE['username']) &&
   !empty($_COOKIE['lastlogintime']) &&
   !empty($_COOKIE['lastloginip']))
{
	$c_uname     = AuthCode($_COOKIE['username']);
	$c_logintime = AuthCode($_COOKIE['lastlogintime']);
	$c_loginip   = AuthCode($_COOKIE['lastloginip']);
}
else
{
	$c_uname     = '';
	$c_logintime = '';
	$c_loginip   = '';
}


//验证是否登录和用户合法
if($a=='saveedit' or $a=='getarea' or $a=='savefavorite' or
   $a=='delfavorite' or $a=='delcomment' or $a=='avatar')
{
	if(!empty($c_uname))
	{
		$r = $dosql->GetOne("SELECT `id`,`expval` FROM `#@__member` WHERE `username`='$c_uname'");
		if(!is_array($r))
		{
			setcookie('username',      '', time()-3600);
			setcookie('lastlogintime', '', time()-3600);
			setcookie('lastloginip',   '', time()-3600);
			ShowMsg('该用户已不存在！','?c=login');
			exit();
		}
		else if($r['expval'] <= 0)
		{
			ShowMsg('抱歉，您的账号被禁止登陆！','?c=login');
			exit();
		}
	}
	else
	{
		header('location:?c=login');
		exit();
	}
}


//登录账户
if($a == 'login')
{

	//初始化参数
	$username = empty($username) ? '' : $username;
	$password = empty($password) ? '' : md5(md5($password));
	$validate = empty($validate) ? '' : strtolower($validate);


	//验证输入数据
	if($username == '' or
	   $password == '' or
	   $validate == '')
	{
		header('location:?c=login');
		exit();
	}
	
	
	//删除已过时记录
	$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE (UNIX_TIMESTAMP(NOW())-time)/60>15");


	//判断是否被暂时禁止登录
	$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE username='$username'");
	if(is_array($r))
	{
		$min = round((time()-$r['time']))/60;
		if($r['num']==0 and $min<=15)
		{
			ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','?c=login');
			exit();
		}
	}


	//检测数据正确性
	if($validate != strtolower(GetCkVdValue()))
	{
		ResetVdValue();
		ShowMsg('验证码不正确！','?c=login');
		exit();
	}
	else
	{

		$row = $dosql->GetOne("SELECT `id`,`password`,`logintime`,`loginip`,`expval` FROM `#@__member` WHERE `username`='$username'");


		//密码错误
		if(!is_array($row) or $password!=$row['password'])
		{
			$logintime = time();
			$loginip   = GetIP();

			$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE `username`='$username'");
			if(is_array($r))
			{
				$num = $r['num']-1;

				if($num == 0)
				{
					$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET `time`=$logintime, `num`=$num WHERE `username`='$username'");
					ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','?c=login');
					exit();
				}
				else if($r['num']<=5 and $r['num']>0)
				{
					$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET `time`=$logintime, `num`=$num WHERE `username`='$username'");
					ShowMsg('用户名或密码不正确！您还有'.$num.'次尝试的机会！','?c=login');
					exit();
				}
			}
			else
			{
				$dosql->ExecNoneQuery("INSERT INTO `#@__failedlogin` (username, ip, time, num, isadmin) VALUES ('$username', '$loginip', '$logintime', 5, 0)");
				ShowMsg('用户名或密码不正确！您还有5次尝试的机会！','?c=login');
				exit();
			}
		}


		//密码正确，查看是否被禁止登录
		else if($row['expval'] <= 0)
		{
			ShowMsg('抱歉，您的账号被禁止登陆！','?c=login');
			exit();
		}


		//用户名密码正确
		else
		{

			$logintime = time();
			$loginip = GetIP();
			
			
			//删除禁止登录
			if(is_array($r))
			{
				$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE `username`='$username'");
			}


			//是否自动登录
			if(isset($autologin))
				$cookie_time = time()+14*24*60*60;
			else
				$cookie_time = time()+3600;

			setcookie('username',      AuthCode($username        ,'ENCODE'), $cookie_time);
			setcookie('lastlogintime', AuthCode($row['logintime'],'ENCODE'), $cookie_time);
			setcookie('lastloginip',   AuthCode($row['loginip']  ,'ENCODE'), $cookie_time);


			//每天登陆增加10点经验
			if(MyDate('d',time()) != MyDate('d',$row['logintime']))
			{
				$dosql->ExecNoneQuery("UPDATE `#@__member` SET `expval`='".($row['expval'] + 10)."' WHERE `username`='$username'");
			}
			
			$dosql->ExecNoneQuery("UPDATE `#@__member` SET `loginip`='$loginip',`logintime`='$logintime' WHERE `id`=".$row['id']);
			header('location:?c=default');
			exit();
		}
	}
}


//注册账户
else if($a == 'reg')
{
	
	//初始化参数
	$username   = empty($username)   ? '' : $username;
	$password   = empty($password)   ? '' : md5(md5($password));
	$repassword = empty($repassword) ? '' : md5(md5($repassword));
	$email      = empty($email)      ? '' : $email;
	$validate   = empty($validate)   ? '' : strtolower($validate);


	//验证输入数据
	if($username   == '' or
	   $password   == '' or
	   $repassword == '' or
	   $email      == '' or
	   $validate   == '')
	{
		header('location:?c=reg');
		exit();
	}


	//验证数据准确性
	if($validate != strtolower(GetCkVdValue()))
	{
		ResetVdValue();
		ShowMsg('验证码不正确！','?c=reg');
		exit();
	}

	if($password != $repassword)
	{
		header('location:?c=reg');
		exit();
	}

    $uname_len = strlen($username);
	$upwd_len  = strlen($_POST['password']);
	if($uname_len<6 or $uname_len>16 or $upwd_len<6 or $upwd_len>16)
	{
		header('location:?c=reg');
		exit();
	}

	if(preg_match("/[^0-9a-zA-Z_@!\.-]/",$username) or
	   preg_match("/[^0-9a-zA-Z_-]/",$password) or
	   !preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/", $email))
	{
		header('location:member.php?c=reg');
		exit();
	}

	$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `username`='$username'");
	if(isset($r['id']))
	{
		ShowMsg('用户名已存在！','?c=reg');
		exit();
	}

	$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `email`='$email'");
	if(isset($r['id']))
	{
		ShowMsg('您填写的邮箱已被注册！','?c=reg');
		exit();
	}


	//添加用户数据
	$regtime  = time();
	$regip    = GetIP();

	$sql = "INSERT INTO `#@__member` (username, password, email, expval, regtime, regip, logintime, loginip) VALUES ('$username', '$password', '$email', '10', '$regtime', '$regip', '$regtime', '$regip')";	
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:?c=login&d=".md5('reg'));
		exit();
	}
}


//退出账户
else if($a == 'logout')
{
	setcookie('username',      '', time()-3600);
	setcookie('lastlogintime', '', time()-3600);
	setcookie('lastloginip',   '', time()-3600);
	header('location:?c=login');
	exit();
}


//找回密码
else if($a == 'findpwd2')
{
	if(!isset($_POST['username']))
	{
		header('location:?c=findpwd');
		exit();
	}


	//检测验证码
	$validate = empty($validate) ? '' : strtolower($validate);
	if($validate == '' || $validate != strtolower(GetCkVdValue()))
	{
		ResetVdValue();
		ShowMsg('验证码不正确！','?c=findpwd');
		exit();
	}
	else
	{
		$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `username`='$username'");
		if(!isset($r['id']))
		{
			ShowMsg('请输入正确的账号信息！','?c=findpwd');
			exit();
		}
	}
}


//找回密码
else if($a == 'quesfind')
{
	if(!isset($_POST['uname']))
	{
		header('location:?c=findpwd');
		exit();
	}


	//验证输入数据
	if($question == '-1' or
	   $answer == '')
	{
		header('location:?c=findpwd');
		exit();
	}


	$r = $dosql->GetOne("SELECT `question`,`answer` FROM `#@__member` WHERE `username`='$uname'");
	if($r['question']==0 or !isset($r['answer']))
	{
		ShowMsg('此账号未填写验证问题，请选择其他方式找回！','?c=findpwd');
		exit();
	}
	else
	{
		if($question != $r['question'] or $answer != $r['answer'])
		{
			ShowMsg('您填写的验证问题或答案不符！','?c=findpwd');
			exit();
		}
	}
}


//设置新密码
else if($a == 'setnewpwd')
{
	if(!isset($_POST['uname']))
	{
		header('location:?c=findpwd');
		exit();
	}


	//初始化参数
	$uname      = empty($uname)      ? '' : $uname;
	$password   = empty($password)   ? '' : md5(md5($password));
	$repassword = empty($repassword) ? '' : md5(md5($repassword));


	//验证输入数据
	if($uname == '' or
	   $password == '' or
	   $repassword == '' or
	   $password != $repassword or
	   preg_match("/[^0-9a-zA-Z_-]/",$password))
	{
		header('location:?c=findpwd');
		exit();
	}


	if($dosql->ExecNoneQuery("UPDATE `#@__member` SET password='$password' WHERE username='$uname'"))
	{
		header("location:?c=login&d=".md5('newpwd'));
		exit();
	}
}


//找回密码
else if($a == 'mailfind')
{
	if(!isset($_POST['uname']))
	{
		header('location:?c=findpwd');
		exit();
	}


	//验证输入数据
	if($email == '')
	{
		header('location:?c=findpwd');
		exit();
	}


	$r = $dosql->GetOne("SELECT `email` FROM `#@__member` WHERE `username`='$uname'");
	if($r['email'] == $email)
	{
		
	}
	else
	{
		ShowMsg('您填写的邮箱不符！','?c=findpwd');
		exit();
	}
}


//更新资料
else if($a == 'saveedit')
{
	if($password!=$repassword or
	   $email=='')
	{
		header('location:?c=edit');
		exit();
	}


	//检测旧密码是否正确
	if($password != '')
	{
		$oldpassword = md5(md5($oldpassword));
		$r = $dosql->GetOne("SELECT `password` FROM `#@__member` WHERE `username`='$c_uname'");
		if($r['password'] != $oldpassword)
		{
			ShowMsg('抱歉，旧密码错误！','-1');
			exit();
		}
	}

	$sql = "UPDATE `#@__member` SET ";
	if($password != '')
	{
		$password = md5(md5($password));
		$sql .= "password='$password', ";
	}
	@$sql .= "question='$question', answer='$answer', cnname='$cnname', enname='$enname', sex='$sex', birthtype='$birthtype', birth_year='$birth_year', birth_month='$birth_month', birth_day='$birth_day', astro='$astro', bloodtype='$bloodtype', trade='$trade', live_prov='$live_prov', live_city='$live_city', live_country='$live_country', home_prov='$home_prov', home_city='$home_city', home_country='$home_country', cardtype='$cardtype', cardnum='$cardnum', intro='$intro', email='$email', qqnum='$qqnum', mobile='$mobile', telephone='$telephone', address_prov='$address_prov', address_city='$address_city', address_country='$address_country', address='$address', zipcode='$zipcode' WHERE id=$id";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('资料更新成功！','?c=edit');
		exit();
	}
}


//获取级联
else if($a == 'getarea')
{

	//初始化参数
	$datagroup = isset($datagroup) ? $datagroup   : '';
	$level     = isset($level)     ? $level   : '';
	$v         = isset($areaval)   ? $areaval : '0';

	if($datagroup == '' or $level == '' or $v == '')
	{
		header('location:?c=default');
		exit();
	}

	$str = '<option value="-1">--</option>';
	$sql = "SELECT * FROM `#@__cascadedata` WHERE `level`=$level And ";

	if($v == 0)
		$sql .= "datagroup='$datagroup'";
	else if($v % 500 == 0)
		$sql .= "`datagroup`='$datagroup' AND `datavalue`>$v AND `datavalue`<".($v + 500);
	else
		$sql .= "`datavalue` LIKE '$v.%%%' AND `datagroup`='$datagroup'";
	
	$sql .= " ORDER BY orderid ASC, datavalue ASC";

	$dosql->Execute($sql);
	while($row = $dosql->GetArray())
	{
		$str .= '<option value="'.$row['datavalue'].'">'.$row['dataname'].'</option>';
	}
	
	if($str == '') $str .= '<option value="-1">--</option>'; 
	echo $str;
	exit();
}


//保存评论
else if($a == 'savecomment')
{
	$aid   = isset($aid)   ? $aid   : '';
	$molds = isset($molds) ? $molds : '';
	$body  = isset($body)  ? htmlspecialchars($body) : '';
	$link  = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

	if($aid == '' or $molds == '' or $body == '')
	{
		header('location:?c=default');
		exit();
	}

	$reply = '';
	
	if(empty($c_uname))
	{
		$uid   = '-1';
		$uname = '游客';
	}
	else
	{
		$r = $dosql->GetOne("SELECT `id`,`expval`,`integral` FROM `#@__member` WHERE `username`='$c_uname'");
		$uid   = $r['id'];
		$uname = $c_uname;
	}

	$time  = time();
	$ip    = GetIP();

	$dosql->ExecNoneQuery("INSERT INTO `#@__usercomment` (aid,molds,uid,uname,body,reply,link,time,ip,isshow) VALUES ('$aid','$molds','$uid','$uname','$body','$reply','$link','$time','$ip','1')");

	if(!empty($c_uname))
	{
		//评论一条增加1经验值2积分
		$dosql->ExecNoneQuery("UPDATE `#@__member` SET expval='".($r['expval'] + 1)."', integral='".($r['integral'] + 2)."' WHERE `username`='$c_uname'");
	}

	echo '1';
	exit();
}


//保存收藏
else if($a == 'savefavorite')
{

	$aid   = isset($aid)   ? $aid   : '';
	$molds = isset($molds) ? $molds : '';
	$link  = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

	if($aid == '' or $molds == '' or $link == '')
	{
		header('location:?c=default');
		exit();
	}

	$r = $dosql->GetOne("SELECT `id`,`expval`,`integral` FROM `#@__member` WHERE `username`='$c_uname'");
	$uid   = $r['id'];
	$uname = $c_uname;
	$time  = time();
	$ip    = GetIP();

	$r2 = $dosql->GetOne("SELECT `aid`,`molds` FROM `#@__userfavorite` WHERE `aid`=$aid and `molds`=$molds");
	if(!is_array($r2))
	{
		$dosql->ExecNoneQuery("INSERT INTO `#@__userfavorite` (aid,molds,uid,uname,link,time,ip,isshow) VALUES ('$aid','$molds','$uid','$uname','$link','$time','$ip','1')");
		
		//收藏一条增加1经验值2积分
		$dosql->ExecNoneQuery("UPDATE `#@__member` SET expval='".($r['expval'] + 1)."', integral='".($r['integral'] + 2)."' WHERE `username`='$c_uname'");
		echo '1';
		exit();
	}
	else
	{
		echo '2';
		exit();
	}
}


//删除收藏
else if($a == 'delfavorite')
{
	if(is_array($checkid))
	{
		foreach($checkid as $v)
		{
			$dosql->ExecNoneQuery("DELETE FROM `#@__userfavorite` WHERE `id`=$v AND `uname`='$c_uname'");
		}
	}

	header('location:?c=favorite');
	exit();
}


//删除评论
else if($a == 'delcomment')
{
	if(is_array($checkid))
	{
		foreach($checkid as $v)
		{
			$dosql->ExecNoneQuery("DELETE FROM `#@__usercomment` WHERE `id`=$v AND `uname`='$c_uname'");
		}
	}

	header('location:?c=comment');
	exit();
}





//加载模板页面
if($c == 'login')
{
	if(!empty($c_uname))
	{
		$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `username`='$c_uname'");
		if(is_array($r))
		{
			header('location:?c=default');
			exit();
		}
		else
		{
			setcookie('username',      '', time()-3600);
			setcookie('lastlogintime', '', time()-3600);
			setcookie('lastloginip',   '', time()-3600);
			ShowMsg('该用户已不存在！','?c=login');
			exit();
		}
	}
	else
	{
		require_once(PHPMYWIND_TEMP.'/default/member/login.html');
		exit();
	}
}

if($c=='default' or $c=='edit' or $c=='comment' or $c=='favorite' or $c=='msg' or $c=='avatar')
{
	if(!empty($c_uname))
	{
		$r = $dosql->GetOne("SELECT `id`,`expval` FROM `#@__member` WHERE `username`='$c_uname'");
		if(!is_array($r))
		{
			setcookie('username',      '', time()-3600);
			setcookie('lastlogintime', '', time()-3600);
			setcookie('lastloginip',   '', time()-3600);
			ShowMsg('该用户已不存在！','?c=login');
			exit();
		}
		else if($r['expval'] <= 0)
		{
			ShowMsg('抱歉，您的账号被禁止登陆！','?c=login');
			exit();
		}
	}
	else
	{
		header('location:?c=login');
		exit();
	}
}

if($c == 'default')
{
	require_once(PHPMYWIND_TEMP.'/default/member/default.html');
	exit();
}

else if($c == 'avatar')
{		
	require_once(PHPMYWIND_TEMP.'/default/member/avatar.html');
	exit();
}

else if($c == 'edit')
{		
	require_once(PHPMYWIND_TEMP.'/default/member/edit.html');
	exit();
}

else if($c == 'comment')
{	
	require_once(PHPMYWIND_TEMP.'/default/member/comment.html');
	exit();
}

else if($c == 'favorite')
{
	require_once(PHPMYWIND_TEMP.'/default/member/favorite.html');
	exit();
}

else if($c == 'msg')
{
	require_once(PHPMYWIND_TEMP.'/default/member/msg.html');
	exit();
}

else if($c == 'reg')
{
	require_once(PHPMYWIND_TEMP.'/default/member/reg.html');
	exit();
}

else if($c == 'findpwd')
{
	require_once(PHPMYWIND_TEMP.'/default/member/findpwd.html');
	exit();
}

else if($c == 'findpwd2')
{
	if(!isset($_POST['username']))
	{
		header('location:?c=findpwd');
		exit();
	}
	else
	{
		require_once(PHPMYWIND_TEMP.'/default/member/findpwd2.html');
		exit();
	}
}

else if($c == 'findpwd3')
{
	if(!isset($_POST['uname']))
	{
		header('location:?c=findpwd');
		exit();
	}
	else
	{
		require_once(PHPMYWIND_TEMP.'/default/member/findpwd3.html');
		exit();
	}
}

else
{
	header('location:?c=login');
	exit();
}



//验证码获取函数
function GetCkVdValue()
{
	if(!isset($_SESSION)) session_start();
	return isset($_SESSION['ckstr']) ? $_SESSION['ckstr'] : '';
}


//验证码重置函数
function ResetVdValue()
{
	if(!isset($_SESSION)) session_start();
	$_SESSION['ckstr'] = '';
}
