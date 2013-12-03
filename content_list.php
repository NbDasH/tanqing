<?php
	require_once('config/config.php');
	
	admin_validate();
	
	$db = new db;
	
	$contents = $db->select('contents',NULL,' order by id desc');

?>

<?php include('template/admin_header.php'); ?>
<?php include('template/admin_nav.php'); ?>
<div class="location">
	<a href="#">返回后台首页</a> >> <a href="content_list.php">文章管理</a>
</div>
<div class="content">
<h5>
	<a href="content_manager.php?event=add" class="btn_link">添加新文章</a>
</h5><!--sub_nav end-->

<table>
	<tr>
    	<td>序</td>
        <td>文章标题</td>
        <td>操作</td>
    </tr>
    <?php foreach($contents as $v){ ?>
    <tr>
    	<td><?php echo $v['id']; ?></td>
        <td><a href="show.php?id=<?php echo $v['id']; ?>" target="_blank"><?php echo $v['title']; ?></a></td>
        <td>
        	<a href="content_manager.php?event=del&id=<?php echo $v['id']; ?>" onClick="return confirm('是否删除？')">删除</a>
            <a href="content_manager.php?event=edit&id=<?php echo $v['id']; ?>">修改</a>
        </td>
    </tr>
    <?php } ?>
</table>

<div class="description">
	<span class="redFont">*</span> 
	在添加标签的时候，空格也应该，能作为标签的分割符
</div><!--描述 end-->

</div><!--content end-->
<?php include('template/admin_footer.php'); ?>