<?php
	session_start();
	require_once("includes/dbconni.php");

	$dirAdj = '';
	
	$metaDescription = "Golfweather.com is focused on the delivery of accurate weather forecasts pin pointed to your local golf course.";
	$metaKey = "Weather, golfweather, golf weather, weather feed, golf course, local golf course weather, hyper local weather forecast, Cape Town Weather, Golf tip, putting, driver, weather widget, golf clubs,";
	$metaTitle = "Get your Weather Forecast for your local Golf Course";
	
	function filename_safe($filename) {
		$temp = $filename;
		$temp = strtolower($temp);
		$temp = str_replace(" ", "_", $temp);
		$result = '';
		for ($i=0; $i<strlen($temp); $i++) {
			if (preg_match('([0-9]|[a-z]|_)', $temp[$i])) {
				$result = $result . $temp[$i];
			}
		}
		return str_replace("_", "-", $result);
	}

	function decodeText($_str, $_form) { $trans_tbl = get_html_translation_table (HTML_ENTITIES); $trans_tbl = array_flip ($trans_tbl); $_str      = strtr($_str, $trans_tbl); if ($_form) { $_nl = "\r\n"; } else { $_nl = "<br />"; } $_str = str_replace("#BR#", "$_nl", $_str); return($_str); }
	function html2text($html){ $tags = array ( 0 => '~<h[123][^>]+>~si', 1 => '~<h[456][^>]+>~si', 2 => '~<table[^>]+>~si', 3 => '~<tr[^>]+>~si', 4 => '~<li[^>]+>~si', 5 => '~<br[^>]+>~si', 6 => '~<p[^>]+>~si', 7 => '~<div[^>]+>~si', ); $html = preg_replace($tags,"\n",$html); $html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html); $html = preg_replace('~<[^>]+>~s','',$html); $html = preg_replace('~ +~s',' ',$html); $html = preg_replace('~^\s+~m','',$html); $html = preg_replace('~\s+$~m','',$html); $html = preg_replace('~\n+~s',"\n",$html); $html = str_replace('&lsquo;', '', $html); $html = str_replace('&rsquo;', '', $html); return $html; }

	function getCountryName($countryId,$db){
		$countryName = '';
		$getQuery = "select name from countries where upper(id)='".strtoupper($countryId)."'";
		$getQueryRes = mysqli_query($db,$getQuery);
		$countNumD = mysqli_num_rows($getQueryRes);
		if ($countNumD > 0){
			$getRes = mysqli_fetch_array($getQueryRes);
			$countryName = $getRes['name'];
		}
		mysqli_free_result($getQueryRes);
		return $countryName;
	}

	function get_client_ip() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
	
	$ipAdd = get_client_ip();

	if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost")) > 0 || $ipAdd == '169.1.255.59'){
		error_reporting(E_ALL); 
		ini_set('display_errors', '1'); 
	}else{
		error_reporting(E_ALL); 
		ini_set('display_errors', '0'); 
	}

	$curpageMain = $_SERVER['REQUEST_URI'];
	$curpageMain = str_replace('/www.golfweather.com/', '', $curpageMain);
	$curpageMain = str_replace('/golfweather/', '', $curpageMain);
	$curpageMain = str_replace('/test/', '', $curpageMain);

	if(!isset($_COOKIE['timeOptCook'])) { $timeOpt = 12; }else{ $timeOpt = $_COOKIE['timeOptCook']; }
	if(!isset($_COOKIE['tempOptCook'])) { $tempOpt = 'C'; }else{ $tempOpt = $_COOKIE['tempOptCook']; }
	if(!isset($_COOKIE['windOptCook'])) { $windOpt = 'kmh'; }else{ $windOpt = $_COOKIE['windOptCook']; }
	if(!isset($_COOKIE['rainOptCook'])) { $rainOpt = 'mm'; }else{ $rainOpt = $_COOKIE['rainOptCook']; }

	if($tempOpt == 'C'){ $tempCol = 'temp_celsius'; $tempHigh = 'hi_cel'; $tempLow = 'lo_cel'; $tempDeg = '&deg;C'; }
	if($tempOpt == 'F'){ $tempCol = 'temp_fahrenheit'; $tempHigh = 'hi_fahr'; $tempLow = 'lo_fahr'; $tempDeg = '&deg;F'; }
	if($windOpt == 'kmh'){ $windCol = 'wind_speed_kmh'; }else{ $windCol = 'wind_speed_mph'; }
	if($rainOpt == 'mm'){ $rainCol = 'precip_mm_3hr'; $rainColSum = 'precip_mm';  }else{ $rainCol = 'precip_in_3hr'; $rainColSum = 'precip_in';  }
	if($timeOpt == 12){ $timeHour = 'h'; }else{ $timeHour = 'H'; }



	$dirCount = substr_count($curpageMain,"/");
	
	if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost")) > 0 || strlen(strpos($_SERVER['HTTP_HOST'], "fusia.co.za")) > 0 || strlen(strpos($_SERVER['HTTP_HOST'], "69.48.142.81")) > 0){
		for($d=1;$d<=$dirCount;$d++){ $dirAdj .= '../golfweather-v2/'; }
	}else{
		$dirAdj = '/';
	}

	require_once('includes/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$geoCountryCode = $geoplugin->countryCode;
	
	if($geoCountryCode == ''){
		$geoCountryCode = 'za';
		$geoRegion = 'Western Cape';
		$geoCountryName = 'South Africa';
		$geoCity = 'Cape Town';
		$geoTimezone = 'Africa/Johannesburg';
		if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost")) > 0 || $ipAdd == '169.1.255.59'){
			/*
			$geoCountryCode = 'gb';
			$geoRegion = 'England';
			$geoCountryName = 'United Kingdom';
			$geoCity = 'Canary Wharf';
			$geoTimezone = 'Europe/London';

			$geoCountryCode = 'us';
			$geoRegion = 'Texas';
			$geoCountryName = 'United States';
			$geoCity = 'Austin';
			$geoTimezone = 'America/Chicago';

			$geoCountryCode = 'au';
			$geoRegion = 'Australian Capital Territory';
			$geoCountryName = 'Australia';
			$geoCity = 'Canberra';
			$geoTimezone = 'Australia/Sydney';

			$geoCountryCode = 'za';
			$geoRegion = 'Gauteng';
			$geoCountryName = 'South Africa';
			$geoCity = 'Johannesburg';
			$geoTimezone = 'Africa/Johannesburg';

			$geoCountryCode = 'ie';
			$geoRegion = 'Leinster';
			$geoCountryName = 'Ireland';
			$geoCity = 'Raheny';
			$geoTimezone = 'Europe/Dublin';
			*/
		}
	}else{
		$geoCity = $geoplugin->city;
		$geoRegion = $geoplugin->region;
		$geoRegionCode = $geoplugin->regionCode;
		$geoRegionName = $geoplugin->regionName;
		$geoDMACode = $geoplugin->dmaCode;
		$geoCountryName = $geoplugin->countryName;
		$geoCountryCode = $geoplugin->countryCode;
		$geoInEU = $geoplugin->inEU;
		$geoLatitude = $geoplugin->latitude;
		$geoLongitude = $geoplugin->longitude;
		$geoTimezone = $geoplugin->timezone;
	}

	date_default_timezone_set($geoTimezone);
	
	$sqlRegionOrder = '';
	$sqlRegionExtra = '';

	if($geoCity != ''){
		$sqlRegionOrderSum = "FIELD(lower(feedregion), '".strtolower(str_replace(' ', '', $geoRegion))."') DESC, ";
		$sqlRegionOrder = "FIELD(lower(region_name), '".strtolower(str_replace(' ', '', $geoRegion))."') DESC, ";
		$sqlRegionExtra = "and lower(region_name) = '".strtolower(str_replace(' ', '', $geoRegion))."'";
		//$sqlRegionOrder = "FIELD(lower(feedregion), '".strtolower(str_replace(' ', '', $geoRegion))."') DESC, FIELD(lower(city), '".strtolower($geoCity)."') DESC, ";
	}
	
	if($geoRegion != ''){
		$sqlRegionOrder .= "FIELD(lower(address2), '".strtolower($geoRegion)."') DESC, ";
		$sqlRegionOrderSum .= "FIELD(lower(address2), '".strtolower($geoRegion)."') DESC, ";
		$sqlRegionExtra = "and lower(address2) = '".strtolower($geoRegion)."'";
	}
	
	if($geoCity != '' && $geoRegion != ''){
		$sqlRegionExtra = "and (lower(region_name) = '".strtolower(str_replace(' ', '', $geoRegion))."' or lower(address2) = '".strtolower($geoRegion)."')";
	}

	$timeNow = mktime((date('H')), date('i'), date('s'), date('m'), date('d'), date('Y'));
	
	$lastHour = 19;
	if($geoCountryCode == 'za') {$lastHour = 20;}
	if($geoCountryCode == 'au') {$lastHour = 19;}
	if($geoCountryCode == 'ie') {$lastHour = 19;}
	if($geoCountryCode == 'gb') {$lastHour = 19;}
	if($geoCountryCode == 'us') {$lastHour = 19;}
	if($geoCountryCode == 'ca') {$lastHour = 18;}
	
	if(date('H') >= $lastHour){
		$todDate = date('Y-m-d '.$lastHour.':00');
		if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost")) > 0 || $ipAdd == '169.1.255.59'){
			//$todDate = date('2024-07-02 20:00');
		}
	}elseif(date('H') < 5){
		$todDate = date('Y-m-d 05:00');
	}else{
		$todDate = date('Y-m-d '.date('H').':00');
	}
	
	$todDateEnd = date('Y-m-d 23:59');
	$todDateSum = date('Y-m-d 00:01');

	if(isset($hp)){
		$getQueryNews = "select id, heading, status, newsText, commentDate, headlineImg from tbl_news where heading is not null and status=1 order by commentDate desc, heading limit 5";
		$getQueryResNews = mysqli_query($db,$getQueryNews);
		$countNumNews = mysqli_num_rows($getQueryResNews);
		if ($countNumNews > 0){
			$getResNews = mysqli_fetch_array($getQueryResNews);
			$iSum=0;
			while($iSum < $countNumNews){
			
				$BodyCopy = html2text(decodeText(trim($getResNews['newsText']), ""));
				$BodyCopy = str_replace("<p>", "", substr($BodyCopy, 0, 46)) . "...";

				if(!isset($news5Home[$iSum]['newsId'])){ $news5Home[$iSum]['newsId'] = $getResNews['id']; }
				if(!isset($news5Home[$iSum]['heading'])){ $news5Home[$iSum]['heading'] = trim($getResNews['heading']); }
				if(!isset($news5Home[$iSum]['newsIntro'])){ $news5Home[$iSum]['newsIntro'] = trim($BodyCopy); }
				if(!isset($news5Home[$iSum]['commentDate'])){ $news5Home[$iSum]['commentDate'] = $getResNews['commentDate']; }
				if(!isset($news5Home[$iSum]['headlineImg'])){ $news5Home[$iSum]['headlineImg'] = $getResNews['headlineImg']; }
			
				$iSum++;
				$getResNews = mysqli_fetch_array($getQueryResNews);
			}
		}
		mysqli_free_result($getQueryResNews);
	}

	if(strlen(strpos($curpageMain, "share-course")) > 0){
		$courseId = $_GET['courseId'];
		$getQuery = "select name, details, url, phone, address1, metakey, metadesc, country_id, latitude, longitude, tzone from courses c where c.id=".$courseId."";
		$getQueryRes = mysqli_query($db,$getQuery);
		$countNumD = mysqli_num_rows($getQueryRes);
		if ($countNumD > 0){
			$getRes = mysqli_fetch_array($getQueryRes);
			$courseCountryId = $getRes['country_id'];
			$courseCountry = getCountryName($getRes['country_id'],$db);
			$courseName = $getRes['name'];
			$courseDetails = $getRes['details'];
			$courseUrl = $getRes['url'];
			$coursePhone = $getRes['phone'];
			$courseAddress = $getRes['address1'];
		}
		mysqli_free_result($getQueryRes);
	}

	if(strlen(strpos($curpageMain, "/summary/")) > 0){
		$courseId = substr($curpageMain, strrpos($curpageMain, '/') + 1);
		if(is_numeric($courseId)){
			setcookie('lastCourse', ''.$courseId.'', time() + (86400 * 30), "/");
		}
		$getQuery = "select name, details, url, phone, address1, metakey, metadesc, country_id, latitude, longitude, tzone from courses c where c.id=".$courseId."";
		$getQueryRes = mysqli_query($db,$getQuery);
		$countNumD = mysqli_num_rows($getQueryRes);
		if ($countNumD > 0){
			$getRes = mysqli_fetch_array($getQueryRes);
			$courseCountryId = $getRes['country_id'];
			$courseCountry = getCountryName($getRes['country_id'],$db);
			$courseName = $getRes['name'];
			$courseDetails = $getRes['details'];
			$courseUrl = $getRes['url'];
			$coursePhone = $getRes['phone'];
			$courseAddress = $getRes['address1'];
			$courseLat = $getRes['latitude'];
			$courseLon = $getRes['longitude'];
			$longLat = $getRes['latitude'] . ' ' . $getRes['longitude'];
			$metaTitle = $getRes['name'] . ' | ' . $courseCountry . ' | Weather | GolfWeather.com';
			if($getRes['metakey'] != ''){$metaKey = $getRes['metakey'];}
			if($getRes['metadesc'] != ''){$metaDescription = $getRes['metadesc'];}

			$detailedCoursePageUrl = str_replace('/summary/', '/detailed/', $curpageMain);

			$getQuerySumm7 = "
				select 
					local_time, day_no, weekday, cf.".$tempHigh." as tempHigh, cf.".$tempLow." as tempLow, conditions, wind_dir_deg, wind_dir_desc, cf.".$windCol." as windSpeed, cf.".$rainColSum." as rainMeas, cf.pop_perc, icon, cf.rating, cf.sunrise, cf.sunset, cf.updated
				from 
					courses c
					join current_summary_feed cf on c.id = cf.course_id
				where 
					c.id=".$courseId."
					and lower(cf.country_id)='".strtolower($courseCountryId)."'
					#and lower(c.country_id)='".strtolower($geoCountryCode)."' 
				order by local_time
				limit 7
			";
			//echo $getQuerySumm7;
			$getQueryResSumm7 = mysqli_query($db,$getQuerySumm7);
			$countNumSumm7 = mysqli_num_rows($getQueryResSumm7);
			if ($countNumSumm7 > 0){
				$getResSumm7 = mysqli_fetch_array($getQueryResSumm7);
				$iSum=0;
				while($iSum < $countNumSumm7){
				
					if(!isset($summary7Page[$iSum]['local_time'])){ $summary7Page[$iSum]['local_time'] = $getResSumm7['local_time']; }
					if(!isset($summary7Page[$iSum]['weekday'])){ $summary7Page[$iSum]['weekday'] = $getResSumm7['weekday']; }
					if(!isset($summary7Page[$iSum]['tempHigh'])){ $summary7Page[$iSum]['tempHigh'] = $getResSumm7['tempHigh']; }
					if(!isset($summary7Page[$iSum]['tempLow'])){ $summary7Page[$iSum]['tempLow'] = $getResSumm7['tempLow']; }
					if(!isset($summary7Page[$iSum]['icon'])){ $summary7Page[$iSum]['icon'] = $getResSumm7['icon']; }
					if(!isset($summary7Page[$iSum]['conditions'])){ $summary7Page[$iSum]['conditions'] = $getResSumm7['conditions']; }
					if(!isset($summary7Page[$iSum]['rainMeas'])){ $summary7Page[$iSum]['rainMeas'] = $getResSumm7['rainMeas']; }
					if(!isset($summary7Page[$iSum]['pop_perc'])){ $summary7Page[$iSum]['pop_perc'] = $getResSumm7['pop_perc']; }
					if(!isset($summary7Page[$iSum]['rating'])){ $summary7Page[$iSum]['rating'] = $getResSumm7['rating']; }
					if(!isset($summary7Page[$iSum]['sunrise'])){ $summary7Page[$iSum]['sunrise'] = $getResSumm7['sunrise']; }
					if(!isset($summary7Page[$iSum]['sunset'])){ $summary7Page[$iSum]['sunset'] = $getResSumm7['sunset']; }
					if(!isset($summary7Page[$iSum]['wind_dir_deg'])){ $summary7Page[$iSum]['wind_dir_deg'] = $getResSumm7['wind_dir_deg']; }
					if(!isset($summary7Page[$iSum]['wind_dir_desc'])){ $summary7Page[$iSum]['wind_dir_desc'] = $getResSumm7['wind_dir_desc']; }
					if(!isset($summary7Page[$iSum]['windSpeed'])){ $summary7Page[$iSum]['windSpeed'] = $getResSumm7['windSpeed']; }
					if(!isset($summary7Page[$iSum]['updated'])){ $summary7Page[$iSum]['updated'] = $getResSumm7['updated']; }
				
					$iSum++;
					$getResSumm7 = mysqli_fetch_array($getQueryResSumm7);
				}
			}
			mysqli_free_result($getQueryResSumm7);
			
			$getQueryNear = '
				SELECT 
					c.id, c.name, local_time, day_no, weekday, cf.'.$tempHigh.' as tempHigh, cf.'.$tempLow.' as tempLow, conditions, wind_dir_deg, wind_dir_desc, cf.'.$windCol.' as windSpeed, cf.'.$rainColSum.' as rainMeas, cf.pop_perc, icon, cf.rating, cf.sunrise, cf.sunset, cf.updated,
					sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug,
					ST_Length(LineFromWKB(LineString(ST_GeomFromText("POINT('.$longLat.')"),coordinate))) AS `dist` 
				FROM 
					`courses` c
					join current_summary_feed cf on c.id = cf.course_id
					left join countries co on co.id = c.country_id
					left join sub_regions sr on sr.id = c.subregion_id
					left join geo_regions gr on gr.id = c.region_id
				WHERE 
					(ST_Length(LineFromWKB(LineString(ST_GeomFromText("POINT('.$longLat.')"),coordinate))) < 1.3508102970648) 
					AND (c.id not in ("'.$courseId.'")) AND (c.flow_state_id = 4) 
					AND cf.local_time >= "'.$todDate.'"
					AND cf.local_time <= "'.$todDateEnd.'"
					
				GROUP BY 
					c.id
				ORDER BY ST_Length(LineFromWKB(LineString(ST_GeomFromText("POINT('.$longLat.')"),coordinate))) asc 
				LIMIT 5
			';
			//echo '<pre>' . $getQueryNear . '</pre>';
			$getQueryResNear = mysqli_query($db,$getQueryNear);
			$countNumNear = mysqli_num_rows($getQueryResNear);
			if ($countNumNear > 0){
				$getResNear = mysqli_fetch_array($getQueryResNear);
				$iNear=0;
				while($iNear < $countNumNear){
				
					if(!isset($nearBy[$iNear]['courseId'])){ $nearBy[$iNear]['courseId'] = $getResNear['id']; }
					if(!isset($nearBy[$iNear]['name'])){ $nearBy[$iNear]['name'] = $getResNear['name']; }
					if(!isset($nearBy[$iNear]['tempHigh'])){ $nearBy[$iNear]['tempHigh'] = $getResNear['tempHigh']; }
					if(!isset($nearBy[$iNear]['icon'])){ $nearBy[$iNear]['icon'] = $getResNear['icon']; }
					if(!isset($nearBy[$iNear]['conditions'])){ $nearBy[$iNear]['conditions'] = $getResNear['conditions']; }
					
					if($getResNear['subregionslug'] != ''){
						$coursePageUrl = $getResNear['countryslug'].'/'.$getResNear['regionslug'].'/'.$getResNear['subregionslug'].'/'.filename_safe($getResNear['name']).'/summary/'.$getResNear['id'];
					}else{
						$coursePageUrl = $getResNear['countryslug'].'/'.$getResNear['regionslug'].'/region/'.filename_safe($getResNear['name']).'/summary/'.$getResNear['id'];
					}
					if(!isset($nearBy[$iNear]['coursePageUrl'])){ $nearBy[$iNear]['coursePageUrl'] = $coursePageUrl; }
				
					$iNear++;
					$getResNear = mysqli_fetch_array($getQueryResNear);
				}
			}
			mysqli_free_result($getQueryResNear);

		}
		mysqli_free_result($getQueryRes);
	}

	if(strlen(strpos($curpageMain, "/detailed/")) > 0){
		if(strlen(strpos($curpageMain, "?")) > 0){
			$curpageMain = substr($curpageMain, 0, strpos($curpageMain, '?'));
		}
		$courseId = substr($curpageMain, strrpos($curpageMain, '/') + 1);
		
		if(is_numeric($courseId)){
			setcookie('lastCourse', ''.$courseId.'', time() + (86400 * 30), "/");
		}
		$getQuery = "select name, details, url, phone, address1, metakey, metadesc, country_id, latitude, longitude, tzone from courses c where c.id=".$courseId."";
		$getQueryRes = mysqli_query($db,$getQuery);
		$countNumD = mysqli_num_rows($getQueryRes);
		if ($countNumD > 0){
			$getRes = mysqli_fetch_array($getQueryRes);
			$courseCountry = getCountryName($getRes['country_id'],$db);
			$courseName = $getRes['name'];
			$courseDetails = $getRes['details'];
			$courseUrl = $getRes['url'];
			$coursePhone = $getRes['phone'];
			$courseAddress = $getRes['address1'];
			$longLat = $getRes['latitude'] . ' ' . $getRes['longitude'];
			$metaTitle = $getRes['name'] . ' | ' . $courseCountry . ' | Weather | GolfWeather.com';
			if($getRes['metakey'] != ''){$metaKey = $getRes['metakey'];}
			if($getRes['metadesc'] != ''){$metaDescription = $getRes['metadesc'];}

			$detailedCoursePageUrl = str_replace('/summary/', '/detailed/', $curpageMain);
			$summaryCoursePageUrl = str_replace('/detailed/', '/summary/', $curpageMain);

			$getQuerySumm7 = "
				select 
					local_time, day_no, weekday, cf.".$tempHigh." as tempHigh, cf.".$tempLow." as tempLow, conditions, wind_dir_deg, wind_dir_desc, cf.".$windCol." as windSpeed, cf.".$rainColSum." as rainMeas, cf.pop_perc, icon, cf.rating, cf.sunrise, cf.sunset, cf.updated
				from 
					courses c
					join current_summary_feed cf on c.id = cf.course_id
				where 
					c.id=".$courseId."
				order by local_time
				limit 7
			";
			//echo $getQuerySumm7;
			$getQueryResSumm7 = mysqli_query($db,$getQuerySumm7);
			$countNumSumm7 = mysqli_num_rows($getQueryResSumm7);
			if ($countNumSumm7 > 0){
				$getResSumm7 = mysqli_fetch_array($getQueryResSumm7);
				$iSum=0;
				while($iSum < $countNumSumm7){
				
					if(!isset($summary7Page[$iSum]['local_time'])){ $summary7Page[$iSum]['local_time'] = $getResSumm7['local_time']; }
					if(!isset($summary7Page[$iSum]['weekday'])){ $summary7Page[$iSum]['weekday'] = $getResSumm7['weekday']; }
					if(!isset($summary7Page[$iSum]['tempHigh'])){ $summary7Page[$iSum]['tempHigh'] = $getResSumm7['tempHigh']; }
					if(!isset($summary7Page[$iSum]['tempLow'])){ $summary7Page[$iSum]['tempLow'] = $getResSumm7['tempLow']; }
					if(!isset($summary7Page[$iSum]['icon'])){ $summary7Page[$iSum]['icon'] = $getResSumm7['icon']; }
					if(!isset($summary7Page[$iSum]['conditions'])){ $summary7Page[$iSum]['conditions'] = $getResSumm7['conditions']; }
					if(!isset($summary7Page[$iSum]['rainMeas'])){ $summary7Page[$iSum]['rainMeas'] = $getResSumm7['rainMeas']; }
					if(!isset($summary7Page[$iSum]['pop_perc'])){ $summary7Page[$iSum]['pop_perc'] = $getResSumm7['pop_perc']; }
					if(!isset($summary7Page[$iSum]['rating'])){ $summary7Page[$iSum]['rating'] = $getResSumm7['rating']; }
					if(!isset($summary7Page[$iSum]['sunrise'])){ $summary7Page[$iSum]['sunrise'] = $getResSumm7['sunrise']; }
					if(!isset($summary7Page[$iSum]['sunset'])){ $summary7Page[$iSum]['sunset'] = $getResSumm7['sunset']; }
					if(!isset($summary7Page[$iSum]['wind_dir_deg'])){ $summary7Page[$iSum]['wind_dir_deg'] = $getResSumm7['wind_dir_deg']; }
					if(!isset($summary7Page[$iSum]['wind_dir_desc'])){ $summary7Page[$iSum]['wind_dir_desc'] = $getResSumm7['wind_dir_desc']; }
					if(!isset($summary7Page[$iSum]['windSpeed'])){ $summary7Page[$iSum]['windSpeed'] = $getResSumm7['windSpeed']; }
					if(!isset($summary7Page[$iSum]['updated'])){ $summary7Page[$iSum]['updated'] = $getResSumm7['updated']; }
				
					$iSum++;
					$getResSumm7 = mysqli_fetch_array($getQueryResSumm7);
				}
			}
			mysqli_free_result($getQueryResSumm7);
	
			$getQueryNear = '
				SELECT 
					c.id, c.name, local_time, day_no, weekday, cf.'.$tempHigh.' as tempHigh, cf.'.$tempLow.' as tempLow, conditions, wind_dir_deg, wind_dir_desc, cf.'.$windCol.' as windSpeed, cf.'.$rainColSum.' as rainMeas, cf.pop_perc, icon, cf.rating, cf.sunrise, cf.sunset, cf.updated,
					sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug,
					ST_Length(LineFromWKB(LineString(ST_GeomFromText("POINT('.$longLat.')"),coordinate))) AS `dist` 
				FROM 
					`courses` c
					join current_summary_feed cf on c.id = cf.course_id
					left join countries co on co.id = c.country_id
					left join sub_regions sr on sr.id = c.subregion_id
					left join geo_regions gr on gr.id = c.region_id
				WHERE 
					(ST_Length(LineFromWKB(LineString(ST_GeomFromText("POINT('.$longLat.')"),coordinate))) < 1.3508102970648) 
					AND (c.id not in ("'.$courseId.'")) AND (c.flow_state_id = 4) 
					AND cf.local_time >= "'.$todDate.'"
					AND cf.local_time <= "'.$todDateEnd.'"
					
				GROUP BY 
					c.id
				ORDER BY ST_Length(LineFromWKB(LineString(ST_GeomFromText("POINT('.$longLat.')"),coordinate))) asc 
				LIMIT 5
			';
			//echo '<pre>' . $getQueryNear . '</pre>';
			$getQueryResNear = mysqli_query($db,$getQueryNear);
			$countNumNear = mysqli_num_rows($getQueryResNear);
			if ($countNumNear > 0){
				$getResNear = mysqli_fetch_array($getQueryResNear);
				$iNear=0;
				while($iNear < $countNumNear){
				
					if(!isset($nearBy[$iNear]['courseId'])){ $nearBy[$iNear]['courseId'] = $getResNear['id']; }
					if(!isset($nearBy[$iNear]['name'])){ $nearBy[$iNear]['name'] = $getResNear['name']; }
					if(!isset($nearBy[$iNear]['tempHigh'])){ $nearBy[$iNear]['tempHigh'] = $getResNear['tempHigh']; }
					if(!isset($nearBy[$iNear]['icon'])){ $nearBy[$iNear]['icon'] = $getResNear['icon']; }
					if(!isset($nearBy[$iNear]['conditions'])){ $nearBy[$iNear]['conditions'] = $getResNear['conditions']; }
					
					if($getResNear['subregionslug'] != ''){
						$coursePageUrl = $getResNear['countryslug'].'/'.$getResNear['regionslug'].'/'.$getResNear['subregionslug'].'/'.filename_safe($getResNear['name']).'/summary/'.$getResNear['id'];
					}else{
						$coursePageUrl = $getResNear['countryslug'].'/'.$getResNear['regionslug'].'/region/'.filename_safe($getResNear['name']).'/summary/'.$getResNear['id'];
					}
					if(!isset($nearBy[$iNear]['coursePageUrl'])){ $nearBy[$iNear]['coursePageUrl'] = $coursePageUrl; }
				
					$iNear++;
					$getResNear = mysqli_fetch_array($getQueryResNear);
				}
			}
			mysqli_free_result($getQueryResNear);

		}
		mysqli_free_result($getQueryRes);
	}

	if(strlen(strpos($curpageMain, "advertise.php")) > 0){
		$page_content = 'Under construction...';
		$getQueryPageSys = "select page_content, metaTitle, metaKeywords, metaDescription from gw_content where page_title='Advertise' limit 1";
		$getQueryResPageSys = mysqli_query($db,$getQueryPageSys);
		$countNumPageSys = mysqli_num_rows($getQueryResPageSys);
		if ($countNumPageSys > 0){
			$getResPageSys = mysqli_fetch_array($getQueryResPageSys);
			$metaTitle = $getResPageSys['metaTitle'];
			$metaKey = $getResPageSys['metaKeywords'];
			$metaDescription = $getResPageSys['metaDescription'];
			$page_content = $getResPageSys['page_content'];
		}
		mysqli_free_result($getQueryResPageSys);
	}

	if(strlen(strpos($curpageMain, "contact-us.php")) > 0){
		$page_content = 'Under construction...';
		$getQueryPageSys = "select page_content, metaTitle, metaKeywords, metaDescription from gw_content where page_title='Contact Us' limit 1";
		$getQueryResPageSys = mysqli_query($db,$getQueryPageSys);
		$countNumPageSys = mysqli_num_rows($getQueryResPageSys);
		if ($countNumPageSys > 0){
			$getResPageSys = mysqli_fetch_array($getQueryResPageSys);
			$metaTitle = $getResPageSys['metaTitle'];
			$metaKey = $getResPageSys['metaKeywords'];
			$metaDescription = $getResPageSys['metaDescription'];
			$page_content = $getResPageSys['page_content'];
		}
		mysqli_free_result($getQueryResPageSys);
	}

	if(strlen(strpos($curpageMain, "faq.php")) > 0){
		$page_content = 'Under construction...';
		$getQueryPageSys = "select page_content, metaTitle, metaKeywords, metaDescription from gw_content where page_title='FAQ' limit 1";
		$getQueryResPageSys = mysqli_query($db,$getQueryPageSys);
		$countNumPageSys = mysqli_num_rows($getQueryResPageSys);
		if ($countNumPageSys > 0){
			$getResPageSys = mysqli_fetch_array($getQueryResPageSys);
			$metaTitle = $getResPageSys['metaTitle'];
			$metaKey = $getResPageSys['metaKeywords'];
			$metaDescription = $getResPageSys['metaDescription'];
			$page_content = $getResPageSys['page_content'];
		}
		mysqli_free_result($getQueryResPageSys);
	}
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
  	<script src="<?php echo $dirAdj;?>assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="GolfWeather.com">
	<meta name="description" content="<?php echo $metaDescription;?>" />
    <meta name="keywords" content="<?php echo $metaKey;?>" />
    <title><?php echo $metaTitle;?></title>
    <link rel="canonical" href="https://www.golfweather.com">
	<link href="<?php echo $dirAdj;?>assets/dist/css/bootstrap.css?v=1" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="<?php echo $dirAdj;?>css/gw.css?v=<?php echo date('his');?>" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo $dirAdj;?>img/gw-black.ico">
	
	<script src="https://use.fontawesome.com/releases/v6.2.0/js/all.js"></script>

    <link href="<?php echo $dirAdj;?>css/markers.css?v=<?php echo date('his');?>" rel="stylesheet">
	<?php
		if(strlen(strpos($curpageMain, "course-weather-search")) > 0){
			//load provinces 
	?>

  
  	<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
	<script src="<?php echo $dirAdj;?>assets/dist/js/jquery1.12.4.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7vRCQ2Ti9d4GMJ1GoZas7mW9JIgz1Uvg&v=weekly"></script>
	<script type="text/javascript">
	
	function getCArr(latv = -33.8723141, lngv = 18.4920258, cID = 'ZA', mapName = 'map'){
		cID = $('#search_country_id').val();
		var formData = {cID:cID,tempCol:'<?php echo $tempCol?>',todDate:'<?php echo $todDate?>',todDateEnd:'<?php echo $todDateEnd?>'};
		$.ajax({
			url: "<?php echo $dirAdj;?>countryMarkers.php",
			type: "POST",
			cache: false,
			dataType: 'json',
			data: formData,
			success: function(data) {
				var locations = data;
				initMap(latv, lngv, cID, locations, mapName)
				//console.log(data);
			}
		});
	}
	
	
async function initMap(latv = -33.8723141, lngv = 18.4920258, cID = 'ZA', locations, mapName) {
	const { Map } = await google.maps.importLibrary("maps");
	const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
	const map = new google.maps.Map(document.getElementById("" + mapName + ""), {
    	zoom: 4,
    	center: { lat: latv, lng: lngv },
    	mapId: "78443u4hnnmsjGyWE",
  	});
	
	const renderer = {
	    render({ count, position }) {
		
			if(count > 20){
		
	        return new google.maps.Marker({
				icon: {
    				anchor: new google.maps.Point(16, 16),
    				url: 'data:image/svg+xml;utf-8, \
       				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" width="50" height="50"> \
						<circle cx="120" cy="120" opacity=".6" r="70" fill="rgb(142,170,110)" /> \
						<circle cx="120" cy="120" opacity=".3" r="90" fill="rgb(142,170,110)" /> \
						<circle cx="120" cy="120" opacity=".2" r="110" fill="rgb(142,170,110)" /> \
					</svg>'
				},
	            label: { text: String(count), color: "white", fontSize: "10px" },
	            position,
	            zIndex: Number(google.maps.Marker.MAX_ZINDEX) + count,
	        });
			
			}else{
	        return new google.maps.Marker({
				icon: {
    				anchor: new google.maps.Point(16, 16),
    				url: 'data:image/svg+xml;utf-8, \
       				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" width="50" height="50"> \
						<circle cx="120" cy="120" opacity=".6" r="70" fill="rgb(86,122,193)" /> \
						<circle cx="120" cy="120" opacity=".3" r="90" fill="rgb(86,122,193)" /> \
						<circle cx="120" cy="120" opacity=".2" r="110" fill="rgb(86,122,193)" /> \
					</svg>'
				},
	            label: { text: String(count), color: "white", fontSize: "10px" },
	            position,
	            zIndex: Number(google.maps.Marker.MAX_ZINDEX) + count,
	        });
			}
	    }
	}	
	
	var isTouch = 'ontouchstart' in document.documentElement;
	
  	const markers = locations.map((property, i) => {
	    const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
	      map,
	      content: buildContent(property),
	      position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
	      title: 'P_' + property.pid,
	    });
	
	    AdvancedMarkerElement.addListener("click", () => {
			if(isTouch){
		      toggleHighlight(AdvancedMarkerElement, property, AdvancedMarkerElement.title);
			}else{
		      toggleHighlight(AdvancedMarkerElement, property, AdvancedMarkerElement.title);
			}
		
	    });
	
	
    	return AdvancedMarkerElement;
	});

	new markerClusterer.MarkerClusterer({ map, markers, renderer  }, { ignoreHidden: true });
	//new markerClusterer.MarkerClusterer({ map, markers});
}

