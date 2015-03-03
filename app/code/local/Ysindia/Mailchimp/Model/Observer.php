<?php
class Ys_Mailchimp_Model_Observer{

    public function sync()
    {
        $myfile = fopen("mailchimp_list.txt", "r") or die("Unable to open file!");
        $apikey_listid = trim(fgets($myfile));
        fclose($myfile);

        $ar = explode(",", $apikey_listid);

        $api_key = trim($ar[0]);
        $list_id = trim($ar[1]);

        $correct = isset($api_key) && isset($list_id) && (strlen($list_id) > 0) && (strlen($api_key) > 0);

        if ($correct) {
            $date_to_look = date('Y-m-d');

            echo "Current date = " . $date_to_look . "<br/><br/>";

            $collection = Mage::getModel('customer/customer')->getCollection()
                ->addAttributeToSelect('entity_id')
                ->addAttributeToSelect('firstname')
                ->addAttributeToSelect('lastname')
                ->addAttributeToSelect('email')
                ->addAttributeToFilter('created_at', array('gteq' => $date_to_look . ' 00:00:01'))
                ->addAttributeToFilter('created_at', array('lteq' => $date_to_look . ' 23:59:59'));

            if ($collection && count($collection) == 0) {
                echo "No records found";
                return;
            }

            foreach ($collection as $item) {
                $row = $item->getData();

                $customerId = $row['entity_id'];

                $customer = Mage::getModel('customer/customer')->load($customerId);

                $customerAddress = null;

                foreach ($customer->getAddresses() as $address) {
                    $customerAddress = $address->toArray();
                    break;
                }

                $country = "";
                $state = "";
                if ($customerAddress) {
                    $country = Mage::app()->getLocale()->getCountryTranslation($customerAddress['country_id']);
                    $state = $customerAddress['region'];
                }

                $batch[] = array(
                    'EMAIL' => $row['email'],
                    'FNAME' => $row['firstname'],
                    'LNAME' => $row['lastname'],
                    'STATE' => $state,
                    'COUNTRY' => $country
                );
            }

            include("mailchimpapi/Drewm/MailChimp.php");

            $mailChimp = new Drewm\MailChimp($api_key);

            $i = 0;
            foreach ($batch as $single) {

                ++$i;

                $email = $single["EMAIL"];
                $fname = $single["FNAME"];
                $lname = $single["LNAME"];
                $state = $single["STATE"];
                $country = $single["COUNTRY"];

                $result = $mailChimp->call('lists/member-info', array(
                    'id' => $list_id,
                    'emails' => array(0 => array('email' => $email))
                ));

                if (isset($result["data"][0]["status"]) && $result["data"][0]["status"] == "unsubscribed") {
                    Mage::log($result["data"][0]["email"] . " is " . $result["data"][0]["status"] . ", not changing values");
                } else if (isset($result["data"][0]["status"]) && $result["data"][0]["status"] == "subscribed") {
                    Mage::log($result["data"][0]["email"] . " is " . $result["data"][0]["status"] . ", not changing values");
                } else {
                    $result = $mailChimp->call('lists/subscribe', array(
                        'id' => $list_id,
                        'email' => array('email' => $email),
                        'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname, 'STATE' => $state, 'COUNTRY' => $country),
                        'double_optin' => false,
                        'update_existing' => true,
                        'replace_interests' => false,
                        'send_welcome' => false,
                    ));
                }
            }

            Mage::log("Mailchimp Synchronize Task Completed at : " . date("Y-m-d h:i:s"));
        }
    }
}
?>
