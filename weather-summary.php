<?php
	require_once("includes/header.php");
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="flex featbot pb20">
			<div class="flexible-width">
				<div class="flex">
					<div class="fcName"><?php echo $courseName;?></div>
					<div class="fcIco"><img src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $courseId) {?>full<?php }else{?>empty<?php }?>.svg" /></div>
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
		<div class="flex pb20">
			<div class="normhead pt20"><span class="green">7 Day Summary</span> Forecast</div>
			<div class="flex genSplit">
				<div class="f18B pe-1">Forecast Updated:</div>
				<div class="f18M fTime"><?php echo date($timeHour.':i a', strtotime($summary7Page[0]['updated']))?> Local time</div>
			</div>
		</div>
		
		<div class="flex bgSum pt20 pb20">
			<div class="fixed-width-sum-date f18B"><?php echo date('D d M', strtotime($summary7Page[0]['local_time']))?> - <?php echo date('D d M', strtotime($summary7Page[6]['local_time']))?></div>
			<div class="f15N pt3 pe-2 ">Time</div>
			<div class="flex metricOut">
				<div class="f12N metric<?php if(!isset($timeOpt) || $timeOpt == 12){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('time',12);">
					12h
				</div>
				<div class="f12N metric<?php if(isset($timeOpt) && $timeOpt == 24){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('time',24);">
					24h
				</div>
			</div>
			<div class="f15N pt3 pe-2 ps-3">Wind</div>
			<div class="flex metricOut">
				<div class="f12N metric<?php if(!isset($windOpt) || $windOpt == 'kmh'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('wind','kmh');">
					kmh
				</div>
				<div class="f12N metric<?php if(isset($windOpt) && $windOpt == 'mph'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('wind','mph');">
					mph
				</div>
			</div>
			<div class="f15N pt3 pe-2 ps-3">Rain</div>
			<div class="flex metricOut">
				<div class="f12N metric<?php if(!isset($rainOpt) || $rainOpt == 'mm'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('rain','mm');">
					mm
				</div>
				<div class="f12N metric<?php if(isset($rainOpt) && $rainOpt == 'in'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('rain','in');">
					in
				</div>
			</div>
			<div class="f15N pt3 pe-2 ps-3">Temp</div>
			<div class="flex metricOut">
				<div class="f12N metric<?php if(!isset($tempOpt) || $tempOpt == 'C'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('temp','C');">
					&deg;C
				</div>
				<div class="f12N metric<?php if(isset($tempOpt) && $tempOpt == 'F'){?>Sel<?php }else{?>Opt<?php }?>" onclick="javascript:metrics('temp','F');">
					&deg;F
				</div>
			</div>
		</div>
		
		<div class="botforecast mt20Sum">
			<div class="somCol1 bgSum f14B">
				Day
			</div>
			<div class="somCol2 bgSum f14B">
				Condition
			</div>
			<div class="somCol3 bgSum f14B">
				Low Temp
			</div>
			<div class="somCol4 bgSum f14B">
				High Temp
			</div>
			<div class="somCol5 bgSum f14B">
				Wind/Dir
			</div>
			<div class="somCol6 bgSum f14B">
				Rain/mm
			</div>
			<div class="somCol7 bgSum f14B">
				Sunrise Sunset
			</div>
		</div>

		<?php for ($s=0;$s<=6;$s++){?>
		
		<div class="botforecastSumm<?php if($s < 6){?> sumbot<?php }?>">
			<div class="somCol1">
				<div class="f15N"><?php echo date('D. d F', strtotime($summary7Page[$s]['local_time']))?></div>
				<div class="f9N">Rating</div>
				<div class="">
					<?php for($si=0;$si<$summary7Page[$s]['rating'];$si++){ ?>
					<img class="timestar" src="<?php echo $dirAdj;?>img/icons/star-green.svg">
					<?php }?>
					<?php for($si=0;$si<(5-$summary7Page[$s]['rating']);$si++){ ?>
					<img class="timestar" src="<?php echo $dirAdj;?>img/icons/star-wht.svg">
					<?php }?>
				</div>
			</div>
			<div class="somCol2">
				<div class="daysIco"><img src="<?php echo $dirAdj;?>img/icons/<?php echo $summary7Page[$s]['icon'];?>.svg" class="weatherSVG" /></div>
				<div class="f15N pt4Dir"><?php echo $summary7Page[$s]['conditions'];?></div>
			</div>
			<div class="flexCent somCol3">
				<div class="f20B"><?php echo $summary7Page[$s]['tempLow'];?>&deg;</div>
			</div>
			<div class="flexCent somCol4">
				<div class="f20B"><?php echo $summary7Page[$s]['tempHigh'];?>&deg;</div>
			</div>
			<div class="somCol5">
				<img src="<?php echo $dirAdj;?>img/icons/wind-oval.svg" style="transform: rotate(<?php echo ($summary7Page[$s]['wind_dir_deg']+128);?>deg);" class="cover-img pb8" />
				<div class="f15N pt6Dir"><?php echo $summary7Page[$s]['windSpeed'];?> <?php echo $windOpt;?> | <?php echo $summary7Page[$s]['wind_dir_desc'];?></div>
			</div>
			<div class="flexCent somCol6">
				<div class="f15N"><?php echo $summary7Page[$s]['pop_perc'];?>%<br /><?php echo $summary7Page[$s]['rainMeas'];?><?php echo $rainOpt;?></div>
			</div>
			<div class="flexCent somCol7">
				<div class="f15N"><?php echo date($timeHour.':i',strtotime($summary7Page[$s]['sunrise']));?> am<br /><?php echo date($timeHour.':i',strtotime($summary7Page[$s]['sunset']));?> pm</div>
			</div>
		</div>
		<?php }?>

		<div class="flex featbot mt20">
			&nbsp;
		</div>
		
		<div class="flex mt50">
			<div class="butCircle" onclick="javascript:location.href='<?php echo $dirAdj;?><?php echo $detailedCoursePageUrl;?>';">
				<div class="butMoreTxtGreen f15B"><img class="icoUpSumm" src="<?php echo $dirAdj;?>img/icons/calendar-green.svg">&nbsp;&nbsp;Detailed Forecast</div>
			</div>

			<div class="butCircle2">
				<div class="butMoreTxt f15B"><a class="wno" href="javascript:;" onclick="printCourse('<?php echo $courseId;?>');"><img class="icoUpSumm" src="<?php echo $dirAdj;?>img/icons/print.svg">&nbsp;&nbsp;Print Forecast</a></div>
			</div>

			<div class="butCircle2">
				<div class="butMoreTxt f15B"><a class="wno" href="<?php echo $dirAdj;?>share-course.php?courseId=<?php echo $courseId;?>"><img class="icoUpSumm" src="<?php echo $dirAdj;?>img/icons/share.svg">&nbsp;&nbsp;Share Forecast</a></div>
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
				<div class="fcIco"><a href="javascript:;" onclick="setFav(<?php echo $courseId;?>);"><img src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $courseId) {?>full<?php }else{?>empty<?php }?>.svg" /></a></div>
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
		<div class="featbot pb20">
			<div class="flex">
				<div style="width:90%">
					<div class="forecasthead pt20"><span class="green">7 Day Summary</span> Forecast</div>
					<div class="f15B">Forecast Updated: <span class="fTime"><?php echo date($timeHour.':i a', strtotime($summary7Page[0]['updated']))?> Local time</span></div>
				</div>
				<div class="fcIcoMet"><a href="javascript:;" onclick="metricsM();"><img src="<?php echo $dirAdj;?>img/icons/metrics.svg" /></a></div>
			</div>
		</div>
		
		<div class="pt20 f18B"><?php echo date('l d F', strtotime($summary7Page[0]['local_time']))?> - <?php echo date('D d F', strtotime($summary7Page[6]['local_time']))?></div>
		<div id="metricMo" class="bgSum hidmob">
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

		
		<div class="mt20">
			<div class="butCircle" onclick="javascript:location.href='<?php echo $dirAdj;?><?php echo $detailedCoursePageUrl;?>';">
				<div class="flex">
					<div class="butMoreTxtAllGreen f15B"><img class="icoUp" src="<?php echo $dirAdj;?>img/icons/calendar-green.svg">&nbsp;&nbsp;Detailed Forecast</div>
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

