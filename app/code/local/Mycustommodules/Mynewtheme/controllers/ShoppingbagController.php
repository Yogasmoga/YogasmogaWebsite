<?php
class Mycustommodules_Mynewtheme_ShoppingbagController extends Mage_Core_Controller_Front_Action
{
    protected $points_current = '';
    public function testAction()
    {
        echo "Output newtheme_ShoppingbagController";
    }

    public function showshoppingbaghtmlAction1()
    {

        $html = '';
        $itemcount = $this->getcartcount();
        if($itemcount < 1)
        {
            $html = "<h1>Your cart is Empty.</h1>";
            echo json_encode(array("html" => $html));
            return;
        }
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
                    if(strlen($temparray['name']) > 20)
                        $temparray['name'] = substr($temparray['name'], 0, 19)."...";

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
                    $temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
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
                    if(strlen($temparray['name']) > 20)
                        $temparray['name'] = substr($temparray['name'], 0, 19)."...";
                    $temparray['quantity'] = $item->getQty();
                    $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                    $temparray['imageurl'] = $this->getMiniImage($item->getProductId());
                    $temparray['imageurl'] = "_".Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100, 100)->setQuality(100);
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
                if(strlen($temparray['name']) > 20)
                    $temparray['name'] = substr($temparray['name'], 0, 19)."...";
                $temparray['quantity'] = $item->getQty();
                $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                $temparray['imageurl'] = $this->getMiniImage($item->getProductId());
                $temparray['imageurl'] = "_".Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100, 100)->setQuality(100);
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
        $grandtotal = $totals["grand_total"]->getValue();

        $minidetails['items'] = $miniitems;
        //$minidetails['totalitems'] = Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
        $minidetails['totalitems'] = $this->getcartcount();
        $minidetails['cartlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/cart";
        $minidetails['subtotal'] = "$".number_format((float)$subtotal, 2, '.','');// round(Mage::getModel('checkout/cart')->getQuote()->getGrandTotal(), 2);
        $minidetails['grandtotal'] = "$".number_format((float)$grandtotal, 2, '.','');
        $minidetails['checkoutlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/onepage";


        $html = '<div class="shopping-cart">
    <!-- ContinueShoppingBtn -->
    <div class="cont-full capstxt">
        <a href="javascript:void(0);" id="continuelink" class="continuelink f-left">Continue Shopping</a>
        <a href="<?php echo $this->getBaseUrl();?>checkout_new" class="continuelink f-right grn">Continue</a>
    </div>
    <!-- ContinueShoppingBtn -->
    <!-- productOption -->
    <div class="cont-full">';
        $totalhtml = '
                        <!-- totalAmount -->
                        <div class="totalAmnt capstxt">
                            <span class="f-left">Total</span>
                            <span class="f-right">'.$minidetails['grandtotal'].'</span>
                        </div>
                        <!-- totalAmount -->';
        $html .= $totalhtml;
        $html .='
                    <!-- listItems -->
                    <ul>
                        <li>
                            <span class="f-left capstxt">'.$minidetails['totalitems'].' item</span>
                            <span class="f-right">'.$minidetails['subtotal'].'</span>
                        </li>
                        <li>
                            <span class="f-left">Shipping: FREE</span>
                            <span class="f-right capstxt">Free</span>
                        </li>
                    </ul>
                    <!-- listItems -->
                    <p class="c-align">Use your SMOGI Bucks for this purchase</p>
                    <!-- addItem Input -->
                    <div class="adddields">
                        <form>
                            <label><input type="text" name="count" id="count" value="10" /><span>+</span></label>
                            <label><input type="text" name="promocode" id="promocode" value="Add a promo code " /><span>+</span></label>
                            <label><input type="text" name="giftcartcode" id="giftcartcode" value="Add a gift card code" /><span>+</span></label>

                        </form>
                    </div>
                    <!-- addItem Input -->
                </div>
                <!-- productOption -->
                <!-- stripGry -->
                <div class="strip-gry">Free and fast shipping to US and Canada</div>
                <!-- stripGry -->
                <!-- productadded -->
                <div class="addedItem">
                    <ul class="similarProdList">';
        foreach($minidetails['items'] as $item)
        {

        $html .='<li>
                <a href="'.$item['producturl'].'"><span class="wdth100"><img alt="'.$item['name'].'" src="'.substr($item['imageurl'], 1).'" ></span></a>
<span>
                    <span class="quantity">qty '.$item['quantity'].'</span>
                    <span class="pname">'.$item['name'].'</span>
                    <span class="amnt">'.$item['price'].'</span>
                    <span class="clr">'.$item['color'].'</span>
                    <span class="size">size '.$item['size'].'</span>
                </span>
<a href="#" class="close"></a>
</li>';
        }
            // show bracelet if it is not in cart else do not show
        $namaskarbracelet = array();
        $productId = Mage::getModel('core/variable')->loadByCode('namaskar_bracelet_id')->getValue('plain');
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $foundInCart = false;
        foreach($quote->getAllVisibleItems() as $item) {
            if ($item->getData('product_id') == $productId) {
                $foundInCart = true;
                break;
            }
        }
        if(!$foundInCart)
        {
            // check for instorck and pre-ordered
            $doNotShowBracelet = false;
            $_product = Mage::getModel('catalog/product')->load(Mage::getModel('core/variable')->loadByCode('namaskar_bracelet_id')->getValue('plain'));
            $_childproducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);
            foreach($_childproducts as $_childproduct)
            {
                //echo '<pre>'; print_r($_childproduct);die;

                $qty = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
                $stock = $_childproduct->getStockItem();
                $inStock = $stock->getIsInStock();
                $isPreorder = (int) Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getBackorders();
                if(!(($inStock == 0)&&($isPreorder == 0)))
                {
                    $doNotShowBracelet = true;
                }


            }
            // end check for in stock

            if($doNotShowBracelet)
            {
                ?>
                <?php /* speed fix
                                <script type="text/javascript" src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS); ?>jquery/shoppingbag.js"></script>
                                */ ?>
                <?php
                $_helper = Mage::helper('catalog/output');
                $_product = Mage::getModel('catalog/product')->load(Mage::getModel('core/variable')->loadByCode('namaskar_bracelet_id')->getValue('plain'));
                $producturl = $_product->getProductUrl();
                $productname = $_helper->productAttribute($_product, $_product->getName(), 'name');
                $productid = $_product->getId();
                $price = $_product->getSpecialPrice();

                if($price == "")
                    $price = $_product->getPrice();
                $price = round($price,2);
                if (floor($price)==$price)
                    $price = floor($price);
                $rewardpoints = Mage::helper('rewardpoints/data')->getProductPointsText($_product, false, false);
                $rewardpoints = strip_tags($rewardpoints);
                $rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "loyalty") - 1 - strlen("loyalty") - strpos($rewardpoints, "earn") + strlen("earn")));
                $productrewardpoints = $rewardpoints;
                //$productrewardpoints = floor($price * $_rewardpointsearned);
                $productprice = "$".$price;

                $_childproducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);
                $_gallery = Mage::getModel('catalog/product')->load($_product->getId())->getMediaGalleryImages();
                $productcolorinfo = array();
                $configurableAttributeCollection=$_product->getTypeInstance()->getConfigurableAttributes();
                $sizeavaliable = false;
                foreach($configurableAttributeCollection as $attribute){
                    if($attribute->getProductAttribute()->getAttributeCode() == "size")
                    {
                        $sizeavaliable = true;
                        break;
                    }
                    //echo "Attr-Code:".$attribute->getProductAttribute()->getAttributeCode()."<br/>";
                    //        echo "Attr-Label:".$attribute->getProductAttribute()->getFrontend()->getLabel()."<br/>";
                    //        echo "Attr-Id:".$attribute->getProductAttribute()->getId()."<br/>";
                }
                foreach($_childproducts as $_childproduct)
                {
                    //echo '<pre>'; print_r($_childproduct);

                    //echo Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
                    $temp = $_childproduct->getAttributeText('color');
                    if(strpos($temp,"|") !== FALSE)
                    {
                        $hexcodes = substr($temp, strpos($temp,"|") + 1);
                        $hexcodes = explode(",", $hexcodes);
                        $temp = substr($temp, 0, strpos($temp,"|"));
                        if(!isset($productcolorinfo[$temp]))
                            $productcolorinfo[$temp] = array();
                        $productcolorinfo[$temp]['hex'] = $hexcodes;
                        $productcolorinfo[$temp]['value'] = Mage::getResourceModel('catalog/product')->getAttributeRawValue($_childproduct->getId(), 'color', Mage::app()->getStore()->getStoreId());
                    }
                    $price = $_childproduct->getSpecialPrice();
                    if($price == "")
                        $price = $_childproduct->getPrice();
                    $price = round($price,2);
                    if (floor($price)==$price)
                        $price = floor($price);

                    $rewardpoints = Mage::helper('rewardpoints/data')->getProductPointsText($_childproduct, false, false);
                    $rewardpoints = strip_tags($rewardpoints);
                    $rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "loyalty") - 1 - strlen("loyalty") - strpos($rewardpoints, "earn") + strlen("earn")));
                    if($sizeavaliable)
                        $temp1 = $_childproduct->getAttributeText('size')."|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
                    else
                        $temp1 = "2|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
                    //$temp1 = $_childproduct->getAttributeText('size')."|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
                    //if(array_key_exists("sizes", $productcolorinfo[$temp]))
                    if(isset($productcolorinfo[$temp]["sizes"]))
                    {
                        //echo "pushing";
                        array_push($productcolorinfo[$temp]["sizes"], $temp1);
                    }
                    else
                    {
                        $productcolorinfo[$temp]["sizes"] = array($temp1);
                        if(!isset($productcolorinfo[$temp]["sizes"]))
                            echo "not set";
                        foreach($_gallery as $_image)
                        {
                            if(str_replace("*", "", $_image->getLabel()) == $temp)
                            {
                                //echo $imageurl;
                                $smallimageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(75, 75);
                                $imageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(450, 450);
                                $zoomimageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(750, 750);

                                //if(count($productcolorinfo[$temp]["images"]) == 0)
                                if(!isset($productcolorinfo[$temp]["images"]))
                                {
                                    $productcolorinfo[$temp]["images"] = array();
                                    $productcolorinfo[$temp]["images"]["small"] = array($smallimageurl);
                                    $productcolorinfo[$temp]["images"]["zoom"] = array($zoomimageurl);
                                    $productcolorinfo[$temp]["images"]["big"] = array($imageurl);
                                    //echo "creating"."<br/>";
                                }
                                else
                                    if(count($productcolorinfo[$temp]["images"]["small"]) < 4)
                                    {
                                        array_push($productcolorinfo[$temp]["images"]["big"], $imageurl);
                                        array_push($productcolorinfo[$temp]["images"]["small"], $smallimageurl);
                                        //echo "pushing"."<br/>";
                                        array_push($productcolorinfo[$temp]["images"]["zoom"], $zoomimageurl);
                                    }
                            }
                        }
                    }
                }
                $tempproductcolorinfo = array();
                $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'color'); //here, "color" is the attribute_code
                $allOptions = $attribute->getSource()->getAllOptions(true, true);
                foreach ($allOptions as $instance) {
                    if(array_key_exists($instance['label'], $productcolorinfo))
                    {
                        $tempproductcolorinfo[$instance['label']] = $productcolorinfo[$instance['label']];
                    }
                }
                $productcolorinfo = $tempproductcolorinfo;


                $productallsizes = array();


                $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'size'); //here, "color" is the attribute_code
                $allOptions = $attribute->getSource()->getAllOptions(true, true);
                foreach ($allOptions as $instance) {
                    if($instance['label'] != "")
                        array_push($productallsizes, array("label" => $instance['label'], "value" => $instance['value']) );
                }
                ?>

                        <script type="text/javascript">
                            _productcolorinfo = new Array();
                            <?php
                            $configurableAttributeCollection=$_product->getTypeInstance()->getConfigurableAttributes();
                            foreach($configurableAttributeCollection as $attribute){
                                //echo "Attr-Code:".$attribute->getProductAttribute()->getAttributeCode()."<br/>";
                        //        echo "Attr-Label:".$attribute->getProductAttribute()->getFrontend()->getLabel()."<br/>";
                        //        echo "Attr-Id:".$attribute->getProductAttribute()->getId()."<br/>";
                                ?>
                            _productid = '<?php echo $productid; ?>';
                            <?php
                            if($attribute->getProductAttribute()->getAttributeCode() == "color")
                            {
                                ?>
                            _colorattributeid = '<?php echo $attribute->getProductAttribute()->getId(); ?>';
                            <?php
                        }
                        if($attribute->getProductAttribute()->getAttributeCode() == "size")
                        {
                            ?>
                            _sizeattributeid = '<?php echo $attribute->getProductAttribute()->getId(); ?>';
                            <?php
                        }
                    }

                    $currentcolorcount = 0;
                    foreach($productcolorinfo as $key=>$val)
                    {
                        ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>] = new Object();
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].color = '<?php echo $key; ?>';
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].hex = new Array();
                            <?php
                                for($i = 0; $i < count($val['hex']); $i++)
                                {
                                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].hex[<?php echo $i; ?>] = '<?php echo $val['hex'][$i]; ?>';
                            <?php
                        }
                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].sizes = new Array();
                            <?php
                                for($i = 0; $i < count($val['sizes']); $i++)
                                {
                                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].sizes[<?php echo $i; ?>] = '<?php echo $val['sizes'][$i]; ?>';
                            <?php
                        }
                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].zoomimages = new Array();
                            <?php
                                for($i = 0; $i < count($val['images']['zoom']); $i++)
                                {
                                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].zoomimages[<?php echo $i; ?>] = '<?php echo substr($val['images']['zoom'][$i], 1); ?>';
                            <?php
                        }
                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].smallimages = new Array();
                            <?php
                                for($i = 0; $i < count($val['images']['small']); $i++)
                                {
                                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].smallimages[<?php echo $i; ?>] = '<?php echo substr($val['images']['small'][$i], 1); ?>';
                            <?php
                        }
                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].bigimages = new Array();
                            <?php
                                for($i = 0; $i < count($val['images']['big']); $i++)
                                {
                                    ?>
                            _productcolorinfo[<?php echo $currentcolorcount; ?>].bigimages[<?php echo $i; ?>] = '<?php echo substr($val['images']['big'][$i], 1); ?>';
                            <?php
                        }
                    ?>
                            <?php
                                    $currentcolorcount++;
                                }
                            ?>
                            //_productdisplaymode = 'popup';
                            //console.log(_productcolorinfo);
                        </script>
                        <?php
                        if(!$sizeavaliable)
                        {
                            ?>
                            <script type='text/javascript'>
                                _sizesuperattribute = false;
                            </script>
                        <?php
                        }
                        ?>
