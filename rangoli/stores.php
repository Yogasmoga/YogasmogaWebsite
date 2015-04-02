<?php
/**

 * Template Name: YS STORES

/*
 */
get_header(); ?>
    <div class="wp_page row" style="margin-top: 50px; text-align: center;">

        <br/>

        <div class="main-content row">
            <div class="entry-header">
                <h1 class="entry-title">YS STORES</h1>
            </div>
            <div class="smogi-list row">

                <?php
                    get_template_part("content","stores");
                ?>

            </div>

        </div>
    </div>
<?php get_footer();
?>