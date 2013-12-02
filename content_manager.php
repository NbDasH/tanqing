<?php
	require_once('config/config.php');
	
	admin_validate();
	
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
		$db->del('contents',array('id'=>$id));
		jump('content_list.php');
		exit();
	}		
	
	//如果是修改，查询出修改目标保存进data
	$data = array();
	if($event == 'edit'){
		$id = $_GET['id'];
		$db = new db;
		$row = $db->select('contents',array('id'=>$id));
		$data = $row[0];
	}
	
	//提交
	if(!empty($_POST)){
		
		//获取表单提交数据
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['time'] = time();
		$data['user_id'] = $_SESSION['user']['id'];
		$data['key_words'] = set_keyword($_POST['key_words']);
		
		$db = new db;
		
		//区分新建或是修改
		switch($_POST['event']){
			case 'add':
				$db->insert('contents',$data);
				jump('show.php?id='.$db->insert_id());
				exit();
			case 'edit':
				$id = $_POST['id'];
				$db->update('contents',$data,array('id'=>$id));
				jump("show.php?id=$id");
				exit();
		}
	}
?>
<?php include('admin_header.php'); ?>
<?php include('admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="#">文章管理</a>
</div>
<div class="content">

<script type="text/javascript" src="ue/ueditor.config.js"></script>
<script type="text/javascript" src="ue/ueditor.all.min.js"></script>

<form action="" method="post">
	标题:<input type="text" name="title" value="<?php if(!empty($data)){echo $data['title'];} ?>" />
    <textarea name="content" id="myEditor"><?php if(!empty($data)){echo $data['content'];} ?></textarea>
    <script type="text/javascript">UE.getEditor('myEditor');</script>
    关键字:<input type="text" name="key_words" value="<?php if(!empty($data)){echo $data['key_words'];} ?>" />
    <input type="hidden" name="event" value="<?php echo $event; ?>" />
    <input type="hidden" name="id" value="<?php if(!empty($data)){echo $data['id'];} ?>" />
    <input type="submit" value="发布">
</form>

<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->
</div><!--content end-->
<?php include('admin_footer.php'); ?>