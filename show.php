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
<head id="h">
<meta name='viewport' content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta charset="utf-8">
<title>明园艺术视野</title>
<?php include('template/header.php'); ?>
<?php include('template/banner.php'); ?>
<div class="content clearfix">
	<div class="warp">
    	<div class="main left">
       		 <ul class="article">
             	<li>
                					<img src="img/t.png" class="img1">
                                    <h4><?php echo "<a href='show.php?id=".$content['c_id']."'>".$content['title']."</a>"; ?></h4>
                                    <h6>自： Yann 2013-11-25</h6>
                                    <?php
									/*输出文章主图*/
									$imgPath = get_small(get_imgsrc($v['content']));
									 if(strlen($imgPath)>10){//如果路径长度太短，说明找不到图像 ?>
                                    <img src="<?php echo $imgPath; ?>" class="img2" >
                                    <?php } //if end ?>
                                    <ul class="tag">
                                    <?php 
                                    foreach(key_word_encode($content['key_words']) as $v2){
                                        echo '<li><a href="search.php?event=key_word&amp;search='.$v2.'">'.$v2.'</a> | </li>';
                                    }
                                    ?>
                                    </ul>
                                    <p><?php echo strip_tags($content['content']); ?></p>
                <li>
             </ul>


    
    
    

    
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
		 </div><!--left end-->
         <?php include('template/sidebar.php'); ?>
    </div><!--warp end-->
</div><!--content end-->
<?php include('template/footer.php'); ?>