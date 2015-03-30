<?php
require("wp-load.php");


$query = "select rp.id as post_id,rup.color_main as color, rup.color_shade as color_shade,ru.display_name as post_author,post_date from rangoli_posts as rp,rangoli_users as ru,rangoli_user_profiles as rup where rp.post_status='publish' and rp.post_author=rup.user_id and rp.id in (select distinct(comment_post_id) from rangoli_comments order by comment_date desc)";

$posts = $wpdb->get_results($query);

$ar_post = array();
$ar_colors = array();
if ($posts && count($posts) > 0) {

    foreach ($posts as $post) {
        $post_data = get_object_vars($post);

        $color = $post_data['color'];

        if (!isset($ar_colors[$color])) {
            $ar_post[] = array(
                'color' => $post_data['color_shade'],
                'post_date' => $post_data['post_date'],
                'post_author' => $post_data['post_author'],
                'post_id' => $post_data['post_id']
            );

            $ar_colors[$color] = $color;
        }
    }

    if(count($ar_post)>0)
        echo json_encode($ar_post);
}


?>