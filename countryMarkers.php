<?php
	session_start();
	require_once("includes/dbconni.php");
	
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

	$cID = $_POST['cID'];
	$todDate = $_POST['todDate'];
	$todDateEnd = $_POST['todDateEnd'];
	$tempCol = $_POST['tempCol'];

	$markersARR = array();

	$getQuery = "
		select 
			c.id, cf.local_time, cf.conditions, c.name, cf.".$tempCol." as tempNow, icon, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug, address1, latitude, longitude
		from 
			courses c
			join current_feed cf on c.feedid = cf.feed_id
			left join countries co on co.id = c.country_id
			left join sub_regions sr on sr.id = c.subregion_id
			left join geo_regions gr on gr.id = c.region_id
		where 
			lower(cf.country_id)='".strtolower($cID)."'
			and lower(c.country_id)='".strtolower($cID)."' 
			and c.flow_state_id=4
			and cf.local_time >= '".$todDate."'
			and c.name is not null

		group by cf.feed_id
		order by 
		c.id limit 2000
	";

	//echo $getQuery;
	$getQueryResCountryDD = mysqli_query($db,$getQuery);
	$countNumCountryDD = mysqli_num_rows($getQueryResCountryDD);
	if ($countNumCountryDD > 0){
		$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
		$iDet=0;
		while($iDet < $countNumCountryDD){
			$iDet++;
			$getRes = mysqli_fetch_array($getQueryResCountryDD);
			
			if(isset($getRes['address1'])){ $courseAddress = $getRes['address1']; }else{ $courseAddress = 'N/A'; }
			if(isset($getRes['regionslug'])){ $regionslug = $getRes['regionslug']; }else{ $regionslug = 'region'; }
			if(isset($getRes['subregionslug'])){ $subregionslug = $getRes['subregionslug']; }else{ $subregionslug = 'subregionslug'; }
			if(isset($getRes['countryslug'])){ $countryslug = $getRes['countryslug']; }else{ $countryslug = 'countryslug'; }
			if(isset($getRes['name']) && isset($getRes['id'])){ 
				$coursePageUrl = $countryslug.'/'.$regionslug.'/'.$subregionslug.'/'.filename_safe($getRes['name']).'/detailed/'.$getRes['id'];
				$arrItem = array("pid" => $iDet, "name" => $getRes['name'], "condition" => $getRes['conditions'], "deg" => $getRes['tempNow'] . '&deg;', "icon" => $getRes['icon'] . '-grey.svg', "icoex" => 'sun', "url" => $coursePageUrl, "address" => $courseAddress, "lat" => $getRes['latitude']*1, "lng" => $getRes['longitude']*1);
				array_push($markersARR, $arrItem);
			}
			
			$iDet++;
			$getRes = mysqli_fetch_array($getQueryResCountryDD);
		}
	}
	mysqli_free_result($getQueryResCountryDD);

	echo json_encode($markersARR); 