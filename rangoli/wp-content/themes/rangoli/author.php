<?php get_header();

?>
<div class="wp_page row">

	<div class="main-content row">
		<?php
		$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
		$user_id=$curauth->ID;
		$user_info=get_userdata($user_id);
		$wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=".$user_id);
		if(count($wpauthors)>0)
		$wp_author=$wpauthors[0];

		$avatar = get_the_author_meta('author_profile_picture', $user_id);
		?>
	</div>
	<div class="wp_page_banner row" style="height:600px; background: url('<?php echo $avatar; ?>') <?php echo '#'.$wp_author->color_shade; ?>">
		<?php
		if($curauth->roles[0]=="smogi"){
			$role='SMOGI';
		}
		else if($curauth->roles[0]=="store"){
			$role = "STORE";
		}
		$user_profile=get_user_profile($user_id);
		$main_color=$user_profile->color_main;
		$level = get_user_level($user_id);
		$main_color=strtoupper($main_color);

		echo " <div class='overlay-text'>
			<div class='align-bottom'>
			<span class='charm color_$main_color $level'></span>
			<p class='author_role'>".$role."</p>";

		$title=get_the_title();
		echo "<p class='post_title'>".$curauth->display_name."</p>";

		echo "</div></div>";
		?>
	</div>

	<div class="row container author_info">
		<div class="span3">
			<p class="about_author">ABOUT</p>
			<div class="description">
				<?php
				echo nl2br($curauth->description);

				echo get_template_part("author", "events");
				?>

			</div>

		</div>
		<div class="span6">

			<?php

				echo get_template_part("author","posts");

				echo get_template_part("author","readings");

				echo get_template_part("author","watchings");

				echo get_template_part("author","learnings");
			?>

		</div>
		<div class="span3" style=" right:0;top: 20px; ">
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
								echo "<p class='post_date'>".date("j.m.y",strtotime($data->date))."</p>";
								$name=$curauth->display_name;
								$name=ucwords($curauth->display_name);
								echo $name.'  <span style="font-style: italic">says</span> <br/> checkout my new post "';
									echo "<a class='ajax-load' href='".get_the_permalink($data->article_id)."'>".$data->content."</a>";
								echo '"';

								$imgUrl=wp_get_attachment_image_src(get_post_thumbnail_id($data->article_id),'single-post-thumbnail');
								if($imgUrl[0]!="") {
									?>

									<div class="img_in_circle" onclick="ajax_load_pages('<?php echo get_the_permalink($data->article_id) ?>')"
										 style="background: url('<?php echo $imgUrl[0]; ?>') no-repeat; background-size:auto 100%; background-position: center center;">

									</div>
								<?php
								}
								echo "</div>";
							}
							if($data->type == "like"){
								echo "<div class='author_recent_activity' >";
								echo "<p class='post_date'>".date("j.m.y",strtotime($data->date))."</p>";
								$name=$curauth->display_name;
								$name=ucwords($curauth->display_name);
								echo $name.' <span style="font-style: italic">saved</span> <br/> "';
								echo "<a  class='ajax-load' href='".get_the_permalink($data->article_id)."'>".$data->content."</a>";
								echo '"';
								$imgUrl=wp_get_attachment_image_src(get_post_thumbnail_id($data->article_id),'single-post-thumbnail');
								if($imgUrl[0]!="") {
									?>

									<div class="img_in_circle" onclick="ajax_load_pages('<?php echo get_the_permalink($data->article_id) ?>')"
										 style="background: url('<?php echo $imgUrl[0]; ?>') no-repeat; background-size:auto 100%; background-position: center center;">

									</div>
								<?php
								}
								echo "</div>";
							}
							if($data->type == "comment"){
								echo "<div class='author_recent_activity' >";
								echo "<p class='post_date'>".date("j.m.y",strtotime($data->date))."</p>";
								$name=$curauth->display_name;
								$name=ucwords($curauth->display_name);
								echo $name.' <span style="font-style: italic"> commented on</span> <br/> "';
								echo "<a  class='ajax-load' href='".get_the_permalink($data->article_id)."'>".$data->content."</a>";
								echo '"';
								$imgUrl=wp_get_attachment_image_src(get_post_thumbnail_id($data->article_id),'single-post-thumbnail');
								if($imgUrl[0]!="") {
									?>

									<div class="img_in_circle" onclick="ajax_load_pages('<?php echo get_the_permalink($data->article_id) ?>')"
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
</div>
<?php get_footer(); ?>
