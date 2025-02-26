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
		for($d=1;$d<=$dirCount;$d++){ $dirAdj .= '../'; }
	}else{
		$dirAdj = '/';
	}

	require_once('includes/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$geoCountryCode = $geoplugin->countryCode;

	$timeNow = mktime((date('H')), date('i'), date('s'), date('m'), date('d'), date('Y'));
	
	$lastHour = 20;
	if($geoCountryCode == 'za') {$lastHour = 20;}
	if($geoCountryCode == 'au') {$lastHour = 19;}
	if($geoCountryCode == 'ie') {$lastHour = 19;}
	if($geoCountryCode == 'gb') {$lastHour = 19;}
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

  </head>
<body>
<div class="">
	<div class="mobiinner">
	<div class="flexible-width2">
		<div class="featbot pb20">
			<div class="flex" style="width:100%">
				<div class="fcName"><?php echo $courseName;?></div>
				<div class="fcIco"><img src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $courseId) {?>full<?php }else{?>empty<?php }?>.svg" /></div>
			</div>

			<div class="">
				<?php if($courseAddress != ''){?>
				<div class="flex">
					<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-pin.svg" class="address-ico" /></div>
					<div class="address-txt ml6"><?php echo $courseAddress;?></div>
				</div>
				<?php }?>
				<div class="flex pt-1">
					<?php if($courseUrl != ''){?>
					<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-url.svg" class="address-ico" /></div>
					<div class="address-txt mr10"><?php echo $courseUrl;?></div>
					<?php }?>
					<?php if($coursePhone != ''){?>
					<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-tel.svg" class="address-ico" /></div>
					<div class="address-txt"><?php echo $coursePhone;?></div>
					<?php }?>
				</div>
			</div>
			<div style="clear:both"></div>
			<div>
				<div class="address-sponsor">Weather Sponsored By:</div>
				<div class="address-banner"><a href=""><img src="<?php echo $dirAdj;?>img/banners/callaway-golf.png" class="fw" /></a></div>
			</div>
		</div>
		<div class="featbot pb20">
			<div class="flex">
				<div style="width:90%">
					<div class="forecasthead pt20"><span class="green">7 Day Summary</span> Forecast</div>
					<div class="f15B">Forecast Updated: <span class="fTime"><?php echo date($timeHour.':i a', strtotime($summary7Page[0]['updated']))?> Local time</span></div>
				</div>
			</div>
		</div>
		
		<div class="pt20 f18B"><?php echo date('l d F', strtotime($summary7Page[0]['local_time']))?> - <?php echo date('D d F', strtotime($summary7Page[6]['local_time']))?></div>
		
		<div class="botforecast mt30">
			<div class="somCol1 bgSum f14B">
				Day
			</div>
			<div class="somCol2 bgSum f14B">
				Condition
			</div>
			<div class="somCol3 bgSum f14B">
				Temp
			</div>
			<div class="somCol4 bgSum f14B">
				Wind<br />Dir.
			</div>
			<div class="somCol5 bgSum f14B">
				Rain/<br />mm
			</div>
			<div class="somCol6 bgSum f14B">
				Sunrise<br />Sunset
			</div>
		</div>

		<?php for ($s=0;$s<=6;$s++){?>
		
		<div class="botforecast<?php if($s < 6){?> sumbot<?php }?>">
			<div class="somCol1">
				<div class="f15N"><?php echo date('D.', strtotime($summary7Page[$s]['local_time']))?><br /><?php echo date('d M', strtotime($summary7Page[$s]['local_time']))?></div>
				<div class="f9N">Rating</div>
				<div class="starHgt">
					<?php
						$rcnt = 0;
						for($si=0;$si<$summary7Page[$s]['rating'];$si++){ 
							$rcnt++;
					?>
					<img class="starSML" src="<?php echo $dirAdj;?>img/icons/star-green.svg">
					<?php
							if($rcnt == 3){
								echo '<br />';
							}
						}
					?>
					<?php
						for($si=0;$si<(5-$summary7Page[$s]['rating']);$si++){
							$rcnt++;
					?>
					<img class="starSML" src="<?php echo $dirAdj;?>img/icons/star-wht.svg">
					<?php
							if($rcnt == 3){
								echo '<br />';
							}
						}
					?>
				</div>
			</div>
			<div class="somCol2">
				<div class="daysIco"><img src="<?php echo $dirAdj;?>img/icons/<?php echo $summary7Page[$s]['icon'];?>.svg" class="iconMob" /></div>
				<div class="f15N"><?php echo $summary7Page[$s]['conditions'];?></div>
			</div>
			<div class="somCol3">
				<div class="f15N pt20">L: <?php echo $summary7Page[$s]['tempLow'];?>&deg;<br />H: <?php echo $summary7Page[$s]['tempHigh'];?>&deg;</div>
			</div>
			<div class="somCol4">
				<img src="<?php echo $dirAdj;?>img/icons/wind-oval.svg" style="transform: rotate(<?php echo ($summary7Page[$s]['wind_dir_deg']+128);?>deg);" class="cover-img pb10" />
				<div class="f15N"><?php echo $summary7Page[$s]['windSpeed'];?> <?php echo $windOpt;?><br /><?php echo $summary7Page[$s]['wind_dir_desc'];?></div>
			</div>
			<div class="somCol5">
				<div class="f15N pt20"><?php echo $summary7Page[$s]['pop_perc'];?>%<br /><?php echo $summary7Page[$s]['rainMeas'];?><?php echo $rainOpt;?></div>
			</div>
			<div class="somCol6">
				<div class="f15N pt20"><?php echo date($timeHour.':i',strtotime($summary7Page[$s]['sunrise']));?> am<br /><?php echo date($timeHour.':i',strtotime($summary7Page[$s]['sunset']));?> pm</div>
			</div>
		</div>
		<?php }?>

		
	</div>



	</div>
</div>

<div class="botSpace"></div>
<script src="<?php echo $dirAdj;?>assets/dist/js/jquery1.12.4.min.js"></script>
<script src="<?php echo $dirAdj;?>assets/dist/js/bootstrap.bundle.min.4.6.1.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		window.print();
	});
</script>

<?php mysqli_close($db);?>
    </body>
</html>
