<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改广告位</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__adtype` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改广告位</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="adtype_save.php" onsubmit="return cfm_adtype();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属广告位：</td>
			<td width="75%">
				<select name="parentid" id="parentid">
					<option value="0">一级广告位</option>
					<?php GetAllType('#@__adtype','#@__adtype','parentid'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">广告位名称：</td>
			<td><input name="classname" type="text" class="class_input" id="classname" value="<?php echo $row['classname']; ?>" />
				<span class="maroon">*<span class="cnote">带*号表示为必填项</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">广告位宽度：</td>
			<td><input type="text" name="width" class="class_input" id="width" style="width:80px;" value="<?php echo $row['width']; ?>" />
				px　高度：
				<input type="text" name="height" class="class_input" id="height" style="width:80px;" value="<?php echo $row['height']; ?>" />
				px</td>
		</tr>
		<tr>
			<td height="35" align="right">排列顺序：</td>
			<td><input type="text" name="orderid" id="orderid" class="class_input" style="width:80px;" value="<?php echo $row['orderid']; ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked'; ?> />
				显示&nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked'; ?> />
				隐藏</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input name="action" type="hidden" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>