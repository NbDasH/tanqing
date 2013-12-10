<div class="banner">
	<div class="warp">
    	<div class="imgs">
        	<?php
            	$b_db = new db;
				$banners = $b_db->select('banners');
			?>
            <a href="http://<?php echo $banners[0]['link']; ?>"><img src="img/b1.jpg" style="z-index:1"></a>
            <a href="http://<?php echo $banners[1]['link']; ?>"><img src="img/b2.jpg"></a>
            <a href="http://<?php echo $banners[2]['link']; ?>"><img src="img/b3.jpg"></a>
        </div>
        <ul class="btns">
        	<li class="hover">1</li>
            <li>2</li>
            <li>3</li>
        </ul>
    </div>
</div>	
