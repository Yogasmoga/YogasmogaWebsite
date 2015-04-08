<?php

class Ysindia_Profile_ManageController extends Mage_Core_Controller_Front_Action
{
    public function viewAction()
    {

        $customer = Mage::getSingleton('customer/session');
        if (!$customer->isLoggedIn()) {
            $this->_redirectReferer();
        } else {
            $this->loadLayout();
            $this->renderLayout();

            $id = $_REQUEST['id'];

            if (!isset($id)) {

            } else {

            }
        }
    }

    public function referralurlAction(){
        $userId = Mage::getSingleton('customer/session')->getCustomer()->getId();

        echo $this->bit_ly_short_url(Mage::getUrl('rewardpoints/index/goReferral') . "referrer/" . $userId);
    }

    function bit_ly_short_url($url, $format='txt') {
        $login = "yogasmogarangoli";
        $appkey = "R_0f1d1bc2a82f472eaa33ef817e8d5548";
        $bitly_api = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$bitly_api);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function indexAction()
    {
        $customer = Mage::getSingleton('customer/session');
        if (!$customer->isLoggedIn()) {
            $this->_redirectReferer();
        } else {
            $this->loadLayout();
            $this->getLayout()->getBlock('head')->setTitle($this->__('Update Your Profile'));
            $this->renderLayout();
        }


    }
    /************* code update by YS india team, add profile picture to customer account ********************/
    /*public function profileAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }*/

    public function pad($x)
    {
        if ($x < 10) {
            if (substr(0, 1) == "0")
                return $x;
            else
                return "0" . $x;
        } else
            return $x;
    }

    public function saveimageAction()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $query = "SELECT id,user_login FROM rangoli_users where user_email='" . $customer->getEmail() . "'";

            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');

            $results = $readConnection->fetchAll($query);

            if ($results && count($results) == 1) {
                $user_id = $results[0]["id"];

                $description = $_REQUEST['description'];

                $writeConnection = $resource->getConnection('core_write');
                if ($results && count($results) > 0) {
                    $query = "update rangoli_usermeta set meta_value='$description' where user_id=$user_id and meta_key='description'";
                    $result = $writeConnection->query($query);
                } else {
                    $query = "insert into rangoli_usermeta(user_id, meta_key, meta_value) values($user_id, 'description','$description')";
                    $result = $writeConnection->query($query);
                }

                $filepath = Mage::getBaseDir() . "rangoli/rangoli_profile_images/";
                $savepath = Mage::getBaseUrl() . "rangoli/rangoli_profile_images/";

//                $banner_found = false;
                $profile_found = false;

//                if(isset($_POST['banner_filename'])) {
//                    $banner_found = true;
//                }

                if(isset($_POST['profile_filename']) && strlen(trim($_POST['profile_filename']))>4) {
                    $profile_found = true;
                }

                $file_formats = array("jpg", "jpeg", "png", "gif", "bmp");

                $ar_messages = array();
                $error = false;

//                if ($banner_found) {
//
//                    $extension_banner = pathinfo($_POST['banner_filename'], PATHINFO_EXTENSION);
//
//                    if (in_array($extension_banner, $file_formats)) { // check it if it's a valid format or not
//
////                            $imagename_banner = md5(uniqid() . time()) . "." . $extension_banner;
////                            $tmp_banner = $_FILES['banner_pic']['tmp_name'];
//
//                            $thumb_width = "150";
//
//                            //$banner_result = move_uploaded_file($tmp_banner, $filepath . $imagename_banner);
//                            $banner_result = true;
//
//                            //$banner_pic = $savepath . $imagename_banner;
//                            $banner_pic = $savepath . $_POST['banner_filename'];
//
//                            if ($banner_result) {
//                                $ar_messages[] = array('message' => 'Banner uploaded');
//
//                                $writeConnection = $resource->getConnection('core_write');
//
//                                $query = "SELECT user_id FROM rangoli_usermeta where user_id=$user_id and meta_key='author_profile_picture'";
//
//                                $results = $readConnection->fetchAll($query);
//
//                                if ($results && count($results) > 0) {
//                                    $query = "update rangoli_usermeta set meta_value='$banner_pic' where user_id=$user_id and meta_key='author_profile_picture'";
//                                    $result = $writeConnection->query($query);
//                                } else {
//                                    $query = "insert into rangoli_usermeta(user_id, meta_key, meta_value) values($user_id, 'author_profile_picture','$banner_pic')";
//                                    $result = $writeConnection->query($query);
//                                }
//
//                            } else {
//                                $ar_messages[] = array('message' => 'There was some error in uploading the banner');
//
//                                $error = true;
//                            }
//                    } else {
//                        $ar_messages[] = array('message' => 'Invalid banner picture, not an image');
//
//                        $error = true;
//                    }
//                }
//                else {
//                    ;//$ar_messages[] = array('message' => 'Banner picture not provided');
//                }

                if ($profile_found) {

                    $extension_profile = pathinfo($_POST['profile_filename'], PATHINFO_EXTENSION);

                    if (in_array($extension_profile, $file_formats)) { // check it if it's a valid format or not

                        //$imagename_profile = md5(uniqid() . time()) . "." . $extension_profile;
                        //$tmp_profile = $_FILES['profile_pic']['tmp_name'];

                        $thumb_width = "150";

                        $large_image_location = $filepath.'temp/'.$_POST['profile_filename'];
                        $thumb_image_location = $filepath."thumb_".$_POST['profile_filename'];

                        $x1 = $_POST["x1"];
                        $y1 = $_POST["y1"];
                        $w = $_POST["w"];
                        $h = $_POST["h"];

                        $scale = $thumb_width/$w;
                        $cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);

//                            $profile_result = move_uploaded_file($tmp_profile, $filepath . $imagename_profile);
                        $profile_result = true;

                        //$profile_pic = $savepath . $imagename_profile;
                        $profile_pic = $savepath . "thumb_" . $_POST['profile_filename'];

                        if ($profile_result) {
                            $ar_messages[] = array('message' => 'Profile uploaded');

                            $writeConnection = $resource->getConnection('core_write');

                            $query = "SELECT user_id FROM rangoli_usermeta where user_id=$user_id and meta_key='cupp_upload_meta'";

                            $results = $readConnection->fetchAll($query);

                            if ($results && count($results) > 0) {
                                $query = "update rangoli_usermeta set meta_value='$profile_pic' where user_id=$user_id and meta_key='cupp_upload_meta'";
                                $result = $writeConnection->query($query);
                            } else {
                                $query = "insert into rangoli_usermeta(user_id, meta_key, meta_value) values($user_id, 'cupp_upload_meta','$profile_pic')";
                                $result = $writeConnection->query($query);
                            }

                            try{
                                unlink($large_image_location);
                            }
                            catch(Exception $ex){
                            }

                        } else {
                            $ar_messages[] = array('message' => 'There was an error in uploading profile picture');

                            $error = true;
                        }

                    } else {
                        $ar_messages[] = array('message' => 'Invalid profile picture, not an image');

                        $error = true;
                    }
                }
                else {
                    ;//$ar_messages[] = array('message' => 'Profile picture not provided');
                }

