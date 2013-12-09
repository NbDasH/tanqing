<div class="nav">
	<ul>
    <!--如果没有登陆，不显示导航内容-->
    	<li><a href="global_config.php" <?php if(pageName()=='global_config.php') echo 'class="current"'; ?>>全局设置</a></li>
        <li><a href="banner_manager.php" <?php if(pageName()=='banner_manager.php') echo 'class="current"'; ?>>Banner修改</a></li>
        <li>
        	<a href="content_list.php" <?php if(pageName()=='content_list.php') echo 'class="current"'; ?>>文章管理</a>
            <ul>
            	<li><a href="content_manager.php?event=add">添加新文章</a></li>
            </ul>        
        </li>
        <li><a href="key_word_manager.php?event=list"  <?php if(pageName()=='key_word_manager.php') echo 'class="current"'; ?>>标签管理</a></li>
        <li><a href="message_manager.php"  <?php if(pageName()=='message_manager.php') echo 'class="current"'; ?>>评论管理</a></li>
        <li><a href="user_list.php"  <?php if(pageName()=='user_list.php') echo 'class="current"'; ?>>成员管理</a></li>
        <li><a href="index.php" style="color:blue;">网站首页</a></li>
        <li><a href="logout.php" style="color:red;">退出管理</a></li>
        
    </ul>
</div>