function toggleHighlight(markerView, property, pid) {
	$('.highlight').hide();
  if (markerView.content.classList.contains("highlight")) {
    markerView.content.classList.remove("highlight");
    markerView.zIndex = null;
	$('.mark'+pid+'Icon').show();
  } else {
    markerView.content.classList.add("highlight");
    markerView.zIndex = 1;
	$('.mark'+pid+'Icon').hide();
  }
}

function buildContent(property) {
  const content = document.createElement("div");

  content.classList.add("property");
  content.innerHTML = `
    <div class="allprops">
		<div class="markP_${property.pid}Icon" style="background-image: url(img/icons/pin-dark.svg);width:45px;height:55px;"><img src="img/icons/logo-white.svg" class="marker-ico${property.icoex}" /></div>
    </div>
    <div class="details">
		<div class="close"><img src="img/icons/close.png"/></div>
        <div class="name">${property.name}</div>
        <div class="address">${property.address}</div>
        <div class="conditions">
			<div class="icon_C1"><img src="img/icons/${property.icon}" class="icon_C" />&nbsp;&nbsp;</div>
			<div class="deg_C">${property.deg}&nbsp;&nbsp;</div>
			<div class="condition_C">${property.condition}</div>
		</div>
        <div class="but flexCent" onclick="javascript:location.href='${property.url}';">View full forecast</div>
    </div>
    `;
  return content;
}


