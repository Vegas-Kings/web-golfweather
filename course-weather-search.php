<?php
	require_once("includes/header.php");
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<form id="courseSearch">
		<div class="flex ">
			<div class="flexible-width">
				<div class="normhead pt20 featbot"><span class="green">Search For</span> Your Course</div>
				<div class="flex pt20">
					<div class="flex1"><input maxlength="20" id="searchTXT" name="searchTXT" class="search_page" placeholder="Start typing" onchange="checkInpSearch();" /></div>
					<div class="search_page_ico"><img src="img/icons/search-lrg.png" class="search_pos_page" onclick="mainSearch();" /></div>
					<br /><br />
				</div>
				<div class="flex bgDetTop mt20">
					<input type="Hidden" id="search_continent_id" name="search_continent_id" value="<?php if(!isset($_GET['search_home'])){?>AF<?php }?>" />
					<input type="Hidden" id="AF_lat" value="-28.48322" /><input type="Hidden" id="AF_long" value="24.676997" /><input type="Hidden" id="AS_lat" value="1.2896700" /><input type="Hidden" id="AS_long" value="103.8500700" /><input type="Hidden" id="EU_lat" value="55.3617609" /><input type="Hidden" id="EU_long" value="-3.4433238" /><input type="Hidden" id="NA_lat" value="37.6" /><input type="Hidden" id="NA_long" value="-95.665" /><input type="Hidden" id="OC_lat" value="-26.4390917" /><input type="Hidden" id="OC_long" value="133.281323" /><input type="Hidden" id="SA_lat" value="-38.4192641" /><input type="Hidden" id="SA_long" value="-63.5989206" />
					<div class="botforecast">
						<div id="contAF" class="country6<?php if(!isset($_GET['search_home'])){?> countrySel<?php }?>" onclick="selContinent('AF');">
							<div class="countryInner">
								Africa
							</div>
						</div>
						<div id="contAS" class="country6" onclick="selContinent('AS');">
							<div class="countryInner">
								Asia
							</div>
						</div>
						<div id="contEU" class="country6" onclick="selContinent('EU');">
							<div class="countryInner">
								Europe
							</div>
						</div>
						<div id="contNA" class="country6" onclick="selContinent('NA');">
							<div class="countryInner">
								North America
							</div>
						</div>
						<div id="contOC" class="country6" onclick="selContinent('OC');">
							<div class="countryInner">
								Oceania
							</div>
						</div>
						<div id="contSA" class="country6" onclick="selContinent('SA');">
							<div class="countryInnerLast">
								South America
							</div>
							
						</div>
					</div>
				</div>

				<div class="flexUneven mt20" style="height:40px">
					<div id="countryDD" class="countryCircle dropdown">
						<div class="flexrel" type="button" onclick="shdd('countryDDMain');" style="margin-bottom:8px">
							<?php if(!isset($_GET['search_home'])){?>
							<input type="Hidden" id="search_country_id" name="search_country_id" value="ZA" />
							<div class="countryPlace f15B">Country:</div>
							<div class="countryFlag" id="country_flag_disp"><img src="http://www.golfweather.com/img/countries/ZA-24.png" style="width:17px" class="fw" /></div>
							<div class="countryTxt f15B" id="country_name_disp">South Africa</div>
							<?php }else{?>
							<input type="Hidden" id="search_country_id" name="search_country_id" value="" />
							<div class="countryPlace f15B">Country:</div>
							<div class="countryFlag" id="country_flag_disp"></div>
							<div class="countryTxt f15B" id="country_name_disp">Any</div>
							<?php }?>
							<div class="arrowpos">
								<i class="arrow down"></i>
							</div>
						</div>
						<?php if(!isset($_GET['search_home111'])){?>
							<div id="countryDDMain" class="scrolldd" aria-labelledby="dropdownMenuButton">
								<?php
									$getQueryCountryDD = "
										select 
											co.id, co.name, latitude, longitude
										from 
											countries co
											join geonames ge on ge.id = co.geoname_id
										where 
											co.active=1
											and co.continent = 'AF'
										order by 
											co.name
									";
									//echo '<pre>' . $getQueryCountryDD . '</pre>';
									//die();
									$getQueryResCountryDD = mysqli_query($db,$getQueryCountryDD);
									$countNumCountryDD = mysqli_num_rows($getQueryResCountryDD);
									if ($countNumCountryDD > 0){
										$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
										$iDet=0;
										while($iDet < $countNumCountryDD){
								?>
								<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selCountrySearch('<?php echo $getResCountryDD['id'];?>','<?php echo $getResCountryDD['name'];?>','<?php echo $getResCountryDD['latitude'];?>','<?php echo $getResCountryDD['longitude'];?>');">
									<div class="countryFlagDrop"><img src="http://www.golfweather.com/img/countries/<?php echo $getResCountryDD['id'];?>-24.png" style="width:17px" class="fw" /></div>
									<div class="countryTxtDrop f15B"><?php echo $getResCountryDD['name'];?></div>
								</div>
								<?php
											$iDet++;
											$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
										}
									}
									mysqli_free_result($getQueryResCountryDD);
								?>
								<br />
							</div>
						<?php }?>
					</div>

					<div id="areaDD" class="countryCircle dropdown">
						<div class="flexrel" type="button" onclick="shdd('areaDDMain');" style="margin-bottom:8px">
							<input type="Hidden" id="search_area" name="search_area" value="" />
							<div class="countryPlace f15B">Province/area:</div>
							<div class="countryTxt f15B" id="country_area_disp">Any</div>
							<div class="arrowpos">
								<i class="arrow down"></i>
							</div>
						</div>
						<?php if(!isset($_GET['search_home111'])){?>
							<div id="areaDDMain" class="scrolldd" aria-labelledby="dropdownMenuButton">
								<?php
									$getQueryCountryDD = "
										select 
											id, name
										from 
											geo_regions
										where 
											country_id='ZA'
										order by 
											name
									";
									//echo '<pre>' . $getQueryCountryDD . '</pre>';
									//die();
									$getQueryResCountryDD = mysqli_query($db,$getQueryCountryDD);
									$countNumCountryDD = mysqli_num_rows($getQueryResCountryDD);
									if ($countNumCountryDD > 0){
										$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
										$iDet=0;
										while($iDet < $countNumCountryDD){
								?>
								<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selAreaSearch('<?php echo $getResCountryDD['id'];?>','<?php echo $getResCountryDD['name'];?>','ZA');">
									<div class="countryTxtDrop f15B"><?php echo $getResCountryDD['name'];?></div>
								</div>
								<?php
											$iDet++;
											$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
										}
									}
									mysqli_free_result($getQueryResCountryDD);
								?>
								<br />
							</div>
						<?php }?>
					</div>


					<div class="countryCircle dropdown">
						<input type="Hidden" id="search_city" name="search_city" value="" />
						<div class="flexrel" type="button" onclick="shdd('cityDD');" style="margin-bottom:8px">
							<div class="countryPlace f15B">City:</div>
							<div class="countryTxt f15B" id="country_city_disp">Any</div>
							<div class="arrowpos">
								<i class="arrow down"></i>
							</div>
						</div>
						<div id="cityDD" class="scrolldd" aria-labelledby="dropdownMenuButton">
							<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel">
								<div class="countryTxtDrop f15B">Any</div>
							</div>
							<br />
						</div>
					</div>
					
					<div class="searchDiv">
						<button type="button" class="searchBut" onclick="mainSearch();">Search</button>
					</div>
					
				</div>
				
				<div id="searchResults" class="searchResults">
					<div class="searchResultsInner" style="display:<?php if((isset($_GET['search_home']) && $_GET['search_home'] != '') || (isset($_GET['searchTXT']) && $_GET['searchTXT'] != '')){?>block<?php }else{?>none<?php }?>">
						<?php
							$searchHome = '';
							$searchSql = '';
							if(isset($_GET['search_home'])){
								$searchHome = utf8_encode($_GET['search_home']);
								$searchHome = mysqli_real_escape_string($db, $searchHome);
								$searchSql = "and
									(
										lower(c.name) like '%".strtolower($searchHome)."%'
										or lower(c.address1) like '%".strtolower($searchHome)."%'
									)
								";
							}
						
							if(isset($_GET['searchTXT'])){
								$searchHome = utf8_encode($_GET['searchTXT']);
								$searchHome = mysqli_real_escape_string($db, $searchHome);
								$searchSql = "and
									(
										lower(c.name) like '%".strtolower($searchHome)."%'
										or lower(c.address1) like '%".strtolower($searchHome)."%'
									)
								";
							}
							
							if((isset($_GET['search_home']) && $_GET['search_home'] != '') || (isset($_GET['searchTXT']) && $_GET['searchTXT'] != '')){

							if(isset($_GET['showFrom'])){
								$showFrom = $_GET['showFrom'];
							}else{
								$showFrom = 0;

							}
							if(isset($_GET['showTo'])){
								$showTo = $_GET['showTo'];
							}else{
								$showTo = 10;
							}

							$getQuery = "
								select 
									c.id, cf.local_time, c.name, c.address1, cf.".$tempCol." as tempNow, icon, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug
								from 
									courses c
									join current_feed cf on c.id = cf.course_id
									left join countries co on co.id = c.country_id
									left join sub_regions sr on sr.id = c.subregion_id
									left join geo_regions gr on gr.id = c.region_id
								where 
									cf.local_time >= '".$todDate."'
									and c.flow_state_id = 4
									#and cf.local_time <= '".$todDateEnd."'
									".$searchSql."
								group by c.id
								order by c.name
								
								limit 1000
								
							";
							//echo '<pre>' . $getQuery . '</pre>';
							$getQueryRes = mysqli_query($db,$getQuery);
							$countNumSearch = mysqli_num_rows($getQueryRes);
							$countNumA = $countNumSearch;
							$pageTo = ($showTo*1)/10;
							$pageAll = ceil($countNumA/10);

							if ($countNumSearch > 0){
								$showToMess = $showTo;
								if ($showTo > $countNumSearch){
									$showToMess = $countNumSearch;
								}
						?>
						<div class="flexAlign">
							<div class="resulthead pt25"><span class="green"><?php echo $countNumSearch;?></span> Result<?php if($countNumSearch != 1){?>s<?php }?></div>
							<div class="resulOptDD pt20">
								<div class="flexUneven" style="height:40px;">
									<div class="ddCircle dropdown">
										<input type="Hidden" id="search_DD" name="search_DD" value="" />
										<div class="flexrel" type="button" onclick="shdd('sortDD');" style="margin-bottom:8px">
											<div class="countryPlace f15B">Sort by:</div>
											<div class="countryTxt f15B" id="country_dd_disp">A-Z</div>
											<div class="arrowpos">
												<i class="arrow down"></i>
											</div>
										</div>
										<div id="sortDD" class="scrolldd" aria-labelledby="dropdownMenuButton">
											<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selDDSearch('A-Z','<?php echo $searchHome;?>');">
												<div class="countryTxtDrop f15B">A-Z</div>
											</div>
											<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selDDSearch('Z-A','<?php echo $searchHome;?>');">
												<div class="countryTxtDrop f15B">Z-A</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php

								$getRes = mysqli_fetch_array($getQueryRes);
								$i=0;
								while($i < $countNumSearch){
								
									if ($i >= $showFrom && $i < $showTo){

										$courseName = $getRes['name'];
										$subregionslug = $getRes['subregionslug'];
	
										if(strlen($courseName) > 20){
											$courseName = substr($courseName, 0, 20) . '...';
										}
										
										if($subregionslug == ''){
											$subregionslug = 'golf';
										}
										
										$coursePageUrl = $getRes['countryslug'].'/'.$getRes['regionslug'].'/'.$subregionslug.'/'.filename_safe($getRes['name']).'/detailed/'.$getRes['id'];
										
										$featicon = $getRes['icon'] . '.svg';
						?>
						<div class="topcourseSearch mt10">
							<div class="flex100">
								<div class="srUri flex" onclick="javascript:location.href='<?php echo $coursePageUrl;?>';">
									<div class="coursePin"><img src="<?php echo $dirAdj;?>img/icons/google.svg" class="googlepin" /></div>
									<div class="searchCourseName<?php if($getRes['address1'] == ''){?>Only<?php }?>" title="<?php echo $getRes['name'];?>">
										<?php echo $courseName;?><br />
										<div class="searchCourse"><?php echo substr($getRes['address1'], 0, 80);?></div>
									</div>
									<div class="courseTempSearch flexCent"><?php echo $getRes['tempNow'];?>&deg;</div>
									<div class="tempIcoSearch flexCent"><img src="img/icons/<?php echo $featicon;?>" class="" /></div>
								</div>
								<div class="srIco"><div class="starIco"><a href="javascript:;" onclick="setFav(<?php echo $getRes['id'];?>);"><img id="favstar_<?php echo $getRes['id'];?>" src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $getRes['id']) {?>full<?php }else{?>empty<?php }?>.svg" class="star" /></a></div></div>
							</div>
							<div style="clear:both"></div>
						</div>
						<?php
									}
									$i++;
									$getRes = mysqli_fetch_array($getQueryRes);
								}
						?>
						<div class="flexAlign">
							<div class="missCourse"><button type="button" class="greyBtnMed" onclick="location.href='contact-us.php?subj=missing-course';">Missing course? Let us know</button></div>
						<?php
								if ($countNumSearch > 10){
						?>	
							<div class="course-paggination">
								<!--
								<?php if ($showFrom > 0){?>
                                      <div class="category-paggination-prev category-paggination-disable"><a href="&showTo=<?php echo ($showTo - 10);?>&showFrom=<?php echo ($showFrom - 10);?>"> <dfn>Previous</dfn></a></div>
								<?php }else{?>
                                      <div class="category-paggination-prev category-paggination-disable"> <img src="<?php echo $dirAdj;?>svgs/category-sublevel/arrow-left-blue.svg" alt=""><dfn>Previous</dfn></div>
								<?php }?>
								-->
								<ul class="category-paggination-count">
								<?php
									$aVal = ceil(($showFrom+1)/10)/10;
									$startDig = 1;//stay 1
									$toDig = (floor($aVal)*10)+9;
									if ($toDig > 10){
										$startDig = $toDig - 9;
									}
									$curPage = ceil($showToMess/10);
									$lastPage = ceil($countNumSearch/10);
									if ($toDig > $lastPage){
										$toDig = $lastPage;
									}
									
									if ($startDig > 9){
								?>
									<li><a href="javascript:;" onclick="sPN('<?php echo ((10*$startDig) - 10);?>','<?php echo ((10*$startDig) - 10 - 10);?>','<?php echo $searchHome;?>');"> ...&nbsp;</a></li>
								<?php
									}
									for($cp=$startDig;$cp<=$toDig;$cp++){
										if ($curPage == $cp){
											if($cp == $lastPage){
								?>
									 <li class="li-active"><a onclick="sPN('<?php echo $showTo;?>','<?php echo $showFrom;?>','<?php echo $searchHome;?>');" class="paggination-active">&nbsp;<?php echo $cp;?></a></li>
								<?php
											}else{
								?>
									 <li class="li-active"><a onclick="sPN('<?php echo $showTo;?>','<?php echo $showFrom;?>','<?php echo $searchHome;?>');" class="paggination-active"><?php echo $cp;?></a></li>
								<?php
											}
										}else{
											if($cp == $lastPage){
								?>
									 <li><a onclick="sPN('<?php echo (10*$cp);?>','<?php echo ((10*$cp) - 10);?>','<?php echo $searchHome;?>');"><?php echo $cp;?></a></li>
								<?php
											}else{
								?>
									 <li><a onclick="sPN('<?php echo (10*$cp);?>','<?php echo ((10*$cp) - 10);?>','<?php echo $searchHome;?>');"><?php echo $cp;?></a></li>
								<?php
											}
										}
									}
									if ($cp < $lastPage){
								?>
									<li><a onclick="sPN('<?php echo (10*$cp);?>','<?php echo ((10*$cp) - 10);?>','<?php echo $searchHome;?>');"> ...&nbsp;</a></li>
								<?php
									}
								?>
								</ul>
								<!--
								<?php if ($countNumA > $showTo){?>
                                      <div class="category-paggination-next"><a href="&showTo=<?php echo ($showTo + 10);?>&showFrom=<?php echo ($showTo);?>"><img src="<?php echo $dirAdj;?>svgs/category-sublevel/arrowright-blue.svg" alt=""> <dfn>Next</dfn></a></div> 
								<?php }else{?>
                                      <div class="category-paggination-next category-paggination-disable"><img src="<?php echo $dirAdj;?>svgs/category-sublevel/arrowright-blue.svg" alt=""> <dfn>Next</dfn></div> 
								<?php }?>
								-->
							</div>
						<?php
							}
						?>	
						</div>
						<?php
							}
							mysqli_free_result($getQueryRes);
							
							}
						?>
					</div>
				</div>
				
				<div class="normhead pt20 featbot"><span class="green">Map</span> Search</div>
				<div class="infoDim mt20 f15N pb20" style="position:relative;z-index:0;">
					<div id="map" style="width:100%;height: 490px;"></div>
				</div>
			</div>
		</div>
	</div>
	</form>
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
		<div class="normhead pt20 featbot"><span class="green">Search For</span> Your Course</div>
		<div class="flex pt20">
			<div class="flex1"><input maxlength="20" id="searchTXTMob" name="searchTXTMob" class="search_page" placeholder="Start typing" /></div>
			<div class="search_page_ico"><img src="img/icons/search-lrg.png" class="search_pos_page" onclick="mainSearchMob();" /></div>
			<br /><br />
		</div>

		<div id="searchResultsMob" class="searchResultsMob">
			<div class="searchResultsInnerMob">
				<?php
					$searchSql = '';
					if(isset($_GET['search_home'])){
						$searchHome = utf8_encode($_GET['search_home']);
						$searchHome = mysqli_real_escape_string($db, $searchHome);
						$searchSql = "and
							(
								lower(c.name) like '%".strtolower($searchHome)."%'
								or lower(c.address1) like '%".strtolower($searchHome)."%'
							)
						";
					}
				
					if(isset($_GET['searchTXT'])){
						$searchHome = utf8_encode($_GET['searchTXT']);
						$searchHome = mysqli_real_escape_string($db, $searchHome);
						$searchSql = "and
							(
								lower(c.name) like '%".strtolower($searchHome)."%'
								or lower(c.address1) like '%".strtolower($searchHome)."%'
							)
						";
					}
					
					if(isset($_GET['search_home']) || isset($_GET['searchTXT'])){

					if(isset($_GET['showFrom'])){
						$showFrom = $_GET['showFrom'];
					}else{
						$showFrom = 0;

					}
					if(isset($_GET['showTo'])){
						$showTo = $_GET['showTo'];
					}else{
						$showTo = 10;
					}
					$getQuery = "
						select 
							c.id, cf.local_time, c.name, c.address1, cf.".$tempCol." as tempNow, icon, sr.slug as subregionslug, gr.slug as regionslug, co.slug as countryslug
						from 
							courses c
							join current_feed cf on c.id = cf.course_id
							left join countries co on co.id = c.country_id
							left join sub_regions sr on sr.id = c.subregion_id
							left join geo_regions gr on gr.id = c.region_id
						where 
							cf.local_time >= '".$todDate."'
							and c.flow_state_id = 4
							#and cf.local_time <= '".$todDateEnd."'
							".$searchSql."
						group by c.id
						
						limit 1000
					";
					//echo '<pre>' . $getQuery . '</pre>';
					$getQueryRes = mysqli_query($db,$getQuery);
					$countNumSearch = mysqli_num_rows($getQueryRes);
					$countNumA = $countNumSearch;
					$pageTo = ($showTo*1)/10;
					$pageAll = ceil($countNumA/10);
					if ($countNumSearch > 0){
						$showToMess = $showTo;
						if ($showTo > $countNumSearch){
							$showToMess = $countNumSearch;
						}
				?>
				<div class="flexAlign">
					<div class="resulthead pt25"><span class="green"><?php echo $countNumSearch;?></span> Result<?php if($countNumSearch != 1){?>s<?php }?></div>
					<div class="resulOptDD pt20">
						<div class="flexUneven" style="height:40px;">
							<div class="ddCircle dropdown">
								<input type="Hidden" id="search_DDMob" name="search_DDMob" value="" />
								<div class="flexrel" type="button" onclick="shdd('sortDDmob');" style="margin-bottom:8px">
									<div class="countryPlace f15B">Sort by:</div>
									<div class="countryTxt f15B" id="country_dd_disp_mob">A-Z</div>
									<div class="arrowpos">
										<i class="arrow down"></i>
									</div>
								</div>
								<div id="sortDDmob" class="scrolldd" aria-labelledby="dropdownMenuButton">
									<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selDDSearchMob('A-Z','<?php echo $searchHome;?>');">
										<div class="countryTxtDrop f15B">A-Z</div>
									</div>
									<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selDDSearchMob('Z-A','<?php echo $searchHome;?>');">
										<div class="countryTxtDrop f15B">Z-A</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
						$getRes = mysqli_fetch_array($getQueryRes);
						$i=0;
						while($i < $countNumSearch){
						
							if ($i >= $showFrom && $i < $showTo){
						
								$courseName = $getRes['name'];
								$subregionslug = $getRes['subregionslug'];

								if(strlen($courseName) > 20){
									$courseName = substr($courseName, 0, 20) . '...';
								}
								
								if($subregionslug == ''){
									$subregionslug = 'golf';
								}
								
								$coursePageUrl = $getRes['countryslug'].'/'.$getRes['regionslug'].'/'.$subregionslug.'/'.filename_safe($getRes['name']).'/detailed/'.$getRes['id'];
								
								$featicon = $getRes['icon'] . '.svg';
				?>
				<div class="topcourseSearch mt10">
					<div class="flex100">
						<div class="srUri flex" onclick="javascript:location.href='<?php echo $coursePageUrl;?>';">
							<div class="coursePin"><img src="<?php echo $dirAdj;?>img/icons/google.svg" class="googlepin" /></div>
							<div class="searchCourseName" title="<?php echo $getRes['name'];?>">
								<?php echo $courseName;?>
							</div>
							<div class="courseTempSearch flexCent"><?php echo $getRes['tempNow'];?>&deg;</div>
							<div class="tempIcoSearch flexCent"><img src="img/icons/<?php echo $featicon;?>" class="" /></div>
						</div>
						<div class="srIco"><div class="starIco"><a href="javascript:;" onclick="setFavMob(<?php echo $getRes['id'];?>);"><img id="favstarMob_<?php echo $getRes['id'];?>" src="<?php echo $dirAdj;?>img/icons/desktop_star_<?php if(isset($_COOKIE['lastCourse']) && $_COOKIE['lastCourse'] == $getRes['id']) {?>full<?php }else{?>empty<?php }?>.svg" class="star" /></a></div></div>
					</div>
					<div style="clear:both"></div>
				</div>
				<?php
							}
							$i++;
							$getRes = mysqli_fetch_array($getQueryRes);
						}
				?>
				<div class="flexAlign">
					<div class="course-paggination">
						<!--
						<?php if ($showFrom > 0){?>
			                                 <div class="category-paggination-prev category-paggination-disable"><a href="&showTo=<?php echo ($showTo - 10);?>&showFrom=<?php echo ($showFrom - 10);?>"> <dfn>Previous</dfn></a></div>
						<?php }else{?>
			                                 <div class="category-paggination-prev category-paggination-disable"> <img src="<?php echo $dirAdj;?>svgs/category-sublevel/arrow-left-blue.svg" alt=""><dfn>Previous</dfn></div>
						<?php }?>
						-->
						<ul class="category-paggination-count">
						<?php
							$aVal = ceil(($showFrom+1)/10)/10;
							$startDig = 1;//stay 1
							$toDig = (floor($aVal)*10)+9;
							if ($toDig > 10){
								$startDig = $toDig - 9;
							}
							$curPage = ceil($showToMess/10);
							$lastPage = ceil($countNumSearch/10);
							if ($toDig > $lastPage){
								$toDig = $lastPage;
							}
							
							if ($startDig > 9){
						?>
							<li><a href="javascript:;" onclick="sPNMob('<?php echo ((10*$startDig) - 10);?>','<?php echo ((10*$startDig) - 10 - 10);?>','<?php echo $searchHome;?>');"> ...&nbsp;</a></li>
						<?php
							}
							for($cp=$startDig;$cp<=$toDig;$cp++){
								if ($curPage == $cp){
									if($cp == $lastPage){
						?>
							 <li class="li-active"><a onclick="sPNMob('<?php echo $showTo;?>','<?php echo $showFrom;?>','<?php echo $searchHome;?>');" class="paggination-active">&nbsp;<?php echo $cp;?></a></li>
						<?php
									}else{
						?>
							 <li class="li-active"><a onclick="sPNMob('<?php echo $showTo;?>','<?php echo $showFrom;?>','<?php echo $searchHome;?>');" class="paggination-active"><?php echo $cp;?></a></li>
						<?php
									}
								}else{
									if($cp == $lastPage){
						?>
							 <li><a onclick="sPNMob('<?php echo (10*$cp);?>','<?php echo ((10*$cp) - 10);?>','<?php echo $searchHome;?>');"><?php echo $cp;?></a></li>
						<?php
									}else{
						?>
							 <li><a onclick="sPNMob('<?php echo (10*$cp);?>','<?php echo ((10*$cp) - 10);?>','<?php echo $searchHome;?>');"><?php echo $cp;?></a></li>
						<?php
									}
								}
							}
							if ($cp < $lastPage){
						?>
							<li><a onclick="sPNMob('<?php echo (10*$cp);?>','<?php echo ((10*$cp) - 10);?>','<?php echo $searchHome;?>');"> ...&nbsp;</a></li>
						<?php
							}
						?>
						</ul>
						<!--
						<?php if ($countNumA > $showTo){?>
			                                 <div class="category-paggination-next"><a href="&showTo=<?php echo ($showTo + 10);?>&showFrom=<?php echo ($showTo);?>"><img src="<?php echo $dirAdj;?>svgs/category-sublevel/arrowright-blue.svg" alt=""> <dfn>Next</dfn></a></div> 
						<?php }else{?>
			                                 <div class="category-paggination-next category-paggination-disable"><img src="<?php echo $dirAdj;?>svgs/category-sublevel/arrowright-blue.svg" alt=""> <dfn>Next</dfn></div> 
						<?php }?>
						-->
					</div>
				</div>
				<?php		
					}
					mysqli_free_result($getQueryRes);
					
					}
				?>
			</div>
		</div>

		<div class="mob-fc-option">
			<div id="curforcast" class="mob-fc-option1 mob-fc-option-sel" onclick="javascript:loadMapSearch('Man');">Manual Search</div>
			<div id="featcourse" class="mob-fc-option2" onclick="javascript:loadMapSearch('Map');">Map Search</div>
		</div>
		<div class="mob-mansearch">
			<div class="flex bgDetTop mt20">
				<input type="Hidden" id="search_continent_idMob" name="search_continent_idMob" value="AF" />
				<div class="botforecast">
					<div id="contAFMob" class="country6 <?php if(!isset($_GET['search_home'])){?> countrySel<?php }?>" onclick="selContinentMob('AF');">
						<div class="countryInner">
							Africa
						</div>
					</div>
					<div id="contASMob" class="country6" onclick="selContinentMob('AS');">
						<div class="countryInner">
							Asia
						</div>
					</div>
					<div id="contEUMob" class="country6" onclick="selContinentMob('EU');">
						<div class="countryInner">
							Europe
						</div>
					</div>
					<div id="contNAMob" class="country6" onclick="selContinentMob('NA');">
						<div class="countryInnerOther">
							North America
						</div>
					</div>
					<div id="contOCMob" class="country6" onclick="selContinentMob('OC');">
						<div class="countryInner">
							Oceania
						</div>
					</div>
					<div id="contSAMob" class="country6" onclick="selContinentMob('SA');">
						<div class="countryInnerLast" style="margin-top:-3px">
							South America
						</div>
					</div>
				</div>
			</div>
			<div class="mt20" style="height:40px">
				<div id="countryDDMob" class="countryCircle dropdown">
					<div class="flexrel" type="button" onclick="shdd('countryDDMainMob');" style="margin-bottom:8px">
						<?php if(!isset($_GET['search_home'])){?>
						<input type="Hidden" id="search_country_idMob" name="search_country_idMob" value="ZA" />
						<div class="countryPlace f15B">Country:</div>
						<div class="countryFlag" id="country_flag_dispMob"><img src="http://www.golfweather.com/img/countries/ZA-24.png" style="width:17px" class="fw" /></div>
						<div class="countryTxt f15B" id="country_name_dispMob">South Africa</div>
						<?php }else{?>
						<input type="Hidden" id="search_country_idMob" name="search_country_idMob" value="" />
						<div class="countryPlace f15B">Country:</div>
						<div class="countryFlag" id="country_flag_dispMob"></div>
						<div class="countryTxt f15B" id="country_name_dispMob">Any</div>
						<?php }?>
						<div class="arrowpos">
							<i class="arrow down"></i>
						</div>
					</div>

					<?php if(!isset($_GET['search_home111'])){?>
					<div id="countryDDMainMob" class="scrollddMob" aria-labelledby="dropdownMenuButton">
						<?php
							$getQueryCountryDD = "
								select 
									co.id, co.name, latitude, longitude
								from 
									countries co
									join geonames ge on ge.id = co.geoname_id
								where 
									co.active=1
									and co.continent = 'AF'
								order by 
									co.name
							";
							//echo '<pre>' . $getQueryCountryDD . '</pre>';
							//die();
							$getQueryResCountryDD = mysqli_query($db,$getQueryCountryDD);
							$countNumCountryDD = mysqli_num_rows($getQueryResCountryDD);
							if ($countNumCountryDD > 0){
								$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
								$iDet=0;
								while($iDet < $countNumCountryDD){
						?>
						<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selCountrySearchMob('<?php echo $getResCountryDD['id'];?>','<?php echo $getResCountryDD['name'];?>','<?php echo $getResCountryDD['latitude'];?>','<?php echo $getResCountryDD['longitude'];?>');">
							<div class="countryFlagDrop"><img src="http://www.golfweather.com/img/countries/<?php echo $getResCountryDD['id'];?>-24.png" style="width:17px" class="fw" /></div>
							<div class="countryTxtDrop f15B"><?php echo $getResCountryDD['name'];?></div>
						</div>
						<?php
									$iDet++;
									$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
								}
							}
							mysqli_free_result($getQueryResCountryDD);
						?>
						<br />
					</div>
					<?php }?>
				</div>

				<div id="areaDDMob" class="countryCircle dropdown">
					<div class="flexrel" type="button" onclick="shdd('areaDDMainMob');" style="margin-bottom:8px">
						<input type="Hidden" id="search_areaMob" name="search_areaMob" value="" />
						<div class="countryPlace f15B">Province/area:</div>
						<div class="countryTxt f15B" id="country_area_dispMob">Any</div>
						<div class="arrowpos">
							<i class="arrow down"></i>
						</div>
					</div>
					<?php if(!isset($_GET['search_home111'])){?>
					<div id="areaDDMainMob" class="scrollddMob" aria-labelledby="dropdownMenuButton">
						<?php
							$getQueryCountryDD = "
								select 
									id, name
								from 
									geo_regions
								where 
									country_id='ZA'
								order by 
									name
							";
							//echo '<pre>' . $getQueryCountryDD . '</pre>';
							//die();
							$getQueryResCountryDD = mysqli_query($db,$getQueryCountryDD);
							$countNumCountryDD = mysqli_num_rows($getQueryResCountryDD);
							if ($countNumCountryDD > 0){
								$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
								$iDet=0;
								while($iDet < $countNumCountryDD){
						?>
						<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selAreaSearchMob('<?php echo $getResCountryDD['id'];?>','<?php echo $getResCountryDD['name'];?>','ZA');">
							<div class="countryTxtDrop f15B"><?php echo $getResCountryDD['name'];?></div>
						</div>
						<?php
									$iDet++;
									$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
								}
							}
							mysqli_free_result($getQueryResCountryDD);
						?>
					</div>
					<?php }?>
					</div>
				</div>

				<div class="countryCircle dropdown">
					<input type="Hidden" id="search_cityMob" name="search_cityMob" value="" />
					<div class="flexrel" type="button" onclick="shdd('cityDDMob');" style="margin-bottom:8px">
						<div class="countryPlace f15B">City:</div>
						<div class="countryTxt f15B" id="country_city_dispMob">Any</div>
						<div class="arrowpos">
							<i class="arrow down"></i>
						</div>
					</div>
					<div id="cityDDMob" class="scrollddMob" aria-labelledby="dropdownMenuButton">
						<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel">
							<div class="countryTxtDrop f15B">Any</div>
						</div>
					</div>
				</div>
				
				
				<div class="">
					<button type="button" class="greenBtnPopReg" onclick="mainSearchMob();">Search courses</button>
				</div>

				<div class="pt10 pb20">
					<button type="button" class="greyBtnWide" onclick="location.href='missing-course';">Missing course? Let us know</button>
				</div>
			</div>

			<div class="mob-mapsearch pt20 pb20">
				<div id="mapMob" style="width:100%;height: 490px;"></div>
			</div>

			<div class="mob-banner1 pt10">
				<a href=""><img src="<?php echo $dirAdj;?>img/banners/hero-8.jpg" class="banner_full" /></a>
			</div>
	
			<div class="mob-banner1 pt20">
				<img src="<?php echo $dirAdj;?>img/banners/ship-sticks.png" class="fw" />
			</div>
	
			<div class="botSpace" style="height:30px">&nbsp;</div>
		</div>
		<div class="botSpace" style="height:30px">&nbsp;</div>
	</div>
</div>

<div class="botSpace"></div>

<?php if(strlen(strpos($_SERVER['HTTP_HOST'], "localhost1")) > 0){?>
<?php }else{?>
<?php }?>
<?php
	require_once("includes/footer.php");
?>            

