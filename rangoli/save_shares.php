<?php
require("wp-load.php");

$user_id = $_REQUEST['user_id'];
//echo "user_id =$user_id";

    $post_id = $_REQUEST['post_id'];

    $saves = $wpdb->get_results("select user_id from rangoli_shares where user_id=$user_id and post_id=$post_id limit 0,1");
    if ($saves && count($saves) > 0) {
        echo "exists";
    } else {

        $result = $wpdb->insert(
            'rangoli_shares',
            array(
                'user_id' => $user_id,
                'post_id' => $post_id,
                'created_at' => date('Y-m-d h:i:s')
            ),
            array(
                '%d',
                '%d',
                '%s'
            )
        );

        if ($result > 0)
            echo "done";
        else
            echo "failed";
    }
?>