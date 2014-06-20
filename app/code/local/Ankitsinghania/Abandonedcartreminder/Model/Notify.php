<?php
class Ankitsinghania_Abandonedcartreminder_Model_Notify extends Mage_Core_Model_Abstract {
    protected function _construct()
    {
        $this->_init('abandonedcartreminder/notify');
        parent::_construct();
    }
    public function remind(){
        echo "hello world";
        Mage::log("i ran", null, "abandonedcartreminder.log");
        //$this->getCustomerslist(20);
    }
    public function remindusers()
    {
        Mage::log("notifying users", null, "abandonedcartreminder.log");

        $serverType = Mage::getModel('core/variable')->loadByCode('server_type')->getValue('plain');

            $customerlist = $this->getabandonedlist();

            foreach($customerlist as $customer)
            {

               // print_r($customer);
//                if($serverType == 'production')
//                $notification_log->setEmail_status($this->sendemail($customer['customer_name'], $customer['customer_email'], $customer['bucks_expiring'], $notification_period));
                /*    else
                        $notification_log->setEmail_status($this->sendemail($customer['customer_name'], "ankit@mobikasa.com", $customer['bucks_expiring'], $notification_period));  */
//                $write = Mage::getSingleton('core/resource')->getConnection('core_write');
//                $readresult=$write->query("SELECT count(*) as total FROM abandonedcart_reminder_log WHERE customer_email='".$customer['customer_email']."' AND cartid=".$customer['cartid']."  AND email_status = 1 limit 1");
//                $total='';
//                while ($row = $readresult->fetch() ) {
//                    $total=$row['total'];
//                }
                //echo $total;
                //print_r($customer);
//                if($customer['customer_email']=='neha@mobikasa.com')
//                {
                    /// $customer['customer_email'];
                    $notification_log = Mage::getModel('abandonedcartreminder/notify');
                    $notification_log->setCustomer_email($customer['customer_email']);
                    $notification_log->setCustomer_firstname($customer['customer_firstname']);
                    $notification_log->setCustomer_lastname($customer['customer_lastname']);
                    $notification_log->setCustomer_productname($customer['product_name']);
                    $notification_log->setCustomer_productcolor($customer['product_color']);
                    $notification_log->setCustomer_productsize($customer['product_size']);
                    $notification_log->setCartid($customer['cartid']);
                    $notification_log->setEmail_status($this->sendemail($customer['customer_email'], $customer['customer_firstname'],$customer['customer_lastname'], $customer['product_name'], $customer['product_color'],$customer['product_size'],$customer['product_url'],$customer['product_imageurl'],$customer['product_html']));
                    Mage::log("notifying users before save".$customer['customer_email'], null, "abandonedcartreminder.log");
                $notification_log->save();
                    Mage::log("notifying users after save".$customer['customer_email'], null, "abandonedcartreminder.log");
//                }
            }
        }
    public function getabandonedlist()
    {
        $abandonedlist = array();
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readcolor = $write->query("SELECT eaov.value AS 'Attribute', eaov.option_id AS 'Value' FROM eav_attribute ea, eav_attribute_option eao,   eav_attribute_option_value eaov WHERE ea.attribute_id = eao.attribute_id AND eao.option_id = eaov.option_id AND eaov.store_id = 0
  AND ea.attribute_code='color'");
        $readcolor1 = $readcolor->fetchAll();
        $colorarray = array();
        for($i=0;$i<count($readcolor1);$i++)
        {
            $colorarray[$readcolor1[$i]['Attribute']] = $readcolor1[$i]['Value'];

        }

        //get product sizes
        $productallsizes = array();


        $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'size'); //here, "color" is the attribute_code
        $allOptions = $attribute->getSource()->getAllOptions(true, true);
        for($i=0;$i<count($allOptions);$i++)
        {
            $productsizearray[$allOptions[$i]['label']] = $allOptions[$i]['value'];
        }

        $sdate= date('Y-m-d', strtotime('-2 days', strtotime(date('Y-m-d')))).' 00:00:00';
        $edate= date('Y-m-d', strtotime('-2 days', strtotime(date('Y-m-d')))).' 23:59:59';
        $readresult=$write->query("SELECT sales_flat_quote.entity_id,customer_email , customer_firstname, customer_lastname ,GROUP_CONCAT(product_id) as product_id
  FROM sales_flat_quote, sales_flat_quote_item WHERE is_active = 1 AND customer_email IS NOT NULL
    AND items_count > 0 AND (SELECT is_active FROM customer_entity ce WHERE ce.entity_id = customer_id) = 1 AND sales_flat_quote_item.quote_id=sales_flat_quote.entity_id AND sales_flat_quote_item.product_type IN ('simple','giftcards')
    AND sales_flat_quote.updated_at between '".$sdate."' and '".$edate."' 
 GROUP BY customer_email ORDER BY  sales_flat_quote.updated_at DESC");
        
        $abandonedproductsparentId=array();
        while ($row = $readresult->fetch() ) {

            $row['customer_email'];
            $row['customer_firstname'];
            $row['customer_lastname'];
            

            $product_ids = explode(",", $row['product_id']);
            $tempcolor = '';
            $tempproductname = '';
            $tempsize = '';
            $html = '';
            $html ='<table cellspacing="10" cellpadding="5">
                        <tr>
                            <th style="font-size: 12px;font-weight: bold; text-align: left; font-family:Calibri;color: #666;" colspan="5">SHOPPING BAG CONTENTS:</th>
                            <th></th>
                        </tr>';
            
            foreach($product_ids as $id)
            {    
                
                $productname = '';
                $producturl = '';
                $productimageurl = '';
                $_product = Mage::getModel('catalog/product')->load($id);
                $pcolor = (int) $_product->getColor();
                $color = array_search($pcolor, $colorarray);
                //echo Mage::getBaseUrl().$_product->getUrlKey().".html";die;
                $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($id);
                if (isset($parentIds[0])) {
                    $parentproduct = Mage::getModel('catalog/product')->load($parentIds[0]);                    
                    $productname = $parentproduct->getName();
                    $abandonedproductsparentId[] = $parentIds[0];
                    $producturl = Mage::helper('core/url')->getHomeUrl().$parentproduct->getUrlKey();
                    $productimageurl = (string)Mage::helper('catalog/image')->init($parentproduct, 'image')->resize(150);
                    $_gallery =Mage::getModel('catalog/product')->load($parentIds[0])->getMediaGalleryImages();
                    $imageArr = array();
                    foreach($_gallery as $_image)
                    {

                        $imgdata = json_decode(trim($_image->getLabel()), true);
                        $colorId = $imgdata['color'];
                        
                        if($colorId == $pcolor)
                        {
                            //echo $_image->getFile();
                            $productimageurl= $_image->getUrl();
                            break;
                        }
                        //echo $productimageurl = Mage::helper('catalog/image')->init($parentIds[0], 'thumbnail',$_image)->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(150)->setQuality(91);
                    }
                    
                    
                }else{
                    $producturl = Mage::helper('core/url')->getHomeUrl().$_product->getUrlKey();
                    $productname = $_product->getName();
                    $productimageurl = (string)Mage::helper('catalog/image')->init($_product, 'image')->resize(150);
                }
                //echo $parentproduct->getUrlKey();
                //print_r($parentproduct);die;

                //$subhtml2 .= '<td>'.$_product->getName().'</td>';
                //print_r($colorarray);
//                $pcolor = (int) $_product->getColor();
//                $color = array_search($pcolor, $colorarray);
                //print_r($pcolor);
                //print_r($color);
                $tempcolor .= $color.',';
                $size = array_search($_product->getSize(), $productsizearray);
                $tempsize .= $size.',';
                $tempproductname .= $productname.',';

                $html .= '<tr>
                                <td>&nbsp;</td>
                                    <td style="text-align: center;padding-bottom: 3px;padding-top: 8px; border:1px solid #ccc;">
                                        <a  href="'.$producturl.'"  target="_blank">
                                                <img width="75" src="'.$productimageurl.'" alt="YOGASMOGA"  />
                                        </a>
                                    </td>
                                    <td>
                                        <a style="color: #666666;text-decoration: none;font-size: 12px;font-weight: bold; font-family:Calibri;" href="'.$producturl.'"  target="_blank">
                                                '.$productname.'
                                        </a><br/>
                                        <a style="color: #666666;text-decoration: none;font-size: 12px;font-weight: bold; font-family:Calibri;" href="'.$producturl.'"  target="_blank">
                                                COLOR: '.$color.'
                                        </a>';
                if($size !='') $html .= '<br/><a style="color: #666666;text-decoration: none;font-size: 12px;font-weight: bold; font-family:Calibri;" href="'.$producturl.'"  target="_blank">
                                                SIZE: '.$size.'
                                        </a>';
                $html .= '</td>
                            </tr>';



//                $abandonedlist1 =  array($row['customer_email'], $row['customer_firstname'] , $row['customer_lastname'],$productname, $color, $size  );
                //$abandonedlist1 =  array("customer_email"=>$row['customer_email'], "customer_firstname"=>$row['customer_firstname'] ,"customer_lastname"=>$row['customer_lastname'],"product_name"=>$productname, "product_color"=>$color, "product_size"=> $size ,"product_url"=>$producturl,"product_imageurl" => $productimageurl );
                //array_push($abandonedlist, $abandonedlist1);
            }
            $html .= '  <tr height="56">
                            <td></td>
                        </tr>
		        </table>';
            ////////////Related Products HTML ///////////////
            $html .='<table cellspacing="10" cellpadding="5">
                        <tr>
                            <td style="text-align: center;">
                            <a style="width:640px;text-align: center" href="https://yogasmoga.com/customer/account/login?goto=cart">
                                    <img src="http://yogasmoga.com/media/wysiwyg/email_images/abandoned/btn_checkout.png" alt="YOGASMOGA" style="">
                            </a>
                           </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <img src="http://yogasmoga.com/media/wysiwyg/email_images/abandoned/divider.png" alt="YOGASMOGA" style="margin-bottom: 8px;">
                            </td>
                        </tr>
                        </table>';
            $abandonedproductsparentId = array_unique($abandonedproductsparentId);
            $categoryIds = array();
            foreach ($abandonedproductsparentId as $parentId) {
                $parentproduct = Mage::getModel('catalog/product')->load($parentId);
                $cat=$parentproduct->getCategoryIds();
                foreach ($cat as $catId) {
                    $categoryIds[] = $catId;
                }
            }
            $catid='';
            if(!in_array(5,$categoryIds) && in_array(3,$categoryIds)) $catid=3;
            else if(in_array(5,$categoryIds) && !in_array(3,$categoryIds)) $catid=5;     
            if($catid !='') { 
                $category = Mage::getModel('catalog/category')->load($catid);
                $collectionConfigurable = Mage::getResourceModel('catalog/product_collection')->addAttributeToFilter('type_id', 'configurable')->addAttributeToFilter('status', 1)->addCategoryFilter($category);
            }
            else $collectionConfigurable = Mage::getResourceModel('catalog/product_collection')->addAttributeToFilter('type_id', 'configurable')->addAttributeToFilter('status', 1);
            $confis = array();
            foreach ($collectionConfigurable as $_configurableproduct) {
                $product = Mage::getModel('catalog/product')->load($_configurableproduct->getId());
                $confis[] = $product->getId();
            }
            $out1 = array_diff($confis, $abandonedproductsparentId);            

            $html .='<table cellspacing="10" cellpadding="5" width="100%">
                        <tr>
                            <td align="center" style="font-size: 12px;font-weight: bold; text-align:center; font-family:Calibri;color: #666;" colspan="3">YOU MAY ALSO LIKE:</td>
                            
                        </tr><tr>';
            $i = 0;
            $out1 = $this->shuffle_assoc($out1);
            foreach ($out1 as $key => $value) {
                $_rproduct = Mage::getModel('catalog/product')->load($value);
                $rproductname = $_rproduct->getName();
                $rproducturl = Mage::helper('core/url')->getHomeUrl() . $_rproduct->getUrlKey();
                $rproductimageurl = (string) Mage::helper('catalog/image')->init($_rproduct, 'image')->resize(150);

                $html .= '<td style="text-align: center;padding-bottom: 3px;padding-top: 8px;">
                                        <a  href="' . $rproducturl . '" target="_blank">
                                                <img  src="' . $rproductimageurl . '" alt="YOGASMOGA"  />
                                        </a>
                                    <br><br>
                                        <a style="color: #666666;text-decoration: none;font-size: 12px;font-weight: bold; font-family:Calibri;" href="' . $rproducturl . '" target="_blank">
                                                ' . $rproductname . '
                                        </a>
                                    </td>';
                $i++;
                if ($i == 3)
                    break;
            }
            $html .= '</tr>  <tr height="56">
                            <td></td>
                        </tr>
		        </table>';
            //echo $html;
            /////////////END/////////////////

            $abandonedlist1 =  array("cartid"=>$row['entity_id'],"customer_email"=>$row['customer_email'], "customer_firstname"=>$row['customer_firstname'] ,"customer_lastname"=>$row['customer_lastname'],"product_name"=>$tempproductname, "product_color"=>$tempcolor, "product_size"=> $tempsize ,"product_url"=>$producturl,"product_imageurl" => $productimageurl,"product_html"=>$html );
            array_push($abandonedlist, $abandonedlist1);


        }
        


        //print_r($abandonedlist);die;
        return $abandonedlist;

    }
    public function shuffle_assoc($list) { 
        if (!is_array($list)) return $list; 

        $keys = array_keys($list); 
        shuffle($keys); 
        $random = array(); 
        foreach ($keys as $key) { 
          $random[$key] = $list[$key]; 
        }
        return $random; 
      } 
    public function sendemail($recipient_email, $recipient_fistname,$recipient_lastname, $recipient_productname,$recipient_productcolor,$recipient_productsize,$recipient_producturl,$product_imageurl,$product_html )
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');

        $mail_collection = Mage::getModel('core/email_template')->getCollection()->addFieldToFilter('template_code','abandonedcart_notification_email');
        $template_id = $mail_collection->getFirstItem()->getTemplate_id();

        $recipient = array(
            'email' => $recipient_email,
            'name'  => $recipient_fistname
        );
        $sender  = array(
            'name' => 'YOGASMOGA',
            'email' => 'hello@yogasmoga.com'
        );
        //echo "<pre>";print_r($email); die('test');
        $email->setDesignConfig(array('area'=>'frontend', 'store'=> Mage::app()->getStore()->getId()))
            ->sendTransactional(
                $template_id,
                $sender,
                $recipient_email,
                $recipient_fistname,

                array(
                    'lastname'        => $recipient_lastname,
                    'producthtml'     => $product_html,
                    'storeurl'         => Mage::getBaseUrl()
//                    'productname' => $recipient_productname,
//                    'productcolor' => $recipient_productcolor,
//                    'productsize' => $recipient_productsize,
//                    'producturl' => $recipient_producturl,
//                    'productimageurl' => $product_imageurl
                )

            );
        Mage::log("check email", null, "abandonedemailsend.log");
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }
    public function notifyusers()
    {
        Mage::log("notifying users", null, "smoginotifier.log");
        $notification_periods = array(3,30);
        $serverType = Mage::getModel('core/variable')->loadByCode('server_type')->getValue('plain');
        foreach($notification_periods as $notification_period)
        {
            $customerlist = $this->getabandonedlist($notification_period);
            $notify_date = date('Y-m-d');
            $bucks_expiration_date = date('Y-m-d', strtotime(" + ".$notification_period." days"));
            foreach($customerlist as $customer)
            {
                $notification_log = Mage::getModel('smogiexpirationnotifier/notify');
                $notification_log->setCustomer_id($customer['customer_id']);
                $notification_log->setCustomer_email($customer['customer_email']);
                $notification_log->setCustomer_name($customer['customer_name']);
                $notification_log->setBucks_expiring($customer['bucks_expiring']);
                $notification_log->setBucks_expiration_date($bucks_expiration_date);
                $notification_log->setNotify_date($notify_date);
                if($serverType == 'production')
				    $notification_log->setEmail_status($this->sendemail($customer['customer_name'], $customer['customer_email'], $customer['bucks_expiring'], $notification_period));
            /*    else
                    $notification_log->setEmail_status($this->sendemail($customer['customer_name'], "ankit@mobikasa.com", $customer['bucks_expiring'], $notification_period));  */
                $notification_log->setNotification_period($notification_period);
                $notification_log->save();
            }
        }
    }

