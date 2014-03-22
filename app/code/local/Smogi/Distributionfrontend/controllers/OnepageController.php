<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once("Mage/Checkout/controllers/OnepageController.php");

//class Mage_Checkout_OnepageController extends Mage_Checkout_Controller_Action
class Smogi_Distributionfrontend_OnepageController extends Mage_Checkout_OnepageController
{
    protected $_sectionUpdateFunctions = array(
        'payment-method'  => '_getPaymentMethodsHtml',
        'shipping-method' => '_getShippingMethodsHtml',
        'review'          => '_getReviewHtml',
    );

    /** @var Mage_Sales_Model_Order */
    protected $_order;

    /**
     * @return Mage_Checkout_OnepageController
     */
    public function preDispatch()
    {
        parent::preDispatch();
        $this->_preDispatchValidateCustomer();

        $checkoutSessionQuote = Mage::getSingleton('checkout/session')->getQuote();
        if ($checkoutSessionQuote->getIsMultiShipping()) {
            $checkoutSessionQuote->setIsMultiShipping(false);
            $checkoutSessionQuote->removeAllAddresses();
        }

        if(!$this->_canShowForUnregisteredUsers()){
            $this->norouteAction();
            $this->setFlag('',self::FLAG_NO_DISPATCH,true);
            return;
        }

        return $this;
    }

    protected function _ajaxRedirectResponse()
    {
        $this->getResponse()
            ->setHeader('HTTP/1.1', '403 Session Expired')
            ->setHeader('Login-Required', 'true')
            ->sendResponse();
        return $this;
    }

    /**
     * Validate ajax request and redirect on failure
     *
     * @return bool
     */
    protected function _expireAjax()
    {
        if (!$this->getOnepage()->getQuote()->hasItems()
            || $this->getOnepage()->getQuote()->getHasError()
            || $this->getOnepage()->getQuote()->getIsMultiShipping()) {
            $this->_ajaxRedirectResponse();
            return true;
        }
        $action = $this->getRequest()->getActionName();
        if (Mage::getSingleton('checkout/session')->getCartWasUpdated(true)
            && !in_array($action, array('index', 'progress'))) {
            $this->_ajaxRedirectResponse();
            return true;
        }

        return false;
    }

    /**
     * Get shipping method step html
     *
     * @return string
     */
    protected function _getShippingMethodsHtml()
    {
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('checkout_onepage_shippingmethod');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        return $output;
    }

    /**
     * Get payment method step html
     *
     * @return string
     */
    protected function _getPaymentMethodsHtml()
    {
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('checkout_onepage_paymentmethod');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        return $output;
    }

    protected function _getAdditionalHtml()
    {
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('checkout_onepage_additional');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        Mage::getSingleton('core/translate_inline')->processResponseBody($output);
        return $output;
    }

    /**
     * Get order review step html
     *
     * @return string
     */
    protected function _getReviewHtml()
    {
        return $this->getLayout()->getBlock('root')->toHtml();
    }

    /**
     * Get one page checkout model
     *
     * @return Mage_Checkout_Model_Type_Onepage
     */
    public function getOnepage()
    {
        return Mage::getSingleton('checkout/type_onepage');
    }

