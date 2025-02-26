<?php
	$hp = 'true';
	require_once("includes/header.php");
	
	if(isset($_COOKIE['lastCourse'])) {
		$getQuery = "
			select 
				c.id, cf.local_time, c.name, cf.".$tempCol." as tempNow, cf.relative_humity, cf.rating, cf.sunrise, cf.sunset, cf.".$windCol." as windSpeed, cf.wind_dir_desc, cf.".$rainCol." as rainMeas, cf.precip_in_3hr, cf.pop_perc, icon, sr.name as subregionsname, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug, c.details, c.url, c.phone, c.address1, c.country_id, c.latitude, c.longitude, c.tzone
			from 
				courses c
				join current_feed cf on c.feedid = cf.feed_id
				left join countries co on co.id = c.country_id
				left join sub_regions sr on sr.id = c.subregion_id
				left join geo_regions gr on gr.id = c.region_id
			where 
				c.id=".$_COOKIE['lastCourse']."
				and c.country_id = cf.country_id
				#and lower(cf.country_id)='".strtolower($geoCountryCode)."'
				#and lower(c.country_id)='".strtolower($geoCountryCode)."' 
				and cf.local_time >= '".$todDate."'
				and cf.local_time <= '".$todDateEnd."'
			limit 1
		";
	}else{
		$getQuery = "
			select 
				c.id, cf.local_time, c.name, cf.".$tempCol." as tempNow, cf.relative_humity, cf.rating, cf.sunrise, cf.sunset, cf.".$windCol." as windSpeed, cf.wind_dir_desc, cf.".$rainCol." as rainMeas, cf.precip_in_3hr, cf.pop_perc, icon, sr.name as subregionsname, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug, c.details, c.url, c.phone, c.address1, c.country_id, c.latitude, c.longitude, c.tzone
			from 
				courses c
				join current_feed cf on c.feedid = cf.feed_id
				left join countries co on co.id = c.country_id
				left join sub_regions sr on sr.id = c.subregion_id
				left join geo_regions gr on gr.id = c.region_id
			where 
				lower(cf.country_id)='".strtolower($geoCountryCode)."'
				and lower(c.country_id)='".strtolower($geoCountryCode)."' 
				and cf.local_time >= '".$todDate."'
				and cf.local_time <= '".$todDateEnd."'
			group by cf.feed_id
			order by 
				".$sqlRegionOrder."
			c.id limit 1
		";
	}

	//echo '<pre>' . $getQuery . '</pre>';
	$getQueryRes = mysqli_query($db,$getQuery);
	$countNumD = mysqli_num_rows($getQueryRes);
	if ($countNumD > 0){
		$getRes = mysqli_fetch_array($getQueryRes);
		$mainCourseId = $getRes['id'];
		$mainCourseCountryId = $getRes['country_id'];
		$mainCourseCountry = getCountryName($getRes['country_id'],$db);
		$mainCourseName = $getRes['name'];
		$mainCourseDetails = $getRes['details'];
		$mainCourseUrl = $getRes['url'];
		$mainCoursePhone = $getRes['phone'];
		$mainCourseAddress = $getRes['address1'];
		$mainCourseRegion = $getRes['subregionsname'];
		
		$mainCourseTemp = $getRes['tempNow'];
		$mainCourseHumid = $getRes['relative_humity'];
		$mainCourseRating = $getRes['rating'];
		$mainCourseSunrise = $getRes['sunrise'];
		$mainCourseSunset = $getRes['sunset'];
		$mainCourseWindspeed = $getRes['windSpeed'];
		$mainCourseWinddir = $getRes['wind_dir_desc'];
		$mainCoursePrec = $getRes['rainMeas'];
		$mainCoursePrecPerc = $getRes['pop_perc'];
		$mainCourseIcon = $getRes['icon'];
		
		$subregionslug = $getRes['subregionslug'];
		if($subregionslug == ''){
			$subregionslug = 'suburb';
		}
		$mainCoursePageUrl = $getRes['countryslug'].'/'.$getRes['regionslug'].'/'.$subregionslug.'/'.filename_safe($getRes['name']).'/detailed/'.$getRes['id'];

		$getQuerySumm7 = "
			select 
				day_no, weekday, cf.".$tempHigh." as tempHigh, cf.".$tempLow." as tempLow, icon
			from 
				courses c
				join current_summary_feed cf on c.feedid = cf.feed_id
			where 
				c.id=".$mainCourseId."
				and lower(cf.country_id)='".strtolower($mainCourseCountryId)."'
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
			
				if(!isset($summary7[$iSum]['weekday'])){ $summary7[$iSum]['weekday'] = $getResSumm7['weekday']; }
				if(!isset($summary7[$iSum]['tempHigh'])){ $summary7[$iSum]['tempHigh'] = $getResSumm7['tempHigh']; }
				if(!isset($summary7[$iSum]['tempLow'])){ $summary7[$iSum]['tempLow'] = $getResSumm7['tempLow']; }
				if(!isset($summary7[$iSum]['icon'])){ $summary7[$iSum]['icon'] = $getResSumm7['icon']; }
			
				$iSum++;
				$getResSumm7 = mysqli_fetch_array($getQueryResSumm7);
			}
		}
		mysqli_free_result($getQueryResSumm7);


	}
	mysqli_free_result($getQueryRes);
