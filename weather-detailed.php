<?php
	require_once("includes/header.php");
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="flex featbot pb20">
			<div class="flexible-width">
				<div class="flex">
					<div class="fcName"><?php echo $courseName;?></div>
					<div class="fcIco"><img src="<?php echo $dirAdj;?>img/icons/desktop_star_full.svg" /></div>
				</div>
				<?php if($courseAddress != ''){?>
				<div class="flex">
					<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-pin.svg" class="address-ico" /></div>
					<div class="address-txt"><?php echo $courseAddress;?></div>
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
			<div class="fixed-width-sponsor">
				<div class="address-sponsor">Weather Sponsored By:</div>
				<div class="address-banner"><a href=""><img src="<?php echo $dirAdj;?>img/banners/callaway-golf.png" class="fw" /></a></div>
			</div>
		</div>
		<div class="flex">
			<div class="normhead pt20"><span class="green">7 Day Detailed</span> Forecast</div>
			<div class="flex genSplit">
				<div class="f18B pe-1">Forecast Updated:</div>
				<div class="f18M fTime"><?php echo date($timeHour.':i a', strtotime($summary7Page[0]['updated']))?> Local time</div>
			</div>
		</div>
		
		<div class="flex pb20" id="dayTopDetails">
			<div class="flex">
				<div class="pt30"><img src="<?php echo $dirAdj;?>img/icons/<?php if(date('H') >= 7 && date('H') <= 17){?>sunrise<?php }else{?>night-white<?php }?>.svg" /></div>
				<div class="flex pt30">
					<div class="f18M pe-3 ms-3 pt5"><?php echo date('D d M', strtotime($summary7Page[0]['local_time']))?></div>
					<div class="f18B genSplitClean ps-3 pt5" style="height:35px">Sunrise:</div>
					<div class="f18M fTime pt5 ps-2"><?php echo date($timeHour.':i',strtotime($summary7Page[0]['sunrise']));?>am</div>
				</div>
				<div class="flex pt30">
					<div class="f18M ms-3 pt5">Sunset:</div>
					<div class="f18M fTime pt5 ps-2 pe-3"><?php echo date($timeHour.':i',strtotime($summary7Page[0]['sunset']));?>pm</div>
					<div class="f18B ps-3 pe-3 pt5" style="height:35px"></div>
					<div class="f18M fTime pt5"></div>
				</div>
			</div>
		</div>
		<div class="flex bgDetTop">
			<div class="botforecast">
			
				<?php for ($s=0;$s<=6;$s++){?>
			
				<div onmouseover="sevenDayOverD(<?php echo $s;?>);" onmouseout="sevenDayOutD(<?php echo $s;?>);" id="dayDetF_<?php echo $s;?>" class="days7Det<?php if($s == 0){?> days7SelDet<?php }?>" onclick="javascript:doDetailedDay(<?php echo $s;?>);">
					<div id="dayin_<?php echo $s;?>" class="daysDetInner<?php if($s == 0){?>First<?php }?>">
						<?php echo $summary7Page[$s]['weekday'];?>
						<div class="daysTemp"><?php echo date('d', strtotime($summary7Page[$s]['local_time']))?></div>
					</div>
				</div>
				<?php }?>
			</div>
			<div class="fixed-width-det-controls pt10">
				<div class="flex">
					<div class="f15N pt3 pe-2 ps-3 metricTxtFix">Rain</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($rainOpt) || $rainOpt == 'mm'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('rain','mm');">
							mm
						</div>
						<div class="f12N metric<?php if(isset($rainOpt) && $rainOpt == 'in'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('rain','in');">
							in
						</div>
					</div>
					<div class="f15N pt3 pe-2 ps-3 metricTxtFix">Temp</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($tempOpt) || $tempOpt == 'C'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('temp','C');">
							&deg;C
						</div>
						<div class="f12N metric<?php if(isset($tempOpt) && $tempOpt == 'F'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('temp','F');">
							&deg;F
						</div>
					</div>
				</div>
				<div class="flex pt20">
					<div class="f15N pt3 pe-2 ps-3 metricTxtFix">Time</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($timeOpt) || $timeOpt == 12){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('time',12);">
							12h
						</div>
						<div class="f12N metric<?php if(isset($timeOpt) && $timeOpt == 24){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('time',24);">
							24h
						</div>
					</div>
					<div class="f15N pt3 pe-2 ps-3 metricTxtFix">Wind</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($windOpt) || $windOpt == 'kmh'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('wind','kmh');">
							kmh
						</div>
						<div class="f12N metric<?php if(isset($windOpt) && $windOpt == 'mph'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('wind','mph');">
							mph
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="dayDetails">
			<div class="botforecast mt20Sum">
				<div class="detCol1 bgDet f14B">
					Time
				</div>
				<div class="detCol2 bgDet f14B">
					Condition
				</div>
				<div class="detCol3 bgDet f14B">
					Temp
				</div>
				<div class="detCol4 bgDet f14B">
					Wind/Dir
				</div>
				<div class="detCol5 bgDet f14B">
					Rain/mm
				</div>
			</div>
			
			<?php
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
						$dayCourseCountry = getCountryName($getResDetDays['country_id'],$db);
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
				<div class="flexCent detCol1Cent">
					<div class="">
						<div class="f18N"><?php echo date($timeHour.':i a', strtotime($getResDetDays['local_time']))?></div>
						<div class="">
							<?php for($s=0;$s<$dayCourseRating;$s++){ ?>
							<img class="timestarDet" src="<?php echo $dirAdj;?>img/icons/star-green.svg">
							<?php }?>
							<?php for($s=0;$s<(5-$dayCourseRating);$s++){ ?>
							<img class="timestarDet" src="<?php echo $dirAdj;?>img/icons/star-wht.svg">
							<?php }?>
						</div>
					</div>
				</div>
				<div class="flexCent detCol2">
					<div class="">
						<div class="daysIco"><img src="<?php echo $dirAdj;?>img/icons/<?php echo $dayCourseIcon;?>.svg" class="weatherSVG" /></div>
						<div class="f15N"><?php echo $getResDetDays['conditions'];?></div>
					</div>
				</div>
				<div class="flexCent detCol3">
					<div class="f20B"><?php echo $dayCourseTemp;?>&deg;</div>
				</div>
				<div class="flexCent detCol4">
					<div class="">
						<div class="f15N"><img src="<?php echo $dirAdj;?>img/icons/wind-oval.svg" style="transform: rotate(<?php echo ($getResDetDays['wind_dir_deg']+128);?>deg);" class="" /></div>
						<div class="f15N"><?php echo $dayCourseWindspeed;?> <?php echo $windOpt;?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <?php echo $dayCourseWinddir;?></div>
					</div>
				</div>
				<div class="flexCent detCol5">
					<div class="f15N"><?php echo $dayCoursePrecPerc;?>% | <?php echo $dayCoursePrec;?><?php echo $rainOpt;?></div>
				</div>
			</div>
			<?php		
					
						$iDet++;
						$getResDetDays = mysqli_fetch_array($getQueryResDetDays);
					}
				}
				mysqli_free_result($getQueryResDetDays);
			?>
			
		</div>

		<div class="flex featbot mt20">
			&nbsp;
		</div>
		
		<div class="flex mt50">
			<div class="butCircleWide" onclick="javascript:location.href='<?php echo $dirAdj;?><?php echo $summaryCoursePageUrl;?>';">
				<div class="flex">
					<div class="butMoreTxtGreen f15B"><img class="icoUp" src="<?php echo $dirAdj;?>img/icons/calendar-green.svg">&nbsp;&nbsp;7 Day Forecast Summary</div>
				</div>
			</div>

			<div class="butCircle2">
				<div class="flex">
					<div class="butMoreTxt f15B"><a class="wno" href="javascript:;" onclick="printCourse('<?php echo $courseId;?>');"><img class="icoUp2" src="<?php echo $dirAdj;?>img/icons/print.svg">&nbsp;&nbsp;Print Forecast</a></div>
				</div>
			</div>

			<div class="butCircle2">
				<div class="flex">
					<div class="butMoreTxt f15B"><a class="wno" href="<?php echo $dirAdj;?>share-course.php?courseId=<?php echo $courseId;?>"><img class="icoUp2" src="<?php echo $dirAdj;?>img/icons/share.svg">&nbsp;&nbsp;Share Forecast</a></div>
				</div>
			</div>
		</div>
		
		
		<div class="flex featbot mt20">
			<div class="normhead pt20"><span class="green">Courses Near By:</span> <?php echo $courseName;?></div>
		</div>

		<?php for ($s=0;$s<=4;$s++){?>
			<?php if(isset($nearBy[$s]['coursePageUrl'])){?>
			<div class="topcourseSumm <?php if($s==0){?>mt20<?php }else{?>mt10<?php }?>">
				<div class="srUri flex" onclick="javascript:location.href='../../../../../<?php echo $nearBy[$s]['coursePageUrl'];?>';">
					<div class="courseName"><?php echo $nearBy[$s]['name'];?></div>
					<div class="courseTemp flexCent"><?php echo $nearBy[$s]['tempHigh'];?>&deg;</div>
					<div class="tempIco flexCent"><img src="<?php echo $dirAdj;?>img/icons/<?php echo $nearBy[$s]['icon'];?>.svg" class="" /></div>
				</div>
				<div class="srNearIco"><div class="rateIco"><a href="javascript:;" onclick="setFav(<?php echo $nearBy[$s]['courseId'];?>);"><img id="favstar_<?php echo $nearBy[$s]['courseId'];?>" src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $nearBy[$s]['courseId']) {?>full<?php }else{?>empty<?php }?>.svg" /></a></div></div>
				<div style="clear:both"></div>
			</div>
			<?php }?>
		<?php }?>

		<div class="flex featbot mt20">
			<div class="normhead pt20"><span class="green">Radar Map:</span> <?php echo $courseName;?></div>
		</div>
		
		<div class="mt20">
			<?php if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost")) > 0){?>
			<img src="<?php echo $dirAdj;?>img/courses/map@2x.png" class="fw" />
			<?php }else{?>
			<iframe width="100%" height="450" src="https://embed.windy.com/embed.html?type=map&location=coordinates&metricRain=default&metricTemp=default&metricWind=default&zoom=10&overlay=wind&product=ecmwf&level=surface&lat=<?php echo $courseLat;?>&lon=<?php echo $courseLon;?>&pressure=true" frameborder="0"></iframe>
			<?php }?>
		</div>

		<div class="flex featbot mt20">
			<div class="normhead pt20"><span class="green">Course Information:</span> <?php echo $courseName;?></div>
		</div>
		
		<div class="infoDim mt20 f15N">
			<div class="courseImages pt20">
				<div class="courseImg1">
					<img src="<?php echo $dirAdj;?>img/courses/logo_rev.jpg" class="fw" />
				</div>
				<div class="courseImg2">
					<img src="<?php echo $dirAdj;?>img/courses/milnerton-golf-course.png" class="fw" />
				</div>
				<div class="courseImg3">
					<img src="<?php echo $dirAdj;?>img/courses/Milnerton-Golf-Course-Cape-Town-South-Africa-Aerial-View.png" class="fw" />
				</div>
			</div>
			<div style="clear:both"></div>
			<br />			
			<?php echo $courseDetails;?>

			<div class="flex pt20">
				<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-pin.svg" class="address-ico" /></div>
				<div class="address-txt white f15N"><?php echo $courseAddress;?></div>
			</div>
			<div class="flex pt-1">
				<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-tel.svg" class="address-ico" /></div>
				<div class="address-txt white f15N"><?php echo $coursePhone;?></div>
			</div>
		</div>

	</div>
	<div class="fixed-width">
