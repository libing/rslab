<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改软件信息</title>
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
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__soft` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改软件信息</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="soft_save.php" onsubmit="return cfm_infolm();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属栏目：</td>
			<td width="75%"><select name="classid" id="classid">
					<option value="-1">请选择所属栏目</option>
					<?php CategoryType(3); ?>
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
					<?php GetAllType('#@__maintype','#@__soft','mainid'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td height="35" align="right">标　题：</td>
			<td><script src="../data/plugin/colorpicker/colorpicker.js" type="text/javascript"></script>
				<input name="title" type="text" id="title" class="input_title" value="<?php echo $row['title']; ?>" <?php echo 'style="color:'.$row['colorval'].';font-weight:'.$row['boldval'].';"'; ?> />
				<span class="maroon">*</span> 
				<script src="../data/plugin/colorpicker/colorpicker.js" type="text/javascript"></script>
				<div class="title_panel">
					<input type="hidden" name="colorval" id="colorval" value="<?php echo $row['colorval']; ?>" />
					<input type="hidden" name="boldval" id="boldval" value="<?php echo $row['boldval']; ?>" />
					<span onclick="colorpicker('colorpanel','colorval','title');" class="color" title="标题颜色"> </span> <span id="colorpanel"></span> <span onclick="blodpicker('boldval','title');" class="blod" title="标题加粗"> </span> <span onclick="clearpicker()" class="clear" title="清除属性">[#]</span> &nbsp; </div></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">属　性：</td>
			<td class="attrArea"><?php
			$flagarr = explode(',',$row['flag']);

			$dosql->Execute("SELECT * FROM `#@__infoflag` ORDER BY orderid ASC");
			while($r = $dosql->GetArray())
			{
				echo '<span><input type="checkbox" name="flag[]" id="flag[]" value="'.$r['flag'].'"';

				if(in_array($r['flag'],$flagarr))
				{
					echo 'checked="checked"';
				}

				echo ' />'.$r['flagname'].'['.$r['flag'].']</span>';
			}
			?></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"> </div></td>
		</tr>
		<?php
		GetDiyField('3',$row);
		?>
		<tr>
			<td height="35" align="right">文件类型：</td>
			<td><select name="filetype" id="filetype">
					<?php
				foreach(array('0'=>'.exe','1'=>'.zip','2'=>'.rar','3'=>'.iso','4'=>'.gz','5'=>'.其它') as $k=>$v)
				{
					if($row['filetype'] == $v)
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}
					echo "<option value=\"$v\" $selected>$v</option>";
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">软件类型：</td>
			<td><select name="softtype" id="softtype">
					<?php
				foreach(array('0'=>'国产软件','1'=>'国外软件','2'=>'汉化补丁') as $k=>$v)
				{
					if($row['softtype'] == $v)
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}
					echo "<option value=\"$v\" $selected>$v</option>";
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">界面语言：</td>
			<td><select name="language" id="language">
					<?php
				foreach(array('0'=>'简体中文','1'=>'英文软件','2'=>'繁体中文','3'=>'其它类型') as $k=>$v)
				{
					if($row['language'] == $v)
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}
					echo "<option value=\"$v\" $selected>$v</option>";
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">授权方式：</td>
			<td><select name="accredit" id="accredit">
					<?php
				foreach(array('0'=>'共享软件','1'=>'免费软件','2'=>'开源软件','3'=>'商业软件','4'=>'破解软件','5'=>'游戏外挂') as $k=>$v)
				{
					if($row['accredit'] == $v)
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}
					echo "<option value=\"$v\" $selected>$v</option>";
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">软件大小：</td>
			<td><input type="text" name="softsize" id="softsize" value="<?php echo $row['softsize']; ?>" class="input_short" />
				<select name="unit" id="unit">
					<?php
				foreach(array('0'=>'MB','1'=>'KB','2'=>'GB') as $k=>$v)
				{
					if($row['unit'] == $v)
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = '';
					}
					echo "<option value=\"$v\" $selected>$v</option>";
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">运行环境：</td>
			<td><input type="text" name="runos" id="runos" value="<?php echo $row['runos']; ?>" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">官方网站：</td>
			<td><input type="text" name="website" id="website" value="<?php echo $row['website']; ?>" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">演示地址：</td>
			<td><input type="text" name="demourl" id="demourl" value="<?php echo $row['demourl']; ?>" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">下载地址：</td>
			<td><input type="text" name="dlurl" id="dlurl" value="<?php echo $row['dlurl']; ?>" class="class_input" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','软件上传','soft','soft',1,<?php echo $cfg_max_file_size; ?>0,'dlurl')">上 传</span> </span></td>
		</tr>
		<tr>
			<td height="35" align="right">来源作者：</td>
			<td><input name="author" type="text" id="author" value="<?php echo $row['author']; ?>" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">缩略图片：</td>
			<td><input name="picurl" type="text" id="picurl" value="<?php echo $row['picurl']; ?>" class="class_input" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span><span class="reimg">
				<input type="checkbox" name="rempic" id="rempic" value="true" />
				远程</span> <span class="cutimg"><a href="javascript:;" onclick="GetJcrop('jcrop','picurl');return false;">裁剪</a></span> </span></td>
		</tr>
		<tr>
			<td height="35" align="right">跳转链接：</td>
			<td><input name="linkurl" type="text" id="linkurl" value="<?php echo $row['linkurl']; ?>" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">关键词：</td>
			<td><input name="keywords" type="text" id="keywords" value="<?php echo $row['keywords']; ?>" class="class_input" />
				<span class="cnote">多关键词之间用空格或者“,”隔开</span></td>
		</tr>
		<tr>
			<td height="104" align="right">摘　要：</td>
			<td><textarea name="description" class="class_areadesc" id="description"><?php echo $row['description']; ?></textarea>
				<div class="maxtxtlen"> 最多能输入 <strong>255</strong> 个字符 </div></td>
		</tr>
		<tr class="nb">
			<td height="340" align="right">详细内容：</td>
			<td><textarea name="content" id="content" class="kindeditor"><?php echo $row['content']; ?></textarea>
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
					<?php
					if($row['picarr'] != '')
					{
						$picarr = explode(',', $row['picarr']);
						foreach($picarr as $v)
						{
							echo '<li rel="'.$v.'"><input type="text" name="picarr[]" value="'.$v.'"><a href="javascript:void(0);" onclick="ClearPicArr(\''.$v.'\')">删除</a></li>';
						}
					}
					?>
					</ul>
				</fieldset></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"> </div></td>
		</tr>
		<tr>
			<td height="35" align="right">点击次数：</td>
			<td><input name="hits" type="text" id="hits" class="input_short" value="<?php echo $row['hits']; ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input name="orderid" type="text" id="orderid" class="input_short" value="<?php echo $row['orderid']; ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">更新时间：</td>
			<td><input name="posttime" type="text" class="input_short" id="posttime" value="<?php echo GetDateTime($row['posttime']); ?>" readonly="readonly" />
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
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked'; ?> />
				是 &nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked'; ?> />
				否<span class="cnote">选择“否”则该信息暂时不显示在前台</span></td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input name="action" type="hidden" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="tid" id="tid" value="<?php echo ($tid = isset($tid) ? $tid : ''); ?>" />
	</div>
</form>
</body>
</html>