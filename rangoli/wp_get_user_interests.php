<?php

    require("wp-load.php");
    global $wpbd;
    $user_id = $_REQUEST['user_id'];

    $interests = $wpdb->get_results("select category from rangoli_user_interests where user_id=".$user_id);

    if($interests && count($interests)>0) {

        $ar = array();
        foreach($interests as $interest){
            $ar[] = $interest->category;
        }

        echo json_encode($ar);
    }
else{
    echo null;
}

?>