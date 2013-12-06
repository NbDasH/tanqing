// JavaScript Document
$(function(){
	
	var timer; //az:2013-12-7 定义全局对象，方便清除
	
	
	$(".articleContent img").click(function(){
		var oImg=$(this).attr("src");
		var bImg=oImg.replace(/_small/, "");
		$(".show img").attr("src",bImg);
		
	
		
		
		timer = setTimeout(function(){
			var l=($(window).width()-$(".show").width())/2;
			$(".show").css("left",l);
			$(".show").fadeIn(100);	
			$(".bg").fadeIn(100);	
		},100)
			
		
		
	})
	
	$(".bg").click(function(){
			$(".show").fadeOut(100);	
			$(".bg").fadeOut(100);	
			clearTimeout(timer)
	})
	$(".show span").click(function(){
			$(".show").fadeOut(100);	
			$(".bg").fadeOut(100);	
			clearTimeout(timer)
	})
})