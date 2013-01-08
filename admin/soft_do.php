<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2012 phpMyWind.com
update: 2011-4-6 16:40:24
person: Feng
**************************
*/


//初始化未传递参数
$action  = isset($action) ? $action : '';
$keyword = isset($keyword) ? $keyword : '';
$styleal = '';
$stylec1 = '';
$stylec0 = '';
$styleah = '';


//删除单条记录
if($action == 'del')
{
	$deltime = time();
	$dosql->ExecNoneQuery("UPDATE `#@__$tbname` SET delstate='true', deltime='$deltime' WHERE id=$id");
}


//删除选中记录
if($action == 'delall')
{
	if($ids != '')
	{
		$deltime = time();
		$dosql->ExecNoneQuery("UPDATE `#@__$tbname` SET delstate='true', deltime='$deltime' WHERE id IN ($ids)");
	}
}


//设置属性样式及查询语句
switch($flag)
{
	case 'all':
		$flagquery = 'id<>0';
		$styleal = 'onflag';
	break;  
	case 'checkinfo2':
		$flagquery  = "checkinfo='false'";
		$stylec1 = 'onflag';
	break;
	case 'checkinfo':
		$flagquery  = "checkinfo='true'";	
		$stylec0 = 'onflag';
	break;
	case 'author':
		$flagquery  = "author='".$_SESSION['admin']."'";
		$styleah = 'on_author';
	break;
	default:
		$dosql->Execute("SELECT `flag` FROM `#@__infoflag`");
		while($row = $dosql->GetArray())
		{
			if($row['flag'] == $flag)
			{
				$flagquery = "flag LIKE '%$flag%'";
			}
		}
}

//Ajax输出数据
?>

<div class="mgr_divt">
	<ul class="flag">
		<li>属性：</li>
		<li class="<?php echo $styleal; ?>"><a href="javascript:;" onclick="GetFlag('all')">全部</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $stylec1; ?>"><a href="javascript:;" onclick="GetFlag('checkinfo2');">未审</a></li>
		<li><span>|</span></li>
		<li class="<?php echo $stylec0; ?>"><a href="javascript:;" onclick="GetFlag('checkinfo')">已审</a></li>
		<li><span>|</span></li>
		<?php
		$dosql->Execute("SELECT * FROM `#@__infoflag` ORDER BY orderid ASC");
		while($row = $dosql->GetArray())
		{
			echo '<li class="';

			if($row['flag'] == $flag)
			{
				echo 'onflag';
			}

			echo '"><a href="javascript:;" onclick="GetFlag(\''.$row['flag'].'\',\''.$tid.'\')">'.$row['flagname'].'</a></li>';
			echo '<li><span>|</span></li>';
		}
		?>
		<li class="<?php echo $styleah; ?>"><a href="javascript:;" onclick="GetFlag('author')">我发布的文档</a></li>
		<li><span>|</span></li>
		<li><a href="javascript:;" onclick="ShowRecycle();">内容回收站</a></li>
	</ul>
	<div id="search" class="search"> <span class="s">
		<input name="keyword" id="keyword" type="text" title="输入软件名进行搜索" value="<?php echo $keyword; ?>" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearch();"><img src="templates/images/search_btn.png" title="搜索" /></a></span></div>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table" id="ajaxlist">
	<tr class="thead2" align="center">
		<td width="5%"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
		<td width="10%">软件LOGO</td>
		<td width="5%">ID</td>
		<td width="15%">软件名称</td>
		<td width="15%">更新时间</td>
		<td width="12%">所属栏目</td>
		<td width="10%">点击</td>
		<td width="10%">发布人</td>
		<td width="18%" class="noborder">操作</td>
	</tr>
	<?php

	//检查全局分页数
	if(empty($cfg_pagenum))  $cfg_pagenum = 20;

	//设置sql
	$sql = "SELECT * FROM `#@__$tbname` WHERE siteid='$cfg_siteid' AND delstate=''";	

	if(!empty($tid))     $sql .= " AND (classid=$tid OR parentstr Like '%,$tid,%')";	
	if(!empty($flag))    $sql .= " AND $flagquery";
	if(!empty($keyword)) $sql .= " AND title LIKE '%$keyword%'";

	$dopage->GetPage($sql,$cfg_pagenum,'DESC');

	while($row = $dosql->GetArray())
	{

		//获取标题名称
		$title = '<span style="color:'.$row['colorval'].';font-weight:'.$row['boldval'].'">'.$row['title'].'</span>';
		$title .= '<span class="titflag">';

		if($cfg_maintype == 'Y')
		{
			$r = $dosql->GetOne('SELECT classname FROM `#@__maintype` WHERE id='.$row['mainid']);
			
			if(isset($r['classname']))
			{
				$title .= '['.$r['classname'].'] ';
			}
		}

		$flagarr = explode(',',$row['flag']);
		$flagnum = count($flagarr);
		for($i=0; $i<$flagnum; $i++)
		{
			$r = $dosql->GetOne("SELECT `flagname` FROM `#@__infoflag` WHERE flag='".$flagarr[$i]."'");

			if(isset($r['flagname']))
			{
				$title .= $r['flagname'].' ';
			}
		}

		$title .= '</span>';


		//获取类型名称
		$r = $dosql->GetOne("SELECT classname FROM `#@__infoclass` WHERE id=".$row['classid']);

		if(isset($r['classname']))
		{
			$classname = $r['classname'].' ['.$row['classid'].']';
		}
		else
		{
			$classname = '<span class="red">分类已删 ['.$row['classid'].']</span>';
		}


		//获取审核状态
		switch($row['checkinfo'])
		{
			case 'true':
			$checkinfo = '已审';
			break;  
			case 'false':
			$checkinfo = '未审';
			break;
			default:
			$checkinfo = '没有获取到参数';
		}
	?>
	<tr align="center" class="mgr_tr" onmouseover="this.className='mgr_tr_on'" onmouseout="this.className='mgr_tr'">
		<td height="70"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
		<td><span class="thumbs"><?php echo GetMgrThumbs($row['picurl']); ?></span></td>
		<td><?php echo $row['id']; ?></td>
		<td align="left"><span class="titles"><?php echo $title; ?></span></td>
		<td class="number"><?php echo GetDateTime($row['posttime']); ?></td>
		<td><?php echo $classname; ?></td>
		<td><?php echo $row['hits']; ?></td>
		<td><?php echo $row['author']; ?></td>
		<td class="action"><span id="check<?php echo $row['id']; ?>">[<a href="javascript:;" title="点击进行审核与未审操作" onclick="CheckInfo(<?php echo $row['id']; ?>,'<?php echo $checkinfo; ?>')"><?php echo $checkinfo; ?></a>]</span><span>[<a href="soft_update.php?tid=<?php echo $tid; ?>&id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="javascript:;" onclick="ClearInfo(<?php echo $row['id']; ?>)">删除</a>]</span></td>
	</tr>
	<?php
	}	
	?>
</table>
<?php
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="mgr_nlist">暂时没有相关的记录</div>';
}
?>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:;" onclick="AjaxClearAll();">删除</a></div>
	<?php
	if($cfg_curmode != 'small')
	{
	?>
	<span class="mgr_btn"><a href="soft_add.php">添加软件信息</a></span>
	<?php
	}
	?>
</div>
<div class="page_area"> <?php echo $dopage->AjaxPage(); ?> </div>
<script>
$(function(){
    $(".thumbs img").LoadImage();
});
</script>