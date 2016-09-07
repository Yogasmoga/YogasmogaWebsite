<?php
// Send email.
require_once 'app/Mage.php';
Mage::app();
umask(0);


$emails = array(  array(
    "name" =>"Brahmdev Sharma",
    'email' => 'Brahmdev.sharma@yogasmoga.com'
),
    array(
        "name" =>"Fahim Khan",
        'email' => 'fahim.khan@yogasmoga.com',
    ),
    array(
        "name" =>"Sanjay Kumar",
        'email' => 'sanjay.kumar@yogasmoga.com',
    ),
    array(
        "name" =>"Anuradha Tomar",
        'email' => 'anuradha.tomar@yogasmoga.com',
    ),
    array(
        "name" =>"Kritika Shahi",
        'email' => 'kritika.shahi@yogasmoga.com',
    ),
    array(
        "name" =>"Shivaji Chauhan",
        'email' => 'shivaji.chauhan@yogasmoga.com',
    )
);

$templateId = "share_smogi_bucks";

foreach($emails as $data){
    $name = $data['name'] ;
    $email = $data['email'];


    $emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateId);
    $storeId = Mage::app()->getStore()->getId();
    $vars = array( 'name'=>$name,'email'=> $email);
    if($email) {
        $emailTemplate->getProcessedTemplate($vars);
        $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
        $emailTemplate->send($email, $vars);
    }
}











