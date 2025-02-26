<?php 
	if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost")) > 0){
		$db = mysqli_connect("localhost", "root", "12345678", "golfweather");
		$db -> set_charset("utf8");
	}elseif(strlen(strpos($_SERVER['HTTP_HOST'], "fusia.co.za")) > 0){
		$db = mysqli_connect("sql16.jnb2.host-h.net", "fusiaa_5", "b2FFktE4YnVi29w7d2Va", "fusiaa_db5");
		$db -> set_charset("utf8");
	}else{
		$db = mysqli_connect("69.48.142.81", "golfweat_dev", "1GzoXigK8lq(", "golfweat_db");
		$db -> set_charset("utf8");
	}