    /**
     * Checkout page
     */
    public function indexAction()
    {
        if (!Mage::helper('checkout')->canOnepageCheckout()) {
            Mage::getSingleton('checkout/session')->addError($this->__('The onepage checkout is disabled.'));
            $this->_redirect('checkout/cart');
            return;
        }
        $quote = $this->getOnepage()->getQuote();
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->_redirect('checkout/cart');
            return;
        }
        if (!$quote->validateMinimumAmount()) {
            $error = Mage::getStoreConfig('sales/minimum_order/error_message') ?
                Mage::getStoreConfig('sales/minimum_order/error_message') :
                Mage::helper('checkout')->__('Subtotal must exceed minimum order amount');

            Mage::getSingleton('checkout/session')->addError($error);
            $this->_redirect('checkout/cart');
            return;
        }
        Mage::getSingleton('checkout/session')->setCartWasUpdated(false);
        Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_secure'=>true)));
        $this->getOnepage()->initCheckout();
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Checkout'));
        $this->renderLayout();
    }

    /**
     * Checkout status block
     */
    public function progressAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $this->loadLayout(false);
        $this->renderLayout();
    }

    public function shippingMethodAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $this->loadLayout(false);
        $this->renderLayout();
    }

    public function reviewAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $this->loadLayout(false);
        $this->renderLayout();
    }

    /**
     * Order success action
     */
    public function successAction()
    {
        $session = $this->getOnepage()->getCheckout();
        if (!$session->getLastSuccessQuoteId()) {
            $this->_redirect('checkout/cart');
            return;
        }

        $lastQuoteId = $session->getLastQuoteId();
        $lastOrderId = $session->getLastOrderId();
        
        //Mage::log("Order #".$lastOrderId,null,'distribution.log');
        $order = Mage::getModel('sales/order')->load($lastOrderId);
        Mage::getModel('rewardpoints/stats')->ordercompleteoperations($order,'Frontend');
        /*
        Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '','Frontend', 'Source');
        try{
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $readresult=$write->query("Select base_discount_amount, rewardpoints_quantity, grand_total, coupon_code,store_id,entity_id,customer_id,increment_id from sales_flat_order where entity_id=".$lastOrderId);
            $row = $readresult->fetch();
            $smogiused = false;
			//Mage::log("Base Discount = ".$row['base_discount_amount'],null,'distribution.log');
            Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$row['base_discount_amount'], 'Base Discount Amount');    
            $couponcode = $row['coupon_code'];
            Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$couponcode, 'Coupon Code');
            //if($row['base_discount_amount'] < 0 && $row['grand_total'] > 0)
            if($row['base_discount_amount'] < 0 && $row['grand_total'] > 0 && $row['coupon_code'] == '')
            {
                $discount_amount = $row['base_discount_amount'] * -1;
				//Mage::log("Rewardpoints = ".$row['rewardpoints_quantity'],null,'distribution.log');
                Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$row['rewardpoints_quantity'], 'SMOGI Bucks Used');
                if($row['rewardpoints_quantity'] > 0)
                {
                    $this->smogi_setstartdate($order->getIncrementId());
                    $smogiused = true;
                    $this->smogi_storeExpiryDate($row);
                }

                //Mage::log("Smogi used = $smogiused",null,'distribution.log');        
                $readresult=$write->query("Select entity_id from sales_flat_invoice where order_id=".$lastOrderId);
                $row = $readresult->fetch();
                if($row)
                    $invoiceid = $row['entity_id'];
                else{
                    $invoiceid = '';
                }
                $arrOrderItem = array();
                $readresult=$write->query("Select product_id, row_total_incl_tax, item_id from sales_flat_order_item where order_id=".$lastOrderId." and price > 0");
                while ($row = $readresult->fetch() ) {
                    $temp = array();
                    $temp['product_id'] = $row['product_id'];
                    $temp['price'] = $row['row_total_incl_tax'];
                    $temp['item_id'] = $row['item_id'];
                    $temp['exclude'] = 0;
                    if($smogiused)
                    {
                        $write1 = Mage::getSingleton('core/resource')->getConnection('core_write');
                        $readresult1=$write1->query("SELECT COUNT(*) AS cnt FROM catalog_category_product ccp, catalog_category_flat_store_1 ccfs WHERE ccp.product_id = ".$row['product_id']." AND ccfs.entity_id = ccp.category_id AND category_id IN (".Mage::getModel('core/variable')->loadByCode('nosmogicategories ')->getValue('plain').")");
                        //Mage::log("SELECT COUNT(*) AS cnt FROM catalog_category_product ccp, catalog_category_flat_store_1 ccfs WHERE ccp.product_id = ".$row['product_id']." AND ccfs.entity_id = ccp.category_id AND category_id IN (".Mage::getModel('core/variable')->loadByCode('nosmogicategories ')->getValue('plain').")",null,'distribution.log');
                        $row1 = $readresult1->fetch();
                        if($row1['cnt'] > 0)
                        {
                            $temp['exclude'] = 1;
                            Mage::log("Excluded = ".$row['product_id'],null,'distribution.log');
                            Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$row['product_id'], 'Excluding Product ID for distribution');            
                        }
                    }
                    array_push($arrOrderItem, $temp);
                }
                $total = 0;
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    if($arrOrderItem[$i]['exclude'] == 0)
                        $total += $arrOrderItem[$i]['price'];
                }
				//Mage::log("Total Calculatable = ".$total,null,'distribution.log');
                Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$total, 'Total Amount of products applicable for discount.');
                $temp = 0;
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    if($arrOrderItem[$i]['exclude'] == 1)
                    {
                        $arrOrderItem[$i]['price'] = 0;    
                    }
                    else
                    {
                        if($couponcode == '')
                        {
                            $percent = round((($arrOrderItem[$i]['price'] / $total) * 100), 2);
                            $discount = round(($discount_amount * $percent) / 100);    
                        }
                        else
                        {
                            $percent = ($arrOrderItem[$i]['price'] / $total) * 100;
                            $discount = round((($discount_amount * $percent) / 100), 2);
                            Mage::log($arrOrderItem[$i]['product_id']." - ".$percent."% - ".$discount,null,'distribution.log');
                        }
                        $temp += $discount;
                        $arrOrderItem[$i]['price'] = $discount;   
                    }
                    //Mage::log($arrOrderItem[$i]['price']."  ".$arrOrderItem[$i]['product_id'] ,null,'distribution.log');
                    Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'New Discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                }
                Mage::log($temp."   ".$discount_amount,null,'distribution.log');    
                Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$temp, 'Sum of all allocated discounts');
                if($temp < $discount_amount)
                {
                    for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
                    {
                        if($arrOrderItem[$i]['exclude'] == 0)
                        {
                            $arrOrderItem[$i]['price'] += ($discount_amount - $temp);
                            Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is less than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                            break;
                        }
                        //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
                    }

                }
                if($temp > $discount_amount)
                {
                    for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
                    {
                        if($arrOrderItem[$i]['exclude'] == 0)
                        {
                            $arrOrderItem[$i]['price'] -= ($temp - $discount_amount);
                            Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is more than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                            break;
                        }
                        //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
                    }

                }
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    //$readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and product_id=".$arrOrderItem[$i]['product_id']);
                    $readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and item_id=".$arrOrderItem[$i]['item_id']);
                    if($invoiceid !='')
                    $readresult=$write->query("Update sales_flat_invoice_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price']." where parent_id=".$invoiceid." and order_item_id=".$arrOrderItem[$i]['item_id']);
                }
                //Mage::log($temp."   ".$discount_amount,null,'distribution.log');
            }
            else
            {
                Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '','Reward Points is not used hence exiting.', 'EXIT');
            }
            $readresult=$write->query("SELECT COUNT(item_id) AS cnt FROM sales_flat_order_item WHERE order_id=".$lastOrderId." AND qty_backordered>0");
            $row = $readresult->fetch();
            
            if($row['cnt'] > 0)
            {
               // $order = Mage::getModel('sales/order')->load($lastOrderId);
                $order->addStatusHistoryComment("This order contains Pre-Ordered items.");
                $order->save();   
            }
            
        }
        catch(Exception $e)
        {
            //Mage::log("Error Occured".$e->getMessage(),null,'distribution.log');
            Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'discount distribution', '',$e->getMessage(), 'ERROR');
        }
        */
        
        $lastRecurringProfiles = $session->getLastRecurringProfileIds();
        if (!$lastQuoteId || (!$lastOrderId && empty($lastRecurringProfiles))) {
            $this->_redirect('checkout/cart');
            return;
        }

        $session->clear();
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($lastOrderId)));
        $this->renderLayout();
    }
    
    public function smogi_setstartdate($incrementid)
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT * FROM rewardpoints_account WHERE order_id = '".$incrementid."' and date_start is null order by rewardpoints_account_id desc limit 1");
        $row = $readresult->fetch();
        $write->query("Update rewardpoints_account set date_start='".date('Y-m-d')."' where rewardpoints_account_id=".$row['rewardpoints_account_id']);
        Mage::getModel('rewardpoints/stats')->orderLog($incrementid, 'smogi used point date', '',$row['rewardpoints_account_id'], 'Setting date for used smogi points = '.date('Y-m-d'));
    }

    public function smogi_storeExpiryDate($orderinfo)
    {
        $smogi_balance = Mage::getModel('rewardpoints/stats')->getPointsCurrent($orderinfo['customer_id'], $orderinfo['store_id'], null, true, true);
        Mage::log(json_encode($smogi_balance),null,'smogi_balance.log');
        //Mage::getModel('rewardpoints/stats')->orderLog($orderinfo['increment_id'], 'smogi expiry date', '',json_encode($smogi_balance), 'Current SMOGI Balance');
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $arrEarnedPoints = $smogi_balance['history'];
        $temp = $orderinfo['rewardpoints_quantity'];
        $date_end = array();
        foreach($arrEarnedPoints as $key => $value)
        {
            $date_end[$key] = $value['date_end'];
        }
        array_multisort($date_end, SORT_ASC, $arrEarnedPoints);
        Mage::log(json_encode($arrEarnedPoints),null,'smogi_balance1.log');
        foreach($arrEarnedPoints as $key => $value)
        {
            if($arrEarnedPoints[$key]['points_current'] <= 0)
                continue;
            if((strtotime($arrEarnedPoints[$key]['date_end']) > strtotime(date('Y-m-d'))) && ($arrEarnedPoints[$key]['balance'] > 0))
            {
                if($arrEarnedPoints[$key]['balance'] >= $temp)
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$temp.",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp = 0;
                }
                else
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$arrEarnedPoints[$key]['balance'].",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp -= $arrEarnedPoints[$key]['balance'];
                }
                if($temp <= 0)
                    break;
            }
        }
    }
    
    public function smogi_storeExpiryDate_old1($orderinfo)
    {
        $smogi_balance = Mage::getModel('rewardpoints/stats')->getPointsCurrent_excludelast($orderinfo['customer_id'], $orderinfo['store_id'], null, true);
        Mage::log(json_encode($smogi_balance),null,'smogi_balance.log');
        //Mage::getModel('rewardpoints/stats')->orderLog($orderinfo['increment_id'], 'smogi expiry date', '',json_encode($smogi_balance), 'Current SMOGI Balance');
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $arrEarnedPoints = $smogi_balance['history'];
        $temp = $orderinfo['rewardpoints_quantity'];
        foreach($arrEarnedPoints as $key => $value)
        {
            if($arrEarnedPoints[$key]['points_current'] <= 0)
                continue;
            if((strtotime($arrEarnedPoints[$key]['date_end']) > strtotime(date('Y-m-d'))) && ($arrEarnedPoints[$key]['balance'] > 0))
            {
                if($arrEarnedPoints[$key]['balance'] >= $temp)
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$temp.",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp = 0;
                }
                else
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$arrEarnedPoints[$key]['balance'].",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp -= $arrEarnedPoints[$key]['balance'];
                }
                if($temp <= 0)
                    break;
            }
        }
    }

    public function smogi_storeExpiryDateold($orderinfo)
    {
        $smogi_balance = Mage::getModel('rewardpoints/stats')->getPointsCurrent($orderinfo['customer_id'], $orderinfo['store_id'], null, true);
        Mage::log(json_encode($smogi_balance),null,'smogi_balance.log');
        //Mage::getModel('rewardpoints/stats')->orderLog($orderinfo['increment_id'], 'smogi expiry date', '',json_encode($smogi_balance), 'Current SMOGI Balance');
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $arrEarnedPoints = $smogi_balance['history'];
        $temp = $orderinfo['rewardpoints_quantity'];
        foreach($arrEarnedPoints as $key => $value)
        {
            if($arrEarnedPoints[$key]['points_current'] <= 0)
                continue;
            if((strtotime($arrEarnedPoints[$key]['date_end']) > strtotime(date('Y-m-d'))) && (($arrEarnedPoints[$key]['points_current'] - $arrEarnedPoints[$key]['balance']) > 0))
            {
                if(($arrEarnedPoints[$key]['points_current'] - $arrEarnedPoints[$key]['balance']) >= $temp)
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$temp.",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp = 0;
                }
                else
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".($arrEarnedPoints[$key]['points_current'] - $arrEarnedPoints[$key]['balance']).",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp -= $arrEarnedPoints[$key]['points_current'] - $arrEarnedPoints[$key]['balance'];
                }
                if($temp <= 0)
                    break;
            }
        }
    }

    public function failureAction()
    {
        $lastQuoteId = $this->getOnepage()->getCheckout()->getLastQuoteId();
        $lastOrderId = $this->getOnepage()->getCheckout()->getLastOrderId();

        if (!$lastQuoteId || !$lastOrderId) {
            $this->_redirect('checkout/cart');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }


    public function getAdditionalAction()
    {
        $this->getResponse()->setBody($this->_getAdditionalHtml());
    }

    /**
     * Address JSON
     */
    public function getAddressAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $addressId = $this->getRequest()->getParam('address', false);
        if ($addressId) {
            $address = $this->getOnepage()->getAddress($addressId);

            if (Mage::getSingleton('customer/session')->getCustomer()->getId() == $address->getCustomerId()) {
                $this->getResponse()->setHeader('Content-type', 'application/x-json');
                $this->getResponse()->setBody($address->toJson());
            } else {
                $this->getResponse()->setHeader('HTTP/1.1','403 Forbidden');
            }
        }
    }

    /**
     * Save checkout method
     */
    public function saveMethodAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getPost('method');
            $result = $this->getOnepage()->saveCheckoutMethod($method);
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * save checkout billing address
     */
    public function saveBillingAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
