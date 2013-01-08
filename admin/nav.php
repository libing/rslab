<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>导航菜单管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">导航菜单管理</span><span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="30%" class="title2">导航名称</td>
			<td width="15%">跳转链接</td>
			<td width="15%">排序</td>
			<td width="30%">操作</td>
		</tr>
	</table>
	<?php
	function Show($id=0, $i=0)
	{
		global $dosql,$cfg_siteid;
		$dosql->Execute("SELECT * FROM `#@__nav` WHERE `siteid`='$cfg_siteid' AND `parentid`=$id ORDER BY `orderid` ASC", $id);
		$i++;
	
		while($row = $dosql->GetArray($id))
		{
			switch($row['checkinfo'])
			{
				case 'true':
				$checkinfo = '显示';
				break;  
				case 'false':
				$checkinfo = '隐藏';
				break;
				default:
				$checkinfo = '没有获取到参数';
			}
	
			//设置classname区域
			$classname = '';
	
			if($row['parentid'] == '0')
			{
				$classname .= '<span class="disimg" id="rowid_'.$row['id'].'" onclick="DisplayRows('.$row['id'].');">';
			}
			else
			{
				$classname .= '<span class="sub_type">';
			}
	
			$classname .= $row['classname'].'</span>';
	
			$topid = GetTopID($row['parentstr']);
	?>
	<div rel="rowpid_<?php echo $topid ; ?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
			<tr align="center" class="mgr_tr">
				<td width="5%" height="32"><input type="checkbox" name="checkid[]" value="<?php echo $row['id']; ?>" /></td>
				<td width="5%"><?php echo $row['id']; ?>
					<input type="hidden"  name="id[]"id="id[]" value="<?php echo $row['id']; ?>" /></td>
				<td width="30%" align="left">
				<?php
				for($n=1; $n<$i; $n++) echo '&nbsp;&nbsp;';
				echo $classname;
				?></td>
				<td width="15%" class="number"><?php echo $row['linkurl']; ?></td>
				<td width="15%"><a href="nav_save.php?action=up&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/up.gif" title="向上移动" /></a>
					<input type="text" name="orderid[]" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
					<a href="nav_save.php?action=down&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>"><img src="templates/images/down.gif" title="向下移动" /></a></td>
				<td width="30%" class="action"><span><a href="nav_add.php?id=<?php echo $row['id']; ?>">添加子导航</a></span> | <span><a href="nav_save.php?action=check&id=<?php echo $row['id']; ?>&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行显示与隐藏操作"><?php echo $checkinfo; ?></a></span> | <span><a href="nav_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | <span><a href="nav_save.php?action=del&id=<?php echo $row['id'] ?>" onclick="return ConfDel(2);">删除</a></span></td>
			</tr>
		</table>
	</div>
	<?php
			Show($row['id'], $i+2);
		}
	}

	Show();


	//判断类别页是否折叠
	if($cfg_typefold == 'Y')
	{
		echo '<script>HideAllRows();</script>';
	}
	?>
</form>
<?php
if($dosql->GetTotalRow(0) == 0)
{
	echo '<div class="mgr_nlist">暂时没有相关的记录</div>';
}
?>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('nav_save.php');" onclick="return ConfDelAll(1);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('nav_save.php');">更新</a> - <a href="javascript:ShowAllRows();">展开</a> - <a href="javascript:HideAllRows();">隐藏</a></div>
	<span class="mgr_btn"><a href="nav_add.php">添加导航菜单</a></span> </div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow('#@__nav',$cfg_siteid); ?></span>条记录</div>
</div>
</body>
</html>