//initMap();
	</script>
	<?php
		}
	?>
  </head>
<body>
<div class="widecontainer">
	<div class="header_top my-1">
		<div class="container">
		  <header class="lh-1 py-2">
		    <div class="row">
		      <div class="col-2 my-3"><a href="<?php echo $dirAdj;?>index.php"><img src="<?php echo $dirAdj;?>img/Golfweather_Logo.png" class="gw_logo" /></a></div>
		      <div class="col-2"></div>
		      <div class="col-8 text-end"><a href=""><img src="<?php echo $dirAdj;?>img/banners/tag-heuer-top.png" class="banner_full" /></a></div>
		    </div>
		  </header>
		</div>
	</div>
	<div class="header_bot">
		<div class="container">
		  <div class="nav-scroller py-1 mb-3">
		    <nav class="nav nav-underline pt-1 justify-content-between fl_l">
		      <a class="nav-item nav-link nav-active" href="<?php echo $dirAdj;?>index.php">Home</a>
		      <a class="nav-item nav-link" href="<?php echo $dirAdj;?>course-weather-search.php">Search</a>
		      <a class="nav-item nav-link" href="<?php echo $dirAdj;?>faq.php">FAQ</a>
		      <a class="nav-item nav-link" href="<?php echo $dirAdj;?>about-us.php">About Us</a>
		      <a class="nav-item nav-link" href="<?php echo $dirAdj;?>news.php">News</a>
		      <a class="nav-item nav-link" href="<?php echo $dirAdj;?>contact-us.php">Contact Us</a>
		      <!--<a class="nav-item nav-link" href="<?php echo $dirAdj;?>widgets.php"><img src="<?php echo $dirAdj;?>img/icons/widget.svg" class="ico-20" /> Widget</a>-->
		    </nav>
		  	<div class="py-2 me-3 fl_r" style="margin:-5px 0 0 0">
		  		<a href="https://itunes.apple.com/app/golfweather.com/id460006449?mt=8" target="_blank"><img src="<?php echo $dirAdj;?>img/icons/appleplay.svg" style="height:36px"  /></a>
		  	</div>
		  	<div class="mb-1 me-3 fl_r">
		  		<a href="https://play.google.com/store/apps/details?id=com.fontera.golfweather&hl=en" target="_blank"><img src="<?php echo $dirAdj;?>img/icons/googleplay.svg" class="h-40" /></a>
		  	</div>
		  	<div style="clear:both"></div>
		  </div>
		</div>
	</div>
	<?php if(isset($hp)){?>
	<div class="cover_top">
		<form name="qSearch" method="get" action="course-weather-search.php">
		<img src="<?php echo $dirAdj;?>img/golf_weather_dt.webp" class="cover-body" />
		<div class="cover_child">
			<span class="cover_head">Where would you like to play?</span><br /><br />
			<div style="display: inline-block;vertical-align: top"><input name="search_home" class="search_home" id="search_home" placeholder="Find your course" onchange="checkInpSearchHP();" /></div>
			<div style="display: inline-block;vertical-align: top"><div class="search_ico"><img src="<?php echo $dirAdj;?>img/icons/search.svg" class="search_pos" onclick="javascript:document.qSearch.submit();" /></div></div>
		</div>
		</form>
	</div>
	<?php }?>
