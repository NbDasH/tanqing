var time;
var index=1;
$(function(){
	show(index);	
	$(".btns li").hover(function(){
		  clearTimeout(time);	
		  index=$(".btns li").index(this)+1;
  		  $(".btns li").removeClass("hover").eq(index-1).addClass("hover");
	 	  $(".imgs img").hide().stop(true,true).eq(index-1).fadeIn("slow");	
	},function(){
		  index = index + 1 > 3 ? 1 : index+1;
		 time = setTimeout("show(" + index + ")", 3000);
	})
})

function show(index){
	$(".btns li").removeClass("hover").eq(index-1).addClass("hover");
	 $(".imgs img").hide().stop(true,true).eq(index-1).fadeIn("slow");
	  index = index + 1 > 3 ? 1 : index+1;
	 time = setTimeout("show(" + index + ")", 3000);
}
		


