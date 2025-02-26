<?php
	require_once("includes/header.php");
	
	if(isset($_GET['newsId'])){
		$getQueryNews = "select id, heading, status, newsText, commentDate, headlineImg from tbl_news where heading is not null and status=1 and id=".$_GET['newsId']."";
		$getQueryResNews = mysqli_query($db,$getQueryNews);
		$countNumNews = mysqli_num_rows($getQueryResNews);
		if ($countNumNews > 0){
			$getResNews = mysqli_fetch_array($getQueryResNews);
			$iSum=0;
			$BodyCopy = decodeText(trim($getResNews['newsText']), "");

			if(!isset($news5HomeM[$iSum]['newsId'])){ $news5HomeM[$iSum]['newsId'] = $getResNews['id']; }
			if(!isset($news5HomeM[$iSum]['heading'])){ $news5HomeM[$iSum]['heading'] = $getResNews['heading']; }
			if(!isset($news5HomeM[$iSum]['newsIntro'])){ $news5HomeM[$iSum]['newsIntro'] = $BodyCopy; }
			if(!isset($news5HomeM[$iSum]['commentDate'])){ $news5HomeM[$iSum]['commentDate'] = $getResNews['commentDate']; }
			if(!isset($news5HomeM[$iSum]['headlineImg'])){ $news5HomeM[$iSum]['headlineImg'] = $getResNews['headlineImg']; }
			
		}
		mysqli_free_result($getQueryResNews);

		$getQueryNews = "select id, heading, status, newsText, commentDate, headlineImg from tbl_news where heading is not null and status=1  and id != ".$_GET['newsId']." order by commentDate desc, heading limit 6";
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
	}
?>            
<main class="container deskcontainer">
	<div class="flexible-width2">
		<div class="flex ">
			<div class="flexible-width">
				<div class="fcName"><?php echo $news5HomeM[0]['heading'];?></div>
				<div class="pt10"><img style="width:100%" src="system-files/<?php echo $news5HomeM[0]['headlineImg'];?>"></div>
				<div class="pt10 footTxt"><?php echo $news5HomeM[0]['newsIntro']?></div>
			</div>
		</div>
		<div class="normhead pt20 featbot"><span class="green">Recent</span> News</div>
		
		<div class="flex pt15">
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
		<div class="flex ">
			<div class="flexible-width">
				<div class="fcName"><?php echo $news5HomeM[0]['heading'];?></div>
				<div class="pt10"><img style="width:100%" src="system-files/<?php echo $news5HomeM[0]['headlineImg'];?>"></div>
				<div class="pt10 footTxt" style="text-align:left"><?php echo $news5HomeM[0]['newsIntro']?></div>
			</div>
		</div>
		<div class="normhead pt20 featbot"><span class="green">Recent</span> News</div>

		<div class="flex pt15">
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
					<strong><?php echo substr($news5Home[3]['heading'], 0, 40);?></strong><br />
					<div class="newsIntro"><?php echo $news5Home[3]['newsIntro']?></div>
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

