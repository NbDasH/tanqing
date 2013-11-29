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
	
	$key_words = $db->select('key_words');
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>

<?php foreach($contents as $v){ ?>
    <h3>
        <?php echo "<a href='show.php?id=".$v['c_id']."'>".$v['title']."</a>"; ?>
    </h3>
    <div style="height:500px; overflow:hidden;">
        <?php echo $v['content']; ?>
    </div>
    <div>
        <?php 
        foreach(key_word_encode($v['key_words']) as $v){
            echo "<a href='search.php?event=key_word&amp;search=$v'>$v</a> | ";
        }
        ?>
    </div>
    
    <br />
    <br />
    <br />
    <br />
<?php } ?>

<?php
	//分页
	echo $page->get_page();
?>

关键字
<p>
	<?php
		foreach($key_words as $v){
			echo "<a href='search.php?event=key_word&amp;search=".$v['key_word']."'>".$v['key_word']."</a> | ";
		}
	?>
</p>

</body>
</html>