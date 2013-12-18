<?php
	require_once('config/config.php');
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}else{
		jump('index.php');	
	}
	
	if(!empty($_POST)){
		if($_POST['event'] == 'new'){
			$data['message'] = $_POST['message'];
			
			//如果是登陆用户则保存用户ID
			if(isset($_SESSION['user'])){
				//$data['user_id'] = $_SESSION['user']['id'];
			}
			
			$data['time'] = time();
			$data['content_id'] = $id;
			
			//增加全局配置留言过滤的开关
			$data['validate'] = $CONFIG['message_validate'] ? 0 : 1;
			
			$db = new db;
			$db->insert('messages',$data);
			
			jump("show.php?id=$id");
			exit();
		}else{
			$data['message'] = $_POST['message'];
			$data['time'] = time();
			$data['parent_id'] = $_POST['parent_id'];
			$data['validate'] = 1;
			$db = new db;
			$db->insert('messages',$data);
			jump("show.php?id=$id");
			exit();
		}
	}
	
	
	//读取当前文档
	$db = new db;
	$contents = $db->select('contents',array('contents`.`id'=>$id),'order by `contents`.`id` desc limit 0,5','*,`contents`.`id` as `c_id`',"left join `users` on `users`.`id` = `contents`.`user_id`");
	$content = $contents[0];
	
	
	//读取留言 -- 当前未查询用户全匿名评论
	$messages = $db->select('messages',array('content_id'=>$id,'validate'=>1));
	
	
?>
<!doctype html>
<html>
<head id="h">
<meta name='viewport' content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta charset="utf-8">
<title>明园艺术视野 >> <?php echo $content['title']; ?></title>
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
                                    
                                    <div class="articleContent">
                                    
                                    <?php
									/*输出文章主图*/
									$imgsrc = get_imgsrc($content['content']);
									if($imgsrc){
									$imgPath = get_small($imgsrc);
									 if(strlen($imgPath)>10){//如果路径长度太短，说明找不到图像 ?>
                                    <img src="<?php echo $imgPath; ?>" class="img2" >
                                    <?php }} //if end ?>
                                    <ul class="tag">
                                    <?php 
                                    echo get_list_key_words(key_word_encode($content['key_words']));
                                    ?>
                                    </ul>
                                    <p><?php echo show_content($content['content']); ?></p>
                                    
                                    </div><!--articleContent end-->
                <li>
             </ul>


    
    
    

 <div class="comment">
    <h5>评论( <?php echo count($messages); ?>条 )</h5>
    <ul>
    <?php foreach($messages as $v){ ?>
    <li>
        <h6><span>发表于<?php echo date('y-m-d H:i',$v['time']);?></span>游客:<?php echo substr($v['time'],0,-5);?></h6> 
        <?php echo $v['message'];?>
            
            <?php
            	$parent_id = $v['id'];
				$reply = $db->select('messages',array('parent_id'=>$parent_id));
				
				if(empty($reply)){
			?>
            
                <div class="reply">
                回复
                </div><!--reply end-->
                
                <div class="reply_form">
                <form action="" method="post">
                    <div><textarea name="message"></textarea></div>
                    <div><input type="submit" class="btn_link2" value="回复"></div>
                    <input type="hidden" value="<?php echo $v['id'] ?>" name="parent_id" />
                    <input type="hidden" name="event" value="reply" />
                </form>
                </div><!--reply form end-->
            
            <?php }else{ ?>
            
                <div class="replyOver">
                    管理员回复：<?php echo $reply[0]['message']; ?>
                </div>
       
       		<?php } ?>
  
    </li>
    <?php } ?>
    
    <h5>
        我要评论
        <?php if($CONFIG['message_validate']){ ?>
            <span>(目录管理员已设置了评论内容审核机制，新提交的评论需要进行审核才会被显示)</span>
        <?php } ?>
    </h5>
    <form action="" method="post">
    	<input type="hidden" name="event" value="new" />
    	<div><textarea name="message"></textarea></div>
    	<div><input type="submit" class="btn_link2"></div>
    </form>
 </div>
 

    
    
		 </div><!--left end-->
         <?php include('template/sidebar.php'); ?>
    </div><!--warp end-->
</div><!--content end-->



<?php include('template/footer.php'); ?>