</div>
<div class="mobidiv mt10 mobile-header-container">
	<div class="container-sm">
	  <header class="mobile-header-wrapper">
	    <div class="row">
	      <div class="mb5 logo-container"><a href="<?php echo $dirAdj;?>index.php"><img src="<?php echo $dirAdj;?>img/Golfweather_Logo.png" class="gw_logo" /></a></div>
	      <div class="ps-1 app-image-container"><a href="https://play.google.com/store/apps/details?id=com.fontera.golfweather&hl=en" target="_blank"><img src="<?php echo $dirAdj;?>img/icons/googleplay.svg" /></a></div>
	      <div class="ps-1 app-image-container"><a href="https://itunes.apple.com/app/golfweather.com/id460006449?mt=8" target="_blank"><img src="<?php echo $dirAdj;?>img/icons/appleplay.svg" /></a></div>
	      <div class="flex burger-menu-container"><img src="<?php echo $dirAdj;?>img/icons/burger.svg" style="vertical-align: middle;" onclick="doMobMenu();" /></a></div>
	    </div>
	  </header>
	</div>
	<?php if(isset($hp)){?>
	<div class="cover_top">
		<form name="qSearch2" method="get" action="course-weather-search.php">
		
		<div class="cover_child">
			<span class="cover_head">Where would you like to play?</span><br /><br />
			<div style="display: inline-block;vertical-align: top"><input type="Text" name="search_home" class="search_home" placeholder="Find your course" /></div>
			<div style="display: inline-block;vertical-align: top"><div class="search_ico"><img src="<?php echo $dirAdj;?>img/icons/search.svg" class="search_pos" onclick="javascript:document.qSearch2.submit();" /></div></div>
		</div>
		</form>
	</div>
	<?php }?>
</div>
