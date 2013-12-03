<?php
	//array()的简写
	function a(){
		return func_get_args();
	}
	
	//防注入
	function data_check($arr){
		$data = array();
		foreach($arr as $k => $v){
			if($k == 'content'){
				$data[addslashes($k)] = addslashes($v);
			}else{
				$data[addslashes(strip_tags($k))] = addslashes(strip_tags($v));
			}
		}
		return $data;
	}
	
	//跳转
	function jump($url){
		echo "<script>location='$url';</script>";
	}
	
	//添加关键字
	function set_keyword($key_words){
		$key_word = '';
		$key_words = str_replace(' ','',$key_words);
		$key_word_arr = explode(',',$key_words);
		$db = new db;
		
		foreach($key_word_arr as $v){
			if(!empty($v)){
				$key_word .= ','.$v;
				$search = $db->select('key_words',array('key_word'=>$v));
				if(empty($search)){
					$db->insert('key_words',array('key_word'=>$v));
				}
			}
		}
		
		if(!empty($key_word)){
			return $key_word.',';
		}else{
			return $key_word;
		}
		
	}
	
	//格式化首页关键字链接
	function key_word_encode($key_words){
		$key_words = substr($key_words,1,-1);
		
		if(!empty($key_words)){
			return explode(',',$key_words);
		}else{
			return array();
		}
		
	}
	
	//判断登陆
	function user_validate(){
		if(!isset($_SESSION['user'])){
			jump('login.php');
			exit();
		}
	}
	
	//判断管理员登陆
	function admin_validate(){
		user_validate();
		if($_SESSION['user']['user_event'] < 2){
			jump('login.php');
			exit();
		}
	}
	
	//超级管理员登陆
	function super_admin_validate(){
		user_validate();
		if($_SESSION['user']['user_event'] < 3){
			jump('login.php');
			exit();
		}
	}
	
	//从文档中获取第一个img的src
	function get_imgsrc($content){
		$result = preg_match('/<img.{0,5}src=\"?(.{0,90}\.(jpg|gif|bmp|bnp|png))?\" .{0,70}\/>/i',$content,$matches);
		if($result){
			return $matches["1"];
		}else{
			return false;	
		}
	}
	
	//设置680像素的图片
	function get_small($url){
		$name = explode('.',$url);
		return $name[0].'_small.'.$name[1];
	}
	
	//设置320宽度的图片
	function get_phone($url){
		$name = explode('.',$url);
		return $name[0].'_phone.'.$name[1];
	}
	
	//验证非空字段
	function get_err($arr){
		$err =array();
		foreach($arr as $k=>$v){
			if(empty(trim($v))){
				$err[$k] = '不能为空！';
			}
		}
		return $err;
	}
	
	//详细页中的内容 清除第一张图 将剩余的图变小图
	function show_content($content){
		preg_match_all('/<img.{0,5}src=\"?(.{0,90}\.(jpg|gif|bmp|bnp|png))?\" .{0,70}\/>/i',$content,$matches);

		foreach($matches[0] as $k => $v){
			if($k == 0){
				$content = str_replace($v,'',$content);
			}else{
				$content = str_replace($v,'<img src="'.get_small($matches[1][$k]).'" >',$content);
			}
		}
		
		return $content;
	}
	
	//格式化输出关键字
	function get_list_key_words($key_words){
		$str = '';
		foreach($key_words as $k => $v){
			if($k == count($key_words)-1){
				$str.='<li><a href="search.php?event=key_word&amp;search='.$v.'">'.$v.'</a></li>';
			}else{
				$str.='<li><a href="search.php?event=key_word&amp;search='.$v.'">'.$v.'</a> | </li>';
			}
		}	
		return $str;
	}
	
?>