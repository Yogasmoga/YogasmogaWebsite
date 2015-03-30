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
echo "count = " . count($results);
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
echo "description updated";
                $filepath = Mage::getBaseDir() . "/rangoli/rangoli_profile_images/";
                $savepath = Mage::getBaseUrl() . "/rangoli/rangoli_profile_images/";

                $name_banner = $_FILES['banner_pic']['name']; // filename to get file's extension
                $size_banner = $_FILES['banner_pic']['size'];

                $name_profile = $_FILES['profile_pic']['name']; // filename to get file's extension
                $size_profile = $_FILES['profile_pic']['size'];


                $file_formats = array("jpg", "png", "gif", "bmp");

                $ar_messages = array();
                $error = false;

                if (strlen($name_banner) > 0) {

                    $extension_banner = pathinfo($name_banner, PATHINFO_EXTENSION);

                    if (in_array($extension_banner, $file_formats)) { // check it if it's a valid format or not
                        if ($size_banner < (2048 * 1024)) { // check it if it's bigger than 2 mb or no

                            $imagename_banner = md5(uniqid() . time()) . "." . $extension_banner;
                            $tmp_banner = $_FILES['banner_pic']['tmp_name'];

                            $banner_result = move_uploaded_file($tmp_banner, $filepath . $imagename_banner);

                            $banner_pic = $savepath . $imagename_banner;

                            if ($banner_result) {
                                $ar_messages[] = array('message' => 'Banner uploaded');

                                $writeConnection = $resource->getConnection('core_write');

                                $query = "SELECT user_id FROM rangoli_usermeta where user_id=$user_id and meta_key='author_profile_picture'";

                                $results = $readConnection->fetchAll($query);

                                if ($results && count($results) > 0) {
                                    $query = "update rangoli_usermeta set meta_value='$banner_pic' where user_id=$user_id and meta_key='author_profile_picture'";
                                    $result = $writeConnection->query($query);
                                } else {
                                    $query = "insert into rangoli_usermeta(user_id, meta_key, meta_value) values($user_id, 'author_profile_picture','$banner_pic')";
                                    $result = $writeConnection->query($query);
                                }

                            } else {
                                $ar_messages[] = array('message' => 'There was some error in uploading the banner');

                                $error = true;
                            }
                        } else {
                            $ar_messages[] = array('message' => 'Banner picture greater than 2 mb');

                            $error = true;
                        }
                    } else {
                        $ar_messages[] = array('message' => 'Invalid banner picture, not an image');

                        $error = true;
                    }
                }
                else {
                    $ar_messages[] = array('message' => 'Banner picture not provided');
                }

                if (strlen($name_profile) > 0) {

                    $extension_profile = pathinfo($name_profile, PATHINFO_EXTENSION);

                    if (in_array($extension_profile, $file_formats)) { // check it if it's a valid format or not
                        if ($size_profile < (2048 * 1024)) { // check it if it's bigger than 2 mb or no

                            $imagename_profile = md5(uniqid() . time()) . "." . $extension_profile;
                            $tmp_profile = $_FILES['profile_pic']['tmp_name'];

                            $profile_result = move_uploaded_file($tmp_profile, $filepath . $imagename_profile);

                            $profile_pic = $savepath . $imagename_profile;

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

                            } else {
                                $ar_messages[] = array('message' => 'There was an error in uploading profile picture');

                                $error = true;
                            }
                        } else {
                            $ar_messages[] = array('message' => 'Profile picture greater than 2 mb');

                            $error = true;
                        }

                    } else {
                        $ar_messages[] = array('message' => 'Invalid profile picture, not an image');

                        $error = true;
                    }
                }
                else {
                    $ar_messages[] = array('message' => 'Profile picture not provided');
                }

                if ($ar_messages && count($ar_messages) > 0) {

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
    }
}

?>