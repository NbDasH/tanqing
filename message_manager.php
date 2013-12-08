<?php
	require_once('config/config.php');
	
	admin_validate();
	
	if(isset($_GET['event']) && $_GET['event'] == 'del'){
		$id = $_GET['id'];
		$db = new db;
		$db->del('messages',array('id'=>$id));
		jump('message_manager.php');
	}
	
	$db = new db;
	$messages = $db->select('messages',NULL,'where `parent_id` is null order by m_id desc','*,`messages`.id as m_id,`contents`.id as c_id',' left join contents on `messages`.content_id = `contents`.id');
	
	/*
	if(!empty($_POST)){
		$i = 1;
		foreach($_FILES as $value){
			if(!empty($value['tmp_name'])){
				require_once('config/resizeimage.php');
				if(in_array($value['type'],array('image/gif','image/png','image/jpeg','image/jpg'))){
					$type = strtolower(substr(strrchr($value['name'],"."),1));
					$rand = rand();
					$tmp = $rand.'.'.$type;
					move_uploaded_file($value['tmp_name'],'tmp/'.$tmp);
					new resizeimage('tmp/'.$tmp, "910", "1", "0","img/b".$i.".jpg");
					unlink('tmp/'.$tmp);
				}
			}
			$i++;
		}
		
		$i=1;
		foreach($_POST['banner_link'] as $v){
			$db->update('banners',array('link'=>$v),array('id'=>$i));
			$i++;
		}
		
		jump('banner_manager.php');
		
	}
	*/
	
?>
<?php include('template/admin_header.php'); ?>
<?php include('template/admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="message_manager.php">评论管理</a>
</div>
<div class="content">

<table>
	<tr>
    	<td>序</td>
        <td>留言内容</td>
        <td>文章标题</td>
        <td>操作</td>
    </tr>
    <?php foreach($messages as $v){ ?>
    <tr>
    	<td><?php echo $v['m_id']; ?></td>
        <td><?php echo $v['message']; ?></td>
        <td><a href="show.php?id=<?php echo $v['c_id']; ?>"><?php echo $v['title']; ?></a></td>
        <td>
        	<a href="message_manager.php?event=del&id=<?php echo $v['m_id']; ?>">删除</a>
            <!--<a href="user_manager.php?event=edit&id=<?php echo $v['m_id']; ?>">修改</a>-->
        </td>
    </tr>
    <?php } ?>
</table>

<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->
</div><!--content end-->
<?php include('template/admin_footer.php'); ?>