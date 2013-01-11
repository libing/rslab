<?php 
include_once (dirname(__FILE__).'/include/config.inc.php');
include_once ('header.php'); 

$dosql->Execute("SELECT `id`,`classid`,`title`,`linkurl`,`picurl`,`abstract_cn`,`abstract_en`,`flash_url` FROM `#@__infoimg` WHERE  `flag` = 'c' AND delstate='' AND checkinfo=true ORDER BY orderid ASC");
$return_top = array();
while($row = $dosql->GetArray()){
    $return_top[$row['classid']] = $row;//只保存最新的classid的推荐数据
    if($row['linkurl']=='' and $cfg_isreurl!='Y'){
        $return_top[$row['classid']]['gourl'] = 'productshow.php?cid='.$row['classid'].'&id='.$row['id'];
    }else if($cfg_isreurl=='Y'){
        $return_top[$row['classid']]['gourl']  = 'productshow-'.$row['classid'].'-'.$row['id'].'-1.html';
    }else{
        $return_top[$row['classid']]['gourl']  = $row['linkurl'];
    }
}

?>
<!-- Banner Wrapper Start -->
<DIV style="BACKGROUND: none transparent scroll repeat 0% 0%" class=main_slider>
   <div id="slideplay">
   <ul>
           <?php
           $dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=12 AND delstate='' AND checkinfo=true ORDER BY orderid DESC LIMIT 0,6");
           while($row = $dosql->GetArray())
           {
                   if($row['linkurl'] != '')$gourl = $row['linkurl'];
                   else $gourl = 'javascript:;';
           ?>
           <li><a href="<?php echo $gourl; ?>"><img src="<?php echo $row['picurl']; ?>" alt="<?php echo $row['title']; ?>" /></a></li>
           <?php
           }
           ?>
   </ul>
   </div>
</DIV>
<!-- Banner Wrapper End -->
<!-- Middle Wrapper Start -->
<DIV class=repeat-bg-1>
    <DIV style="Z-INDEX: 9999; POSITION: relative" class=main-wrapper>
        <DIV class="cm-fl cm-div">
            <DIV class="cm-fl box-1">
                <H4 class=lab><A href="product.php?cid=14">运动服务实验室 RSLab</A></H4>
                <DIV class="cm-fl d-box1 img-1" style="height:330px;">
                    <embed src="<?php echo $return_top['14']['flash_url']; ?>" quality="high" width="310" height="330" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>
                </DIV>
            </DIV>
            
            <DIV class="cm-fl box-1">
                <H4 class=shop><A title=SHOP href="product.php?cid=19">冠军体验服务 Champion Service</A></H4>
                <DIV class="cm-fl d-box1 img-1">
                    <A href="<?php echo $return_top['19']['gourl']; ?>">
                        <IMG title=<?php echo $return_top['19']['title']; ?> border=0 alt="" width="313" height="183" src="<?php echo $return_top['19']['picurl']; ?>">
                    </A> 
                    <SPAN style="COLOR: #00b0f5" class=title>&nbsp;<?php echo ReStrLen($return_top['19']['title'],5); ?></A></SPAN><BR>
                    <SPAN>
                        <div style="float: left;width:100%;height:70px;margin-top:5px;"><?php echo ReStrLen($return_top['19']['abstract_cn'],70); ?> </div>
                     <HR>
                     <?php echo ReStrLen($return_top['19']['abstract_en'],70); ?> 
                    </SPAN>
                </DIV>
            </DIV>
            
            <DIV class="cm-fl box-2">
                <H4 class=pro><A title="RSLAB PRO" href="product.php?cid=21">专家咨询 Expert Adviser</A></H4>
                <DIV class="cm-fl d-box1 img-1">
                    <A href="<?php echo $return_top['21']['gourl']; ?>">
                        <IMG title=<?php echo $return_top['21']['title']; ?> border=0 alt="" width="313" height="183" src="<?php echo $return_top['21']['picurl']; ?>">
                    </A> 
                    <SPAN style="COLOR: #00b0f5" class=title>&nbsp;<?php echo ReStrLen($return_top['21']['title'],5); ?></A></SPAN><BR>
                    <SPAN>
                        <div style="float: left;width:100%;height:70px;margin-top:5px;"><?php echo ReStrLen($return_top['21']['abstract_cn'],70); ?> </div>
                     <HR>
                     <?php echo ReStrLen($return_top['21']['abstract_en'],70); ?> 
                    </SPAN>
                </DIV>
            </DIV>

        </DIV>
    </DIV>
