<?php
	session_start();
	require_once('php-sdk/facebook.php');

	if($_POST['index'] < 0){
		$config = $_SESSION['config'];
	}
	else{
		$configs = $_SESSION['configs'];
		$appIndex = ($_POST['index'])%(count($configs));
		$config = $configs[$appIndex];
	}

	$likeId = (string)$_POST['id'];
	try {
		$facebook = new Facebook($config);
		$apiRet = $facebook->api('/'.$likeId.'/likes', 'post');
	} catch (Exception $e) {
		$apiRet = array('error' => array('message' => 'from php: '.$e->getMessage()));
	}

	$ret = json_encode($apiRet);

	$success = true;
	echo $ret;
?>