<?php
                $html .= '<li>
                            <span><img src="'.Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(75, 75).'" width="100" height="100" alt="'.$productname. '" /></span>
                            <span>
                                    <strong>HELP THE <br' . ' />NAMASKAR FOUNDATION</strong>
                                    <span class="capsnone">Add this bracelet to your order</span>
                            </span>
                            ';
?>



                         <?php $html .= '<select id="cmbcolor">';

                                    foreach($productcolorinfo as $key=>$colorinfo)
                                    {

                                       $html .= '<option value="'. $colorinfo['value'].'">'. $key.'</option>';

                                    }

                                $html .= '</select>';



                                $html .= '<select id="cmbsize" class="cmbsize"';
                                  if(!$sizeavaliable)
                                  {
                                      $html .= 'style="display:none;">';
                                  }

                                    foreach($productallsizes as $size)
                                    {

                                        $html .= '<option value="'.$size['value'].'" size="'.$size['label'].'">'. $size['label'].'</option>';

                                    }

                                $html .= '</select>';



                        if(Mage::getSingleton("core/session")->getCartNamaskarError() > 0)
                        {
                            $html .= '<p class="item-msg error">* The requested quantity for "'.$productname.'" is not available.</p>';

                        }




                    $html .= '<select class="qtyselector">';

                        for($i = 1; $i < 11; $i++)
                        {

                           $html .=  '<option value="'.$i.'">'. $i.'</option>';

                        }

                    $html .= '</select>
                                </li>';




            }
        }

            // end to show braclet
            $html .= '</ul>
                                    </div>
                                    <!-- productadded -->
                                    </div>';




        //print_r($html);die('test');
        echo $html;
        //echo json_encode(array("html" => $html));
    }
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }
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
    public function showshoppingbaghtmlAction()
    {
        $html = $this->createshoppingbaghtml();

        echo json_encode(array("status" => "success","html" => $html));
    }
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }
    public function addAction()
    {
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
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
                echo json_encode(array("status" => "error"));
                return;
            }

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
            echo json_encode(array("status" => "success", "html" => $this->createshoppingbaghtml(), "count" => $this->getcartcount()));
            return;

        } catch (Mage_Core_Exception $e) {
            echo json_encode(array("status" => "error"));
            return;
        } catch (Exception $e) {
            echo json_encode(array("status" => "error"));
            return;
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
        // check for whick type of promotion code is apply in the cart (this is because of to fix grand total in cart)
        $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
        $subtotal = $totals["subtotal"]->getValue(); //Subtotal value
        $grandtotal = $totals["grand_total"]->getValue();
       /*
        if($grandtotal<0)
        {
            if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
            {
                // check for Gift of YS
            }
            if(Mage::helper('rewardpoints/event')->getCreditPoints() > 0)
            {
                if(Mage::getModel('smogiexpirationnotifier/applyremovediscount')->removesmogibucks())
                {
                    Mage::getSingleton('checkout/session')->getQuote()->setTotalsCollectedFlag(false)->collectTotals();
//                    $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
//                    $subtotal = $totals["subtotal"]->getValue(); //Subtotal value
//                    $grandtotal = $totals["grand_total"]->getValue();
//                    echo $grandtotal;
//                    return;
                    Mage::getModel('smogiexpirationnotifier/applyremovediscount')->automaticapplysmogibucks();
                }
            }

            if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
            {

            }

        }
       */

        echo json_encode(array("status" => "success", "count" => $this->getcartcount()));
        return;
        echo json_encode(array("status" => "success","html" => $this->createshoppingbaghtml(), "count" => $this->getcartcount()));
    }

    protected function createshoppingbaghtml()
    {
        Mage::getSingleton('checkout/session')->getQuote()->setTotalsCollectedFlag(false)->collectTotals();
        $html = '';
        $jshtml = '';
        $itemcount = $this->getcartcount();
        if($itemcount < 1)
        {
            $html = '
                <!-- ContinueShoppingBtn -->
                    <div class="cont-full capstxt">
                    <a href="javascript:void(0);" id="continuelink" class="continuelink f-left grn">Continue Shopping</a>
                    <span class="continuelink f-right">Continue</span>
                    </div>
                <!-- ContinueShoppingBtn -->
                <div class="empty-cart">your cart is empty.</div>
            ';

            return $html;
        }
        $output = "";

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
                    $temparray['pid'] = $item->getProductId();
                    $temparray['sku'] = $item->getSku();
                    //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                    $temparray['name'] = $item->getName();
                    if(strlen($temparray['name']) > 20)
                        $temparray['name'] = substr($temparray['name'], 0, 19)."...";

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
                    $temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
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
                    $temparray['pid'] = $item->getProductId();
                    $temparray['sku'] = $item->getSku();
                    //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                    $temparray['name'] = $item->getName();
                    if(strlen($temparray['name']) > 20)
                        $temparray['name'] = substr($temparray['name'], 0, 19)."...";
                    $temparray['quantity'] = $item->getQty();
                    $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                    $temparray['imageurl'] = $this->getMiniImage($item->getProductId());
                    $temparray['imageurl'] = "_".Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100, 100)->setQuality(100);
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
                $temparray['pid'] = $item->getProductId();
                $temparray['sku'] = $item->getSku();
                //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                $temparray['name'] = $item->getName();
                if(strlen($temparray['name']) > 20)
                    $temparray['name'] = substr($temparray['name'], 0, 19)."...";
                $temparray['quantity'] = $item->getQty();
                $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                $temparray['imageurl'] = $this->getMiniImage($item->getProductId());
                $temparray['imageurl'] = "_".Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100, 100)->setQuality(100);
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
        $grandtotal = $totals["grand_total"]->getValue();

        $minidetails['items'] = $miniitems;
        //$minidetails['totalitems'] = Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
        $minidetails['totalitems'] = $this->getcartcount();
        $minidetails['cartlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/cart";
        $minidetails['subtotal'] = "$".number_format((float)$subtotal, 2, '.','');// round(Mage::getModel('checkout/cart')->getQuote()->getGrandTotal(), 2);
        $minidetails['grandtotal'] = "$".number_format((float)$grandtotal, 2, '.','');
        $minidetails['checkoutlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/onepage";


        $html = '
    <!-- ContinueShoppingBtn -->
    <div class="cont-full capstxt">
        <a href="javascript:void(0);" id="continuelink" class="continuelink f-left">Continue Shopping</a>
        <a href="<?php echo $this->getBaseUrl();?>checkout_new" class="continuelink f-right grn">Continue</a>
    </div>
    <!-- ContinueShoppingBtn -->
    <!-- productOption -->
    <div class="cont-full">';
        $totalhtml = '
                        <!-- totalAmount -->
                        <div class="totalAmnt capstxt">
                            <span class="f-left">Total</span>
                            <span class="f-right">'.$minidetails['grandtotal'].'</span>
                        </div>
                        <!-- totalAmount -->';
        $html .= $totalhtml;
        $html .='
                    <!-- listItems -->
                    <ul>
                        <li>
                            <span class="f-left capstxt">'.$minidetails['totalitems'].' item</span>
                            <span class="f-right">'.$minidetails['subtotal'].'</span>
                        </li>';
        $getsmogipointscurrentlyuserd = $this->getPointsCurrentlyUsed();
        if($getsmogipointscurrentlyuserd > 0)
        {
            $getsmogipointscurrentlyuserd = number_format((float)($getsmogipointscurrentlyuserd), 2, '.', '');
            $html .='<li class="smogi">
                            <span class="f-left capstxt">SMOGI Bucks used | </span>
                            <span class="removesmogi"><a>remove</a></span>
                            <span class="f-right" usedpoints ="'.$getsmogipointscurrentlyuserd.'">-$'.$getsmogipointscurrentlyuserd.'</span>
                        </li>';
        }

        // all conditions for apply coupon code (promotion code)
        //$customerId = Mage::getModel('customer/session')->getCustomerId();
       // if($customerId)
            // Mage::getModel('smogiexpirationnotifier/applyremovediscount')->applycouponcode(1);
        $promotioncode = Mage::getModel('smogiexpirationnotifier/applyremovediscount')->getCouponCode();
        if($promotioncode)
        {
            if(isset($totals['discount'])){
                $discount = round($totals['discount']->getValue()); //Discount value if applied
            }
            $oCoupon = Mage::getModel('salesrule/coupon')->load($promotioncode, 'code');
            $oRule = Mage::getModel('salesrule/rule')->load($oCoupon->getRuleId());
            $coupondetails = $oRule->getData();
            $coupondetails['discount_amount'] = number_format((float)$coupondetails['discount_amount'], 2, '.','');
            if($coupondetails['simple_action'] == 'by_fixed')
            {

            }
            if($coupondetails['simple_action'] == '')
            {

            }
            if($coupondetails['simple_action'] == '')
            {

            }
            if($coupondetails['simple_action'] == '')
            {

            }

            $html .='<li class="promotion">
                            <span class="f-left capstxt">'.$promotioncode.' promo  used  </span>
                            <span class="removepromotion"><a>remove</a></span>
                            <span class="f-right" usedpromotion ="'.$discount.'">-$'.$coupondetails['discount_amount'].'</span>
                        </li>';


        }
        // all conditions for apply Gift of YS
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $giftofysbalance = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId());

            $html .='<li class="giftcard">
                            <span class="f-left capstxt">Gift of YS used  </span>
                            <span class="removegiftcart"><a>remove</a></span>
                            <span class="f-right" usedgiftcard ="'.$giftofysbalance.'">-$'.$giftofysbalance.'</span>
                        </li>';
        }

                 $html .=  '<li>
                            <span class="f-left">Shipping: FREE</span>
                            <span class="f-right capstxt">Free</span>
                        </li>
                    </ul>
                    <!-- listItems -->
                    <p class="c-align">Use your SMOGI Bucks for this purchase</p>
                    <!-- addItem Input -->
                    <div class="adddields">
                        <form>';
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if(!$customerId)
             $html .=' <label><input type="text" name="smogi" class="gry" available="0" id="smogi" value="You must be signed in to use SMOGI Bucks" readonly="readonly"/><span  class="smogi-login">+</span></label>
                        <label><input type="text" name="promocode" class="gry" id="promocode" value="You must be signed in to add a promo code " readonly="readonly" /><span>+</span></label>
                        <label><input type="text" name="giftcartcode" class="gry" id="giftcartcode" value="You must be signed in to add a gift card code" readonly="readonly" /><span>+</span></label>';
        else{


            $getcustomerpoints = $this->getCustomerPoints($customerId);
            $getsmogipointscurrentlyuserd = $this->getPointsCurrentlyUsed();
            $showedpoints = $getcustomerpoints - $getsmogipointscurrentlyuserd;
            if($showedpoints >= 1)
                $html .=' <label><input type="text" available="'.$getcustomerpoints.'" name="smogi" id="smogi" value="'.$showedpoints.'" /><span class="applysmogi">+</span><span class="error-count"></span></label>';
            if($showedpoints < 1) 
                $html .=' <label><input type="text" name="smogi" id="smogi" readonly="readonly" value="You have no more available SMOGI Bucks" /><span class="">+</span><span class="error-count"></span></label>';

            $html .='           <label><input type="text" name="promocode" id="promocode" value="Add a promo code " /><span>+</span><span class="error-count"></span></label>
                            <label><input type="text" name="giftcartcode" id="giftcartcode" value="Add a gift card code" /><span>+</span><span class="error-count"></span></label>';

        }
        // $html .='           <label><input type="text" name="promocode" id="promocode" value="Add a promo code " /><span>+</span></label>
        //                     <label><input type="text" name="giftcartcode" id="giftcartcode" value="Add a gift card code" /><span>+</span></label>';
        if(!$customerId)
            $html .= '<a class="shoppingbag-login" href="#login" >Sign-in or Register here</a>';
        $html .='                </form>
                    </div>
                    <!-- addItem Input -->
                </div>
                <!-- productOption -->
                <!-- stripGry -->
                <div class="strip-gry">Free and fast shipping to US and Canada</div>
                <!-- stripGry -->
                <!-- productadded -->
                <div class="addedItem">
                    <ul class="similarProdList">';
        foreach($minidetails['items'] as $item)
        {

            $html .='<li id="'.$item['itemid'].'">
                <a href="'.$item['producturl'].'"><span class="wdth100"><img alt="'.$item['name'].'" src="'.substr($item['imageurl'], 1).'" ></span></a>
<span>
                    <span class="quantity">qty '.$item['quantity'].'</span>
                    <span class="pname">'.$item['name'].'</span>
                    <span class="amnt">'.$item['price'].'</span>
                    <span class="clr">'.$item['color'].'</span>
                    <span class="size">size '.$item['size'].'</span>
                </span>
<a href="#" class="close"></a>
</li>';
        }
        // show bracelet if it is not in cart else do not show
        $namaskarbracelet = array();
        $productId = Mage::getModel('core/variable')->loadByCode('namaskar_bracelet_id')->getValue('plain');
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $foundInCart = false;
        foreach($quote->getAllVisibleItems() as $item) {
            if ($item->getData('product_id') == $productId) {
                $foundInCart = true;
                break;
            }
        }
        if(!$foundInCart)
        {
            // check for instorck and pre-ordered
            $doNotShowBracelet = false;
            $_product = Mage::getModel('catalog/product')->load(Mage::getModel('core/variable')->loadByCode('namaskar_bracelet_id')->getValue('plain'));
            $_childproducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);
            foreach($_childproducts as $_childproduct)
            {
                //echo '<pre>'; print_r($_childproduct);die;

                $qty = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
                $stock = $_childproduct->getStockItem();
                $inStock = $stock->getIsInStock();
                $isPreorder = (int) Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getBackorders();
                if(!(($inStock == 0)&&($isPreorder == 0)))
                {
                    $doNotShowBracelet = true;
                }


            }
            // end check for in stock

            if($doNotShowBracelet)
            {
                ?>
                <?php /* speed fix
                                <script type="text/javascript" src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS); ?>jquery/shoppingbag.js"></script>
                                */ ?>
                <?php
                $_helper = Mage::helper('catalog/output');
                $_product = Mage::getModel('catalog/product')->load(Mage::getModel('core/variable')->loadByCode('namaskar_bracelet_id')->getValue('plain'));
                $producturl = $_product->getProductUrl();
                $productname = $_helper->productAttribute($_product, $_product->getName(), 'name');
                $productid = $_product->getId();
                $colorattributeid = '';
                $sizeattributeid = '';
                $price = $_product->getSpecialPrice();

                if($price == "")
                    $price = $_product->getPrice();
                $price = round($price,2);
                if (floor($price)==$price)
                    $price = floor($price);
                $rewardpoints = Mage::helper('rewardpoints/data')->getProductPointsText($_product, false, false);
                $rewardpoints = strip_tags($rewardpoints);
                $rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "loyalty") - 1 - strlen("loyalty") - strpos($rewardpoints, "earn") + strlen("earn")));
                $productrewardpoints = $rewardpoints;
                //$productrewardpoints = floor($price * $_rewardpointsearned);
                $productprice = "$".$price;

                $_childproducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);
                $_gallery = Mage::getModel('catalog/product')->load($_product->getId())->getMediaGalleryImages();
                $productcolorinfo = array();
                $configurableAttributeCollection=$_product->getTypeInstance()->getConfigurableAttributes();
                $sizeavaliable = false;
                foreach($configurableAttributeCollection as $attribute){
                    if($attribute->getProductAttribute()->getAttributeCode() == "size")
                    {
                        $sizeavaliable = true;
                        break;
                    }
                    //echo "Attr-Code:".$attribute->getProductAttribute()->getAttributeCode()."<br/>";
                    //        echo "Attr-Label:".$attribute->getProductAttribute()->getFrontend()->getLabel()."<br/>";
                    //        echo "Attr-Id:".$attribute->getProductAttribute()->getId()."<br/>";
                }
                foreach($_childproducts as $_childproduct)
                {
                    //echo '<pre>'; print_r($_childproduct);

                    //echo Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
                    $temp = $_childproduct->getAttributeText('color');
                    $productqty = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
                    $checkinstock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getIsInStock();
                    $backOrderCheck = (int) Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getBackorders();
                    $checkbackorder = $backOrderCheck;
                    if(strpos($temp,"|") !== FALSE)
                    {
                        $hexcodes = substr($temp, strpos($temp,"|") + 1);
                        $hexcodes = explode(",", $hexcodes);
                        $temp = substr($temp, 0, strpos($temp,"|"));
                        if(!isset($productcolorinfo[$temp]))
                            $productcolorinfo[$temp] = array();
                        $productcolorinfo[$temp]['productqty'] = $productqty;
                        $productcolorinfo[$temp]['checkinstock'] = $checkinstock;
                        $productcolorinfo[$temp]['checkbackorder'] = $checkbackorder;

                        $productcolorinfo[$temp]['hex'] = $hexcodes;
                        $productcolorinfo[$temp]['value'] = Mage::getResourceModel('catalog/product')->getAttributeRawValue($_childproduct->getId(), 'color', Mage::app()->getStore()->getStoreId());
                    }
                    $price = $_childproduct->getSpecialPrice();
                    if($price == "")
                        $price = $_childproduct->getPrice();
                    $price = round($price,2);
                    if (floor($price)==$price)
                        $price = floor($price);

                    $rewardpoints = Mage::helper('rewardpoints/data')->getProductPointsText($_childproduct, false, false);
                    $rewardpoints = strip_tags($rewardpoints);
                    $rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "loyalty") - 1 - strlen("loyalty") - strpos($rewardpoints, "earn") + strlen("earn")));
                    if($sizeavaliable)
                        $temp1 = $_childproduct->getAttributeText('size')."|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
                    else
                        $temp1 = "2|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
                    //$temp1 = $_childproduct->getAttributeText('size')."|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
                    //if(array_key_exists("sizes", $productcolorinfo[$temp]))
                    if(isset($productcolorinfo[$temp]["sizes"]))
                    {
                        //echo "pushing";
                        array_push($productcolorinfo[$temp]["sizes"], $temp1);
                    }
                    else
                    {
                        $productcolorinfo[$temp]["sizes"] = array($temp1);
                        if(!isset($productcolorinfo[$temp]["sizes"]))
                            echo "not set";
                        foreach($_gallery as $_image)
                        {
                            if(str_replace("*", "", $_image->getLabel()) == $temp)
                            {
                                //echo $imageurl;
                                $smallimageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(75, 75);
                                $imageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(450, 450);
                                $zoomimageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(750, 750);

                                //if(count($productcolorinfo[$temp]["images"]) == 0)
                                if(!isset($productcolorinfo[$temp]["images"]))
                                {
                                    $productcolorinfo[$temp]["images"] = array();
                                    $productcolorinfo[$temp]["images"]["small"] = array($smallimageurl);
                                    $productcolorinfo[$temp]["images"]["zoom"] = array($zoomimageurl);
                                    $productcolorinfo[$temp]["images"]["big"] = array($imageurl);
                                    //echo "creating"."<br/>";
                                }
                                else
                                    if(count($productcolorinfo[$temp]["images"]["small"]) < 4)
                                    {
                                        array_push($productcolorinfo[$temp]["images"]["big"], $imageurl);
                                        array_push($productcolorinfo[$temp]["images"]["small"], $smallimageurl);
                                        //echo "pushing"."<br/>";
                                        array_push($productcolorinfo[$temp]["images"]["zoom"], $zoomimageurl);
                                    }
                            }
                        }
                    }
                }
                $tempproductcolorinfo = array();
                $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'color'); //here, "color" is the attribute_code
                $allOptions = $attribute->getSource()->getAllOptions(true, true);
                foreach ($allOptions as $instance) {
                    if(array_key_exists($instance['label'], $productcolorinfo))
                    {
                        $tempproductcolorinfo[$instance['label']] = $productcolorinfo[$instance['label']];
                    }
                }
                $productcolorinfo = $tempproductcolorinfo;


                $productallsizes = array();


                $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'size'); //here, "color" is the attribute_code
                $allOptions = $attribute->getSource()->getAllOptions(true, true);
                foreach ($allOptions as $instance) {
                    if($instance['label'] != "")
                        array_push($productallsizes, array("label" => $instance['label'], "value" => $instance['value']) );
                }


                $jshtml .= '<script type="text/javascript">
                    _productcolorinfo = new Array();';

                    $configurableAttributeCollection=$_product->getTypeInstance()->getConfigurableAttributes();
                    foreach($configurableAttributeCollection as $attribute){
                        //echo "Attr-Code:".$attribute->getProductAttribute()->getAttributeCode()."<br/>";
                //        echo "Attr-Label:".$attribute->getProductAttribute()->getFrontend()->getLabel()."<br/>";
                //        echo "Attr-Id:".$attribute->getProductAttribute()->getId()."<br/>";

                    $jshtml .= ' _productid = '.$productid.'; ';

                    if($attribute->getProductAttribute()->getAttributeCode() == "color")
                    {

                    $jshtml .= '_colorattributeid = '.$attribute->getProductAttribute()->getId().';';
                        $colorattributeid = $attribute->getProductAttribute()->getId();

                }
                if($attribute->getProductAttribute()->getAttributeCode() == "size")
                {

                    $jshtml .= '_sizeattributeid = '.$attribute->getProductAttribute()->getId().';';
                    $sizeattributeid = $attribute->getProductAttribute()->getId();
                }
            }

            $currentcolorcount = 0;
            foreach($productcolorinfo as $key=>$val)
            {

                   $jshtml .= ' _productcolorinfo['.$currentcolorcount.'] = new Object();';
                   $jshtml .= ' _productcolorinfo['.$currentcolorcount.'].color = '.$key.';';
                   $jshtml .= ' _productcolorinfo['.$currentcolorcount.'].hex = new Array();';

                        for($i = 0; $i < count($val['hex']); $i++)
                        {

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].hex['.$i.'] = '. $val['hex'][$i].';';

                }

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].sizes = new Array();';

                        for($i = 0; $i < count($val['sizes']); $i++)
                        {

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].sizes['.$i.'] = '.$val['sizes'][$i].';';

                }

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].zoomimages = new Array();';

                        for($i = 0; $i < count($val['images']['zoom']); $i++)
                        {

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].zoomimages['.$i.'] = '.substr($val['images']['zoom'][$i], 1).';';

                }

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].smallimages = new Array();';

                        for($i = 0; $i < count($val['images']['small']); $i++)
                        {

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].smallimages['.$i.'] = '. substr($val['images']['small'][$i], 1).';';

                }

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].bigimages = new Array();';

                        for($i = 0; $i < count($val['images']['big']); $i++)
                        {

                    $jshtml .= '_productcolorinfo['.$currentcolorcount.'].bigimages['. $i.'] = '. substr($val['images']['big'][$i], 1).';';

                }


                            $currentcolorcount++;
                        }

                    //_productdisplaymode = 'popup';
                    //console.log(_productcolorinfo);
                $jshtml .= '</script>';

                if(!$sizeavaliable)
                {

                    $jshtml .= '<script type="text/javascript">';
                    $jshtml .=  '_sizesuperattribute = false;';
                    $jshtml .=  '</script>';

                }


                $html .= '<li class= "namaskarinfo" colorattributeid = "'.$colorattributeid.'" sizeattributeid = "'.$sizeattributeid.'" productid =" '.$productid.'">
                            <span><img src="'.Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(75, 75).'" width="100" height="100" alt="'.$productname. '" /></span>
                            <span>
                                    <strong>HELP THE <br' . ' />NAMASKAR FOUNDATION</strong>
                                    <span class="capsnone">Add this bracelet to your order</span>
                            </span>
                            ';
                ?>



                <?php $html .= '<select id="cmbcolor">';

                foreach($productcolorinfo as $key=>$colorinfo)
                {

                    $html .= '<option productqty="'.$colorinfo['productqty'].'" checkinstock="'.$checkinstock['checkinstock'].'" checkbackorder="'.$checkbackorder['checkbackorder'].'" value="'. $colorinfo['value'].'">'. $key.'</option>';

                }

                $html .= '</select>';



                $html .= '<select id="cmbsize" class="cmbsize"';
                if(!$sizeavaliable)
                {
                    $html .= 'style="display:none;">';
                }

                foreach($productallsizes as $size)
                {

                    $html .= '<option value="'.$size['value'].'" size="'.$size['label'].'">'. $size['label'].'</option>';

                }

                $html .= '</select>';



                if(Mage::getSingleton("core/session")->getCartNamaskarError() > 0)
                {
                    //$html .= '<p class="item-msg error">* The requested quantity for "'.$productname.'" is not available.</p>';

                }




                $html .= '<span style="width: auto;"><select class="qtyselector">';

                for($i = 1; $i < 11; $i++)
                {

                    $html .=  '<option value="'.$i.'">'. $i.'</option>';

                }

                $html .= '</select><button class="addbracelet">Add to bag</button></span>
                                </li>';




            }
        }

        // end to show braclet
        $html .= '</ul>
                                    </div>
                                    <!-- productadded -->
                                    ';


        return $html;
         //return $jshtml.$html;
        //print_r($html);die('test');
        //echo $html;
        //echo json_encode(array("html" => $html));
    }
    protected function getCustomerPoints($customerId) {

        if ($this->points_current){
            return $this->points_current;
        }

        //$customerId = Mage::getModel('customer/session')->getCustomerId();
        $store_id = Mage::app()->getStore()->getId();

        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            $this->points_current = $reward_flat_model->collectPointsCurrent($customerId, $store_id);
            return $this->points_current;
        }

        $reward_model = Mage::getModel('rewardpoints/stats');
        $this->points_current = $reward_model->getPointsCurrent($customerId, $store_id);

        return $this->points_current;
    }

    public function getPointsCurrentlyUsed() {
        $creditpointsentered = Mage::helper('rewardpoints/event')->getCreditPoints();
        $grandTotal = Mage::helper('checkout/cart')->getQuote()->getSubtotal();
        //print_r($grandTotal);
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $cartHelper = Mage::helper('checkout/cart');
        $items = $cartHelper->getCart()->getItems();

        foreach ($items as $item) {
            if($item->getPrice() > 0)
            {
                $itemId = $item->getProductId();
                $itemstotal = $item->getRowTotal();

                $query1 = "Select category_id, name from catalog_category_product, catalog_category_flat_store_1 where catalog_category_product.product_id = ".$itemId." and catalog_category_flat_store_1.entity_id = catalog_category_product.category_id";
                $categoryid = $readConnection->fetchAll($query1);
                $excludecats = Mage::getModel('core/variable')->loadByCode('nosmogicategories')->getValue('plain');
                $excludecats = explode(",", $excludecats);

                for($id=0;$id<count($categoryid);$id++)
                {
                    $flag = false;
                    for($i = 0; $i < count($excludecats); $i++)
                    {
                        if($categoryid[$id]['category_id'] == $excludecats[$i])
                        {
                            $flag = true;
                            break;
                        }
                    }
                    if($flag)
                        //if($categoryid[$id]['category_id'] == 8)
                        //if($categoryid[$id]['name'] == 'Accessories')
                    {
                        $cattotal = $cattotal + $itemstotal;
                    }
                }
            }
        }

        $grandTotal = $grandTotal - $cattotal;

        if ($creditpointsentered > $grandTotal)
        {
            //Mage::getSingleton('core/session')->setCreditPointsApplied($grandTotal);
            //echo $grandTotal;
            return $grandTotal;
        }
        else
        {
            //echo $creditpointsentered;
            return $creditpointsentered;
        }

    }

    public function getcartcount()
    {
        //return Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
        $cart = Mage::getModel('checkout/cart')->getQuote()->getData();
        if(isset($cart['items_qty'])){
            return (int)$cart['items_qty'];
        } else {
            return 0;
        }
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

    function getMiniImage($productid, $color)
    {
        $_gallery = Mage::getModel('catalog/product')->load($productid)->getMediaGalleryImages();
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
            return "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100, 100)->setQuality(100);
        }
        return "";
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
    protected function getSkinUrl($path)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/new-yogasmoga/yogasmoga-theme/".$path;
    }

}
