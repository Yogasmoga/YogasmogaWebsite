<?php
    require("wp-load.php");

    $customer_id = $_REQUEST['customer_id'];
    $password = $_REQUEST['password'];

    $row = $wpdb->get_results("SELECT user_id FROM rangoli_user_profiles WHERE customer_id = $customer_id");

    if(isset($row) && count($row)>0){

        $data = get_object_vars($row[0]);

        $user_id = $data['user_id'];

        $hash = wp_hash_password( $password );

        $wpdb->update($wpdb->users, array('user_pass' => $hash), array('ID' => $user_id) );
        //wp_set_password($password, $user_id);

        echo 'done';
    }
    else
        echo 'not found';
?>