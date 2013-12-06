<div class="footer">
	<div class="warp">
    	<?php echo $CONFIG['page_footer']; ?> <a href='content_list.php'>后台管理</a>
        <?php if(isset($_SESSION['user'])){/*将来做成登陆了再显示*/} ?>
    </div>
</div>	


<style>
.footer{ height:100px; color:#ccc; padding-top:10px; margin-top:20px;}/*az:2013-12-7 客户要求脚部不要太高*/
.footer a{ color:red;}
.main{ min-height:700px;}

</style>



<script type="text/javascript"  src="cssjs/jquery-2.0.1.js"></script>
<script type="text/javascript" src="cssjs/silder.js"></script>
<script src="cssjs/bigImg.js"></script>