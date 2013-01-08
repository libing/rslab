<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2012-1-13 11:11:33
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__goodsorder';
$gourl  = 'goodsorder.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加订单信息
if($action == 'add')
{
	if(!isset($core)) $core = '';

	$posttime = GetMkTime($posttime);

	if($checkinfo != '')
	{
		$checkinfo = implode(',', $checkinfo);
	}

	$sql = "INSERT INTO `$tbname` (username, truename, telephone, zipcode, province, city, address, cardtype, cardnum, postid, postmode, postarea_prov, postarea_city, postarea_country, paymode, getmode, weight, cost, orderamount, integral, buyremark, sendremark, posttime, orderid, checkinfo, core) VALUES ('$username', '$truename', '$telephone', '$zipcode', '$province', '$city', '$address', '$cardtype', '$cardnum', '$postid', '$postmode', '$postarea_prov', '$postarea_city', '$postarea_country', '$paymode', '$getmode', '$weight', '$cost', '$orderamount', '$integral', '$buyremark', '$sendremark', '$posttime', '$orderid', '$checkinfo', '$core')";

	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//修改订单信息
else if($action == 'update')
{
	if(!isset($core)) $core = '';

	$posttime = GetMkTime($posttime);

	if($checkinfo != '')
	{
		$checkinfo = implode(',', $checkinfo);
	}

	$sql = "UPDATE `$tbname` SET username='$username', truename='$truename', telephone='$telephone', zipcode='$zipcode', province='$province', city='$city', address='$address', cardtype='$cardtype', cardnum='$cardnum', postid='$postid', postarea_prov='$postarea_prov', postarea_city='$postarea_city', postarea_country='$postarea_country', postmode='$postmode', paymode='$paymode', getmode='$getmode', weight='$weight', cost='$cost', orderamount='$orderamount', integral='$integral', buyremark='$buyremark', sendremark='$sendremark', posttime='$posttime', orderid='$orderid', checkinfo='$checkinfo', core='$core' WHERE id=$id";
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