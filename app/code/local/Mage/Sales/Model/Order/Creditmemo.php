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
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Order creditmemo model
 *
 * @method Mage_Sales_Model_Resource_Order_Creditmemo _getResource()
 * @method Mage_Sales_Model_Resource_Order_Creditmemo getResource()
 * @method int getStoreId()
 * @method Mage_Sales_Model_Order_Creditmemo setStoreId(int $value)
 * @method float getAdjustmentPositive()
 * @method float getBaseShippingTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseShippingTaxAmount(float $value)
 * @method float getStoreToOrderRate()
 * @method Mage_Sales_Model_Order_Creditmemo setStoreToOrderRate(float $value)
 * @method float getBaseDiscountAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseDiscountAmount(float $value)
 * @method float getBaseToOrderRate()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseToOrderRate(float $value)
 * @method float getGrandTotal()
 * @method Mage_Sales_Model_Order_Creditmemo setGrandTotal(float $value)
 * @method float getBaseAdjustmentNegative()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseAdjustmentNegative(float $value)
 * @method float getBaseSubtotalInclTax()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseSubtotalInclTax(float $value)
 * @method float getShippingAmount()
 * @method float getSubtotalInclTax()
 * @method Mage_Sales_Model_Order_Creditmemo setSubtotalInclTax(float $value)
 * @method float getAdjustmentNegative()
 * @method float getBaseShippingAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseShippingAmount(float $value)
 * @method float getStoreToBaseRate()
 * @method Mage_Sales_Model_Order_Creditmemo setStoreToBaseRate(float $value)
 * @method float getBaseToGlobalRate()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseToGlobalRate(float $value)
 * @method float getBaseAdjustment()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseAdjustment(float $value)
 * @method float getBaseSubtotal()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseSubtotal(float $value)
 * @method float getDiscountAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setDiscountAmount(float $value)
 * @method float getSubtotal()
 * @method Mage_Sales_Model_Order_Creditmemo setSubtotal(float $value)
 * @method float getAdjustment()
 * @method Mage_Sales_Model_Order_Creditmemo setAdjustment(float $value)
 * @method float getBaseGrandTotal()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseGrandTotal(float $value)
 * @method float getBaseAdjustmentPositive()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseAdjustmentPositive(float $value)
 * @method float getBaseTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseTaxAmount(float $value)
 * @method float getShippingTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setShippingTaxAmount(float $value)
 * @method float getTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setTaxAmount(float $value)
 * @method int getOrderId()
 * @method Mage_Sales_Model_Order_Creditmemo setOrderId(int $value)
 * @method int getEmailSent()
 * @method Mage_Sales_Model_Order_Creditmemo setEmailSent(int $value)
 * @method int getCreditmemoStatus()
 * @method Mage_Sales_Model_Order_Creditmemo setCreditmemoStatus(int $value)
 * @method int getState()
 * @method Mage_Sales_Model_Order_Creditmemo setState(int $value)
 * @method int getShippingAddressId()
 * @method Mage_Sales_Model_Order_Creditmemo setShippingAddressId(int $value)
 * @method int getBillingAddressId()
 * @method Mage_Sales_Model_Order_Creditmemo setBillingAddressId(int $value)
 * @method int getInvoiceId()
 * @method Mage_Sales_Model_Order_Creditmemo setInvoiceId(int $value)
 * @method string getCybersourceToken()
 * @method Mage_Sales_Model_Order_Creditmemo setCybersourceToken(string $value)
 * @method string getStoreCurrencyCode()
 * @method Mage_Sales_Model_Order_Creditmemo setStoreCurrencyCode(string $value)
 * @method string getOrderCurrencyCode()
 * @method Mage_Sales_Model_Order_Creditmemo setOrderCurrencyCode(string $value)
 * @method string getBaseCurrencyCode()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseCurrencyCode(string $value)
 * @method string getGlobalCurrencyCode()
 * @method Mage_Sales_Model_Order_Creditmemo setGlobalCurrencyCode(string $value)
 * @method string getTransactionId()
 * @method Mage_Sales_Model_Order_Creditmemo setTransactionId(string $value)
 * @method string getIncrementId()
 * @method Mage_Sales_Model_Order_Creditmemo setIncrementId(string $value)
 * @method string getCreatedAt()
 * @method Mage_Sales_Model_Order_Creditmemo setCreatedAt(string $value)
 * @method string getUpdatedAt()
 * @method Mage_Sales_Model_Order_Creditmemo setUpdatedAt(string $value)
 * @method float getHiddenTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setHiddenTaxAmount(float $value)
 * @method float getBaseHiddenTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseHiddenTaxAmount(float $value)
 * @method float getShippingHiddenTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setShippingHiddenTaxAmount(float $value)
 * @method float getBaseShippingHiddenTaxAmount()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseShippingHiddenTaxAmount(float $value)
 * @method float getShippingInclTax()
 * @method Mage_Sales_Model_Order_Creditmemo setShippingInclTax(float $value)
 * @method float getBaseShippingInclTax()
 * @method Mage_Sales_Model_Order_Creditmemo setBaseShippingInclTax(float $value)
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Order_Creditmemo extends Mage_Sales_Model_Abstract
{
	
    const STATE_OPEN        = 1;
    const STATE_REFUNDED    = 2;
    const STATE_CANCELED    = 3;

    const XML_PATH_EMAIL_TEMPLATE               = 'sales_email/creditmemo/template';
    const XML_PATH_EMAIL_GUEST_TEMPLATE         = 'sales_email/creditmemo/guest_template';
    const XML_PATH_EMAIL_IDENTITY               = 'sales_email/creditmemo/identity';
    const XML_PATH_EMAIL_COPY_TO                = 'sales_email/creditmemo/copy_to';
    const XML_PATH_EMAIL_COPY_METHOD            = 'sales_email/creditmemo/copy_method';
    const XML_PATH_EMAIL_ENABLED                = 'sales_email/creditmemo/enabled';

    const XML_PATH_UPDATE_EMAIL_TEMPLATE        = 'sales_email/creditmemo_comment/template';
    const XML_PATH_UPDATE_EMAIL_GUEST_TEMPLATE  = 'sales_email/creditmemo_comment/guest_template';
    const XML_PATH_UPDATE_EMAIL_IDENTITY        = 'sales_email/creditmemo_comment/identity';
    const XML_PATH_UPDATE_EMAIL_COPY_TO         = 'sales_email/creditmemo_comment/copy_to';
    const XML_PATH_UPDATE_EMAIL_COPY_METHOD     = 'sales_email/creditmemo_comment/copy_method';
    const XML_PATH_UPDATE_EMAIL_ENABLED         = 'sales_email/creditmemo_comment/enabled';

    const REPORT_DATE_TYPE_ORDER_CREATED        = 'order_created';
    const REPORT_DATE_TYPE_REFUND_CREATED       = 'refund_created';

    /*
     * Identifier for order history item
     */
    const HISTORY_ENTITY_NAME = 'creditmemo';

    protected static $_states;

    protected $_items;
    protected $_order;
    protected $_comments;

    /**
     * Calculator instances for delta rounding of prices
     *
     * @var array
     */
    protected $_calculators = array();

    protected $_eventPrefix = 'sales_order_creditmemo';
    protected $_eventObject = 'creditmemo';

    /**
     * Initialize creditmemo resource model
     */
    protected function _construct()
    {
        $this->_init('sales/order_creditmemo');
    }

    /**
     * Init mapping array of short fields to its full names
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    protected function _initOldFieldsMap()
    {
        $this->_oldFieldsMap = Mage::helper('sales')->getOldFieldMap('order_creditmemo');
        return $this;
    }

    /**
     * Retrieve Creditmemo configuration model
     *
     * @return Mage_Sales_Model_Order_Creditmemo_Config
     */
    public function getConfig()
    {
        return Mage::getSingleton('sales/order_creditmemo_config');
    }

    /**
     * Retrieve creditmemo store instance
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        return $this->getOrder()->getStore();
    }

    /**
     * Declare order for creditmemo
     *
     * @param   Mage_Sales_Model_Order $order
     * @return  Mage_Sales_Model_Order_Creditmemo
     */
    public function setOrder(Mage_Sales_Model_Order $order)
    {
        $this->_order = $order;
        $this->setOrderId($order->getId())
            ->setStoreId($order->getStoreId());
        return $this;
    }

    /**
     * Retrieve the order the creditmemo for created for
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if (!$this->_order instanceof Mage_Sales_Model_Order) {
            $this->_order = Mage::getModel('sales/order')->load($this->getOrderId());
        }
        return $this->_order->setHistoryEntityName(self::HISTORY_ENTITY_NAME);
    }

    /**
     * Retrieve billing address
     *
     * @return Mage_Sales_Model_Order_Address
     */
    public function getBillingAddress()
    {
        return $this->getOrder()->getBillingAddress();
    }

    /**
     * Retrieve shipping address
     *
     * @return Mage_Sales_Model_Order_Address
     */
    public function getShippingAddress()
    {
        return $this->getOrder()->getShippingAddress();
    }

    public function getItemsCollection()
    {
        if (empty($this->_items)) {
            $this->_items = Mage::getResourceModel('sales/order_creditmemo_item_collection')
                ->setCreditmemoFilter($this->getId());

            if ($this->getId()) {
                foreach ($this->_items as $item) {
                    $item->setCreditmemo($this);
                }
            }
        }
        return $this->_items;
    }

    public function getAllItems()
    {
        $items = array();
        foreach ($this->getItemsCollection() as $item) {
            if (!$item->isDeleted()) {
                $items[] =  $item;
            }
        }
        return $items;
    }

    public function getItemById($itemId)
    {
        foreach ($this->getItemsCollection() as $item) {
            if ($item->getId()==$itemId) {
                return $item;
            }
        }
        return false;
    }

    /**
     * Returns credit memo item by its order id
     *
     * @param $orderId
     * @return Mage_Sales_Model_Order_Creditmemo_Item|bool
     */
    public function getItemByOrderId($orderId)
    {
        foreach ($this->getItemsCollection() as $item) {
            if ($item->getOrderItemId() == $orderId) {
                return $item;
            }
        }
        return false;
    }

    public function addItem(Mage_Sales_Model_Order_Creditmemo_Item $item)
    {
        $item->setCreditmemo($this)
            ->setParentId($this->getId())
            ->setStoreId($this->getStoreId());
        if (!$item->getId()) {
            $this->getItemsCollection()->addItem($item);
        }
        return $this;
    }

    /**
     * Creditmemo totals collecting
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function collectTotals()
    {
        foreach ($this->getConfig()->getTotalModels() as $model) {
            $model->collect($this);
        }
        return $this;
    }

    /**
     * Round price considering delta
     *
     * @param float $price
     * @param string $type
     * @param bool $negative Indicates if we perform addition (true) or subtraction (false) of rounded value
     * @return float
     */
    public function roundPrice($price, $type = 'regular', $negative = false)
    {
        if ($price) {
            if (!isset($this->_calculators[$type])) {
                $this->_calculators[$type] = Mage::getModel('core/calculator', $this->getStore());
            }
            $price = $this->_calculators[$type]->deltaRound($price, $negative);
        }
        return $price;
    }

    public function canRefund()
    {
        if ($this->getState() != self::STATE_CANCELED
            && $this->getState() != self::STATE_REFUNDED
            && $this->getOrder()->getPayment()->canRefund()
            ) {
            return true;
        }
        return false;
    }

    /**
     * Check creditmemo cancel action availability
     *
     * @return bool
     */
    public function canCancel()
    {
        return $this->getState() == self::STATE_OPEN;
    }

    /**
     * Check invice void action availability
     *
     * @return bool
     */
    public function canVoid()
    {
        $canVoid = false;
        return false;
        if ($this->getState() == self::STATE_REFUNDED) {
            $canVoid = $this->getCanVoidFlag();
            /**
             * If we not retrieve negative answer from payment yet
             */
            if (is_null($canVoid)) {
                $canVoid = $this->getOrder()->getPayment()->canVoid($this);
                if ($canVoid === false) {
                    $this->setCanVoidFlag(false);
                    $this->_saveBeforeDestruct = true;
                }
            }
            else {
                $canVoid = (bool) $canVoid;
            }
        }
        return $canVoid;
    }

	public function savetodb($orderid, $bucks)
	{
		$resource = Mage::getSingleton('core/resource');
 		$readConnection = $resource->getConnection('core_write');
		$readConnection->query("Insert into smogi_refund_log values (NULL, '$orderid', $bucks)");
	}
	
    public function refund()
    {
        $this->setState(self::STATE_REFUNDED);
        $orderRefund = Mage::app()->getStore()->roundPrice(
            $this->getOrder()->getTotalRefunded()+$this->getGrandTotal()
        );
        $baseOrderRefund = Mage::app()->getStore()->roundPrice(
            $this->getOrder()->getBaseTotalRefunded()+$this->getBaseGrandTotal()
        );

        if ($baseOrderRefund > Mage::app()->getStore()->roundPrice($this->getOrder()->getBaseTotalPaid())) {

            $baseAvailableRefund = $this->getOrder()->getBaseTotalPaid()- $this->getOrder()->getBaseTotalRefunded();

            Mage::throwException(
                Mage::helper('sales')->__('Maximum amount available to refund is %s', $this->getOrder()->formatBasePrice($baseAvailableRefund))
            );
        }
        
        //$order = $this->getOrder();
//        $qtytorefund = Mage::getSingleton('core/session')->getQtyToRef();
//		$qty_ordered = $order->getTotalQtyOrdered();
//        $totrew = $order->getRewardpoints();
//        $itemids = "";
//        foreach ($this->getItemsCollection() as $item) {
//            $itemids .= $item."-";
//        }
//        $itemcount = Mage::getSingleton('core/session')->getitemcount();
        //Mage::throwException( Mage::helper('sales')->__('Qty refunding = '.$qtytorefund."<br/>Total Qty ordered = ".$qty_ordered."<br/>Reward Points Used = ".$totrew."<br/>Item collection = ".$itemids."<br/>Items Refunding = ".$itemcount));
        
        $order = $this->getOrder();
        $order->setBaseTotalRefunded($baseOrderRefund);
        $order->setTotalRefunded($orderRefund);

        $order->setBaseSubtotalRefunded($order->getBaseSubtotalRefunded()+$this->getBaseSubtotal());
        $order->setSubtotalRefunded($order->getSubtotalRefunded()+$this->getSubtotal());

        $order->setBaseTaxRefunded($order->getBaseTaxRefunded()+$this->getBaseTaxAmount());
        $order->setTaxRefunded($order->getTaxRefunded()+$this->getTaxAmount());
        $order->setBaseHiddenTaxRefunded($order->getBaseHiddenTaxRefunded()+$this->getBaseHiddenTaxAmount());
        $order->setHiddenTaxRefunded($order->getHiddenTaxRefunded()+$this->getHiddenTaxAmount());

        $order->setBaseShippingRefunded($order->getBaseShippingRefunded()+$this->getBaseShippingAmount());
        $order->setShippingRefunded($order->getShippingRefunded()+$this->getShippingAmount());

        $order->setBaseShippingTaxRefunded($order->getBaseShippingTaxRefunded()+$this->getBaseShippingTaxAmount());
        $order->setShippingTaxRefunded($order->getShippingTaxRefunded()+$this->getShippingTaxAmount());

        $order->setAdjustmentPositive($order->getAdjustmentPositive()+$this->getAdjustmentPositive());
        $order->setBaseAdjustmentPositive($order->getBaseAdjustmentPositive()+$this->getBaseAdjustmentPositive());

        $order->setAdjustmentNegative($order->getAdjustmentNegative()+$this->getAdjustmentNegative());
        $order->setBaseAdjustmentNegative($order->getBaseAdjustmentNegative()+$this->getBaseAdjustmentNegative());

        $order->setDiscountRefunded($order->getDiscountRefunded()+$this->getDiscountAmount());
        $order->setBaseDiscountRefunded($order->getBaseDiscountRefunded()+$this->getBaseDiscountAmount());

        if ($this->getInvoice()) {
            $this->getInvoice()->setIsUsedForRefund(true);
            $this->getInvoice()->setBaseTotalRefunded(
                $this->getInvoice()->getBaseTotalRefunded() + $this->getBaseGrandTotal()
            );
            $this->setInvoiceId($this->getInvoice()->getId());
        }

        if (!$this->getPaymentRefundDisallowed()) {
            $order->getPayment()->refund($this);
        }

        Mage::dispatchEvent('sales_order_creditmemo_refund', array($this->_eventObject=>$this));
        return $this;
    }
    
    public function refund1()
    {
        $this->setState(self::STATE_REFUNDED);
        $orderRefund = Mage::app()->getStore()->roundPrice(
            $this->getOrder()->getTotalRefunded()+$this->getGrandTotal()
        );
        $baseOrderRefund = Mage::app()->getStore()->roundPrice(
            $this->getOrder()->getBaseTotalRefunded()+$this->getBaseGrandTotal()
        );

        if ($baseOrderRefund > Mage::app()->getStore()->roundPrice($this->getOrder()->getBaseTotalPaid())) {

            $baseAvailableRefund = $this->getOrder()->getBaseTotalPaid()- $this->getOrder()->getBaseTotalRefunded();

            Mage::throwException(
                Mage::helper('sales')->__('Maximum amount available to refund is %s', $this->getOrder()->formatBasePrice($baseAvailableRefund))
            );
        }
        $order = $this->getOrder();
		
        ///Begins our custom code for refunding SMOGI Bucks
        
        $sum_reward_points = 0;
        
           
        $resource = Mage::getSingleton('core/resource');
 		$readConnection = $resource->getConnection('core_read');
		$qtytorefund = Mage::getSingleton('core/session')->getQtyToRef();
		$qty_ordered = $order->getTotalQtyOrdered();
		
        /* Reward Points Api for Partial Refund */
		$proxy = new SoapClient(Mage::getBaseUrl().'api/soap/?wsdl');
		$sessionId = $proxy->login('mobikasadeveloper', 'developerkey');
		$customer_id = $order->getCustomerId();
		$storeIds = 1;    
		
		if($qty_ordered == $qtytorefund) //For Full Refund
		{
			$ordertotal = $order->getBaseGrandTotal();
			$totrew = $order->getRewardpoints();
            if($ordertotal == 0)
            {
                //Mage::log("Order total is 0. Adding points".$totrew,null,'partialrefund.log');
                    
				/*$proxy->call($sessionId, 'j2trewardapi.add', array($customer_id, $totrew, $storeIds)); //In case of full refund at once if order total is zero refunding all bucks to user 
				$this->savetodb($order->getId(), $totrew);*/
                
                $sum_reward_points += $totrew;
			}			
		      //Mage::log("Going to complete refund at once",null,'partialrefund.log');
		}
		else
		{
			$itemcount = Mage::getSingleton('core/session')->getitemcount();		
			$checkrew = Mage::getSingleton('core/session')->getcheckrew();
			$checkrew = explode(',' , $checkrew);
			
			/* For Total Reward Points */
			
			// for total reward points 
			$table1 = $resource->getTableName('sales_flat_order_item');
			$query = "SELECT product_id, qty_ordered FROM ".$table1." WHERE order_id = ".$order->getEntityId()." AND product_type = 'simple'";
			$total_points_gained = $readConnection->fetchAll($query);
			//print_r($points_gained);
			for ($id=0;$id < $itemcount; $id++)
			{
    			 $product_id[$id]=$total_points_gained[$id]['product_id']."<br />";
    			 $total_qty_ordered = $total_points_gained[$id]['qty_ordered']."<br />";
    			 $total_points_awarded[$id] = Mage::helper('rewardpoints/data')->getProductPoints(Mage::getModel('catalog/product')->load($product_id[$id]),false,false);
    			 $totalrewardpoints[$id] = $total_points_awarded[$id] * $total_qty_ordered."<br />";										
			}
            // for total reward points
			$total_points_earned11 = 0;
            $totalrewardpoints1 = array_sum($totalrewardpoints);
			//echo "Total reward points".$totalrewardpoints1 = array_sum($totalrewardpoints);
			//Mage::throwException( Mage::helper('sales')->__($order->getGiftMessageId()." ".$order->getCouponRuleName())  );
			/* For Total Reward Points */
			
			if ($order->getRewardpoints() != NULL || $totalrewardpoints1 > 0)  
			{
			if ($order->getGiftMessageId() == '' && $order->getCouponRuleName() == '')
			{
			$qty_refunded = Mage::getSingleton('core/session')->getQtyToRef();
			
			/* For Full refund after partial Refund and Rounding off purpose    */
			
			$table = $resource->getTableName('sales_flat_order');
			$table3 = $resource->getTableName('sales_flat_order_item');
			$table1 = $resource->getTableName('sales_flat_creditmemo');
			$table2 = $resource->getTableName('sales_flat_creditmemo_item');
			
			//$query = 'SELECT '.$table2.'.qty FROM ' . $table2.','. $table1.','. $table.' WHERE '.$table2.'.base_price > 1 AND '.$table2.'.parent_id = '.$table1.'.entity_id AND '.$table1.'.order_id ='.$order->getEntityId().' GROUP BY '.$table2.'.parent_id';
			$query = "SELECT SUM(qty_refunded) FROM ".$table3." where product_type = 'configurable' AND order_id =".$order->getEntityId();
			$qty = $readConnection->fetchOne($query);
			$qty_left = $qty_ordered - $qty ;
			/* For Full refund after partial Refund and Rounding off purpose    */
			
			if($qty_left == $qtytorefund)
			{
			$refpoints = Mage::helper('rewardpoints/data')->convertmoneytopoints(floor($this->getDiscountAmount()));
			}
			else
			{
			$refpoints = Mage::helper('rewardpoints/data')->convertmoneytopoints($this->getDiscountAmount());
			}
            
			/* Reward Points Api for Partial Refund */
            
			$proxy = new SoapClient(Mage::getBaseUrl().'api/soap/?wsdl');
			$sessionId = $proxy->login('mobikasadeveloper', 'developerkey');
			$customer_id = $order->getCustomerId();
			//$storeIds = Mage::app()->getStore()->getId(); 
			$storeIds = 1; 
			
			if($refpoints > 0)
			{
    			if($qty_left == $qtytorefund)
    			{
    				$resource1 = Mage::getSingleton('core/resource')->getConnection('core_read');
    				$readresult=$resource1->query("Select SUM(smogi_bucks) as sm from smogi_refund_log where order_id='".$order->getId()."'");
    				$row = $readresult->fetch();
    				//Mage::log("total reward points = ".$order->getRewardpoints()."  points given =  ".$row['sm'], null, 'partialrefund.log');
    				$refpoints = $order->getRewardpoints() - $row['sm'];
    			}
    			/*** OrderId applicable ******/	
    			if($order->getId() > Mage::getModel('core/variable')->loadByCode('partial_nonapplicable')->getValue('plain'))
    			{
        			/*$proxy->call($sessionId, 'j2trewardapi.add', array($customer_id, $refpoints, $storeIds));
                    $this->savetodb($order->getId(), $refpoints);*/
                    
                    $sum_reward_points += $refpoints;
    			}
			}			
			$table1 = $resource->getTableName('sales_flat_order_item');
			$query = "SELECT product_id FROM ".$table1." WHERE order_id = ".$order->getEntityId()." AND product_type = 'simple'";
			$points_gained = $readConnection->fetchAll($query);
			//print_r($points_gained);
			$basediscountamt = $order->getBaseDiscountAmount();	
				
			foreach ($points_gained as $id => $values) {
						foreach ($values as $value) {
							//echo "id {$id} and value {$value}<br />";
									
								 $points_awarded[$id] = Mage::helper('rewardpoints/data')->getProductPoints(Mage::getModel('catalog/product')->load($value),false,false);
								 $checkrew[$id]."<br />";
								 $rewardpoints[$id] = $points_awarded[$id] * $checkrew[$id];
										
								if ($basediscountamt > 0)
								{
									if($rewardpoints[$id] > 0)
									{							
									//$proxy->call($sessionId, 'j2trewardapi.remove', array($customer_id, $rewardpoints[$id], $storeIds));
										
									}
								}
								else if ($basediscountamt == 0  )
								{
									if($rewardpoints[$id] > 0)
									{		
									Mage::log("Adding value reward ".$rewardpoints[$id],null,'partialrefund.log');
									$total_points_earned11 = $total_points_earned11 + $rewardpoints[$id];
									
                                    /*$proxy->call($sessionId, 'j2trewardapi.remove', array($customer_id, $rewardpoints[$id], $storeIds));
									$this->savetodb($order->getId(), (-1 * $rewardpoints[$id]));*/
                                    
                                    $sum_reward_points -= $rewardpoints[$id];
									}
								}
								
							//Mage:throwException( Mage::helper('sales')->__('test')  ); for debugging
								}
							}
			
            if($qty_left == $qtytorefund)
				{	
			/*** OrderId applicable ******/	
			
			if($order->getId() > Mage::getModel('core/variable')->loadByCode('partial_nonapplicable')->getValue('plain'))
			{
				    //Mage::log("Complete refund after partial".$total_points_earned11,null,'partialrefund.log');
					$state = 'closed';
					$status = 'closed';
					$comment = 'Closed';
					$isCustomerNotified = false;
					$shouldProtectState = false;
					$order->setState($state, $status, $comment, $isCustomerNotified,$shouldProtectState);
					
					//$rewardpointstotal = $points_awarded * $qty_ordered;
                    $ordertotal = $order->getBaseGrandTotal();
                   
					if($ordertotal == 0)
                    {
                        //Mage::log("Order total is 0. Adding points".$total_points_earned11,null,'partialrefund.log');    
    					//$proxy->call($sessionId, 'j2trewardapi.add', array($customer_id, $totalrewardpoints1 , $storeIds)); 
						if($total_points_earned > 0)
						{
						/*
                        $proxy->call($sessionId, 'j2trewardapi.remove', array($customer_id, $total_points_earned11, $storeIds));
						
						$this->savetodb($order->getId(), (-1 * $total_points_earned11));
						*/
                        $sum_reward_points -= $total_points_earned11;
						}
                    
					}
                    else
                    {
                        //Mage::log("Order total is more than 0. Adding points and removing",null,'partialrefund.log');
                        $refpointstotal = $order->getRewardpoints();
    					if($refpointstotal > 0)
    					{
    					/*$proxy->call($sessionId, 'j2trewardapi.remove', array($customer_id, $refpointstotal, $storeIds));
						$this->savetodb($order->getId(), (-1 * $refpointstotal));*/
                        $sum_reward_points -= $refpointstotal;
    					}
    					if ($basediscountamt == 0 )
    					{
    					/*$proxy->call($sessionId, 'j2trewardapi.add', array($customer_id, $totalrewardpoints1, $storeIds));
						$this->savetodb($order->getId(), $totalrewardpoints1);*/
                        $sum_reward_points += $totalrewardpoints1;
    					}    
                    }
				}
			}
			}
			
			}
			
			
		}
        
		$totrew_zeroorder = $order->getRewardpoints();
		if(($qty_left == $qtytorefund) && $ordertotal == 0)
		{
		$sum_reward_points -= $totrew_zeroorder;
		}
		
        if($sum_reward_points != 0)
        {
            if($sum_reward_points < 0)
            {
                $sum_reward_points *= -1;
                $proxy->call($sessionId, 'j2trewardapi.remove', array($customer_id, $sum_reward_points, $storeIds));
    			$this->savetodb($order->getId(), (-1 * $sum_reward_points));
            }
            else
            {
                $proxy->call($sessionId, 'j2trewardapi.add', array($customer_id, $sum_reward_points, $storeIds));
                $this->savetodb($order->getId(), $sum_reward_points);   
            }    
        }
		
        
		$order->setBaseTotalRefunded($baseOrderRefund);
		$order->setTotalRefunded($orderRefund);

		$order->setBaseSubtotalRefunded($order->getBaseSubtotalRefunded()+$this->getBaseSubtotal());
		$order->setSubtotalRefunded($order->getSubtotalRefunded()+$this->getSubtotal());

		$order->setBaseTaxRefunded($order->getBaseTaxRefunded()+$this->getBaseTaxAmount());
		$order->setTaxRefunded($order->getTaxRefunded()+$this->getTaxAmount());
		$order->setBaseHiddenTaxRefunded($order->getBaseHiddenTaxRefunded()+$this->getBaseHiddenTaxAmount());
		$order->setHiddenTaxRefunded($order->getHiddenTaxRefunded()+$this->getHiddenTaxAmount());

		$order->setBaseShippingRefunded($order->getBaseShippingRefunded()+$this->getBaseShippingAmount());
		$order->setShippingRefunded($order->getShippingRefunded()+$this->getShippingAmount());

		$order->setBaseShippingTaxRefunded($order->getBaseShippingTaxRefunded()+$this->getBaseShippingTaxAmount());
		$order->setShippingTaxRefunded($order->getShippingTaxRefunded()+$this->getShippingTaxAmount());

		$order->setAdjustmentPositive($order->getAdjustmentPositive()+$this->getAdjustmentPositive());
		$order->setBaseAdjustmentPositive($order->getBaseAdjustmentPositive()+$this->getBaseAdjustmentPositive());

		$order->setAdjustmentNegative($order->getAdjustmentNegative()+$this->getAdjustmentNegative());
		$order->setBaseAdjustmentNegative($order->getBaseAdjustmentNegative()+$this->getBaseAdjustmentNegative());

		$order->setDiscountRefunded($order->getDiscountRefunded()+$this->getDiscountAmount());
		$order->setBaseDiscountRefunded($order->getBaseDiscountRefunded()+$this->getBaseDiscountAmount());
		
		
		 if ($this->getInvoice()) {
			$this->getInvoice()->setIsUsedForRefund(true);
			$this->getInvoice()->setBaseTotalRefunded(
				$this->getInvoice()->getBaseTotalRefunded() + $this->getBaseGrandTotal()
			);
			$this->setInvoiceId($this->getInvoice()->getId());
		}

		if (!$this->getPaymentRefundDisallowed()) {
			$order->getPayment()->refund($this);
		}
		Mage::dispatchEvent('sales_order_creditmemo_refund', array($this->_eventObject=>$this));
		return $this;
    }
	
    /**
     * Cancel Creditmemo action
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function cancel()
    {
        $this->setState(self::STATE_CANCELED);
        foreach ($this->getAllItems() as $item) {
            $item->cancel();
        }
        $this->getOrder()->getPayment()->cancelCreditmemo($this);

        if ($this->getTransactionId()) {
            $this->getOrder()->setTotalOnlineRefunded(
                $this->getOrder()->getTotalOnlineRefunded()-$this->getGrandTotal()
            );
            $this->getOrder()->setBaseTotalOnlineRefunded(
                $this->getOrder()->getBaseTotalOnlineRefunded()-$this->getBaseGrandTotal()
            );
        }
        else {
            $this->getOrder()->setTotalOfflineRefunded(
                $this->getOrder()->getTotalOfflineRefunded()-$this->getGrandTotal()
            );
            $this->getOrder()->setBaseTotalOfflineRefunded(
                $this->getOrder()->getBaseTotalOfflineRefunded()-$this->getBaseGrandTotal()
            );
        }

        $this->getOrder()->setBaseSubtotalRefunded(
            $this->getOrder()->getBaseSubtotalRefunded()-$this->getBaseSubtotal()
        );
        $this->getOrder()->setSubtotalRefunded($this->getOrder()->getSubtotalRefunded()-$this->getSubtotal());

        $this->getOrder()->setBaseTaxRefunded($this->getOrder()->getBaseTaxRefunded()-$this->getBaseTaxAmount());
        $this->getOrder()->setTaxRefunded($this->getOrder()->getTaxRefunded()-$this->getTaxAmount());

        $this->getOrder()->setBaseShippingRefunded(
            $this->getOrder()->getBaseShippingRefunded()-$this->getBaseShippingAmount()
        );
        $this->getOrder()->setShippingRefunded($this->getOrder()->getShippingRefunded()-$this->getShippingAmount());

        Mage::dispatchEvent('sales_order_creditmemo_cancel', array($this->_eventObject=>$this));
        return $this;
    }

    /**
     * Register creditmemo
     *
     * Apply to order, order items etc.
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function register()
    {
	
        if ($this->getId()) {
            Mage::throwException(
                Mage::helper('sales')->__('Cannot register an existing credit memo.')
            );
        }

        foreach ($this->getAllItems() as $item) {
            if ($item->getQty()>0) {
                $item->register();
            }
            else {
                $item->isDeleted(true);
            }
        }

        $this->setDoTransaction(true);
        if ($this->getOfflineRequested()) {
            $this->setDoTransaction(false);
        }
		
	
        $this->refund();

        if ($this->getDoTransaction()) {
            $this->getOrder()->setTotalOnlineRefunded(
                $this->getOrder()->getTotalOnlineRefunded()+$this->getGrandTotal()
            );
            $this->getOrder()->setBaseTotalOnlineRefunded(
                $this->getOrder()->getBaseTotalOnlineRefunded()+$this->getBaseGrandTotal()
            );
        }
        else {
            $this->getOrder()->setTotalOfflineRefunded(
                $this->getOrder()->getTotalOfflineRefunded()+$this->getGrandTotal()
            );
            $this->getOrder()->setBaseTotalOfflineRefunded(
                $this->getOrder()->getBaseTotalOfflineRefunded()+$this->getBaseGrandTotal()
            );
        }

        $this->getOrder()->setBaseTotalInvoicedCost(
            $this->getOrder()->getBaseTotalInvoicedCost()-$this->getBaseCost()
        );

        $state = $this->getState();
        if (is_null($state)) {
            $this->setState(self::STATE_OPEN);
        }
	       
        return $this;
		
		
		
    }

    /**
     * Retrieve Creditmemo states array
     *
     * @return array
     */
    public static function getStates()
    {
        if (is_null(self::$_states)) {
            self::$_states = array(
                self::STATE_OPEN       => Mage::helper('sales')->__('Pending'),
                self::STATE_REFUNDED   => Mage::helper('sales')->__('Refunded'),
                self::STATE_CANCELED   => Mage::helper('sales')->__('Canceled'),
            );
        }
        return self::$_states;
    }

    /**
     * Retrieve Creditmemo state name by state identifier
     *
     * @param   int $stateId
     * @return  string
     */
    public function getStateName($stateId = null)
    {
        if (is_null($stateId)) {
            $stateId = $this->getState();
        }

        if (is_null(self::$_states)) {
            self::getStates();
        }
        if (isset(self::$_states[$stateId])) {
            return self::$_states[$stateId];
        }
        return Mage::helper('sales')->__('Unknown State');
    }

    public function setShippingAmount($amount)
    {
        // base shipping amount calculated in total model
//        $amount = $this->getStore()->roundPrice($amount);
//        $this->setData('base_shipping_amount', $amount);
//
//        $amount = $this->getStore()->roundPrice(
//            $amount*$this->getOrder()->getStoreToOrderRate()
//        );
        $this->setData('shipping_amount', $amount);
        return $this;
    }


    public function setAdjustmentPositive($amount)
    {
        $amount = trim($amount);
        if (substr($amount, -1) == '%') {
            $amount = (float) substr($amount, 0, -1);
            $amount = $this->getOrder()->getGrandTotal() * $amount / 100;
        }

        $amount = $this->getStore()->roundPrice($amount);
        $this->setData('base_adjustment_positive', $amount);

        $amount = $this->getStore()->roundPrice(
            $amount*$this->getOrder()->getStoreToOrderRate()
        );
        $this->setData('adjustment_positive', $amount);
        return $this;
    }

    public function setAdjustmentNegative($amount)
    {
        $amount = trim($amount);
        if (substr($amount, -1) == '%') {
            $amount = (float) substr($amount, 0, -1);
            $amount = $this->getOrder()->getGrandTotal() * $amount / 100;
        }

        $amount = $this->getStore()->roundPrice($amount);
        $this->setData('base_adjustment_negative', $amount);

        $amount = $this->getStore()->roundPrice(
            $amount*$this->getOrder()->getStoreToOrderRate()
        );
        $this->setData('adjustment_negative', $amount);
        return $this;
    }

    /**
     * Adds comment to credit memo with additional possibility to send it to customer via email
     * and show it in customer account
     *
     * @param bool $notify
     * @param bool $visibleOnFront
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function addComment($comment, $notify=false, $visibleOnFront=false)
    {
        if (!($comment instanceof Mage_Sales_Model_Order_Creditmemo_Comment)) {
            $comment = Mage::getModel('sales/order_creditmemo_comment')
                ->setComment($comment)
                ->setIsCustomerNotified($notify)
                ->setIsVisibleOnFront($visibleOnFront);
        }
        $comment->setCreditmemo($this)
            ->setParentId($this->getId())
            ->setStoreId($this->getStoreId());
        if (!$comment->getId()) {
            $this->getCommentsCollection()->addItem($comment);
        }
        $this->_hasDataChanges = true;
        return $this;
    }

    public function getCommentsCollection($reload=false)
    {
        if (is_null($this->_comments) || $reload) {
            $this->_comments = Mage::getResourceModel('sales/order_creditmemo_comment_collection')
                ->setCreditmemoFilter($this->getId())
                ->setCreatedAtOrder();
            /**
             * When credit memo created with adding comment,
             * comments collection must be loaded before we added this comment.
             */
            $this->_comments->load();

            if ($this->getId()) {
                foreach ($this->_comments as $comment) {
                    $comment->setCreditmemo($this);
                }
            }
        }
        return $this->_comments;
    }


    /**
     * Send email with creditmemo data
     *
     * @param boolean $notifyCustomer
     * @param string $comment
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function sendEmail($notifyCustomer = true, $comment = '')
    {
        $order = $this->getOrder();
        $storeId = $order->getStore()->getId();

        if (!Mage::helper('sales')->canSendNewCreditmemoEmail($storeId)) {
            return $this;
        }
        // Get the destination email addresses to send copies to
        $copyTo = $this->_getEmails(self::XML_PATH_EMAIL_COPY_TO);
        $copyMethod = Mage::getStoreConfig(self::XML_PATH_EMAIL_COPY_METHOD, $storeId);
        // Check if at least one recepient is found
        if (!$notifyCustomer && !$copyTo) {
            return $this;
        }

        // Start store emulation process
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);

        try {
            // Retrieve specified view block from appropriate design package (depends on emulated store)
            $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())
                ->setIsSecureMode(true);
            $paymentBlock->getMethod()->setStore($storeId);
            $paymentBlockHtml = $paymentBlock->toHtml();
        } catch (Exception $exception) {
            // Stop store emulation process
            $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
            throw $exception;
        }

        // Stop store emulation process
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        // Retrieve corresponding email template id and customer name
        if ($order->getCustomerIsGuest()) {
            $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_GUEST_TEMPLATE, $storeId);
            $customerName = $order->getBillingAddress()->getName();
        } else {
            $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $storeId);
            $customerName = $order->getCustomerName();
        }

        $mailer = Mage::getModel('core/email_template_mailer');
        if ($notifyCustomer) {
            $emailInfo = Mage::getModel('core/email_info');
            $emailInfo->addTo($order->getCustomerEmail(), $customerName);
            if ($copyTo && $copyMethod == 'bcc') {
                // Add bcc to customer email
                foreach ($copyTo as $email) {
                    $emailInfo->addBcc($email);
                }
            }
            $mailer->addEmailInfo($emailInfo);
        }

        // Email copies are sent as separated emails if their copy method is 'copy' or a customer should not be notified
        if ($copyTo && ($copyMethod == 'copy' || !$notifyCustomer)) {
            foreach ($copyTo as $email) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($email);
                $mailer->addEmailInfo($emailInfo);
            }
        }

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig(self::XML_PATH_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
                'order'        => $order,
                'creditmemo'   => $this,
                'comment'      => $comment,
                'billing'      => $order->getBillingAddress(),
                'payment_html' => $paymentBlockHtml
            )
        );
        $mailer->send();
        $this->setEmailSent(true);
        $this->_getResource()->saveAttribute($this, 'email_sent');

        return $this;
    }

    /**
     * Send email with creditmemo update information
     *
     * @param boolean $notifyCustomer
     * @param string $comment
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function sendUpdateEmail($notifyCustomer = true, $comment = '')
    {
        $order = $this->getOrder();
        $storeId = $order->getStore()->getId();

        if (!Mage::helper('sales')->canSendCreditmemoCommentEmail($storeId)) {
            return $this;
        }
        // Get the destination email addresses to send copies to
        $copyTo = $this->_getEmails(self::XML_PATH_UPDATE_EMAIL_COPY_TO);
        $copyMethod = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_COPY_METHOD, $storeId);
        // Check if at least one recepient is found
        if (!$notifyCustomer && !$copyTo) {
            return $this;
        }

        // Retrieve corresponding email template id and customer name
        if ($order->getCustomerIsGuest()) {
            $templateId = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_GUEST_TEMPLATE, $storeId);
            $customerName = $order->getBillingAddress()->getName();
        } else {
            $templateId = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_TEMPLATE, $storeId);
            $customerName = $order->getCustomerName();
        }

        $mailer = Mage::getModel('core/email_template_mailer');
        if ($notifyCustomer) {
            $emailInfo = Mage::getModel('core/email_info');
            $emailInfo->addTo($order->getCustomerEmail(), $customerName);
            if ($copyTo && $copyMethod == 'bcc') {
                // Add bcc to customer email
                foreach ($copyTo as $email) {
                    $emailInfo->addBcc($email);
                }
            }
            $mailer->addEmailInfo($emailInfo);
        }

        // Email copies are sent as separated emails if their copy method is 'copy' or a customer should not be notified
        if ($copyTo && ($copyMethod == 'copy' || !$notifyCustomer)) {
            foreach ($copyTo as $email) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($email);
                $mailer->addEmailInfo($emailInfo);
            }
        }

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
                'order'      => $order,
                'creditmemo' => $this,
                'comment'    => $comment,
                'billing'    => $order->getBillingAddress()
            )
        );
        $mailer->send();

        return $this;
    }

    protected function _getEmails($configPath)
    {
        $data = Mage::getStoreConfig($configPath, $this->getStoreId());
        if (!empty($data)) {
            return explode(',', $data);
        }
        return false;
    }

    protected function _beforeDelete()
    {
        $this->_protectFromNonAdmin();
        return parent::_beforeDelete();
    }

    /**
     * After save object manipulations
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
     
    function islastcreditmemo($orderId, $creditmemoid, $first)
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        
        $readresult=$read->query("Select entity_id from sales_flat_creditmemo where order_id=".$orderId);
        $creditmemoids = "";
        $creditmemocount = 0;
        while ($row = $readresult->fetch() ) {
            $creditmemoids .= $row['entity_id'].",";
            $creditmemocount++;
        }
        $creditmemoids = substr($creditmemoids,0,strlen($creditmemoids) - 1);
        
        $readresult=$read->query("Select SUM(qty) as cnt from sales_flat_creditmemo_item where parent_id IN (".$creditmemoids.") and row_total IS NOT NULL");
        $row = $readresult->fetch();
        $order = Mage::getModel('sales/order')->load($orderId);
        Mage::log("Credit memo item count =".$row['cnt']."<br/> Order item count = ".$order->getTotalQtyOrdered(), null, 'partial_ankit.log');
        if($row['cnt'] != $order->getTotalQtyOrdered())
            return false;
        if($first && $creditmemocount != 1)
        {
            //$readresult=$read->query("Select Count(entity_id) as cnt from sales_flat_creditmemo where order_id=".$orderId);
//            $row = $readresult->fetch();
//            if($row['cnt'] != 1)
                return false;
        }
        return true;
        
        //$read = Mage::getSingleton('core/resource')->getConnection('core_read');
//        $readresult=$read->query("Select Count(entity_id) as cnt from sales_flat_creditmemo where order_id=".$orderId);
//        $row = $readresult->fetch();
//        if($row['cnt'] == 1)
//        {
//            $readresult=$read->query("Select SUM(qty) as cnt from sales_flat_creditmemo_item where parent_id=".$creditmemoid." and row_total IS NOT NULL");
//            $row = $readresult->fetch();
//            $order = Mage::getModel('sales/order')->load($orderId);
//            Mage::log("Credit memo item count =".$row['cnt']."<br/> Order item count = ".$order->getTotalQtyOrdered(), null, 'partial_ankit.log');
//            if($row['cnt'] != $order->getTotalQtyOrdered())
//                return false;
//        }
//        else
//            return false;
//        return true;
    }
    
    function getorderstatus($orderid)
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("Select state from sales_flat_order where entity_id=".$orderid);
        $row = $readresult->fetch();
        return $row['state'];
    }
    
    function issmogiused($orderid)
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("Select rewardpoints_quantity from sales_flat_order where entity_id=".$orderid);
        $row = $readresult->fetch();
        Mage::log("Reward Points Quantity ".$row['rewardpoints_quantity'], null, 'partial_ankit.log');
        if($row['rewardpoints_quantity'] > 0)
            return true;
        else
            return false;
    }
    
    function isdiscountused($orderid)
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("Select base_discount_amount from sales_flat_order where entity_id=".$orderid);
        $row = $readresult->fetch();
        Mage::log("Base discount amount ".$row['base_discount_amount'], null, 'partial_ankit.log');
        if($row['base_discount_amount'] < 0)
            return true;
        else
            return false;
    }
    
    function getcustomaddedsmogis($orderid)
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("Select SUM(smogi_bucks) as cnt from smogi_refund_log where order_id=".$orderid);
        $row = $readresult->fetch();
        Mage::log("Cutom Point added uptil now = ".$row['cnt'], null, 'partial_ankit.log');
        return $row['cnt'];
    }
    
    function getmemodiscountamount($creditmemoid)
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("Select base_discount_amount from sales_flat_creditmemo where entity_id=".$creditmemoid);
        $row = $readresult->fetch();
        Mage::log("Credit Memo Discount Amount = ".$row['base_discount_amount'], null, 'partial_ankit.log');
        return $row['base_discount_amount'];
    }
    
    function calculateearnedpoints($creditmemoid)
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("Select qty, product_id from sales_flat_creditmemo_item where parent_id=".$creditmemoid." and row_total IS NOT NULL");
        $sum = 0;
        while ($row = $readresult->fetch() ) {
            Mage::log("Credit Memo Item ::  Product Id = ".$row['product_id']."  Qty = ".$row['qty']."  Points earned per unit = ".Mage::helper('rewardpoints/data')->getProductPoints(Mage::getModel('catalog/product')->load($row['product_id']),false,false), null, 'partial_ankit.log');    
            $sum += Mage::helper('rewardpoints/data')->getProductPoints(Mage::getModel('catalog/product')->load($row['product_id']),false,false) * $row['qty'];               
        }
        return $sum;
    }
    
    /*
    IF(!FULL_REFUND_AT_ONCE)
    {
    	IF(LAST_REFUND)
    	{
    		REVERT THE SMOGI BUCKS ADDED/REMOVED BEFORE.
    	}
    	ELSE
    	{
    		IF(SMOGI_BUCKS_USED_AS_DISCOUNT)
    		{
    			ADD THE SMOGI_BUCKS_USED_AS_DISCOUNT BACK TO USER.
    		}
    		ELSE
    		{
    			IF(!DISCOUNT_USED)
    			{
    				EXTRACT SMOGI_BUCKS_EARNED FROM USER. //EARNED ON THE ITEMS TO BE REFUNDED
    			}
    		}
    	}
    }
    */
    
    
    function refundsmogibucks($creditmemoid, $orderid)
    {
        $order = Mage::getModel('sales/order')->load($orderid);
        $orderincrementid = $order->getIncrementId();
        try{
            //Mage::log("\n\n\n\n\nCredit Memo Id =".$creditmemoid, null, 'partial_ankit.log');
            //Mage::log("Order Id =".$orderid, null, 'partial_ankit.log');
            if(!$this->islastcreditmemo($orderid, $creditmemoid, true)) //FOR FULL REFUND AT ONCE NO PROCESSING IS REQUIRED
            {
                $sum_smogi_customization = 0; //Variable to hold the customizations
                if($this->islastcreditmemo($orderid, $creditmemoid, false)) //IF LAST REFUND AFTER REFUND
                {
                    //Mage::log("THIS IS THE LAST REFUND. REVERTING BACK ".$this->getcustomaddedsmogis($orderid)." BUCKS", null, 'partial_ankit.log');
                    Mage::getModel('rewardpoints/stats')->orderLog($orderincrementid, 'smogi refund', $this->getId(),$this->getcustomaddedsmogis($orderid), 'LAST PARTIAL REFUND. REFUNDING BUCKS BACK TO USER');
                    $sum_smogi_customization -= $this->getcustomaddedsmogis($orderid);
                    $order = $this->getOrder();
                    $order->setState(Mage_Sales_Model_Order::STATE_CLOSED, true)->save();
                }
                else
                {
                    if($this->issmogiused($orderid))
                    {
                        //Mage::log("THIS IS NOT THE LAST REFUND. ADDING ".$this->getmemodiscountamount($creditmemoid)." BUCKS", null, 'partial_ankit.log');    
                        Mage::getModel('rewardpoints/stats')->orderLog($orderincrementid, 'smogi refund', $this->getId(),$this->getmemodiscountamount($creditmemoid), 'PARTIAL REFUND. REFUNDING BUCKS BACK TO USER');
                        $sum_smogi_customization += $this->getmemodiscountamount($creditmemoid);
                    }
                    else
                    {
                        if(!$this->isdiscountused($orderid))
                        {
                            //Mage::log("NO DISCOUNTS USED ON THIS ORDER. TAKING BACK ".$this->calculateearnedpoints($creditmemoid)." BUCKS", null, 'partial_ankit.log');
                            Mage::getModel('rewardpoints/stats')->orderLog($orderincrementid, 'smogi refund', $this->getId(),$this->calculateearnedpoints($creditmemoid), 'NO DISCOUNTS USED. TAKING BACK POINTS FROM USER');
                            $sum_smogi_customization -= $this->calculateearnedpoints($creditmemoid);
                        }       
                    }
                }
                $sum_smogi_customization = round($sum_smogi_customization);
                if($sum_smogi_customization != 0)
                {
                    $proxy = new SoapClient(Mage::getBaseUrl().'api/soap/?wsdl');
            		$sessionId = $proxy->login('mobikasadeveloper', 'developerkey');
                    $order = $this->getOrder();
            		$customer_id = $order->getCustomerId();
            		$storeIds = 1;
                    if($sum_smogi_customization < 0)
                    {
                        $sum_smogi_customization *= -1;
                        //$proxy->call($sessionId, 'j2trewardapi.remove', array($customer_id, $sum_smogi_customization, $storeIds));
                        $proxy->call($sessionId, 'j2trewardapi.create', array(array('customer_id' => $customer_id, 'order_id' => $order->getIncrementId(), 'date_start' => date('Y-m-d'), 'points_spent' => $sum_smogi_customization, 'store_id' => $storeIds,'rewardpoints_description' => 'CreditMemo # '.$this->getIncrementId().'. Pulling back bucks added via partial refund(s).')));
            			$this->savetodb($order->getId(), (-1 * $sum_smogi_customization));
                    }
                    else
                    {
                        //$proxy->call($sessionId, 'j2trewardapi.add', array($customer_id, $sum_smogi_customization, $storeIds));
                        $read = Mage::getSingleton('core/resource')->getConnection('core_write');
                        $readresult=$read->query("SELECT * FROM smogi_store_expiry_date WHERE order_id = ".$order->getId()." AND (used_points - refunded_points) > 0 ORDER BY expiry_date DESC");

                        $temp = $sum_smogi_customization;
                        $count = 0;
                        while ($row = $readresult->fetch() ) {
                            if(($row['used_points'] - $row['refunded_points']) >= $temp)
                            {
                                $read->query("Update smogi_store_expiry_date set refunded_points=(refunded_points +".$temp.") where id=".$row['id']);
                                $proxy->call($sessionId, 'j2trewardapi.create', array(array('customer_id' => $customer_id, 'order_id' => $order->getIncrementId(), 'date_start' => date('Y-m-d'),'date_end' => $row['expiry_date'], 'points_current' => $temp, 'store_id' => $storeIds,'rewardpoints_description' => 'CreditMemo # '.$creditmemoid.'. Refunding bucks via partial refund.')));
                                $temp = 0;
                            }
                            else
                            {
                                $temp -= ($row['used_points'] - $row['refunded_points']);
                                $read->query("Update smogi_store_expiry_date set refunded_points=used_points where id=".$row['id']);
                                $proxy->call($sessionId, 'j2trewardapi.create', array(array('customer_id' => $customer_id, 'order_id' => $order->getIncrementId(), 'date_start' => date('Y-m-d'),'date_end' => $row['expiry_date'], 'points_current' => ($row['used_points'] - $row['refunded_points']), 'store_id' => $storeIds,'rewardpoints_description' => 'CreditMemo # '.$creditmemoid.'. Refunding bucks via partial refund.')));
                            }
                            $count = 1;
                            if($temp <= 0)
                                break;
                        }
                        if($count == 0)
                        {
                            $proxy->call($sessionId, 'j2trewardapi.create', array(array('customer_id' => $customer_id, 'order_id' => $order->getIncrementId(), 'date_start' => date('Y-m-d'),'date_end' => date('Y-m-d',strtotime("+ 365 days")), 'points_current' => $sum_smogi_customization, 'store_id' => $storeIds,'rewardpoints_description' => 'CreditMemo # '.$creditmemoid.'. Refunding bucks via partial refund and add 365 days expiries.')));
                        }
                        //$proxy->call($sessionId, 'j2trewardapi.create', array(array('customer_id' => $customer_id, 'order_id' => $order->getIncrementId(), 'date_start' => date('Y-m-d'),'date_end' => date('Y-m-d',strtotime("+ 10 days")), 'points_current' => $sum_smogi_customization, 'store_id' => $storeIds,'rewardpoints_description' => 'CreditMemo # '.$creditmemoid.'. Refunding bucks via partial refund.')));
                        $this->savetodb($order->getId(), $sum_smogi_customization);
                    }
                }            
            }
            else
            {
                //Mage::log("FULL REFUND AT ONCE. NO PROCESSING REQUIRED.", null, 'partial_ankit.log');
                Mage::getModel('rewardpoints/stats')->orderLog($orderincrementid, 'smogi refund', $this->getId(),'', 'FULL REFUND AT ONCE. NO PROCESSING REQUIRED');
                $order = $this->getOrder();
                $order->setState(Mage_Sales_Model_Order::STATE_CLOSED, true)->save();
            }   
        }
        catch(Exception $e)
        {
            Mage::getModel('rewardpoints/stats')->orderLog($orderincrementid, 'smogi refund', $this->getId(),$e->getMessage(), 'ERROR');
        }
    }
     
    protected function _afterSave()
    {
        if (null != $this->_items) {
            foreach ($this->_items as $item) {
                $item->save();
            }
        }

        if (null != $this->_comments) {
            foreach($this->_comments as $comment) {
                $comment->save();
            }
        }
		
        //Mage::log("\n\n\n\n\nCredit Memo Id =".$this->getId(), null, 'partial_ankit.log');
        $order = $this->getOrder();
        //Mage::log("Order Id =".$order->getId(), null, 'partial_ankit.log');
        if($order->getId() > Mage::getModel('core/variable')->loadByCode('partial_nonapplicable')->getValue('plain'))
            $this->refundsmogibucks($this->getId(), $order->getId());
        else
            Mage::getModel('rewardpoints/stats')->orderLog($order->getIncrementId(), 'smogi refund', $this->getId(),'', 'Not refunding SMOGI as is restricted by custom variable');
        //$read = Mage::getSingleton('core/resource')->getConnection('core_read');
//        $readresult=$read->query("Select order_id from sales_flat_creditmemo where entity_id=".$this->getId());
//        $row = $readresult->fetch();
        
        
        
        
        
        //$order = $this->getOrder();
//        $qtytorefund = Mage::getSingleton('core/session')->getQtyToRef();
//		$qty_ordered = $order->getTotalQtyOrdered();
//        $totrew = $order->getRewardpoints();
//        Mage::log('Qty refunding = '.$qtytorefund."<br/>Total Qty ordered = ".$qty_ordered."<br/>Reward Points Used = ".$totrew, null, 'partial.log');
        //Mage::throwException( Mage::helper('sales')->__('Qty refunding = '.$qtytorefund."<br/>Total Qty ordered = ".$qty_ordered."<br/>Reward Points Used = ".$totrew));		
        
        
        return parent::_afterSave();
    }

    /**
     * Before object save manipulations
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();

        if (!$this->getOrderId() && $this->getOrder()) {
            $this->setOrderId($this->getOrder()->getId());
            $this->setBillingAddressId($this->getOrder()->getBillingAddress()->getId());
        }

        return $this;
    }

    /**
     * Get creditmemos collection filtered by $filter
     *
     * @param array|null $filter
     * @return Mage_Sales_Model_Resource_Order_Creditmemo_Collection
     */
    public function getFilteredCollectionItems($filter = null)
    {
        return $this->getResourceCollection()->getFiltered($filter);
    }
	
}

