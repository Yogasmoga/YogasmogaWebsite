<?php
class Mailchimp_Mod_Model_Observer{

    public function sync(){

		$myfile = fopen("mailchimp_list.txt", "r") or die("Unable to open file!");
		$apikey_listid = trim(fgets($myfile));
		fclose($myfile);

		$ar = explode(",", $apikey_listid);

		$api_key = trim($ar[0]);
		$list_id = trim($ar[1]);

		$correct = isset($api_key) && isset($list_id) && (strlen($list_id) > 0) && (strlen($api_key) > 0);

		if ($correct) {

			//ini_set('max_execution_time', 36000);
			//ini_set('memory_limit', '1024M');
			//require 'app/Mage.php';
			
			$app = Mage::app('');

			$collection = Mage::getModel('customer/customer')->getCollection()
				->addAttributeToSelect('firstname')
				->addAttributeToSelect('lastname')
				->addAttributeToSelect('email');

			foreach ($collection as $item) {
				$row = $item->getData();

				if(strstr( $row['email'], "example.com")>-1)
					;
				else
					$batch[] = array('EMAIL' => $row['email'], 'FNAME' => $row['firstname'], 'LNAME' => $row['lastname']);
			}

			include("mailchimpapi/Drewm/MailChimp.php");

			$mailChimp = new Drewm\MailChimp($api_key);

			$i = 0;
			foreach ($batch as $single) {

				++$i;

				$email = $single["EMAIL"];
				$fname = $single["FNAME"];
				$lname = $single["LNAME"];

				$result = $mailChimp->call('lists/subscribe', array(
					'id' => $list_id,
					'email' => array('email' => $email),
					'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname),
					'double_optin' => false,
					'update_existing' => true,
					'replace_interests' => false,
					'send_welcome' => false,
				));
			}

			Mage::log("Mailchimp Synchronize Task Completed at : " . date("Y-m-d h:i:s"));

		} else
			Mage::log("I guess api key or list id are invalid");
    }
}