

<?php
class Mycustommodules_Mycheckout_MycartController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Output from Cart Module";
    }
    
    protected function getSkinUrl($path)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/yogasmoga/yogasmoga-theme/".$path;
    }
    
    /**
     * Action list where need check enabled cookie
     *
     * @var array
     */
    protected $_cookieCheckActions = array('add');

    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current active quote instance
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
        return $this->_getCart()->getQuote();
    }

    /**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     */
    protected function _goBack()
    {
        $returnUrl = $this->getRequest()->getParam('return_url');
        if ($returnUrl) {

            if (!$this->_isUrlInternal($returnUrl)) {
                throw new Mage_Exception('External urls redirect to "' . $returnUrl . '" denied!');
            }

            $this->_getSession()->getMessages(true);
            $this->getResponse()->setRedirect($returnUrl);
        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
            && !$this->getRequest()->getParam('in_cart')
            && $backUrl = $this->_getRefererUrl()
        ) {
            $this->getResponse()->setRedirect($backUrl);
        } else {
            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
            }
            $this->_redirect('checkout/cart');
        }
        return $this;
    }

    /**
     * Initialize product instance from request data
     *
     * @return Mage_Catalog_Model_Product || false
     */
    protected function _initProduct()
    {
        $productId = (int) $this->getRequest()->getParam('product');
        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product->getId()) {
                return $product;
            }
        }
        return false;
    }

    public function giftExistsInCard($productId){
        $session = Mage::getSingleton('checkout/session');
        $count = 0;
        foreach ($session->getQuote()->getAllItems() as $item)
        {
            if($item->getProductId()==$productId)
                return true;
        }

        return false;
    }

    public function addAction()
    {
        Mage::getModel('smogiexpirationnotifier/applyremovediscount')->removesmogibucks();
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode() != ''){
            try{
                $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
                $this->_getQuote()->setCouponCode('')
                    ->collectTotals()
                    ->save();
                // refresh cart total
                $cart = Mage::getSingleton('checkout/session')->getQuote();

                foreach ($cart->getAllAddresses() as $address)
                {
                    $cart->unsetData('cached_items_nonnominal');
                    $cart->unsetData('cached_items_nominal');
                }

                $cart->setTotalsCollectedFlag(false);
                $cart->collectTotals();
            }catch (Exception $e){
                die($e->getMessage());
            }

        }

        Mage::getSingleton('giftcards/session')->setActive('0');

        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        $showhtml = $params['showhtml'];

        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                $this->_goBack();
                return;
            }

            $uniqueTimeStamp = date("Ymdhis");
            $productId = (int) $this->getRequest()->getParam('product');

            if(isset($params["type"]) && $params["type"]=="gift"){

                /************* checking if product is gift-set ****************/

                if($this->giftExistsInCard($productId)){
                    echo json_encode(array("status" => "exists"));
                    return;
                }

                $bundle = $params['bundle'];

                $arBundle = explode(",", $bundle);

                $cartItems = $cart->getQuote()->getAllItems();

                foreach($arBundle as $bundleProduct){

                    $arBundleProductOptions = explode(":", $bundleProduct);

                    if(count($arBundleProductOptions)==4) {                  // product id, color, size, bra-cup
                        $bundleProductId = $arBundleProductOptions[0];
                        $colorData = $arBundleProductOptions[1];
                        $sizeData = $arBundleProductOptions[2];
                        $braData = $arBundleProductOptions[3];

                        $arColorData = explode("-", $colorData);
                        $arSizeData = explode("-", $sizeData);
                        $arBraData = explode("-", $braData);

                        $arSuper = array($arColorData[0] => $arColorData[1], $arSizeData[0] => $arSizeData[1], $arBraData[0] => $arBraData[1]);
                    }
                    else{
                        $bundleProductId = $arBundleProductOptions[0];
                        $colorData = $arBundleProductOptions[1];
                        $sizeData = $arBundleProductOptions[2];

                        $arColorData = explode("-", $colorData);
                        $arSizeData = explode("-", $sizeData);

                        $arSuper = array($arColorData[0] => $arColorData[1], $arSizeData[0] => $arSizeData[1]);
                    }

                    $data = array(
                        'qty' => 1,
                        'super_attribute' => $arSuper,
                        'product' => $bundleProductId,
                        'type' => 'gift-bundled',
                        'unique_time_stamp' => $uniqueTimeStamp,
                        'main_product_id' => $product->getId()
                    );

                    /************* check if part of gift set is already in cart, if yes, remove it ****************/
                    foreach ($cartItems as $item) {
                        $childProduct = Mage::getModel('catalog/product_type_configurable')->getProductByAttributes($arSuper, $product);

                        $buyRequest = $item->getBuyRequest();

                        // if we are trying to remove gift set
                        if (!isset($buyRequest)) {      // a normal product is found
                            if($childProduct->getProductId()==$item->getProductId()){
                                $cart->removeItem($item->getId());
                            }
                        }
                    }
                    /************* check if part of gift set is already in cart, if yes, remove it ****************/

                    $bundledProduct = Mage::getModel('catalog/product')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->load($bundleProductId);

                    $cart->addProduct($bundledProduct, $data);
                }
                /************* checking if product is gift-set ****************/
            }
            else{
                /************** check if we are purchasing a product that is part of gift set *********/

                $isAlreadyPartOfGiftSet = false;

                $childProduct = Mage::getModel('catalog/product_type_configurable')->getProductByAttributes($this->getRequest()->getParam('super_attribute'), $product);

                if($childProduct) {
                    $cartItems = $cart->getQuote()->getAllItems();

                    foreach ($cartItems as $item) {

                        $buyRequest = $item->getBuyRequest();

                        // if we are trying to remove gift set
                        if(isset($buyRequest) && isset($buyRequest['type']) && $buyRequest['type']=="gift-bundled") {

                            if ($childProduct->getId() == $item->getProductId()) {
                                $isAlreadyPartOfGiftSet = true;
                                break;
                            }
                        }
                    }

                    if ($isAlreadyPartOfGiftSet) {
                        echo json_encode(array("status" => "ingiftset"));
                        return;
                    }
                }
                /************** check if we are purchasing a product that is part of gift set *********/
            }


            $params['unique_time_stamp'] = $uniqueTimeStamp;
            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
            $minicarthtml = '';
            if($showhtml == '')
                $minicarthtml = $this->getminicarthtml();
            echo json_encode(array("status" => "success","html" => $minicarthtml , "count" => $this->getcartcount()));
        } catch (Mage_Core_Exception $e) {
            echo json_encode(array("status" => "error", "reason" => $e->getMessage()));
        } catch (Exception $e) {
            echo json_encode(array("status" => "error"));
            //$this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
//            Mage::logException($e);
//            $this->_goBack();
        }
    }

	public function addmobileAction()
    {
		Mage::getModel('smogiexpirationnotifier/applyremovediscount')->removesmogibucks();
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode() != ''){
            try{
                $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
                $this->_getQuote()->setCouponCode('')
                    ->collectTotals()
                    ->save();
                // refresh cart total
                $cart = Mage::getSingleton('checkout/session')->getQuote();

                foreach ($cart->getAllAddresses() as $address)
                {
                    $cart->unsetData('cached_items_nonnominal');
                    $cart->unsetData('cached_items_nominal');
                }

                $cart->setTotalsCollectedFlag(false);
                $cart->collectTotals();
            }catch (Exception $e){
                die($e->getMessage());
            }

        }

        Mage::getSingleton('giftcards/session')->setActive('0');

        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        //$showhtml = $params['showhtml'];
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                $this->_goBack();
                return;
            }

          //  $cart->addProduct($product, $params);
           // if (!empty($related)) {
            //    $cart->addProductsByIds(explode(',', $related));
            //}

			
			
			$uniqueTimeStamp = date("Ymdhis");

            if(isset($params["type"]) && $params["type"]=="gift"){

                /************* checking if product is gift-set ****************/

                $productId = (int) $this->getRequest()->getParam('product');
                if($this->giftExistsInCard($productId)){
                    echo json_encode(array("status" => "exists"));
                    return;
                }

                $bundle = $params['bundle'];

                $arBundle = explode(",", $bundle);

                foreach($arBundle as $bundleProduct){

                    $arBundleProductOptions = explode(":", $bundleProduct);

                    if(count($arBundleProductOptions)==4) {                  // product id, color, size, bra-cup
                        $bundleProductId = $arBundleProductOptions[0];
                        $colorData = $arBundleProductOptions[1];
                        $sizeData = $arBundleProductOptions[2];
                        $braData = $arBundleProductOptions[3];

                        $arColorData = explode("-", $colorData);
                        $arSizeData = explode("-", $sizeData);
                        $arBraData = explode("-", $braData);

                        $arSuper = array($arColorData[0] => $arColorData[1], $arSizeData[0] => $arSizeData[1], $arBraData[0] => $arBraData[1]);
                    }
                    else{
                        $bundleProductId = $arBundleProductOptions[0];
                        $colorData = $arBundleProductOptions[1];
                        $sizeData = $arBundleProductOptions[2];

                        $arColorData = explode("-", $colorData);
                        $arSizeData = explode("-", $sizeData);

                        $arSuper = array($arColorData[0] => $arColorData[1], $arSizeData[0] => $arSizeData[1]);
                    }

                    $data = array(
                        'qty' => 1,
                        'super_attribute' => $arSuper,
                        'product' => $bundleProductId,
                        'type' => 'gift-bundled',
                        'unique_time_stamp' => $uniqueTimeStamp,
                        'main_product_id' => $product->getId()
                    );

                    $bundledProduct = Mage::getModel('catalog/product')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->load($bundleProductId);

                    $cart->addProduct($bundledProduct, $data);
                }
                /************* checking if product is gift-set ****************/
            }
            else{
                /************** check if we are purchasing a product that is part of gift set *********/

                $isAlreadyPartOfGiftSet = false;

                $childProduct = Mage::getModel('catalog/product_type_configurable')->getProductByAttributes($this->getRequest()->getParam('super_attribute'), $product);

                if($childProduct) {
                    $cartItems = $cart->getQuote()->getAllItems();

                    foreach ($cartItems as $item) {

                        $buyRequest = $item->getBuyRequest();

                        // if we are trying to remove gift set
                        if(isset($buyRequest) && isset($buyRequest['type']) && $buyRequest['type']=="gift-bundled") {

                            if ($childProduct->getId() == $item->getProductId()) {
                                $isAlreadyPartOfGiftSet = true;
                                break;
                            }
                        }
                    }

                    if ($isAlreadyPartOfGiftSet) {
                        echo json_encode(array("status" => "ingiftset"));
                        return;
                    }
                }
                /************** check if we are purchasing a product that is part of gift set *********/
            }


            $params['unique_time_stamp'] = $uniqueTimeStamp;
            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

			
			
			
            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );

			

			ob_start();
			?>
			
			<?php echo $this->getcartcount();?>
		    
			<?php
			$mincarthtml = ob_get_clean();
			ob_flush();

			
           // $minicarthtml = '';
            //if($showhtml == '')
               // $minicarthtml = $this->getminicarthtml();
           // echo json_encode(array("status" => "success", "count" => $this->getcartcount()));
		   echo json_encode(array("status" => "success","html" => $mincarthtml , "count" => $this->getcartcount()));
            //echo "success";
            //if (!$this->_getSession()->getNoCartRedirect(true)) {