</DIV>
<DIV class=border-1></DIV>
<!--图片滚动-->
<div id=demo style="overflow:hidden;width:1050px; margin:auto; background:url(templates/rslab/images/repeat-bg-2.png) center">
    <table  align=center cellpadding=0 cellspacing=0 cellspace=0  style="border:0px; width:1050px;">
        <tr><td valign=top  id=marquePic1>
                <table width='100%'  cellpadding=3 cellspacing=3  border="0">
                    <tr>
                    <?php
                        $sql = "SELECT `linkurl`,`picurl`,`title` FROM `#@__infoimg` WHERE (classid='20' OR parentstr LIKE '%,20,%') AND delstate='' AND checkinfo=true ORDER BY orderid DESC";
                        $dopage->GetPage($sql,30);
                        $roll = array();
                        while($row = $dosql->GetArray()){
                            echo '<td align=center width="190"class="gundong"><a style="COLOR: #c00032;" href="'.$row['linkurl'].'"><img src="'.$row['picurl'].'" width=180 height=120 border=0/><br><br>'.$row['title'].'</a></td>';
                        }
                    ?>
                    </tr></table>
            </td><td id=marquePic2 valign=top></td></tr>
    </table></div>
<script type="text/javascript"> 
    var speed=50 
    marquePic2.innerHTML=marquePic1.innerHTML 
    function Marquee(){ 
        if(demo.scrollLeft>=marquePic1.scrollWidth){ 
            demo.scrollLeft=0 
        }else{ 
            demo.scrollLeft++ 
        } 
    } 
    var MyMar=setInterval(Marquee,speed) 
    demo.onmouseover=function() {clearInterval(MyMar)} 
    demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)} 
</script>
<!--图片滚动-->
<DIV class=repeat-bg-2>
    <DIV class=main-wrapper>
        <DIV class="cm-fl box-1">
            <H4>装备测评 Gear evulation</H4>
            <DIV class="cm-fl d-box1 img-4 left-attribut" style="height:330px;">
                <embed src="<?php echo $return_top['16']['flash_url']; ?>" quality="high" width="310" height="330" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>
            </DIV>
        </DIV>
        <DIV class="cm-fl box-1">
            <H4 class=shop><A title=SHOP href="product.php?cid=16">装备指导 Guidance</A></H4>
            <DIV class="cm-fl d-box1 img-1">
                <A href="<?php echo $return_top['16']['gourl']; ?>">
                    <IMG title=<?php echo $return_top['16']['title']; ?> border=0 alt="" width="313" height="183" src="<?php echo $return_top['16']['picurl']; ?>">
                </A> 
                <SPAN style="COLOR: #00b0f5" class=title>&nbsp;<?php echo ReStrLen($return_top['16']['title'],5); ?></A></SPAN><BR>
                <SPAN>
                    <div style="float: left;width:100%;height:70px;margin-top:5px;"><?php echo ReStrLen($return_top['16']['abstract_cn'],70); ?> </div>
                 <HR>
                 <?php echo ReStrLen($return_top['16']['abstract_en'],70); ?> 
                </SPAN>
            </DIV>
        </DIV>
        
        <DIV class="cm-fl box-2">
            <H4 class=pro><A title="RSLAB PRO" href="product.php?cid=17">足部保护 Protect</A></H4>
            <DIV class="cm-fl d-box1 img-1">
                <A href="<?php echo $return_top['17']['gourl']; ?>">
                    <IMG title=<?php echo $return_top['17']['title']; ?> border=0 alt="" width="313" height="183" src="<?php echo $return_top['17']['picurl']; ?>">
                </A> 
                <SPAN style="COLOR: #00b0f5" class=title>&nbsp;<?php echo ReStrLen($return_top['17']['title'],5); ?></A></SPAN><BR>
                <SPAN>
                    <div style="float: left;width:100%;height:70px;margin-top:5px;"><?php echo ReStrLen($return_top['17']['abstract_cn'],70); ?> </div>
                 <HR>
                 <?php echo ReStrLen($return_top['17']['abstract_en'],70); ?> 
                </SPAN>
            </DIV>
        </DIV>
    </DIV>
</DIV>
<!-- Middle Wrapper End -->
<?php require_once('footer.php'); ?>