?>            

<main class="container deskcontainer">
	<div class="flexible-width">
		<?php if(isset($mainCoursePageUrl)){?>
		<div class="normhead pt20 featbot"><span class="green">Current</span> Forecast</div>
		<div class="topforecast mt20 cp" onclick="javascript:location.href='<?php echo $mainCoursePageUrl;?>';">
			<div class="forecastImg cp" style="position: relative;overflow:hidden">
				<div style="position:absolute;width:100%;/* padding-top:90px; */margin: 71px 0px !important;!i;!;" align="center">
					<img src="img/icons/<?php echo $mainCourseIcon;?>-white.svg" style="width:80px" class="cover-img" />
					<div class="bigTemp" align="center"><?php echo $mainCourseTemp;?>&deg;</div>
					<div class="smlTemp" align="center"><?php echo $mainCourseName;?></div>
					<div class="medTemp" align="center"><?php echo date('l'); ?></div>
					<div class="minTemp" align="center"><?php echo date('d M Y'); ?></div>
				</div>
				<div style="width:100%;">
					<img src="img/golf_weather_courses.webp" style="height:463px;" />
				</div>
			</div>
			<div class="forecastInfo">
				<div class="currentbot">
					<div class="fcName<?php if(strlen($mainCourseName) > 20){?>Mult<?php }?>"><?php echo $mainCourseName;?></div>
					<div class="fcSubName"><?php if($mainCourseRegion != ''){?><?php echo $mainCourseRegion?>, <?php }?><?php echo $mainCourseCountry?></div>
				</div>
				<div class="types">
					<div class="fcType1">WIND</div>
					<div class="fcType2"><?php echo $mainCourseWindspeed;?><?php echo $windOpt;?> <?php echo $mainCourseWinddir;?></div>
				</div>
				<div class="types">
					<div class="fcType1">RAIN/<?php echo $rainOpt;?></div>
					<div class="fcType2"><?php echo $mainCoursePrecPerc;?>% <?php echo $mainCoursePrec;?><?php echo $rainOpt;?></div>
				</div>
				<div class="types">
					<div class="fcType1">RATING</div>
					<div class="fcType2">
						<?php for($s=0;$s<$mainCourseRating;$s++){ ?>
						<img src="img/icons/star-green.svg">
						<?php }?>
						<?php for($s=0;$s<(5-$mainCourseRating);$s++){ ?>
						<img src="img/icons/star-wht.svg">
						<?php }?>
					</div>
				</div>
				<div class="typeslast">
					<div class="fcType1">SUNRISE: <?php echo date($timeHour.':i',strtotime($mainCourseSunrise));?>AM</div>
					<div class="fcType2">SUNSET: <?php echo date($timeHour.':i',strtotime($mainCourseSunset));?>PM</div>
				</div>
				
				<div class="butFC">
					<button class="greenBtn" onclick="javascript:location.href='<?php echo $mainCoursePageUrl;?>';">View 7 Day Forecast</button>
				</div>
				
			</div>
		</div>
		<div class="botforecast">
			<?php for($d=0;$d<=6;$d++){?>
			<div onmouseover="sevenDayOver(<?php echo $d;?>);" onmouseout="sevenDayOut(<?php echo $d;?>);" class="days7<?php if($d == 0){?> days7Sel<?php }?>" onclick="javascript:location.href='<?php echo $mainCoursePageUrl;?>?day=<?php echo $d;?>';">
				<div id="dayin_<?php echo $d;?>" class="daysInner<?php if($d == 0){?>First<?php }elseif($d == 6){?>Last<?php }?>">
					<div class="daysIcoHome flexCent"><img src="img/icons/<?php echo $summary7[$d]['icon'];?>.svg" class="w30" /></div>
					<?php echo $summary7[$d]['weekday'];?>
					<div class="daysTempHome"><?php echo $summary7[$d]['tempHigh'];?>&deg;</div>
				</div>
			</div>
			<?php }?>
		</div>
		<?php }?>
	</div>
	<div class="fixed-width">
		<div class="normhead pt20 featbot"><span class="green">Featured</span> Courses</div>
		<?php
			$getQuerySummary = "
				select 
					csf.local_time, c.name, csf.hi_cel, csf.hi_fahr,csf.Conditions
				from 
					courses c
					join current_summary_feed csf on c.feedid = csf.feed_id
				where 
					c.flow_state_id=4
					and lower(csf.country_id)='".strtolower($geoCountryCode)."'
					and lower(c.country_id)='".strtolower($geoCountryCode)."' 
					and csf.local_time >= '".$todDateSum."'
				group by csf.feed_id
				order by 
					".$sqlRegionOrderSum."
				c.id limit 10
			";
			$getQuery = "
				select 
					c.id, cf.local_time, c.name, cf.".$tempCol." as tempNow, icon, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug
				from 
					courses c
					join current_feed cf on c.feedid = cf.feed_id
					left join countries co on co.id = c.country_id
					left join sub_regions sr on sr.id = c.subregion_id
					left join geo_regions gr on gr.id = c.region_id
				where 
					lower(cf.country_id)='".strtolower($geoCountryCode)."'
					and lower(c.country_id)='".strtolower($geoCountryCode)."' 
					and cf.local_time >= '".$todDate."'
					and cf.local_time <= '".$todDateEnd."'
				group by cf.feed_id
				order by 
					".$sqlRegionOrder."
				c.id limit 10
			";
			//echo $getQuery;
			$getQueryRes = mysqli_query($db,$getQuery);
			$countNumD = mysqli_num_rows($getQueryRes);
			if ($countNumD > 0){
				$getRes = mysqli_fetch_array($getQueryRes);
				$i=0;
				while($i < $countNumD){
					$courseName = $getRes['name'];
					if(strlen($courseName) > 20){
						$courseName = substr($courseName, 0, 20) . '...';
					}
					
					$coursePageUrl = $getRes['countryslug'].'/'.$getRes['regionslug'].'/'.$getRes['subregionslug'].'/'.filename_safe($getRes['name']).'/detailed/'.$getRes['id'];
					
					$featicon = $getRes['icon'] . '.svg';
					
					/*
					$conditions = $getRes['Conditions'];
					if($conditions == 'Sunny'){$featicon = 'sunny.png';}
					if($conditions == 'Overcast'){$featicon = 'cloudy.png';}
					if($conditions == 'Chance of Rain'){$featicon = 'rainy.png';}
					if($conditions == 'Partly Cloudy'){$featicon = 'partly.png';}
					if($conditions == 'Mostly Cloudy'){$featicon = 'cloudy.png';}
					if($conditions == 'Chance of Snow'){$featicon = 'cloudy.png';}
					if($conditions == 'T.Storms possible'){$featicon = 'thunder.png';}
					*/
		?>
		<div class="topcourse <?php if($i==0){?>mt20<?php }else{?>mt10<?php }?>" onclick="javascript:location.href='<?php echo $coursePageUrl;?>';">
			<div class="courseName" title="<?php echo $getRes['name'];?>"><?php echo $courseName;?></div>
			<div class="courseTempHome flexCent"><?php echo $getRes['tempNow'];?>&deg;</div>
			<div class="tempIco flexCent"><img src="img/icons/<?php echo $featicon;?>" class="" /></div>
			<div style="clear:both"></div>
		</div>
		<?php
					$i++;
					$getRes = mysqli_fetch_array($getQueryRes);
				}
			}
			mysqli_free_result($getQueryRes);
		?>
		&nbsp;
	</div>
	<div class="fixed-width bannersd">
		<div class="pt20"><a href=""><img src="img/banners/tag_watch_mobile.webp" class="banner_full" /></a><div id="txt" class="clock"></div></div>
		<div class="pt10"><a href=""><img src="img/banners/banner1.webp" class="banner_full" /></a></div>
		<div class="pt10"><a href=""><img src="img/banners/appleapp_banner.webp" class="banner_full" /></a></div>
		<div class="pt10"><a href=""><img src="img/banners/googleapp_banner.webp" class="banner_full" /></a></div>
		<div class="pt10"><a href=""><img src="img/banners/banner3.webp" class="banner_full" /></a></div>
	</div>
