<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加商品品牌</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">添加商品品牌</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="goodsbrand_save.php" onsubmit="return cfm_btype();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属品牌名称：</td>
			<td width="75%">
				<select name="parentid" id="parentid">
					<option value="0">一级品牌分类</option>
					<?php GetAllType('#@__goodsbrand','#@__goodsbrand','id'); ?>
				</select>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">品牌名称：</td>
			<td><input type="text" name="classname" id="classname" class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">图片地址：</td>
			<td><input type="text" name="picurl" id="picurl" class="class_input" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">跳转链接：</td>
			<td><input type="text" name="linkurl" id="linkurl" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">排列顺序：</td>
			<td><input type="text" name="orderid" id="orderid" value="<?php echo GetOrderID('#@__goodsbrand'); ?>" class="input_shortb" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">隐藏类别：</td>
			<td><input type="radio" name="checkinfo" value="true" checked="checked"  />
				显示&nbsp;
				<input type="radio" name="checkinfo" value="false" />
				隐藏</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" onclick="history.go(-1)" value=""  />
		<input type="hidden" name="action" id="action" value="add" />
	</div>
</form>
</body>
</html>