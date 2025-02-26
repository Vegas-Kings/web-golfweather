<?php
	session_start();
	require_once("includes/dbconni.php");
	
	if(isset($_POST['mOpt']) && isset($_POST['mVal'])){
		$mOpt = $_POST['mOpt'];
		$mVal = $_POST['mVal'];
		
		if($mOpt == 'time'){ setcookie('timeOptCook', ''.$mVal.'', time() + (86400 * 365), "/"); }
		if($mOpt == 'temp'){ setcookie('tempOptCook', ''.$mVal.'', time() + (86400 * 365), "/"); }
		if($mOpt == 'wind'){ setcookie('windOptCook', ''.$mVal.'', time() + (86400 * 365), "/"); }
		if($mOpt == 'rain'){ setcookie('rainOptCook', ''.$mVal.'', time() + (86400 * 365), "/"); }
	}
