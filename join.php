<?php require_once(dirname(__FILE__).'/include/config.inc.php'); ?>
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
<div class="notice"><strong>网站公告：</strong> <?php echo Info(1); ?> </div>
<!-- /notice-->
<!-- mainbody-->
<div class="subBody">
	<div class="OneOfTwo">
		<?php require_once('lefter.php'); ?>
	</div>
	<div class="TwoOfTwo">
		<?php
		if($cfg_isreurl!='Y') $gourl = 'index.php';
		else $gourl = 'index.html';
		?>
		<div class="subTitle"> <span>您当前所在位置：<a href="<?php echo $gourl; ?>">首页</a> &gt;&gt; <strong>人才招聘</strong></span>
			<div class="cl"></div>
		</div>
		<div class="subCont">
			<div class="news_list">
				<ul>
					<?php
					$dopage->GetPage("SELECT * FROM `#@__job` WHERE checkinfo=true ORDER BY orderid DESC",10);
					while($row = $dosql->GetArray())
					{
						if($cfg_isreurl!='Y') $gourl = 'joinshow.php?id='.$row['id'];
						else $gourl = 'joinshow-'.$row['id'].'.html';
						
					?>
					<li><span>[<?php echo GetDateMk($row['posttime']); ?>]</span><strong>&gt;&gt;</strong><a href="<?php echo $gourl; ?>"><?php echo $row['title']; ?></a></li>
					<?php
					}
					?>
				</ul>
			</div>
			<?php echo $dopage->GetList(); ?> </div>
	</div>
	<div class="cl"></div>
</div>
<!-- /mainbody-->
<!-- footer-->
<?php require_once('footer.php'); ?>
<!-- /footer-->
</body>
</html>