</main>
<main class="container deskcontainer mu60">
	<div class="flexible-width2">
		<div class="normhead pt20 featbot" style="width:100%"><span class="green">Latest</span> Golf News</div>
	</div>
	<div class="fixed-width"></div>
</main>
<main class="container deskcontainer">
	<div class="botnewsA pt20">
		<?php if(isset($news5Home[0]['commentDate'])){?>
		<div class="botnewsA1">
			<div class="newsImgBig" style="background-image: url(system-files/<?php echo $news5Home[0]['headlineImg'];?>)" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[0]['newsId'];?>';">
				<div class="botNewsAIco">
					<img src="img/icons/gw_logo_sml2x.png" class="cover-img" />
				</div>
				<div class="botNewsATXT">
					<?php echo $news5Home[0]['heading']?><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[0]['commentDate']))?></span>
				</div>
				<div class="mainNewsOver">
					&nbsp;
				</div>
			</div>
		</div>
		<?php }?>
		<?php if(isset($news5Home[1]['commentDate'])){?>
		<div class="botnewsA2">
			<div class="newsImgBig" style="background-image: url(system-files/<?php echo $news5Home[1]['headlineImg'];?>)" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[1]['newsId'];?>';">
				<div class="botNewsAIco">
					<img src="img/icons/gw_logo_sml2x.png" class="cover-img" />
				</div>
				<div class="botNewsATXT">
					<?php echo $news5Home[1]['heading']?><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[1]['commentDate']))?></span>
				</div>
				<div class="mainNewsOver">
					&nbsp;
				</div>
			</div>
		</div>
		<?php }?>
		<div class="botnewsA3">
			<a href=""><img src="img/banners/banner2.webp" class="banner_full" /></a>
		</div>
	</div>
