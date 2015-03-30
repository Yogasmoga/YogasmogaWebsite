<?php
require("wp-load.php");

global $wpdb;

$user_id = $_REQUEST['user_id'];
$category = $_REQUEST['category'];
$type = $_REQUEST['type'];                  // add , remove

if(isset($category) && isset($user_id)) {

        if($type=="add") {
            $result = $wpdb->query(
                "insert into rangoli_user_interests(user_id, category) values($user_id, '$category')"
            );
            echo get_site_url()."/wp_update_user_interest.php?type=remove&user_id=".$user_id."&category=".$category;
        }
        else{
            $result = $wpdb->query(
                "delete from rangoli_user_interests where user_id=$user_id and category='$category'"
            );
            echo get_site_url()."/wp_update_user_interest.php?type=add&user_id=".$user_id."&category=".$category;
        }
}
else
    echo "notfound";

ob_end_flush();
?>