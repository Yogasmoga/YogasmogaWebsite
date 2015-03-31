<?php
require("wp-load.php");

function compareDates($firstDate, $secondDate)
{
    return strtotime($secondDate["date"]) - strtotime($firstDate["date"]);
}

$user_id = $_REQUEST['user_id'];

if(isset($user_id)) {

    $user_info = get_userdata($user_id);

    if(isset($user_info)) {

        $query = "select display_name, post_title, post_date, rp.id as post_id from rangoli_posts as rp, rangoli_users as ru where rp.post_status='publish' and rp.post_type='post' and rp.post_author=ru.id and rp.post_author=$user_id order by post_date desc limit 0,200";
//echo $query . " <hr/>";
        $posts = $wpdb->get_results($query);

        $data = array();
        if ($posts && count($posts) > 0) {

            foreach ($posts as $post) {

                $post_data = get_object_vars($post);

                $ar_data = array(
                    'article_id' => $post_data['post_id'],
                    'name' => $post_data['display_name'],
                    'content' => $post_data['post_title'],
                    'date' => $post_data['post_date'],
                    'type' => 'post'
                );

                $data[] = $ar_data;
            }
        }

        $query = "select comment_author, comment_content, comment_date, comment_post_ID from rangoli_comments as rc, rangoli_users as ru where rc.user_id=ru.id and rc.user_id=$user_id and rc.comment_approved not in ('trash','post-trashed') order by comment_date desc limit 0,200";

        $comments = $wpdb->get_results($query);

        if ($comments && count($comments) > 0) {

            foreach ($comments as $comment) {

                $comment_data = get_object_vars($comment);

                $ar_data = array(
                    'article_id' => $comment_data['comment_post_ID'],
                    'name' => $comment_data['comment_author'],
                    'content' => $comment_data['comment_content'],
                    'date' => $comment_data['comment_date'],
                    'type' => 'comment'
                );

                $data[] = $ar_data;
            }
        }

        $user_favourites = wpfp_get_users_favorites($user_info->user_login);

        if($user_favourites && is_array($user_favourites) && count($user_favourites)>0){

            foreach($user_favourites as $favourite){

                if(isset($favourite) && !empty($favourite)){

                    $post = get_post($favourite);

                    $author_id = $post->post_author;

                    $author = get_userdata($author_id);

                    $ar_data = array(
                        'article_id' => $post->ID,
                        'name' => $author->display_name,
                        'content' => $post->post_title,
                        'date' => $post->post_date,
                        'type' => 'like'
                    );

                    $data[] = $ar_data;
                }
            }
        }

        echo json_encode(array('message'=>'found', 'data' => $data));
    }
    else
        echo json_encode(array('message' => 'invalid user'));
}
else
    echo json_encode(array('message' => 'user id missing'));
?>