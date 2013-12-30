<?php
	session_start();
	require_once('php-sdk/facebook.php');

	ini_set("log_errors", 1);
	ini_set("error_log", "./errorlog.log");

	$configs = $_SESSION['configs'];
	$likeId = (string)$_POST['id'];
	$appIndex = ($_POST['index'])%(count($configs));

	try {
		$facebook = new Facebook($configs[$appIndex]);
		$apiRet = $facebook->api('/'.$likeId.'/likes', 'post');
	} catch (Exception $e) {
		$apiRet = array('error' => array('message' => 'facebook exception in php file'));
	}

	$ret = json_encode($apiRet);

	$success = true;
	echo $ret;
?>
