<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
    <HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo GetHeader(); ?>
    <LINK rel="SHORTCUT ICON" href="images/favicon.ico">
    <SCRIPT language=javascript type=text/javascript src="templates/rslab/js/jquery.min.js"></SCRIPT>
    <script type="text/javascript" src="templates/default/js/slideplay.js"></script>
    <LINK rel=stylesheet type=text/css href="templates/rslab/style/tweet.css" media=all>
    <LINK rel=stylesheet type=text/css href="templates/rslab/style/bx_styles_home.css">
    <SCRIPT type=text/javascript>
        // <![CDATA[
        if (screen.width > 1024) {
            document.write('<link rel="stylesheet" href="templates/rslab/style/style.css" type="text/css" media="screen,tv,projection" />');		
        } else {
            document.write('<link rel="stylesheet" href="templates/rslab/style/mobile.css" type="text/css" media="screen,tv,projection" />');		
        }
    </SCRIPT>
    <script type="text/javascript">
    function check_msg()
    {
            if($("#txtName").val() == "名字")
            {
                    alert("请填写昵称！");
                    $("#txtName").focus();
                    return false;
            }
            if($("#txtTel").val() == "联系方式")
            {
                    alert("请填写联系方式！");
                    $("#txtTel").focus();
                    return false;
            }
            if($("#txtEmail").val() == "邮箱")
            {
                    alert("请填写邮箱！");
                    $("#txtEmail").focus();
                    return false;
            }
            if($("#txtAreaVraag").val() == "留言内容")
            {
                    alert("请填写留言内容！");
                    $("#txtAreaVraag").focus();
                    return false;
            }
            $("#contact_form").submit();

    }
    </script>
    <LINK rel=stylesheet type=text/css href="templates/rslab/style/SpryMenuBarHorizontal.css">
    <LINK rel=stylesheet type=text/css href="templates/rslab/style/gallery.css"><!------------------------------------------------------------------------------------------------------------->
    <META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<BODY>
    <DIV class=start-stop>
        <DIV id=my-start-stop></DIV></DIV><!-- Main Part Start -->
    <DIV id=main-bg>
        <DIV class=bot-bg><!------------------------------------------------------------------------------------------------------------->
            <!-- Main Wrapper Start -->
            <DIV class=second-nav-bg>
                <DIV class=main-wrapper><!-- Top Part Start -->
                    <DIV class=top-part>
                        <DIV class="cm-fl top-left"><A title="Keep on Running" href="http://e.weibo.com/u/2964372814" target=_blank>新浪微博</A>
                        </DIV>
                        <DIV class="cm-fl cm-div menu_mob">
                            <DIV class="cm-fl logo"><A title="Ruuners Service Lab" 
                                                       href="http://rslab.be/nl/home"><IMG border=0 alt="" src="templates/rslab/images/logo.png" width="237"  height="73"></A></DIV>
                            <DIV class=nav><SPAN>
                                    <UL id=MenuBar1 class=MenuBarHorizontal>
                                        <?php echo GetNav(); ?>
                                    </UL>
                                </SPAN></DIV>
                        </DIV>
                    </DIV><!-- Top Part End --></DIV></DIV>
            <!-- Main Wrapper End -->