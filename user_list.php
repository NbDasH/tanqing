<?php
	require_once('config/config.php');
	
	super_admin_validate();
	
	$db = new db;
	
	$users = $db->select('users',NULL,' order by id desc');
	
?>
<?php include('admin_header.php'); ?>
<?php include('admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="#">文章管理</a>
</div>
<div class="content">
<a href="content_manager.php?event=add">增加成员</a>
<table>
	<tr>
    	<td>id</td>
        <td>name</td>
        <td>do</td>
    </tr>
    <?php foreach($users as $v){ ?>
    <tr>
    	<td><?php echo $v['id']; ?></td>
        <td><?php echo $v['user_name']; ?></td>
        <td>
        	<a href="user_manager.php?event=del&id=<?php echo $v['id']; ?>">删除</a>
            <a href="user_manager.php?event=edit&id=<?php echo $v['id']; ?>">修改</a>
        </td>
    </tr>
    <?php } ?>
</table>

<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->
</div><!--content end-->
<?php include('admin_footer.php'); ?>