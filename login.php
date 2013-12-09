<?php
	require_once('config/config.php');
	if(!empty($_POST)){
		$db = new db;
		$data['user_password'] = md5($_POST['user_password']);
		$data['user_name'] = $_POST['user_name'];
		$user = $db->select('users',$data);
		if(!empty($user)){
			$_SESSION['user'] = $user[0];
			jump('content_list.php');
		}else{
			//登陆失败后的信息
			
		}
	}	
?>
<?php include('template/admin_header.php'); ?>
<?php include('template/admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="#">###</a>
</div>
<div class="content">

<form action="" method="post">
	用户名：<input type="text" name="user_name" />
    
    密码： <input type="password" name="user_password" />
    
    <input type="submit">
    
</form>
<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->
</div>
<?php include('template/admin_footer.php'); ?>
