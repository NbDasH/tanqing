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
<?php include('header.php'); ?>
<?php include('banner.php'); ?>

<div class="content clearfix">
	<div class="warp">
    	<div class="main left">
        	<ul class="article">
			<?php foreach($contents as $v){ ?>
                            <li>
                                    <img src="img/t.png" class="img1">
                                    <h4><?php echo "<a href='show.php?id=".$v['c_id']."'>".$v['title']."</a>"; ?></h4>
                                    <h6>自： Yann 2013-11-25</h6>
                                    <img src="<?php echo get_small(get_imgsrc($v['content'])); ?>" class="img2" >
                                    <ul class="tag">
                                    <?php 
                                    foreach(key_word_encode($v['key_words']) as $v2){
                                        echo '<li><a href="search.php?event=key_word&amp;search='.$v2.'">'.$v2.'</a> | </li>';
                                    }
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
       <?php include('sidebar.php'); ?>
    </div>
</div>



<?php include('footer.php'); ?>