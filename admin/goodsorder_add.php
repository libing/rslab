<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>创建订单</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getarea.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">创建订单</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="goodsorder_save.php" onsubmit="return cfm_goodsorder();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">会员用户名：</td>
			<td width="75%"><input name="username" type="text" id="username" class="class_input" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="120" align="right">商品列表：</td>
			<td><div class="order_area order_text">
					<table width="99%" border="0" align="right" cellpadding="0" cellspacing="0" class="nb">
						<tr class="order_header">
							<td height="20" align="left">商品名称</td>
							<td>商品编号</td>
							<td>数量</td>
							<td>价格</td>
							<td>单件运费</td>
							<td align="center">返点积分</td>
						</tr>
						<tr>
							<td height="20">&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
						</tr>
					</table>
				</div>
				<div class="gray_btn_area"> <span class="gray_btn">添 加</span> </div>
				</td>
		</tr>
		<tr>
			<td height="35" align="right">订单状态：</td>
			<td style="color:#00F">发布订单</td>
		</tr>
		<tr class="nb">
			<td height="80" align="right">订单操作：</td>
			<td style="line-height:22px;"><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="enterorder" checked="checked" />
				确认订单&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="alpay" />
				确认付款&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="postgoods" />
				商品发货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="getgoods" />
				已收货<br />
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="apregoods" />
				申请退货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="alregoods" />
				同意退货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="getregoods" />
				收到返货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="alrefund" />
				已退款 <br />
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="storage" />
				已归档</td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">收货人姓名： </td>
			<td><input name="truename" type="text" class="class_input" id="truename" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">电　话：</td>
			<td><input name="telephone" type="text" class="class_input" id="telephone" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">邮　编： </td>
			<td><input name="zipcode" type="text" class="class_input" id="zipcode" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">地　址：</td>
			<td><select name="postarea_prov" id="postarea_prov" onchange="SelProv(this.value,'postarea');">
					<option value="-1">请选择</option>
					<?php
						$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
						while($row = $dosql->GetArray())
						{
							echo '<option value="'.$row['datavalue'].'">'.$row['dataname'].'</option>';
						}
						?>
				</select>
				<select name="postarea_city" id="postarea_city" onchange="SelCity(this.value,'postarea');">
					<option value="-1">--</option>
				</select>
				<select name="postarea_country" id="postarea_country">
					<option value="-1">--</option>
				</select>
			<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">&nbsp;</td>
			<td><input name="address" type="text" class="class_input" id="address" />
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">证件号码：</td>
			<td><select name="cardtype" id="cardtype">
					<option value="0">身份证</option>
					<option value="1">护照号</option>
					<option value="2">其他</option>
				</select>
				<input type="text" name="cardnum" id="cardnum" class="class_input" style="width:174px" />
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">运单号：</td>
			<td><input name="postid" type="text" class="class_input" id="postid" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">配送方式：</td>
			<td><select name="postmode" id="postmode">
					<option value="-1">请选择配送方式</option>
					<?php GetTopType('#@__postmode','#@__goodsorder','postmode'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">支付方式：</td>
			<td><select name="paymode" id="paymode">
					<option value="-1">请选择支付方式</option>
					<?php GetTopType('#@__paymode','#@__goodsorder','paymode'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">货到方式：</td>
			<td><select name="getmode" id="getmode">
					<option value="-1">请选择货到方式</option>
					<?php GetTopType('#@__getmode','#@__goodsorder','getmode'); ?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">物品重量：</td>
			<td><input name="weight" type="text" class="class_input" id="weight" />
				kg<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">商品运费：</td>
			<td><input name="cost" type="text" class="class_input" id="cost" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">订单金额：</td>
			<td><input name="orderamount" type="text" id="orderamount" class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">赠送积分：</td>
			<td><input name="integral" type="text" class="class_input" id="integral" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="116" align="right">购物备注：</td>
			<td><textarea name="buyremark" class="class_areatext" id="buyremark"></textarea></td>
		</tr>
		<tr>
			<td height="116" align="right">发货方备注：</td>
			<td><textarea name="sendremark" class="class_areatext" id="sendremark"></textarea></td>
		</tr>
		<tr>
			<td height="35" align="right">订单时间：</td>
			<td><input name="posttime" type="text" id="posttime" class="input_short" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript" src="../data/plugin/calendar/calendar.js"></script>
				<script type="text/javascript">
							Calendar.setup({
								inputField     :    "posttime",
								ifFormat       :    "%Y-%m-%d %H:%M:%S",
								showsTime      :    true,
								timeFormat     :    "24"
							});
							</script></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input name="orderid" type="text" id="orderid" class="input_short" value="<?php echo GetOrderID('#@__goodsorder'); ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right"><span class="core_ico"></span>是否加星：</td>
			<td><input name="core" type="checkbox" id="core" value="true" />
				标注</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" onclick="history.go(-1)" value=""  />
		<input type="hidden" name="action" id="action" value="add" />
	</div>
</form>
<!--<div id="addgoods_win">
		<div class="recycle_window_header"><span class="recycle_window_title">增加商品：</span> <span class="recycle_window_close"><a href="javascript:HiddRecycle()"></a></span>
				<div class="cl"></div>
		</div>
		<form id="recycleform" name="recycleform" method="post">
				<div class="recycle_list" id="recycle_list"></div>
				<div class="recycle_bottom">
						<div class="selectall"><span>选择：</span> <a href="javascript:RecycleCheckAll(true);">全部</a> - <a href="javascript:RecycleCheckAll(false);">无</a></div>
						<a href="javascript:;" onclick="RecycleReAll('empty')"><img src="templates/images/empty_recycle.png" /></a> </div>
		</form>
</div>-->
</body>
</html>