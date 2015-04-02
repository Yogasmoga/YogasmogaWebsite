<div id="post_comments_listing" class="row">
    <?php
    $post = get_post();
    $comments = get_comments(array('post_id' => $post->ID, "order" => "DESC"));
    $count = count($comments);
    $i = 0;
    $print=0;
    if ($count > 3):
        $print = 3;
    else:
        $print = 4;
    endif;

    $hasMore = false;
    foreach ($comments as $comment) :
        if($comment->comment_approved != "trash" && $comment->comment_approved != "post-trashed"){
    $user_id = $comment->user_id;
    $user_info = get_userdata($user_id);
    if ($i >= $print) {
    $print = $count + 1;
    $hasMore = true;
    ?>
    <div class='row' style='clear:both;'>
        <div class='span2'></div>
        <div class='span10'>
            <span class='show_more_comments'>More</span>
        </div>
    </div>
    <div class='more_comments row' style='clear:both;'>

        <?php
        }
        if (username_exists($user_info->user_login)) {
        $imgURL = get_the_author_meta('cupp_upload_meta', $user_id);
        $size = 'thumbnail';
        if ($imgURL != "") {

        ?>
        <div class="row">
            <div class="span2">
                <div class="profile-img-small"
                     style="background: url('<?php echo $imgURL ?>'); background-size: 100%;"></div>
            </div>

            <?php } else { ?>

            <div class="row">
                <div class="span2">
                    <div class="profile-img-small"
                         style="background: url('<?php echo get_site_url() . "/wp-content/themes/rangoli/images/default.jpg" ?>'); background-size: 100%;">
                    </div>
                </div>

                <?php } ?>

                <div class='span9'>
                    <p class='comment_author'><?php echo get_the_author_meta('display_name', $user_id); ?></p>

                    <p class='comment'><?php echo nl2br($comment->comment_content); ?></p>
                </div>
                <div class='span1'>
                    <p class='comment_time'><?php echo date('m.j.y', strtotime($comment->comment_date)); ?></p>
                </div>

            </div>
            <?php
            }

            $i++;
            }
    endforeach;
            if($hasMore){
                echo "</div>";
            }

    ?>

    <?php
    $args = array(
        'fields' => apply_filters(
            'comment_form_default_fields',
            array('comment_field' => __(''),
                'reply-title' => __(''),
                'logged-in-as' => __(''),
                'form-allowed-tags' => __(''),
                'comment-notes' => __('')
            )),
        'label_submit' => __('Share your comments')
    );
    ?>
    <div style='clear:both;'></div>
    <div class='span2'>

    </div>
    <div class='span9'>
        <?php
        comment_form($args);
        ?>
    </div>
    <div class="span1"></div>
    <div style='clear:both;'></div>

    <div style='clear:both;'></div>
</div>