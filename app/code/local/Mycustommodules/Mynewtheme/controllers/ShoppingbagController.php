<?php
class Mycustommodules_Mynewtheme_ShoppingbagController extends Mage_Core_Controller_Front_Action
{
    protected $points_current = '';
    protected $productselectedoptionarray = array("foo" => "bar");
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
            $html = "<h1>Your cart is Empty</h1>";
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
        <div class="clear-fix"></div>
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
                            <label><input type="text" name="promocode" id="promocode" value="Add a promo code" /><span>+</span></label>
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
        $countDiscountType = '';
        $countDiscountType = $this->countDiscountType();
        $discounttypeerror = 'Gift Card, SMOGI Bucks and Promotion Code cannot be combined.Please choose one and continue CheckOut.';


        echo json_encode(array("status" => "success","html" => $html,"count" => $this->getcartcount(),"countdiscount" => $countDiscountType,"discounttypeerror" => $discounttypeerror));
    

    }
    public function fastshowshoppingbaghtmlAction()
    {
        $html = $this->fastcreateshoppingbaghtml();

        $totalitems = $this->getcartcount();

        echo json_encode(array("status" => "success","html" => $html,"count" => $totalitems));

    }
    public function shoppingbagtotalsAction()
    {
        // totals
        $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
        $subtotal = $totals["subtotal"]->getValue(); //Subtotal value
        $grandtotal = $totals["grand_total"]->getValue();
        //echo $totals['tax'];die('tax');

        $tax = 0;
        if(isset($totals['tax']) && $totals['tax']->getValue()) {
            $tax = $totals['tax']->getValue(); //Tax value if present
            $grandtotal = $grandtotal - $tax;
        } else {
            $tax = 0;
        }


        //$minidetails['totalitems'] = Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
        $totalitems = $this->getcartcount().' items';
        $subtotal = "$".number_format((float)$subtotal, 2, '.','');// round(Mage::getModel('checkout/cart')->getQuote()->getGrandTotal(), 2);
        $grandtotal = "$".number_format((float)$grandtotal, 2, '.','');
        if($this->getcartcount() == 1)
        {
            $totalitems = $this->getcartcount().' item';
            $grandtotal = 'donotshowprice';
        }
        //$discountHtml = $this->updateDiscount();
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        $discountHtml = '';
        if($customerId) {
            $discountHtml = $this->newUpdateDiscount($grandtotal,$totalitems, $subtotal);
        }


        //end totals
        echo json_encode(array("status" => "success","count" => $totalitems,"subtotal" => $subtotal,"grandtotal" => $grandtotal, "upperHtml"=>$discountHtml));
    }

    public function newUpdateDiscount($grandtotal, $totalitems, $subtotal)
    {
        $totalhtml = '';
        $totalhtml .= '
                        <!-- totalAmount -->
                        <div class="totalAmnt capstxt">
                            <span class="f-left">Total</span>
                            <span class="f-right cart-grandtotal">'.$grandtotal.'</span>
                        </div>
                        <!-- totalAmount -->';
        $html = $totalhtml;
        $stritem = 'item';
        if($this->getcartcount() > 1)
        {
            $stritem = 'items';
        }
        $checksmogiapplied = false;
        $checkpromoapplied = false;
        $checkgiftapplied = false;
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if($customerId) {
            $continuelink=Mage::getBaseUrl().'checkout/onepage';
            $getcustomerpoints = $this->getCustomerPoints($customerId);
            $getsmogipointscurrentlyuserd = $this->getPointsCurrentlyUsed();
            $showedpoints = $getcustomerpoints - $getsmogipointscurrentlyuserd;
            if($getsmogipointscurrentlyuserd) $getcustomerpoints = $getcustomerpoints - $getsmogipointscurrentlyuserd;
        }
        $html .='
                    <!-- listItems -->
                    <ul id="sub-totals-discount">
                        <li>
                            <span class="f-left capstxt cart-totalitems">'.$totalitems.'</span>
                            <span class="f-right cart-subtotal">'.$subtotal.'</span>
                        </li>';

        $checkisactive = '';

        $getsmogipointscurrentlyuserd = $this->getPointsCurrentlyUsed();
        if($getsmogipointscurrentlyuserd > 0)
        {
            $getsmogipointscurrentlyuserd = number_format((float)($getsmogipointscurrentlyuserd), 2, '.', '');
            $html .='<li class="smogi">
                            <span class="f-left">SMOGI Bucks used | </span>
                            <span class="removesmogi"><a>remove</a></span>
                            <span class="f-right"  usedpoints ="'.$getsmogipointscurrentlyuserd.'">-$'.$getsmogipointscurrentlyuserd.'</span>
                        </li>';
            $checksmogiapplied = true;
        }
        // all conditions for apply coupon code (promotion code)
        $checkgiftsapply = false;
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $checkgiftsapply = true;
        }
        $promotioncode = Mage::getModel('smogiexpirationnotifier/applyremovediscount')->getCouponCode();
        if($promotioncode == '' && !$checksmogiapplied && !$checkgiftsapply)
        {
            $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
            if(isset($totals['discount']) && $totals['discount']->getValue())
            {
                $promotioncode = true;
                echo $promotioncode;echo 'manish';
            }


        }



        if($promotioncode)
        {
            if(isset($totals['discount'])){
                $discount = ($totals['discount']->getValue()); //Discount value if applied
                $discount = substr($discount,1);
                $discount = number_format((float)$discount, 2, '.','');
                $afterdecimalcount = strlen(substr(strrchr($discount, "."), 1));
                if($afterdecimalcount == 0)
                    $discount .= '.00';
                if($afterdecimalcount == 1)
                    $discount .= '0';

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
            if($promotioncode == 1)
            {
                $html .='<li class="promotion">
                            <span class="f-left">Discount : </span>
                            <span class="f-right" class="active" usedpromotion ="'.$discount.'">-$'.$discount.'</span>
                        </li>';
            }else{
                $html .='<li class="promotion">
                            <span class="f-left">&#39;'.$promotioncode.'&#39; promo used | </span>
                            <span class="removepromotion"><a>remove</a></span>
                            <span class="f-right" class="active" usedpromotion ="'.$discount.'">-$'.$discount.'</span>
                        </li>';
            }

            $checkpromoapplied = true;


        }
        // all conditions for apply Gift of YS
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $giftofysbalance = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId());
            $discount = $totals['discount']->getValue();
            $discount1 = ($discount * -1.00);
            $discount =  number_format((float)$discount1, 2, '.','');  //Discount value if applied


            $html .='<li class="giftcard">
                            <span class="f-left">$'.$discount1.' Gift Card used  |</span>
                            <span class="removegiftcart"><a>remove</a></span>

                            <span class="f-right" usedgiftcard ="'.$discount.'">-$'.$discount.'</span>


                        </li>';
            $checkgiftapplied = true;
        }
        $shippingPrice = '';
        $shippingcode = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getShippingMethod();
        if($shippingcode == "")
            $shippingPrice =  "FREE";
        else
            if($this->getShippingCost($shippingcode) == 0)
                $shippingPrice = "FREE";
            else
                $shippingPrice =  "$".number_format((float)($this->getShippingCost($shippingcode)), 2, '.', '');



        if($checksmogiapplied == '1' && $showedpoints > 0) $usesmogi="<p class='c-align'>You can't use other codes with SMOGI Bucks.</p>";
        else if($checkpromoapplied == '1' || $checkgiftapplied == '1') $usesmogi='';
        else if($checksmogiapplied != '1' && $showedpoints > 0) $usesmogi='';
        else if($checksmogiapplied != '1' && $showedpoints > 0) $usesmogi='<p class="c-align">Use your SMOGI Bucks for this purchase</p>';
        $usesmogi = '';
        $html .=  '<li>';
        if($shippingPrice == "FREE")
            $html .= '      <span class="f-left">Shipping: </span>
                            <span class="f-right capstxt">'.$shippingPrice.'</span>';
        else
            $html .= '      <span class="f-left">Shipping: </span>
                            <span class="f-right capstxt">'.$shippingPrice.'</span>';


        $html .='     </li>';