    public function getCustomerslist($expiring_in_days)
    {
        $allStores = Mage::app()->getStores();	
        $customerlist = array();
        foreach ($allStores as $_eachStoreId => $val)
        {
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            $days = $expiring_in_days;
		/*	$points = Mage::getModel('rewardpoints/stats')
                        ->getResourceCollection()
                        ->addFinishFilter($days)
                        ->addValidPoints($store_id);
            if ($points->getSize()){
				foreach ($points as $current_point){
                    $customer_id = $current_point->getCustomerId();
                    $points = $current_point->getNbCredit();
                    $customer = Mage::getModel('customer/customer')->load($customer_id);
                    $customerName = $customer->getName();
                    $customerEmail = $customer->getEmail();
                    array_push($customerlist, array("customer_id" => $customer_id, "customer_email" => $customerEmail, "customer_name" => $customerName,"bucks_expiring" => $points));
                }
            }*/
            $resource = Mage::getSingleton('core/resource');
            //$writeConnection = $resource->getConnection('core_write');
            $readConnection = $resource->getConnection('core_write');
            $temp = $readConnection->query("Select entity_id from customer_entity where is_active=1");
            $date = date('Y-m-d');
            $dateAfter = date('Y-m-d', strtotime($date. ' + '.$days.' day'));
            while($customerId = $temp->fetch())
            {
                $customer = Mage::getModel('customer/customer')->load($customerId);
                $customerName = $customer->getName();
                $customerEmail = $customer->getEmail();
                $customer_id =  $customer->getId();
                //$expireSmogiBucks = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id) - Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id,$dateAfter);

                $afterSmogiArrray = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id,$dateAfter, true);
                $afterBalance = 0;

                foreach($afterSmogiArrray["history"] as $smogi1)
                {
                    if(strtotime($dateAfter)== strtotime($smogi1["date_end"]))
                    {
                        $afterBalance += $smogi1["balance"];

                    }
                }

                    $expireSmogiBucks = $afterBalance;
                    if($expireSmogiBucks > 0)
                    {
                        array_push($customerlist, array("customer_id" => $customer_id, "customer_email" => $customerEmail, "customer_name" => $customerName,"bucks_expiring" => $expireSmogiBucks));
                    }



            }

        }
        return $customerlist;
    }
    

}
?>