//            $postData = $this->getRequest()->getPost('billing', array());
//            $data = $this->_filterPostData($postData);
            $data = $this->getRequest()->getPost('billing', array());
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

            if (isset($data['email'])) {
                $data['email'] = trim($data['email']);
            }
            $result = $this->getOnepage()->saveBilling($data, $customerAddressId);

            if (!isset($result['error'])) {
                /* check quote for virtual */
                if ($this->getOnepage()->getQuote()->isVirtual()) {
                    $result['goto_section'] = 'payment';
                    $result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
                    );
                } elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
                    $result['goto_section'] = 'shipping_method';
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml()
                    );

                    $result['allow_sections'] = array('shipping');
                    $result['duplicateBillingInfo'] = 'true';
                } else {
                    $result['goto_section'] = 'shipping';
                }
            }

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * Shipping address save action
     */
    public function saveShippingAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping', array());
            $customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
            $result = $this->getOnepage()->saveShipping($data, $customerAddressId);

            if (!isset($result['error'])) {
                $result['goto_section'] = 'shipping_method';
                $result['update_section'] = array(
                    'name' => 'shipping-method',
                    'html' => $this->_getShippingMethodsHtml()
                );
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * Shipping method save action
     */
    public function saveShippingMethodAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping_method', '');
            $result = $this->getOnepage()->saveShippingMethod($data);
            /*
            $result will have erro data if shipping method is empty
            */
            if(!$result) {
                Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
                        array('request'=>$this->getRequest(),
                            'quote'=>$this->getOnepage()->getQuote()));
                $this->getOnepage()->getQuote()->collectTotals();
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

                $result['goto_section'] = 'payment';
                $result['update_section'] = array(
                    'name' => 'payment-method',
                    'html' => $this->_getPaymentMethodsHtml()
                );
            }
            $this->getOnepage()->getQuote()->collectTotals()->save();
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * Save payment ajax action
     *
     * Sets either redirect or a JSON response
     */
    public function savePaymentAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        try {
            if (!$this->getRequest()->isPost()) {
                $this->_ajaxRedirectResponse();
                return;
            }

            // set payment to quote
            $result = array();
            $data = $this->getRequest()->getPost('payment', array());
            $result = $this->getOnepage()->savePayment($data);
            
            // get section and redirect data
            $redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();
            if (empty($result['error']) && !$redirectUrl) {
                $this->loadLayout('checkout_onepage_review');
                $result['goto_section'] = 'review';
                $result['update_section'] = array(
                    'name' => 'review',
                    'html' => $this->_getReviewHtml()
                );
            }
            if ($redirectUrl) {
                $result['redirect'] = $redirectUrl;
            }
        } catch (Mage_Payment_Exception $e) {
            if ($e->getFields()) {
                $result['fields'] = $e->getFields();
            }
            $result['error'] = $e->getMessage();    
        } catch (Mage_Core_Exception $e) {
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            Mage::logException($e);
            $result['error'] = $this->__('Unable to set Payment Method.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * Get Order by quoteId
     *
     * @return Mage_Sales_Model_Order
     */
    protected function _getOrder()
    {
        if (is_null($this->_order)) {
            $this->_order = Mage::getModel('sales/order')->load($this->getOnepage()->getQuote()->getId(), 'quote_id');
            if (!$this->_order->getId()) {
                throw new Mage_Payment_Model_Info_Exception(Mage::helper('core')->__("Can not create invoice. Order was not found."));
            }
        }
        return $this->_order;
    }

    /**
     * Create invoice
     *
     * @return Mage_Sales_Model_Order_Invoice
     */
    protected function _initInvoice()
    {
        $items = array();
        foreach ($this->_getOrder()->getAllItems() as $item) {
            $items[$item->getId()] = $item->getQtyOrdered();
        }
        /* @var $invoice Mage_Sales_Model_Service_Order */
        $invoice = Mage::getModel('sales/service_order', $this->_getOrder())->prepareInvoice($items);
        $invoice->setEmailSent(true)->register();

        Mage::register('current_invoice', $invoice);
        return $invoice;
    }

    /**
     * Create order action
     */
    public function saveOrderAction()
    {
        if ($this->_expireAjax()) {
            return;
        }

        $result = array();
        try {
            if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    $result['success'] = false;
                    $result['error'] = true;
                    $result['error_messages'] = $this->__('Please agree to all the terms and conditions before placing the order.');
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }
            }
            if ($data = $this->getRequest()->getPost('payment', false)) {
                $this->getOnepage()->getQuote()->getPayment()->importData($data);
            }
            $this->getOnepage()->saveOrder();

            $redirectUrl = $this->getOnepage()->getCheckout()->getRedirectUrl();
            $result['success'] = true;
            $result['error']   = false;
        } catch (Mage_Payment_Model_Info_Exception $e) {
            $message = $e->getMessage();
            if( !empty($message) ) {
                $result['error_messages'] = $message;
            }
            $result['goto_section'] = 'payment';
            $result['update_section'] = array(
                'name' => 'payment-method',
                'html' => $this->_getPaymentMethodsHtml()
            );
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();

            if ($gotoSection = $this->getOnepage()->getCheckout()->getGotoSection()) {
                $result['goto_section'] = $gotoSection;
                $this->getOnepage()->getCheckout()->setGotoSection(null);
            }

            if ($updateSection = $this->getOnepage()->getCheckout()->getUpdateSection()) {
                if (isset($this->_sectionUpdateFunctions[$updateSection])) {
                    $updateSectionFunction = $this->_sectionUpdateFunctions[$updateSection];
                    $result['update_section'] = array(
                        'name' => $updateSection,
                        'html' => $this->$updateSectionFunction()
                    );
                }
                $this->getOnepage()->getCheckout()->setUpdateSection(null);
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success']  = false;
            $result['error']    = true;
            $result['error_messages'] = $this->__('There was an error processing your order. Please contact us or try again later.');
        }
        $this->getOnepage()->getQuote()->save();
        /**
         * when there is redirect to third party, we don't want to save order yet.
         * we will save the order in return action.
         */
        if (isset($redirectUrl)) {
            $result['redirect'] = $redirectUrl;
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('dob'));
        return $data;
    }

    /**
     * Check can page show for unregistered users
     *
     * @return boolean
     */
    protected function _canShowForUnregisteredUsers()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn()
            || $this->getRequest()->getActionName() == 'index'
            || Mage::helper('checkout')->isAllowedGuestCheckout($this->getOnepage()->getQuote())
            || !Mage::helper('checkout')->isCustomerMustBeLogged();
    }
}


