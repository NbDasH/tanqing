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
				$key_word .= $v.',';
				$search = $db->select('key_words',array('key_word'=>$v));
				if(empty($search)){
					$db->insert('key_words',array('key_word'=>$v));
				}
			}
		}
		
		return substr($key_word,0,-1);
	}
	
	//格式化首页关键字链接
	function key_word_encode($key_words){
		$key_word = '';
		return $key_word_arr = explode(',',$key_words);
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
		if($_SESSION['user']['user_event'] != 1){
			jump('login.php');
			exit();
		}
	}
	
	function get_imgsrc($content){
		$strr= preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))?\" .+>/i',$content,$matches);
		return $matches["1"];
	}
	
	function get_small($url){
		$name = explode('.',$url);
		return $name[0].'_small.'.$name[1];
	}
	
?>