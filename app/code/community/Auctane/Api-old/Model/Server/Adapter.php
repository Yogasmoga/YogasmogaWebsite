<?php
/**
 * ShipStation
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@auctane.com so we can send you a copy immediately.
 *
 * @category   Shipping
 * @package	Auctane_Api
 * @license	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Auctane_Api_Model_Server_Adapter
	extends Varien_Object
	implements Mage_Api_Model_Server_Adapter_Interface
{
	/**
	 * Set handler class name for webservice
	 * Regular handlers are ignored because this adapter only performs one service.
	 *
	 * @param string $handler
	 * @return Auctane_Api_Model_Server_Adapter
	 */
	public function setHandler($handler)
	{
		$this->setData('handler', $handler);
		return $this;
	}

	/**
	 * Retreive handler class name for webservice
	 *
	 * @return string
	 */
	public function getHandler()
	{
		return $this->getData('handler');
	}

	 /**
	 * Set webservice api controller
	 *
	 * @param Auctane_Api_AuctaneController $controller
	 * @return Auctane_Api_Model_Server_Adapter
	 */
	public function setController(Mage_Api_Controller_Action $controller)
	{
		 $this->setData('controller', $controller);
		 return $this;
	}

	/**
	 * Retrive webservice api controller
	 *
	 * @return Auctane_Api_AuctaneController
	 */
	public function getController()
	{
		return $this->getData('controller');
	}

	/**
	 * Run webservice
	 *
	 * @return Auctane_Api_Model_Server_Adapter
	 */
	public function run()
	{
    	// Basic HTTP Authentication is used here, check on every request.
    	// Unlike RPC services there is no session
    	/* @var $user Mage_Api_Model_User */
    	$user = Mage::getModel('api/user');
		$auth_user = isset($_SERVER['HTTP_SS_AUTH_USER']) ? $_SERVER['HTTP_SS_AUTH_USER'] : @$_SERVER['PHP_AUTH_USER'];
		$auth_password = isset($_SERVER['HTTP_SS_AUTH_PW']) ? $_SERVER['HTTP_SS_AUTH_PW'] : @$_SERVER['PHP_AUTH_PW'];
		if (!$user->authenticate($auth_user, $auth_password)) {
			header(sprintf('WWW-Authenticate: Basic realm="%s"', Mage::getStoreConfig('auctaneapi/config/realm')));
			$this->fault(401, 'Unauthorized');
		}

		// In case store is part of URL path use it to choose config.
		$store = $this->getController()->getRequest()->get('store');
		if ($store) $store = Mage::app()->getStore($store);

		$apiConfigCharset = Mage::getStoreConfig("api/config/charset", $store);

		try { switch ($this->getController()->getRequest()->getParam('action', 'export')) {
			case 'export':
				$start_date = strtotime($this->getController()->getRequest()->getParam('start_date'));
				$end_date = strtotime($this->getController()->getRequest()->getParam('end_date'));
				if (!$start_date || !$end_date) throw new Exception('Start and end dates are required', 400);

				/* @var $orders Mage_Sales_Model_Mysql4_Order_Collection */
				$orders = Mage::getResourceModel('sales/order_collection');
				// might use 'created_at' attribute instead
				$orders->addAttributeToFilter('updated_at',
					array(
						'from' => date('Y-m-d H:i:s', $start_date),
						'to' => date('Y-m-d H:i:s', $end_date)
					));
				if ($store) $orders->addAttributeToFilter('store_id', $store->getId());

				$xml = new XMLWriter;
				$xml->openMemory();
				$xml->startDocument('1.0', $apiConfigCharset);
				$this->_writeOrders($orders, $xml, $store ? $store->getId() : 0);
				$xml->endDocument();

				$this->getController()->getResponse()
					->clearHeaders()
					->setHeader('Content-Type','text/xml; charset='.$apiConfigCharset)
					->setBody($xml->outputMemory(true));
				break;
			case 'shipnotify':
				// Raw XML is POSTed to this stream
				$xml = simplexml_load_file('php://input');

				// load some objects
				$order = $this->_getOrder($xml->OrderNumber);
				$carrier = $this->_getCarrier(@$xml->Carrier);
				$qtys = $this->_getOrderItemQtys(@$xml->Items, $order);
				$shipment = $this->_getOrderShipment($order, $qtys);

				// this is where tracking is actually added
				$track = Mage::getModel('sales/order_shipment_track')
					->setNumber($xml->TrackingNumber)
					->setCarrierCode($xml->Carrier)
					->setTitle($xml->Service);
				$shipment->addTrack($track);

				// Internal notes are only visible to admin
				if (@$xml->InternalNotes) {
					$shipment->addComment($xml->InternalNotes);
				}
				// Customer notes have 'Visible On Frontend' set
				// 'NotifyCustomer' must be "true" or "yes" to trigger an email
				if (@$xml->NotesToCustomer) {
					$notify = filter_var(@$xml->NotifyCustomer, FILTER_VALIDATE_BOOLEAN);
					if ($notify) {
						$shipment
							->sendEmail(true, $xml->NotesToCustomer)
							->setEmailSent(true);
					}
					$shipment->addComment($xml->NotesToCustomer, $notify, true);
				}

				Mage::getModel('core/resource_transaction')
					->addObject($shipment)
					->addObject($track)
					->save();
				// if there hasn't been an error yet the work is done and a "200 OK" is given
				break;
		}}
		catch (Exception $e) {
			$this->fault($e->getCode(), $e->getMessage());
		}

		return $this;
	}

	/**
	 * Dispatch webservice fault
	 *
	 * @param int $code
	 * @param string $message
	 */
	public function fault($code, $message)
	{
		if (is_numeric($code) && strlen((int) $code) === 3) {
			header(sprintf('%s %03d Fault', $_SERVER['SERVER_PROTOCOL'], $code));
		}
		header('Content-Type: text/xml; charset=UTF-8');
		die('<?xml version="1.0" encoding="UTF-8"?>
<fault>
	<faultcode>' . $code . '</faultcode>
	<faultstring>' . $message . '</faultstring>
</fault>
');
	}

	protected function _writeOrders(Varien_Data_Collection $orders, XMLWriter $xml, $storeId = null)
	{
		$xml->startElement('Orders');
		foreach ($orders as $order) {
			$this->_writeOrder($order, $xml, $storeId);
		}
		$xml->endElement(); // Orders
	}

	protected function _writeOrder(Mage_Sales_Model_Order $order, XMLWriter $xml, $storeId = null)
	{
		$history = '';
		/* @var $status Mage_Sales_Model_Order_Status */
		foreach ($order->getStatusHistoryCollection() as $status) {
			if ($status->getComment()) {
				$history .= $status->getCreatedAt() . PHP_EOL;
				$history .= $status->getComment() . PHP_EOL . PHP_EOL;
			}
		}
		$history = trim($history);
		if ($history) {
			$order->setStatusHistoryText($history);
		}

		/* @var $gift Mage_GiftMessage_Model_Message */
		$gift = Mage::helper('giftmessage/message')->getGiftMessage($order->getGiftMessageId());
		$order->setGift($gift->isObjectNew() ? 'false' : 'true');
		if (!$gift->isObjectNew()) {
			$order->setGiftMessage(sprintf("From: %s\nTo: %s\nMessage: %s",
				$gift->getSender(), $gift->getRecipient(), $gift->getMessage()));
		}

		$helper = Mage::helper('auctaneapi');

		$xml->startElement('Order');
		$helper->fieldsetToXml('sales_order', $order, $xml);

		$xml->startElement('Customer');
		$xml->writeElement('CustomerCode', $order->getCustomerEmail());

		$xml->startElement('BillTo');
		$helper->fieldsetToXml('sales_order_billing_address',
			$order->getBillingAddress(), $xml);
		$xml->endElement(); // BillTo

		$xml->startElement('ShipTo');
		$helper->fieldsetToXml('sales_order_shipping_address',
			$order->getShippingAddress(), $xml);
		$xml->endElement(); // ShipTo

		$xml->endElement(); // Customer

		$xml->startElement('Items');
		/* @var $item Mage_Sales_Model_Order_Item */
		foreach ($order->getItemsCollection($helper->getIncludedProductTypes()) as $item) {
			$this->_writeOrderItem($item, $xml, $storeId);
		}
		$xml->endElement(); // Items

		$xml->endElement(); // Order
	}

	protected function _writeOrderItem(Mage_Sales_Model_Order_Item $item, XMLWriter $xml, $storeId = null)
	{
		// inherit some attributes from parent order item
		if ($item->getParentItemId() && !$item->getParentItem()) {
			$item->setParentItem(Mage::getModel('sales/order_item')->load($item->getParentItemId()));
		}
		// only inherit if parent has been hidden
		if ($item->getParentItem() && ($item->getPrice() == 0.000)
		 && (Mage::helper('auctaneapi')->isExcludedProductType($item->getParentItem()->getProductType())))
		{
			$item->setPrice($item->getParentItem()->getPrice());
		}

		/* @var $gift Mage_GiftMessage_Model_Message */
		$gift = Mage::helper('giftmessage/message')->getGiftMessage(
			!$item->getGiftMessageId() && $item->getParentItem()
			? $item->getParentItem()->getGiftMessageId()
			: $item->getGiftMessageId());
		$item->setGift($gift->isObjectNew() ? 'false' : 'true');
		if (!$gift->isObjectNew()) {
			$item->setGiftMessage(sprintf("From: %s\nTo: %s\nMessage: %s",
				$gift->getSender(), $gift->getRecipient(), $gift->getMessage()));
		}

		/* @var $product Mage_Catalog_Model_Product */
		$product = Mage::getModel('catalog/product')
			->setStoreId($storeId)
			->load($item->getProductId());
		// inherit some attributes from parent product item
		if (($parentProduct = $this->_getOrderItemParentProduct($item, $storeId))) {
			if (!$product->getImage() || ($product->getImage() == 'no_selection'))
				$product->setImage($parentProduct->getImage());
			if (!$product->getSmallImage() || ($product->getSmallImage() == 'no_selection'))
				$product->setSmallImage($parentProduct->getSmallImage());
			if (!$product->getThumbnail() || ($product->getThumbnail() == 'no_selection'))
				$product->setThumbnail($parentProduct->getThumbnail());
		}

		$xml->startElement('Item');
		Mage::helper('auctaneapi')->fieldsetToXml('sales_order_item', $item, $xml);
		Mage::helper('auctaneapi')->fieldsetToXml('sales_order_item_product',
			$product, $xml);

		if ($item->getProductOptionByCode('options')) {
			$xml->startElement('Options');
			foreach ($item->getProductOptionByCode('options') as $option) {
				$this->_writeOrderItemOption($option, $xml, $storeId);
			}
			$xml->endElement(); // Options
		}

		$xml->endElement(); // Item
	}

	protected function _writeOrderItemOption($option, XMLWriter $xml)
	{
		$xml->startElement('Option');
		Mage::helper('auctaneapi')->fieldsetToXml('sales_order_item_option', $option, $xml);
		$xml->endElement(); // Option
	}

	/**
	 * @param string $carrierCode
	 * @return Mage_Shipping_Model_Carrier_Interface
	 */
	protected function _getCarrier($carrierCode)
	{
		$carrierCode = strtolower($carrierCode);
		$carrierModel = Mage::getStoreConfig("carriers/{$carrierCode}/model");
		if (!$carrierModel) throw new Exception('Invalid carrier specified.', 400);
		/* @var $carrier Mage_Shipping_Model_Carrier_Interface */
		$carrier = Mage::getModel($carrierModel);
		if (!$carrier) throw new Exception('Invalid carrier specified.', 400);
		if (!$carrier->isTrackingAvailable()) throw new Exception('Carrier does not supported tracking.', 400);
		return $carrier;
	}

	/**
	 * @param string $orderIncrementId
	 * @return Mage_Sales_Model_Order
	 */
	protected function _getOrder($orderIncrementId)
	{
		$order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
		if ($order->isObjectNew()) throw new Exception("Order '{$orderIncrementId}' does not exist", 400);
		return $order;
	}

	protected function _getOrderItemQtys(SimpleXMLElement $xmlItems, Mage_Sales_Model_Order $order)
	{
		/* @var $items Mage_Sales_Model_Mysql4_Order_Item_Collection */
		$items = $order->getItemsCollection();
		$qtys = array();
		/* @var $item Mage_Sales_Model_Order_Item */
		foreach ($items as $item) {
			// search for item by SKU
			@list($xmlItem) = $xmlItems->xpath(sprintf('//Item/SKU[text()="%s"]/..',
				addslashes($item->getSku())));
			if ($xmlItem) {
				// store quantity by order item ID, not by SKU
				$qtys[$item->getId()] = (float) $xmlItem->Quantity;
			}
		}
		return $qtys;
	}

	/**
	 * @param Mage_Sales_Model_Order_Item $item
	 * @param mixed $storeId
	 * @return Mage_Catalog_Model_Product
	 */
	protected function _getOrderItemParentProduct(Mage_Sales_Model_Order_Item $item, $storeId = null)
	{
		if ($item->getParentItemId()) {
			// cannot use getParentItem() because we stripped parents from the order
			$parentItem = Mage::getModel('sales/order_item')
				->load($item->getParentItemId());
			// initialise with store so that images are correct
			return Mage::getModel('catalog/product')
				->setStoreId($storeId)
				->load($parentItem->getProductId());
		}
		return null;
	}

	/**
	 * @param Mage_Sales_ModelOrder $order
	 * @param array $qtys
	 * @return Mage_Sales_Model_Order_Shipment
	 */
	protected function _getOrderShipment(Mage_Sales_Model_Order $order, $qtys)
	{
		/* @var $shipments Mage_Sales_Model_Mysql4_Order_Shipment_Collection */
		$shipments = $order->getShipmentsCollection();
		/* @var $shipment Mage_Sales_Model_Order_Shipment */
		if (($shipments === false) || ($shipments->count() === 0)) {
			// order has no shipments yet, create one
			$shipment = $order->prepareShipment($qtys);
			$shipment->register();
			$order->setIsInProgress(true);
			// shipment must have an ID before proceeding
			Mage::getModel('core/resource_transaction')
				->addObject($shipment)
				->addObject($order)
				->save();
		}
		else {
			// probably only one shipment for all items, assume the last is most recent
			$shipment = $shipments->getLastItem();
		}
		return $shipment;
	}

}
