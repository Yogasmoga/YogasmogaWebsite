<ul id="instagram_widget">
	<?php       
	// Download: https://github.com/cosenary/Instagram-PHP-API/blob/master/instagram.class.php
	require_once 'http://staging.yogasmoga.com/qry/instagram_images/instagram_class.php';
	// Register at http://instagram.com/developer/ and replace client_id with your own
	$instagram = new Instagram('999f9f95809944558d0151f0fe93daed');
	$tag = 'yogasmoga';
	$media = $instagram->getTagMedia($tag);
	$limit = 12;
	$size = '225';
	foreach(array_slice($media->data, 0, $limit) as $data) {
		echo '<li>';
		echo '<img src="'.$data->images->standard_resolution->url.'" height="'.$size.'" width="'.$size.'"/>';
		echo '<p class="instagram_likes"><span class="likes_count">'.$data->likes->count.'</span></p>';
        echo '</li>';
    }
	
	
	?>
</ul>