<?php
class Ankitsinghania_Abandonedcartreminder_Model_Notify extends Mage_Core_Model_Abstract {
    protected function _construct()
    {
        $this->_init('abandonedcartreminder/notify');
        parent::_construct();
    }
    public function remind(){
        echo "hello world";
        Mage::log("i ran", null, "abandonedcartreminder.log");
        //$this->getCustomerslist(20);
    }
    public function remindusers()
    {
        Mage::log("notifying users", null, "abandonedcartreminder.log");

        $serverType = Mage::getModel('core/variable')->loadByCode('server_type')->getValue('plain');

            $customerlist = $this->getabandonedlist();

            foreach($customerlist as $customer)
            {
                $notification_log = Mage::getModel('abandonedcartreminder/notify');
                $notification_log->setCustomer_email($customer['customer_email']);
                $notification_log->setCustomer_name($customer['customer_fistname']);
                $notification_log->setCustomer_name($customer['customer_lastname']);
                $notification_log->setCustomer_productname($customer['product_name']);
                $notification_log->setCustomer_productcolor($customer['product_color']);
                $notification_log->setCustomer_productsize($customer['product_size']);

//                if($serverType == 'production')
//                $notification_log->setEmail_status($this->sendemail($customer['customer_name'], $customer['customer_email'], $customer['bucks_expiring'], $notification_period));
                /*    else
                        $notification_log->setEmail_status($this->sendemail($customer['customer_name'], "ankit@mobikasa.com", $customer['bucks_expiring'], $notification_period));  */
                if($customer['customer_email']== "manish@mobikasa.com")
                    $notification_log->setEmail_status($this->sendemail($customer['customer_email'], $customer['customer_firstname'],$customer['customer_lastname'], $customer['product_name'], $customer['product_color'],$customer['product_size']));
                $notification_log->save();
            }
        }


