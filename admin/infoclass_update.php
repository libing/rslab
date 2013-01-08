<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改栏目</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改栏目</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<form name="form" id="form" method="post" action="infoclass_save.php" onsubmit="return cfm_infoclass();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<?php
		if($cfg_curmode != 'small')
		{
		?>
		<tr>
			<td width="25%" height="35" align="right">栏目类型：</td>
			<td width="350"><select name="infotype" id="infotype">
				<?php
				foreach(array('0'=>'单页','1'=>'列表','2'=>'图片','3'=>'下载') as $k => $v)
				{
					if($row['infotype'] == $k)
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}
					echo "<option value=\"$k\" $selected>$v</option>";
				}
				?>
				</select>
				<span class="maroon">*</span></td>
			<td><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">所属栏目：</td>
			<td><select name="parentid" id="parentid">
					<option value="0">一级栏目</option>
					<?php GetAllType('#@__infoclass','#@__infoclass','parentid'); ?>
				</select></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}
		else
		{
		?>
		<tr>
			<td width="25%" height="35" align="right">信息类型：</td>
			<td width="350"><strong>
				<?php
				foreach(array('0'=>'单页','1'=>'列表','2'=>'图片','3'=>'下载') as $k => $v)
				{
					if($row['infotype'] == $k)
					{
						echo $v;
					}
				}
				?>
				</strong> <span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
			<input type="hidden" name="infotype" id="infotype" value="<?php echo $row['infotype']; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="35" align="right">所属栏目：</td>
			<td><strong>
				<?php
				if($row['parentid'] != 0)
				{
					$r = $dosql->GetOne("SELECT classname FROM `#@__infoclass` WHERE id=".$row['parentid']);
					echo $r['classname'];
				}
				else
				{
					echo '一级栏目';
				}
				?>
				</strong>
				<input type="hidden" name="parentid" id="parentid" value="<?php echo $row['parentid']; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td height="35" align="right">栏目名称：</td>
			<td><input name="classname" type="text" id="classname" value="<?php echo $row['classname']; ?>"  class="class_input" />
				<span class="maroon">*</span></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="35" align="right">缩略图片：</td>
			<td><input name="picurl" type="text" id="picurl" class="class_input" value="<?php echo $row['picurl']; ?>" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="35" align="right">跳转链接：</td>
			<td><input name="linkurl" type="text" id="linkurl" value="<?php echo $row['linkurl']; ?>"  class="class_input" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="35" align="right">SEO标题：</td>
			<td><input type="text" name="seotitle" id="seotitle" class="class_input" value="<?php echo $row['seotitle']; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="35" align="right">关键词：</td>
			<td><input type="text" name="keywords" id="keywords" class="class_input" value="<?php echo $row['keywords']; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="116" align="right">栏目描述：</td>
			<td><textarea name="description" id="description" class="class_areatext"><?php echo $row['description']; ?></textarea></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" value="<?php echo $row['orderid']; ?>" class="input_shortb" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">隐藏栏目：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked'; ?> />
				显示&nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked'; ?> />
				隐藏</td>
			<td>&nbsp;</td>
		</tr>
		<?php
		if($cfg_curmode != 'small')
		{
		?>
		<tr class="nb">
			<td colspan="3" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">管　理：</td>
			<td><input name="adminmenu" value="true" type="checkbox" <?php if($row['adminmenu'] == 'true') echo 'checked'; ?> />
				设为管理菜单</td>
			<td><span class="cnote">设置后可允许普通管理员管理此栏目</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">分　类：</td>
			<td>限制为
				<input type="text" name="menulevel" value="<?php echo $row['menulevel']; ?>" class="class_input" style="width:40px;" />
				级分类</td>
			<td><span class="cnote">限制普通管理员管理此栏目下级层数，0为不允许</span></td>
		</tr>
		<?php
		}
		else
		{
		?>
		<input name="adminmenu" type="hidden" value="<?php echo $row['adminmenu']; ?>" />
		<input name="menulevel" type="hidden" value="<?php echo $row['menulevel']; ?>" />
		<?php
		}
		?>
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