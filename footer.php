<!-- Footer Part Start -->
            <DIV class=footer-bg>
                <DIV class=repeat-bg-3>
                    <DIV class=main-wrapper>
                        <DIV class="cm-fl bot-left">
                            <DIV class="cm-fl feed-part">
                                <DIV class=cm-fl>
                                    <IMG title="I LOVE RSLAB" alt="" src="templates/rslab/images/rslab.jpg" width="100" height="38"></DIV>
                                <DIV class="cm-fl bot-feed"><!-- ---------------------Social media ---------------------  -->
                                </DIV></DIV>
                            <DIV class=s-detail>
                                <H2><STRONG>友情链接</STRONG></H2>
                                <P>
                                    <?php
                                        $dosql->Execute("SELECT * FROM `#@__weblink` WHERE classid=1 AND checkinfo=true ORDER BY orderid,id DESC");
                                        while($row = $dosql->GetArray())
                                        {

                                            echo '<a href="'.$row['linkurl'].'" target="_blank">'.$row['webname'].'</a>&nbsp;&nbsp;';

                                        }
                                    ?>
    
                                </P></DIV></DIV>
                        <DIV class=bot-right>
                            <DIV class=cm-fl>

                                <DIV class="cm-fl bot-box2">
                                    <DIV class="cm-fl bot-img">
                                        <A title="联系我们" href="product.php?cid=21"><IMG title=联系我们 alt=""  src="templates/rslab/images/img-8.jpg" width="142" height="59"></A></DIV>
                                    <DIV class=cm-btn-1>
                                        <A title="联系我们" href="product.php?cid=21"><SPAN>联系我们</SPAN></A> 
                                    </DIV></DIV>
                            </DIV>
                        </DIV>
                        <!--友情链接-->
                        <DIV class="cm-fl footer-bar">
                        </DIV>
                        <!--友情链接-->
                    </DIV></DIV></DIV>
            <!-- Footer Part End -->
        </DIV></DIV>
    <!-- Here is google analtics code -->
</BODY></HTML>