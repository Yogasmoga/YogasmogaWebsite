<?php
function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

if(isset($_FILES['file'])) {

    $target_file = "facebook_advert.csv";
    $extension = pathinfo($target_file, PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if (isset($_FILES["file"])) {

        if ($_FILES["file"]["size"] > 50000000) {
            echo "large";
        } else {
            if (strtolower($extension) == "csv") {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], 'facebook_advert_files/' . $target_file)) {
                    ;
                } else {
                    echo "Error in uploading file";
                    die;
                }
            }
        }
    } else {
        echo "No file found";
        die;
    }

    $myfile = fopen("facebook_mailchimp_list.txt", "r") or die("Unable to open file!");
    $apikey_listid = trim(fgets($myfile));
    fclose($myfile);

    $ar = explode(",", $apikey_listid);

    $api_key = trim($ar[0]);
    $list_id = trim($ar[1]);

    $correct = isset($api_key) && isset($list_id) && (strlen($list_id) > 0) && (strlen($api_key) > 0);

    if ($correct) {

        $file = fopen("facebook_advert_files/$target_file", "r");

        $firstTime = true;
        while (!feof($file)) {
            if ($firstTime) {
                $data = fgetcsv($file);
                $firstTime = !$firstTime;
            }
            $data = fgetcsv($file);

            $zip = $data[2];
            if (startsWith($zip, 'z:'))
                $zip = substr($zip, 2);

            $batch[] = array(
                'FNAME' => $data[0],
                'LNAME' => '',
                'EMAIL' => $data[1],
                'ZIP' => $zip,
                'GENDER' => $data[3],
                'MAILSOURCE' => 'facebook'
            );
        }

        fclose($file);

        include("../mailchimpapi/Drewm/MailChimp.php");

        $mailChimp = new Drewm\MailChimp($api_key);

        $i = 0;
        foreach ($batch as $single) {

            ++$i;

            $email = $single["EMAIL"];
            $fname = $single["FNAME"];
            $lname = $single["LNAME"];
            $gender = $single["GENDER"];
            $zip = $single["ZIP"];
            $mailSource = $single["MAILSOURCE"];

            $result = $mailChimp->call('lists/member-info', array(
                'id' => $list_id,
                'emails' => array(0 => array('email' => $email))
            ));

            if (isset($result["data"][0]["status"]) && $result["data"][0]["status"] == "unsubscribed") {
                echo $result["data"][0]["email"] . " is " . $result["data"][0]["status"] . ", not changing values<br/>";
            } else if (isset($result["data"][0]["status"]) && $result["data"][0]["status"] == "subscribed") {
                echo $result["data"][0]["email"] . " is " . $result["data"][0]["status"] . ", not changing values<br/>";
            } else {
                $result = $mailChimp->call('lists/subscribe', array(
                    'id' => $list_id,
                    'email' => array('email' => $email),
                    'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname, 'ZIP' => $zip, 'GENDER' => $gender, 'MAILSOURCE' => $mailSource),
                    'double_optin' => false,
                    'update_existing' => false,
                    'replace_interests' => false,
                    'send_welcome' => false,
                ));
            }

            echo "<br/><br/>";
        }
    }
}
else{
?>

    <html>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
            Choose file : <input type="file" name="file"/> &nbsp; <input type="submit" value="Upload file"/>
        </form>
    </body>
    </html>

<?php
}
?>