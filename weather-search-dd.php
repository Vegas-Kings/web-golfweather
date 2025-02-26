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

	$dirAdj = '';
	$searchTXT = $_GET['searchTXT'];
	
	$timeNow = mktime((date('H')), date('i'), date('s'), date('m'), date('d'), date('Y'));
	$todDate = date('Y-m-d', $timeNow);
	
	if(isset($searchTXT)){
		$searchHome = utf8_encode($searchTXT);
		$searchHome = mysqli_real_escape_string($db, $searchHome);
	}
	
	$resultARR = array();
	
	if(isset($searchTXT)){

		$searchSql = " and
			(
				lower(c.name) like '%".strtolower($searchHome)."%'
			)
		";

		$getQuery = "
			select 
				c.id, cf.local_time, c.name, c.address1, co.name as CountryName, city, gr.slug as regionslug, co.slug as countryslug, sr.slug as subregionslug
			from 
				courses c
				join current_feed cf on c.id = cf.course_id
				left join countries co on co.id = c.country_id
				left join sub_regions sr on sr.id = c.subregion_id
				left join geo_regions gr on gr.id = c.region_id
			where 
				cf.local_time >= '".$todDate."'
				and c.flow_state_id = 4
				".$searchSql."
			group by c.id
			order by c.name
			
			
			limit 1000
		";
		//echo '<pre>' . $getQuery . '</pre>';
		$getQueryRes = mysqli_query($db,$getQuery);
		$countNumSearch = mysqli_num_rows($getQueryRes);
		if ($countNumSearch > 0){
			$getRes = mysqli_fetch_array($getQueryRes);
			$i=0;
			while($i < $countNumSearch){
				$courseName = $getRes['name'];
				$courseAddLabel = '';
				
				if(trim($getRes['city']) != ''){
					$courseAddLabel = '' . $getRes['city'] . ', ';
				}
				$courseAddLabel .= $getRes['CountryName'];
				
				$subregionslug = $getRes['subregionslug'];
				if($subregionslug == ''){
					$subregionslug = 'suburb';
				}
				$mainCoursePageUrl = $getRes['countryslug'].'/'.$getRes['regionslug'].'/'.$subregionslug.'/'.filename_safe($getRes['name']).'/detailed/'.$getRes['id'];
				
				array_push($resultARR, array("value" => $courseName,"label" => $courseAddLabel,"uri" => $mainCoursePageUrl));
				
				$i++;
				$getRes = mysqli_fetch_array($getQueryRes);
			}
		}
		mysqli_free_result($getQueryRes);
	}
	
	echo json_encode($resultARR);
