<?php
	require_once('config/config.php');
	
	super_admin_validate();
	
	//判断event传值是否正确
	$event_arr = array('add','edit','del');
	if(isset($_GET['event']) && in_array($_GET['event'],$event_arr)){
		$event = $_GET['event'];
	}else{
		jump('index.php');
		exit();
	}
	
	//删除
	if($event == 'del'){
		$id = $_GET['id'];
		$db = new db;
		$db->del('users',array('id'=>$id));
		jump('user_list.php');
		exit();
	}		
	
	//如果是修改，查询出修改目标保存进data
	$data = array();
	if($event == 'edit'){
		$id = $_GET['id'];
		$db = new db;
		$row = $db->select('users',array('id'=>$id));
		$data = $row[0];
		$data['old_password'] = $data['user_password'];
	}
	
	//提交
	if(!empty($_POST)){
		//获取表单提交数据
		unset($data['old_password'],$data['user_photo']);
		
		$data['user_name'] = $_POST['user_name'];
		$data['user_password'] = $_POST['user_password'];
		$data['user_nick_name'] = $_POST['user_nick_name'];
		
		$err = get_err($data);
		
		//用户名存在验证
		$db = new db;
		$user = $db->select('users',array('user_name'=>$data['user_name']));
		if(!empty($user)){
			$err['user_name'] = "用户名已存在!";
		}
		
		$password_confirm = $_POST['password_confirm'];
		
		if($data['user_password'] != $_POST['old_password'] && $password_confirm != $data['user_password']){
			$err['password_confirm'] = '与密码不一致！';
			$data['password_confirm'] = $_POST['password_confirm'];
		}
		
		if(empty($err)){
			//如果密码被修改过，则MD5加密
			if($data['user_password'] != $_POST['old_password']){
				$data['user_password'] = md5($data['user_password']);
			}
			//区分新建或是修改
			switch($_POST['event']){
				case 'add':
					$data['user_event'] = 2;
					$db->insert('users',$data);
				case 'edit':
					$id = $_POST['id'];
					$db->update('users',$data,array('id'=>$id));
			}
			jump('user_list.php');
			exit();
		}else{
			$data['old_password'] = $_POST['old_password'];	
		}
	}
?>
<?php include('template/admin_header.php'); ?>
<?php include('template/admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="user_list.php">成员管理</a><?php if(isset($_GET['event']))if($_GET['event']=='add')echo " >>  添加新成员";else echo " >>  编辑成员";;?>
</div>
<div class="content">

<form action="" method="post">
	
    <input class="input_addUser" type="text" name="user_name" value="<?php if(!empty($data)){echo $data['user_name'];} ?>" />
    用户名
    <span><?php if(isset($err['user_name'])){echo $err['user_name'];} ?></span>
    <br />
    
    <input class="input_addUser" type="password" name="user_password" value="<?php if(!empty($data)){echo $data['user_password'];} ?>" />
    密码
    <span><?php if(isset($err['user_password'])){echo $err['user_password'];} ?></span>
    <br />
    
    <input class="input_addUser" type="password" name="password_confirm" value="<?php if(isset($data['password_confirm'])){echo $data['password_confirm'];} ?>" />
    确认密码
    <span><?php if(isset($err['password_confirm'])){echo $err['password_confirm'];} ?></span>
    <br />
    
    <input class="input_addUser" type="text" name="user_nick_name" value="<?php if(!empty($data)){echo $data['user_nick_name'];} ?>" />
    昵称
    <span><?php if(isset($err['user_nick_name'])){echo $err['user_nick_name'];} ?></span>
    <br />
    
    <input class="input_addUser" type="hidden" name="event" value="<?php echo $event; ?>" />
    <input type="hidden" name="old_password" value="<?php if(!empty($data)){echo $data['old_password'];} ?>" />
    <input type="hidden" name="id" value="<?php if(!empty($data)){echo $data['id'];} ?>" />
    <input type="submit" value="提交" class="btn_link btn_form">
</form>

<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->
</div><!--content end-->
<?php include('template/admin_footer.php'); ?>