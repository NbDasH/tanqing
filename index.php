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
	
	//获取关键字
	$key_words = $db->select('key_words',NULL,'order by click_rate desc limit 0,20');
	
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
        <div class="sidebar right">
        	<div class="about">
            	<h3>关于我们(About)</h3>
                <ul class="share">
                	<li><a href="#" class="s1"></a></li>
                    <li><a href="#" class="s2"></a></li>
                    <li><a href="#" class="s3"></a></li>
                    <li><a href="#" class="s4"></a></li>
                </ul>
                
            </div>
            <div class="ad"><img src="img/ad.jpg"></div>
            <div class="search">
            	<form action="search.php" method="get">
                	<input type="hidden" name="event" value="search" />
                	<input type="text" name="search" class="text" value="输入文章关键子">
                    <input type="submit" class="btn" value="查">
                </form>
            </div>
            <div class="tags">
            	<h4>热门标签：</h4>

                <?php
				foreach($key_words as $v){
					echo "<li><a href='search.php?event=key_word&amp;search=".$v['key_word']."'>".$v['key_word']."</a></li>";
				}
				?>
                </ul>
            </div>
        </div>
    </div>
</div>	



<?php include('footer.php');