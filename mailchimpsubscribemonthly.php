<?php
require 'app/Mage.php';
$app = Mage::app('');
umask(0);

$resource = Mage::getSingleton('core/resource');
$readConnection = $resource->getConnection('core_read');

$date_to_start = '2015-08-01';
$date_to_end = '2015-08-31';

echo "Between " . $date_to_start . " and " . $date_to_end . "<br/><br/>";

$collection = Mage::getModel('customer/customer')->getCollection()
    ->addAttributeToSelect('entity_id')
    ->addAttributeToSelect('firstname')
    ->addAttributeToSelect('lastname')
    ->addAttributeToSelect('email')
    ->addAttributeToFilter('created_at', array('gteq' => $date_to_start . ' 00:00:01'))
    ->addAttributeToFilter('created_at', array('lteq' => $date_to_end . ' 23:59:59'));

if($collection && count($collection)==0){
    echo "No records found";
    return;
}
else
    echo count($collection) . " records found<br/><br/>";

$unsubscribeCount = 0;

foreach ($collection as $item) {
    $row = $item->getData();

    $email = $row['email'];

    $query = "select email from unsubscribed_customers where email='$email'";
    $rows = $readConnection->fetchAll($query);

    if(isset($rows) && count($rows)>0) {
        ++$unsubscribeCount;
        continue;
    }

    unset($rows);

    $customerId = $row['entity_id'];

    $customer = Mage::getModel('customer/customer')->load($customerId);

    $gender = $customer->getGender();

    $customerAddress = null;

    foreach ($customer->getAddresses() as $address) {
        $customerAddress = $address->toArray();
        break;
    }

    $country = "";
    $state = "";
    if($customerAddress){
        $country = Mage::app()->getLocale()->getCountryTranslation($customerAddress['country_id']);
        $state = $customerAddress['region'];
    }

    if(isset($gender) && strlen(trim($gender))>0){
        if($gender=="1")
            $gender = "MALE";
        else
            $gender = "FEMALE";
    }
    else
        $gender = '';

    $batch[] = array(
        'EMAIL' => $row['email'],
        'FNAME' => $row['firstname'],
        'LNAME' => $row['lastname'],
        'STATE' => $state,
        'COUNTRY' => $country,
        'GENDER' => $gender
    );
}

echo $unsubscribeCount . " unsubscribed <hr/>";

echo "<pre>";
print_r($batch);
echo "</pre>";
?>