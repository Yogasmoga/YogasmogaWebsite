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
}
?>