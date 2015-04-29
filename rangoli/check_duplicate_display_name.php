<?php
require("wp-load.php");

global $wpdb;

$name = $_REQUEST['name'];

if(isset($name)) {
    $users = $wpdb->get_results("select user_display_name from rangoli_user_profiles where user_display_name='" . $name . "'");

    if(is_array($users) && count($users)>0)
        echo "exists";
    else
        echo "available";
}
else
    echo "invalid";

ob_end_flush();
?>