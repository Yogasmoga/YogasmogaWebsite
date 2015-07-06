<?php

class Ysindia_Emailjourney_UnsubscribeController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $customerId = $this->getRequest()->getParam('id');

        if (isset($customerId) && strlen($customerId)>0) {

            $customer = Mage::getModel('customer/customer')->load($customerId);

            if (isset($customer)) {

                $resource = Mage::getSingleton('core/resource');

                $readConnection = $resource->getConnection('core_read');
                $query = "SELECT id FROM unsubscribed_customers where customer_id=$customerId";

                $row = $readConnection->fetchAll($query);

                if ($row) {
                    echo "<h2>You are already unsubscribed</h2>";
                } else {
                    $writeConnection = $resource->getConnection('core_write');

                    $created_at = date('Y-m-d h:i:s');

                    $query = "insert into unsubscribed_customers(customer_id, email, created_at) values($customerId, '" . $customer->getEmail() . "','$created_at')";

                    $result = $writeConnection->query($query);

                    echo "<h2>We are sad to see you go</h2>";
                    echo "<h4>You will not receive any more emails from us</h4>";
                }
            }
        }
        else
            return $this->_redirect('/');
    }
}

?>