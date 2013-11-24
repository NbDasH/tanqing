<?php
	require_once('config/config.php');
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}else{
		jump('index.php');	
	}
	
	if(!empty($_POST)){
		$data['message'] = $_POST['message'];
		
		//如果是登陆用户则保存用户ID
		if(isset($_SESSION['user'])){
			$data['user_id'] = $_SESSION['user']['id'];
		}
		
		$data['time'] = time();
		$data['content_id'] = $id;
		$db = new db;
		$db->insert('messages',$data);
		
		jump("show.php?id=$id");
		exit();
	}
	
	
	//读取当前文档
	$db = new db;
	$contents = $db->select('contents',array('contents`.`id'=>$id),'order by `contents`.`id` desc limit 0,5','*,`contents`.`id` as `c_id`',"left join `users` on `users`.`id` = `contents`.`user_id`");
	$content = $contents[0];
	
	
	//读取留言 -- 当前未查询用户全匿名评论
	$messages = $db->select('messages',array('content_id'=>$id));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>

    <h3>
        <?php echo $content['title']; ?>
    </h3>
    <div style="height:500px; overflow:hidden;">
        <?php echo $content['content']; ?>
    </div>
    <div>
        <?php 
        foreach(key_word_encode($content['key_words']) as $v){
            echo "<a href='search.php?event=keyword&amp;search=$v'>$v</a> | ";
        }
        ?>
    </div>
    
    
    
    
    
    <br />
    <br />
    <br />
    <br />
    
    <?php foreach($messages as $v){ ?>
    <div>
    	<?php echo $v['time'].':'.$v['message'] ?>
    </div>
    <?php } ?>
    
    <br />
    <br />
    <br />
    <br />
    
    
    评论:
    <form action="" method="post">
    	<textarea name="message"></textarea>
    	<input type="submit">
    </form>


</body>
</html>