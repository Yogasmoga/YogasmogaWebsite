<?php
require("wp-load.php");

global $wpdb;

$user_id = $_REQUEST['user_id'];
$username = $_REQUEST['username'];
               // add , remove

if(isset($username) && isset($user_id)) {
    $username = trim($username);

    $users = $wpdb->get_results("select * from rangoli_user_profiles where user_display_name='" .$username."'");

    if(is_array($users) && count($users)>0) {
        $result = $wpdb->query("update  rangoli_user_profiles set  user_display_name = '$username' where user_id=$user_id");
        if ($result) {
            echo "updated";
        }
        else{
            echo "error";
        }
    }
    else{
        echo "exists";
    }
}
else
    echo "notfound";

ob_end_flush();
?>