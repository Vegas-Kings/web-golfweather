<?php
	require_once("includes/header.php");
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="flex ">
			<div class="flexible-width">
				<div class="fcName">Golfweather FAQ</div>
				<div class="infoDim mt20 f15N pb20">
					<?php echo $page_content;?>
				</div>

				<?php
					$getQueryFAQ = 'select faq_question, faq_answer from gw_content_faq where contentID=4 order by sortOrder';
					$getQueryResFAQ = mysqli_query($db,$getQueryFAQ);
					$countNumFAQ = mysqli_num_rows($getQueryResFAQ);
					if ($countNumFAQ > 0){
						$getResFAQ = mysqli_fetch_array($getQueryResFAQ);
						$iFAQ=0;
						while($iFAQ < $countNumFAQ){
				?>
				<div class="botforecast mt20Sum" onclick="showFAQ('FAQ_<?php echo $iFAQ;?>');">
					<div class="flex widecontainer">
						<div class="circleTxt"><?php echo $getResFAQ['faq_question'];?></div>
						<div class="circleMin mt12">
							<div id="FAQ_<?php echo $iFAQ;?>_b" class="circleMaxTxt">+</div>
						</div>
					</div>
				</div>

				<div id="FAQ_<?php echo $iFAQ;?>" class="faqInfo infoDim mt30 f15N pb20">
					<?php echo $getResFAQ['faq_answer'];?>
				</div>
				<?php
							$iFAQ++;
							$getResFAQ = mysqli_fetch_array($getQueryResFAQ);
						}
					}
					mysqli_free_result($getQueryResFAQ);
				?>


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
	<div class="mobiinner mBG">
		<div class="mob-banner1">
			<img src="<?php echo $dirAdj;?>img/banners/tag-heuer-mobi.jpg" class="fw" /><div id="txtmob" class="clockmob"></div>
		</div>
		<div class="f20B pt15">Golfweather FAQ</div>
		<div class="mobiTxt pt15"><?php echo $page_content;?></div>
		<div>
				<?php
					$getQueryFAQ = 'select faq_question, faq_answer from gw_content_faq where contentID=4 order by sortOrder';
					$getQueryResFAQ = mysqli_query($db,$getQueryFAQ);
					$countNumFAQ = mysqli_num_rows($getQueryResFAQ);
					if ($countNumFAQ > 0){
						$getResFAQ = mysqli_fetch_array($getQueryResFAQ);
						$iFAQ=0;
						while($iFAQ < $countNumFAQ){
				?>
				<div class="botforecast mt20Sum" onclick="showFAQ('FAQM_<?php echo $iFAQ;?>');">
					<div class="flex w100">
						<div class="circleTxt"><?php echo $getResFAQ['faq_question'];?></div>
						<div class="circleMin mt12">
							<div id="FAQM_<?php echo $iFAQ;?>_b" class="circleMaxTxt">+</div>
						</div>
					</div>
				</div>

				<div id="FAQM_<?php echo $iFAQ;?>" class="faqInfo infoDim mt30 f15B pb20">
					<?php echo $getResFAQ['faq_answer'];?>
				</div>
				<?php
							$iFAQ++;
							$getResFAQ = mysqli_fetch_array($getQueryResFAQ);
						}
					}
					mysqli_free_result($getQueryResFAQ);
				?>
		</div>
		<div class="mob-banner1 mt40">
			<a href=""><img src="<?php echo $dirAdj;?>img/banners/hero-8.jpg" class="banner_full" /></a>
		</div>
		<div class="mob-banner1 mt20 mb40">
			<img src="<?php echo $dirAdj;?>img/banners/ship-sticks.png" class="fw" />
		</div>
	</div>
</div>

<div class="botSpace"></div>
<?php
	require_once("includes/footer.php");
?>            
