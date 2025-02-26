<?php
	session_start();
	require_once("includes/dbconni.php");
	
	$dirAdj = $_POST['dirAdj'];
	
	if(isset($_POST['dayOpt']) && isset($_POST['dayOpt'])){
		$dayOpt = $_POST['dayOpt'];
		$tempHigh = $_POST['tempHigh'];
		$tempLow = $_POST['tempLow'];
		$windCol = $_POST['windCol'];
		$rainColSum = $_POST['rainColSum'];
		$tempCol = $_POST['tempCol'];
		$rainCol = $_POST['rainCol'];
		$todDate = $_POST['todDate'];
		$todDateEnd = $_POST['todDateEnd'];
		$geoCountryCode = $_POST['geoCountryCode'];
		$timeHour = $_POST['timeHour'];
		$windOpt = $_POST['windOpt'];
		$rainOpt = $_POST['rainOpt'];
	}else{
		$dayOpt = 0;
	}

	$courseId = $_POST['courseId'];
	
	$getQuery = "select name, details, url, phone, address1, metakey, metadesc, country_id, latitude, longitude, tzone from courses c where c.id=".$courseId."";
	$getQueryRes = mysqli_query($db,$getQuery);
	$countNumD = mysqli_num_rows($getQueryRes);
	if ($countNumD > 0){
		$getRes = mysqli_fetch_array($getQueryRes);
		$courseName = $getRes['name'];
		$courseDetails = $getRes['details'];
		$courseUrl = $getRes['url'];
		$coursePhone = $getRes['phone'];
		$courseAddress = $getRes['address1'];
		if($getRes['metakey'] != ''){$metaKey = $getRes['metakey'];}
		if($getRes['metadesc'] != ''){$metaDescription = $getRes['metadesc'];}

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

	}
	mysqli_free_result($getQueryRes);
