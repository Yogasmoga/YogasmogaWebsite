<?php

class Ysindia_Emailjourney_UnsubscribeController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $customerId = $this->getRequest()->getParam('id');

        if (isset($customerId) && strlen($customerId)>0) {

            $customer = Mage::getModel('customer/customer')->load($customerId);

            if (isset($customer)) {

                $this->loadLayout();

                $resource = Mage::getSingleton('core/resource');

                $readConnection = $resource->getConnection('core_read');
                $query = "SELECT id FROM unsubscribed_customers where customer_id=$customerId";

                $row = $readConnection->fetchAll($query);

                if ($row) {
                    ?>
                    <div style="font:30px/36px ITCAvantGardeProBk;color:#555555;width:100%;text-align:center; margin-top: 69px;  padding-top: 90px;  box-sizing: border-box;"
                         class="unsubscribe-page">
                        You are already unsubscribed.<br/>However, you can always contact us<br/>at
                        <a href="mailto:hello@yogasmoga.com" style="color:#666;text-decoration:none">hello@yogasmoga.com</a> to be included<br/>back into our mailing list. <br/><br/>

                        Have a breezy day.


                    </div>

                <?php
                } else {
                    $writeConnection = $resource->getConnection('core_write');

                    $created_at = date('Y-m-d h:i:s');

                    $query = "insert into unsubscribed_customers(customer_id, email, created_at) values($customerId, '" . $customer->getEmail() . "','$created_at')";

                    $result = $writeConnection->query($query);
                    ?>
                    <div style="font:30px/36px ITCAvantGardeProBk;color:#555555;width:100%;height:381px;text-align:center;  padding-top: 90px;  box-sizing: border-box;"
                         class="unsubscribe-page">
                        We're sad to see one of our SMOGIs leave us.<br/>However, you can always contact us<br/>at
                        <a href="mailto:hello@yogasmoga.com" style="color:#666;text-decoration:none">hello@yogasmoga.com</a> to be included<br/>back into our mailing list. <br/><br/>

                        Have a breezy day.


                    </div>
                <?php
                }

                $this->renderLayout();
            }
            else
                return $this->_redirect('/');
        }
        else
            return $this->_redirect('/');
    }
}

?>