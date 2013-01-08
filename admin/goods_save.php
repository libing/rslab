<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2011-1-20 10:12:28
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__goods';
$gourl  = 'goods.php';
$action = isset($action) ? $action : '';


//添加商品信息
if($action == 'add')
{
	if(!isset($flag))      $flag   = '';
	if(!isset($attrid))    $attrid = '';
	if(!isset($attrvalue)) $attrvalue = '';
	if(!isset($picarr))    $picarr = '';

	if(!isset($rempic))             $rempic = '';
	if(!isset($remote))             $remote = '';
	if(!isset($autothumb))       $autothumb = '';
	if(!isset($autodesc))         $autodesc = '';
	if(!isset($autodescsize)) $autodescsize = '';
	if(!isset($autopage))         $autopage = '';
	if(!isset($autopagesize)) $autopagesize = '';


	//获取parentstr
	$row = $dosql->GetOne("SELECT parentid FROM `#@__goodstype` WHERE id=$classid");
	$parentid = $row['parentid'];

	if($parentid == 0)
	{
		$parentstr = '0,';
	}
	else
	{
		$r = $dosql->GetOne("SELECT parentstr FROM `#@__goodstype` WHERE id=$parentid");
		$parentstr = $r['parentstr'].$parentid.',';
	}
	
	
	//获取品牌parentstr
	$row = $dosql->GetOne("SELECT parentid FROM `#@__goodsbrand` WHERE id=$brandid");
	if(isset($row['parentid']))
	{
		if($brandpid == 0)
		{
			$brandpstr = '0,';
		}
		else
		{
			$r = $dosql->GetOne("SELECT parentstr FROM `#@__goodsbrand` WHERE id=$brandpid");
			$brandpstr = $r['parentstr'].$brandpid.',';
		}
	}
	else
	{
		$brandpid = '-1';
	}


	if(is_array($flag))
	{
		$flag = implode(',',$flag);
	}

	
	if(is_array($attrid))
	{
		$attrid = implode(',', $attrid);
	}


	if(is_array($attrvalue))
	{
		$attrvalue = implode(',', $attrvalue);
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
	$dosql->Execute("SELECT * FROM `#@__diyfield` WHERE infotype=4 AND checkinfo=true ORDER BY orderid ASC");

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


	$sql = "INSERT INTO `$tbname` (classid, parentid, parentstr, brandid, brandpid, brandpstr, title, colorval, boldval, flag, goodsid, payfreight, weight, attrid, attrvalue, marketprice, salesprice, memberprice, housenum, housewarn, warnnum, integral, author, linkurl, keywords, description, content, picurl, picarr, hits, orderid, posttime, checkinfo {$fieldname}) VALUES ('$classid', '$parentid', '$parentstr', '$brandid', '$brandpid', '$brandpstr', '$title', '$colorval', '$boldval', '$flag', '$goodsid', '$payfreight', '$weight', '$attrid', '$attrvalue', '$marketprice', '$salesprice', '$memberprice', '$housenum', '$housewarn', '$warnnum', '$integral', '$author', '$linkurl', '$keywords', '$description', '$content', '$picurl', '$picarr', '$hits', '$orderid', '$posttime', '$checkinfo' {$fieldvalue})";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改商品信息
else if($action == 'update')
{
	if(!isset($flag))      $flag   = '';
	if(!isset($attrid))    $attrid = '';
	if(!isset($attrvalue)) $attrvalue = '';
	if(!isset($picarr))    $picarr = '';

	if(!isset($rempic))             $rempic = '';
	if(!isset($remote))             $remote = '';
	if(!isset($autothumb))       $autothumb = '';
	if(!isset($autodesc))         $autodesc = '';
	if(!isset($autodescsize)) $autodescsize = '';
	if(!isset($autopage))         $autopage = '';
	if(!isset($autopagesize)) $autopagesize = '';


	//获取parentstr
	$row = $dosql->GetOne("SELECT parentid FROM `#@__goodstype` WHERE id=$classid");
	$parentid = $row['parentid'];

	if($parentid == 0)
	{
		$parentstr = '0,';
	}
	else
	{
		$r = $dosql->GetOne("SELECT parentstr FROM `#@__goodstype` WHERE id=$parentid");
		$parentstr = $r['parentstr'].$parentid.',';
	}
	
	
	//获取品牌parentstr
	$row = $dosql->GetOne("SELECT parentid FROM `#@__goodsbrand` WHERE id=$brandid");
	if(isset($row['parentid']))
	{
		if($brandpid == 0)
		{
			$brandpstr = '0,';
		}
		else
		{
			$r = $dosql->GetOne("SELECT parentstr FROM `#@__goodsbrand` WHERE id=$brandpid");
			$brandpstr = $r['parentstr'].$brandpid.',';
		}
	}
	else
	{
		$brandpid = '-1';
	}


	if(is_array($flag))
	{
		$flag = implode(',',$flag);
	}

	
	if(is_array($attrid))
	{
		$attrid = implode(',', $attrid);
	}


	if(is_array($attrvalue))
	{
		$attrvalue = implode(',', $attrvalue);
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
	$dosql->Execute("SELECT * FROM `#@__diyfield` WHERE infotype=4 AND checkinfo=true ORDER BY orderid ASC");

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


	$sql = "UPDATE `$tbname` SET classid='$classid', parentid='$parentid', parentstr='$parentstr', brandid='$brandid', brandpid='$brandpid', brandpstr='$brandpstr', title='$title', colorval='$colorval', boldval='$boldval', flag='$flag', goodsid='$goodsid', payfreight='$payfreight', weight='$weight', attrid='$attrid', attrvalue='$attrvalue', marketprice='$marketprice', salesprice='$salesprice', memberprice='$memberprice', housenum='$housenum', housewarn='$housewarn', warnnum='$warnnum', integral='$integral', author='$author', linkurl='$linkurl', keywords='$keywords', description='$description', content='$content', picurl='$picurl', picarr='$picarr', hits='$hits', orderid='$orderid', posttime='$posttime', checkinfo='$checkinfo' {$fieldstr} WHERE id=$id";
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