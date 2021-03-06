<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改导航菜单</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__nav` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改导航菜单</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<form name="form" id="form" method="post" action="nav_save.php" onsubmit="return cfm_nav();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td height="35" align="right" width="25%">所属分类：</td>
			<td width="75%">
				<select name="parentid" id="parentid">
					<option value="0">一级导航分类</option>
					<?php GetAllType('#@__nav','#@__nav','parentid'); ?>
				</select><span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">栏目名称：</td>
			<td><input name="classname" type="text" id="classname" value="<?php echo $row['classname']; ?>"  class="class_input" />
				<span class="maroon">*</span><span class="cnote">导航图片不为空，则以导航图片为优先级展示</span></td>
		</tr>
		<tr>
			<td height="35" align="right">跳转链接：</td>
			<td><input name="linkurl" type="text" id="linkurl" value="<?php echo $row['linkurl']; ?>"  class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">重写地址：</td>
			<td><input type="text" name="relinkurl" id="relinkurl" value="<?php echo $row['relinkurl']; ?>" class="class_input" />
				<span class="cnote">若开启URL静态化，系统自动切换至重写地址；请符合URL静态化设置的规则</span></td>
		</tr>
		<tr>
			<td height="35" align="right">导航图片：</td>
			<td><input name="picurl" type="text" id="picurl" class="class_input" value="<?php echo $row['picurl']; ?>" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" value="<?php echo $row['orderid']; ?>" class="class_input" style="width:80px;" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">隐藏栏目：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked'; ?> />
				显示&nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked'; ?> />
				隐藏</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="repid" id="repid" value="<?php echo $row['parentid']; ?>" />
	</div>
</form>
</body>
</html>