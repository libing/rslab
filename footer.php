<!-- weblink-->

<div class="weblink">
	<?php
	$dosql->Execute("SELECT * FROM `#@__weblink` WHERE classid=1 AND checkinfo=true ORDER BY orderid,id DESC");
	while($row = $dosql->GetArray())
	{
	?>
	<a href="<?php echo $row['linkurl']; ?>" target="_blank"><?php echo $row['webname']; ?></a>
	<?php
	}
	?>
</div>
<!-- /weblink-->
<!-- footer-->
<div class="footer"><?php echo $cfg_copyright.$cfg_countcode; ?><br />网站采用 <a href="http://phpmywind.com" target="_blank">PHPMyWind</a> 核心</div>
<!-- /footer-->
<div class="contmsg">
	<div class="msgtxt">测试数据内容均来自互联网，若涉及侵权，请联系我们删除。</div>
</div>
<script type="text/javascript">
$(function(){
	$(".contmsg").hover(
		function(){$(".msgtxt").fadeIn(300);},
		function(){$(".msgtxt").fadeOut(0);}
	);		   
});
</script>
<?php echo GetQQ(); ?>