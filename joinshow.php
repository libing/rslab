<?php
require_once(dirname(__FILE__).'/include/config.inc.php');

//初始化参数检测正确性
$id = intval($id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?> - 人才招聘</title>
<meta name="generator" content="<?php echo $cfg_generator; ?>" />
<meta name="author" content="<?php echo $cfg_author; ?>" />
<meta name="keywords" content="<?php echo $cfg_keyword; ?>" />
<meta name="description" content="<?php echo $cfg_description; ?>" />
<link href="templates/default/style/webstyle.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="templates/default/js/jquery.min.js"></script>
</head>
<body>
<!-- header-->
<?php require_once('header.php'); ?>
<!-- /header-->
<!-- banner-->
<div class="subBanner"> <img src="templates/default/images/banner-ir.png" /> </div>
<!-- /banner-->
<!-- notice-->
<div class="notice"><strong>网站公告：</strong><?php echo Info(1); ?></div>
<!-- /notice-->
<!-- mainbody-->
<div class="subBody">
	<div class="OneOfTwo">
		<?php require_once('lefter.php'); ?>
	</div>
	<?php
	if($cfg_isreurl!='Y') $gourl = 'index.php';
	else $gourl = 'index.html';
	?>
	<div class="TwoOfTwo">
		<div class="subTitle"> <a href="javascript:history.go(-1);" class="goback">&gt;&gt; 返回</a> <span>您当前所在位置：<a href="<?php echo $gourl; ?>">首页</a> &gt;&gt; 人才招聘 &gt;&gt; <strong>详细内容</strong></span>
			<div class="cl"></div>
		</div>
		<div class="jobConts">
			<?php

			$row = $dosql->GetOne("SELECT * FROM `#@__job` WHERE id=$id");
			if(@$row)
			{
			?>
			<strong>职位名称：</strong><br />
			<span style="font-size:14px;"><?php echo $row['title']; ?></span>
			<table width="593" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="25%" height="25"><strong>工作地点：</strong></td>
					<td width="25%"><strong>工作性质：</strong></td>
					<td width="25%"><strong>招聘人数：</strong></td>
					<td width="25%"><strong>性别要求：</strong></td>
				</tr>
				<tr>
					<td height="25"><?php echo $row['jobplace']; ?></td>
					<td><?php echo $row['jobdescription']; ?></td>
					<td><?php echo $row['employ']; ?></td>
					<td><?php if($row['jobsex']==0){echo '不限制';}else if($row['jobsex']==1){echo '男';}else if($row['jobsex']==2){echo '女';} ?></td>
				</tr>
				<tr>
					<td width="25%" height="25"><strong>工资待遇：</strong></td>
					<td width="25%"><strong>有效期限：</strong></td>
					<td width="25%"><strong>工作经验：</strong></td>
					<td width="25%"><strong>学历要求：</strong></td>
				</tr>
				<tr>
					<td height="25"><?php echo $row['treatment']; ?></td>
					<td><?php echo $row['usefullife']; ?></td>
					<td><?php echo $row['experience']; ?></td>
					<td><?php echo $row['education']; ?></td>
				</tr>
				<tr>
					<td width="25%" height="25"><strong>语言能力：</strong></td>
					<td width="25%"></td>
					<td width="25%"></td>
					<td width="25%"></td>
				</tr>
				<tr>
					<td height="25"><?php echo $row['joblang']; ?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<strong>职位要求：</strong>
			<div class="jobdesc"><?php echo $row['content']; ?></div>
			<?php
			}
			?>
		</div>
	</div>
	<div class="cl"></div>
</div>
<!-- /mainbody-->
<!-- footer-->
<?php require_once('footer.php'); ?>
<!-- /footer-->
</body>
</html>