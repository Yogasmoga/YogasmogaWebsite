<?php
require("wp-load.php");

global $wpdb;

$name = mysql_real_escape_string($_REQUEST['name']);
$customer_id = mysql_real_escape_string($_REQUEST['customer_id']);

if(isset($name)) {
    $users = $wpdb->get_results("select user_display_name, customer_id from rangoli_user_profiles where user_display_name='" . trim($name) . "'");

    if(isset($users) && count($users)>0) {

        $data = get_object_vars($users[0]);

        $user_display_name = $data['user_display_name'];
        $record_customer_id = $data['customer_id'];

        if($customer_id==$record_customer_id)
            echo "same";
        else
            echo "exists";
    }
    else
        echo "available";
}
else
    echo "invalid";

ob_end_flush();
?>