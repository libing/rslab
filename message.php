<?php
require_once(dirname(__FILE__).'/include/config.inc.php');


//留言内容处理
if(isset($action) and $action=='add')
{
	if(empty($nickname))
	{
		ShowMsg('昵称不能为空！','message.php');
		exit();
	}
	
	if(empty($content))
	{
		ShowMsg('内容不能为空！','message.php');
		exit();
	}


	$r = $dosql->GetOne("SELECT Max(orderid) AS orderid FROM `#@__message`");
	$orderid  = (empty($r['orderid']) ? 1 : ($r['orderid'] + 1));
	$nickname = htmlspecialchars($nickname);
	$contact  = htmlspecialchars($contact);
	$content  = htmlspecialchars($content);
	$posttime = GetMkTime(time());
	$ip       = gethostbyname($_SERVER['REMOTE_ADDR']);


	$sql = "INSERT INTO `#@__message` (siteid, nickname, contact, content, orderid, posttime, htop, rtop, checkinfo, ip) VALUES (1, '$nickname', '$contact', '$content', '$orderid', '$posttime', '', '', 'false', '$ip')";
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('留言成功，感谢您的支持！','message.php');
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?> - 客户留言</title>
<meta name="generator" content="<?php echo $cfg_generator; ?>" />
<meta name="author" content="<?php echo $cfg_author; ?>" />
<meta name="keywords" content="<?php echo $cfg_keyword; ?>" />
<meta name="description" content="<?php echo $cfg_description; ?>" />
<link href="templates/default/style/webstyle.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="templates/default/js/jquery.min.js"></script>
<script type="text/javascript">
function cfm_msg()
{
	if($("#nickname").val() == "")
	{
		alert("请填写昵称！");
		$("#nickname").focus();
		return false;
	}
	if($("#content").val() == "")
	{
		alert("请填写留言内容！");
		$("#content").focus();
		return false;
	}
	$("#form").submit();
}
</script>
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
		<div class="subTitle"> <span>您当前所在位置：<a href="<?php echo $gourl; ?>">首页</a> &gt;&gt; <strong>客户留言</strong></span>
			<div class="cl"></div>
		</div>
		<div class="subCont">
			<div class="message_warp">
				<div class="message_bg">
					<div class="message_wz">我们热忱接受您的意见和建议</div>
					<form name="form" id="form" method="post" action="">
						<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="80" height="60" align="right" class="message_labes">联系方式：&nbsp;</td>
								<td><input name="contact" type="text" id="contact" class="message_input" /></td>
							</tr>
							<tr>
								<td height="116" align="right" class="message_labes">内　　容：&nbsp;</td>
								<td><textarea name="content" class="message_input" style="height:100px;overflow:auto;" id="content" ></textarea></td>
							</tr>
							<tr>
								<td colspan="2"><div class="msg_btn_area"> <a href="javascript:void(0);" onclick="cfm_msg();return false;">提　交</a> &nbsp; <a href="<?php echo $gourl; ?>">返　回</a>
									</div></td>
							</tr>
						</table>
						<input type="hidden" name="action" id="action" value="add" />
						<?php
						if(!empty($_COOKIE['username']))
						{
							$nickname = AuthCode($_COOKIE['username']);
						}
						else
						{
							$nickname = '游客';
						}
						?>
						<input type="hidden" name="nickname" id="nickname" value="<?php echo $nickname; ?>" />
					</form>
				</div>
				<?php
				$dopage->GetPage("SELECT * FROM `#@__message` WHERE checkinfo=true ORDER BY orderid DESC",10);
				$i = $dosql->GetTotalRow();
				while($row = $dosql->GetArray())
				{
				?>
				<div class="message_block">
					<div class="message_title">
						<h2><?php echo $row['nickname']; ?></h2>
						<span><?php echo $i; ?>#</span></div>
					<p><?php echo $row['content']; ?></p>
					<?php
					if($row['recont'] != '')
					{
					?>
					<div class="message_replay"><strong>回复：</strong><?php echo $row['recont']; ?></div>
					<?php
					}
					?>
					<div class="message_info"><?php echo GetDateTime($row['posttime']); ?> / <?php echo $row['ip']; ?></div>
				</div>
				<?php
					$i--;
				}
				echo $dopage->GetList();
				?>
			</div>
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