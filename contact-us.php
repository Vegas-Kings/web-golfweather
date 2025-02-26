<?php
	require_once("includes/header.php");
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="flex ">
			<div class="flexible-width">
				<div class="fcName">Get in touch with us</div>
				<div class="infoDim mt20 f15N pb20">
					<?php echo $page_content;?>
				</div>

				<div class="flex">
					<div style="background:#272A30;height:258px;flex: 1;margin-right:20px;">
						<div class="infoIco"><img src="img/icons/email-green.svg" /></div>
						<div class="infoTXTBigCont">Email</div>
						<div class="infoTXTSml f15B">
							contact@golfweather.com<br />
							support@golfweather.com
						</div>
					</div>
					<div style="background:#272A30;height:258px;flex: 1;margin-right:20px;">
						<div class="infoIco"><img src="img/icons/social-green.svg" /></div>
						<div class="infoTXTBigCont">Social</div>
						<div class="infoTXTSml">
							<div class="f15B" align="center"><img src="img/icons/twitter-sml.svg" />&nbsp;&nbsp;&nbsp;@Golfweather</div>
						</div>
						<div class="infoTXTSml">
							<div class="f15B pt4" align="center"><img src="img/icons/instagram-sml.svg" />&nbsp;&nbsp;&nbsp;@Golfweather</div>
						</div>
						<div class="infoTXTSml">
							<div class="f15B pt4" align="center"><img src="img/icons/facebook-sml.svg" />&nbsp;&nbsp;&nbsp;@Golfweather</div>
						</div>
					</div>
					<div style="background:#272A30;height:258px;flex: 1;">
						<div class="infoIco"><img src="img/icons/pin-green.svg" /></div>
						<div class="infoTXTBigCont">Address</div>
						<div class="infoTXTSml f15B" align="center">Studio 11 (702),<br />Six on Pepper, Pepper Street,<br />Cape Town, South Africa, 8001</div>
					</div>
				</div>

				<div class="normhead pt20 mb20 featbot"><span class="green">Send us</span> an email</div>
				
				<div class="flex" style="background:#272A30">
					<div style="padding:43px 74px 40px 74px">
						<img src="img/icons/Golfweather_Logo.svg" />
						<div class="f18N pt20">Christopher Perry</div>
						<div class="f12N pt12">Lead Editor</div>
						<div class="f18N">chrisper@golfweather.com</div>
						<div class="pt20">
							<a href=""><img src="<?php echo $dirAdj;?>img/icons/facebook.svg" alt="Facebook" class="footIco"></a>
							<a href=""><img src="<?php echo $dirAdj;?>img/icons/twitter.svg" alt="Twitter" class="footIco"></a>
							<a href=""><img src="<?php echo $dirAdj;?>img/icons/youtube.svg" alt="Youtube" class="footIco"></a>
						</div>
					</div>
				  	<div style="width:100%;margin-left:0px;margin-top:20px;margin-right:30px">
						<div class="flex pt20 f16N">
							<div class="input-icon-container mr10">
								Subject
						    </div>
							<div class="input-icon-container mr10">
								Full Name
						    </div>
							<div class="input-icon-container">
						      	Email
						    </div>
						</div>
						<div class="flex f16N">
							<div class="input-icon-container mr10" style="text-align:center;">
						      	<select class="inpNormDrop">
									<option value="Support">Support</option>
									<option value="Advertising">Advertising</option>
									<option <?php if(isset($_GET['subj']) && $_GET['subj'] == 'missing-course'){?>selected <?php }?>value="Missing Course">Missing Course</option>
								</select>
						    </div>
							<div class="input-icon-container mr10" style="text-align:center;">
						      	<input type="text" class="inpNorm" />
						    </div>
							<div class="input-icon-container" style="text-align:center;">
						      	<input type="text" class="inpNorm" />
						    </div>
						</div>
			
						<div class="flex pt10 f16N">
							<div class="input-icon-container mr10">
						      	Message
						    </div>
						</div>
						<div class="flex f16N">
							<div class="input-icon-containerFull" style="text-align:center">
						      	<textarea class="inpNorm" style="width:100%;border:0px;height:140px !important"></textarea>
						    </div>
						</div>
						<div class="flex pt20">
						     <button class="greenBtnPopReg" onclick="javascript:location.href='';">Send Email</button>
						</div>
					</div>
				</div>
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
		<div class="f20B pt15">Get in touch with us</div>
		<div class="mobiTxt pt15"><?php echo $page_content;?></div>
		<div class="">
			<div style="background:#272A30;height:228px;flex: 1;">
				<div class="infoIco pt30"><img src="img/icons/email-green.svg" /></div>
				<div class="infoTXTBigCont pt40">Email</div>
				<div class="infoTXTSml f15B">
					contact@golfweather.com<br />
					support@golfweather.com
				</div>
			</div>
			<div style="background:#272A30;height:228px;flex: 1">
				<div class="infoIco pt30"><img src="img/icons/social-green.svg" /></div>
				<div class="infoTXTBigCont pt40">Social</div>
				<div class="infoTXTSml">
					<div class="f15B pt3" align="center"><img src="img/icons/twitter-sml.svg" />&nbsp;&nbsp;&nbsp;@Golfweather</div>
				</div>
				<div class="infoTXTSml">
					<div class="f15B" align="center"><img src="img/icons/instagram-sml.svg" />&nbsp;&nbsp;&nbsp;@Golfweather</div>
				</div>
				<div class="infoTXTSml">
					<div class="f15B" align="center"><img src="img/icons/facebook-sml.svg" />&nbsp;&nbsp;&nbsp;@Golfweather</div>
				</div>
			</div>
			<div style="background:#272A30;height:228px;flex: 1;">
				<div class="infoIco pt30"><img src="img/icons/pin-green.svg" /></div>
				<div class="infoTXTBigCont pt40">Address</div>
				<div class="infoTXTSml f15B" align="center">Studio 11 (702),<br />Six on Pepper, Pepper Street,<br />Cape Town, South Africa, 8001</div>
			</div>
		</div>

		<div class="normhead pt20 featbot"><span class="green">Send us</span> an email</div>
		  	<div style="width:100%;margin-bottom:30px;margin-top:20px;margin-right:30px">
				<div class="flex pt20 f16N">
					<div class="input-icon-container mr10">
						Subject
				    </div>
				</div>
				<div class="flex f16N">
					<div class="input-icon-container" style="width:100% !important;text-align:center;background:red">
				      	<select class="inpNormDrop" style="width:100% !important">
							<option value="Support">Support</option>
							<option value="Advertising">Advertising</option>
							<option value="Missing Course">Missing Course</option>
						</select>
				    </div>
				</div>
	
				<div class="flex pt20 f16N">
					<div class="input-icon-container mr10">
						Full Name
				    </div>
					<div class="input-icon-container">
				      	Email
				    </div>
				</div>
				<div class="flex f16N">
					<div class="input-icon-container mr10" style="text-align:center;">
				      	<input type="text" class="inpNorm" />
				    </div>
					<div class="input-icon-container" style="text-align:center;">
				      	<input type="text" class="inpNorm" />
				    </div>
				</div>

				<div class="flex pt10 f16N">
					<div class="input-icon-container mr10">
				      	Message
				    </div>
				</div>
				<div class="flex f16N">
					<div class="input-icon-containerFull" style="text-align:center">
				      	<textarea class="inpNorm" style="width:100%;border:0px;height:140px !important"></textarea>
				    </div>
				</div>
				<div class="flex pt20">
				     <button class="greenBtnPopReg" onclick="javascript:location.href='';">Contact Us</button>
				</div>
			</div>
	</div>
</div>

<div class="botSpace"></div>
<?php
	require_once("includes/footer.php");
?>            

