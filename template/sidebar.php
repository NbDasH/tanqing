<?php
//获取关键字
$key_words = $db->select('key_words',NULL,'order by weight desc limit 0,20');
?>
<div class="sidebar right">

			
        	<div class="about">
            	<h3>关于我们(About)</h3>
                <?php if($CONFIG['weibo_btn']==1){ ?>
                <ul class="share">
                	<li><a href="#" class="s1"></a></li>
                    <li><a href="#" class="s2"></a></li>
                    <li><a href="#" class="s3"></a></li>
                    <li><a href="#" class="s4"></a></li>
                </ul>
                <?php } ?>
            </div>
            
            <!--做一个开关，可以开启或关闭它-->
            <?php
            	if($CONFIG['ad_visible']==1){
					$b_db = new db;
					$banners = $b_db->select('banners');
					if(empty($banners[3]['link'])){
			?>
            	<div class="ad"><img src="img/ad.jpg"></div>
            <?php }else{ ?>
            	<div class="ad"><a href="http://<?php echo $banners[3]['link']; ?>"><img src="img/ad.jpg"></a></div>
			<?php }} ?>
            <div class="search">
            	<form action="../search.php" method="get">
                	<input type="hidden" name="event" value="search" />
                	<input type="text" name="search" class="text" value="输入文章关键字" id="search">
                    <input type="submit" class="btn" value="查">
                </form>
            </div>   
            <div class="tags">
            	<h4>热门标签：</h4>

                <?php
				foreach($key_words as $v){
					echo "<li><a href='search.php?event=key_word&amp;search=".$v['key_word']."'>".$v['key_word']."</a></li>";
				}
				?>
                </ul>
            </div>
        </div><!--right end-->