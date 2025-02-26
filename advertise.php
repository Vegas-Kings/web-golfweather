<?php
	require_once("includes/header.php");
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="flex ">
			<div class="flexible-width">
				<div class="fcName">Advertise</div>
				<div class="infoDim mt20 f15N pb20">
					<?php echo $page_content;?>
				</div>

			  	<div style="float:left;width:548px;margin-left:0px;margin-top:0px">
					<div class="flex pt20 f16N">
						<div class="input-icon-container mr10">
							Name
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
					      	Comments
					    </div>
					</div>
					<div class="flex f16N">
						<div class="input-icon-containerFull" style="text-align:center">
					      	<textarea class="inpNorm" style="width:100%;border:0px;height:90px !important"></textarea>
					    </div>
					</div>
					<div class="flex pt20">
					     <button class="greenBtnPopReg" onclick="javascript:location.href='';">Contact Us</button>
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
		<div class="f20B pt15">Advertise</div>
		<div class="mobiTxt pt15"><?php echo $page_content;?></div>
	  	<div style="width:100%;margin-left:0px;margin-top:0px">
			<div class="flex pt20 f16N">
				<div class="input-icon-container mr10">
					Name
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
			      	Comments
			    </div>
			</div>
			<div class="flex f16N">
				<div class="input-icon-containerFull" style="text-align:center">
			      	<textarea class="inpNorm" style="width:100%;border:0px;height:90px !important"></textarea>
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

