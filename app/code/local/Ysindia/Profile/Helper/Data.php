<?php
class Ysindia_Profile_Helper_Data extends Mage_Core_Helper_Abstract{

    public function getProfileDescription(){

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $query = "SELECT id,user_login FROM rangoli_users where user_email='" . $customer->getEmail() . "'";

            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');

            $results = $readConnection->fetchAll($query);

            if ($results && count($results) == 1) {
                $user_id = $results[0]["id"];

                $query = "select meta_value from rangoli_usermeta where user_id=$user_id and meta_key='description'";
                $results = $readConnection->fetchAll($query);

                if ($results && count($results) == 1) {
                    $description = $results[0]["meta_value"];

                    echo $description;
                }
                else{
                    echo "";
                }
            }
            else
                echo "Nothing";
        }
        else
            echo "not logged";
    }

    public function getProfilePicture(){

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $customer_id = $customer->getId();

            $query = "SELECT meta_value from rangoli_usermeta where meta_key='cupp_upload_meta' and user_id=(select user_id from rangoli_user_profiles where customer_id=$customer_id)";

            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');

            $results = $readConnection->fetchAll($query);

            if ($results && count($results) == 1)
                $profile_picture = $results[0]["meta_value"];
            else
                $profile_picture = Mage::getUrl("rangoli/wp-content/themes/rangoli/images/default.jpg", array('_secure' => true));

            return $profile_picture;
        }
        else
            return null;
    }

    public function getDisplayName(){

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $customer_id = $customer->getId();

            $query = "SELECT user_display_name from rangoli_user_profiles where customer_id=$customer_id";

            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');

            $results = $readConnection->fetchAll($query);

            $displayName = '';

            if ($results && count($results) == 1) {

                if(isset($results[0]["user_display_name"]))
                    $displayName = $results[0]["user_display_name"];
            }

            return $displayName;
        }
        else
            return '';
    }
}
?>