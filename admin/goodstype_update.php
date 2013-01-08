<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改商品分类</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__goodstype` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改商品分类</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="goodstype_save.php" onsubmit="return cfm_btype();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属类别：</td>
			<td width="75%">
			<select name="parentid" id="parentid">
				<option value="0">一级商品分类</option>
				<?php GetAllType('#@__goodstype','#@__goodstype','parentid'); ?>
			</select>
			<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">类别名称：</td>
			<td><input type="text" name="classname" id="classname" class="class_input" value="<?php echo $row['classname']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">类别属性：</td>
			<td style="padding-top:5px;">
			<?php
			$r = $dosql->GetOne("SELECT attrstr from `#@__goodstype` WHERE id=$id");
			$attrstr_arr = explode(',',$r['attrstr']);

			$dosql->Execute("SELECT * FROM `#@__goodsattr` WHERE checkinfo=true ORDER BY orderid",2);
			$i = 1;
			
			if($dosql->GetTotalRow(2) > 0)
			{
				while($row2 = $dosql->GetArray(2))
				{
					if(in_array($row2['id'], $attrstr_arr))
					{
						$checked = 'checked';
					}
					else
					{
						$checked = '';
					}

					echo '<span class="goodstypeattr"><input type="checkbox" name="attrids[]" id="attrids[]" value="'.$row2['id'].'" '.$checked.' />'.$row2['classname'].'</span>';
					if($i % 5 == 0) echo '<br />';
					$i++;
				}
			}
			else
			{
				echo '暂无属性 <a href="goodsattr.php" style="color:#09F">[添加属性]</a>';
			}
			?></td>
		</tr>
		<tr>
			<td height="35" align="right">图片地址：</td>
			<td><input type="text" name="picurl" class="class_input" id="picurl" value="<?php echo $row['picurl']; ?>" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">跳转链接：</td>
			<td><input type="text" name="linkurl" class="class_input" id="linkurl" value="<?php echo $row['linkurl']; ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">排列顺序：</td>
			<td><input type="text" name="orderid" id="orderid" class="class_input" style="width:80px;" value="<?php echo $row['orderid']; ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">隐藏类别：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked'; ?> />
				显示&nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked'; ?> />
				隐藏</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" onclick="history.go(-1)" value=""  />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="repid" id="repid" value="<?php echo $row['parentid']; ?>" />
	</div>
</form>
</body>
</html>