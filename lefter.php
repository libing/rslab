<ul class="subnav">
	<?php echo GetNav(2); ?>
</ul>
<script type="text/javascript">
var href = window.location.href.split('/')[window.location.href.split('/').length-1].substr(0,4);
if(href.length>0){
	$(document).ready(function(){$("ul.subnav li a[href^='"+href+"']").attr("class","on")});
}
</script>
<div class="follow"><a href="http://weibo.com/phpMyWind" class="sina" target="_blank">收听新浪微博</a><a href="http://t.qq.com/phpMyWind" class="tqq" target="_blank">收听腾讯微博</a></div>