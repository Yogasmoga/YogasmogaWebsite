<?php

class Ysindia_Emailjourney_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $templates = array(29,30,31,32,33,34);

        $date_to_look_start = date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d'))));
        $date_to_look_end = date('Y-m-d');
        $storeId = Mage::app()->getStore()->getStoreId();
        echo $date_to_look_start . " , " . $date_to_look_end . "<br/><br/>";

        $collection = Mage::getModel('customer/customer')->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSelect('gender')
            ->addAttributeToSelect('email')
            ->addAttributeToFilter('created_at', array('gteq' => $date_to_look_start . ' 00:00:01'))
            ->addAttributeToFilter('created_at', array('lteq' => $date_to_look_end . ' 23:59:59'));

        if ($collection && count($collection) == 0) {
            return;
        }

        $customers = array();

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

            $customers[] = array(
                'CUSTOMER_ID' => $row['entity_id'],
                'EMAIL' => $row['email'],
                'FNAME' => $row['firstname'],
                'LNAME' => $row['lastname'],
                'STATE' => $state,
                'COUNTRY' => $country,
                'GENDER' => $row['gender'],
                'CREATE_DATE' => $row['created_at']
            );
        }

        //=================================================

        echo "Store email = " . Mage::getStoreConfig('trans_email/ident_general/email', $storeId) . "<br/><br/>";

        echo "Store name = " . Mage::getStoreConfig('trans_email/ident_general/name', $storeId) . "<br/><br/>";

        foreach ($customers as $customer) {

            $customerId = $customer['CUSTOMER_ID'];
            $customerEmail = $customer['EMAIL'];
            $customerName = $customer['FNAME'] . ' ' . $customer['LNAME'];
            $createDate = $customer['CREATE_DATE'];

            $now = time();
            $your_date = strtotime($createDate);
            $datediff = $now - $your_date;
            $days = floor($datediff / (60 * 60 * 24));

            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');

            $query = "SELECT id from email_journey where customer_id=$customerId and email_number=$days";

            $rows = $readConnection->fetchAll($query);

            if ($rows && count($rows) > 0) {
                continue;
            }

            $templateId = $templates[$days];

            $emailTemplate = Mage::getModel('core/email_template')->load($templateId);
            $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
            $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));

            $vars = array();

            $processed = $emailTemplate->getProcessedTemplate($vars);

            $emailTemplate->send($customerEmail, $customerName, $vars);

            $model = Mage::getModel('journey/journey');
            $model->setCustomerId($customerId);
            $model->setEmailNumber($days);
            $model->setTemplateId($templateId);
            $model->setCurrentDate(date('Y-m-d h:i:s'));
            $model->save();


        }

    }
}

?>