//        if($tax > 0)
//            $html .= '<li>
//                        <span class="f-left">Tax: </span>
//                            <span class="f-right capstxt">'."$".number_format((float)($tax), 2, '.', '').'</span></li>';
        $html .= '  </ul>
                    <!-- listItems -->
                    '.$usesmogi.'
                    <!-- addItem Input -->
                    <div class="adddields">
                        <form>';
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if(!$customerId)
            $html .=' <label><input type="text" name="smogi" class="gry lightgray" available="0" id="smogi" value="Sign in to use SMOGI Bucks" disabled="disabled"/><span  class="smogi-login">+</span></label>
                        <label><input type="text" name="giftcartcode" data-used="no" class="gry lightgray" id="giftcartcode" value="Sign in to use Promo Code / Gift Card Code" disabled="disabled" /><span class="giftcardlogin">+</span></label>';
        else{
            $gryclasssmogi = "";
            $gryclasspromo = "";
            $gryclassgift = "";
            $applygiftcard="applygiftcard";
            $applygiftdisable="";
            $applypromo="applypromo";
            $applypromodisable="";
            $applysmogi="applysmogi";
            $applysmogidisable="";
            $checkboxapplied="";
            $smogiplaceholder="Use your ".$showedpoints." SMOGI Bucks toward this purchase";
            $showedpointsvalue=$showedpoints;
            $codeused='';
            if($checksmogiapplied)
            {
                $gryclasspromo = "gry";
                $gryclassgift = "gry";
                $applygiftcard="";
                if($showedpoints < 1) {
                    $applysmogidisable=" disabled='disabled'";
                    $gryclasssmogi = "gry";
                }
                $showedpointsvalue=$showedpoints;
                $applygiftdisable=" disabled='disabled'";
//                $applypromo="";
//                $applypromodisable=" disabled='disabled'";
                $checkboxapplied=" disabled='disabled'";
            }
            if($checkpromoapplied)
            {
                $smogiplaceholder="SMOGI Bucks cannot be used with Promo Codes";
                $gryclasssmogi = "gry";
                $gryclassgift = "gry";
                $applysmogi="";
                $applygiftcard="";
                //$applypromodisable=" disabled='disabled'";
                $applysmogidisable=" disabled='disabled'";
                $applygiftdisable=" disabled='disabled'";
                $checkboxapplied=" disabled='disabled'";
                $showedpointsvalue="";
                $codeused='yes';
            }
            if($checkgiftapplied)
            {
                //$gryclassgift = "gry";
                $smogiplaceholder="SMOGI Bucks cannot be used with Promo Codes";
                $gryclasssmogi = "gry";
                $gryclasspromo = "gry";
                $applysmogi="";
                $applysmogidisable=" disabled='disabled'";
                $checkboxapplied="";
                $showedpointsvalue="";
                $codeused='yes';
                //$applygiftcard="";
                //$applygiftdisable=" disabled='disabled'";
                //   $applypromo="";
                // $applypromodisable=" disabled='disabled'";
            }
            if($showedpoints >= 1) {
                $html .=' <label><input type="text" class = "'.$gryclasssmogi.'" placeholder="'.$smogiplaceholder.'" available="'.$getcustomerpoints.'" name="smogi" id="smogi"  '.$applysmogidisable.'/><span class="'.$applysmogi.'">+</span><span class="error-count"></span></label>';
            }
            if($showedpoints < 1) {
                $applysmogidisable=" disabled='disabled'";
                $html .=' <label><input type="text" name="smogi" class="gry lightgray" placeholder="You have no more available SMOGI Bucks" '.$applysmogidisable.'/><span class="">+</span><span class="error-count"></span></label>';
            }
            // check if promotion code is used or not
//            if($promotioncode)
//            {
//                $html .='<label><input type="text" name="promocode" id="promocode" value="'.$promotioncode.' promo used"   '.$applypromodisable.' class="gry" /><span class="">+</span><span class="error-count"></span></label>';
//            }
//            else
//            {
//                $html .='<label><input type="text" class="'.$gryclasspromo.'" name="promocode" id="promocode" placeholder="Add a promo code"  '.$applypromodisable.'/><span class="'.$applypromo.'">+</span><span class="error-count"></span></label>';
//            }

            // check for Gift of YS

            $giftofysbalance = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId());
            $giftofysbalance = number_format((float)$giftofysbalance, 2, '.','');
            if($giftofysbalance > 0 || $promotioncode == '1')
            {
                $html .='  <label><input class="'.$gryclassgift.'" type="text" data-used="'.$codeused.'" name="giftcartcode" id="giftcartcode" placeholder="Add a Promo Code / Gift Card Code" '.$applygiftdisable.'/><span class="'.$applygiftcard.'">+</span><span class="error-count"></span></label>';
                if(Mage::getSingleton("giftcards/session")->getActive() == "1")
                {
                    //  $html .='<div> <input type="checkbox" value="1" checked="checked" class="giftcardcheckbox" '.$checkboxapplied.'/><p>Use your Gift Card balance: $'.$giftofysbalance.' available.</p></div>';
                }
                else
                {
                    $html .='<div style="min-height: inherit;"> <input type="checkbox" id="giftCardShop" value="1"  class="giftcardcheckbox"  '.$checkboxapplied.'/><label for="giftCardShop">Use your Gift Card balance: $'.$giftofysbalance.' available</label></div>';
                }
                $html .='<div class="giftcarloader" style="clear: both;text-align:left;position:text-align: left; width: 100%;"></div>';
            }
            else
            {
                $html .=' <label><input  class="'.$gryclassgift.'" type="text" data-used="'.$codeused.'" name="giftcartcode" id="giftcartcode" placeholder="Add a Promo Code / Gift Card Code" '.$applygiftdisable.' /><span class="'.$applygiftcard.'">+</span><span class="error-count"></span></label>

                    ';
            }





        }
        $errormsg = '';
        $globalerrormsg = html_entity_decode(strip_tags(Mage::getSingleton('core/session')->getGlobalMessage()));
        if($globalerrormsg !='')
            $errormsg = $globalerrormsg;
        Mage::getSingleton('core/session')->setGlobalMessage('');
        $html .='<div class="errortext">'.$errormsg.'</div>';
        $html .='<div class="bagerrormsg" id="redeemresult"></div><div class="zindexH"></div>';
        // $html .='           <label><input type="text" name="promocode" id="promocode" value="Add a promo code" /><span>+</span></label>
        //                     <label><input type="text" name="giftcartcode" id="giftcartcode" value="Add a gift card code" /><span>+</span></label>';
        if(!$customerId)
            $html .= '<a class="shoppingbag-login" href="#login" >Sign-in or Register here</a>';
        $html .='                </form>




                    </div>
                    <div class="clear-fix"></div>

                    ';

        return $html;


    }
    public  function updateDiscount()
    {
        $html = '';
        $getsmogipointscurrentlyuserd = $this->getPointsCurrentlyUsed();
        if($getsmogipointscurrentlyuserd > 0)
        {
            $getsmogipointscurrentlyuserd = number_format((float)($getsmogipointscurrentlyuserd), 2, '.', '');
            $html .='<li class="smogi">
                            <span class="f-left">SMOGI Bucks used | </span>
                            <span class="removesmogi"><a>remove</a></span>
                            <span class="f-right"  usedpoints ="'.$getsmogipointscurrentlyuserd.'">-$'.$getsmogipointscurrentlyuserd.'</span>
                        </li>';
            $checksmogiapplied = true;
        }
        // all conditions for apply coupon code (promotion code)


        $promotioncode = Mage::getModel('smogiexpirationnotifier/applyremovediscount')->getCouponCode();
        if($promotioncode == '' && !$checksmogiapplied)
        {
            $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
            if(isset($totals['discount']) && $totals['discount']->getValue())
                $promotioncode = true;
        }



        if($promotioncode)
        {
            if(isset($totals['discount'])){
                $discount = ($totals['discount']->getValue()); //Discount value if applied
                $discount = substr($discount,1);
                $discount = number_format((float)$discount, 2, '.','');
                //$afterdecimalcount = strlen(substr(strrchr($discount, "."), 1));
                $afterdecimalcount = number_format((float)$discount, 2, '.','');
                /*if($afterdecimalcount == 0)
                    $discount .= '.00';
                if($afterdecimalcount == 1)
                    $discount .= '0';*/

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
            if($promotioncode == 1)
            {
                $html .='<li class="promotion">
                            <span class="f-left">Discount : </span>
                            <span class="f-right" class="active" usedpromotion ="'.$discount.'">-$'.$discount.'</span>
                        </li>';
            }else{
                $html .='<li class="promotion">
                            <span class="f-left">&#39;'.$promotioncode.'&#39; promo used | </span>
                            <span class="removepromotion"><a>remove</a></span>
                            <span class="f-right" class="active" usedpromotion ="'.$discount.'">-$'.$discount.'</span>
                        </li>';
            }

            return $html;


        }
        // all conditions for apply Gift of YS
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $giftofysbalance = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId());
            $discount = $totals['discount']->getValue();
            $discount1 = ($discount * -1.00);
            $discount =  number_format((float)$discount1, 2, '.','');  //Discount value if applied


            $html .='<li class="giftcard">
                            <span class="f-left">$'.$discount1.' Gift Card used  |</span>
                            <span class="removegiftcart"><a>remove</a></span>

                            <span class="f-right" usedgiftcard ="'.$discount.'">-$'.$discount.'</span>


                        </li>';
            $checkgiftapplied = true;
        }
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
        $deletedqty = (int) $this->getRequest()->getParam('deleteqty');
        if ($id) {
            try {
                if($deletedqty >1)
                {
                    // update item quantity in cart -1 for each time
                    $quote = Mage::getSingleton('checkout/session')->getQuote();
                    $cartItems = $quote->getAllVisibleItems();
                    $cart = Mage::getSingleton('checkout/cart');
                    foreach ($cartItems as $item) {
                        if($id==$item->getId())
                        {
                            $item->setQty($deletedqty-1);
                            //$item->setQty($_POST['qty']); // UPDATE ONLY THE QTY, NOTHING ELSE!
                            $cart->save();  // SAVE
                            //Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
                        }

                    }
                    // end update item quantity in cart -1 for each time
                }
                else
                    $this->_getCart()->removeItem($id)->save();
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
                    <a href="javascript:void(0);" id="continuelink" class="continuelink f-left grn">Keep Shopping</a>
                    <span class="continuelink f-right">Checkout</span>
                    </div>
                <!-- ContinueShoppingBtn -->
                <div class="empty-cart">your cart is empty</div>
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
        $i=0;
        foreach ($session->getQuote()->getAllItems() as $item)
        {//echo ++$i.'--';
            //echo $item->getProductId().'--'.$item->getSku().'<br>';

            $temparray = array();
            if(Mage::getModel('catalog/product')->load($item->getProductId())->getTypeID() == "configurable")
            {
                $productselectedoption = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
                $productselectedoptioncount = count($productselectedoption['options']);

                if($this->searchcartnew($miniitems, $item->getSku(),$productselectedoptioncount) == false  )
                {// echo $item->getSku().'--';

                    $_product = Mage::getModel('catalog/product')->loadByAttribute('sku',$item->getSku());
                    $product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $temparray['pid'] = $item->getProductId();
                    $temparray['sku'] = $item->getSku();
                    $temparray['pavailableqty'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getQty();
                    $temparray['preorder'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getBackorders();
                    $temparray['instock'] = $_product->stock_item->is_in_stock;
                    $temparray['typeid'] = 'configurable';
                    // for insale
                    $temparray['insale'] = $_product->getAttributeText('insale');
                    $temparray['confPrice'] = '';
                    if($temparray['insale'] == 'Yes')
                    {
                        $confProduct = Mage::getModel('catalog/product')->load($item->getProductId());
                        $temparray['confPrice'] = "$".number_format((float)( $confProduct->getPrice()), 2, '.', '');


                    }






                    //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                    $temparray['name'] = $item->getName();
                    //if(strlen($temparray['name']) > 20)
                        //$temparray['name'] = substr($temparray['name'], 0, 19)."...";

                    if($this->issuperattribute($product, "color"))
                    {
                        $temparray['color'] = $_product->getAttributeText('color');
                        if(strpos($temparray['color'], "|") !== false)
                            $temparray['color'] = substr($temparray['color'], 0, strpos($temparray['color'], "|"));
                    }
                    if($this->issuperattribute($product, "size"))
                        $temparray['size'] = $_product->getAttributeText('size');
                    if($this->issuperattribute($product, "length"))
                        $temparray['length'] = $_product->getAttributeText('length');
                    if(count($productselectedoption['options'])>0)
                    {
                        $temparray['optionlabel'] = $productselectedoption['options'][0]['label'];
                        $temparray['optionvalue'] = $productselectedoption['options'][0]['value'];
                    }
                    $temparray['quantity'] = $item->getQty();
                    //$temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                    $temparray['price'] = "$".number_format((float)( $item->getBaseCalculationPrice()), 2, '.', '');
                    //$temparray['imageurl'] = $this->getMiniImage($item->getProductId(), $temparray['color']);
                    $temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
                    $temparray['itemid'] = $item->getItemId();
                    $temparray['producturl'] = Mage::getModel('catalog/product')->load($item->getProductId())->getProductUrl();
                    array_push($miniitems, $temparray);
                }
            }
            else if(Mage::getModel('catalog/product')->load($item->getProductId())->getTypeID() == "simple")
            {//echo $item->getSku().'++';
                if($this->searchcart($miniitems, $item->getSku()) == false)
                {
                    $_product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $temparray['pid'] = $item->getProductId();
                    $temparray['sku'] = $item->getSku();
                    $temparray['pavailableqty'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getQty();
                    $temparray['preorder'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getBackorders();
                    $temparray['instock'] = $_product->stock_item->is_in_stock;
                    $temparray['typeid'] = 'simple';

                    //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                    $temparray['name'] = $item->getName();
                    //if(strlen($temparray['name']) > 20)
                        //$temparray['name'] = substr($temparray['name'], 0, 19)."...";
                    $temparray['quantity'] = $item->getQty();
                    //$temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                    $temparray['price'] = "$".number_format((float)( $item->getBaseCalculationPrice()), 2, '.', '');
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
                $temparray['pavailableqty'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getQty();
                $temparray['preorder'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getBackorders();
                $temparray['instock'] = $_product->stock_item->is_in_stock;
                $temparray['typeid'] = '';
                //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                $temparray['name'] = $item->getName();
                //if(strlen($temparray['name']) > 20)
                    //$temparray['name'] = substr($temparray['name'], 0, 19)."...";
                $temparray['quantity'] = $item->getQty();
                //$temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                $temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');
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
        //print_r($miniitems);die('tst');
        $miniitems = array_reverse($miniitems);
        //print_r($miniitems);
        $customerId = Mage::getModel('customer/session')->getCustomerId();

        if($customerId)
        {
            Mage::getSingleton('core/session')->setCartItems($miniitems);
        }
        // show every quantity seperatly in shopping bag
        $newminiitems = $miniitems;
        $miniitems = array();
        foreach($newminiitems as $item)
        {
            if($item['quantity'] > 1)
            {
                for($i = 0;$i < $item['quantity'];$i++)
                {
                    array_push($miniitems,$item);
                }
            }
            else{
                array_push($miniitems,$item);
            }

        }
        //print_r($miniitems);die('test');
        // end show every quantity

        //echo $foundOnlyNoSmogiProduct;
        $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
        $subtotal = $totals["subtotal"]->getValue(); //Subtotal value
        $grandtotal = $totals["grand_total"]->getValue();
        //echo $totals['tax'];die('tax');

        $tax = 0;
        if(isset($totals['tax']) && $totals['tax']->getValue()) {
            $tax = $totals['tax']->getValue(); //Tax value if present
            $grandtotal = $grandtotal - $tax;
        } else {
            $tax = 0;
        }

        $minidetails['items'] = $miniitems;
        //$minidetails['totalitems'] = Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
        $minidetails['totalitems'] = $this->getcartcount();
        $minidetails['cartlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/cart";
        $minidetails['subtotal'] = "$".number_format((float)$subtotal, 2, '.','');// round(Mage::getModel('checkout/cart')->getQuote()->getGrandTotal(), 2);
        $minidetails['grandtotal'] = "$".number_format((float)$grandtotal, 2, '.','');
        $minidetails['checkoutlink'] = Mage::helper('core/url')->getHomeUrl()."checkout/onepage";

        $stritem = 'item';
        if($this->getcartcount() > 1)
        {
            $stritem = 'items';
        }

        $checksmogiapplied = false;
        $checkpromoapplied = false;
        $checkgiftapplied = false;
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if($customerId) {
            $continuelink=Mage::getBaseUrl().'checkout/onepage';
            $getcustomerpoints = $this->getCustomerPoints($customerId);
            $getsmogipointscurrentlyuserd = $this->getPointsCurrentlyUsed();
            $showedpoints = $getcustomerpoints - $getsmogipointscurrentlyuserd;
            if($getsmogipointscurrentlyuserd) $getcustomerpoints = $getcustomerpoints - $getsmogipointscurrentlyuserd;
        }
        else $continuelink="javascript:void(0);";
        $allow = $this->countDiscountType();
        if($allow > 1)
        {
            $html = '
            <!-- ContinueShoppingBtn -->
            <div class="cont-full capstxt">
                <a href="javascript:void(0);" id="continuelink" class="continuelink f-left">Keep Shopping</a>
                <span class="continuelink f-right">Checkout</span>
                <div class="clear-fix"></div>

            </div>

            <!-- ContinueShoppingBtn -->
            <!-- productOption -->
            <div class="cont-full contfull2">';
        }
        else{   $html = '
            <!-- ContinueShoppingBtn -->
            <div class="cont-full capstxt">
                <a href="javascript:void(0);" id="continuelink" class="continuelink f-left">Keep Shopping</a>
                <a href="'.$continuelink.'" id="continuecheckout" class="continuelink f-right grn">Checkout</a>

                <div class="clear-fix"></div>

            </div>

            <!-- ContinueShoppingBtn -->
            <!-- productOption -->
            <div class="cont-full contfull2">';
        }

        $totalhtml = '
                        <!-- totalAmount -->
                        <div class="totalAmnt capstxt">
                            <span class="f-left">Total</span>
                            <span class="f-right cart-grandtotal">'.$minidetails['grandtotal'].'</span>
                        </div>
                        <!-- totalAmount -->';
        $html .= $totalhtml;
        $html .='
                    <!-- listItems -->
                    <ul id="sub-totals-discount">
                        <li>
                            <span class="f-left capstxt cart-totalitems">'.$minidetails['totalitems'].' '.$stritem.'</span>
                            <span class="f-right cart-subtotal">'.$minidetails['subtotal'].'</span>
                        </li>';

        $checkisactive = '';

        $getsmogipointscurrentlyuserd = $this->getPointsCurrentlyUsed();
        if($getsmogipointscurrentlyuserd > 0)
        {
            $getsmogipointscurrentlyuserd = number_format((float)($getsmogipointscurrentlyuserd), 2, '.', '');
            $html .='<li class="smogi">
                            <span class="f-left">SMOGI Bucks used | </span>
                            <span class="removesmogi"><a>remove</a></span>
                            <span class="f-right"  usedpoints ="'.$getsmogipointscurrentlyuserd.'">-$'.$getsmogipointscurrentlyuserd.'</span>
                        </li>';
            $checksmogiapplied = true;
        }
        // all conditions for apply coupon code (promotion code)

        // for 75 $ auto apply
        $checkgiftsapply = false;
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
            {
            $checkgiftsapply = true;
            }
        $promotioncode = Mage::getModel('smogiexpirationnotifier/applyremovediscount')->getCouponCode();
        if($promotioncode == '' && !$checksmogiapplied && !$checkgiftsapply)
        {
            $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
            if(isset($totals['discount']) && $totals['discount']->getValue())
                $promotioncode = true;
        }
        // end // for 75 $ auto apply


        if($promotioncode)
        {
            if(isset($totals['discount'])){
                $discount = ($totals['discount']->getValue()); //Discount value if applied
                $discount = substr($discount,1);
                $afterdecimalcount = strlen(substr(strrchr($discount, "."), 1));
                if($afterdecimalcount == 0)
                    $discount .= '.00';
                if($afterdecimalcount == 1)
                    $discount .= '0';

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
            if($promotioncode == 1)
            {
                $html .='<li class="promotion">
                            <span class="f-left">Discount : </span>
                            <span class="f-right" class="active" usedpromotion ="'.$discount.'">-$'.$discount.'</span>
                        </li>';
            }else{
                $html .='<li class="promotion">
                            <span class="f-left">&#39;'.$promotioncode.'&#39; promo used | </span>
                            <span class="removepromotion"><a>remove</a></span>
                            <span class="f-right" class="active" usedpromotion ="'.$discount.'">-$'.$discount.'</span>
                        </li>';
            }

            $checkpromoapplied = true;


        }
        // all conditions for apply Gift of YS
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $giftofysbalance = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId());
            $discount = $totals['discount']->getValue();
            $discount1 = ($discount * -1.00);
            $discount =  number_format((float)$discount1, 2, '.','');  //Discount value if applied


            $html .='<li class="giftcard">
                            <span class="f-left">$'.$discount1.' Gift Card used  |</span>
                            <span class="removegiftcart"><a>remove</a></span>

                            <span class="f-right" usedgiftcard ="'.$discount.'">-$'.$discount.'</span>


                        </li>';
            $checkgiftapplied = true;
        }
        $shippingPrice = '';
        $shippingcode = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getShippingMethod();
        if($shippingcode == "")
            $shippingPrice =  "FREE";
        else
            if($this->getShippingCost($shippingcode) == 0)
                $shippingPrice = "FREE";
            else
                $shippingPrice =  "$".number_format((float)($this->getShippingCost($shippingcode)), 2, '.', '');



        if($checksmogiapplied == '1' && $showedpoints > 0) $usesmogi="<p class='c-align'>You can't use other codes with SMOGI Bucks.</p>";
        else if($checkpromoapplied == '1' || $checkgiftapplied == '1') $usesmogi='';
        else if($checksmogiapplied != '1' && $showedpoints > 0) $usesmogi='';
        else if($checksmogiapplied != '1' && $showedpoints > 0) $usesmogi='<p class="c-align">Use your SMOGI Bucks for this purchase</p>';
        $usesmogi = '';
        $html .=  '<li>';
        if($shippingPrice == "FREE")
            $html .= '      <span class="f-left">Shipping: </span>
                            <span class="f-right capstxt">'.$shippingPrice.'</span>';
        else
            $html .= '      <span class="f-left">Shipping: </span>
                            <span class="f-right capstxt">'.$shippingPrice.'</span>';


        $html .='     </li>';
//        if($tax > 0)
//            $html .= '<li>
//                        <span class="f-left">Tax: </span>
//                            <span class="f-right capstxt">'."$".number_format((float)($tax), 2, '.', '').'</span></li>';
        $html .= '  </ul>
                    <!-- listItems -->
                    '.$usesmogi.'
                    <!-- addItem Input -->
                    <div class="adddields">
                        <form>';
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if(!$customerId)
            $html .=' <label><input type="text" name="smogi" class="gry lightgray" available="0" id="smogi" value="Sign in to use SMOGI Bucks" disabled="disabled"/><span  class="smogi-login">+</span></label>
                        <label><input type="text" name="giftcartcode" data-used="no" class="gry lightgray" id="giftcartcode" value="Sign in to use Promo Code / Gift Card Code" disabled="disabled" /><span class="giftcardlogin">+</span></label>';
        else{
            $gryclasssmogi = "";
            $gryclasspromo = "";
            $gryclassgift = "";
            $applygiftcard="applygiftcard";
            $applygiftdisable="";
            $applypromo="applypromo";
            $applypromodisable="";
            $applysmogi="applysmogi";
            $applysmogidisable="";
            $checkboxapplied="";
            $smogiplaceholder="Use your ".$showedpoints." SMOGI Bucks toward this purchase";
            $showedpointsvalue=$showedpoints;
            $codeused='';
            if($checksmogiapplied)
            {
                $gryclasspromo = "gry";
                $gryclassgift = "gry";
                $applygiftcard="";
                if($showedpoints < 1) {
                    $applysmogidisable=" disabled='disabled'";
                    $gryclasssmogi = "gry";
                }
                $showedpointsvalue=$showedpoints;
                $applygiftdisable=" disabled='disabled'";
//                $applypromo="";
//                $applypromodisable=" disabled='disabled'";
                $checkboxapplied=" disabled='disabled'";
            }
            if($checkpromoapplied)
            {
                $smogiplaceholder="SMOGI Bucks cannot be used with Promo Codes";
                $gryclasssmogi = "gry";
                $gryclassgift = "gry";
                $applysmogi="";
                $applygiftcard="";
                //$applypromodisable=" disabled='disabled'";
                $applysmogidisable=" disabled='disabled'";
                $applygiftdisable=" disabled='disabled'";
                $checkboxapplied=" disabled='disabled'";
                $showedpointsvalue="";
                $codeused='yes';
            }
            if($checkgiftapplied)
            {
                //$gryclassgift = "gry";
                $smogiplaceholder="SMOGI Bucks cannot be used with Promo Codes";
                $gryclasssmogi = "gry";
                $gryclasspromo = "gry";
                $applysmogi="";
                $applysmogidisable=" disabled='disabled'";
                $checkboxapplied="";
                $showedpointsvalue="";
                $codeused='yes';
                //$applygiftcard="";
                //$applygiftdisable=" disabled='disabled'";
                //   $applypromo="";
                // $applypromodisable=" disabled='disabled'";
            }
            if($showedpoints >= 1) {
                $html .=' <label><input type="text" class = "'.$gryclasssmogi.'" placeholder="'.$smogiplaceholder.'" available="'.$getcustomerpoints.'" name="smogi" id="smogi"  '.$applysmogidisable.'/><span class="'.$applysmogi.'">+</span><span class="error-count"></span></label>';
            }
            if($showedpoints < 1) {
                $applysmogidisable=" disabled='disabled'";
                $html .=' <label><input type="text" name="smogi" class="gry lightgray" placeholder="You have no more available SMOGI Bucks" '.$applysmogidisable.'/><span class="">+</span><span class="error-count"></span></label>';
            }
            // check if promotion code is used or not
//            if($promotioncode)
//            {
//                $html .='<label><input type="text" name="promocode" id="promocode" value="'.$promotioncode.' promo used"   '.$applypromodisable.' class="gry" /><span class="">+</span><span class="error-count"></span></label>';
//            }
//            else
//            {
//                $html .='<label><input type="text" class="'.$gryclasspromo.'" name="promocode" id="promocode" placeholder="Add a promo code"  '.$applypromodisable.'/><span class="'.$applypromo.'">+</span><span class="error-count"></span></label>';
//            }

            // check for Gift of YS

            $giftofysbalance = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId());
            $giftofysbalance = number_format((float)$giftofysbalance, 2, '.','');
            if($giftofysbalance > 0 || $promotioncode == '1')
            {
                $html .='  <label><input class="'.$gryclassgift.'" type="text" data-used="'.$codeused.'" name="giftcartcode" id="giftcartcode" placeholder="Add a Promo Code / Gift Card Code" '.$applygiftdisable.'/><span class="'.$applygiftcard.'">+</span><span class="error-count"></span></label>';
                if(Mage::getSingleton("giftcards/session")->getActive() == "1")
                {
                    //  $html .='<div> <input type="checkbox" value="1" checked="checked" class="giftcardcheckbox" '.$checkboxapplied.'/><p>Use your Gift Card balance: $'.$giftofysbalance.' available.</p></div>';
                }
                else
                {
                    $html .='<div style="min-height: inherit;"> <input type="checkbox" id="giftCardShop" value="1"  class="giftcardcheckbox"  '.$checkboxapplied.'/><label for="giftCardShop">Use your Gift Card balance: $'.$giftofysbalance.' available</label></div>';
                }
                $html .='<div class="giftcarloader" style="clear: both;text-align:left;position:text-align: left; width: 100%;"></div>';
            }
            else
            {
                $html .=' <label><input  class="'.$gryclassgift.'" type="text" data-used="'.$codeused.'" name="giftcartcode" id="giftcartcode" placeholder="Add a Promo Code / Gift Card Code" '.$applygiftdisable.' /><span class="'.$applygiftcard.'">+</span><span class="error-count"></span></label>

                    ';
            }





        }
        $errormsg = '';
        $globalerrormsg = html_entity_decode(strip_tags(Mage::getSingleton('core/session')->getGlobalMessage()));
        if($globalerrormsg !='')
            $errormsg = $globalerrormsg;
        Mage::getSingleton('core/session')->setGlobalMessage('');
        $html .='<div class="errortext">'.$errormsg.'</div>';
        $html .='<div class="bagerrormsg" id="redeemresult"></div><div class="zindexH"></div>';
        // $html .='           <label><input type="text" name="promocode" id="promocode" value="Add a promo code" /><span>+</span></label>
        //                     <label><input type="text" name="giftcartcode" id="giftcartcode" value="Add a gift card code" /><span>+</span></label>';
        if(!$customerId)
            $html .= '<a class="shoppingbag-login" href="#login" >Sign-in or Register here</a>';
        $html .='                </form>


                    

                    </div>
                    <div class="clear-fix"></div>
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

            $html .='<li id="'.$item['itemid'].'" availableqty="'.$item['pavailableqty'].'" backorder="'.$item['preorder'].'" instock="'.$item['instock'].'">
                <a href="'.$item['producturl'].'"><span class="wdth100"><img alt="'.$item['name'].'" src="'.substr($item['imageurl'], 1).'" ></span></a>
<span>
                    <span class="quantity dnone" cartqty='.$item['quantity'].'>qty '.$item['quantity'].'</span>
                    <span class="pname">'.$item['name'].'</span>';

            if($item['insale'] == 'Yes')
            {
                $html .='<span class="amnt" style="color : #c03;">'.$item['price'].'</span>
                            <span class="insale"  > was '.$item['confPrice'].'</span>';
            }
            else{
                $html .='<span class="amnt">'.$item['price'].'</span>';
            }

            $html .='<span class="clr">'.$item['color'].'</span>';
            if($item['size'] !='') $html .='<span class="size">size '.$item['size'].'</span>';
            if($item['length'] !='') $html .='<span class="size">'.$item['length'].'</span>';
            if($item['optionlabel'] != '')
            {
                $html .='<span class="size">'.$item['optionlabel'].'</span>';
                //$html .='<span class="clr">'.$item['optionvalue'].'</span>';
            }
            if($item['insale'] == 'Yes')
            {
                $html .='<span class="size" style="color: #c03;">This Item is Final Sale. Cannot be exchanged or returned.</span>';
            }
            $html .='</span>
<a href="#" class="close"></a>';
            // Preorder
            if($item['pavailableqty'] - $item['quantity'] < 0 && $item['preorder'] == 1 && $item['instock']&& ($item['typeid'] != "giftcards" && $item['typeid'] != ''))
            {
                $html .= '<div class="preorderinfo errortext">'.Mage::getModel("core/variable")->loadByCode("preorder_message_email")->getValue("html").'</div>';
            }
            //Out of stock
            if($item['pavailableqty'] < 1 && $item['instock'] == 0 && $item['preorder'] == 0)
            {
                $html .= '<div class="outofstockinfo errortext">* This product is currently out of stock.</div>';
            }
            // Requested quantity is not available
            if($item['pavailableqty'] < $item['quantity'] && $item['instock'] == 1 && $item['preorder'] == 0 )
            {
                $html .= '<div class="notavailproductinfo errortext">* The requested quantity for "'.$item['name'].'" is not available.</div>';
            }
            $html .='</li>';
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
                            <span class="c-align"><img src="'.Mage::helper('catalog/image')->init($_product, 'image')->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100, 100).'" width="" height="" alt="'.$productname. '" /></span>
                            <span>
                                    <strong>HELP THE NAMASKÁR<br' . ' />FOUNDATION</strong>
                                    <span class="">Add this bracelet<br' . ' />to your order</span>
                            
                            ';
                ?>



                <?php $html .= '<select id="cmbcolor" style="width: 116px;">';

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




                $html .= '<span style="width: 47px; float:right;"><select class="qtyselector">';

                for($i = 1; $i < 11; $i++)
                {

                    $html .=  '<option value="'.$i.'">'. $i.'</option>';

                }

                $html .= '</select></span><div class="clear-fix"></div><button class="addbracelet"><span>Add to bag</span></button></span>
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
    protected function fastcreateshoppingbaghtml()
    {
        /*$productID=Mage::getSingleton('checkout/session')->getLastAddedProductId(true);
        echo $productID."<br>";
        $_product=Mage::getModel('catalog/product')->load($productID);
        echo $_product->getName()."<br>";*/
        $session= Mage::getSingleton('checkout/session');
        $cartsession = $session->getQuote()->getAllItems();
        $cartcount = count($session->getQuote()->getAllItems());
        $html = '';
        $i = 1;
        //echo time().'<br>';
        foreach($session->getQuote()->getAllItems() as $item)
        {
            if($i ==$cartcount-1)
            {
                $productselectedoption = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
                $productselectedoptioncount = count($productselectedoption['options']);
                $_product = Mage::getModel('catalog/product')->loadByAttribute('sku',$item->getSku());
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $temparray['pid'] = $item->getProductId();
                $temparray['sku'] = $item->getSku();
                $temparray['pavailableqty'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getQty();
                $temparray['preorder'] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getBackorders();
                $temparray['instock'] = $_product->stock_item->is_in_stock;
                $temparray['typeid'] = 'configurable';

                // for insale
                $temparray['insale'] = $_product->getAttributeText('insale');
                $temparray['confPrice'] = '';
                if($temparray['insale'] == 'Yes')
                {
                    $confProduct = Mage::getModel('catalog/product')->load($item->getProductId());
                    $temparray['confPrice'] = "$".number_format((float)( $confProduct->getPrice()), 2, '.', '');


                }
                //$temparray['name'] = $_helper->productAttribute($_product, $_product->getName(), 'name');
                $temparray['name'] = $item->getName();
                //if(strlen($temparray['name']) > 20)
                //$temparray['name'] = substr($temparray['name'], 0, 19)."...";

                if($this->issuperattribute($product, "color"))
                {
                    $temparray['color'] = $_product->getAttributeText('color');
                    if(strpos($temparray['color'], "|") !== false)
                        $temparray['color'] = substr($temparray['color'], 0, strpos($temparray['color'], "|"));
                }
                if($this->issuperattribute($product, "size"))
                    $temparray['size'] = $_product->getAttributeText('size');
                if($this->issuperattribute($product, "length"))
                    $temparray['length'] = $_product->getAttributeText('length');
                if(count($productselectedoption['options'])>0)
                {
                    $temparray['optionlabel'] = $productselectedoption['options'][0]['label'];
                    $temparray['optionvalue'] = $productselectedoption['options'][0]['value'];
                }
                $temparray['quantity'] = $item->getQty();
                //$temparray['price'] = "$".number_format((float)($item->getQty() * $item->getBaseCalculationPrice()), 2, '.', '');//  round($item->getQty() * $item->getBaseCalculationPrice(), 2);
                $temparray['price'] = "$".number_format((float)( $item->getBaseCalculationPrice()), 2, '.', '');
                //$temparray['imageurl'] = $this->getMiniImage($item->getProductId(), $temparray['color']);
                $temparray['imageurl'] = $this->getMiniImage($item->getProductId(), Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'color', Mage::app()->getStore()->getStoreId()));
                $temparray['itemid'] = $item->getItemId();
                $temparray['producturl'] = Mage::getModel('catalog/product')->load($item->getProductId())->getProductUrl();

                $minidetailss['items'] = $temparray;
            }
            $i++;
        }

        $customerId = Mage::getModel('customer/session')->getCustomerId();

        if($customerId)
        {
            $cartItems = Mage::getSingleton('core/session')->getCartItems();
            array_reverse($cartItems);
            array_push($cartItems,$minidetailss['items']);
            array_reverse($cartItems);
            Mage::getSingleton('core/session')->setCartItems($cartItems);
        }

            $item = $temparray;

            $html .='<li id="'.$item['itemid'].'" availableqty="'.$item['pavailableqty'].'" backorder="'.$item['preorder'].'" instock="'.$item['instock'].'">
                <a href="'.$item['producturl'].'"><span class="wdth100"><img alt="'.$item['name'].'" src="'.substr($item['imageurl'], 1).'" ></span></a>
<span>
                    <span class="quantity dnone" cartqty='.$item['quantity'].'>qty '.$item['quantity'].'</span>
                    <span class="pname">'.$item['name'].'</span>';

                if($item['insale'] == 'Yes')
                {
                    $html .='<span class="amnt" style="color : #c03;">'.$item['price'].'</span>
                                    <span class="insale"  > was '.$item['confPrice'].'</span>';
                }
                else{
                    $html .='<span class="amnt">'.$item['price'].'</span>';
                }


                    $html .='<span class="clr">'.$item['color'].'</span>';
            if($item['size'] !='') $html .='<span class="size">size '.$item['size'].'</span>';
            if($item['length'] !='') $html .='<span class="size">'.$item['length'].'</span>';
            if($item['optionlabel'] != '')
            {
                $html .='<span class="size">'.$item['optionlabel'].'</span>';
                //$html .='<span class="clr">'.$item['optionvalue'].'</span>';
            }

        if($item['insale'] == 'Yes')
        {
            $html .='<span class="size" style="color: #c03;">This Item is Final Sale. Cannot be exchanged or returned.</span>';
        }
            $html .='</span>
<a href="#" class="close"></a>';
            // Preorder
            if($item['pavailableqty'] - $item['quantity'] < 0 && $item['preorder'] == 1 && $item['instock']&& ($item['typeid'] != "giftcards" && $item['typeid'] != ''))
            {
                $html .= '<div class="preorderinfo errortext">'.Mage::getModel("core/variable")->loadByCode("preorder_message_email")->getValue("html").'</div>';
            }
            //Out of stock
            if($item['pavailableqty'] < 1 && $item['instock'] == 0 && $item['preorder'] == 0)
            {
                $html .= '<div class="outofstockinfo errortext">* This product is currently out of stock.</div>';
            }
            // Requested quantity is not available
            if($item['pavailableqty'] < $item['quantity'] && $item['instock'] == 1 && $item['preorder'] == 0 )
            {
                $html .= '<div class="notavailproductinfo errortext">* The requested quantity for "'.$item['name'].'" is not available.</div>';
            }
            $html .='</li>';

        //echo time().'<br>';
        return $html;
    }
    protected function countDiscountType()
    {
        $allow = 0;
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
            $allow++;
        if(Mage::helper('rewardpoints/event')->getCreditPoints() > 0)
            $allow++;
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
            $allow++;
        return $allow;
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
        $itemids = array();
        $count = 0;

        foreach ($items as $item) {
            array_push($itemids, $item->getProductId());
        }

        foreach ($items as $item) {
            if($item->getPrice() > 0)
            {
                $itemId = $item->getProductId();
                $itemstotal = $item->getRowTotal();

                if($item->getProductType() == "configurable")
                {$query1 = "Select category_id, name from catalog_category_product, catalog_category_flat_store_1 where catalog_category_product.product_id IN (".$itemId.",".$itemids[$count + 1].") and catalog_category_flat_store_1.entity_id = catalog_category_product.category_id";

                }
                else
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
                        $cattotal = $cattotal + $itemstotal;break;
                    }
                }
            }
            $count++;
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
    public function searchcartnew($minidetails, $sku, $productselectedoptioncount = null)
    {
        if($productselectedoptioncount > 0)
        {
            if($this->searchforoptionproduct($this->productselectedoptionarray,$sku) == false)
            {
                array_push($this->productselectedoptionarray, $sku);
                return false;
            }
            else
                return true;
        }
        foreach($minidetails as $item)
        {
            if($item['sku'] == $sku  )
            {
                if($this->searchforoptionproduct($this->productselectedoptionarray,$sku) == true)
                {
                    return false;
                }
                return true;
            }

        }
        return false;
    }
    public function searchforoptionproduct($productarr,$sku)
    {
        foreach($productarr as $key=>$value)
        {
            if($value == $sku  )
            {
                return true;
            }

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

}
