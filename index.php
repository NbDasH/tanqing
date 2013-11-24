<?php
	require_once('config/config.php');
	
	$db = new db;
	
	$contents = $db->select('contents',NULL,'order by `contents`.`id` desc limit 0,5','*,`contents`.`id` as `c_id`',"left join `users` on `users`.`id` = `contents`.`user_id`");
	
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