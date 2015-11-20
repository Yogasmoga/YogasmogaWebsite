<?php
require_once 'app/Mage.php';
Mage::app();umask(0);

$cartHelper = Mage::helper('checkout/cart');
$items = $cartHelper->getCart()->getItems();        
foreach ($items as $item) 
{
   $itemId = $item->getItemId();
   $cartHelper->getCart()->removeItem($itemId)->save();
} 
?>