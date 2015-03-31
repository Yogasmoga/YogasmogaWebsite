<?php
require("wp-load.php");

function compareDates($firstDate, $secondDate)
{
    return strtotime($secondDate["date"]) - strtotime($firstDate["date"]);
}

function isDuplicateUserPost($data, $user_id){

    if($data){

        foreach($data as $single){

            if($single['user_id']===$user_id)
                return true;
        }

        return false;
    }
    else
        return false;
}

function isDuplicateColor($data, $color){

    if($data){

        foreach($data as $single){

            if($single['color_main']===$color)
                return true;
        }

        return false;
    }
    else
        return false;
}

$color_main = $_REQUEST['color'];

if(isset($color_main)==false)
    return null;

$query = "select post_author, post_title, post_date, color_main, color_shade, profile_url, display_name, customer_id
          from rangoli_posts as rp, rangoli_user_profiles as rup, rangoli_users as ru
          where rp.post_author=rup.user_id and rup.user_id=ru.id and customer_id>0 and color_main='$color_main'
          order by post_date desc limit 0,200";

$posts = $wpdb->get_results($query);

$data = array();
if ($posts && count($posts) > 0) {

    foreach($posts as $post){

        $post_data = get_object_vars($post);

        if($post_data['post_author']=='')
            continue;

        if(!isDuplicateUserPost($data, $post_data['post_author'])){
            $ar_data = array(
                'user_id' => $post_data['post_author'],
                'post_author' => $post_data['display_name'],
                'customer_id' => $post_data['customer_id'],
                'type'=> 'post',
                'title' => $post_data['post_title'],
                'date' => $post_data['post_date'],
                'color_main' => $post_data['color_main'],
                'color_shade' => $post_data['color_shade'],
                'profile_url' => $post_data['profile_url']
            );

            $data[] = $ar_data;
        }
    }
}

$query = "select rp.user_id, comment_content, comment_date, color_main, color_shade, profile_url, comment_post_id, customer_id from rangoli_comments as rp, rangoli_user_profiles as rup
          where rp.user_id=rup.user_id and color_main='$color_main'
          order by comment_date desc limit 0,200";

$comments = $wpdb->get_results($query);

if ($comments && count($comments) > 0) {

    foreach($comments as $comment){

        $comment_data = get_object_vars($comment);

        if(!isDuplicateUserPost($data, $comment_data['user_id'])){

            if($comment_data['user_id']=='')
                continue;

            $comment_post_id = $comment_data['comment_post_id'];

            $authors = $wpdb->get_results("select display_name from rangoli_users as ru, rangoli_posts as rp where ru.user_id=rp.post_author and rp.post_id=$comment_post_id");

            if($authors) {
                $author = $authors[0];
                $post_author = $author['display_name'];
            }
            else{
                $post_author = -1;
            }

            if($post_author>-1) {

                $ar_data = array(
                    'user_id' => $comment_data['user_id'],
                    'post_author' => $post_author,
                    'customer_id' => $comment_data['customer_id'],
                    'type' => 'comment',
                    'title' => '',
                    'date' => $comment_data['comment_date'],
                    'color_main' => $post_data['color_main'],
                    'color_shade' => $post_data['color_shade'],
                    'profile_url' => $post_data['profile_url']
                );

                $data[] = $ar_data;

                unset($ar_data);
            }
        }
    }
}

if($data){

    usort($data, "compareDates");

    $data_unique_color = array();

    foreach($data as $single){

        if(!isDuplicateColor($data_unique_color,$single['color_main'])) {

            $user_id = $single['user_id'];
            $customer_id = $single['customer_id'];

/********************* read user interests ******************************/
            $interests = $wpdb->get_results("select category from rangoli_user_interests where user_id=$user_id");

            if($interests && count($interests)>0) {

                $ar = array();
                foreach($interests as $interest){

                    $interest_data = get_object_vars($interest);

                    $ar[] = $interest_data['category'];
                }

                $all_interests = implode(',', $ar);
            }
            else
                $all_interests = '';
/********************* read user interests ******************************/

/********************* read user smogi bucks ******************************/
            $query = "SELECT points_current,points_spent FROM rewardpoints_account where customer_id=$customer_id";
            $points = $wpdb->get_results($query);

            if($points && count($points)>0) {

                foreach($points as $point) {

                    $smogi_bucks = 0;
                    foreach ($points as $point) {

                        $point_data = get_object_vars($point);

                        $smogi_bucks += intval($point_data["points_current"]);
                        $smogi_bucks += intval($point_data["points_spent"]);
                    }
                }
            }
            else
                $smogi_bucks = 0;
/********************* read user smogi bucks ******************************/

            $data_unique_color[] = array(
                'user_id' => $single['user_id'],
                'post_author' => $single['post_author'],
                'type'=> $single['type'],
                'title' => $single['title'],
                'date' => $single['date'],
                'color_main' => $single['color_main'],
                'color_shade' => $single['color_shade'],
                'profile_url' => $single['profile_url'],
                'interestes' => $all_interests,
                'smogi_bucks' => $smogi_bucks
            );
        }
    }

    if($data_unique_color && count($data_unique_color)>0)
        echo json_encode($data_unique_color);
    else
        echo null;
}
?>