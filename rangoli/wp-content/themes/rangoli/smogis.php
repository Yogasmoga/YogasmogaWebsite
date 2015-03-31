<?php
/**

 * Template Name: Super Smogis
 
	/*			
 */ 
get_header(); ?>
	<div class="wp_page row" style="margin-top: 50px; text-align: center;">
	<div class="main-content row">
		<div class="smogi-list row">

			<?php
				get_template_part("content","smogi");
			?>

		</div>

	</div>
</div>

<?php get_footer(); 
?>