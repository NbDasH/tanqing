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
	$key_words = $db->select('key_words');
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>

<form action="search.php" method="get">
	<input type="hidden" name="event" value="search" />
	<input type="text" name="search" />
    <input type="submit" />
</form>


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