</main>
<main class="container deskcontainer">
	<div class="botnewsB pt20">
		<?php if(isset($news5Home[2]['commentDate'])){?>
		<div class="botnewsB1">
			<div class="newsImgBig" style="background-image: url(system-files/<?php echo $news5Home[2]['headlineImg'];?>)" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[2]['newsId'];?>';">
				<div class="botNewsAIco">
					<img src="img/icons/gw_logo_sml2x.png" class="cover-img" />
				</div>
				<div class="botNewsATXT">
					<?php echo $news5Home[2]['heading']?><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[2]['commentDate']))?></span>
				</div>
				<div class="mainNewsOver">
					&nbsp;
				</div>
			</div>
		</div>
		<?php }?>
		<?php if(isset($news5Home[3]['commentDate'])){?>
		<div class="botnewsB2">
			<div class="newsImgBig" style="background-image: url(system-files/<?php echo $news5Home[3]['headlineImg'];?>)" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[3]['newsId'];?>';">
				<div class="botNewsAIco">
					<img src="img/icons/gw_logo_sml2x.png" class="cover-img" />
				</div>
				<div class="botNewsATXT">
					<?php echo $news5Home[3]['heading']?><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[3]['commentDate']))?></span>
				</div>
				<div class="mainNewsOver">
					&nbsp;
				</div>
			</div>
		</div>
		<?php }?>
		<?php if(isset($news5Home[4]['commentDate'])){?>
		<div class="botnewsB3">
			<div class="newsImgBig" style="background-image: url(system-files/<?php echo $news5Home[4]['headlineImg'];?>)" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[4]['newsId'];?>';">
				<div class="botNewsAIco">
					<img src="img/icons/gw_logo_sml2x.png" class="cover-img" />
				</div>
				<div class="botNewsATXT">
					<?php echo $news5Home[4]['heading']?><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[4]['commentDate']))?></span>
				</div>
				<div class="mainNewsOver">
					&nbsp;
				</div>
			</div>
		</div>
		<?php }?>
		<div class="botnewsB4">
			&nbsp;
		</div>
	</div>
	<div style="clear:both"></div>
