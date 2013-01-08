<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传新文件</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/mgr.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">上传新文件</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<div class="newupload">
		<iframe frameborder="0" src="upload_file_do.php" width="100%" height="65" scrolling="no"></iframe>
</div>
<div class="notewarn" id="notification">
		<span class="close"><a href="javascript:;" id="notification_close" onclick="HideDiv('notification');"></a></span>
		<div><strong>允许上传格式　</strong>图片格式：<?php echo $cfg_upload_img_type; ?>　软件类型：<?php echo $cfg_upload_soft_type; ?>　多媒体类型：<?php echo $cfg_upload_media_type; ?></div>
</div>
</body>
</html>