<?php
	require_once('config/config.php');
	
	if(!empty($_POST)){
		$db = new db;
		$data['user_password'] = md5($_POST['user_password']);
		$data['user_name'] = $_POST['user_name'];
		$user = $db->select('users',$data);
		if(!empty($user)){
			$_SESSION['user'] = $user[0];
			header('location:index.php');
		}else{
			//登陆失败后的信息
			
		}
	}
	
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>


<form action="" method="post">
	用户名：<input type="text" name="user_name" />
    
    密码： <input type="password" name="user_password" />
    
    <input type="submit">
    
</form>


</body>
</html>