//                if (!$cart->getQuote()->getHasError()){
//                    $message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
//                    $this->_getSession()->addSuccess($message);
//                }
//                $this->_goBack();
//            }
        } catch (Mage_Core_Exception $e) {
            echo json_encode(array("status" => "error"));
        
        } catch (Exception $e) {
            echo json_encode(array("status" => "error"));
            //$this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
//            Mage::logException($e);
//            $this->_goBack();
        }
    }
    
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        if ($id) {

            try {
                $this->_getCart()->removeItem($id)
                    ->save();
            } catch (Exception $e) {
                echo json_encode(array("status" => "error"));
                //$this->_getSession()->addError($this->__('Cannot remove the item.'));
                Mage::logException($e);
                return;
            }

        }
        $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
        $subtotal = $totals["subtotal"]->getValue(); //Subtotal value
        echo json_encode(array("status" => "success", "data" => $data, "count" => $this->getcartcount(), "grandtotal" => "$".number_format((float)$subtotal, 2, '.','')));
    }
    
    
    function getMiniImage($productid, $color)
    {
        $_product = Mage::getModel('catalog/product')->load($productid);
        $_gallery = $_product->getMediaGalleryImages();
        foreach($_gallery as $_image)
        {
            $imgdata = json_decode(trim($_image->getLabel()), true);
            if($imgdata == NULL || strcasecmp($imgdata['type'], "product image") != 0)
                continue;
            if($imgdata['color'] != $color)
                continue;
            //if(strpos($_image->getLabel(), $color) === false)
//            //if(strpos($_image->getLabel(),"*") === false)
//                continue;
            return "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(43, 65)->setQuality(100);
        }
        return "";
    }

    // return gift set image for cart
    function getGiftSetMiniImage($productid)
    {
        $_product = Mage::getModel('catalog/product')->load($productid);
        $_gallery = Mage::getModel('catalog/product')->load($productid)->getMediaGalleryImages();
        foreach($_gallery as $_image)
        {
            $imgdata = json_decode(trim($_image->getLabel()), true);
            return "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100, 100)->setQuality(100);
        }
        return "";
    }

    public function searchcart($minidetails, $sku)
    {
        foreach($minidetails as $item)
        {
            if($item['sku'] == $sku)
                return true;
        }
        return false;
    }
    
    public function getcartcount()
    {
/*************** original code ***************/
/*
        $cart = Mage::getModel('checkout/cart')->getQuote()->getData();
        if(isset($cart['items_qty'])){
            return (int)$cart['items_qty'];
        } else {
            return 0;
        }
*/
        $session = Mage::getSingleton('checkout/session');
        $count = 0;
        foreach ($session->getQuote()->getAllItems() as $item)
        {
            if(Mage::getModel('catalog/product')->load($item->getProductId())->getTypeID() == "configurable")
            {
                $buyRequest = $item->getBuyRequest();
                $product_type = $buyRequest['type'];

                if(isset($product_type) && $product_type=="gift-bundled")
                    continue;

                ++$count;
            }
        }

        return $count;
    }
    
    public function issuperattribute($_product, $superattribute)
    {
        $configurableAttributeCollection=$_product->getTypeInstance()->getConfigurableAttributes();
        $sizeavaliable = false;
        foreach($configurableAttributeCollection as $attribute){
            if($attribute->getProductAttribute()->getAttributeCode() == $superattribute)
            {
                return true;
            }
        }
        return false;
    }
    
    public function getminicarthtml()
    {
        //$output .= "SKU = ".Mage::getModel('catalog/product')->load($item->getProductId())->getTypeID() . "<br>";
//        $output .= "SKU = ".$item->getSku() . "<br>";
//        $output .= "Namw = ".$item->getName() . "<br>";
//        $output .= "Description = ".$item->getDescription() . "<br>";
//        $output .= "QTY = ".$item->getQty() . "<br>";
//        $output .= $item->getBaseCalculationPrice() . "<br>";
//        $output .= $item->getProductId() . "<br>";
//        $output .= "<br>";
        $output = "";
        if(Mage::getModel('checkout/cart')->getQuote()->getItemsCount() == 0)
        {
            $output = "<div class='minctitle'>Shopping bag</div><div class='totalitemcount noitem'>You have no items in your bag.</div>";
            return $output;
        }
        $_helper = Mage::helper('catalog/output');
        $minidetails = array();
        $miniitems = array();
        $mageFilename = 'app/Mage.php';
        require_once $mageFilename;
        umask(0);
        Mage::app();
        Mage::getSingleton('core/session', array('name'=>'frontend'));
        $session = Mage::getSingleton('checkout/session');
        
        foreach ($session->getQuote()->getAllItems() as $item) 
        {
            $temparray = array();
            if(Mage::getModel('catalog/product')->load($item->getProductId())->getTypeID() == "configurable")
            {
                if($this->searchcart($miniitems, $item->getSku()) == false)
                {
                    $_product = Mage::getModel('catalog/product')->loadByAttribute('sku',$item->getSku());
                    $product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $temparray['sku'] = $item->getSku();
                    //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                    $temparray['name'] = $item->getName();
                    if(strlen($temparray['name']) > 12)
                        $temparray['name'] = substr($temparray['name'], 0, 11)."...";
                    
                    if($this->issuperattribute($product, "color"))
                    {
                        $temparray['color'] = $_product->getAttributeText('color');
                        if(strpos($temparray['color'], "|") !== false)
                            $temparray['color'] = substr($temparray['color'], 0, strpos($temparray['color'], "|"));   
                    }
                    if($this->issuperattribute($product, "size"))
                        $temparray['size'] = $_product->getAttributeText('size');
                    $temparray['quantity'] = $item->getQty();
                    $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                    //$temparray['imageurl'] = $this->getMiniImage($item->getProductId(), $temparray['color']);
                    //$temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));

                    /******************* gift set check ****************/

                    $buyRequest = $item->getBuyRequest();

                    if(isset($buyRequest['type'])) {
                        $product_type = $buyRequest['type'];

                        if (isset($product_type)) {
                            $temparray['product_type'] = $product_type;         // there should not be any remove icon on cart for this

                            if ($product_type == 'gift')
                                $temparray['imageurl'] = $this->getGiftSetMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
                            else
                                $temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
                        } else {
                            $temparray['product_type'] = null;
                            $temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
                        }
                    }
                    else{
                        $temparray['product_type'] = null;
                        $temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
                    }

                    /******************* gift set  check ****************/


                    $temparray['itemid'] = $item->getItemId();
                    $temparray['producturl'] = Mage::getModel('catalog/product')->load($item->getProductId())->getProductUrl();
                    array_push($miniitems, $temparray);
                }
            }
            elseif(Mage::getModel('catalog/product')->load($item->getProductId())->getTypeID() == "simple")
            {
                if($this->searchcart($miniitems, $item->getSku()) == false)
                {
                    $_product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $temparray['sku'] = $item->getSku();
                    //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                    $temparray['name'] = $item->getName();
                    if(strlen($temparray['name']) > 12)
                        $temparray['name'] = substr($temparray['name'], 0, 11)."...";
                    $temparray['quantity'] = $item->getQty();
                    $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                    $temparray['imageurl'] = $this->getMiniImage($item->getProductId());
                    $temparray['imageurl'] = "_".Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(43, 65)->setQuality(100);
                    $temparray['producturl'] = $_product->getProductUrl();
                    $temparray['itemid'] = $item->getItemId();
                    array_push($miniitems, $temparray);
                }
            }
            else
            {
                //if($this->searchcart($miniitems, $item->getSku()) == false)
//                {
                    $_product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $temparray['sku'] = $item->getSku();
                    //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                    $temparray['name'] = $item->getName();
                    if(strlen($temparray['name']) > 12)
                        $temparray['name'] = substr($temparray['name'], 0, 11)."...";
                    $temparray['quantity'] = $item->getQty();
                    $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                    $temparray['imageurl'] = $this->getMiniImage($item->getProductId());
                    $temparray['imageurl'] = "_".Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(43, 65)->setQuality(100);
                    $temparray['producturl'] = $_product->getProductUrl();
                    $temparray['itemid'] = $item->getItemId();
                    array_push($miniitems, $temparray);
                //}
            }
        }
        //$totalItems = Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
//        echo "Total Items:".$totalItems."<br/>";
//        $grandTotal = Mage::getModel('checkout/cart')->getQuote()->getGrandTotal();
//        echo "Grand total:".$grandTotal."<br/>";
//        
//        print $output;
        
        $miniitems = array_reverse($miniitems);
        
        $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
        $subtotal = $totals["subtotal"]->getValue(); //Subtotal value
        
        $minidetails['items'] = $miniitems;
        //$minidetails['totalitems'] = Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
        $minidetails['totalitems'] = $this->getcartcount();
        $minidetails['cartlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/cart";
        $minidetails['subtotal'] = "$".number_format((float)$subtotal, 2, '.','');// round(Mage::getModel('checkout/cart')->getQuote()->getGrandTotal(), 2);
        $minidetails['checkoutlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/onepage";
        
        //echo "<pre>";
//        print_r($minidetails);
//        echo "</pre>";
        if($minidetails['totalitems'] > 1)
            $output = "<div class='minctitle'>Shopping bag</div><div class='totalitemcount'><table><tr><td>You have <span class='cartitemcount'>".$minidetails['totalitems']."</span> items in your bag.</td></tr></table></div>";
        else
            $output = "<div class='minctitle'>Shopping bag</div><div class='totalitemcount'><table><tr><td>You have ".$minidetails['totalitems']." item in your bag.</td></tr></table></div>";
        $productcount = 1;
        foreach($minidetails['items'] as $item)
        {
            if($productcount > 5)
                break;
            //$output .= "<a href='".$item['producturl']."'>";
            $output .= "<div id='".$item['itemid']."' class='minicartitems'> <table> <tr> <td class='tdproductimage'> <img src='".substr($item['imageurl'], 1)."' /> </td> <td class='tdproductdetail'> <div class='productname'>".html_entity_decode($item['name'])."</div>";
            if(isset($item['color']))
                $output .= "<div class='productdetail'><span class='productattribute'>COLOR:</span>&nbsp;".$item['color']."</div>";
            if(isset($item['size']))
                $output .= "<div class='productdetail'><span class='productattribute'>SIZE:</span>&nbsp;".$item['size']."</div>";
            
            $output .= "<div class='productdetail'><span class='productattribute'>QTY:</span>&nbsp;".$item['quantity']."</div></td> <td class='tdproductprice'> ".$item['price']." </td> </tr> </table> <img class='delete' src='".$this->getSkinUrl('images/cross_mini_cart.png')."' /> </div>";
            //$output .= "</a>";
            $productcount++;
        }
        //$output .= "<div class='bottomlinks'><a href='".$minidetails['cartlink']."'><div class='gotoshoppingbag spbutton' imageurl='".$this->getSkinUrl('images/go_to_shopping_bag_01off.png')."' downimageurl='".$this->getSkinUrl('images/go_to_shopping_bag_01on.png')."'></div></a> <div class='subtotal'> <table> <tr> <td class='anchor'> SUBTOTAL </td> <td class='totalprice'> ".$minidetails['subtotal']." </td> </tr> </table> </div> <a href='".$minidetails['checkoutlink']."'> <div class='minicheckout spbutton' imageurl='".$this->getSkinUrl('images/checkout_off.png')."' downimageurl='".$this->getSkinUrl('images/checkout_on.png')."'></div></a></div>";
        $output .= "<div class='bottomlinks'><div class='subtotal'> <table> <tr> <td class='anchor'> SUBTOTAL </td> <td class='totalprice'> ".$minidetails['subtotal']." </td> </tr> </table> </div> <a href='".$minidetails['cartlink']."'> <div class='minicheckout spbutton' imageurl='".$this->getSkinUrl('images/checkout_off.png')."' downimageurl='".$this->getSkinUrl('images/checkout_on.png')."'></div></a></div>";
        return $output;
    }
    
    public function minidetailsAction()
    {
        $output = $this->getminicarthtml();
        echo json_encode(array("html" => $output, "count" => $this->getcartcount()));
    }
    
    function getShippingCost($code)
    {
        //$rates = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->collectShippingRates()->getGroupedAllShippingRates();
//         foreach ($rates as $carrier) {
//            foreach ($carrier as $rate) {
//                print_r($rate->getData());
//            }
//        }
        $rates = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->collectShippingRates()->getGroupedAllShippingRates();
         foreach ($rates as $carrier) {
            foreach ($carrier as $rate) {
                $temp = $rate->getData();
                if($temp['code'] == $code)
                    return $temp['price'];
            }
        }
        return "";
    }
    
    function getDiscountsummary()
    {
        //$rates = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->collectShippingRates()->getGroupedAllShippingRates();
//         foreach ($rates as $carrier) {
//            foreach ($carrier as $rate) {
//                print_r($rate->getData());
//            }
//        }
        $summary = "";
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()) > 0)
            $summary .= "Gift of YS Card";
        if(Mage::helper('rewardpoints/event')->getCreditPoints() > 0)
        {
            if(strlen($summary) > 0)
                $summary .= " and <br/>";
            $summary .= Mage::helper('rewardpoints/event')->getCreditPoints()." SMOGI Bucks used";
        }
        $coupon_code = Mage::getSingleton('checkout/session')->getQuote()->getCouponCode();
        if($coupon_code){
            if(strlen($summary) > 0)
                $summary .= " and <br/>";
            $summary .= $coupon_code." Promotion";
        }
        if(strlen($summary) == 0)
            $summary = "Discount";
        return $summary;
    }
    
    public function getCartSummaryAction()
    {
        $quote = Mage::helper('checkout')->getQuote()->getData();
        $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
        $subtotal = $totals["subtotal"]->getValue(); //Subtotal value
        $grandtotal = $totals["grand_total"]->getValue(); //Grandtotal value
        if(isset($totals['discount']) && $totals['discount']->getValue()) {
            $discount = $totals['discount']->getValue() * -1; //Discount value if applied
        } else {
            $discount = 0;
        }
        if(isset($totals['tax']) && $totals['tax']->getValue()) {
            $tax = $totals['tax']->getValue(); //Tax value if present
        } else {
            $tax = 0;
        }
        ?>
        <span class="anchor dnone">ORDER SUMMARY</span>
        <table>
            <tr>
                <td><?php echo $this->getcartcount().' ITEMS'?><!-- Order Subtotal --></td>
                <td id="ordersubtotal" class="total">
                    $<?php echo number_format((float)($subtotal), 2, '.', ''); ?>
                </td>
            </tr>
            <?php
                if($tax > 0)
                {
                    ?>
                        <tr>
                            <td>Taxes</td>
                            <td id="taxtotal" class="total">
                                <?php echo "$".number_format((float)($tax), 2, '.', ''); ?>
                            </td>
                        </tr>
                    <?php
                }
            ?>
            <tr>
                <td>Shipping</td>
                <td id="shippingtotal" class="total">
                    <?php $shippingcode = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getShippingMethod();
                        if($shippingcode == "")
                            echo "-";
                        else
                            if($this->getShippingCost($shippingcode) == 0)
                                echo "FREE";
                            else
                                echo "$".number_format((float)($this->getShippingCost($shippingcode)), 2, '.', '');
                    ?>
                </td>
            </tr>
            <?php
                if($discount > 0)
                {
                    ?>
                        <tr>
                            <td><?php echo $this->getDiscountsummary(); ?></td>
                            <td id="discounttotal" class="total">
                                <?php echo "-$".number_format((float)($discount), 2, '.', ''); ?>
                            </td>
                        </tr>
                    <?php
                }
            ?>
            <tr>
                <td colspan="2" class="divider"></td>
            </tr>
            <tr class="ordertotal">
                <td><span class="anchor">GRAND TOTAL</span></td>
                <td id="ordertotal" class="total">
                    <?php echo "$".number_format((float)($grandtotal), 2, '.', ''); ?>
                </td>
            </tr>
        </table>
        <?php
    }
}
?>