<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>信息标记管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">信息标记管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="infoflag_save.php?action=save">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="5%" height="30"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="40%" align="left">属性名称</td>
			<td width="35%" align="left">属性标识 <span style="font-weight:normal;">[属性标识不可含有重复字母]</span></td>
			<td width="10%">排序</td>
			<td width="10%">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__infoflag` ORDER BY orderid ASC");
		
		if($dosql->GetTotalRow() > 0)
		{
			while($row = $dosql->GetArray())
			{		
		?>
		<tr align="center" class="mgr_tr">
			<td height="32"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left"><input type="text" name="flagname[]" id="flagname[]" class="input_gray2" value="<?php echo $row['flagname']; ?>" />
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="left"><input type="text" name="flag[]" id="flag[]" class="input_gray2" value="<?php echo $row['flag']; ?>" /></td>
			<td><a href="infoflag_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=up"><img src="templates/images/up.gif" title="向上移动" /></a>
				<input type="text" name="orderid[]" id="orderid[]" class="input_gray_short" value="<?php echo $row['orderid']; ?>" />
				<a href="infoflag_save.php?id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>&action=down"><img src="templates/images/down.gif" title="向下移动" /></a></td>
			<td class="action"><span>[<a href="infoflag_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
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
		<?Php
		}
		?>
		<tr align="center">
			<td height="25" colspan="5" class="tr_orange">新增一个信息标记</td>
		</tr>
		<tr align="center" class="mgr_tr">
			<td height="32">&nbsp;</td>
			<td align="left"><input type="text" name="flagnameadd" id="flagnameadd" class="input_gray2" /></td>
			<td align="left"><input type="text" name="flagadd" id="flagadd" class="input_gray2" /></td>
			<td><input type="text" name="orderidadd" id="orderidadd" class="input_gray_short" value="<?php echo GetOrderID('#@__infoflag'); ?>" /></td>
			<td class="action">&nbsp;</td>
		</tr>
	</table>
</form>
<div class="mgr_divb"> <span class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('infoflag_save.php');" onclick="return ConfDelAll(0);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('infoflag_save.php');">更新排序</a></span> <span class="mgr_btn_short"><a href="#" onclick="form.submit();">更新全部</a></span></div>
<div class="page_area">
	<div class="page_info">共有<span><?php echo $dosql->GetTableRow("#@__infoflag"); ?></span>条记录</div>
</div>
</body>
</html>