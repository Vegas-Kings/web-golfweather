<?php
	session_start();
	require_once("includes/dbconni.php");
	
	$extraVar = '';
	if(isset($_GET['mob'])){
		$extraVar = 'Mob';
	}
	$countryId = $_POST['countryId'];
	$cID = $_POST['cID'];
?>
							<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selCitySearch<?php echo $extraVar;?>('<?php echo $cID;?>','Any','<?php echo $countryId;?>');">
								<div class="countryTxtDrop f15B">Any</div>
							</div>
<?php
							if($cID != ''){
								$getQueryCountryDD = "
									select 
										distinct TRIM(city) as city
									from 
										courses
									where 
										country_id='".$countryId."'
										and region_id=".$cID."
										and city is not null
										and city != ''
									order by 
										city
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
							<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selCitySearch<?php echo $extraVar;?>('<?php echo $cID;?>','<?php echo $getResCountryDD['city'];?>','<?php echo $countryId;?>');">
								<div class="countryTxtDrop f15B"><?php echo $getResCountryDD['city'];?></div>
							</div>
							<?php
										$iDet++;
										$getResCountryDD = mysqli_fetch_array($getQueryResCountryDD);
									}
								}
								mysqli_free_result($getQueryResCountryDD);
							}
							?>
							<br />
