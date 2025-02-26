<?php
	session_start();
	require_once("includes/dbconni.php");
	
	if(isset($_POST['cID']) && isset($_POST['cID'])){
		$cID = $_POST['cID'];
		setcookie('lastCourse', ''.$cID.'', time() + (86400 * 30), "/");
		setcookie('lastFav', ''.$cID.'', time() + (86400 * 30), "/");
	}
