<?php
    $target_file = "stitch.xls";
    $extension = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_FILES["file"])) {

        if ($_FILES["file"]["size"] > 50000000) {
            echo "large";
        }
        else {
            if (strtolower($extension) == "xls") {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "success";
                } else {
                    echo "error";
                }
            }
        }
    }
    else
        echo "file";
?>