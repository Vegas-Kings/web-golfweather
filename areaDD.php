<?php
	session_start();
	require_once("includes/dbconni.php");
	
	$extraVar = '';
	if(isset($_GET['mob'])){
		$extraVar = 'Mob';
	}
	$cID = $_POST['cID'];
?>
							<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selAreaSearch<?php echo $extraVar;?>('','Any','<?php echo $cID;?>');">
								<div class="countryTxtDrop f15B">Any</div>
							</div>
<?php
								$getQueryCountryDD = "
									select 
										gr.id, gr.name
									from 
										geo_regions gr
										JOIN courses c ON c.region_id = gr.id
									where 
										gr.country_id='".$cID."'
									GROUP BY gr.id	
									order by 
										gr.name
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
							<div style="width:93%;border-top:1px solid #4B5660;margin:0px 5px 0px 5px;padding:6px 0 5px 0" class="flexrel" onclick="javascript:selAreaSearch<?php echo $extraVar;?>('<?php echo $getResCountryDD['id'];?>','<?php echo $getResCountryDD['name'];?>','<?php echo $cID;?>');">
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