    public function notifyusers()
    {
        Mage::log("notifying users", null, "smoginotifier.log");
        $notification_periods = array(3,30);
        $serverType = Mage::getModel('core/variable')->loadByCode('server_type')->getValue('plain');
        foreach($notification_periods as $notification_period)
        {
            $customerlist = $this->getabandonedlist($notification_period);
            $notify_date = date('Y-m-d');
            $bucks_expiration_date = date('Y-m-d', strtotime(" + ".$notification_period." days"));
            foreach($customerlist as $customer)
            {
                $notification_log = Mage::getModel('smogiexpirationnotifier/notify');
                $notification_log->setCustomer_id($customer['customer_id']);
                $notification_log->setCustomer_email($customer['customer_email']);
                $notification_log->setCustomer_name($customer['customer_name']);
                $notification_log->setBucks_expiring($customer['bucks_expiring']);
                $notification_log->setBucks_expiration_date($bucks_expiration_date);
                $notification_log->setNotify_date($notify_date);
                if($serverType == 'production')
				    $notification_log->setEmail_status($this->sendemail($customer['customer_name'], $customer['customer_email'], $customer['bucks_expiring'], $notification_period));
            /*    else
                    $notification_log->setEmail_status($this->sendemail($customer['customer_name'], "ankit@mobikasa.com", $customer['bucks_expiring'], $notification_period));  */
                $notification_log->setNotification_period($notification_period);
                $notification_log->save();
            }
        }
    }
    public function getabandonedlist()
    {
        $abandonedlist = array();
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readcolor = $write->query("SELECT eaov.value AS 'Attribute', eaov.option_id AS 'Value' FROM eav_attribute ea, eav_attribute_option eao,   eav_attribute_option_value eaov WHERE ea.attribute_id = eao.attribute_id AND eao.option_id = eaov.option_id AND eaov.store_id = 0
  AND ea.attribute_code='color'");
        $readcolor1 = $readcolor->fetchAll();
        $colorarray = array();
        for($i=0;$i<count($readcolor1);$i++)
        {
            $colorarray[$readcolor1[$i]['Attribute']] = $readcolor1[$i]['Value'];

        }

        //get product sizes
        $productallsizes = array();


        $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'size'); //here, "color" is the attribute_code
        $allOptions = $attribute->getSource()->getAllOptions(true, true);
        for($i=0;$i<count($allOptions);$i++)
        {
            $productsizearray[$allOptions[$i]['label']] = $allOptions[$i]['value'];
        }

        //
        $readresult=$write->query("SELECT customer_email , customer_firstname, customer_lastname ,GROUP_CONCAT(product_id) as product_id
  FROM sales_flat_quote, sales_flat_quote_item WHERE is_active = 1 AND customer_email IS NOT NULL
    AND items_count > 0 AND (SELECT is_active FROM customer_entity ce WHERE ce.entity_id = customer_id) = 1 AND sales_flat_quote_item.quote_id=sales_flat_quote.entity_id AND sales_flat_quote_item.product_type IN ('simple','giftcards')
 GROUP BY customer_email ORDER BY  sales_flat_quote.updated_at DESC");
        $html = '<table border="1"><tr><td>Email</td><td>First Name</td><td>Last Name</td> <td>Product Name</td><td>Color</td><td>Size</td></tr>';
        while ($row = $readresult->fetch() ) {

            $row['customer_email'];
            $row['customer_firstname'];
            $row['customer_lastname'];


            $product_ids = explode(",", $row['product_id']);

            foreach($product_ids as $id)
            {

                $productname = '';
                $_product = Mage::getModel('catalog/product')->load($id);
                //print_r($_product);die;
                $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($id);
                if (isset($parentIds[0])) {
                    $parentproduct = Mage::getModel('catalog/product')->load($parentIds[0]);
                    $productname = $parentproduct->getName();
                }else{
                    $productname = $_product->getName();
                }
                //echo $parentproduct->getUrlKey();
                //print_r($parentproduct);die;

                //$subhtml2 .= '<td>'.$_product->getName().'</td>';

                $pcolor = (int) $_product->getColor();
                $color = array_search($pcolor, $colorarray);
                $size = array_search($_product->getSize(), $productsizearray);

//                $abandonedlist1 =  array($row['customer_email'], $row['customer_firstname'] , $row['customer_lastname'],$productname, $color, $size  );
                $abandonedlist1 =  array("customer_email"=>$row['customer_email'], "customer_firstname"=>$row['customer_firstname'] ,"customer_lastname"=>$row['customer_lastname'],"product_name"=>$productname, "product_color"=>$color, "product_size"=> $size  );
                array_push($abandonedlist, $abandonedlist1);



            }



        }

        return $abandonedlist;

    }
    public function getCustomerslist($expiring_in_days)
    {
        $allStores = Mage::app()->getStores();	
        $customerlist = array();
        foreach ($allStores as $_eachStoreId => $val)
        {
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            $days = $expiring_in_days;
		/*	$points = Mage::getModel('rewardpoints/stats')
                        ->getResourceCollection()
                        ->addFinishFilter($days)
                        ->addValidPoints($store_id);
            if ($points->getSize()){
				foreach ($points as $current_point){
                    $customer_id = $current_point->getCustomerId();
                    $points = $current_point->getNbCredit();
                    $customer = Mage::getModel('customer/customer')->load($customer_id);
                    $customerName = $customer->getName();
                    $customerEmail = $customer->getEmail();
                    array_push($customerlist, array("customer_id" => $customer_id, "customer_email" => $customerEmail, "customer_name" => $customerName,"bucks_expiring" => $points));
                }
            }*/
            $resource = Mage::getSingleton('core/resource');
            //$writeConnection = $resource->getConnection('core_write');
            $readConnection = $resource->getConnection('core_write');
            $temp = $readConnection->query("Select entity_id from customer_entity where is_active=1");
            $date = date('Y-m-d');
            $dateAfter = date('Y-m-d', strtotime($date. ' + '.$days.' day'));
            while($customerId = $temp->fetch())
            {
                $customer = Mage::getModel('customer/customer')->load($customerId);
                $customerName = $customer->getName();
                $customerEmail = $customer->getEmail();
                $customer_id =  $customer->getId();
                //$expireSmogiBucks = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id) - Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id,$dateAfter);

                $afterSmogiArrray = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id,$dateAfter, true);
                $afterBalance = 0;

                foreach($afterSmogiArrray["history"] as $smogi1)
                {
                    if(strtotime($dateAfter)== strtotime($smogi1["date_end"]))
                    {
                        $afterBalance += $smogi1["balance"];

                    }
                }

                    $expireSmogiBucks = $afterBalance;
                    if($expireSmogiBucks > 0)
                    {
                        array_push($customerlist, array("customer_id" => $customer_id, "customer_email" => $customerEmail, "customer_name" => $customerName,"bucks_expiring" => $expireSmogiBucks));
                    }



            }

        }
        return $customerlist;
    }
    
    public function sendemail($recipient_email, $recipient_fistname,$recipient_lastname, $recipient_productname,$recipient_productcolor,$recipient_productsize )
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');

        $mail_collection = Mage::getModel('core/email_template')->getCollection()->addFieldToFilter('template_code','abandonedcart_notification_email');
        $template_id = $mail_collection->getFirstItem()->getTemplate_id();
        
        $recipient = array(
            'email' => $recipient_email,
            'name'  => $recipient_fistname
        );
        $sender  = array(
            'name' => 'YOGASMOGA',
            'email' => 'hello@yogasmoga.com'
        );
        $email->setDesignConfig(array('area'=>'frontend', 'store'=> Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template_id,
                    $sender,
                    $recipient_email,
                    $recipient_fistname,
                    $recipient_lastname,
                    $recipient_productname,
                    $recipient_productcolor,
                    $recipient_productsize

                    /*array(
                        'bucks'        => $bucks,
                        'days_to_expire' => $expiry_days
                    )*/
                );
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }
}
?>