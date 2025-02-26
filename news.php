<?php
	require_once("includes/header.php");
	
		$getQueryNews = "select id, heading, status, newsText, commentDate, headlineImg from tbl_news where heading is not null and status=1  order by commentDate desc, heading limit 6";
		$getQueryResNews = mysqli_query($db,$getQueryNews);
		$countNumNews = mysqli_num_rows($getQueryResNews);
		if ($countNumNews > 0){
			$getResNews = mysqli_fetch_array($getQueryResNews);
			$iSum=0;
			while($iSum < $countNumNews){
			
				$BodyCopy = html2text(decodeText(trim($getResNews['newsText']), ""));
				$BodyCopy = str_replace("<p>", "", substr($BodyCopy, 0, 46)) . "...";

				if(!isset($news5Home[$iSum]['newsId'])){ $news5Home[$iSum]['newsId'] = $getResNews['id']; }
				if(!isset($news5Home[$iSum]['heading'])){ $news5Home[$iSum]['heading'] = $getResNews['heading']; }
				if(!isset($news5Home[$iSum]['newsIntro'])){ $news5Home[$iSum]['newsIntro'] = $BodyCopy; }
				if(!isset($news5Home[$iSum]['commentDate'])){ $news5Home[$iSum]['commentDate'] = $getResNews['commentDate']; }
				if(!isset($news5Home[$iSum]['headlineImg'])){ $news5Home[$iSum]['headlineImg'] = $getResNews['headlineImg']; }
			
				$iSum++;
				$getResNews = mysqli_fetch_array($getQueryResNews);
			}
		}
		mysqli_free_result($getQueryResNews);
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="fcName">Golf News</div>
		<div class="normhead pt20 featbot"><span class="green">Featured</span> News</div>
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
			<div class="botnewsA2Alt">
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
		</div>
		<div class="normhead pt20 featbot"><span class="green">Recent</span> News</div>
		
		<div class="flex pt20">
			<?php if(isset($news5Home[0]['commentDate'])){?>
			<div class="newsBgHome" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[0]['newsId'];?>';">
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
			<div class="newsBgHome" style="margin-left:20px" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[1]['newsId'];?>';">
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

		</div>
		<div class="flex">
			<?php if(isset($news5Home[2]['commentDate'])){?>
			<div class="newsBgHome" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[2]['newsId'];?>';">
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
			<?php if(isset($news5Home[3]['commentDate'])){?>
			<div class="newsBgHome" style="margin-left:20px" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[3]['newsId'];?>';">
				<div class="newsBgPic">
					<div class="bg-news" style="height:100%">
	    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[3]['headlineImg']?>')"></div>
	  				</div>
				</div>
				<div class="newsBgIntro">
					<strong><?php echo substr($news5Home[3]['heading'], 0, 40);?></strong><br />
					<div class="newsIntro"><?php echo $news5Home[3]['newsIntro']?></div>
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[3]['commentDate']))?></span>
				</div>
			</div>
			<?php }?>

		</div>
		<div style="clear:both"></div>
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
		<div class="normhead pt20 featbot"><span class="green">Featured</span> News</div>
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
		</div>
		<div class="botnewsA pt20">
			<?php if(isset($news5Home[1]['commentDate'])){?>
			<div class="botnewsA2Alt">
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
		</div>
		
		<div class="normhead pt20 featbot"><span class="green">Recent</span> Golf News</div>

		<div class="flex pt20">
			<?php if(isset($news5Home[0]['commentDate'])){?>
			<div class="newsBgHome" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[0]['newsId'];?>';">
				<div class="newsBgPic">
					<div class="bg-news" style="height:100%">
	    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[0]['headlineImg']?>')"></div>
	  				</div>
				</div>
				<div class="newsBgIntro">
					<strong><?php echo substr($news5Home[0]['heading'], 0, 40);?></strong><br /><br />
					<span class="newsIntro"><?php echo trim($news5Home[0]['newsIntro'])?></span><br /><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[0]['commentDate']))?></span>
				</div>
			</div>
			<?php }?>
		</div>
		<div class="flex">
			<?php if(isset($news5Home[1]['commentDate'])){?>
			<div class="newsBgHome" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[1]['newsId'];?>';">
				<div class="newsBgPic">
					<div class="bg-news" style="height:100%">
	    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[1]['headlineImg']?>')"></div>
	  				</div>
				</div>
				<div class="newsBgIntro">
					<strong><?php echo substr($news5Home[1]['heading'], 0, 40);?></strong><br /><br />
					<span class="newsIntro"><?php echo trim($news5Home[1]['newsIntro'])?></span><br /><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[1]['commentDate']))?></span>
				</div>
			</div>
			<?php }?>
		</div>
		<div class="flex">
			<?php if(isset($news5Home[2]['commentDate'])){?>
			<div class="newsBgHome" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[2]['newsId'];?>';">
				<div class="newsBgPic">
					<div class="bg-news" style="height:100%">
	    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[2]['headlineImg']?>')"></div>
	  				</div>
				</div>
				<div class="newsBgIntro">
					<strong><?php echo substr($news5Home[2]['heading'], 0, 40);?></strong><br /><br />
					<span class="newsIntro"><?php echo $news5Home[2]['newsIntro']?></span><br /><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[2]['commentDate']))?></span>
				</div>
			</div>
			<?php }?>
		</div>
		<div class="flex">
			<?php if(isset($news5Home[3]['commentDate'])){?>
			<div class="newsBgHome" onclick="javascript:location.href='news-detail.php?newsId=<?php echo $news5Home[3]['newsId'];?>';">
				<div class="newsBgPic">
					<div class="bg-news" style="height:100%">
	    				<div class="bg-news-d" style="background-image:url('system-files/<?php echo $news5Home[3]['headlineImg']?>')"></div>
	  				</div>
				</div>
				<div class="newsBgIntro">
					<strong><?php echo substr($news5Home[3]['heading'], 0, 40);?></strong><br /><br />
					<span class="newsIntro"><?php echo $news5Home[3]['newsIntro']?></span><br /><br />
					<span class="newsDate"><?php echo date('d M Y', strtotime($news5Home[3]['commentDate']))?></span>
				</div>
			</div>
			<?php }?>

		</div>
		<div style="clear:both"></div>
		<div class="mob-banner1 mt20">
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

