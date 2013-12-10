<?php
	require_once('config/config.php');
	
	admin_validate();
	
	$db = new db;
	
	if(isset($_GET['event']) && $_GET['event'] == 'del'){
		$id = $_GET['id'];
		$db->del('messages',array('id'=>$id));
		jump('message_manager.php');
	}
	
	if(isset($_GET['event']) && $_GET['event'] == 'validate_true'){
		$id = $_GET['id'];
		$db->update('messages',array('validate'=>1),array('id'=>$id));
		jump('message_manager.php');
	}
	
	if(isset($_GET['event']) && $_GET['event'] == 'validate_false'){
		$id = $_GET['id'];
		$db->update('messages',array('validate'=>0),array('id'=>$id));
		jump('message_manager.php');
	}
	
	if(!empty($_POST)){
		if($_POST['event'] == 'edit'){
			$id = $_POST['id'];
			$data['message'] = $_POST['message'];
			$db->update('messages',$data,array('id'=>$id));
			jump('message_manager.php');
		}else{
			$data['message'] = $_POST['message'];
			$data['parent_id'] = $_POST['parent_id'];
			$data['time'] = time();
			$data['validate'] = 1;
			$db->insert('messages',$data);
			jump('message_manager.php');
		}
	}
	
	$messages = $db->select('messages',NULL,'where `parent_id` is null order by m_id desc','*,`messages`.id as m_id,`contents`.id as c_id',' left join contents on `messages`.content_id = `contents`.id');
	
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
        <td>管理员回复</td>
        <td>操作</td>
    </tr>
    <?php foreach($messages as $v){ ?>
    <tr>
    	<td><?php echo $v['m_id']; ?></td>
        <td>
            <span class="msg_form" data-msg_id="<?php echo $v['m_id']; ?>"><?php echo nl2br($v['message']); ?></span>
        </td>
        <td><a href="show.php?id=<?php echo $v['c_id']; ?>"><?php echo $v['title']; ?></a></td>
        <td>
        	<?php
				$result = $db->select('messages',array('parent_id'=>$v['m_id']));
				if(!empty($result)){
			?>
            	<span class="msg_form" data-msg_id="<?php echo $result[0]['id']; ?>"><?php echo $result[0]['message']; ?></span>
            <?php
				}else{
			?>
            	<a href="#" class="msg_reply" data-msg_id="<?php echo $v['m_id']; ?>">点击回复</a>
			<?php	
				}
			?>
        </td>
        <td>
        	<a href="message_manager.php?event=del&id=<?php echo $v['m_id']; ?>">删除</a>
            <?php if(!$v['validate']){ ?>
            	<a href="message_manager.php?event=validate_true&id=<?php echo $v['m_id']; ?>">通过验证</a>
            <?php }else{ ?>
            	<a href="message_manager.php?event=validate_false&id=<?php echo $v['m_id']; ?>">取消验证</a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>

<script type="text/javascript" src="cssjs/jquery-2.0.1.js"></script>
<script>
	$(document).ready(function(e) {
        $('.msg_form').click(function(){
			var data = $(this).html();
			var id = $(this).attr('data-msg_id');
			var form = '<form action="" method="post"><input type="hidden" value="'+id+'" name="id" /><input type="hidden" value="edit" name="event" /><textarea name="message">'+data+'</textarea></form>';
			$(this).parent().html(form);
			$('textarea[name="message"]').focus();
			$('textarea[name="message"]').on('blur',function(){
				$(this).parent('form').submit();
			});
		});
		
		$('.msg_reply').click(function(){
			var id = $(this).attr('data-msg_id');
			var form = '<form action="" method="post"><input type="hidden" value="'+id+'" name="parent_id" /><input type="hidden" value="add" name="event" /><textarea name="message"></textarea></form>';
			$(this).parent().html(form);
			$('textarea[name="message"]').focus();
			$('textarea[name="message"]').on('blur',function(){
				$(this).parent('form').submit();
			});
			return false;
		});
    });
</script>

<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->
</div><!--content end-->
<?php include('template/admin_footer.php'); ?>