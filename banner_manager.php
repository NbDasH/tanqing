<?php
	require_once('config/config.php');
	
	admin_validate();
	
	$db = new db;
	$banner = $db->select('banners');
	
	if(!empty($_POST)){
		//处理上传的banner
		for($i=1;$i<=3;$i++){
			$value = $_FILES['banner'];
			if(!empty($value['tmp_name'][$i])){
				require_once('config/resizeimage.php');
				if(in_array($value['type'][$i],array('image/gif','image/png','image/jpeg','image/jpg'))){
					$type = strtolower(substr(strrchr($value['name'][$i],"."),1));
					$rand = rand();
					$tmp = $rand.'.'.$type;
					move_uploaded_file($value['tmp_name'][$i],'tmp/'.$tmp);
					new resizeimage('tmp/'.$tmp, "910", "1", "0","img/b".$i.".jpg");
					unlink('tmp/'.$tmp);
				}
			}
		}
		
		//处理上传的ad
		if(!empty($_FILES['ad']['tmp_name'])){
			require_once('config/resizeimage.php');
			if(in_array($_FILES['ad']['type'],array('image/gif','image/png','image/jpeg','image/jpg'))){
				$type = strtolower(substr(strrchr($_FILES['ad']['name'],"."),1));
				$rand = rand();
				$tmp = $rand.'.'.$type;
				move_uploaded_file($_FILES['ad']['tmp_name'],'tmp/'.$tmp);
				new resizeimage('tmp/'.$tmp, "210", "1", "0","img/ad.jpg");
				unlink('tmp/'.$tmp);
			}
		}
		
		$i=1;
		foreach($_POST['banner_link'] as $v){
			$db->update('banners',array('link'=>$v),array('id'=>$i));
			$i++;
		}
		
		jump('banner_manager.php');
		
	}
	
?>
<?php include('template/admin_header.php'); ?>
<?php include('template/admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="user_list.php">Banner 修改</a>
</div>
<div class="content">

<h5>Banner1</h5>
<form action="" method="post" enctype="multipart/form-data">
	
    <img src="img/b1.jpg?rand=<?php echo rand(); ?>" width="90" style="border:1px solid #eee;" />
	<input type="file" name="banner[1]">
    url:
    <input type="text" name="banner_link[]" value="<?php echo $banner[0]['link'] ?>" class="input2">
    <br />

    <img src="img/b2.jpg?rand=<?php echo rand(); ?>" width="90"  style="border:1px solid #eee;"/>
    <input type="file" name="banner[2]">
    url:
    <input type="text" name="banner_link[]" value="<?php echo $banner[1]['link'] ?>" class="input2">
    <br />

    <img src="img/b3.jpg?rand=<?php echo rand(); ?>"width="90"  style="border:1px solid #eee;"/>
    <input type="file" name="banner[3]">
    url:
    <input type="text" name="banner_link[]" value="<?php echo $banner[2]['link'] ?>" class="input2">
    <br /><br /><br /><br />
    <h5>侧栏广告(ad)</h5>
    <img src="img/ad.jpg?rand=<?php echo rand(); ?>" width="90"  style="border:1px solid #eee;"/>
    <input type="file" name="ad">
    url:
    <input type="text" name="banner_link[]" value="<?php echo $banner[3]['link'] ?>" class="input2">
    <br />
    <input type="submit" value="提交" class="btn_form btn_link">
</form>

<div class="description">
	<span class="redFont">*</span> 
	Banner建议大小是 910px X 300px， 而侧栏广告的大小建议使用宽度为 210px
</div><!--描述 end-->
</div><!--content end-->
<?php include('template/admin_footer.php'); ?>