<?php
	require_once('config/config.php');
	
	admin_validate();

	//删除
	if(isset($_GET['event']) && $_GET['event'] == 'del'){
		
		$id = $_GET['id'];
		$db = new db;
		$key_words = $db->select('key_words',array('id'=>$id));
		$key_word = $key_words[0]['key_word'];
		
		$contents = $db->select('contents',array(array('key_words','LIKE','%,'.$key_word.',%')));
		
		foreach($contents as $v){
			echo $key_words = str_replace($key_word.',','',$v['key_words']);
			if($key_words == ','){
				$key_words = '';
			}
			$db->update('contents',array('key_words'=>$key_words),array('id'=>$v['id']));
		}
		
		$db->del('key_words',array('id'=>$id));
		
		jump('key_word_manager.php?event=list');
		exit();
	}
	
	if(!empty($_POST)){
		$id = $_POST['id'];
		$weight = $_POST['weight'];
		$db = new db;
		$db->update('key_words',array('weight'=>$weight),array('id'=>$id));
		
		jump('key_word_manager.php?event=list');
		exit();
	}
	
	$db = new db;
	
	$key_words = $db->select('key_words');
	
	
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>

<table>
	<tr>
    	<td>id</td>
        <td>name</td>
        <td>do</td>
    </tr>
    <?php foreach($key_words as $v){ ?>
    <tr>
    	<td><?php echo $v['id']; ?></td>
        <td><?php echo $v['key_word']; ?></td>
        <td>
        	<a href="key_word_manager.php?event=del&id=<?php echo $v['id']; ?>">删除</a>
        	<form action="" method="post">
            	<input type="hidden" name="id" value="<?php echo $v['id']; ?>" />
                <input type="text" name="weight" value="<?php echo $v['weight']; ?>" />
                <input type="submit" value="确认" />
           	</form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>