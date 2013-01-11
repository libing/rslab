<?php 
include_once (dirname(__FILE__).'/include/config.inc.php');
include_once ('header.php'); 
//初始化参数检测正确性
if(empty($cid)) $cid = 5;
$cid = intval($cid);
$id  = intval($id);

$row = $dosql->GetOne("SELECT `picurl` FROM `#@__infoclass` WHERE id=$cid");
if(!empty($row['picurl'])){
    $top_img = $row['picurl'];
}  else {
    $top_img = 'templates/rslab/images/rslab-labo.jpg';
}

//留言内容处理
if(isset($action) and $action=='add')
{
	if(empty($txtName))
	{
		ShowMsg('昵称不能为空！',"productshow.php?cid=$cid&id=$id");
		exit();
	}
	
	if(empty($txtAreaVraag))
	{
		ShowMsg('内容不能为空！',"productshow.php?cid=$cid&id=$id");
		exit();
	}


	$r = $dosql->GetOne("SELECT Max(orderid) AS orderid FROM `#@__message`");
	$orderid  = (empty($r['orderid']) ? 1 : ($r['orderid'] + 1));
	$nickname = htmlspecialchars($txtName);
	$contact  = htmlspecialchars($txtTel);
        $email  = htmlspecialchars($txtEmail);
	$content  = htmlspecialchars($txtAreaVraag);
	$posttime = GetMkTime(time());
	$ip       = gethostbyname($_SERVER['REMOTE_ADDR']);


	$sql = "INSERT INTO `#@__message` (siteid, nickname, contact, email,content, orderid, posttime, htop, rtop, checkinfo, ip) VALUES (1, '$nickname', '$contact','$email', '$content', '$orderid', '$posttime', '', '', 'false', '$ip')";
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('留言成功，感谢您的支持！',"productshow.php?cid=$cid&id=$id");
		exit();
	}
}

?>
<!-- Banner Wrapper Start -->
<DIV class=banner-part-lab-1  style="background:url(<?php echo $top_img;?>) center top no-repeat;"></DIV><!-- Banner Wrapper End --><!-- Middle Wrapper Start -->
<DIV class=repeat-bg-1>
    <DIV style="POSITION: relative" class=main-wrapper>
        
        <DIV class="cm-fl quotes">
            <DIV class="cm-fl q-no"></DIV>
            <DIV class="cm-fl q-text"><span>您当前所在位置：<?php echo GetPosStr($cid,1); ?></span></DIV>
        </DIV>

        <DIV class="cm-fl cm-div-1">
            <?php


            $row = $dosql->GetOne("SELECT * FROM `#@__infoimg` WHERE id=$id");
            
            echo "<H1 style='text-align:center;'><b><SPAN>{$row['title']}</SPAN></b></H1>";
            if($row['content'] != ''){
                echo "<P>".GetContPage($row['content'])."</P>";
            }else{
                echo '<P>网站资料更新中...</P>';
            }
            ?>

        </DIV>
        <DIV class=clear-both></DIV>
        
        <?php
        if($cid==21){
        ?>
        <div class="clear-both"></div>
        <div class="cm-fl left-part-4">
            <h3>您的咨询</h3><br>
            <div>
                <table border="0" cellspacing="0" cellpadding="0" align="left"></table>
                <div class="clear-both"></div>
            </div>
            <form method="post" id="contact_form" name="contact_form" onsubmit="return check_msg();">
            <div style="WIDTH: 325px" class="cm-fl form-bg">
                
                    <input onblur="if(this.value=='') this.value='名字'" id="txtName" onfocus="if(this.value =='名字') this.value=''" value="名字" type="text" name="txtName" id="txtName"> 
                    <input onblur="if(this.value=='') this.value='联系方式'" id="txtTel" onfocus="if(this.value == '联系方式') this.value=''" value="联系方式" type="text" name="txtTel" id="txtTel"> 
                    <input onblur="if(this.value=='') this.value='邮箱'" id="txtEmail" onfocus="if(this.value == '邮箱') this.value=''" value="邮箱" type="text" name="txtEmail" id="txtEmail"> 
                
            </div>
            <div class="cm-fl form-bg">
                <textarea rows="5" onblur="if(this.value=='') this.value='留言内容'" onfocus="if(this.value =='留言内容' ) this.value=''" name="txtAreaVraag" id="txtAreaVraag">留言内容</textarea> 
                <div class="cm-fr">
                    <div class="cm-btn-6"><input type="hidden" name="action" id="action" value="add" /><span><input value="留言" type="submit" name="submit"></span> 
                    </div>
                </div>
            </div>
            </form>
        </div>
        <?php
        }
        ?>
    </DIV>
    
</DIV>
<!-- Middle Wrapper End -->
<?php require_once('footer.php'); ?>