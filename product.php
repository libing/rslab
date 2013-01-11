<?php 
include_once (dirname(__FILE__).'/include/config.inc.php'); 
include_once ('header.php'); 
//初始化参数检测正确性
if(empty($cid)) $cid = 5;
$cid = intval($cid);
?>

<!-- Banner Wrapper Start -->
<DIV class=banner-part-lab-1></DIV><!-- Banner Wrapper End --><!-- Middle Wrapper Start -->

<DIV class=repeat-bg-1>
    <DIV style="Z-INDEX: 9999; POSITION: relative" class=main-wrapper>
        <DIV class="cm-fl cm-div">

            <?php
                if(!empty($keyword))
                {
                        $keyword = htmlspecialchars($keyword);

                        $sql = "SELECT * FROM `#@__infoimg` WHERE (classid=$cid OR parentstr LIKE '%,$cid,%') AND title LIKE '%$keyword%' AND delstate='' AND checkinfo=true ORDER BY orderid DESC";
                }
                else
                {
                        $sql = "SELECT * FROM `#@__infoimg` WHERE (classid=$cid OR parentstr LIKE '%,$cid,%') AND delstate='' AND checkinfo=true ORDER BY orderid DESC";
                }

                $dopage->GetPage($sql,9);
                while($row = $dosql->GetArray())
                {
                        if($row['picurl'] != ''){
                            $picurl = $row['picurl'];
                        }else{
                            $picurl = 'templates/images/nofoundpic.gif';
                        }

                        if($row['linkurl']=='' and $cfg_isreurl!='Y'){
                            $gourl = 'productshow.php?cid='.$row['classid'].'&id='.$row['id'];
                        }else if($cfg_isreurl=='Y'){
                            $gourl = 'productshow-'.$row['classid'].'-'.$row['id'].'-1.html';
                        }else{
                            $gourl = $row['linkurl'];
                        }

                ?>
                <DIV class="cm-fl box-1">
                    <DIV class="cm-fl d-box1 img-1">
                        <A href="<?php echo $gourl; ?>">
                            <IMG title=<?php echo $row['title']; ?> border=0 alt="" width="313" height="183" src="<?php echo $picurl; ?>">
                        </A> 
                        <SPAN style="COLOR: #00b0f5" class=title><?php echo ReStrLen($row['title'],10); ?></A></SPAN><BR>
                        <SPAN>
                        <?php echo $row['abstract_cn']; ?> 
                         <HR>
                         <?php echo $row['abstract_en']; ?> 
                        </SPAN><BR><BR><BR><BR><BR></DIV>
                </DIV>
                <?php
                }
                ?>

        </DIV>
    </DIV>
</DIV>


            <!-- Middle Wrapper End -->
<?php require_once('footer.php'); ?>