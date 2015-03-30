<?php
require("wp-load.php");

global $wpdb;

$user_id = $_REQUEST['user_id'];

$count = $wpdb->query("SELECT COUNT(*) FROM $wpdb->users WHERE ID = '$user_id'");

if( $count>0 ) {

    $color_main = $_REQUEST['color_main'];
    $color_shade = $_REQUEST['color_shade'];

    $ereminders = $wpdb->query(
                        "update rangoli_user_profiles SET color_main='$color_main', color_shade='$color_shade' WHERE user_id = $user_id"
                );

    echo "done";
}
else
    echo "not found";

?>