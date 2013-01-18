<?php 
class Mycustommodules_Mycatalog_MyproductController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Output from Product Module";
    }
    
    public function getgiftcardbalanceAction()
    {
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('cardno')) 
        {
            $cardno              = (string) $this->getRequest()->getPost('cardno');
            $cards = Mage::getModel('giftcards/giftcards')->getCollection()->addFieldToFilter('card_code', $cardno);
            $arr['balance'] = "error";
            $arr['status'] = "error";
            foreach ($cards as $card) {
                $arr['balance'] = $card->getCardBalance();
                $arr['status'] = "success";    
                break;
            }
            $arr['message'] = "Invalid Card Number.";
            echo json_encode($arr);    
        }
        else
        {
            $arr['balance'] = "error";
            $arr['status'] = "error";
            $arr['message'] = "Invalid Card Number.";
            echo json_encode($arr);
        }
    }
    
    public function referfriendAction()
    {
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            $session         = Mage::getSingleton('core/session');
            $emails           = $this->getRequest()->getPost('email'); //trim((string) $this->getRequest()->getPost('email'));
            $names            = $this->getRequest()->getPost('name'); //trim((string) $this->getRequest()->getPost('name'));
            
            $arr['message'] = "";
            $arr['status'] = "error";
            
            $customerSession = Mage::getSingleton('customer/session');
            //$errors = array();
            try {
                foreach ($emails as $key_email => $email){
                    $name = trim((string) $names[$key_email]);
                    $email = trim((string) $email);
                    
                    ///////////////////////////////////////////
                    $no_errors = true;
                    if (!Zend_Validate::is($email, 'EmailAddress')) {
                        //Mage::throwException($this->__('Please enter a valid email address.'));
                        //$errors[] = $this->__('Wrong email address (%s).', $email);
                        //$session->addError($this->__('Wrong email address (%s).', $email));
                        $arr['message'] = "Invalid Email Address (".$email.")";
                        $arr['status'] = "error";            
                        $no_errors = false;
                    }
                    if ($name == ''){
                        //Mage::throwException($this->__('Please enter your friend name.'));
                        //$errors[] = $this->__('Friend name is required for (%s) on line %s.', $email, ($key_email+1));
                        $session->addError($this->__('Friend name is required for email: %s on line %s.', $email, ($key_email+1)));
                        $arr['message'] = "Freind name is required for email (".$email.")";
                        $arr['status'] = "error";
                        $no_errors = false;
                    }
                    
                    if ($no_errors){
                        $referralModel = Mage::getModel('rewardpoints/referral');

                        $customer = Mage::getModel('customer/customer')
                                        ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                                        ->loadByEmail($email);

                        if ($referralModel->isSubscribed($email) || $customer->getEmail() == $email) {
                            //Mage::throwException($this->__('Email %s has been already submitted.', $email));
                            //$session->addError($this->__('Email %s has been already submitted.', $email));
                            $arr['status'] = "error";
                            $arr['message'] = "Email (".$email.") is already submitted.";
                            echo json_encode($arr);
                            return;
                        } else {
                            if ($referralModel->subscribe($customerSession->getCustomer(), $email, $name)) {
                                //$session->addSuccess($this->__('Email %s was successfully invited.', $email));
                                $arr['status'] = "success";
                                $arr['message'] = "Freind is successfully invited";
                                echo json_encode($arr);
                                return;
                            } else {
                                //$session->addError($this->__('There was a problem with the invitation email %s.', $email));
                                $arr['status'] = "success";
                                $arr['message'] = "Freind is successfully invited";
                                echo json_encode($arr);
                                return;
                                $arr['status'] = "error";
                                $arr['message'] = "There was a problem with the invitation email (".$email.").";
                                echo json_encode($arr);
                                return;    
                            }
                        }
                    }
                    else
                    {
                        $arr['status'] = "error";
                        echo json_encode($arr);
                        return;
                    }
                    ///////////////////////////////////////////
                }
            }
            catch (Mage_Core_Exception $e) {
                //$session->addException($e, $this->__('%s', $e->getMessage()));
                
            }
            catch (Exception $e) {
                //print_r($e);
//                die;
//                $session->addException($e, $this->__('There was a problem with the invitation.'));
                $arr['status'] = "error";
                $arr['message'] = "An unexpected error occured.";
                echo json_encode($arr);
                return;
            }
        }
        else
        {
            $arr['status'] = "error";
            $arr['message'] = "An unexpected error occured.";
            echo json_encode($arr);
            return;
        }
    }
    
    protected function getSkinUrl($path)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/yogasmoga/yogasmoga-theme/".$path;
    }
    
    public function detailsAction()
    {
        //echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
//        return;
        $_helper = Mage::helper('catalog/output');
        $_product = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('id'));
        //$_product = Mage::getModel('catalog/product')->load($this->getRequest()->getPost('id'));
        $producturl = $_product->getProductUrl();
        $productname = $_helper->productAttribute($_product, $_product->getName(), 'name');
        $productid = $_product->getId();
        $howdoesitfitblockid = Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'how_does_it_fit', Mage::app()->getStore()->getStoreId());
        $sizechartblockid = Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'size_chart', Mage::app()->getStore()->getStoreId());
        $_rewardpointsearned = 0.1;
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
        foreach($_childproducts as $_childproduct)
        {
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
                //if(!array_key_exists('hex', $productcolorinfo[$temp]))
    //            {
    //                $hexcodes = explode(",", $hexcodes);
    //                $productcolorinfo[$temp]['hex'] = $hexcodes;
    //            }
                //if(count($productcolorinfo[$temp]["images"]) == 0)
    //            {
    //                $hexcodes = explode(",", $hexcodes);
    //                $productcolorinfo[$temp]["hex"] = $hexcodes;
    //            }
                //if(!isset($productcolorinfo[$temp]['hex']))
    //            {
    //                echo $temp;
    //                $hexcodes = explode(",", $hexcodes);
    //                //$productcolorinfo[$temp]['hex'] = $hexcodes;
    //                array_push($productcolorinfo[$temp]['hex'], $hexcodes);   
    //            }
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
            $temp1 = $_childproduct->getAttributeText('size')."|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
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
                    $imgdata = json_decode(trim($_image->getLabel()), true);
                    if($imgdata == NULL || strcasecmp($imgdata['type'], "product image") != 0)
                        continue;
                    if($imgdata['color'] == Mage::getResourceModel('catalog/product')->getAttributeRawValue($_childproduct->getId(), 'color', Mage::app()->getStore()->getStoreId()))                
                    //if(str_replace("*", "", $_image->getLabel()) == $temp)
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
            _cnfrewardpoint = '<?php echo $productrewardpoints; ?>';
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
            _productdisplaymode = 'popup';
            //console.log(_productcolorinfo);
        </script>
        <?php /*
        <table class="productimagecontainer">
            <tr>
                <td>
                    <table class="tdbigimagecontainer">
                        <tr>
                            <td>    
                            </td>
                        </tr>
                    </table>    
                </td>
            </tr>
            <tr>
                <td class="tddivider">
                    <div>
                        <img src="<?php echo $this->getSkinUrl('images/catalog/product/big_line.png'); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="smallimagecontiner">
                        <tr>
                            
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        */ ?>
        <?php
            if($howdoesitfitblockid != "")
            {
                ?>
                <div id="howdoesitfitbox">
                    <div id="howdoesitfitboxinner">
                        <?php echo $this->getLayout()->createBlock('cms/block')->setBlockId($howdoesitfitblockid)->toHtml(); ?>
                    </div>
                    <img src="<?php echo $this->getSkinUrl('images/catalog/product/close_opaque.png'); ?>" id="closehowdoesitfit" />
                </div>
                <?php      
            }
        ?>
        <?php
            if($sizechartblockid != "")
            {
                ?>
                <div id="sizechart">
                    <?php echo $this->getLayout()->createBlock('cms/block')->setBlockId($sizechartblockid)->toHtml(); ?>
                </div>
                <?php      
            }
        ?>
        <table class="productdetailspopup normalproductdetail">
            <tr>
                <td class="popupproductdetail">
                    <div class="productoptions">
                        <table class="productdetailtable">
                            <tr>
                                <td>
                                    <div class="productname"><?php echo $productname; ?></div>
                                    <div class="productcost"><?php echo $productprice; ?></div>
                                    <div class="shortdesc"><?php echo $_product->getShortDescription(); ?></div>
                                    <table class="selectedcolor">
                                        <tr>
                                            <td>COLOR</td>
                                            <td class="selectedcolortext"></td>
                                        </tr>
                                    </table>
                                    <div id="colorcontainer">
                                        <?php
                                            $first = true;
                                            $colorcount = 0;
                                            foreach($productcolorinfo as $key=>$colorinfo)
                                            {
                                                $colorcount++;
                                                ?>
                                                    <div>
                                                        <table color="<?php echo $key; ?>" value="<?php echo $colorinfo['value']; ?>">
                                                            <tr>
                                                                <?php
                                                                    foreach($colorinfo['hex'] as $hex)
                                                                    {
                                                                        ?>
                                                                            <td style="background-color: <?php echo $hex ?>;">    
                                                                            <div>
                                                                                &nbsp;
                                                                            </div>                                            
                                                                            </td>   
                                                                        <?php
                                                                    } 
                                                                ?>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="<?php echo count($colorinfo['hex']); ?>" <?php if($first) { echo "class='tdselectedcolor'"; $first = false; } ?>>
                                                                      
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>  
                                                <?php
                                                if(($colorcount % 5) == 0)
                                                echo "<br/>";
                                            } 
                                        ?>
                                    </div>
                                    <div style="clear: both;"></div>
                                    <table class="selectedsize">
                                        <tr>
                                            <td>SIZE</td>
                                            <td class="sizechartlink"><div><a href="#">Size chart</a></div></td>
                                        </tr>
                                    </table>
                                    <div id="sizecontainer">
                                        <table>
                                            <tr>
                                                <?php
                                                    foreach($productallsizes as $size)
                                                    {
                                                        ?>
                                                            <td><div value="<?php echo $size['value']; ?>" size="<?php echo $size['label']; ?>"><?php echo $size['label']; ?></div></td>        
                                                        <?php
                                                    } 
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                    <table class="fittable">
                                        <tr>
                                            <td>
                                                <div class="hanger"></div>
                                            </td>
                                            <td class="howdoesitfitlink"><div><a href="javascript:void(0);">How does it fit?</a></div></td>
                                        </tr>
                                    </table>
                                    <div class="qty">QTY</div>
                                    <div class="sizeselector">
                                        <select class="qtyselector">
                                            <?php
                                                for($i = 0; $i < 21; $i++)
                                                {
                                                    ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                    <div class="divider"></div>
                                    <table class="smogibucks">
                                        <tr>
                                            <td>
                                                <div class="smogibuckcount">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <?php echo $productrewardpoints; ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                            <td class="earnsmogibuckstext">
                                                EARN SMOGI BUCKS<br/>WITH THIS PURCHASE
                                            </td>
                                        </tr>
                                    </table>
                                    <div id="orderitem" class="addtobag spbutton" imageurl="<?php echo $this->getSkinUrl('images/catalog/product/add_to_bag_off.png'); ?>" downimageurl="<?php echo $this->getSkinUrl('images/catalog/product/add_to_bag_on.png'); ?>"></div>
                                    <div id="preorderitem" class="preorderitem spbutton" imageurl="<?php echo $this->getSkinUrl('images/catalog/product/pre_order_this_item.png'); ?>" downimageurl="<?php echo $this->getSkinUrl('images/catalog/product/pre_order_this_item.png'); ?>"></div>
                                    <div class="producterrorcontainer">
                                        <div class="errormsg">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>        
                </td>
                <td id="tdpopupproductbigimage">
                     <img src="http://192.168.2.110/yogasmoga/media/catalog/product/cache/1/thumbnail/450x450/040ec09b1e35df139433887a97daa66f/a/b/abstract_0011.jpg" />
                </td>
                <td id="tdpopupproductsmallimages">
                    <table>
                        <tr><td><img src="http://192.168.2.110/yogasmoga/media/catalog/product/cache/1/thumbnail/75x75/040ec09b1e35df139433887a97daa66f/a/b/abstract_0011.jpg" /></td></tr>
                        <tr><td><img src="http://192.168.2.110/yogasmoga/media/catalog/product/cache/1/thumbnail/75x75/040ec09b1e35df139433887a97daa66f/a/b/abstract_0002_1.jpg" /></td></tr>
                        <tr><td><img src="http://192.168.2.110/yogasmoga/media/catalog/product/cache/1/thumbnail/75x75/040ec09b1e35df139433887a97daa66f/a/b/abstract_0062_1.jpg" /></td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="productdetailpopupbottomlinks">
            <tr>
                <td>
                    <div class="addtowishlist">
                        <a href="<?php echo Mage::helper('core/url')->getHomeUrl(); ?>wishlist/index/add/product/<?php echo $productid; ?>/">ADD TO WISHLIST +</a>
                    </div>
                </td>
                <td class="tdviewfulldetails">
                    <div class="viewfulldetails">
                        <a href="<?php echo substr($producturl,0)."?from=dressingroom"; ?>">View Full Product Details +</a>
                    </div>
                </td>
            </tr>
        </table>
        <img id="closelightbox" src="<?php echo $this->getSkinUrl('images/catalog/product/close.png'); ?>" />
        <?php
    }
}
?>