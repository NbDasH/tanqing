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
<?php include('header.php'); ?>
<?php include('banner.php'); ?>
<div class="content clearfix">
	<div class="warp">
    	<div class="main left">
       		 <ul class="article">
             	<li>
                					<img src="img/t.png" class="img1">
                                    <h4><?php echo "<a href='show.php?id=".$content['c_id']."'>".$content['title']."</a>"; ?></h4>
                                    <h6>自： Yann 2013-11-25</h6>
                                    <img src="<?php echo get_small(get_imgsrc($content['content'])); ?>" class="img2" >
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
         <?php include('sidebar.php'); ?>
    </div><!--warp end-->
</div><!--content end-->
<?php include('footer.php'); ?>