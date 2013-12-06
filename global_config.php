<?php
	require_once('config/config.php');
	
	admin_validate();
	
	$db = new db;
	
	if(!empty($_POST)){
		$data['page_limit'] = $_POST['page_limit'];
		$data['page_footer'] = $_POST['page_footer'];
		$data['ad_visible'] = isset($_POST['ad_visible']) ? 1 : 0;
		$data['weibo_btn'] = isset($_POST['weibo_btn']) ? 1 : 0;
		foreach($data as $k => $v){
			$db->update('global_config',array('config_value'=>$v),array('config_name'=>$k));
		}
		jump('global_config.php');
	}
	
	
?>
<?php include('template/admin_header.php'); ?>
<?php include('template/admin_nav.php'); ?>
<div class="location">
<!--如果没有登陆，不显示面包屑-->
<a href="#">返回后台首页</a> >> <a href="user_list.php">全局设置</a><?php if(isset($_GET['event']))if($_GET['event']=='add')echo " >>  添加新成员";else echo " >>  编辑成员";?>
</div>
<div class="content">

<form action="" method="post" enctype="multipart/form-data">
	页面显示文章的条目数:
    <select name="page_limit">
    	<?php
        	$nm = array(5,10,15,20,25,30);
			foreach($nm as $v){
				if($CONFIG['page_limit'] == $v){
					echo "<option selected='selected'>".$v."</option>";
				}else{
					echo "<option>".$v."</option>";
				}
			}
		?>
    </select>
    <br />
    页脚信息:
    <input type="text" name="page_footer" value="<?php echo $CONFIG['page_footer']; ?>" class="input2">
    <br />
    右侧广告开关:
    <input type="checkbox" name="ad_visible" value="1" <?php if($CONFIG['ad_visible'] == 1){echo 'checked="checked"';} ?> />
    <br />
    分享按钮开关:
    <input type="checkbox" name="weibo_btn" value="1" <?php if($CONFIG['weibo_btn'] == 1){echo 'checked="checked"';} ?> />
    <br /><br /><br />
    <input type="submit" value="提交" class="btn_form btn_link">
</form>

<div class="description">
	<span class="redFont">*</span> 
	说点什么
</div><!--描述 end-->
</div><!--content end-->
<?php include('template/admin_footer.php'); ?>