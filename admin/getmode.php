<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>货到方式管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">货到方式管理</span><span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="getmode_save.php?action=save">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td align="left">货到方式</td>
			<td width="30%">排序</td>
			<td width="18%">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__getmode` ORDER BY orderid ASC");
		if($dosql->GetTotalRow() > 0)
		{
			while($row = $dosql->GetArray())
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
		?>
		<tr align="center" class="mgr_tr">
			<td height="32"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?>
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left"><input type="text" name="classname[]" class="input_gray" id="classname[]" value="<?php echo $row['classname']; ?>" /></td>
			<td><a href="getmode_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=up"><img src="templates/images/up.gif" title="向上移动" /></a>
				<input type="text" name="orderid[]" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
				<a href="getmode_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=down"><img src="templates/images/down.gif" title="向下移动" /></a></td>
			<td class="action"><span>[<a href="getmode_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行显示与隐藏操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="getmode_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
			}
		}
		else
		{
		?>
		<tr align="center">
			<td colspan="5" class="mgr_nlist">暂时没有相关的记录</td>
		</tr>
		<?php
		}
		?>
		<tr align="center">
			<td height="25" colspan="5" class="tr_green">新增一个方式</td>
		</tr>
		<tr align="center" class="mgr_tr">
			<td height="32">&nbsp;</td>
			<td>自增</td>
			<td align="left"><input type="text" name="classnameadd" class="input_gray" id="classnameadd" /></td>
			<td><input type="text" name="orderidadd" id="orderidadd" class="input_gray_short" value="<?php echo GetOrderID('#@__getmode'); ?>" /></td>
			<td class="action"><input type="radio" name="checkinfoadd" value="true" checked="checked"  />
				显示&nbsp;
				<input type="radio" name="checkinfoadd" value="false" />
				隐藏</td>
		</tr>
	</table>
</form>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('getmode_save.php');" onclick="return ConfDelAll(0);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('getmode_save.php');">更新排序</a></div>
	<span class="mgr_btn"><a href="#" onclick="form.submit();">更新全部内容</a></span> </div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow("#@__getmode"); ?></span>条记录</div>
</div>
</body>
</html>