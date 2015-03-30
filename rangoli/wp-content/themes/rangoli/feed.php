<?php
/*
Template Name: feed
*/
get_header();
?>

	<div class="feed-filter">
		<?php $colors = $wpdb->get_results("select distinct(color_primary) from rangoli_profile_colors limit 0,7");
		if($colors && count($colors)>0) {
			foreach($colors as $color){
				$pos = strstr($color->color_primary, "#");
				if ($pos !== false) {
					$color = substr($color->color_primary, 1);
					$color=strtolower($color);
				}else{
					$color = $color->color_primary;
					$color=strtolower($color);
				};
				echo '<a class="filter-color ajax-load" href="'.get_site_url().'/feeds/?color='.trim($color).'"><span  style="background-color:#'.trim($color).'">&nbsp;</span></a>';
			}
		}; ?>
	</div>
<?php

$url=get_site_url()."/get_feeds.php?color=".$_REQUEST["color"];
$json=file_get_contents($url);
$feeds = json_decode($json, true);
if(count($feeds) > 0){ ?>

<div id="feeds-page">
	<div class="feed-wrapper">
		<?php foreach($feeds as $feed){ ?>
			<div class="feed-box" style="background-color: #<?php echo $feed['shade'] ?>;">
				<span class="ovrlay" style="background-color: #<?php echo $feed['color'] ?>"></span>
				<div class="feed-content">
					<div class="abt-user">
						<div class="img-level">
							<div class="profile-image">
								<?php
									if($feed['profileImage']==""){
										$feed['profileImage']=get_site_url()."/wp-content/themes/rangoli/images/default.jpg";
									}
								?>
								<img src="<?php echo $feed['profileImage']; ?>" />
							</div>
							<span class="charm color_<?php echo $feed['color']; ?> level_<?php echo $feed['level']; ?>"></span>
						</div>
						<div class="uname"><?php echo $feed['name']; ?></div>
						<p class="uplace"><?php echo $feed['place']; ?></p>
						<p class="uinterests"><?php echo $feed['interests']; ?></p>
						<p class="ubucks"><?php echo $feed['smogiBucks']; ?> SMOGI Bucks</p>
					</div>
					<span class="sep"></span>
					<div class="act-user">
						<p class="udata"><?php echo $feed['date']; ?></p>
						<?php if($feed['type'] == "post"){ ?>
							<p class="uact"><a class="ajax-load" href="<?php echo $feed['url']; ?>"><?php echo $feed['name']; ?></a> <span>posted a new article </span> <a class="ajax-load" href="<?php echo $feed['postUrl']; ?>"><?php echo $feed['postTitle']; ?></a></p>
						<?php }else{ ?>
							<p class="uact"><a class="ajax-load" href="<?php echo $feed['url']; ?>"><?php echo $feed['name']; ?></a> <span>commented on article posted By </span> <a class="ajax-load" href="<?php echo $feed['postAutherUrl']; ?>"><?php echo $feed['postAuther']; ?></a></p>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>

</div>
<?php }
else{
	echo "<div class='span12 align-center'><h1>No Feeds found for this color</h1></div>";
}
get_footer();