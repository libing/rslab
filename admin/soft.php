<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片信息管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/listajax.js"></script>
<script type="text/javascript" src="templates/js/loadimage.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body onload="GetList('soft','<?php echo ($tid = isset($tid) ? $tid : ''); ?>','<?php echo $cfg_curmode; ?>')">
<div class="mgr_header"> <span class="title">软件列表管理</span>
		<?php 
		if($cfg_curmode != 'small')
		{
		?>
		<div class="alltype" onmouseover="ShowAllType();" onmouseout="HideAllType();">
				<a href="javascript:;" onclick="GetType('','查看全部')" class="btn">查看全部</a>
				<span><?php GetMgrType2('#@__infoclass',3); ?></span>
		</div>
		<?php
		}
		?>
		<span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<!--/header end-->
<form name="form" id="form" method="post">
		<div id="list_area">
				<div class="loading"><img src="templates/images/loading.gif" />读取列表中...</div>
		</div>
</form>
<!--/list end-->
</body>
</html>