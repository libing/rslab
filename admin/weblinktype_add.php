<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加友情链接类别</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">添加链接类别</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="weblinktype_save.php" onsubmit="return cfm_btype();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属类别：</td>
			<td width="75%">
				<select name="parentid" id="parentid">
					<option value="0">一级友情链接</option>
					<?php GetAllType('#@__weblinktype','#@__weblinktype','id'); ?>
				</select>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">类别名称：</td>
			<td><input type="text" name="classname" id="classname" class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">排列顺序：</td>
			<td><input type="text" name="orderid" id="orderid" value="<?php echo GetOrderID('#@__weblinktype'); ?>" class="input_shortb" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input name="checkinfo" type="radio" value="true" checked="checked"  />
				是&nbsp;
				<input type="radio" name="checkinfo" value="false" />
				否<span class="cnote">选择“否”则该信息暂时不显示在前台</span></td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input name="action" type="hidden" id="action" value="add" />
	</div>
</form>
</body>
</html>