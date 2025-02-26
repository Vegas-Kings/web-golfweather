<?php
	session_start();
	require_once("includes/dbconni.php");
	$dirAdj = '';
	
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

	$orderBy = 'order by c.name';

	$searchTXT = $_POST['searchTXT'];
	
	if(isset($_POST['search_DD'])){
		$search_DD = $_POST['search_DD'];
	}else{
		$search_DD = 'A-Z';
	}
	
	if($search_DD == 'Z-A'){
		$orderBy = 'order by c.name desc';
	}
	
	
	$timeNow = mktime((date('H')), date('i'), date('s'), date('m'), date('d'), date('Y'));
	$todDate = date('Y-m-d', $timeNow);
	
	if(isset($searchTXT)){
		$searchHome = utf8_encode($searchTXT);
		$searchHome = mysqli_real_escape_string($db, $searchHome);
		
		$cID = $_POST['cID'];
		$search_country_id = $_POST['search_country_id'];
		$search_city = $_POST['search_city'];
		$search_area = $_POST['search_area'];
		
		$searchSql = " and
			(
				lower(c.name) like '%".strtolower($searchHome)."%'
				or lower(c.address1) like '%".strtolower($searchHome)."%'
			)
		";
		
		if($search_country_id != ''){
			$searchSql .= " and c.country_id = '".$search_country_id."'";
		}
		
		if($cID != ''){
			$searchSql .= " and continent = '".$cID."'";
		}
		
		if($search_area != ''){
			$searchSql .= " and gr.id = ".$search_area."";
		}

		if($search_city != ''){
			$searchSql .= " and c.city = '".$search_city."'";
		}

		$tempCol = $_POST['tempCol'];
		$todDate = $_POST['todDate'];
		
	}
	
	if(isset($searchTXT)){

		if(isset($_GET['showFrom']) && $_GET['showFrom'] > 0){
			$showFrom = $_GET['showFrom'];
		}else{
			$showFrom = 0;

		}
		if(isset($_GET['showTo']) && $_GET['showTo'] > 0){
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
				".$searchSql."
			group by c.id
			".$orderBy."
			
			
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
					<input type="Hidden" id="search_DD" name="search_DD" value="<?php echo $search_DD;?>" />
					<div class="flexrel" type="button" onclick="shdd('sortDD');" style="margin-bottom:8px">
						<div class="countryPlace f15B">Sort by:</div>
						<div class="countryTxt f15B" id="country_city_disp"><?php echo $search_DD;?></div>
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
			if($countNumSearch > 10){
	?>
	<div class="flexAlign">
		<div class="missCourse"><button type="button" class="greyBtnMed" onclick="location.href='contact-us.php?subj=missing-course';">Missing course? Let us know</button></div>
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
	</div>
	<?php
			}
		}else{
			echo 'No results found...';
		}
		mysqli_free_result($getQueryRes);
	
	}
