<?php
	session_start();
	require_once("includes/dbconni.php");
	
	$extraVar = '';
	if(isset($_GET['mob'])){
		$extraVar = 'Mob';
	}
	
	$cID = $_POST['cID'];
	$startSQL = '';

	if($cID == 'AF'){
		$startSQL = "and id = 'ZA'";
	}
	
	if($cID == 'AS'){
		$startSQL = "and id = 'SG'";
	}

	if($cID == 'EU'){
		$startSQL = "and id = 'GB'";
	}

	if($cID == 'NA'){
		$startSQL = "and id = 'US'";
	}

	if($cID == 'OC'){
		$startSQL = "and id = 'AU'";
	}

	$getQueryCountryDD = "
		select 
			id, name
		from 
			countries
		where 
			active=1
			and continent = '".$cID."'
			".$startSQL."
		order by 
			name
		limit 1	
	";
	//echo '' . $getQueryCountryDD . '';
	//die();
	$getQueryResCountryDD = mysqli_query($db,$getQueryCountryDD);
	$countNumCountryDD = mysqli_num_rows($getQueryResCountryDD);
	if ($countNumCountryDD > 0){
		$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
		$startCCId = $getResCountryDD['id'];
		$startCCName = $getResCountryDD['name'];
	}	
	mysqli_free_result($getQueryResCountryDD);
?>
						<div class="flexrel" type="button" onclick="shdd('countryDDMain');" style="margin-bottom:8px">
							<input type="Hidden" id="search_country_id<?php echo $extraVar;?>" name="search_country_id" value="<?php echo $startCCId;?>" />
							<div class="countryPlace f15B">Country:</div>
							<div class="countryFlag" id="country_flag_disp"><img src="http://www.golfweather.com/img/countries/<?php echo $startCCId;?>-24.png" style="width:17px" class="fw" /></div>
							<div class="countryTxt f15B" id="country_name_disp"><?php echo $startCCName;?></div>
							<div class="arrowpos">
								<i class="arrow down"></i>
							</div>
						</div>
						<div id="countryDDMain" style="padding-bottom:20px" class="scrolldd" aria-labelledby="dropdownMenuButton">
							<?php
								$getQueryCountryDD = "
									select 
										co.id, co.name, latitude, longitude
									from 
										countries co
										join geonames ge on ge.id = co.geoname_id
									where 
										co.active=1
										and co.continent = '".$cID."'
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
							<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selCountrySearch<?php echo $extraVar;?>('<?php echo $getResCountryDD['id'];?>','<?php echo $getResCountryDD['name'];?>','<?php echo $getResCountryDD['latitude'];?>','<?php echo $getResCountryDD['longitude'];?>');">
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
						</div>