<?php 

  # This file simply serves the link that merchants click to authorize your application.
  # When authorization completes, a notification is sent to your redirect URL, which should
  # be handled in callback.php.

  $applicationId = 'sq0idp-M6WKrnm5z_wlR2Kbaer4Wg';

  echo "<a href=\"https://connect.squareup.com/oauth2/authorize?client_id=$applicationId\">Click here</a> to authorize the application.";
?>
