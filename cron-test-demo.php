<?php
// Send email.
require_once 'app/Mage.php';
Mage::app();
umask(0);

$email = 'fahim.khan@yogasmoga.com';
$templateId = "share_smogi_bucks";

$emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateId);
$storeId = Mage::app()->getStore()->getId();
$vars = array( 'email'=> $email);

$emailTemplate->getProcessedTemplate($vars);
$emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
$emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
$emailTemplate->send($email, $vars);

