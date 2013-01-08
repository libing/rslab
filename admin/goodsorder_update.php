<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑订单</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__goodsorder` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">编辑订单</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="goodsorder_save.php" onsubmit="return cfm_goodsorder();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">会员用户名：</td>
			<td width="75%"><input name="username" type="text" id="username" class="class_input" value="<?php echo $row['username']; ?>" />
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
						<?php
						if($row['attrvalue'] != '')
						{
							$attrbutevalue = explode(';',$row['attrvalue']);
							for($i=0; $i<count($attrbutevalue); $i++)
							{
								$goodscart = explode('|',$attrbutevalue[$i]);
								$goodsid = explode(',',$goodscart[0]);
								$goodsnum = explode(',',$goodscart[(count($goodscart)-3)]);//数组倒数第三位为购买数量
								$price = explode(',',$goodscart[(count($goodscart)-2)]);
								$payfreight = explode(',',$goodscart[(count($goodscart)-1)]);
								$row2 = $dosql->GetOne('SELECT * FROM `#@__goods` WHERE id='.$goodsid[1]);
							?>
						<tr class="tdtd">
							<td height="20">
							<?php
							echo $row2['title'];
							for($z=1; $z<count($goodscart)-4; $z++)
							{
								$attrbute = explode(',',$goodscart[$z]);
								echo '<span style="color:#999;margin-left:3px;font-size:11px;">'.$attrbute[1].'</span>';
							}
							?></td>
							<td align="center"><?php echo $row2['goodsid']; ?></td>
							<td align="center"><?php echo $goodsnum[1]; ?></td>
							<td align="center"><?php echo $price[1]; ?></td>
							<td align="center"><?php echo $payfreight[1]; ?></td>
							<td align="center"><?php echo $row2['integral']*$goodsnum[1]; ?></td>
						</tr>
						<?php
							}
						}
						?>
					</table>
				</div>
				<div class="gray_btn_area"> <span class="gray_btn">添 加</span> </div></td>
		</tr>
		<tr>
			<td height="35" align="right">订单状态：</td>
			<td style="color:#00F">
			<?php
			$checkinfo = explode(',',$row['checkinfo']);
	
			if(!in_array('apregoods', $checkinfo) and !in_array('alregoods', $checkinfo) and !in_array('alrefund', $checkinfo) and !in_array('getregoods', $checkinfo) and !in_array('storage', $checkinfo))
			{
				if($row['checkinfo'] == '')
				{
					echo '等待确认';
				}
				else if(!in_array('alpay', $checkinfo))
				{
					echo '已确认，等待付款';
				}
				else if(!in_array('postgoods', $checkinfo))
				{
					echo '已付款，等待发货';
				}
				else if(!in_array('getgoods', $checkinfo))
				{
					echo '已发货，等待收货';
				}
				else if(!in_array('storage', $checkinfo))
				{
					echo '已收货，等待归档';
				}
				else
				{
					echo '参数错误，没有获取到订单状态';
				}
			}
			else
			{
				if(in_array('apregoods', $checkinfo) and !in_array('alregoods', $checkinfo))
				{
					echo '申请退货，等待退货';
				}
				else if(in_array('alregoods', $checkinfo) and !in_array('getregoods', $checkinfo))
				{
					echo '同意退货，等待收返货';
				}
				else if(in_array('getregoods', $checkinfo) and !in_array('alrefund', $checkinfo))
				{
					echo '已收到返货，等待退款';
				}
				else if(in_array('alrefund', $checkinfo) and !in_array('storage', $checkinfo))
				{
					echo '已退款，等待归档';
				}
				else if(in_array('storage', $checkinfo))
				{
					echo '已归档';
				}
				else
				{
					echo '参数错误，没有获取到订单状态';
				}
			}
			?></td>
		</tr>
		<tr class="nb">
			<td height="80" align="right">订单操作：</td>
			<td style="line-height:22px;"><?php $checkinfo = explode(',',$row['checkinfo']); ?>
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="enterorder" <?php if(in_array('enterorder', $checkinfo)) echo 'checked'; ?> />
				确认订单&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]2" value="alpay" <?php if(in_array('alpay', $checkinfo)) echo 'checked'; ?> />
				确认付款&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="postgoods" <?php if(in_array('postgoods', $checkinfo)) echo 'checked'; ?> />
				商品发货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="getgoods" <?php if(in_array('getgoods', $checkinfo)) echo 'checked'; ?> />
				已收货 <br />
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="apregoods" <?php if(in_array('apregoods', $checkinfo)) echo 'checked'; ?> />
				申请退货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="alregoods" <?php if(in_array('alregoods', $checkinfo)) echo 'checked'; ?> />
				同意退货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="getregoods" <?php if(in_array('getregoods', $checkinfo)) echo 'checked'; ?> />
				收到返货&nbsp;
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="alrefund" <?php if(in_array('alrefund', $checkinfo)) echo 'checked'; ?> />
				已退款 <br />
				<input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="storage" <?php if(in_array('storage', $checkinfo)) echo 'checked'; ?> />
				已归档 <span class="cnote"><span class="maroon">*</span> 请谨慎操作，订单流程不可逆</span></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">收货人姓名： </td>
			<td><input name="truename" type="text" class="class_input" id="truename" value="<?php echo $row['truename']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">电　话：</td>
			<td><input name="telephone" type="text" class="class_input" id="telephone" value="<?php echo $row['telephone']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">邮　编： </td>
			<td><input name="zipcode" type="text" class="class_input" id="zipcode" value="<?php echo $row['zipcode']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">地　址：</td>
			<td><select name="postarea_prov" id="postarea_prov" onchange="SelProv(this.value,'postarea');">
					<option value="-1">请选择</option>
					<?php
						$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
						while($row2 = $dosql->GetArray())
						{
							if($row['postarea_prov'] === $row2['datavalue'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
						}
						?>
				</select>
				<select name="postarea_city" id="postarea_city" onchange="SelCity(this.value,'live');">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=1 AND datavalue>".$row['live_prov']." AND datavalue<".($row['live_prov'] + 500)." ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['postarea_city'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
				<select name="postarea_country" id="postarea_country">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=2 AND datavalue LIKE '".$row['live_city'].".%%%' ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['postarea_country'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
			<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">&nbsp;</td>
			<td><input name="address" type="text" class="class_input" id="address" value="<?php echo $row['address']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">证件号码：</td>
			<td><select name="cardtype" id="cardtype">
					<option value="0" <?php if($row['cardtype']=='0')echo 'selected'; ?>>身份证</option>
					<option value="1" <?php if($row['cardtype']=='1')echo 'selected'; ?>>护照号</option>
					<option value="2" <?php if($row['cardtype']=='2')echo 'selected'; ?>>其他</option>
				</select>
				<input type="text" name="cardnum" id="cardnum" class="class_input" style="width:174px" value="<?php echo $row['cardnum']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">运单号：</td>
			<td><input name="postid" type="text" class="class_input" id="postid" value="<?php echo $row['postid']; ?>" />
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
			<td><input name="weight" type="text" class="class_input" id="weight" value="<?php echo $row['weight']; ?>" />
				kg<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">商品运费：</td>
			<td><input name="cost" type="text" class="class_input" id="cost" value="<?php echo $row['cost']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">订单金额：</td>
			<td><input name="orderamount" type="text" id="orderamount" class="class_input" value="<?php echo $row['orderamount']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">赠送积分：</td>
			<td><input name="integral" type="text" class="class_input" id="integral" value="<?php echo $row['integral']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="116" align="right">购物备注：</td>
			<td><textarea name="buyremark" class="class_areatext" id="buyremark"><?php echo $row['buyremark']; ?></textarea></td>
		</tr>
		<tr>
			<td height="116" align="right">发货方备注：</td>
			<td><textarea name="sendremark" class="class_areatext" id="sendremark"><?php echo $row['sendremark']; ?></textarea></td>
		</tr>
		<tr>
			<td height="35" align="right">订单时间：</td>
			<td><input name="posttime" type="text" id="posttime" class="input_short" value="<?php echo GetDateTime($row['posttime']); ?>" readonly="readonly" />
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
			<td><input name="orderid" type="text" id="orderid" class="input_short" value="<?php echo $row['orderid']; ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right"><span class="core_ico"></span>是否加星：</td>
			<td><input name="core" type="checkbox" id="core" value="true" <?php if($row['core']=='true') echo 'checked'; ?> />
				标注</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" onclick="history.go(-1)" value=""  />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>