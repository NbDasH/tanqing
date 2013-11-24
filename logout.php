<?php
	require_once('config/config.php');
	unset($_SESSION['user']);
	jump('index.php');
?>