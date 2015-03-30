<?php
require("wp-load.php");

// logout logic
if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == 1) {
    // Log Out existing user
    if (is_user_logged_in()) {
        wp_logout();

        $ar = array("message" => "loggedout");

        echo json_encode($ar);
    }
    else{

        $ar = array("message" => "alreadyloggedout");

        echo json_encode($ar);
    }
}

// LOG IN
// Find URL Parameters in the URL
if (isset($_REQUEST['user_login']) && $_REQUEST['user_login'] != "" && isset($_REQUEST['password']) && $_REQUEST['password'] != "") {

    wp_logout();
    // Log Out existing user
//    if (is_user_logged_in()) {
//        $ar = array("message" => "alreadylogged");
//
//        echo json_encode($ar);
//
//        return;
//    }


    /********* check if user exists, if not create account ****************************************/
    $email = $_REQUEST['user_login'];

    if( null == username_exists( $email ) ) {

        $first_name = $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];

        $display_name = $first_name . " " . $last_name;

        $password = $_REQUEST['password'];

        $customer_id = $_REQUEST['customer_id'];

        $user_info = array(
            "user_pass"     => $password,
            "user_login"    => $email,
            "user_nicename" => $display_name,
            "user_email"    => $email,
            "display_name"  => $display_name,
            "first_name"    => $first_name,
            "last_name"     => $last_name,
        );

        $user_id = wp_insert_user( $user_info );

        // Set the nickname
        wp_update_user(
            array(
                'ID'            =>      $user_id,
                'nickname'      =>      $first_name,
                'display_name'  =>      $display_name
            )
        );


        $color_main = '#555';
        $color_shade = '#555';
        $biodata = '';
        $profile_url = get_template_directory() . '/images/default.jpg';

        // pick random color for user
        $colors=$wpdb->get_results("select color_primary, color_shade from rangoli_profile_colors order by rand() limit 0,1");
        if($colors && count($colors)>0) {
            $color = get_object_vars($colors[0]);

            $color_main = $color['color_primary'];
            $color_shade = $color['color_shade'];
        }

//        $wpdb->insert(
//            'rangoli_user_profiles',
//            array(
//                'user_id' => $user_id,
//                'email' => $email,
//                'color_main' => $color_main,
//                'color_shade' => $color_shade,
//                'biodata' => $biodata,
//                'user_type' => 'subscriber',
//                'profile_url' => $profile_url,
//                'status' => 'new',
//                'customer_id' => $customer_id
//            ),
//            array(
//                '%d',
//                '%s',
//                '%s',
//                '%s',
//                '%s',
//                '%s',
//                '%s',
//                '%s',
//                '%d'
//            )
//        );

        $result = $wpdb->query(
            "insert into rangoli_user_profiles(
              user_id,
              email,
              color_main,
              color_shade,
              biodata,
              user_type,
              profile_url,
              status,
              customer_id
              ) values(
              $user_id,
              '$email',
              '$color_main',
              '$color_shade',
              '$biodata',
              'subscriber',
              'profile_url',
              'new',
              $customer_id
              )"
        );

        // Set the role
        $user = new WP_User( $user_id );
        $user->set_role( 'subscriber' );
    }

    /********* check if user exists, if not create account ****************************************/


    // GET Login Data from URL
    $creds = array();
    $creds['user_login'] = $_REQUEST['user_login'];
    $creds['user_password'] = $_REQUEST['password'];
    $creds['remember'] = false;

    // Wordpress LOGIN method
    $user = wp_signon($creds, false);

    // ERROR
    if (is_wp_error($user)) {
        $ar = array("message" => "loginerror", "error" => $user->get_error_message());

        echo json_encode($ar);
    }
    else{
        $ar = array(
            "message" => "success",
            "user_id" => $user->ID,
            "user_email" => $user_email,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "display_name" => $user->display_name,
            "total" => $user
        );

        echo json_encode($ar);
    }
}