                if($error) {
                    foreach ($ar_messages as $message) {
                        echo $message['message'] . "<br/>";
                    }
                }
                else
                    echo "Profile updated successfully";
            }
        }
    }


    public function uploadimageAction(){

        $file_formats = array("jpg", "jpeg", "png", "gif", "bmp");

        $picture_type = $_POST['picture_type'];

        $filepath = Mage::getBaseDir() . "/rangoli/rangoli_profile_images/temp/";

        if (isset($_FILES['pic'])) {

            $name = $_FILES['pic']['name']; // filename to get file's extension
            $size = $_FILES['pic']['size'];

            if (strlen($name)) {
                $extension = substr($name, strrpos($name, '.') + 1);
                if (in_array($extension, $file_formats)) { // check it if it's a valid format or not
                    if ($size < (2048 * 1024)) { // check it if it's bigger than 2 mb or no
                        $imagename = md5(uniqid() . time()) . "." . $extension;
                        $tmp = $_FILES['pic']['tmp_name'];
                        if (move_uploaded_file($tmp, $filepath . $imagename)) {
                            echo $imagename;
                        } else {
                            echo "Could not move the file";
                        }
                    } else {
                        echo "Your image size is bigger than 2MB";
                    }
                } else {
                    echo "Invalid file format";
                }
            } else {
                echo "Please select image!";
            }
            exit();
        }
    }
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
    list($imagewidth, $imageheight, $imageType) = getimagesize($image);
    $imageType = image_type_to_mime_type($imageType);

    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
    switch($imageType) {
        case "image/gif":
            $source=imagecreatefromgif($image);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            $source=imagecreatefromjpeg($image);
            break;
        case "image/png":
        case "image/x-png":
            $source=imagecreatefrompng($image);
            break;
    }
    imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
    switch($imageType) {
        case "image/gif":
            imagegif($newImage,$thumb_image_name);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            imagejpeg($newImage,$thumb_image_name,100);
            break;
        case "image/png":
        case "image/x-png":
            imagepng($newImage,$thumb_image_name);
            break;
    }
    chmod($thumb_image_name, 0777);
    return $thumb_image_name;
}
?>