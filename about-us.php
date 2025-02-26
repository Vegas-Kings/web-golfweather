<?php
	require_once("includes/header.php");
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="flex ">
			<div class="flexible-width">
				<div class="fcName">About Golfweather</div>
				<img src="img/about-main.png" class="mt30 fw " />
				<div class="infoDim mt20 f15N pb20">
					Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore.
				</div>
				<div class="flex">
					<div style="background:#272A30;height:258px;flex: 1;margin-right:20px;">
						<div class="infoIco"><img src="img/icons/flag.svg" /></div>
						<div class="infoTXTBig">40,000+</div>
						<div class="infoTXTSml">Courses</div>
					</div>
					<div style="background:#272A30;height:258px;flex: 1;margin-right:20px;">
						<div class="infoIco"><img src="img/icons/green-cloudy.svg" /></div>
						<div class="infoTXTBig">24/7</div>
						<div class="infoTXTSml">Detailed Forecast</div>
					</div>
					<div style="background:#272A30;height:258px;flex: 1;">
						<div class="infoIco"><img src="img/icons/hyperlocal.svg" /></div>
						<div class="infoTXTBig">Hyperlocal</div>
						<div class="infoTXTSml">Location Forecasts</div>
					</div>
				</div>
			</div>
		</div>
		<div class="flex featbot mt10">
			<div class="normhead pt20"><span class="green">Backed By The</span> Biggest Brands</div>
		</div>
		<div class="flex pt10">
			<div class="pt20 pe-4"><a href=""><img src="img/go-pro.png" style="width:133px;height:47px" /></a></div>
			<div class="pt20 pe-4"><a href=""><img src="img/cleveland.png" style="width:120px;height:47px" /></a></div>
			<div class="pt12 pe-4"><a href=""><img src="img/tag-heuer.png" style="width:62px;height:62px" /></a></div>
			<div class="pt28 pe-4"><a href=""><img src="img/porsche.png" style="width:153px;height:23px" /></a></div>
			<div class="pt8 pe-4"><a href=""><img src="img/rolex.png" style="width:104px;height:62px" /></a></div>
			<div class="mu5 pe-4"><a href=""><img src="img/callaway.png" style="width:94px;height:94px" /></a></div>
			<div class="pt26"><a href=""><img src="img/titleist.png" style="width:110px;height:32px" /></a></div>
		</div>
		<div class="infoDim mt20 f15N pb20">
			At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.<br /><br />
			Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
		</div>
		<div class="botforecast mt20Sum" onclick="showFAQ('team');">
			<div class="flex widecontainer">
				<div class="circleTxt">The Team Behind GolfWeather</div>
				<div class="circleMin mt12">
					<div id="team_b" class="circleMaxTxt">+</div>
				</div>
			</div>
		</div>
		<div id="team" class="faqInfo infoDim mt20 f15N pb20">
			Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
		</div>
		
		<div class="botforecast mt20Sum" onclick="showFAQ('advertise');">
			<div class="flex widecontainer">
				<div class="circleTxt">Advertising on GolfWeather</div>
				<div class="circleMin mt12">
					<div id="advertise_b" class="circleMinTxt">-</div>
				</div>
			</div>
		</div>
		<div id="advertise" class="infoDim mt20 f15N pb20">
			Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
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
		<div class="f20B pt15">About Golfweather</div>
		<div class="mobiTxt pt15">
			<img src="img/about-main.png" class="mt30 fw " />		
				<div class="infoDim mt20 mobiTxt pb20">
					Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore.
				</div>
				<div class="flex">
					<div style="background:#272A30;height:168px;flex: 1;margin-right:20px;">
						<div class="infoIco"><img src="img/icons/flag.svg" /></div>
						<div class="infoTXTBig">33,000+</div>
						<div class="infoTXTSml">Courses</div>
					</div>
					<div style="background:#272A30;height:168px;flex: 1;margin-right:20px;">
						<div class="infoIco"><img src="img/icons/green-cloudy.svg" /></div>
						<div class="infoTXTBig">24/7</div>
						<div class="infoTXTSml">Detailed Forecast</div>
					</div>
					<div style="background:#272A30;height:168px;flex: 1;">
						<div class="infoIco"><img src="img/icons/hyperlocal.svg" /></div>
						<div class="infoTXTBig">Hyperlocal</div>
						<div class="infoTXTSml">Location Forecasts</div>
					</div>
				</div>
		</div>
		<div class="flex featbot mt10">
			<div class="normhead pt20"><span class="green">Backed By The</span> Biggest Brands</div>
		</div>
		<div class="flex pt10">
			<div class="pt20 pe-4"><a href=""><img src="img/go-pro.png" style="width:133px;height:47px" /></a></div>
			<div class="pt20 pe-4"><a href=""><img src="img/cleveland.png" style="width:120px;height:47px" /></a></div>
			<div class="pt12 pe-4"><a href=""><img src="img/tag-heuer.png" style="width:62px;height:62px" /></a></div>
		</div>
		<div class="flex pt10">
			<div class="pt28 pe-4"><a href=""><img src="img/porsche.png" style="width:153px;height:23px" /></a></div>
			<div class="pt8 pe-4"><a href=""><img src="img/rolex.png" style="width:104px;height:62px" /></a></div>
			<div class="mu5 pe-4"><a href=""><img src="img/callaway.png" style="width:94px;height:94px" /></a></div>
			<div class="pt26"><a href=""><img src="img/titleist.png" style="width:110px;height:32px" /></a></div>
		</div>
		<div class="infoDim mt20 mobiTxt pb20">
			At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.<br /><br />
			Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
		</div>
		<div class="botforecast mt20Sum" onclick="showFAQ('teamMob');">
			<div class="flex w100">
				<div class="circleTxt">The Team Behind GolfWeather</div>
				<div class="circleMin mt12">
					<div id="teamMob_b" class="circleMaxTxt">+</div>
				</div>
			</div>
		</div>
		<div id="teamMob" class="faqInfo infoDim mt20 mobiTxt pb20">
			Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
		</div>
		
		<div class="botforecast mt20Sum" onclick="showFAQ('advertiseMob');">
			<div class="flex w100">
				<div class="circleTxt">Advertising on GolfWeather</div>
				<div class="circleMin mt12">
					<div id="advertiseMob_b" class="circleMinTxt">-</div>
				</div>
			</div>
		</div>
		<div id="advertiseMob" class="infoDim mt20 mobiTxt pb20">
			Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
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