?>
				<div id="divTopInfoMob" class="pb20" style="display:none">
					<div class="flex pb15 featbot">
						<div class="pt15 ml5"><img style="width:50px" src="<?php echo $dirAdj;?>img/icons/<?php if(date('H') >= 7 && date('H') <= 17){?>sunrise<?php }else{?>night-white<?php }?>.svg" /></div>
						<div class="f18M pe-3 ms-3 pt30"><?php echo date('D d M', strtotime($summary7Page[$dayOpt]['local_time']))?></div>
					</div>
					<div class="flex pt20">
						<div class="">
							<div class="f15B">Sunrise:</div>
							<div class="f15M fTimeMob"><?php echo date($timeHour.':i',strtotime($summary7Page[$dayOpt]['sunrise']));?>am&nbsp;&nbsp;</div>
						</div>
						<div class="genSplitMob">
							<div class="f15M">Sunset:</div>
							<div class="f15M fTimeMob"><?php echo date($timeHour.':i',strtotime($summary7Page[$dayOpt]['sunset']));?>pm</div>
						</div>
						<div class="genSplitMob">
							<div class="f15B">Forecast Updated:</div>
							<div class="f15M fTimeMob"><?php echo date($timeHour.':i a', strtotime($summary7Page[$dayOpt]['updated']))?> Local time</div>
						</div>
					</div>
				</div>
				<div class="botforecast mt20Sum">
					<div class="detMobCol1 bgDet f14B">
						Time
					</div>
					<div class="detMobCol2 bgDet f14B">
						Condition
					</div>
					<div class="detMobCol3 bgDet f14B">
						Temp
					</div>
					<div class="detMobCol4 bgDet f14B">
						Wind/Dir
					</div>
					<div class="detMobCol5 bgDet f14B">
						Rain/mm
					</div>
				</div>
				
				<?php
					if(substr($todDate, 0, 10) == substr($summary7Page[$dayOpt]['local_time'], 0, 10)){
						$todDate = date('Y-m-d '.date('H').':00', strtotime($summary7Page[$dayOpt]['local_time']));
					}else{
						$todDate = date('Y-m-d 00:01', strtotime($summary7Page[$dayOpt]['local_time']));
					}
					$todDateEnd = date('Y-m-d 23:59', strtotime($summary7Page[$dayOpt]['local_time']));
					$todDateEnd = date('Y-m-d 23:59', strtotime($summary7Page[$dayOpt]['local_time']));

					$getQueryDetDays = "
						select 
							c.id, cf.local_time, cf.day_part, c.name, cf.".$tempCol." as tempNow, cf.relative_humity, cf.rating, cf.sunrise, cf.sunset, cf.conditions, cf.".$windCol." as windSpeed, cf.wind_dir_deg, cf.wind_dir_desc, cf.".$rainCol." as rainMeas, cf.precip_in_3hr, cf.pop_perc, icon, sr.name as subregionsname, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug, c.details, c.url, c.phone, c.address1, c.country_id, c.latitude, c.longitude, c.tzone
						from 
							courses c
							join current_feed cf on c.id = cf.course_id
							left join countries co on co.id = c.country_id
							left join sub_regions sr on sr.id = c.subregion_id
							left join geo_regions gr on gr.id = c.region_id
						where 
							cf.local_time >= '".$todDate."'
							and cf.local_time <= '".$todDateEnd."'
							and c.id=".$courseId."
						order by 
							cf.local_time
					";
					//echo '<pre>' . $getQueryDetDays . '</pre>';
					//die();
					$getQueryResDetDays = mysqli_query($db,$getQueryDetDays);
					$countNumDetDays = mysqli_num_rows($getQueryResDetDays);
					if ($countNumDetDays > 0){
						$getResDetDays = mysqli_fetch_array($getQueryResDetDays);
						$iDet=0;
						while($iDet < $countNumDetDays){
		
							$dayCourseId = $getResDetDays['id'];
							$dayCourseName = $getResDetDays['name'];
							$dayCourseDetails = $getResDetDays['details'];
							$dayCourseUrl = $getResDetDays['url'];
							$dayCoursePhone = $getResDetDays['phone'];
							$dayCourseAddress = $getResDetDays['address1'];
							$dayCourseRegion = $getResDetDays['subregionsname'];
							
							$dayCourseTemp = $getResDetDays['tempNow'];
							$dayCourseHumid = $getResDetDays['relative_humity'];
							$dayCourseRating = $getResDetDays['rating'];
							$dayCourseSunrise = $getResDetDays['sunrise'];
							$dayCourseSunset = $getResDetDays['sunset'];
							$dayCourseWindspeed = $getResDetDays['windSpeed'];
							$dayCourseWinddir = $getResDetDays['wind_dir_desc'];
							$dayCoursePrec = $getResDetDays['rainMeas'];
							$dayCoursePrecPerc = $getResDetDays['pop_perc'];
							$dayCourseIcon = $getResDetDays['icon'];
				?>
				<div class="botforecast<?php if($iDet < ($countNumDetDays-1)){?> sumbot<?php }?>">
					<div class="detMobCol1">
						<div class="f15N pt8"><?php echo date($timeHour.':i a', strtotime($getResDetDays['local_time']))?></div>
						<div style="height:5px"></div>
						<div class="starHgt">
							<?php
								$rcnt = 0;
								for($s=0;$s<$dayCourseRating;$s++){
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
								for($s=0;$s<(5-$dayCourseRating);$s++){
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
					<div class="detMobCol2">
						<div class="daysIco flexCent"><img src="<?php echo $dirAdj;?>img/icons/<?php echo $dayCourseIcon;?>.svg" class="cover-img-sml" /></div>
						<div class="f15N"><?php echo $getResDetDays['conditions'];?></div>
					</div>
					<div class="flexCent detMobCol3">
						<div class="f18B"><?php echo $dayCourseTemp;?>&deg;</div>
					</div>
					<div class="detMobCol4">
						<div class="f15N"><img src="<?php echo $dirAdj;?>img/icons/wind-oval.svg" style="transform: rotate(<?php echo ($getResDetDays['wind_dir_deg']+128);?>deg);" class="" /></div>
						<div class="f15N pt5"><?php echo $dayCourseWindspeed;?> <?php echo $windOpt;?><br /><?php echo $dayCourseWinddir;?></div>
					</div>
					<div class="flexCent detMobCol5">
						<div class="f15N"><?php echo $dayCoursePrecPerc;?>%<br /><?php echo $dayCoursePrec;?><?php echo $rainOpt;?></div>
					</div>
				</div>
				<?php		
						
							$iDet++;
							$getResDetDays = mysqli_fetch_array($getQueryResDetDays);
						}
					}
					mysqli_free_result($getQueryResDetDays);
				?>
				