</main>

<div class="mobidiv">
	<div class="mobiinner">
		<div class="mob-banner1">
			<img src="<?php echo $dirAdj;?>img/banners/tag-heuer-mobi.jpg" class="fw" /><div id="txtmob" class="clockmob"></div>
		</div>
		<div class="mob-fc-option pt10">
			<div id="curforcast" class="mob-fc-option1 mob-fc-option-sel" onclick="javascript:loadCurrentFeat('C');">Current Forecast</div>
			<div id="featcourse" class="mob-fc-option2" onclick="javascript:loadCurrentFeat('F');">Featured Courses</div>
		</div>
		<div class="mob-current">
			<div class="current-banner">
				<div style="position:absolute;width:100%;height:100%;z-index:100;">
					<div class="flexCent" style="height:100%;">
						<div class="mob-fc-main1 ">
							<img src="img/icons/<?php echo $mainCourseIcon;?>-white.svg" style="width:80px;" class="" />
						</div>
						<div class="mob-fc-main2">
							<div class="bigTemp" align="center"><?php echo $mainCourseTemp;?>&deg;</div>
						</div>
						<div class="mob-fc-main3">
							<div class="smlTemp"><?php echo $mainCourseName;?></div>
							<div class="medTemp"><strong><?php echo date('l'); ?></strong></div>
							<div class="minTemp"><?php echo date('d M Y'); ?></div>
						</div>
					</div>
				</div>
				<div class="mobiBG"><img src="<?php echo $dirAdj;?>img/mobile_currentcourse_banner.webp" class="fw" /></div>
			</div>

			<div class="forecastInfo">
				<div class="currentbot">
					<div class="fcName"><?php echo $mainCourseName;?></div>
					<div class="fcSubName"><?php if($mainCourseRegion != ''){?><?php echo $mainCourseRegion?>, <?php }?><?php echo $mainCourseCountry?></div>
				</div>
				<div class="types">
					<div class="fcType1">WIND</div>
					<div class="fcType2"><?php echo $mainCourseWindspeed;?><?php echo $windOpt;?> <?php echo $mainCourseWinddir;?></div>
				</div>
				<div class="types">
					<div class="fcType1">RAIN/<?php echo $rainOpt;?></div>
					<div class="fcType2"><?php echo $mainCoursePrecPerc;?>% <?php echo $mainCoursePrec;?><?php echo $rainOpt;?></div>
				</div>
				<div class="types">
					<div class="fcType1">RATING</div>
					<div class="fcType2">
						<?php for($s=0;$s<$mainCourseRating;$s++){ ?>
						<img src="img/icons/star-green.svg">
						<?php }?>
						<?php for($s=0;$s<(5-$mainCourseRating);$s++){ ?>
						<img src="img/icons/star-wht.svg">
						<?php }?>
					</div>
				</div>
				<div class="typeslast">
					<div class="fcType1">SUNRISE: <?php echo date($timeHour.':i',strtotime($mainCourseSunrise));?>AM</div>
					<div class="fcType2">SUNSET: <?php echo date($timeHour.':i',strtotime($mainCourseSunset));?>PM</div>
				</div>
				
				<div class="butFC">
					<button class="greenBtn" onclick="javascript:location.href='<?php echo $mainCoursePageUrl;?>';">View 7 Day Forecast</button>
				</div>
			</div>
			<div class="botforecastmobiOut">
				<div class="botforecastmobi">
					<?php for($d=0;$d<=6;$d++){?>
					<div class="days7<?php if($d == 0){?> days7Sel<?php }?>" onclick="javascript:location.href='<?php echo $mainCoursePageUrl;?>';">
						<div class="daysInner<?php if($d == 0){?><?php }elseif($d == 6){?>Last<?php }?>">
							<div class="daysIcoHome flexCent"><img src="img/icons/<?php echo $summary7[$d]['icon'];?>.svg" class="w30" /></div>
							<?php echo $summary7[$d]['weekday'];?>
							<div class="daysTempHome"><?php echo $summary7[$d]['tempHigh'];?>&deg;</div>
						</div>
					</div>
					<?php }?>
				</div>
				<br />
			</div>
			<div class="botSpace" style="height:30px">&nbsp;</div>

		</div>
		<div class="mob-featured pb20">
			<div class="normhead pt20 featbot"><span class="green">Featured</span> Courses</div>
		<?php
			$getQuerySummary = "
				select 
					csf.local_time, c.name, csf.hi_cel, csf.hi_fahr,csf.Conditions
				from 
					courses c
					join current_summary_feed csf on c.feedid = csf.feed_id
				where 
					c.flow_state_id=4
					and lower(csf.country_id)='".strtolower($geoCountryCode)."'
					and lower(c.country_id)='".strtolower($geoCountryCode)."' 
					and csf.local_time >= '".$todDateSum."'
				group by csf.feed_id
				order by 
					".$sqlRegionOrderSum."
				c.id limit 10
			";
			$getQuery = "
				select 
					c.id, cf.local_time, c.name, cf.".$tempCol." as tempNow, icon, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug
				from 
					courses c
					join current_feed cf on c.feedid = cf.feed_id
					left join countries co on co.id = c.country_id
					left join sub_regions sr on sr.id = c.subregion_id
					left join geo_regions gr on gr.id = c.region_id
				where 
					lower(cf.country_id)='".strtolower($geoCountryCode)."'
					and lower(c.country_id)='".strtolower($geoCountryCode)."' 
					and cf.local_time >= '".$todDate."'
					and cf.local_time <= '".$todDateEnd."'
				group by cf.feed_id
				order by 
					".$sqlRegionOrder."
				c.id limit 10
			";
			//echo $getQuery;
			$getQueryRes = mysqli_query($db,$getQuery);
			$countNumD = mysqli_num_rows($getQueryRes);
			if ($countNumD > 0){
				$getRes = mysqli_fetch_array($getQueryRes);
				$i=0;
				while($i < $countNumD){
					$courseName = $getRes['name'];
					if(strlen($courseName) > 20){
						$courseName = substr($courseName, 0, 20) . '...';
					}
					
					$coursePageUrl = $getRes['countryslug'].'/'.$getRes['regionslug'].'/'.$getRes['subregionslug'].'/'.filename_safe($getRes['name']).'/detailed/'.$getRes['id'];
					
					$featicon = $getRes['icon'] . '.svg';
					
					/*
					$conditions = $getRes['Conditions'];
					if($conditions == 'Sunny'){$featicon = 'sunny.png';}
					if($conditions == 'Overcast'){$featicon = 'cloudy.png';}
					if($conditions == 'Chance of Rain'){$featicon = 'rainy.png';}
					if($conditions == 'Partly Cloudy'){$featicon = 'partly.png';}
					if($conditions == 'Mostly Cloudy'){$featicon = 'cloudy.png';}
					if($conditions == 'Chance of Snow'){$featicon = 'cloudy.png';}
					if($conditions == 'T.Storms possible'){$featicon = 'thunder.png';}
					*/
		?>
		<div class="topcourse <?php if($i==0){?>mt20<?php }else{?>mt10<?php }?>" onclick="javascript:location.href='<?php echo $coursePageUrl;?>';">
			<div class="courseName" title="<?php echo $getRes['name'];?>"><?php echo $courseName;?></div>
			<div class="courseTempHome flexCent"><?php echo $getRes['tempNow'];?>&deg;</div>
			<div class="tempIco flexCent"><img src="img/icons/<?php echo $featicon;?>" class="" /></div>
			<div style="clear:both"></div>
		</div>
		<?php
					$i++;
					$getRes = mysqli_fetch_array($getQueryRes);
				}
			}
			mysqli_free_result($getQueryRes);
		?>
		</div>
		<div class="mob-banner1 pt10">
			<a href=""><img src="<?php echo $dirAdj;?>img/banners/banner2.webp" class="banner_full" /></a>
		</div>
		<div class="flexible-width2 pb20">
			<div class="normhead pt20 featbot"><span class="green">Latest</span> Golf News</div>
		</div>
		<?php if(isset($news5Home[0]['commentDate'])){?>
		<div class="newsBgHome">
			<div class="newsBgPic">
				<div class="bg-news" style="height:100%">
    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[0]['headlineImg']?>')"></div>
  				</div>
			</div>
			<div class="newsBgIntro">
				<strong><?php echo substr($news5Home[0]['heading'], 0, 40);?></strong><br />
				<div class="newsIntro"><?php echo $news5Home[0]['newsIntro']?></div>
				<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[0]['commentDate']))?></span>
			</div>
		</div>
		<?php }?>
		
		<?php if(isset($news5Home[1]['commentDate'])){?>
		<div class="newsBgHome">
			<div class="newsBgPic">
				<div class="bg-news" style="height:100%">
    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[1]['headlineImg']?>')"></div>
  				</div>
			</div>
			<div class="newsBgIntro">
				<strong><?php echo substr($news5Home[1]['heading'], 0, 40);?></strong><br />
				<div class="newsIntro"><?php echo $news5Home[1]['newsIntro']?></div>
				<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[1]['commentDate']))?></span>
			</div>
		</div>
		<?php }?>
		
		<?php if(isset($news5Home[2]['commentDate'])){?>
		<div class="newsBgHome">
			<div class="newsBgPic">
				<div class="bg-news" style="height:100%">
    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[2]['headlineImg']?>')"></div>
  				</div>
			</div>
			<div class="newsBgIntro">
				<strong><?php echo substr($news5Home[2]['heading'], 0, 40);?></strong><br />
				<div class="newsIntro"><?php echo $news5Home[2]['newsIntro']?></div>
				<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[2]['commentDate']))?></span>
			</div>
		</div>
		<?php }?>

		<div class="butFCL" align="left"><button class="greyBtnWide" onclick="javascript:location.href='news.php';">View All The Latest News</button></div>

		<div class="pb30 mu10">
			<div class="normhead featbot" style="width:100%">&nbsp;</div>
		</div>

		<div class="mob-banner1">
			<img src="<?php echo $dirAdj;?>img/banners/ship-sticks.png" class="fw" />
		</div>

		<div class="botSpace" style="height:30px">&nbsp;</div>
	</div>
</div>

<div class="botSpace"></div>
<?php
	require_once("includes/footer.php");
?>            

