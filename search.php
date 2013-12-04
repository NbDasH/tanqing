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
	$limit = $CONFIG['page_limit'];
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
			//$contents[$k]['key_words'] = preg_replace('/('.$search.')/i','<span style="color:red">'.$search.'</span>',$v['key_words']);
			$contents[$k]['content'] = strip_tags($v['content']);
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
                                    <p><?php echo $v['content']; ?></p>
            
                                    
                            </li>
            <?php } ?>
            </ul>            
        
        <?php
            //分页
            echo $page->get_page();
        ?>
        
        </div><!--left end-->
         <?php include('template/sidebar.php'); ?>
    </div><!--warp end-->
</div><!--content end-->
<?php include('template/footer.php'); ?>