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
		
		//jump("show.php?id=$id");
		//exit();
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
    <h5>评论( 6条 )</h5>
    <ul>
    <?php foreach($messages as $v){ ?>
    <li>
        <h6><span>发表于<?php echo date('y-m-d H:i',$v['time']);?><span><?php echo $v['message'];?></h6> 
        <?php echo $v['message'];?>
            <div class="reply">
        	<a href="#">回复</a>
       		</div><!--reply end-->
       
         	<div class="reply_form">
        	<form action="" method="post">
                <div><textarea name="message"></textarea></div>
                <div><input type="submit" class="btn_link2"></div>
            </form>
       		</div><!--reply form end-->
  
    </li>
    <?php } ?>
    
    <h5>我要评论</h5>
    <form action="" method="post">
    	<div><textarea name="message"></textarea></div>
    	<div><input type="submit" class="btn_link2"></div>
    </form>
 </div>
 
 <style>
 .comment{ width:100%;}
 .comment h6{padding:5px;font-size:14px;font-weight:400;color:black;border-bottom:1px solid #eee;}
 .comment h6 span{ float:right; color:#ccc;}
 .comment h5{padding:5px; font-size:14px; font-weight:400; color:blue;}
 .comment li{ border-bottom:1px #eee dashed; padding:20px; min-height:50px; border:1px solid #eee; margin-bottom:10px;}
 .comment textarea{ width:400px; height:50px; border:1px solid #ccc;}
 
 .comment .btn_link2{ padding:3px 15px; border:1px solid #999; background:#eee; color:#000; margin-top:10px;}
 .comment .btn_link2:hover{ background:#fff; color:#f00; cursor:pointer; cursor:pointer;}
 .comment .reply_form{ display:none;}
 .comment .reply{color:#06C; text-align:right;}
 .comment .reply span{ font-weight:800;}
 </style> 
    
    
		 </div><!--left end-->
         <?php include('template/sidebar.php'); ?>
    </div><!--warp end-->
</div><!--content end-->



<?php include('template/footer.php'); ?>