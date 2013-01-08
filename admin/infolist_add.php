<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加列表信息</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="../data/plugin/calendar/calendar.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">添加列表信息</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="infolist_save.php" onsubmit="return cfm_infolm();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属栏目：</td>
			<td width="75%"><select name="classid" id="classid">
					<option value="-1">请选择所属栏目</option>
					<?php CategoryType(1); ?>
				</select>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<?php
		if($cfg_maintype == 'Y')
		{
		?>
		<tr>
			<td height="35" align="right">所属类别：</td>
			<td><select name="mainid" id="mainid">
					<option value="-1">请选择所属类别</option>
					<?php GetAllType('#@__maintype','#@__infolist','mainid'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td height="35" align="right">标　题：</td>
			<td><input type="text" name="title" id="title" class="input_title" />
				<span class="maroon">*</span>
				<script type="text/javascript" src="../data/plugin/colorpicker/colorpicker.js"></script>
				<div class="title_panel">
					<input type="hidden" name="colorval" id="colorval" />
					<input type="hidden" name="boldval" id="boldval" />
					<span onclick="colorpicker('colorpanel','colorval','title');" class="color" title="标题颜色"> </span> <span id="colorpanel"></span> <span onclick="blodpicker('boldval','title');" class="blod" title="标题加粗"> </span> <span onclick="clearpicker()" class="clear" title="清除属性">[#]</span> &nbsp; </div></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">属　性：</td>
			<td class="attrArea">
			<?php
			$dosql->Execute("SELECT * FROM `#@__infoflag` ORDER BY orderid ASC");
			while($row = $dosql->GetArray())
			{
				echo '<span><input type="checkbox" name="flag[]" id="flag[]" value="'.$row['flag'].'" />'.$row['flagname'].'['.$row['flag'].']</span>';
			}
			?></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"> </div></td>
		</tr>
		<?php
		GetDiyField('1');
		?>
		<tr>
			<td height="35" align="right">来源作者：</td>
			<td><input type="text" name="author" id="author" value="<?php echo $_SESSION['admin']; ?>" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">缩略图片：</td>
			<td><input type="text" name="picurl" id="picurl" class="class_input" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span> <span class="reimg">
				<input type="checkbox" name="rempic" id="rempic" value="true" />
				远程</span> <span class="cutimg"><a href="javascript:;" onclick="GetJcrop('jcrop','picurl');return false;">裁剪</a></span> </span></td>
		</tr>
		<tr>
			<td height="35" align="right">跳转链接：</td>
			<td><input type="text" name="linkurl" class="class_input" id="linkurl" /></td>
		</tr>
		<tr>
			<td height="35" align="right">关键词：</td>
			<td><input type="text" name="keywords" class="class_input" id="keywords" />
				<span class="cnote">多关键词之间用空格或者“,”隔开</span></td>
		</tr>
		<tr>
			<td height="104" align="right">摘　要：</td>
			<td><textarea name="description" id="description" class="class_areadesc"></textarea>
				<div class="maxtxtlen"> 最多能输入 <strong>255</strong> 个字符 </div></td>
		</tr>
		<tr>
			<td height="340" align="right">详细内容：</td>
			<td><textarea name="content" id="content" class="kindeditor"></textarea>
				<script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="content"]', {allowFileManager : true,width:'667px',height:'280px'});
				});
				</script>
				<div class="features">
					<input type="checkbox" name="remote" id="remote" value="true" />
					下载远程图片和资源
					&nbsp;
					<input type="checkbox" name="autothumb" id="autothumb" value="true" />
					提取第一个图片为缩略图
					&nbsp;
					<input type="checkbox" name="autodesc" id="autodesc" value="true" />
					提取
					<input type="text" name="autodescsize" id="autodescsize" value="200" size="3" class="input_gray_short" />
					字到摘要
					&nbsp;
					<input type="checkbox" name="autopage" id="autopage" value="true" />
					自动分页
					<input type="text" name="autopagesize" id="autopagesize" value="5" size="6" class="input_gray_short" />
					KB</div></td>
		</tr>
		<tr class="nb">
			<td height="124" align="right">组　图：</td>
			<td><fieldset class="picarr">
					<legend>列表</legend>
					<div>最多可以上传<strong>50</strong>张图片<span onclick="GetUploadify('uploadify2','组图上传','image','image',50,<?php echo $cfg_max_file_size; ?>,'picarr','picarr_area')">开始上传</span></div>
					<ul id="picarr_area">
					</ul>
				</fieldset></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"> </div></td>
		</tr>
		<tr>
			<td height="35" align="right">点击次数：</td>
			<td><input type="text" name="hits" id="hits" class="input_short" value="<?php echo mt_rand(50, 200); ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" class="input_short" value="<?php echo GetOrderID('#@__infolist'); ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">更新时间：</td>
			<td><input name="posttime" type="text" id="posttime" class="input_short" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript">
				date = new Date();
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkinfo" value="true" checked="checked"  />
				是 &nbsp;
				<input type="radio" name="checkinfo" value="false" />
				否<span class="cnote">选择“否”则该信息暂时不显示在前台</span></td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="action" id="action" value="add" />
		<input type="hidden" name="tid" id="tid" value="<?php echo ($tid = isset($tid) ? $tid : ''); ?>" />
	</div>
</form>
</body>
</html>