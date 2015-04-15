<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url')  ?>" />
    <script src="<?php bloginfo('template_directory')?>/js/jquery.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/custom.js" ></script>
    <script type="text/javascript">
    <?php
    $home = get_site_url();
    $root = str_replace("/rangoli","/",$home);
    echo "var homeUrl = '".$root."';
    ";
    echo "var root = '".$root."';
    ";
    ?>
    </script>

</head>
<body>