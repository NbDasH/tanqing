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
<?php include('admin_header.php'); ?>
<?php include('admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="#">标签管理</a>
</div>
<div class="content">
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

<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->

</div><!--content end-->
<?php include('admin_footer.php'); ?>