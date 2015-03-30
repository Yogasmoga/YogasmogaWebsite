<?php
require("wp-load.php");

$user_id = get_current_user_id();
if ($user_id) {
    $subject_id = $_REQUEST['subject_id'];
    $subject_type = $_REQUEST['subject_type'];
    $rating_value = $_REQUEST['rating_value'];

    $ratings = $wpdb->get_results("select user_id from rangoli_ratings where user_id=$user_id and subject_id=$subject_id limit 0,1");
    if ($ratings && count($ratings) > 0) {

        $result = $wpdb->query(
            "update rangoli_ratings SET rating_value=$rating_value WHERE user_id=$user_id and subject_id=$subject_id");

        if ($result > 0)
            echo "updated";
        else
            echo "not found";
    } else {

        $result = $wpdb->insert(
            'rangoli_ratings',
            array(
                'user_id' => $user_id,
                'subject_id' => $subject_id,
                'subject_type' => $subject_type,
                'rating_value' => $rating_value
            ),
            array(
                '%d',
                '%d',
                '%s',
                '%d'
            )
        );

        if ($result > 0)
            echo "done";
        else
            echo "failed";
    }
}
?>