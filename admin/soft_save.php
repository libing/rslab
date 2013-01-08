<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-1-12 8:43:33
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__soft';
$gourl = isset($tid) ? ($gourl = "soft.php?tid=$tid") : ($gourl = "soft.php");


//添加软件信息
if($action == 'add')
{
	if(!isset($mainid)) $mainid = '-1';
	if(!isset($flag))   $flag   = '';
	if(!isset($picarr)) $picarr = '';

	if(!isset($rempic))             $rempic = '';
	if(!isset($remote))             $remote = '';
	if(!isset($autothumb))       $autothumb = '';
	if(!isset($autodesc))         $autodesc = '';
	if(!isset($autodescsize)) $autodescsize = '';
	if(!isset($autopage))         $autopage = '';
	if(!isset($autopagesize)) $autopagesize = '';


	//获取parentstr
	$row = $dosql->GetOne("SELECT parentid FROM `#@__infoclass` WHERE id=$classid");
	$parentid = $row['parentid'];

	if($parentid == 0)
	{
		$parentstr = '0,';
	}
	else
	{
		$r = $dosql->GetOne("SELECT parentstr FROM `#@__infoclass` WHERE id=$parentid");
		$parentstr = $r['parentstr'].$parentid.',';
	}
	
	
	//获取mainid
	if($mainid != '-1')
	{
		$row = $dosql->GetOne("SELECT parentid FROM `#@__maintype` WHERE id=$mainid");
		$mainpid = $row['parentid'];

		if($mainpid == 0)
		{
			$mainpstr = '0,';
		}
		else
		{
			$r = $dosql->GetOne("SELECT parentstr FROM `#@__maintype` WHERE id=$mainpid");
			$mainpstr = $r['parentstr'].$mainpid.',';
		}
	}
	else
	{
		$mainpid  = '-1';
		$mainpstr = '';
	}


	if(is_array($flag))
	{
		$flag = implode(',',$flag);
	}
	
	if(is_array($picarr))
	{
		$picarr = implode(',',$picarr);
	}


	//保存远程缩略图
	if($rempic=='true' and preg_match("#^http:\/\/#i", $picurl))
	{
		$picurl = GetRemPic($picurl);
	}


	//保存远程资源
	if($remote == 'true') $content = GetContFile($content);


	//第一个图片作为缩略图
	if($autothumb == 'true')
	{
		$cont_str = stripslashes($content);
		preg_match_all('/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/', $cont_str, $imgurl);
		
		//如果存在图片
		if(isset($imgurl[1][0]))
		{
			$picurl = $imgurl[1][0];
			$picurl = substr($picurl, strpos($picurl, 'uploads/'));
		}
	}


	//自动提取内容到摘要
	if($autodesc == 'true')
	{
		if(empty($autodescsize) or !intval($autodescsize))
		{
			$autodescsize = 200;
		}

		$descstr = ClearHtml($content);

		$description = ReStrLen($descstr, $autodescsize);

	}


	//自动分页
    if($autopage == 'true')
    {
        $content = ContAutoPage($content, $autopagesize*1024);
    }


	$posttime = GetMkTime($posttime);


	//自定义字段处理
	$fieldname  = '';
	$fieldvalue = '';
	$fieldstr   = '';
	$dosql->Execute("SELECT * FROM `#@__diyfield` WHERE infotype=3 AND checkinfo=true ORDER BY orderid ASC");

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


	$sql = "INSERT INTO `$tbname` (siteid, classid, parentid, parentstr, mainid, mainpid, mainpstr, title, colorval, boldval, flag, filetype, softtype, language, accredit, softsize, unit, runos, website, demourl, dlurl, author, linkurl, keywords, description, content, picurl, picarr, orderid, hits, posttime, checkinfo {$fieldname}) VALUES ('$cfg_siteid', '$classid', '$parentid', '$parentstr', '$mainid', '$mainpid', '$mainpstr', '$title', '$colorval', '$boldval', '$flag', '$filetype', '$softtype', '$language', '$accredit', '$softsize', '$unit', '$runos', '$website', '$demourl', '$dlurl', '$author', '$linkurl', '$keywords', '$description', '$content', '$picurl', '$picarr', '$orderid', '$hits', '$posttime', '$checkinfo' {$fieldvalue})";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改软件信息
else if($action == 'update')
{
	if(!isset($mainid)) $mainid = '-1';
	if(!isset($flag))   $flag   = '';
	if(!isset($picarr)) $picarr = '';

	if(!isset($rempic))             $rempic = '';
	if(!isset($remote))             $remote = '';
	if(!isset($autothumb))       $autothumb = '';
	if(!isset($autodesc))         $autodesc = '';
	if(!isset($autodescsize)) $autodescsize = '';
	if(!isset($autopage))         $autopage = '';
	if(!isset($autopagesize)) $autopagesize = '';


	//获取parentstr
	$row = $dosql->GetOne("SELECT parentid FROM `#@__infoclass` WHERE id=$classid");
	$parentid = $row['parentid'];

	if($parentid == 0)
	{
		$parentstr = '0,';
	}
	else
	{
		$r = $dosql->GetOne("SELECT parentstr FROM `#@__infoclass` WHERE id=$parentid");
		$parentstr = $r['parentstr'].$parentid.',';
	}
	
	
	//获取mainid
	if($mainid != '-1')
	{
		$row = $dosql->GetOne("SELECT parentid FROM `#@__maintype` WHERE id=$mainid");
		$mainpid = $row['parentid'];
	
		if($mainpid == 0)
		{
			$mainpstr = '0,';
		}
		else
		{
			$r = $dosql->GetOne("SELECT parentstr FROM `#@__maintype` WHERE id=$mainpid");
			$mainpstr = $r['parentstr'].$mainpid.',';
		}
	}
	else
	{
		$mainpid  = '-1';
		$mainpstr = '';
	}


	if(is_array($flag))
	{
		$flag = implode(',',$flag);
	}
	
	if(is_array($picarr))
	{
		$picarr = implode(',',$picarr);
	}


	//保存远程缩略图
	if($rempic=='true' and preg_match("#^http:\/\/#i", $picurl))
	{
		$picurl = GetRemPic($picurl);
	}


	//保存远程资源
	if($remote == 'true') $content = GetContFile($content);


	//第一个图片作为缩略图
	if($autothumb == 'true')
	{
		$cont_str = stripslashes($content);
		preg_match_all('/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/', $cont_str, $imgurl);
		
		//如果存在图片
		if(isset($imgurl[1][0]))
		{
			$picurl = $imgurl[1][0];
			$picurl = substr($picurl, strpos($picurl, 'uploads/'));
		}
	}


	//自动提取内容到摘要
	if($autodesc == 'true')
	{
		if(empty($autodescsize) or !intval($autodescsize))
		{
			$autodescsize = 200;
		}

		$descstr = ClearHtml($content);

		$description = ReStrLen($descstr, $autodescsize);

	}


	//自动分页
    if($autopage == 'true')
    {
        $content = ContAutoPage($content, $autopagesize*1024);
    }


	$posttime = GetMkTime($posttime);


	//自定义字段处理
	$fieldname  = '';
	$fieldvalue = '';
	$fieldstr   = '';
	$dosql->Execute("SELECT * FROM `#@__diyfield` WHERE infotype=3 AND checkinfo=true ORDER BY orderid ASC");

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

	$sql = "UPDATE `$tbname` SET siteid='$cfg_siteid', classid='$classid', parentid='$parentid', parentstr='$parentstr', mainid='$mainid', mainpid='$mainpid', mainpstr='$mainpstr', title='$title', colorval='$colorval', boldval='$boldval', flag='$flag', filetype='$filetype', softtype='$softtype', language='$language', accredit='$accredit', softsize='$softsize', unit='$unit', runos='$runos', website='$website', demourl='$demourl', dlurl='$dlurl', author='$author', linkurl='$linkurl', keywords='$keywords', description='$description', content='$content', picurl='$picurl', picarr='$picarr', orderid='$orderid', hits='$hits', posttime='$posttime', checkinfo='$checkinfo' {$fieldstr} WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改审核状态
else if($action == 'check')
{
	if($checkinfo == '已审')
	{
		$dosql->ExecNoneQuery("UPDATE `$tbname` SET checkinfo='false' WHERE id=$id");
		echo '[<a href="javascript:;" onclick="CheckInfo('.$id.',\'未审\')" title="点击进行审核与未审操作">未审</a>]';
		exit();
	}
	if($checkinfo == '未审')
	{
		$dosql->ExecNoneQuery("UPDATE `$tbname` SET checkinfo='true' WHERE id=$id");
		echo '[<a href="javascript:;" onclick="CheckInfo('.$id.',\'已审\')" title="点击进行审核与未审操作">已审</a>]';
		exit();
	}
}

else
{
	header("location:$gourl");
	exit();
}
?>