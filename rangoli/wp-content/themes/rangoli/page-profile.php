<?php get_header();
//$banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );


?>
<div class="wp_page row">

	<div class="main-content row">
		<?php
		$user_id=$_REQUEST["user_id"];
		$user_info=get_userdata($user_id);
		$wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=".$user_id);
		if(count($wpauthors)>0)
		$wp_author=$wpauthors[0];
//		$avatar = get_the_author_meta('author_profile_picture', $user_id);
		$avatar = "";
		?>
	</div>
	<div class="user_banner row">
		<?php
		$user_profile=get_user_profile($user_id);
		$main_color=$user_profile->color_main;
		$level = get_user_level($user_id);
		$main_color=strtoupper($main_color);

		echo " <div class='overlay-text'>
			<div class='align-bottom'>
			<span class='charm color_$main_color $level'></span>
			<p class='post_category'>&nbsp;</p>";

		$title=get_the_title();
		$profile = get_user_profile($user_id);
			$name = $profile->user_display_name;
		if($name==null)
			$name = $user_info->display_name;
		$name = ucwords($name);
		echo "<p class='post_title'>".$name."</p>";

		echo "</div></div>";
		?>
	</div>

	<div class="row container">
		<div class="span3">
			<p class="about_author">ABOUT
				<?php
				if(is_user_logged_in()){
				$current_user_id  = get_current_user_id();
					if($current_user_id == $user_id){
						?>
							<a class="edit" href="https://yogasmoga.com/profile/manage" ><img src="/rangoli/wp-content/themes/rangoli/images/edit_profile.png" /> </a>
						<?php
					}
				}
				?>
				</p>
			<div class="description about">

				<?php
				$profile_url = get_user_meta($user_id,"cupp_upload_meta");

				if(is_array($profile_url) && count($profile_url)) {

					echo "<div class='row'><img class='user_picture' src='" . $profile_url[0] . "' /></div>";
				}
				else{
					echo "<div class='row'><img class='user_picture' src='/rangoli/wp-content/themes/rangoli/images/default.jpg' /></div>";
				}

				if($user_info->description) {
					echo $user_info->description;
				}
				else{
					?>
					<a href="/profile/manage/index">Tell us a little about yourself. How'd you end up on this color journey? Let's get to know each other. </a>
				<?php
				}
				?>
			</div>

		</div>
		<div class="span6">

			<?php

				echo get_template_part("profile","shares");

				echo get_template_part("profile","likes");
			?>

		</div>
		<div class="span3">
			<p class="about_author">RECENT ACTIVITIES</p>
			<div class="description recent_comments">
				<?php

				$url = get_site_url()."/get_user_recent_activities.php?user_id=".$user_id;
				$activities=json_decode(file_get_contents($url));

				if($activities){
					$x=0;
					foreach($activities as $activity){
						if($x==0){
							$x++;
							continue;
						}

						foreach($activity as $data){
							if($data->type == "post"){
								echo "<div class='author_recent_activity' >";
								echo "<p class='post_date'>".date("m.d.y",strtotime($data->date))."</p>";

								echo $name.' says <br/> checkout my new post "';
									echo "<a href='".get_the_permalink($data->article_id)."'>".$data->content."</a>";
								echo '"';

								$imgUrl=wp_get_attachment_image_src(get_post_thumbnail_id($data->article_id),'single-post-thumbnail');
								if($imgUrl[0]!="") {
									?>

									<div class="img_in_circle" onclick="window.location='<?php echo get_the_permalink($data->article_id) ?>'"
										 style="background: url('<?php echo $imgUrl[0]; ?>') no-repeat; background-size:auto 100%; background-position: center center;">

									</div>
								<?php
								}
								echo "</div>";
							}
							if($data->type == "like"){
								echo "<div class='author_recent_activity' >";
								echo "<p class='post_date'>".date("m.d.y",strtotime($data->date))."</p>";

								echo $name.' saved <br/> "';
								echo "<a href='".get_the_permalink($data->article_id)."'>".$data->content."</a>";
								echo '"';
								$imgUrl=wp_get_attachment_image_src(get_post_thumbnail_id($data->article_id),'single-post-thumbnail');
								if($imgUrl[0]!="") {
									?>

									<div class="img_in_circle" onclick="window.location='<?php echo get_the_permalink($data->article_id) ?>'"
										 style="background: url('<?php echo $imgUrl[0]; ?>') no-repeat; background-size:auto 100%; background-position: center center;">

									</div>
								<?php
								}
								echo "</div>";
							}
							if($data->type == "comment"){
								echo "<div class='author_recent_activity' >";
								echo "<p class='post_date'>".date("m.d.y",strtotime($data->date))."</p>";

								echo $name.' commented on <br/> "';
								echo "<a href='".get_the_permalink($data->article_id)."'>".$data->content."</a>";
								echo '"';
								$imgUrl=wp_get_attachment_image_src(get_post_thumbnail_id($data->article_id),'single-post-thumbnail');
								if($imgUrl[0]!="") {
									?>

									<div class="img_in_circle" onclick="window.location='<?php echo get_the_permalink($data->article_id) ?>'"
										 style="background: url('<?php echo $imgUrl[0]; ?>') no-repeat; background-size:auto 100%; background-position: center center;">

									</div>
								<?php
								}
								echo "</div>";
							}
							if($x>=5){
								break;
							}
							$x++;
						}

					}
				}



				?>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>
