<?php	require(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".notewarn").fadeIn();
	$(".notewarn .close a").click(function(){
		$(".notewarn").fadeOut();
	});
	
	$("#showad").html('<iframe src="showad.php" width="100%" height="25" scrolling="no" frameborder="0" allowtransparency="true"></iframe>');
});
</script>
</head>
<body>
<div class="home_header">
		<div class="refurbish"><span class="title">官方公告</span><span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
		<div class="home_info">
				<div id="showad">
				</div>
		</div>
</div>
<ul class="home_content">
		<li>服务器名： <?php echo $_SERVER['SERVER_NAME']; ?> </li>
		<li>ODBC数据库： <?php echo showResult(function_exists('odbc_close')); ?> </li>
		<li>服务器IP： <?php echo gethostbyname($_SERVER['SERVER_NAME']); ?> </li>
		<li>Socket支持： <?php echo showResult(function_exists('socket_accept')); ?> </li>
		<li>服务器端口： <?php echo $_SERVER['SERVER_PORT']; ?> </li>
		<li>GD Library： <?php echo showResult(function_exists('imageline')); ?> </li>
		<li><span style="border-bottom:none;">服务器系统： <?php echo PHP_OS; ?></span></li>
		<li>XML解析： <?php echo showResult(function_exists('xml_set_object')); ?> </li>
		<li> 服务器版本： <?php echo ReStrLen($_SERVER['SERVER_SOFTWARE'],12); ?></li>
		<li>FTP登陆： <?php echo showResult(function_exists('ftp_login')); ?> </li>
		<li>PHP&amp;MySQL版本： <?php echo PHP_VERSION; ?>&amp;<?php echo $dosql->GetVersion(); ?></li>
		<li>PDF支持： <?php echo showResult(function_exists('pdf_close')); ?> </li>
		<li>POST提交内容限制： <?php echo get_cfg_var('post_max_size'); ?></li>
		<li>显示错误信息： <?php echo showResult(get_cfg_var('display_errors')); ?> </li>
		<li>脚本超时时间： <?php echo get_cfg_var('max_execution_time').'秒';; ?></li>
		<li>使用URL打开文件： <?php echo showResult(get_cfg_var('allow_url_fopen')); ?> </li>
		<li>脚本上传文件大小限制： <?php echo get_cfg_var('upload_max_filesize')?get_cfg_var('upload_max_filesize'):'不允许上传附件'; ?></li>
		<li>压缩文件支持(Zlib)： <?php echo showResult(function_exists('gzclose')); ?> </li>
		<li style="border-bottom:none;">脚本运行时可占最大内存： <?php echo get_cfg_var('memory_limit')?get_cfg_var('memory_limit'):'无'; ?></li>
		<li style="border-bottom:none;">ZEND支持： <?php echo showResult(function_exists('zend_version')); ?> </li>
</ul>
<div class="cl"></div>
<?php
function showResult($v)
{
	if($v == 1) echo'<span class="ture">支持</span>';
	else echo'<span class="flase">不支持</span>';
}
?>
<div class="notewarn"> <span class="close"><a href="javascript:;"></a></span>
		<div>显示分辨率 1360*768 显示效果最佳，建议使用新版浏览器；敬请您将在使用中发现的问题或者不适提交给我们，以便改进 <a href="http://phpmywind.com/bbs/" target="_blank" class="text">点击提交反馈</a></div>
</div>
</div>
</body>
</html>