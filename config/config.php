<?php
	session_start();
	date_default_timezone_set('PRC');
	
	require_once('db_config.php');
	require_once('function.php');
	
	if(!empty($_POST)){
		$_POST = data_check($_POST);
	}
	
	if(!empty($_GET)){
		$_GET = data_check($_GET);
	}
	
?>