<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$user_id = $curauth->ID;
?>
    <div class="event_author_name">
        <?php
        echo strtoupper($curauth->display_name) . "'S EVENTS";
        ?>
    </div>
<?php
$args = array(
    'order' => 'DESC',
    'post_type' => 'event'
//    'author_name' => $curauth->user_nicename
);
$i = 0;
$the_query = new WP_Query($args);
echo '<div class="author_events row">';
if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
//
//endwhile;
//endif;
//wp_reset_query();
//$the_query = new WP_Query($args);

//if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
    $post = get_post();
    $title = get_the_title();
    $date = $post->post_date;
    $date = date('h:i A', strtotime($date));
    $event_day_ar = get_post_meta($post->ID, "wpcf-dayname");
    if ($event_day_ar) {
        $event_day = $event_day_ar[0];
    } else {
        $event_day = "";
    }

    $month_ar = get_post_meta($post->ID, "wpcf-month");
    if ($event_day_ar) {
        $month = $month_ar[0];
    } else {
        $month = "";
    }

    $location_ar = get_post_meta($post->ID, "wpcf-location");
    if ($location_ar) {
        $location = $location_ar[0];
    } else {
        $location = "";
    }

    $monthday_ar = get_post_meta($post->ID, "wpcf-monthday");
    if ($location_ar) {
        $monthday = $monthday_ar[0];
    } else {
        $monthday = "";
    }

    ?>
    <div class="author_event">
        <p class="event_time"><?php echo $date; ?></p>

        <p class="event_day"><?php echo $event_day . " " . $month . " " . $monthday; ?></p>

        <p class="event_title"><?php echo $title ?></p>

        <p class="event_location"><?php echo nl2br($location) ?></p>
    </div>


    <?php
    $i++;
    if ($i == 5) {
        break;
    }
endwhile;
endif;
wp_reset_query();
echo '</div>';
//?>