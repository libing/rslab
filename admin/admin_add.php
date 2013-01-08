<?php require(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加管理员</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">添加管理员</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="admin_save.php" onsubmit="return cfm_admin();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">用户名：</td>
			<td width="75%"><input type="text" name="username" class="class_input" id="username" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">密　码：</td>
			<td><input type="password" name="password" class="class_input" id="password" />
				<span class="maroon">*</span><span class="cnote">6-16个字符组成，区分大小写</span></td>
		</tr>
		<tr>
			<td height="35" align="right">确　认：</td>
			<td><input type="password" name="repassword" class="class_input" id="repassword" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">级　别：</td>
			<td><select name="levelname" id="levelname">
				<?php
				foreach(array('0'=>'超级管理员', '1'=>'普通管理员', '2'=>'文章发布员') as $k=>$v)
				{
					if($cfg_curmode != 'small')
					{
						echo "<option value=\"$k\">$v</option>";
					}
					else
					{
						if($k != 0)
						{
							echo "<option value=\"$k\">$v</option>";
						}
						
					}											
				}
				?>
				</select></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkadmin" value="true" checked="checked"  />
				已审核&nbsp;
				<input type="radio" name="checkadmin" value="false" />
				未审核</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" value="" class="blue_submit_btn" />
		<input type="button" value="" class="blue_back_btn" onclick="history.go(-1)" />
		<input type="hidden" name="action" id="action" value="add" />
	</div>
</form>
</body>
</html>