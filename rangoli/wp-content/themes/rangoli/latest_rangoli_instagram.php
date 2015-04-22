<?php
$username = "yogasmoga";
$url = "https://api.instagram.com/v1/users/search?access_token=1536185190.1fb234f.a2a4707e77804807be4b582d58ad4330&q=$username&count=10%20HTTP/1.1";
$json = json_decode(file_get_contents($url));

$userId = $json->data[0]->id;

$url = "https://api.instagram.com/v1/users/$userId/media/recent?access_token=1536185190.1fb234f.a2a4707e77804807be4b582d58ad4330&count=10%20HTTP/1.1";

$json = json_decode(file_get_contents($url));
$imageUrl="";
$i=0;
foreach ($json->data as $data) {

    if(isset($data->tags) && count($data->tags)>0){
        foreach($data->tags as $tag){
            if(strtolower($tag)!="rangoli") {
                continue;
            }
            if($i==0){
                $imageUrl = $data->images->standard_resolution->url;
                if($imageUrl!="" && $i==0){
    ?>
                <div class="row one-three" style="background: url('<?php echo $imageUrl; ?>') no-repeat; background-position: center center; background-size: cover; width:100% !important;" >
                    <?php
                    echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
                    ?>
                </div>
                <div  class="overlay-text" style="background: rgba(0,0,0,0.2)" onclick="window.open('http://instagram.com/yogasmoga','_blank')">
                    <a class="twitter-icon"  href="javascript:void(0);"><img src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/ig-w.png" /></a>
                </div>


    <?php

                $i=1;
                }
            }


//            echo $imageUrl;
            if($i=1)
               break;
        }
    }
}
?>

