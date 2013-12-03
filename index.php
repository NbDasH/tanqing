<?php
	require_once('config/config.php');
	
	$db = new db;
	
	//分页
	$all_nm =  $db->select('contents',NULL,NULL,'count(id)');
	$all_nm = $all_nm[0]['count(id)'];
	$limit = 5;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$page = new page($all_nm,$limit,'index.php',$page);
	
	//获取数据
	$contents = $db->select('contents',NULL,'order by `contents`.`id` desc limit '.$page->get_limit_start().','.$limit,'*,`contents`.`id` as `c_id`',"left join `users` on `users`.`id` = `contents`.`user_id`");

	
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
			<?php foreach($contents as $v){ ?>
                            <li>
                            		
                                    <img src="img/t.png" class="img1">
                                    <h4><?php echo "<a href='show.php?id=".$v['c_id']."'>".$v['title']."</a>"; ?></h4>
                                    <h6>自： Yann 2013-11-25</h6>
                                    
                                    <?php
									/*输出文章主图*/
									$imgsrc = get_imgsrc($v['content']);
									if($imgsrc){
									$imgPath = get_small($imgsrc);
									 if(strlen($imgPath)>10){//如果路径长度太短，说明找不到图像 ?>
                                    <img src="<?php echo $imgPath; ?>" class="img2" >
                                    <?php }} //if end ?>
                                    
                                    <ul class="tag">
                                    <?php
									echo get_list_key_words(key_word_encode($v['key_words']));
                                    ?>
                                    </ul>
                                    <p><?php echo strip_tags($v['content']); ?></p>
            
                                    
                            </li>
            <?php } ?>
            </ul>
            
         <?php
		//分页
		echo $page->get_page();
		?>
        </div>
       <?php include('template/sidebar.php'); ?>
    </div>
</div>

<?php include('template/footer.php'); ?>