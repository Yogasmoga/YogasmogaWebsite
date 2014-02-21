<?php
class Ankitsinghania_Smogiexpirationnotifier_Model_Notify extends Mage_Core_Model_Abstract {
    protected function _construct()
    {
        $this->_init('smogiexpirationnotifier/notify');
        parent::_construct();
    }
    public function notify(){
        Mage::log("i ran", null, "smoginotifier.log");
    }
    
    public function getCustomerslist()
    {
        $allStores = Mage::app()->getStores();
        
		$csv[0] = array('Name', 'Email', 'Bucks', 'Valid_Upto');	

        foreach ($allStores as $_eachStoreId => $val)
        {
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            $date = $this->getRequest()->getParam('date');
            $datearr = split("-", $date);
            //print_r($datearr);
            if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
            {
                echo "Invalid Date";
                return;
            }
			$requireddate = date('Y-m-d',strtotime($datearr[2].'-'.$datearr[0].'-'.$datearr[1]));
            $currentdate =  date('Y-m-d');
			$diff = abs(strtotime($requireddate) - strtotime($currentdate));

			//$years = floor($diff / (365*60*60*24));
			//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$onedayless = date('Y-m-d', strtotime('-1 day', strtotime($requireddate)));
			$middle = strtotime($onedayless);
			$new_date = date('M j Y', $middle);
			

			
            if($days == 0)
            {
                continue;
            }
            $points = Mage::getModel('rewardpoints/stats')
                ->getResourceCollection()
               ->addFinishFilter($days)
                ->addValidPoints($store_id);

            if ($points->getSize()){
				$i=1;
                foreach ($points as $current_point){
                    $html .= "<tr>";
                    $customer_id = $current_point->getCustomerId();
                     $points = $current_point->getNbCredit();
                    if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
                        $points_received = Mage::getModel('rewardpoints/flatstats')->collectPointsCurrent($customer_id, $store_id);
                    } else {
                        $points_received = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id, $store_id);
                    }

                    //2. check if total points >= points available
                    $customer = Mage::getModel('customer/customer')->load($customer_id);
                    $customerName = $customer->getName();
                    $customerEmail = $customer->getEmail();
                    
					$csv[$i] = array($customerName, $customerEmail, $points, $new_date);
                    if ($points_received >= $points){
                        //3. send notification email
                    /*    $customer = Mage::getModel('customer/customer')->load($customer_id);
                        $customerName = $customer->getName();
                        $customerEmail = $customer->getEmail();
                        $html .= "<td>".$customer_id."</td>"."<td>".$customerName."</td>"."<td>".$customerEmail."</td></tr>";  */
                        //Mage::getModel('rewardpoints/stats')->sendNotification($customer, $store_id, $points, $days);
                        //Mage::log("Email sent to coustomer id:".$customer_id.",Points:".$points,null,"smogiexpireemail.log");
                    }
					$i++;
                }
            }

        }
         if($customerEmail == '')
			{
				echo 'No Record found for this date';
				return;
			}
		$fname = 'smogi_bucks_expiring_on'.$new_date;
		

		$baseDir = Mage::getBaseDir();
		$varDir = $baseDir.DS.'tempreports'.DS.$fname.'.csv';
		
		unlink($varDir);
		$fp = fopen($varDir, 'w');
		foreach ($csv as $fields) {
		fputcsv($fp, $fields);
		}

		fclose($fp);
		if(!file_exists($varDir))
		{
			echo 'Records are not found for this date';
		}
		else
		{
			
			Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".csv");
		}
		//file_put_contents('tempreports/expiringbucks/'.$fname.'.xls',$html);
    }    
    
    public function sendemail($recipient_name, $recipient_email, $bucks, $expiry_days)
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');
        //$template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        //$template = 1;
//        $template = Mage::getModel('core/email_template')->loadByCode('testemail');
        $mail_collection = Mage::getModel('core/email_template')->getCollection()->addFieldToFilter('template_code','testemail');
        $template_id = $mail_collection->getFirstItem()->getTemplate_id();
        
        $recipient = array(
            'email' => $recipient_email,
            'name'  => $recipient_name
        );
        $sender  = array(
            'name' => 'YOGASMOGA',
            'email' => 'hello@yogasmoga.com'
        );
        $email->setDesignConfig(array('area'=>'frontend', 'store'=> Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template_id,
                    $sender,
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'bucks'        => $bucks,
                        'days_to_expire' => $expiry_days
                    )
                );
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }
}
?>