<?php
	require_once('config/config.php');
	
		
	$event_arr = array('key_word','search');
	if(isset($_GET['event']) && in_array($_GET['event'],$event_arr) && isset($_GET['search'])){
		$event = $_GET['event'];
		$search = $_GET['search'];
	}else{
		jump('index.php');
	}
	
	$db = new db;
	$limit = 5;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	
	//判断搜索类型
	if($event == 'key_word'){
		//分页
		$all_nm =  $db->select('contents',array(array('contents`.`key_words','LIKE','%,'.$search.',%')),'order by `contents`.`id` desc','count(id)');
		$all_nm = $all_nm[0]['count(id)'];
		$page = new page($all_nm,$limit,'search.php?event='.$event.'&search='.$search,$page);
		
		//数据获取
		$contents = $db->select('contents',array(array('contents`.`key_words','LIKE','%'.$search.'%')),'order by `contents`.`id` desc limit '.$page->get_limit_start().','.$limit,'*,`contents`.`id` as `c_id`',"left join `users` on `users`.`id` = `contents`.`user_id`");
		//高亮
		foreach($contents as $k => $v){
			$contents[$k]['key_words'] = preg_replace('/('.$search.')/i','<span style="color:red">'.$search.'</span>',$v['key_words']);
		}
	}elseif($event == 'search'){
		//分页
		$all_nm =  $db->select('contents',NULL,'where `contents`.`content` LIKE "%'.$search.'%" or `contents`.`title` LIKE "%'.$search.'%" order by `contents`.`id` desc','count(id)');
		$all_nm = $all_nm[0]['count(id)'];
		$page = new page($all_nm,$limit,'search.php?event='.$event.'&search='.$search,$page);
		
		//数据获取
		$contents = $db->select('contents',NULL,'where `contents`.`content` LIKE "%'.$search.'%" or `contents`.`title` LIKE "%'.$search.'%" order by `contents`.`id` desc limit '.$page->get_limit_start().','.$limit,'*,`contents`.`id` as `c_id`',"left join `users` on `users`.`id` = `contents`.`user_id`");
		//高亮
		foreach($contents as $k => $v){
			$contents[$k]['title'] = preg_replace('/('.$search.')/i','<span style="color:red">$1</span>',$v['title']);
			$contents[$k]['content'] = preg_replace('/('.$search.')/i','<span style="color:red">$1</span>',strip_tags($v['content']));
		}
	}

	
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
        
        </div><!--left end-->
         <?php include('sidebar.php'); ?>
    </div><!--warp end-->
</div><!--content end-->
<?php include('footer.php'); ?>