<?php
	require_once("includes/banners.php");
?>            
	</div>
</main>
<div class="mobidiv">
	<div class="mobiinner">
		<div class="mob-banner1">
			<img src="<?php echo $dirAdj;?>img/banners/tag-heuer-mobi.jpg" class="fw" /><div id="txtmob" class="clockmob"></div>
		</div>

		<div class="flexible-width2">
			<div class="featbot pb20">
				<div class="flex" style="width:100%">
					<div class="fcName"><?php echo $courseName;?><div class="arrowWht down showM" onclick="toggleD('hidmobAdd');"></div></div>
					<div class="fcIco"><img src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $courseId) {?>full<?php }else{?>empty<?php }?>.svg" /></div>
				</div>
				<div class="hidmobAdd">
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
			<div class="featbot pb15">
				<div class="flex">
					<div style="width:90%">
						<div class="forecasthead pt10"><span class="green">7 Day Detailed</span> Forecast</div>
						<div class="f15B">Forecast Updated: <span class="fTime"><?php echo date($timeHour.':i a', strtotime($summary7Page[0]['updated']))?> Local time</span></div>
					</div>
					<div class="fcIcoMet"><a href="javascript:;" onclick="metricsM();"><img src="<?php echo $dirAdj;?>img/icons/metrics.svg" /></a></div>
				</div>
			</div>
			<div id="metricMo" class="bgSum hidmob metrDet">
				<div class="flex pt20">
					<div class="f15N pt5 pe-2 ps-3">Rain</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($rainOpt) || $rainOpt == 'mm'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('rain','mm');">
							mm
						</div>
						<div class="f12N metric<?php if(isset($rainOpt) && $rainOpt == 'in'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('rain','in');">
							in
						</div>
					</div>
					<div class="f15N pt5 pe-2 ps-3">Temp</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($tempOpt) || $tempOpt == 'C'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('temp','C');">
							&deg;C
						</div>
						<div class="f12N metric<?php if(isset($tempOpt) && $tempOpt == 'F'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('temp','F');">
							&deg;F
						</div>
					</div>
				</div>
				<div class="flex pt15">
					<div class="f15N pt5 pe-2 ps-3">Time</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($timeOpt) || $timeOpt == 12){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('time',12);">
							12h
						</div>
						<div class="f12N metric<?php if(isset($timeOpt) && $timeOpt == 24){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('time',24);">
							24h
						</div>
					</div>
					<div class="f15N pt5 pe-2 ps-3">Wind</div>
					<div class="flex metricOut">
						<div class="f12N metric<?php if(!isset($windOpt) || $windOpt == 'kmh'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('wind','kmh');">
							kmh
						</div>
						<div class="f12N metric<?php if(isset($windOpt) && $windOpt == 'mph'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('wind','mph');">
							mph
						</div>
					</div>
				</div>
			</div>
			<div id="dayTopDetailsMob" class="pb20">
				<div class="flex pb15 featbot">
					<div class="pt15 ml5"><img style="width:50px" src="<?php echo $dirAdj;?>img/icons/<?php if(date('H') >= 7 && date('H') <= 17){?>sunrise<?php }else{?>night-white<?php }?>.svg" /></div>
					<div class="f18M pe-3 ms-3 pt30"><?php echo date('D d M', strtotime($summary7Page[0]['local_time']))?></div>
				</div>
				<div class="flex pt20">
					<div class="">
						<div class="f15B">Sunrise:</div>
						<div class="f15M fTimeMob"><?php echo date($timeHour.':i',strtotime($summary7Page[0]['sunrise']));?>am&nbsp;&nbsp;</div>
					</div>
					<div class="genSplitMob">
						<div class="f15M">Sunset:</div>
						<div class="f15M fTimeMob"><?php echo date($timeHour.':i',strtotime($summary7Page[0]['sunset']));?>pm</div>
					</div>
					<div class="genSplitMob">
						<div class="f15B">Forecast Updated:</div>
						<div class="f15M fTimeMob"><?php echo date($timeHour.':i a', strtotime($summary7Page[0]['updated']))?> Local time</div>
					</div>
				</div>
			</div>
			<div class="flex bgDetTop">
				<div class="botforecastmobiOutDet">
					<div class="botforecastmobidetailed">
						<div class="botforecast">
							<?php for ($s=0;$s<=6;$s++){?>
						
							<div id="dayDetF_<?php echo $s;?>" class="days7Det<?php if($s == 0){?> days7SelDet<?php }?>" onclick="javascript:doDetailedDayMob(<?php echo $s;?>);">
								<div class="daysDetInner<?php if($s == 0){?>First<?php }?>">
									<?php echo $summary7Page[$s]['weekday'];?>
									<div class="daysTemp"><?php echo date('d', strtotime($summary7Page[$s]['local_time']))?></div>
								</div>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			
			<div id="dayDetailsMob">
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
							$dayCourseCountry = getCountryName($getResDetDays['country_id'],$db);
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
				
			</div>

			<div class="mt20">
				<div class="butCircle" onclick="javascript:location.href='<?php echo $dirAdj;?><?php echo $summaryCoursePageUrl;?>';">
					<div class="flex">
						<div class="butMoreTxtAllGreen f15B"><img class="icoUp" src="<?php echo $dirAdj;?>img/icons/calendar-green.svg">&nbsp;&nbsp;7 Day Forecast Summary</div>
					</div>
				</div>
	
				<div class="butCircle2">
					<div class="flex">
						<div class="butMoreTxtAll f15B"><a class="wno" href="javascript:;" onclick="printCourse('<?php echo $courseId;?>');"><img class="icoUp" src="<?php echo $dirAdj;?>img/icons/print.svg">&nbsp;&nbsp;Print Forecast</a></div>
					</div>
				</div>
	
				<div class="butCircle2">
					<div class="flex">
						<div class="butMoreTxtAll f15B"><a class="wno" href="<?php echo $dirAdj;?>share-course.php?courseId=<?php echo $courseId;?>"><img class="icoUp" src="<?php echo $dirAdj;?>img/icons/share.svg">&nbsp;&nbsp;Share Forecast</a></div>
					</div>
				</div>
			</div>
			
			
			<div class="flex featbot mt10 pb15">
				<div class="normhead pt20"><span class="green">Courses Near By:</span> <?php echo $courseName;?></div>
			</div>
	
			<?php for ($s=0;$s<=4;$s++){?>
				<?php if(isset($nearBy[$s]['coursePageUrl'])){?>
				<div class="topcourse <?php if($s==0){?>mt20<?php }else{?>mt10<?php }?>">
					<div class="flex100">
						<div class="srUri flex" onclick="javascript:location.href='<?php echo $coursePageUrl;?>';">
							<div class="courseName"><?php echo substr($nearBy[$s]['name'], 0, 23);?></div>
							<div class="courseTemp flexCent"><?php echo $nearBy[$s]['tempHigh'];?>&deg;</div>
							<div class="tempIco flexCent"><img src="<?php echo $dirAdj;?>img/icons/<?php echo $nearBy[$s]['icon'];?>.svg" class="" /></div>
						</div>
						<div class="srNearIco"><div class="rateIco"><a href="javascript:;" onclick="setFavMob(<?php echo $nearBy[$s]['courseId'];?>);"><img id="favstarMob_<?php echo $nearBy[$s]['courseId'];?>" src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $nearBy[$s]['courseId']) {?>full<?php }else{?>empty<?php }?>.svg" /></a></div></div>
					</div>
					<div style="clear:both"></div>
				</div>
				<?php }?>
			<?php }?>
	
			<div class="flex featbot mt20">
				<div class="normhead pt20"><span class="green">Radar Map:</span> <?php echo $courseName;?></div>
			</div>
			
			<div class="mt20">
			<?php if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost")) > 0){?>
			<img src="<?php echo $dirAdj;?>img/courses/map@2x.png" class="fw" />
			<?php }else{?>
			<iframe width="100%" height="450" src="https://embed.windy.com/embed.html?type=map&location=coordinates&metricRain=default&metricTemp=default&metricWind=default&zoom=10&overlay=wind&product=ecmwf&level=surface&lat=<?php echo $courseLat;?>&lon=<?php echo $courseLon;?>&pressure=true" frameborder="0"></iframe>
			<?php }?>
			</div>
	
			<div class="flex featbot mt20">
				<div class="normhead pt20"><span class="green">Course Information:</span> <?php echo $courseName;?></div>
			</div>
			
			<div class="infoDim mt20 mb20 f15N">
				<div class="courseImages pt20">
					<div class="courseImg1">
						<img src="<?php echo $dirAdj;?>img/courses/logo_rev.jpg" class="fw" />
					</div>
					<div class="courseImg2">
						<img src="<?php echo $dirAdj;?>img/courses/milnerton-golf-course.png" class="fw" />
					</div>
					<div class="courseImg3">
						<img src="<?php echo $dirAdj;?>img/courses/Milnerton-Golf-Course-Cape-Town-South-Africa-Aerial-View.png" class="fw" />
					</div>
				</div>
				<div style="clear:both"></div>
				<br />			
				<?php echo $courseDetails;?>
	
				<div class="flex pt20">
					<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-pin.svg" class="address-ico" /></div>
					<div class="address-txt white f15N"><?php echo $courseAddress;?></div>
				</div>
				<div class="flex pt-1">
					<div class="address"><img src="<?php echo $dirAdj;?>img/icons/address-tel.svg" class="address-ico" /></div>
					<div class="address-txt white f15N"><?php echo $coursePhone;?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="botSpace"></div>
<?php
	require_once("includes/footer.php");
?>            

