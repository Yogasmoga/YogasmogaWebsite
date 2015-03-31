<?php
require("wp-load.php");

function compareDates($firstDate, $secondDate)
{
    return strtotime($secondDate["date"]) - strtotime($firstDate["date"]);
}

function isDuplicateUserPost($data, $user_id)
{

    if ($data) {

        foreach ($data as $single) {

            if ($single['userId'] === $user_id)
                return true;
        }

        return false;
    } else
        return false;
}

$color_main = $_REQUEST['color'];

if (isset($color_main) == false)
    return null;

$query = "select post_author, post_title, post_date, color_main, color_shade, profile_url, display_name, customer_id
          from rangoli_posts as rp, rangoli_user_profiles as rup, rangoli_users as ru
          where rp.post_author=rup.user_id and rup.user_id=ru.id and customer_id>0 and rp.post_status='publish' and rp.post_type='post' and color_main='$color_main'
          order by post_date desc limit 0,200";

$posts = $wpdb->get_results($query);

$data = array();
if ($posts && count($posts) > 0) {

    $x = 0;
    foreach ($posts as $post) {

        $post_data = get_object_vars($post);

        if (!isDuplicateUserPost($data, $post_data['post_author'])) {
            ++$x;

            $user_id = $post_data['post_author'];
            $ar_image_url = get_user_meta($post_data['post_author'], 'cupp_upload_meta');

            if ($ar_image_url && is_array($ar_image_url) && count($ar_image_url) > 0)
                $image_url = $ar_image_url[0];
            else
                $image_url = get_site_url() . '/wp-content/themes/rangoli/images/default.jpg';

            $address = get_user_meta($user_id, "wpcf-address");
            if (count($address) == 0)
                $place = "";
            else
                $place = $address[0];

            $level = get_user_level($user_id);

            $ar_data = array(
                'userId' => $post_data['post_author'],
                'type' => 'post',
                'color' => $post_data['color_main'],
                'shade' => $post_data['color_shade'],
                'name' => $post_data['display_name'],
                'profileImage' => $image_url,
                'level' => $level,
                'place' => $place,
                'date' => $post_data['post_date'],
                'postTitle' => $post_data['post_title'],
                'customer_id' => $post_data['customer_id'],
                'postAuther' => ''
            );

            $data[] = $ar_data;

            if($x>8)
                break;
        }
    }
}

$query = "select rc.user_id as user_id, comment_content, comment_date, color_main, color_shade, profile_url, comment_post_id, customer_id, comment_author from rangoli_comments as rc, rangoli_user_profiles as rup
          where rc.user_id=rup.user_id and color_main='$color_main'
          order by comment_date desc limit 0,200";

$comments = $wpdb->get_results($query);

if ($comments && count($comments) > 0) {

    $x = 0;
    foreach ($comments as $comment) {

        $comment_data = get_object_vars($comment);

//        if (!isDuplicateUserPost($data, $comment_data['user_id'])) {

        $comment_post_id = $comment_data['comment_post_id'];

        $authors = $wpdb->get_results("select display_name from rangoli_users as ru, rangoli_posts as rp where ru.id=rp.post_author and rp.id=$comment_post_id");

        if ($authors) {
            $author = get_object_vars($authors[0]);
            $post_author = $author['display_name'];
        } else {
            $post_author = -1;
        }

        if ($post_author > -1) {
            ++$x;

            $ar_image_url = get_user_meta($comment_data['user_id'], 'cupp_upload_meta');

            $address = get_user_meta($comment_data['user_id'], "wpcf-address");
            if (count($address) == 0)
                $place = "";
            else
                $place = $address[0];

            if ($ar_image_url && is_array($ar_image_url) && count($ar_image_url) > 0)
                $image_url = $ar_image_url[0];
            else
                $image_url = get_site_url() . '/wp-content/themes/rangoli/images/default.jpg';

            $level = get_user_level($comment_data['user_id']);

            $ar_data = array(
                'userId' => $comment_data['user_id'],
                'type' => 'comment',
                'color' => $comment_data['color_main'],
                'shade' => $comment_data['color_shade'],
                'name' => $comment_data['comment_author'],
                'profileImage' => $image_url,
                'level' => $level,
                'place' => $place,
                'date' => $comment_data['comment_date'],
                'postTitle' => '',
                'customer_id' => $comment_data['customer_id'],
                'postAuther' => $post_author
            );

            $data[] = $ar_data;

            unset($ar_data);
        }

        if($x>8)
            break;
    }
//    }
}

if ($data) {

    usort($data, "compareDates");

    $data_unique_color = array();

    foreach ($data as $single) {

        if (!isDuplicateUserPost($data_unique_color, $single['userId'])) {

            $user_id = $single['userId'];
            $customer_id = $single['customer_id'];

            $ar_image_url = get_user_meta($comment_data['user_id'], 'cupp_upload_meta');

            $address = get_user_meta($comment_data['user_id'], "wpcf-address");
            if (count($address) == 0)
                $place = "";
            else
                $place = $address[0];

            if ($ar_image_url && is_array($ar_image_url) && count($ar_image_url) > 0)
                $image_url = $ar_image_url[0];
            else
                $image_url = get_site_url() . '/wp-content/themes/rangoli/images/default.jpg';

            /********************* read user interests ******************************/
            $interests = $wpdb->get_results("select category from rangoli_user_interests where user_id=$user_id");

            if ($interests && count($interests) > 0) {

                $ar = array();
                foreach ($interests as $interest) {

                    $interest_data = get_object_vars($interest);

                    $ar[] = $interest_data['category'];
                }

                $all_interests = implode(',', $ar);
            } else
                $all_interests = '';
            /********************* read user interests ******************************/

            /********************* read user smogi bucks ******************************/
            $query = "SELECT points_current,points_spent FROM rewardpoints_account where customer_id=$customer_id";
            $points = $wpdb->get_results($query);

            if ($points && count($points) > 0) {

                foreach ($points as $point) {

                    $smogi_bucks = 0;
                    foreach ($points as $point) {

                        $point_data = get_object_vars($point);

                        $smogi_bucks += intval($point_data["points_current"]);
                        $smogi_bucks += intval($point_data["points_spent"]);
                    }
                }
            } else
                $smogi_bucks = 0;
            /********************* read user smogi bucks ******************************/
            $ar_image_url = get_user_meta($comment_data['user_id'], 'cupp_upload_meta');

            $address = get_user_meta($comment_data['user_id'], "wpcf-address");
            if (count($address) == 0)
                $place = "";
            else
                $place = $address[0];

            if ($ar_image_url && is_array($ar_image_url) && count($ar_image_url) > 0)
                $image_url = $ar_image_url[0];
            else
                $image_url = get_site_url() . '/wp-content/themes/rangoli/images/default.jpg';

            $data_unique_color[] = array(
                'userId' => $single['userId'],
                'type' => $single['type'],
                'color' => $single['color'],
                'shade' => $single['shade'],
                'name' => $single['name'],
                'profileImage' => $image_url,
                'place' => $single['place'],
                'interests' => $all_interests,
                'smogiBucks' => $smogi_bucks,
                'postTitle' => $single['postTitle'],
                'date' => $single['date'],
                'postAuther' => $single['postAuther']
            );
        }
    }

    if ($data_unique_color && count($data_unique_color) > 0)
        echo json_encode($data_unique_color);
    else
        echo null;
}
?>