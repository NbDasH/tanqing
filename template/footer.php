<div class="footer">
	<div class="warp">
    	<?php echo $CONFIG['page_footer']; ?> <a href='content_list.php'>后台管理</a>
        <?php if(isset($_SESSION['user'])){/*将来做成登陆了再显示*/} ?>
    </div>
</div>	


<style>
a:hover{ text-decoration:underline}

.banner .imgs{overflow:hidden; height:299px;}
.banner .imgs img{ position:static;}


.article h4 a{ color:black;}
.article h4 a:hover{ color:#900;}
.article .articleMainImg{ height:200px; overflow:hidden; clear:both;} /*az:2013-12-7 解决溢出，以及一点点小图定位问题*/


.footer{ height:100px; color:#ccc; padding-top:10px; margin-top:20px;}/*az:2013-12-7 客户要求脚部不要太高*/
.footer a{ color:red;}
.main{ min-height:700px;}


/*侧栏元素*/
.btn:hover{ background:#000; color:#fff; cursor:pointer;}
.about h3:hover{background:#000; color:#fff; cursor:pointer;}
.sidebar .ad{ height:auto; background:#FFF;}

</style>




<script type="text/javascript"  src="cssjs/jquery-2.0.1.js"></script>
<script type="text/javascript" src="cssjs/silder.js"></script>
<script src="cssjs/bigImg.js"></script>

<script>
/*侧栏脚本*/
			$(function(){
				var val = '输入文章关键字';
				$("#search").focus(function(){
					if($(this).val()==val)
						$(this).val('');				
				})
				
				$("#search").blur(function(){
					 if($(this).val() == "")
						$(this).val(val);	
				})
			})
			
/*回复*/

	$('.reply').click(function(){
		$(this).next('.reply_form').slideDown(100);	
	})
</script>