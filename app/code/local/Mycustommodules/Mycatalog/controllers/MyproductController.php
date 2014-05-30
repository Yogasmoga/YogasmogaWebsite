<?php
class Mycustommodules_Mycatalog_MyproductController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Output from Product Module";
    }

    public function capitalizeAction()
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT * FROM customer_address_entity_varchar WHERE attribute_id IN (20,22)");
        while ($row = $readresult->fetch() ) {
            $write->query("Update customer_address_entity_varchar set value='".str_replace("'","''",ucwords($row['value']))."' where value_id=".$row['value_id']);
        }
    }

    public function inventoryAction()
    {
        $_product = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('id'));
        $_childproducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);
        $inv = Array();
        $configurableAttributeCollection=$_product->getTypeInstance()->getConfigurableAttributes();
        $sizeavaliable = false;
        foreach($configurableAttributeCollection as $attribute){
            if($attribute->getProductAttribute()->getAttributeCode() == "size")
            {
                $sizeavaliable = true;
                break;
            }
        }
        foreach($_childproducts as $_childproduct)
        {
            $temp = Array();
            $temp[0] = substr($_childproduct->getAttributeText('color'), 0, strpos($_childproduct->getAttributeText('color'),"|"));
            if($sizeavaliable)
                $temp[1] = $_childproduct->getAttributeText('size');
            else
                $temp[1] = "2";
            $temp[2] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
            $temp[3] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getIsInStock();
            $backOrderCheck = (int) Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getBackorders();
            $temp[4] = $backOrderCheck;
            array_push($inv, $temp);
        }
        echo json_encode($inv);
    }

    public function inventoryreportAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {
                $output = "<table>" ;
                $output .= "<tr><td style='height:80px;width:200px !important'><img src='http://yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/logo.png' /></td><td style='vertical-align:middle' colspan='5'>INVENTORY STATUS AS OF ".date("dS M,Y")."</td></tr>";
                $productCollection1 = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter(array(array('attribute'=>'type_id', 'eq'=>'configurable'), array('attribute'=>'status', 'eq' => Mage_Catalog_Model_Product_Status::STATUS_DISABLED)))->setPageSize(20000);
                //$productCollection = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter(array(array('attribute'=>'type_id', 'eq'=>'configurable'), array('attribute'=>'status', 'eq' => '2')));
                //$productCollection = Mage::getResourceModel('catalog/product_collection')->addAttributeToFilter('type_id', array('eq' => 'configurable'));

                // custom code for filter enabled product
                $productCollection = array();

                $i=0;
                foreach($productCollection1 as $product){
                    $status = $product->getStatus();
                    if($status == 1){
                        $productCollection[$i] = $product;
                        $i++;
                    }
                }
                $write = Mage::getSingleton('core/resource')->getConnection('core_read');
                $readresult=$write->query("SELECT eaov.value AS 'Attribute', eaov.option_id AS 'Value' FROM eav_attribute ea, eav_attribute_option eao, eav_attribute_option_value eaov
WHERE ea.attribute_id = eao.attribute_id
AND eao.option_id = eaov.option_id
AND eaov.store_id = 0
AND ea.attribute_code='size' ORDER BY eao.sort_order, eaov.value");
                $i = 0;
                $allsizearray = array();
                while($row = $readresult->fetch())
                {
                    $allsizearray[$i] = $row['Attribute'];
                    $i++;
                }

                $arrAccessories = array();
                for ($i = 1; $i <= $productCollection1->getLastPageNumber(); $i++) {
                    if ($productCollection1->isLoaded()) {
                        $productCollection1->clear();
                        $productCollection1->setPage($i);
                        $productCollection1->setPageSize(20000);
                    }
                    foreach ($productCollection as $product) { //echo '<pre>'; print_r($product);die('ttt');
                        $productCats = $product->getCategoryIds();
                        if(array_search(8, $productCats) !== false){
                            array_push($arrAccessories, $product->getId());
                        }
                        else
                            $this->getinventoryhtml($product->getId(), $output);
                    }
                    //echo $i . "\n\n";

                }
                for($ii = 0; $ii < count($arrAccessories); $ii++)
                    $this->getinventoryhtml($arrAccessories[$ii], $output);

                $output .= "<tr><td colspan='2' style='font-weight:bold;'>LEGEND</td></tr>";
                $output .= "<tr><td>VALUE</td><td colspan='4'>Product is in stock and the inventory is positive.</td></tr>";
                $output .= "<tr><td style='color:#fff;background-color:gray;'>VALUE</td><td colspan='4'>Product is out of stock.</td></tr>";
                $output .= "<tr><td style='color:#fff;background-color:red;'>VALUE</td><td colspan='4'>Product is in stock and is in pre-order state.</td></tr>";
                $output .= "<tr><td style='color:#fff;background-color:black;'>VALUE</td><td colspan='4'>This combination of color and size is not available and not displayed on the product view page.</td></tr>";
                $output .= "</table>";
//                echo 'test';
//                echo $output;
                //$fname = mktime();

                if($this->getRequest()->getParam('recurring') == "true")
                {
                    $fname = date("M_j_Y");
                    $fname = "inv_".$fname;

                    $baseDir = Mage::getBaseDir();
                    $varDir = $baseDir.DS.'recurringreports'.DS.'inventory'.DS.$fname.'.xls';

                    unlink($varDir);
                    file_put_contents('recurringreports/inventory/'.$fname.'.xls',$output);
                    return;
                }

                $fname = mktime();
                file_put_contents('tempreports/'.$fname.'.xls',$output);

                Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".xls");
            }
        }
    }

    public function getinventoryhtml($product, &$output)
    {
        //echo $product->getId() . "\n\n";
        $_product = Mage::getModel('catalog/product')->load($product);
        $productname = Mage::Helper('catalog/output')->productAttribute($_product, $_product->getName(), 'name');
        $_childproducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);
        $productcolorinfo = array();
        $sizeArray = array();
        $oldsizeArray = array();
        $sizeTotal = array();
        foreach($_childproducts as $_childproduct)
        {
            //echo Mage::Helper('catalog/output')->productAttribute($_childproduct, $_childproduct->getName(), 'name')."         ";
            $temp = $_childproduct->getAttributeText('color');
            if(strpos($temp,"|") !== FALSE)
            {
                $temp = substr($temp, 0, strpos($temp,"|"));
                if(!isset($productcolorinfo[$temp]))
                    $productcolorinfo[$temp] = array();
            }
            //$temp1 = $_childproduct->getAttributeText('size')."|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
            if(Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getIsInStock())
                $productcolorinfo[$temp][$_childproduct->getAttributeText('size')] = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
            else
                $productcolorinfo[$temp][$_childproduct->getAttributeText('size')] = "_".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty();
            if(array_search($_childproduct->getAttributeText('size'), $sizeArray ) === false)
            {
                array_push($sizeArray , $_childproduct->getAttributeText('size'));
                $sizeTotal[$_childproduct->getAttributeText('size')] = 0;
            }




            //if(isset($productcolorinfo[$temp]["sizes"]))
//                            {
//                                
//                                array_push($productcolorinfo[$temp]["sizes"], $temp1);
//                            }
//                            else
//                            {
//                                $productcolorinfo[$temp]["sizes"] = array($temp1);
//                            }
            //echo $temp."   ".$temp1."<br/>";

        }

        //echo "<pre>";
//                        print_r($productcolorinfo);
//                        asort($sizeArray);
//                        print_r($sizeArray);
//                        echo "</pre>";
//                        echo "<br/><br/>";
        $output .= "<tr style='color:#FFFFFF;'>";
        $output .= "<td style='background-color:#003366;'>Name</td><td style='background-color:#003366;'>Color</td>";
        sort($sizeArray);
        for($j = 0; $j < count($sizeArray); $j++)
        {
            if($sizeArray[$j] != "")
                $output .= "<td style='background-color:#003366;'>Size ".$sizeArray[$j]."</td>";
            else
                $output .= "<td style='background-color:#003366;'>Qty</td>";
        }
        $output .= "</tr>";
        foreach($productcolorinfo as $key=>$val)
        {
            $output .= "<tr>";
            $output .= "<td>$productname</td><td>".$key."</td>";
            for($j = 0; $j < count($sizeArray); $j++)
            {
                if(isset($val[$sizeArray[$j]]))
                {
                    $outofstock = false;
                    if(strpos($val[$sizeArray[$j]], "_") !== false)
                    {
                        $outofstock = true;
                    }
                    $val[$sizeArray[$j]] = str_replace("_","",$val[$sizeArray[$j]]);
                    if($outofstock)
                    {
                        $output .= "<td style='color:#fff;background-color:gray;'>".number_format($val[$sizeArray[$j]])."</td>";
                    }
                    else
                    {
                        if($val[$sizeArray[$j]] <= 0)
                            $output .= "<td style='color:#fff;background-color:red;'>".number_format($val[$sizeArray[$j]])."</td>";
                        else
                            $output .= "<td>".number_format($val[$sizeArray[$j]])."</td>";
                    }
                    $sizeTotal[$sizeArray[$j]] += $val[$sizeArray[$j]];
                }
                else
                    $output .= "<td style='background-color:black;color:#fff;'>0</td>";
            }
            $output .= "</tr>";
        }
        $output .= "<tr style='font-weight:bold;'>";
        $output .= "<td>&nbsp;</td><td>&nbsp;</td>";
        $g_sum = 0;
        for($j = 0; $j < count($sizeArray); $j++)
        {
            $output .= "<td>".$sizeTotal[$sizeArray[$j]]."</td>";
            $g_sum += $sizeTotal[$sizeArray[$j]];
        }
        $output .= "<td style='color:red;'>".$g_sum."</td>";
        $output .= "</tr>";
        $output .= "<tr><td colspan='20'></td></tr>";
//                        $output .= "<tr><td colspan='20'></td></tr>";
    }

    public function goysbalanceAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {
                $output = "<table border='1'><thead><tr><th>Id</th>
                <th>Email ID</th>
                <th>Name</th>
                <th>GOYS Balance</th>
                <th>Cards</th>
                </tr><thead><tbody>";
                $write = Mage::getSingleton('core/resource')->getConnection('core_read');
                $readresult=$write->query("SELECT entity_id AS 'Id', email AS 'Email',
 (SELECT CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=ce.entity_id AND attribute_id=5), ' ', (SELECT VALUE FROM customer_entity_varchar WHERE entity_id=ce.entity_id AND attribute_id=7))) AS 'Name',
 (SELECT IF(SUM(card_balance) > 0, SUM(card_balance), 0) FROM giftcards_card WHERE customer_id=ce.entity_id) AS 'GY Balance'
 FROM customer_entity ce ORDER BY ce.entity_id");
                while ($row = $readresult->fetch() ) {
                    $write1 = Mage::getSingleton('core/resource')->getConnection('core_read');
                    $readresult1=$write->query("Select card_code from giftcards_card where customer_id=".$row['Id']);
                    $cardslist = "";
                    while ($row1 = $readresult1->fetch() ) {
                        $cardslist .= $row1['card_code'].",";
                    }
                    if(strlen($cardslist) > 0)
                        $cardslist = substr($cardslist, 0, strlen($cardslist) - 1);

                    $outputtemp = "<tr><td>".$row['Id']."</td>";
                    $outputtemp .= "<td>".$row['Email']."</td>";
                    $outputtemp .= "<td>".$row['Name']."</td>";
                    $outputtemp .= "<td>".round($row['GY Balance'], 2)."</td>";
                    $outputtemp .= "<td>".$cardslist."</td>";
                    $outputtemp .= "</tr>";
                    $output .= $outputtemp;
                }
                $output .= "</tbody></table>";
                //echo $output;
                $fname = mktime();
                file_put_contents('tempreports/'.$fname.'.xls',$output);
                Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".xls");
            }
        }
    }

    public function referralreportAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {
                $output = "<table border='1'><thead><tr>
                <th>Name</th>
                <th>Email</th>
                <th>Referral Count</th>
                <th>Referral Name</th>
                <th>Referral Email</th>
                </tr><thead><tbody>";
                $write = Mage::getSingleton('core/resource')->getConnection('core_read');
                $readresult=$write->query("SELECT 
CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=5),' ',(SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=7)) AS 'Name',
rr.rewardpoints_referral_parent_id AS 'Id',
(SELECT email FROM customer_entity ce WHERE entity_id=rr.rewardpoints_referral_parent_id) AS 'Email',
(SELECT COUNT(rr1.rewardpoints_referral_email) FROM rewardpoints_referral rr1 WHERE rr1.rewardpoints_referral_status=1 AND rr1.rewardpoints_referral_parent_id=rr.rewardpoints_referral_parent_id) AS 'Count',
CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_child_id AND attribute_id=5),' ',(SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_child_id AND attribute_id=7)) AS 'Referral_Name',
(SELECT email FROM customer_entity ce WHERE entity_id=rr.rewardpoints_referral_child_id) AS 'Referral_Email'
FROM rewardpoints_referral rr WHERE rewardpoints_referral_status=1 AND (SELECT COUNT(rr1.rewardpoints_referral_email) FROM rewardpoints_referral rr1 WHERE rr1.rewardpoints_referral_status=1 AND rr1.rewardpoints_referral_parent_id=rr.rewardpoints_referral_parent_id) > 1
ORDER BY CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=5),' ',(SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=7))");
                while ($row = $readresult->fetch() ) {
                    $outputtemp = "<tr><td>".$row['Name']."</td>";
                    $outputtemp .= "<td>".$row['Email']."</td>";
                    $outputtemp .= "<td>".$row['Count']."</td>";
                    $outputtemp .= "<td>".$row['Referral_Name']."</td>";
                    $outputtemp .= "<td>".$row['Referral_Email']."</td>";
                    $outputtemp .= "</tr>";
                    $output .= $outputtemp;
                }
                $output .= "</tbody></table>";
                //echo $output;
                $fname = "referral_".mktime();
                file_put_contents('tempreports/'.$fname.'.xls',$output);
                Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".xls");
            }
        }
    }

    public function orderreportAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            //echo $this->getRequest()->getParam('date');
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {
                $startdate = $this->getRequest()->getParam('startdate');
                $datearr = split("-", $startdate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $startdate = $datearr[2]."-".$datearr[0]."-".$datearr[1];

                $enddate = $this->getRequest()->getParam('enddate');
                $datearr = split("-", $enddate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $enddate = $datearr[2]."-".$datearr[0]."-".$datearr[1]." 23:59:59";
                //echo $date;
//                return;
                $output = "<table border='1'><thead><tr><th>Order#</th>
                <th>Date</th>
                <th>Status</th>
                <th>Coupon Code</th>
                <th>Shipping Method</th>
                <th>Bill To</th>
                <th>Ship To</th>
                <th>Region</th>
                <th>City</th>
                <th>Zip Code</th>
                <th>Qty Ordered</th>
                <th>Qty Refunded</th>
                <th>Qty PreOrdered</th>
                <th>SKU</th>
                <th>Name</th>
                <th>Color</th>
                <th>Size</th>
                <th>Is Accessory?</th>
                <th>Tax Paid($)</th>
                <th>Discount($)</th>
                <th>Shipping Amount($)</th>
                <th>Gross Amount($)</th>
                <th>Net Amount($)</th>
                <th>Order Total($)</th>
                <th>Payment Method</th>
                </tr><thead><tbody>";
                $write = Mage::getSingleton('core/resource')->getConnection('core_read');
                //$readresult=$write->query("SELECT increment_id AS 'orderno', STATUS AS 'status', total_paid AS 'paid', shipping_description AS 'shipping', DATE_FORMAT(created_at, '%m-%d-%Y') AS 'orderdate',(SELECT CONCAT(firstname,' ',lastname) AS 'name' FROM sales_flat_order_address WHERE address_type='billing' AND parent_id=sfo.entity_id) AS 'billto',(SELECT CONCAT(firstname,' ',lastname) AS 'name' FROM sales_flat_order_address WHERE address_type='shipping' AND parent_id=sfo.entity_id) AS 'shipto', entity_id FROM sales_flat_order sfo where created_at >= '".$startdate."' and created_at <= '".$enddate."' ORDER BY created_at desc");
                //$readresult=$write->query("SELECT sfo.increment_id AS 'orderno', sfo.status AS 'status', sfo.total_paid AS 'paid', sfo.shipping_description AS 'shipping', DATE_FORMAT(sfo.created_at, '%m-%d-%Y') AS 'orderdate', sfo.entity_id,(SELECT customer_id FROM sales_flat_order_address WHERE address_type='billing' AND parent_id=sfo.entity_id) AS 'customer_id',(SELECT email FROM sales_flat_order_address WHERE address_type='billing' AND parent_id=sfo.entity_id) AS 'email', (SELECT CONCAT(firstname,' ',lastname) AS 'name' FROM sales_flat_order_address WHERE address_type='billing' AND parent_id=sfo.entity_id) AS 'billto', CONCAT(firstname,' ',lastname) AS 'shipto', sfoa.region AS 'region', sfoa.city AS 'city', sfoa.postcode AS 'postcode', sfo.coupon_code AS 'coupon' FROM sales_flat_order sfo, sales_flat_order_address sfoa WHERE sfo.created_at >= '".$startdate."' AND sfo.created_at <= '".$enddate."' AND sfoa.parent_id = sfo.entity_id AND sfoa.address_type='shipping' ORDER BY sfo.created_at DESC;");
                $readresult=$write->query("SELECT sfo.increment_id AS 'orderno', sfo.status AS 'status', sfo.base_grand_total AS 'paid', sfo.shipping_description AS 'shipping',sfo.shipping_amount AS 'shipping_amount', DATE_FORMAT(sfo.created_at, '%m-%d-%Y') AS 'orderdate', sfo.entity_id,(SELECT customer_id FROM sales_flat_order_address WHERE address_type='billing' AND parent_id=sfo.entity_id) AS 'customer_id',(SELECT email FROM sales_flat_order_address WHERE address_type='billing' AND parent_id=sfo.entity_id) AS 'email', (SELECT CONCAT(firstname,' ',lastname) AS 'name' FROM sales_flat_order_address WHERE address_type='billing' AND parent_id=sfo.entity_id) AS 'billto', CONCAT(firstname,' ',lastname) AS 'shipto', sfoa.region AS 'region', sfoa.city AS 'city', sfoa.postcode AS 'postcode', sfo.coupon_code AS 'coupon',(SELECT method FROM sales_flat_order_payment WHERE  parent_id=sfo.entity_id) AS 'paymentMethod' FROM sales_flat_order sfo, sales_flat_order_address sfoa WHERE sfo.created_at >= '".$startdate."' AND sfo.created_at <= '".$enddate."' AND sfoa.parent_id = sfo.entity_id AND sfoa.address_type='shipping' ORDER BY sfo.created_at DESC;");
                $paymentMethod = array("stripe"=>"Stripe","cashondelivery"=>"Cash on Delivery","paypal_express"=>"Paypal","free"=>"NA");
                while ($row = $readresult->fetch() ) {
                    $emailtotest = "";
                    if($row['customer_id'] != "")
                    {
                        $write11 = Mage::getSingleton('core/resource')->getConnection('core_read');
                        $readresult11 = $write->query("Select email from customer_entity where entity_id=".$row['customer_id']);
                        $row11 = $readresult11->fetch();
                        $emailtotest = $row11['email'];
                    }
                    else
                    {
                        $emailtotest = $row['email'];
                    }
                    if(stripos($emailtotest,"mobikasa.com") !== false || $emailtotest == "mangat.c@gmail.com" || $emailtotest == "oksana.gervas@yogasmoga.com")
                        $outputtemp = "<tr style='background-color:#CCCCCC'>";
                    else
                        $outputtemp = "<tr>";
                    $order = Mage::getModel('sales/order')->load($row['entity_id']);
                    //$outputtemp .= "<td>".$emailtotest."</td>";
                    $outputtemp .= "<td>".$row['orderno']."</td>";
                    $outputtemp .= "<td>".$row['orderdate']."</td>";
                    $outputtemp .= "<td>".$row['status']."</td>";
                    //$outputtemp .= "<td>".round($row['paid'], 2)."</td>";
                    $orderTotal =  "<td>".round($row['paid'], 2)."</td>";
                    $outputtemp .= "<td>".$row['coupon']."</td>";
                    $outputtemp .= "<td>".$row['shipping']."</td>";
                    //$outputtemp .= "<td>".$row['shipping_amount']."</td>";
                    $shippingAmount = "<td>".$row['shipping_amount']."</td>";
                    $outputtemp .= "<td>".$row['billto']."</td>";
                    $outputtemp .= "<td>".$row['shipto']."</td>";
                    $outputtemp .= "<td>".$row['region']."</td>";
                    $outputtemp .= "<td>".$row['city']."</td>";
                    $outputtemp .= "<td style='text-align:right;'>".$row['postcode']."</td>";

                    $write1 = Mage::getSingleton('core/resource')->getConnection('core_read');
                    //$result = $write1->query("SELECT item_id, product_id AS 'id', sku, qty_ordered AS 'ordered', qty_refunded AS 'refunded', qty_backordered AS 'backordered', qty_shipped AS 'shipped', product_id AS 'productid', sfoi.name AS 'name', sfoi.base_row_total, sfoi.discount_amount,(sfoi.base_row_total_incl_tax - sfoi.base_discount_amount) AS 'net_amount' FROM sales_flat_order_item sfoi WHERE product_type <> 'configurable' AND order_id=".$row['entity_id']);
                    $result = $write1->query("SELECT item_id, product_id AS 'id', sku, qty_ordered AS 'ordered', qty_refunded AS 'refunded', qty_backordered AS 'backordered', qty_shipped AS 'shipped', product_id AS 'productid', sfoi.name AS 'name', sfoi.base_row_total, sfoi.discount_amount, sfoi.base_tax_amount FROM sales_flat_order_item sfoi WHERE product_type <> 'configurable' AND order_id=".$row['entity_id']);
                    while ($row1 = $result->fetch() ) {

                        $productCats = array();
                        $taxPaid = $row1['base_tax_amount'];
                        $outputtemp1 = $outputtemp;
                        $name = $row1['name'];
                        $rowTotal = $row1['base_row_total'];
                        $rowDiscount = $row1['discount_amount'];
                        $netAmount = round(($rowTotal - $rowDiscount + $taxPaid), 2);
                        $_product = Mage::getModel('catalog/product')->load($row1['productid']);
                        if($_product->getTypeId() == "simple"){
                            $write2 = Mage::getSingleton('core/resource')->getConnection('core_read');
                            $result2 = $write2->query("SELECT name, product_id, base_tax_amount,row_total,discount_amount,(base_row_total_incl_tax-base_discount_amount) AS 'net_amount' FROM sales_flat_order_item sfoi WHERE product_type = 'configurable' AND item_id=".($row1['item_id'] - 1));
                            $row2 = $result2->fetch();
                            $name = $row2['name'];
                            $product = Mage::getModel('catalog/product')->load($row2['product_id']);
                            $productCats = $product->getCategoryIds();
                            $taxPaid = $row2['base_tax_amount'];
                            $rowTotal = $row2['row_total'];
                            $rowDiscount = $row2['discount_amount'];
                            //$netAmount = round($row2['net_amount'], 2);
                            $netAmount = round(($rowTotal - $rowDiscount + $taxPaid), 2);
                            //$parentIds = Mage::getModel('catalog/product_type_grouped')->getParentIdsByChild($_product->getId());
//                            if(!$parentIds)
//                                $parentIds = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($_product->getId());
//                            if(isset($parentIds[0])){
//                                $parent = Mage::getModel('catalog/product')->load($parentIds[0]);
//                                $name = Mage::Helper('catalog/output')->productAttribute($parent, $parent->getName(), 'name');
//                            }
                        }

                        $payment = $row['paymentMethod'];
                        $name = html_entity_decode($name);
                        $color = $_product->getAttributeText('color');
                        if(strpos($color, "|") !== false)
                            $color = substr($color, 0, strpos($color, "|"));
                        $outputtemp1 .= "<td>".round($row1['ordered'], 2)."</td>";
                        $outputtemp1 .= "<td>".round($row1['refunded'], 2)."</td>";
                        $outputtemp1 .= "<td>".round($row1['backordered'], 2)."</td>";
                        //$outputtemp1 .= "<td>".round($row1['shipped'], 2)."</td>";
                        $outputtemp1 .= "<td>".$row1['sku']."</td>";
                        $outputtemp1 .= "<td>".$name."</td>";
                        $outputtemp1 .= "<td>".$color."</td>";
                        $outputtemp1 .= "<td>".$_product->getAttributeText('size')."</td>";
                        if(array_search(8, $productCats) !== false){
                            $outputtemp1 .= "<td>Yes</td>";
                        }
                        else
                        {
                            $outputtemp1 .= "<td>No</td>";
                        }
                        $outputtemp1 .= "<td>".$taxPaid."</td>";
                        $outputtemp1 .= "<td>".$rowDiscount."</td>";
                        $outputtemp1 .= $shippingAmount;
                        $outputtemp1 .= "<td>".$rowTotal."</td>";
                        $outputtemp1 .= "<td>".$netAmount."</td>";
                        $outputtemp1 .= $orderTotal;
                        $outputtemp1 .= "<td>".$paymentMethod[$payment]."</td>";
                        $outputtemp1 .= "</tr>";
                        $output .= $outputtemp1;
                    }

                }
                //      echo $output;
                $fname = mktime();
                file_put_contents('tempreports/'.$fname.'.xls',$output);
                Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".xls");
            }
            else
                echo "Invalid Password";
        }
    }

    public function orderdevicereportAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {

                /* Order date code */
                $startdate = $this->getRequest()->getParam('startdate');
                $datearr = split("-", $startdate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $startdate = $datearr[2]."-".$datearr[0]."-".$datearr[1];

                $enddate = $this->getRequest()->getParam('enddate');
                $datearr = split("-", $enddate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $enddate = $datearr[2]."-".$datearr[0]."-".$datearr[1]." 23:59:59";

                /* Order date code */

                $output = "<table border='1'><thead><tr>
                <th>Order Date</th>
                <th>Order No.</th>
                <th>Device Type</th>
                </tr><thead><tbody>";
                $write = Mage::getSingleton('core/resource')->getConnection('core_read');
                // $readresult=$write->query("SELECT order_num AS 'orderno', is_mobile AS 'ismobile' FROM order_by_device");
                $readresult=$write->query("SELECT order_num AS 'orderno', is_mobile AS 'ismobile', DATE_FORMAT(sales_flat_order.created_at, '%m-%d-%Y') AS 'orderdate' FROM order_by_device, sales_flat_order where order_by_device.order_num = sales_flat_order.increment_id and sales_flat_order.created_at >= '".$startdate."' and sales_flat_order.created_at <= '".$enddate."' ORDER BY sales_flat_order.created_at desc");
                while ($row = $readresult->fetch() ) {

                    $outputtemp = "<tr><td>".$row['orderdate']."</td>";
                    $outputtemp .= "<td>".$row['orderno']."</td>";
                    if($row['ismobile'] == "0")
                        $outputtemp .= "<td>Desktop/Laptop/Ipad</td>";
                    else
                        $outputtemp .= "<td>Mobile Devices</td>";


                    $outputtemp1 .= "</tr>";
                    $outputtemp1 = $outputtemp;
                    $output .= $outputtemp1;
                }
                //echo $output;
                $fname = mktime();
                file_put_contents('tempreports/'.$fname.'.xls',$output);
                Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".xls");
            }
        }
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
                $arr['balance'] = Mage::helper('core')->currency($card->getCardBalance());
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

    public function resendinviteemailsAction()
    {
        try{
            if($this->getRequest()->getParam('pass'))
            {
                if($this->getRequest()->getParam('pass') == "MageHACKER")
                {
                    $write = Mage::getSingleton('core/resource')->getConnection('core_write');
                    $readresult=$write->query("SELECT ce.email AS 'Parent', rr.rewardpoints_referral_email AS 'Child', rr.rewardpoints_referral_name AS 'Name' FROM rewardpoints_referral rr, customer_entity ce WHERE rr.rewardpoints_referral_parent_id = ce.entity_id AND rr.rewardpoints_referral_status=0 AND rr.rewardpoints_referral_email NOT IN (SELECT email FROM myresendlog WHERE status=0 and NOW() > DATE_SUB(NOW(), INTERVAL 24 HOUR))");
                    while ($row = $readresult->fetch() ) {
                        //if($row['Child'] != "peeyush@mobikasa.com")
//                            continue;

                        $customer = Mage::getModel('customer/customer')
                            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail($row['Child']);
                        $output = "unsent";
                        if (!$customer->getId())
                        {
                            $customer = Mage::getModel('customer/customer')
                                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                                ->loadByEmail($row['Parent']);
                            //->loadByEmail('vishal@mobikasa.com');
                            //sleep(10);

                            //if(Mage::getModel('rewardpoints/referral')->sendSubscription($customer, 'ankit@mobikasa.com', $row['Name']))

                            if(Mage::getModel('rewardpoints/referral')->sendSubscription($customer, $row['Child'], $row['Name']))
                                //if(Mage::getModel('rewardpoints/referral')->sendSubscription($customer, "ankit@mobikasa.com", $row['Name']))
                                $output = "sent";
                            if($output == "sent")
                                $write->query("Insert into myresendlog values(null,'".$row['Parent']."','".$row['Child']."',1,now())");
                            else
                                $write->query("Insert into myresendlog values(null,'".$row['Parent']."','".$row['Child']."',0,now())");

                            Mage::log("|".$row['Parent']."|".$row['Child']."|".$row['Name']."|".$output,null,'resendlog.log');

                            //echo "correct  ";
                            //echo $row['Parent']." -> ".$row['Child']." -> ".$row['Name']."    ".$output."<br/>";
                        }
                    }
                    Mage::log("Yippee completed",null,'resendlog.log');
                }
                else
                {
                    Mage::log("Invalid password",null,'resendlog.log');
                    //echo "Invalid password";
                }
            }
        }
        catch(Exception $e)
        {
            Mage::logException($e);
        }
    }

    public function referfriendAction()
    {
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            $session         = Mage::getSingleton('core/session');
            $emails           = $this->getRequest()->getPost('email'); //trim((string) $this->getRequest()->getPost('email'));
            $names            = $this->getRequest()->getPost('name'); //trim((string) $this->getRequest()->getPost('name'));
            $id = $this->getRequest()->getPost('id');

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
                        $arr['message'] = "Friend name is required for email (".$email.")";
                        $arr['status'] = "error";
                        $no_errors = false;
                    }

                    if ($no_errors){
                        $custemail = $customerSession->getCustomer();
                        $custemail = $custemail->getEmail();
                        $from = $this->getRequest()->getPost('from');
                        if($from == "")
                            $from = "Account";
                        //Mage::log('|'.$from."|Request|".$custemail."|".$email,null,'referlog.log');
                        $arr['id'] = $id;
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
                                Mage::log('|'.$from."|yes|".$custemail."|".$email,null,'referlog.log');
                                $arr['status'] = "success";
                                $arr['message'] = "Friend is successfully invited";
                                echo json_encode($arr);
                                return;
                            } else {
                                //$session->addError($this->__('There was a problem with the invitation email %s.', $email));


                                //$arr['status'] = "success";
//                                $arr['message'] = "Friend is successfully invited";
//                                echo json_encode($arr);
//                                return;
                                Mage::log('|'.$from."|no|".$custemail."|".$email,null,'referlog.log');
                                $arr['status'] = "error";
                                $arr['message'] = "Invitiation unsuccessfull.";
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
                Mage::log('|'.$from."|Error|".$customer->getEmail()."|".$email."|".$e->getMessage(),null,'referlog.log');
                //$session->addException($e, $this->__('%s', $e->getMessage()));

            }
            catch (Exception $e) {
                //print_r($e);
//                die;
//                $session->addException($e, $this->__('There was a problem with the invitation.'));
                Mage::log('|'.$from."|Error|".$customer->getEmail()."|".$email."|".$e,null,'referlog.log');
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
        $isrewardable = false;
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
        //$rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "loyalty") - 1 - strlen("loyalty") - strpos($rewardpoints, "earn") + strlen("earn")));
        $rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "smogi") - 3 - strlen("smogi") - strpos($rewardpoints, "earn") + strlen("earn")));
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
            //$rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "loyalty") - 1 - strlen("loyalty") - strpos($rewardpoints, "earn") + strlen("earn")));
            $rewardpoints = trim(substr($rewardpoints, strpos($rewardpoints, "earn") + strlen("earn"), strpos($rewardpoints, "smogi") - 3 - strlen("smogi") - strpos($rewardpoints, "earn") + strlen("earn")));
            if($rewardpoints > 0)
                $isrewardable = true;
            if($sizeavaliable)
                $temp1 = $_childproduct->getAttributeText('size')."|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
            else
                $temp1 = "2|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getQty()."|".$price."|".$rewardpoints;
            $temp1 .= "|".Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childproduct)->getIsInStock();
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
                    $imgdata = json_decode(trim($_image->getLabel()), true);
                    if($imgdata == NULL || strcasecmp($imgdata['type'], "product image") != 0)
                        continue;
                    if($imgdata['color'] == Mage::getResourceModel('catalog/product')->getAttributeRawValue($_childproduct->getId(), 'color', Mage::app()->getStore()->getStoreId()))
                        //if(str_replace("*", "", $_image->getLabel()) == $temp)
                    {
                        $alt = "";
                        if(isset($imgdata['alt']))
                            $alt = $imgdata['alt'];
                        //echo $imageurl;
                        if($alt == "")
                        {
                            $abcclr = $_childproduct->getAttributeText('color');
                            if(strpos($abcclr, "|") !== false)
                                $abcclr = substr($abcclr, 0, strpos($abcclr, "|"));
                            $alt = $productname." - ".$abcclr;
                        }

                        $smallimageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(75, 75)->setQuality(100)."|".$alt;
                        $imageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(450, 450)->setQuality(100)."|".$alt;
                        $zoomimageurl = "_".Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(750, 750)->setQuality(100)."|".$alt;

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
                    $abc = explode("|", $val['images']['zoom'][$i]);
                    ?>
            _productcolorinfo[<?php echo $currentcolorcount; ?>].zoomimages[<?php echo $i; ?>] = new Array();
            _productcolorinfo[<?php echo $currentcolorcount; ?>].zoomimages[<?php echo $i; ?>][0] = "<?php echo substr($abc[0], 1); ?>";
            _productcolorinfo[<?php echo $currentcolorcount; ?>].zoomimages[<?php echo $i; ?>][1] = "<?php echo $abc[1]; ?>";
            <?php
        }
    ?>
            _productcolorinfo[<?php echo $currentcolorcount; ?>].smallimages = new Array();
            <?php
                for($i = 0; $i < count($val['images']['small']); $i++)
                {
                    $abc = explode("|", $val['images']['small'][$i]);
                    ?>
            _productcolorinfo[<?php echo $currentcolorcount; ?>].smallimages[<?php echo $i; ?>] = new Array();
            _productcolorinfo[<?php echo $currentcolorcount; ?>].smallimages[<?php echo $i; ?>][0] = "<?php echo substr($abc[0], 1); ?>";
            _productcolorinfo[<?php echo $currentcolorcount; ?>].smallimages[<?php echo $i; ?>][1] = "<?php echo $abc[1]; ?>";
            <?php
        }
    ?>
            _productcolorinfo[<?php echo $currentcolorcount; ?>].bigimages = new Array();
            <?php
                for($i = 0; $i < count($val['images']['big']); $i++)
                {
                    $abc = explode("|", $val['images']['big'][$i]);
                    ?>
            _productcolorinfo[<?php echo $currentcolorcount; ?>].bigimages[<?php echo $i; ?>] = new Array();
            _productcolorinfo[<?php echo $currentcolorcount; ?>].bigimages[<?php echo $i; ?>][0] = "<?php echo substr($abc[0], 1); ?>";
            _productcolorinfo[<?php echo $currentcolorcount; ?>].bigimages[<?php echo $i; ?>][1] = "<?php echo $abc[1]; ?>";
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
        <?php
        if(!$sizeavaliable)
        {
            ?>
            <script type="text/javascript">
                _sizesuperattribute = false;
            </script>
        <?php
        }
        else
        {
            ?>
            <script type="text/javascript">
                _sizesuperattribute = true;
            </script>
        <?php
        }
        ?>
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
        <table class="productdetailspopup normalproductdetail">
            <tr>
                <td class="popupproductdetail">
                    <div class="productoptions">
                        <table class="productdetailtable">
                            <tr>
                                <td>
                                    <div class="productname"><?php echo html_entity_decode($productname); ?></div>
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
                                        $primarycolorcode = Mage::getResourceModel('catalog/product')->getAttributeRawValue($_product->getId(), 'primarycolorcode', Mage::app()->getStore()->getStoreId());
                                        $first = true;
                                        //print_r($productcolorinfo);
                                        $colorcount = 0;
                                        for($incr = 0; $incr < 2; $incr++)
                                        {
                                            foreach($productcolorinfo as $key=>$colorinfo)
                                            {
                                                if($incr == 0)
                                                {
                                                    if($colorinfo['value'] != $primarycolorcode)
                                                        continue;
                                                }
                                                else
                                                {
                                                    if($colorinfo['value'] == $primarycolorcode)
                                                        continue;
                                                }
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
                                        }

                                        ?>
                                    </div>
                                    <div style="clear: both;"></div>
                                    <table class="selectedsize" <?php if(!$sizeavaliable) { echo "style='display:none;'"; } ?>>
                                        <tr>
                                            <td>SIZE</td>
                                            <?php if($sizechartblockid != "") {?>
                                                <td class="sizechartlink">
                                                    <div style="position: relative;">
                                                        <a href="javascript:void(0);">Size chart</a>

                                                        <div id="sizechart">
                                                            <?php echo $this->getLayout()->createBlock('cms/block')->setBlockId($sizechartblockid)->toHtml(); ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                    <div id="sizecontainer" <?php if(!$sizeavaliable) { echo "style='display:none;'"; } ?>>
                                        <table>
                                            <tr>
                                                <?php
                                                $sizecount = 0;
                                                foreach($productallsizes as $size)
                                                {
                                                //if($sizecount % 6 == 0 && $sizecount > 0)
                                                if(strpos($size['label'],"T") !== false & $sizecount == 0)
                                                {
                                                $sizecount++;
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                }
                                                ?>
                                                <td><div value="<?php echo $size['value']; ?>" size="<?php echo $size['label']; ?>"><?php echo $size['label']; ?></div></td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php if($howdoesitfitblockid != "") { ?>
                                        <table class="fittable">
                                            <tr>
                                                <td>
                                                    <div class="hanger"></div>
                                                </td>
                                                <td class="howdoesitfitlink">
                                                    <div style="position: relative;">
                                                        <a href="javascript:void(0);">How does it fit?</a>
                                                        <div id="howdoesitfitbox">
                                                            <div id="howdoesitfitboxinner">
                                                                <?php echo $this->getLayout()->createBlock('cms/block')->setBlockId($howdoesitfitblockid)->toHtml(); ?>
                                                            </div>
                                                            <img src="<?php echo $this->getSkinUrl('images/catalog/product/close_opaque.png'); ?>" id="closesmlight" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    <?php } ?>
                                    <div class="qty">QTY</div>
                                    <div class="sizeselector">
                                        <select class="qtyselector">
                                            <?php
                                            for($i = 1; $i < 21; $i++)
                                            {
                                                ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="divider"></div>
                                    <table class="smogibucks" <?php if(!$isrewardable) { echo "style='display:none;'"; } ?>>
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
                                                EARN <a href="<?php echo Mage::helper('core/url')->getHomeUrl(); ?>smogi-bucks" target="_blank">SMOGI BUCKS</a><br/>WITH THIS PURCHASE
                                            </td>
                                        </tr>
                                    </table>
                                    <?php /*
                                    <button id="orderitem" title="Add to Cart" class="button cbtn btn-bag"><span><span>Add to Cart</span></span></button>
					                <button style="display: none;" id="preorderitem" title="Preorder" class="button cbtn btn-pre"><span>Preorder<span></span></span> </button>
                                    */ ?>
                                    <div id="orderitem" class="addtobag spbutton" imageurl="<?php echo $this->getSkinUrl('images/catalog/product/add_to_bag_off.png'); ?>" downimageurl="<?php echo $this->getSkinUrl('images/catalog/product/add_to_bag_on.png'); ?>"></div>
                                    <div id="outofstockitem" class="outofstockitem"></div>
                                    <div id="preorderitem" class="preorderitem spbutton" imageurl="<?php echo $this->getSkinUrl('images/catalog/product/pre_order_now_off.png'); ?>" downimageurl="<?php echo $this->getSkinUrl('images/catalog/product/pre_order_now_on.png'); ?>"></div>
                                    <div class="producterrorcontainer">
                                        <div class="errormsg">
                                        </div>
                                        <img id="preorderhelp" src="<?php echo $this->getSkinUrl('images/help.png'); ?>" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div id="preorderinfo">
                            <?php echo Mage::getModel('core/variable')->loadByCode('preorder_message_detail')->getValue('html'); ?>
                            <img class="closeinfo" src="<?php echo $this->getSkinUrl('images/cross_red.png'); ?>" />
                        </div>
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
        <img id="closelightbox" src="<?php echo $this->getSkinUrl('images/catalog/product/close1.png'); ?>" />
    <?php
    }

    //code for dressing

    public function dressingBlockUpdateAction()
    {
        if($this->getRequest()->getParam('dressing') != 'false')
        {

            $dressingroomitems = explode("\n", strip_tags($this->getLayout()->createBlock('cms/block')->setBlockId("Women_Dressing_Room1")->toHtml()));
            $model = Mage::getModel('catalog/product');
            $dressImgPath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wysiwyg/dressingroom/new/";


            ?>

            <?php $html='

    <div id="Dressingroom" desc="Dressing Room" class="pgsection mainshoppingbg" tw-summary="Check out YOGASMOGA&apos; '.'s cool Dressing Room">
        <div class="myheader" style="padding-bottom: 10px;">DRESSING ROOM</div>
        <div class="dressingroomsubheader1">Here is our dressing room; navigate through our tops and bottoms using the arrows on the side.</div>
        <div class="dressingroomsubheader">Please select your body type and browse through<br />our YOGASMOGA collection.</div>
        <div id="drsizechart" class="sizeChart">
            <div id="sizechart" style="left:0">
                <div class="light-conent-box">';?>
            <?php
            $html.= $this->getLayout()->createBlock('cms/block')->setBlockId('size_chart')->toHtml();
            $html.= '</div>';
            $html.= '<img id="closesmlight" src='. $this->getSkinUrl("images/catalog/product/close_opaque.png").' />';
            $html.= '</div>
                                        <a class="size-link" href="javascript:viod(0);">Ally is 5&apos;'.'8". She is wearing<br />size 6 in tops and bottoms.</a>
                                    </div>
                                    <div class="dressingroomoptions">
                                        Body Type&nbsp;&nbsp;
                                        <select id="dressingroomoptions">
                                            <!-- <option selected="selected">Slender</option>
                                            <option>Other Types</option> -->
                                        </select>
                                    </div>
                                    <div id="dressingroomholder" actheight="756">
                                        <div id="dressingroomtop" actheight="305">
                                            <div class="ovl-box"></div>';

            $topCount = 0;
            $botCount = 0;
            for($i = 1; $i < count($dressingroomitems); $i++){
                $detail = explode("|", $dressingroomitems[$i]);
                $product = $model->load(trim($detail[3]));
                if(trim($detail[0]) == "top"){
                    $topCount++;
                }else{
                    $botCount++;
                }
            }
            $k = 0;
            for($i = 1; $i < count($dressingroomitems); $i++){
                $detail = explode("|", $dressingroomitems[$i]);
                $product = $model->load(trim($detail[3]));
                if(trim($detail[0]) == "top"){
                    $k++;

                    $html.=    '<div class="dritem" botpos=" intval(strip_tags($detail[6]))+8; ">
                            <div class="dressing-img">';

                    if($k == 1)
                    {
                        $html.= '<img alt="'.html_entity_decode($product->getName().'" - "'.$detail[7]).'" width="'.trim(strip_tags($detail[4])).'" height="'.trim(strip_tags($detail[5])).'" style="margin-left:-'. intval(strip_tags($detail[4]))/2 . 'px" src="'. $dressImgPath.trim($detail[2]).'" loaded="1" />';

                    }
                    else
                    {

                        $html.= '<img alt="'. html_entity_decode($product->getName().'" - "'.$detail[7]).'" width="'. trim(strip_tags($detail[4])).'" height="'. trim(strip_tags($detail[5])).'" style="margin-left:-'. intval(strip_tags($detail[4]))/2 .'px;" realsrc="'. $dressImgPath.trim($detail[2]).'" src="" loaded="0" onload="drimgloaded(this);" />';

                    }

                    $html.='    </div>
                            <div class="productdetail">
                                <div class="detail-box">
                                    <div class="productcount">
                                        <div class="current">'. $k .'</div>
                                        <div class="totalcountregion">
                                            <div class="totalcount">'. $topCount.'</div>
                                        </div>
                                    </div>
                                    <div class="productname">'. trim($product->getName()) .'</div>
                                    <div class="productdescription">'. trim($product->getShortDescription()).'</div>
                                    <div class="viewdetails spbutton" color="'. trim(strip_tags($detail[7])).'" pid="'. trim(strip_tags($detail[6])).'" imageurl="'. $this->getSkinUrl("images/catalog/product/dressingroom/view_details_off.png") .' " downimageurl=" '. $this->getSkinUrl("images/catalog/product/dressingroom/view_details_on.png") .'">View Details
                                    </div>
                                    <a href="#productgrid" class="grid-link">View All Products ></a>
                                </div>
                            </div>
                        </div>';
                }
            }
            $html.='<a class="prevBtn" href="javascript:void(0);">Prev</a>
                       <a class="nextBtn" href="javascript:void(0);">Next</a>
                    </div>
                    <div id="dressingroomdivider">&nbsp;</div>
                    <div id="dressingroombottom" actheight="450">
                        <div class="ovl-box"></div>';

            $j = 0;
            for($i = 1; $i < count($dressingroomitems); $i++){
                $detail = explode("|", $dressingroomitems[$i]);
                $product = $model->load(trim($detail[3]));
                if(trim($detail[0]) == "bottom"){
                    $j++;

                    $html.= '<div class="dritem">
                     <div class="dressing-img">';

                    if($j == 1)
                    {

                        $html.= '<img alt="'. html_entity_decode($product->getName().'" - "'.$detail[7]).'" width="'. trim(strip_tags($detail[4])).'" height="'. trim(strip_tags($detail[5])).'"  style="margin-left:-'. intval(strip_tags($detail[4]))/2 .'px;" src="'. $dressImgPath.trim($detail[2]).'" loaded="1" />';

                    }
                    else
                    {

                        $html.= '<img alt="'. html_entity_decode($product->getName().'" - "'.$detail[7]).'" width="'. trim(strip_tags($detail[4])).'" height="'. trim(strip_tags($detail[5])).'"  style="margin-left:-'. intval(strip_tags($detail[4]))/2 .'px;" realsrc="'. $dressImgPath.trim($detail[2]) .'" src="" loaded="0" onload="drimgloaded(this);" />';

                    }

                    $html.= '       </div>
                            <div class="productdetail">
                                <div class="productcount">
                                    <div class="current">'. $j.'</div>
                                    <div class="totalcountregion">
                                        <div class="totalcount">'. $botCount.'</div>
                                    </div>
                                </div>
                                <div class="productname">'. trim($product->getName()).'</div>
                                <div class="productdescription">'. trim($product->getShortDescription()).'</div>
                                <div class="viewdetails spbutton" color="'. trim(strip_tags($detail[7])).'" pid="'. trim(strip_tags($detail[6])).'" imageurl="'. $this->getSkinUrl("images/catalog/product/dressingroom/view_details_off.png").' " downimageurl="'. $this->getSkinUrl("images/catalog/product/dressingroom/view_details_on.png") .'">View Details
                                </div>
                                <a href="#productgrid" class="grid-link">View All Products ></a>
                            </div>
                        </div>';
                }
            }
            $html.= '    <a class="prevBtn" href="javascript:void(0);">Prev</a>
                <a class="nextBtn" href="javascript:void(0);">Next</a>
            </div>
            <div class="doverlay">&nbsp;</div>
        </div>
    </div>
    <div style="display:none;">
        <div id="productdetailpopup">
        </div>
    </div>';

        }
        $identifier = 'dressingUpdate';
        Mage::getModel('cms/block')
            ->load($identifier, 'identifier')
            ->setData('content', $html)
            ->save();
// echo $html;
// echo 'saved';
    }


    // report SKU Total sail

    public function inventoryskureportAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {
                $startdate = $this->getRequest()->getParam('startdate');
                $datearr = split("-", $startdate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $startdate = $datearr[2]."-".$datearr[0]."-".$datearr[1];

                $enddate = $this->getRequest()->getParam('enddate');
                $datearr = split("-", $enddate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $enddate = $datearr[2]."-".$datearr[0]."-".$datearr[1]." 23:59:59";





                $output = "<table>" ;
                $output .= "<tr><td style='height:80px;'><img src='http://yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/logo.png' /></td></tr>";
                $productCollection = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter(array(array('attribute'=>'type_id', 'eq'=>'configurable'), array('attribute'=>'status', 'eq' => Mage_Catalog_Model_Product_Status::STATUS_DISABLED)))->setPageSize(20000);
                //$productCollection = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter(array(array('attribute'=>'type_id', 'eq'=>'configurable'), array('attribute'=>'status', 'eq' => '2')));
                //$productCollection = Mage::getResourceModel('catalog/product_collection')->addAttributeToFilter('type_id', array('eq' => 'configurable'));





                $arrAccessories = array();
                for ($i = 1; $i <= $productCollection->getLastPageNumber(); $i++) {
                    if ($productCollection->isLoaded()) {
                        $productCollection->clear();
                        $productCollection->setPage($i);
                        $productCollection->setPageSize(20000);
                    }
                    foreach ($productCollection as $product) {  //echo '<pre>'; print_r($product);die('ttt');
                        $productCats = $product->getCategoryIds();
                        if(array_search(8, $productCats) !== false){
                            array_push($arrAccessories, $product->getId());
                        }
                        else
                            $this->getinventoryskuhtml($product->getId(), $output,$startdate,$enddate);
                    }
                    //echo $i . "\n\n";

                }
                for($ii = 0; $ii < count($arrAccessories); $ii++)
                    $this->getinventoryskuhtml($arrAccessories[$ii], $output,$startdate,$enddate);

//                $output .= "<tr><td colspan='2' style='font-weight:bold;'>LEGEND</td></tr>";
//                $output .= "<tr><td>VALUE</td><td colspan='4'>Product is in stock and the inventory is positive.</td></tr>";
//                $output .= "<tr><td style='color:#fff;background-color:gray;'>VALUE</td><td colspan='4'>Product is out of stock.</td></tr>";
//                $output .= "<tr><td style='color:#fff;background-color:red;'>VALUE</td><td colspan='4'>Product is in stock and is in pre-order state.</td></tr>";
//                $output .= "<tr><td style='color:#fff;background-color:black;'>VALUE</td><td colspan='4'>This combination of color and size is not available and not displayed on the product view page.</td></tr>";
                $output .= "</table>";
                //echo 'test';
                // echo $output;
                $fname = mktime();
                file_put_contents('tempreports/'.$fname.'.xls',$output);
                Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".xls");
            }
        }
    }

    public function getinventoryskuhtml($product, &$output,$startdate,$enddate)
    {


        //echo $product->getId() . "\n\n";
        $_product = Mage::getModel('catalog/product')->load($product);
        $productname = Mage::Helper('catalog/output')->productAttribute($_product, $_product->getName(), 'name');
        $_childproducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);
        $productcolorinfo = array();
        $productsku = array();
        $sizeArray = array();
        $sizeTotal = array();

        $output .= "<tr style='color:#FFFFFF;'>";
        $output .= "<td style='background-color:#003366;'>Name</td><td style='background-color:#003366;'>Color</td><td style='background-color:#003366;'>Size</td><td style='background-color:#003366;'>Sku</td><td style='background-color:#003366;'>Total Sale</td></tr>";

        $totalNetSale=0;
        foreach($_childproducts as $_childproduct)
        {  // echo '<pre>';print_r($_childproduct);die('tttt');
            //echo Mage::Helper('catalog/output')->productAttribute($_childproduct, $_childproduct->getName(), 'name')."         ";


            $temp = $_childproduct->getAttributeText('color');

            if(strpos($temp,"|") !== FALSE)
            {
                $temp = substr($temp, 0, strpos($temp,"|"));
                if(!isset($productcolorinfo[$temp]))
                    $productcolorinfo[$temp] = array();
            }

            if(array_search($_childproduct->getAttributeText('size'), $sizeArray) === false)
            {
                array_push($sizeArray, $_childproduct->getAttributeText('size'));
                $sizeTotal[$_childproduct->getAttributeText('size')] = 0;
            }
            $output .= "<tr ><td style='color:#000;'>".$productname."</td>";
            $output .= "<td >".$temp."</td>";
            $output .= "<td >"."Size ".$_childproduct->getAttributeText('size')."</td>";
            $output .= "<td >".$_childproduct->getSku()."</td>";
            $sku = $_childproduct->getSku();
            //echo "SELECT SUM(base_row_total + base_tax_amount - base_discount_amount - COALESCE(base_amount_refunded, 0) - COALESCE(base_tax_refunded,0) + COALESCE(base_discount_refunded,0)) AS 'total collection'  FROM sales_flat_order_item where sku='".$sku."'";die;
            $write2 = Mage::getSingleton('core/resource')->getConnection('core_read');
            //$result2 = $write2->query("SELECT sum(base_row_total_incl_tax-base_discount_amount) AS 'net_amount' FROM sales_flat_order_item  WHERE product_type = 'configurable' AND sku='".$sku."'");
            $result2 = $write2->query("SELECT SUM(base_row_total + base_tax_amount - base_discount_amount - COALESCE(base_amount_refunded, 0) - COALESCE(base_tax_refunded,0) + COALESCE(base_discount_refunded,0)) AS 'net_amount'  FROM sales_flat_order_item  where created_at >= '".$startdate."' AND created_at <= '".$enddate."'  and sku='".$sku."'");
            $row2 = $result2->fetch();
            //$netAmount = round($row2['net_amount'], 2);
            $netAmount = $row2['net_amount'];
            if($netAmount == '')
            {
                $netAmount = 0;

            }
            $totalNetSale += round($netAmount,2);
            $output .= "<td style='text-align:right;'>".$netAmount."</td></tr>";

        }
        $output .= "<tr><td colspan='4'></td><td style='font-weight:bold;text-align:right;'>".$totalNetSale."</td></tr><tr><td>&nbsp;</td></tr>";

    }

    // smogi inventory report

    public function smogiinventoryAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {
                $output = "<table>";
                $output .= "<tr><td>&nbsp;</td><td style='height:80px;width:250px !important;'><img src='http://yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/logo.png' /></td><td style='vertical-align:middle'>SMOGI INVENTORY REPORT AS OF ".date("dS M,Y")."</td></tr>";
                $output .= "<tr style='color:#FFFFFF;'>";
                $output .= "<td style='background-color:#003366;'>Id</td><td style='background-color:#003366;'>Name</td><td style='background-color:#003366;'>Email</td><td style='background-color:#003366;'>Smogi Bucks</td></tr>";
                $collection = Mage::getModel("customer/customer")->getCollection()->addAttributeToSelect("*");
                $store_id = Mage::app()->getStore()->getId();
                $total_available_points = 0;
                foreach($collection as $customer)
                {
                    $isActive = $customer->getIsActive();
                    if($isActive)
                    {
                        $id = $customer->getId();
                        $name = $customer->getName();
                        $email = $customer->getEmail();
                        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
                            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
                            $available_points = $reward_flat_model->collectPointsCurrent($id, $store_id);

                        }
                        else
                        {
                            $reward_model = Mage::getModel('rewardpoints/stats');
                            $available_points = $reward_model->getPointsCurrent($id, $store_id);
                        }

                        $total_available_points += $available_points;
                        $output .= "<tr><td style='text-align:center;'>".$id."</td><td>".$name."</td><td>".$email."</td><td style='text-align:right;'>".$available_points."</tr>";
                    }
                }


                $output .= "<tr><td colspan='3'></td><td style='font-weight: bold;text-align:right'>".$total_available_points."</td> </tr>";
                $output .= "</table>";


                $fname = date("M_j_Y");
                $fname = "smogi_".$fname;

                $baseDir = Mage::getBaseDir();
                $varDir = $baseDir.DS.'recurringreports'.DS.'smogi'.DS.$fname.'.xls';

                unlink($varDir);
                file_put_contents('recurringreports/smogi/'.$fname.'.xls',$output);

            }
        }
    }

    public function getreportAction()
    {
        if($this->getRequest()->getParam('type'))
        {
            $type = $this->getRequest()->getParam('type');
            $type = strtolower($type);
            if(($type !='inventory')&&($type != 'smogi'))
            {
                echo 'Invalid Report type.';
                return;
            }
            if( $type == 'inventory')
            {

                $date = $this->getRequest()->getParam('date');
                $datearr = split("-", $date);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $monthNum = $datearr[0];
                $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                $monthName= substr($monthName,0,3);
                $fileName = 'inv_'.$monthName.'_'.$datearr[1].'_'.$datearr[2];

                $baseDir = Mage::getBaseDir();
                $varDir = $baseDir.DS.'recurringreports'.DS.'inventory';
                $timeOfImport = $fileName;
                $importReadyDir = $varDir.DS.$timeOfImport.'.xls';
                if(!file_exists($importReadyDir))
                {
                    echo 'File is not exists for this date';
                }
                else
                {
                    Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."recurringreports/inventory/".$fileName.".xls");
                }


            }

            if($type == 'smogi')
            {
                $date = $this->getRequest()->getParam('date');
                $datearr = split("-", $date);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $monthNum = $datearr[0];
                $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                $monthName= substr($monthName,0,3);
                $fileName = 'smogi_'.$monthName.'_'.$datearr[1].'_'.$datearr[2];

                $baseDir = Mage::getBaseDir();
                $varDir = $baseDir.DS.'recurringreports'.DS.'smogi';
                $timeOfImport = $fileName;
                $importReadyDir = $varDir.DS.$timeOfImport.'.xls';
                if(!file_exists($importReadyDir))
                {
                    echo 'File is not exists for this date';
                }
                else
                {
                    Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."recurringreports/smogi/".$fileName.".xls");
                }



            }
        }

    }

    public function createrecurringreportsAction()
    {
        $inventoryUrl = Mage::helper('core/url')->getHomeUrl()."mycatalog/myproduct/inventoryreport/pass/MageHACKER/recurring/true";
        $smogiUrl = Mage::helper('core/url')->getHomeUrl()."mycatalog/myproduct/smogiinventory/pass/MageHACKER/";
        $this->curl_post_async($inventoryUrl);
        $this->curl_post_async($smogiUrl);
    }

    function curl_post_async($url, $params = false)
    {
        $post_string = "";
        if($params)
        {
            foreach ($params as $key => &$val) {
                if (is_array($val)) $val = implode(',', $val);
                $post_params[] = $key.'='.urlencode($val);
            }
            $post_string = implode('&', $post_params);
        }

        $parts=parse_url($url);

        $fp = fsockopen($parts['host'],
            isset($parts['port'])?$parts['port']:80,
            $errno, $errstr, 30);

        $out = "POST ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($post_string)."\r\n";
        $out.= "Connection: Close\r\n\r\n";
        if (isset($post_string)) $out.= $post_string;
        fwrite($fp, $out);
        fclose($fp);
    }

    public function setNamaskarErrorAction()
    {
        Mage::getSingleton('core/session')->setCartNamaskarError($this->getRequest()->getParam('qty'));
        return;
        $result = file_get_contents($this->getRequest()->getParam('url'));
        $result = json_encode($result,true);
        print_r($result);
        if($result['status']=='error')
        {
            Mage::getSingleton('core/session')->setCartNamaskarError('1');
        }
        $result = Array();
        $result['status']='success';
        echo json_encode($result);
    }

    public function aggregateRewardPointsAction()
    {
        $allStores = Mage::app()->getStores();

        $csv[0] = array('Name', 'Email', 'Bucks', 'Valid_Upto');

        foreach ($allStores as $_eachStoreId => $val)
        {
            /*$duration = Mage::getStoreConfig(self::XML_PATH_POINTS_DURATION, $store_id);
            if ($duration){*/
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            //   $days =  $this->getRequest()->getParam('days');

            $date = $this->getRequest()->getParam('date');
            $datearr = split("-", $date);
            //print_r($datearr);
            if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
            {
                echo "Invalid Date";
                return;
            }
            $requireddate = date('Y-m-d',strtotime($datearr[2].'-'.$datearr[0].'-'.$datearr[1]));
            $currentdate =  date('Y-m-d');
            $diff = abs(strtotime($requireddate) - strtotime($currentdate));

            //$years = floor($diff / (365*60*60*24));
            //$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $onedayless = date('Y-m-d', strtotime('-1 day', strtotime($requireddate)));
            $middle = strtotime($onedayless);
            $new_date = date('M j Y', $middle);



            if($days == 0)
            {
                continue;
            }
            $points = Mage::getModel('rewardpoints/stats')
                ->getResourceCollection()
                ->addFinishFilter($days)
                ->addValidPoints($store_id);

            if ($points->getSize()){
                $i=1;
                foreach ($points as $current_point){
                    $html .= "<tr>";
                    $customer_id = $current_point->getCustomerId();
                    $points = $current_point->getNbCredit();
                    if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
                        $points_received = Mage::getModel('rewardpoints/flatstats')->collectPointsCurrent($customer_id, $store_id);
                    } else {
                        $points_received = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id, $store_id);
                    }

                    //2. check if total points >= points available
                    $customer = Mage::getModel('customer/customer')->load($customer_id);
                    $customerName = $customer->getName();
                    $customerEmail = $customer->getEmail();

                    $csv[$i] = array($customerName, $customerEmail, $points, $new_date);
                    if ($points_received >= $points){
                        //3. send notification email
                        /*    $customer = Mage::getModel('customer/customer')->load($customer_id);
                            $customerName = $customer->getName();
                            $customerEmail = $customer->getEmail();
                            $html .= "<td>".$customer_id."</td>"."<td>".$customerName."</td>"."<td>".$customerEmail."</td></tr>";  */
                        //Mage::getModel('rewardpoints/stats')->sendNotification($customer, $store_id, $points, $days);
                        //Mage::log("Email sent to coustomer id:".$customer_id.",Points:".$points,null,"smogiexpireemail.log");
                    }
                    $i++;
                }
            }

        }
        if($customerEmail == '')
        {
            echo 'No Record found for this date';
            return;
        }
        $fname = 'smogi_bucks_expiring_on'.$new_date;


        $baseDir = Mage::getBaseDir();
        $varDir = $baseDir.DS.'tempreports'.DS.$fname.'.csv';

        unlink($varDir);
        $fp = fopen($varDir, 'w');
        foreach ($csv as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        if(!file_exists($varDir))
        {
            echo 'Records are not found for this date';
        }
        else
        {

            Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".csv");
        }
        //file_put_contents('tempreports/expiringbucks/'.$fname.'.xls',$html);

    }
    public function aggregateRewardPoints_dayAction()
    {
        $allStores = Mage::app()->getStores();

        $csv[0] = array('Name', 'Email', 'Bucks', 'Valid_Upto');

        foreach ($allStores as $_eachStoreId => $val)
        {
            /*$duration = Mage::getStoreConfig(self::XML_PATH_POINTS_DURATION, $store_id);
            if ($duration){*/
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            //   $days =  $this->getRequest()->getParam('days');

            $days = $this->getRequest()->getParam('day');
            $new_date = date('Y-m-d');



            if($days == 0)
            {
                continue;
            }
            $points = Mage::getModel('rewardpoints/stats')
                ->getResourceCollection()
                ->addFinishFilter($days)
                ->addValidPoints($store_id);

            if ($points->getSize()){
                $i=1;
                foreach ($points as $current_point){
                    $html .= "<tr>";
                    $customer_id = $current_point->getCustomerId();
                    $points = $current_point->getNbCredit();
                    if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
                        $points_received = Mage::getModel('rewardpoints/flatstats')->collectPointsCurrent($customer_id, $store_id);
                    } else {
                        $points_received = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id, $store_id);
                    }

                    //2. check if total points >= points available
                    $customer = Mage::getModel('customer/customer')->load($customer_id);
                    $customerName = $customer->getName();
                    $customerEmail = $customer->getEmail();

                    $csv[$i] = array($customerName, $customerEmail, $points, $new_date);
                    if ($points_received >= $points){
                        //3. send notification email
                        /*    $customer = Mage::getModel('customer/customer')->load($customer_id);
                            $customerName = $customer->getName();
                            $customerEmail = $customer->getEmail();
                            $html .= "<td>".$customer_id."</td>"."<td>".$customerName."</td>"."<td>".$customerEmail."</td></tr>";  */
                        //Mage::getModel('rewardpoints/stats')->sendNotification($customer, $store_id, $points, $days);
                        //Mage::log("Email sent to coustomer id:".$customer_id.",Points:".$points,null,"smogiexpireemail.log");
                    }
                    $i++;
                }
            }

        }
        if($customerEmail == '')
        {
            echo 'No Record found for this date';
            return;
        }
        $fname = 'smogi_bucks_expiring_on'.$new_date;


        $baseDir = Mage::getBaseDir();
        $varDir = $baseDir.DS.'tempreports'.DS.$fname.'.csv';

        unlink($varDir);
        $fp = fopen($varDir, 'w');
        foreach ($csv as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        if(!file_exists($varDir))
        {
            echo 'Records are not found for this date';
        }
        else
        {

            Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".csv");
        }
        //file_put_contents('tempreports/expiringbucks/'.$fname.'.xls',$html);

    }

    public function getCustomerslistAction()
    {
        $allStores = Mage::app()->getStores();
        $customerlist = array();
        foreach ($allStores as $_eachStoreId => $val)
        {
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            $days = $this->getRequest()->getParam('day');
            $points = Mage::getModel('rewardpoints/stats')
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
                    array_push($customerlist, array($customer_id, $customerEmail, $customerName, $points));
                }
            }
        }
        echo "<pre>";
        print_r($customerlist);
        echo "</pre>";
        //return $customerlist;
    }
    public function smogitestingAction()
    {
        //$rc = new ReflectionClass('Rewardpoints_Model_Stats');
        //print_r($rc->newInstanceArgs('af'));
        //$obj = new Rewardpoints_Model_Stats('abcd');
        //echo $obj->getPointsCurrent(30, 1);
        //die;
        $days = $this->getRequest()->getParam('days');
        Mage::register('smogi_exp_interval',$days );
        echo "Points Available today--->".$points = Mage::getModel('rewardpoints/stats')->getPointsCurrent(30, 1)."<br/>";
        //Mage::register('smogi_exp_interval', 0);
        echo "Points Available after ".$days."days---> ".$points_new = Mage::getModel('rewardpoints/statsnew')->getPointsCurrent(30, 1)."<br/>";
        echo "Expiry Smogi bugs are:-->";
        echo $points-$points_new;

        //echo $points = Mage::getModel('rewardpoints/stats')->getPointsReceived(30, 1);
        //echo $points = Mage::getModel('rewardpoints/stats')->getPointsSpent(30, 1);
        //echo $points = Mage::getModel('rewardpoints/stats')->getPointsReceivedReajustment(30, 1);
        //echo $points = Mage::getModel('rewardpoints/stats')->getRealPointsLost(30, 1);
        //echo $points = Mage::getModel('rewardpoints/stats')->getRealPointsReceivedNoExpiry(30, 1);
        //echo $points = Mage::getModel('rewardpoints/stats')->loadpointsbydate(1, 30,'2014-05-31');
    }
    public  function checkSmogiExpiryAction()
    {
        $customerid = $this->getRequest()->getParam('customerid');
        $balanceon = strtotime($this->getRequest()->getParam('date'));
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        //$readresult=$read->query("SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end ORDER BY date_end");
        $readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end) AS temp ORDER BY date_end");
        $arrEarnedPoints = array();
        while($row = $readresult->fetch())
        {
            array_push($arrEarnedPoints, array("points" => $row['points'], "expiry" => $row['date_end'], "balance" => $row['points']));
        }
        $arrSpentPoints = array();
        $readresult=$read->query("SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 GROUP BY date_start ORDER BY date_start");
        while($row = $readresult->fetch())
        {
            array_push($arrSpentPoints, array("points" => $row['points'], "usedon" => $row['date_start']));
        }
        /*
                foreach($arrEarnedPoints as $key => $value)
                {
                    echo $arrEarnedPoints[$key]['balance'];
                    $arrEarnedPoints[$key]['balance'] = 0;
                    //$temp[$key]['balance'] = 0;
                }*/
        echo "<pre>";
        foreach($arrSpentPoints as $spentinfo)
        {
            echo "processing . . <br/>";
            print_r($spentinfo);
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {
                        echo "temp = ".$temp."<br/>";
                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }
                    print_r($arrEarnedPoints[$key]);
                    if($temp <= 0)
                        break;
                }
            }
            /*
            foreach($arrEarnedPoints as $earninfo)
            {
                $temp = $spentinfo['points'];
                if((strtotime($earninfo['expiry']) > strtotime($spentinfo['usedon'])) && ($earninfo['balance'] > 0))
                {
                    if($earninfo['balance'] > $temp)
                    {
                        $earninfo['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $earninfo['balance'];
                        $earninfo['balance'] = 0;
                    }
                    if($temp <= 0)
                        break;
                }
            }
            */
        }
        $balance = 0;
        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceon)
            {
                //echo "adding to balance = ".$earninfo['expiry'].$earninfo['balance'];
                $balance += $earninfo['balance'];
            }
        }
        echo "balance = ".$balance;
        print_r($arrEarnedPoints);
        print_r($arrSpentPoints);
        echo "</pre>";
        /*
        $points_current = array();
        $points_spent = array();
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("SELECT * FROM rewardpoints_account WHERE customer_id = 30");
        $i=0;$j=0;
        while ($row = $readresult->fetch() )
        {
            //echo "<pre>";print_r($row);die;
            if($row['points_current']>0)
            {
                $points_current[$i]['points'] = $row['points_current'];
                $points_current[$i]['date_start'] = $row['date_start'];
                $points_current[$i]['date_end'] = $row['date_end'];
                $i++;
            }
            if($row['points_spent']>0)
            {
                $points_spent[$j]['points'] = $row['points_spent'];
                $points_spent[$j]['date_start'] = $row['date_start'];
                $j++;
            }

        }
        //echo "<pre>";print_r($points_current);
        //print_r($points_spent);

        foreach($points_spent as $spent)
        {

        }
*/



    }
    public  function smogiCurrentBalanceAction()
    {
        $customerid = $this->getRequest()->getParam('customerid');
        $balanceon = strtotime($this->getRequest()->getParam('date'));
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end) AS temp ORDER BY date_end");
        $arrEarnedPoints = array();
        while($row = $readresult->fetch())
        {
            array_push($arrEarnedPoints, array("points" => $row['points'], "expiry" => $row['date_end'], "balance" => $row['points']));
        }
        $arrSpentPoints = array();
        $readresult=$read->query("SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 GROUP BY date_start ORDER BY date_start");
        while($row = $readresult->fetch())
        {
            array_push($arrSpentPoints, array("points" => $row['points'], "usedon" => $row['date_start']));
        }


        foreach($arrSpentPoints as $spentinfo)
        {
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {

                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }

                    if($temp <= 0)
                        break;
                }
            }

        }
        $balance = 0;
        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceon)
            {
                $balance += $earninfo['balance'];
            }
        }
        echo "balance = ".$balance;

    }
    // set date limit in sql query
    public  function smogiCurrentBalance2Action()
    {
        $customerid = $this->getRequest()->getParam('customerid');
        $date = $this->getRequest()->getParam('date');
        $balanceon = strtotime($this->getRequest()->getParam('date'));
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        //$readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end) AS temp ORDER BY date_end");
        $readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end, date_start FROM rewardpoints_account, sales_flat_order  WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end)   AS temp WHERE temp.date_start < '".$date."' ORDER BY date_end");
        $arrEarnedPoints = array();
        while($row = $readresult->fetch())
        {
            array_push($arrEarnedPoints, array("points" => $row['points'], "expiry" => $row['date_end'], "balance" => $row['points']));
        }
        $arrSpentPoints = array();
        $readresult=$read->query("SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 AND date_start < '".$date."' GROUP BY date_start ORDER BY date_start;");

        while($row = $readresult->fetch())
        {
            array_push($arrSpentPoints, array("points" => $row['points'], "usedon" => $row['date_start']));
        }


        foreach($arrSpentPoints as $spentinfo)
        {
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {

                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }

                    if($temp <= 0)
                        break;
                }
            }

        }
        $balance = 0;
        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceon)
            {
                $balance += $earninfo['balance'];
            }
        }
        echo "balance = ".$balance;

    }
    //set date limit in sql query
    public  function smogiExpiryPoints2Action()
    {
        $customerid = $this->getRequest()->getParam('customerid');
        $balanceon = strtotime($this->getRequest()->getParam('date'));
        $date = $this->getRequest()->getParam('date');
        $daysAfter = $this->getRequest()->getParam('days');
        $newDate = date('Y-m-d',strtotime($this->getRequest()->getParam('date') . "+".$daysAfter." days"));
        $balanceAfterDays = strtotime(date('Y-m-d',strtotime($this->getRequest()->getParam('date') . "+".$daysAfter." days")));

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end, date_start FROM rewardpoints_account, sales_flat_order  WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end)   AS temp WHERE temp.date_start < '".$date."' ORDER BY date_end");
        $arrEarnedPoints = array();
        while($row = $readresult->fetch())
        {
            array_push($arrEarnedPoints, array("points" => $row['points'], "expiry" => $row['date_end'], "balance" => $row['points']));
        }
        $arrSpentPoints = array();
        $readresult=$read->query("SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 AND date_start < '".$date."' GROUP BY date_start ORDER BY date_start;");
        while($row = $readresult->fetch())
        {
            array_push($arrSpentPoints, array("points" => $row['points'], "usedon" => $row['date_start']));
        }


        foreach($arrSpentPoints as $spentinfo)
        {
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {

                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }

                    if($temp <= 0)
                        break;
                }
            }

        }
        $balance = 0;
        $balance2 = 0;

        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceon)
            {
                $balance += $earninfo['balance'];
            }
        }
        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceAfterDays)
            {
                $balance2 += $earninfo['balance'];
            }
        }
        $bucksExpire = $balance - $balance2;
        echo "Balance = ".$balance."<br/>";
        echo "Balance after ".$daysAfter." days = ".$balance2."<br/>";
        echo "Expiry On ".$newDate." = ".$bucksExpire."<br/>";
    }


    public  function smogiExpiryPointsAction()
    {
        $customerid = $this->getRequest()->getParam('customerid');
        $balanceon = strtotime($this->getRequest()->getParam('date'));
        $daysAfter = $this->getRequest()->getParam('days');
        $newDate = date('Y-m-d',strtotime($this->getRequest()->getParam('date') . "+".$daysAfter." days"));
        $balanceAfterDays = strtotime(date('Y-m-d',strtotime($this->getRequest()->getParam('date') . "+".$daysAfter." days")));

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end) AS temp ORDER BY date_end");
        $arrEarnedPoints = array();
        while($row = $readresult->fetch())
        {
            array_push($arrEarnedPoints, array("points" => $row['points'], "expiry" => $row['date_end'], "balance" => $row['points']));
        }
        $arrSpentPoints = array();
        $readresult=$read->query("SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 GROUP BY date_start ORDER BY date_start");
        while($row = $readresult->fetch())
        {
            array_push($arrSpentPoints, array("points" => $row['points'], "usedon" => $row['date_start']));
        }


        foreach($arrSpentPoints as $spentinfo)
        {
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {

                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }

                    if($temp <= 0)
                        break;
                }
            }

        }
        $balance = 0;
        $balance2 = 0;

        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceon)
            {
                $balance += $earninfo['balance'];
            }
        }
        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceAfterDays)
            {
                $balance2 += $earninfo['balance'];
            }
        }
        $bucksExpire = $balance - $balance2;
        echo "Balance = ".$balance."<br/>";
        echo "Balance after ".$daysAfter." days = ".$balance2."<br/>";
        echo "Expiry On ".$newDate." = ".$bucksExpire."<br/>";
    }
    public function getPointsCurrentAction(){

        $customerid = $this->getRequest()->getParam('customerid');
        //$balanceon = strtotime($this->getRequest()->getParam('date'));
        $date = null;
        if($date == null)
            $date = date('Y-m-d');
        //$customerid = $this->getRequest()->getParam('customerid');
        $balanceon = strtotime($date);
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end) AS temp ORDER BY date_end");
        $arrEarnedPoints = array();
        while($row = $readresult->fetch())
        {
            array_push($arrEarnedPoints, array("points" => $row['points'], "expiry" => $row['date_end'], "balance" => $row['points']));
        }
        $arrSpentPoints = array();
        //$readresult=$read->query("SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 GROUP BY date_start ORDER BY date_start");
        $readresult=$read->query("SELECT * FROM (SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_start UNION SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('pending', 'processing', 'complete')  AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_spent > 0 GROUP BY date_start) AS temp ORDER BY date_start ");
        while($row = $readresult->fetch())
        {
            array_push($arrSpentPoints, array("points" => $row['points'], "usedon" => $row['date_start']));
        }

        echo "<pre>";
        foreach($arrSpentPoints as $spentinfo)
        {
            echo "processing . . <br/>";
            print_r($spentinfo);
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {
                        echo "temp = ".$temp."<br/>";
                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }
                    print_r($arrEarnedPoints[$key]);
                    if($temp <= 0)
                        break;
                }
            }
        }

        /*
        foreach($arrSpentPoints as $spentinfo)
        {
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {

                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }

                    if($temp <= 0)
                        break;
                }
            }

        }
        */
        $balance = 0;
        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceon)
            {
                $balance += $earninfo['balance'];
            }
        }

        print_r($arrEarnedPoints);
        print_r($arrSpentPoints);
        echo "</pre>";


        echo "balance = ".$balance;
        return $balance;
        $total = $this->getPointsReceived($customer_id, $store_id) - $this->getPointsSpent($customer_id, $store_id);
        if ($total > 0){
            return $total;
        } else {
            return 0;
        }
    }


    public function getPointsCurrent_newAction($date = null, $arraymode = false){
        $customerid = $this->getRequest()->getParam('customerid');
        if(!$this->getRequest()->getParam('date'))
            $date = null;
        else
            $date = $this->getRequest()->getParam('date');
        echo "<pre>";
        print_r(Mage::getModel('rewardpoints/stats')->getPointsCurrent($customerid, 1, $date, true));
        //   var_dump(Mage::getModel('rewardpoints/stats')->getPointsCurrent($customerid, 1, $date, true));
    }

    public function getPointslogAction()
    {
        $customerid = $this->getRequest()->getParam('customerid');
        $history = Mage::getModel('rewardpoints/stats')->getPointsCurrent_excludelast($customerid,1,null,true);
        echo "<pre>";
        print_r($history);
        echo "</pre>";
    }

    public function changeserverdateAction()
    {
        $date = $this->getRequest()->getParam('date');
        echo "Current date = ".date('Y-m-d')."<br/>";
        if(!checkdate(date('m',strtotime($date)),date('d',strtotime($date)),date('Y',strtotime($date))))
        {
            echo "Invalid date"."<br/>";
            return;
        }
        echo shell_exec('sudo date -s "'.date('d M Y',strtotime($date)).' '.date('H:i:s').'"');
        echo "New date = ".date('Y-m-d');
    }

    public function comparenewoldsmogiAction()
    {
        set_time_limit(0);
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $readConnection = $resource->getConnection('core_write');
        $temp = $readConnection->query("Select entity_id from customer_entity where is_active=1");
        while($row = $temp->fetch())
        {
            $writeConnection->query("Insert into new_old_bucks_comparision values (".$row['entity_id'].", ".Mage::getModel('rewardpoints/stats')->getPointsCurrentdefault($row['entity_id'],1).", ".Mage::getModel('rewardpoints/stats')->getPointsCurrent($row['entity_id'],1).")");
        }
    }
    public function exportsmoginotificationlogAction()
    {
        if($this->getRequest()->getParam('pass'))
        {
            if($this->getRequest()->getParam('pass') == "MageHACKER")
            {
                $startdate = $this->getRequest()->getParam('startdate');
                $datearr = split("-", $startdate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $startdate = $datearr[2]."-".$datearr[0]."-".$datearr[1];

                $enddate = $this->getRequest()->getParam('enddate');
                $datearr = split("-", $enddate);
                //print_r($datearr);
                if(!checkdate($datearr[0], $datearr[1], $datearr[2]))
                {
                    echo "Invalid Date";
                    return;
                }
                $enddate = $datearr[2]."-".$datearr[0]."-".$datearr[1];

                $csv[0] = array('Notified On','Customer Name','Customer Email', '# Smogi Bucks','Expiry Date','Notification Period');
                $read = Mage::getSingleton('core/resource')->getConnection('core_read');
                $readresult=$read->query("SELECT * FROM smogi_notify_log WHERE notify_date >='".$startdate."' AND notify_date <= '".$enddate."' order by notify_date desc ;");
                $i = 1;
                while ($row = $readresult->fetch() ) {
                    //echo '<pre>';print_r($row);die;
                    //$id = $row['id'];
                   // $customer_data = Mage::getModel('customer/customer')->load($id);
                   // $csv[$i] = array($row['notify_date'],$customer_data['firstname'].' '.$customer_data['lastname'],$row['customer_email'],$row['bucks_expiring'],$row['bucks_expiration_date'],$row['notification_period']);
                    $csv[$i] = array($row['notify_date'],$row['customer_name'],$row['customer_email'],$row['bucks_expiring'],$row['bucks_expiration_date'],$row['notification_period']);
                    $i++;
                }
                if($i == 1)
                {
                    echo 'No Record found for this date';
                    return;
                }
                $fname = 'smogi_notify_log'.$startdate.'to'.$enddate;


                $baseDir = Mage::getBaseDir();
                echo $varDir = $baseDir.DS.'tempreports'.DS.$fname.'.csv';

                unlink($varDir);
                $fp = fopen($varDir, 'w');
                foreach ($csv as $fields) {
                    fputcsv($fp, $fields);
                }

                fclose($fp);
                if(!file_exists($varDir))
                {
                    echo 'Records are not found for this date';
                }
                else
                {

                    Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".csv");
                }

            }
        }
    }
    public function testMailNotificationAction()
    {
        $days = $this->getRequest()->getParam('days');
        $dateAfter = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$days.' day'));
        $customerList = Mage::getModel('smogiexpirationnotifier/notify')->getCustomerslist($days);
        $csv = array();

        $csv[0] = array('Customer Id','Customer Email','Customer Name', '# Smogi Bucks','Expiry Date');
        $i = 1;
        foreach($customerList as $customer)
        {
            //echo $customer['customer_id']. " ".$customer['customer_email']." ".$customer['customer_name']." ".$customer['bucks_expiring']."<br/>";
            $csv[$i] = array($customer['customer_id'],$customer['customer_email'],$customer['customer_name'],$customer['bucks_expiring'],$dateAfter);
            $i++;
        }

        $fname = 'smogiExpiryReport_on'.$dateAfter;


        $baseDir = Mage::getBaseDir();
        $varDir = $baseDir.DS.'tempreports'.DS.$fname.'.csv';

        unlink($varDir);
        $fp = fopen($varDir, 'w');
        foreach ($csv as $fields) {
            fputcsv($fp, $fields);
        }

        Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".csv");
       // echo "<pre>";
        //print_r($csv);
        //Mage::getModel('smogiexpirationnotifier/notify')->notifyusers();
        //echo Mage::getModel('rewardpoints/stats')->getPointsCurrent(1,1);
    }
    public function callnotifyusersAction()
    {
        Mage::getModel('smogiexpirationnotifier/notify')->notifyusers();
    }
    
    public function smogibalanceAction()
    {
        set_time_limit(0);
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $readConnection = $resource->getConnection('core_write');
        $temp = $readConnection->query("SELECT entity_id AS 'Id', email AS 'Email', (SELECT CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=ce.entity_id AND attribute_id=5), ' ', (SELECT VALUE FROM customer_entity_varchar WHERE entity_id=ce.entity_id AND attribute_id=7))) AS 'Name'
 FROM customer_entity ce  where ce.is_active=1 ORDER BY ce.entity_id");
        $csv[0] = array('Customer Id','Customer Name','Customer Email', 'Smogi Bucks Balance');
        $i = 1;
        while($row = $temp->fetch())
        {
            $csv[$i] = array($row['Id'], $row['Name'],$row['Email'], Mage::getModel('rewardpoints/stats')->getPointsCurrent($row['Id'],1));
            $i++;
            //$writeConnection->query("Insert into new_old_bucks_comparision values (".$row['entity_id'].", ".Mage::getModel('rewardpoints/stats')->getPointsCurrentdefault($row['entity_id'],1).", ".Mage::getModel('rewardpoints/stats')->getPointsCurrent($row['entity_id'],1).")");
        }
        $fname = mktime();
        $baseDir = Mage::getBaseDir();
        $varDir = $baseDir.DS.'tempreports'.DS.$fname.'.csv';
        $fp = fopen($varDir, 'w');
        foreach ($csv as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
        Mage::app()->getFrontController()->getResponse()->setRedirect(str_replace("/index.php","",Mage::helper('core/url')->getHomeUrl())."tempreports/".$fname.".csv");
    }
    public function checkforsignuppopupAction()
    {
        $response = array(
            "status" => 'error'

        );
        if(!Mage::getSingleton('customer/session')->isLoggedIn()){
            if(Mage::getModel('core/cookie')->get("signup_popup")== null){
                Mage::getModel('core/cookie')->set("signup_popup", true,10 * 365 * 24 * 60 * 60);
                $response['status'] = "success";
                echo json_encode($response);
                return;
            }
            else{
                echo json_encode($response);
                return;
            }
        }else{
            echo json_encode($response);
            return;
        }

    }

    public function registercustomerAction()
    {
        $response = array(
            "status" => 'error',
            "errors" => '',
            "success_message" => ""
        );
        $errors = array();
        $session = Mage::getSingleton('customer/session');
        if ($session->isLoggedIn()) {
            array_push($errors, "Already Logged In");
            $response['errors'] = $errors;
            echo json_encode($response);
            return;
        }
        $session->setEscapeMessages(true); // prevent XSS injection in user input
        if ($this->getRequest()->isPost()) {
            if (!$customer = Mage::registry('current_customer')) {
                $customer = Mage::getModel('customer/customer')->setId(null);
            }

            /* @var $customerForm Mage_Customer_Model_Form */
            $customerForm = Mage::getModel('customer/form');
            $customerForm->setFormCode('customer_account_create')
                ->setEntity($customer);

            $customerData = $customerForm->extractData($this->getRequest());

            if ($this->getRequest()->getParam('is_subscribed', false)) {
                $customer->setIsSubscribed(1);
            }

            /**
             * Initialize customer group id
             */
            $customer->getGroupId();

            if ($this->getRequest()->getPost('create_address')) {
                /* @var $address Mage_Customer_Model_Address */
                $address = Mage::getModel('customer/address');
                /* @var $addressForm Mage_Customer_Model_Form */
                $addressForm = Mage::getModel('customer/form');
                $addressForm->setFormCode('customer_register_address')
                    ->setEntity($address);

                $addressData    = $addressForm->extractData($this->getRequest(), 'address', false);
                $addressErrors  = $addressForm->validateData($addressData);
                if ($addressErrors === true) {
                    $address->setId(null)
                        ->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))
                        ->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));
                    $addressForm->compactData($addressData);
                    $customer->addAddress($address);

                    $addressErrors = $address->validate();
                    if (is_array($addressErrors)) {
                        $errors = array_merge($errors, $addressErrors);
                    }
                } else {
                    $errors = array_merge($errors, $addressErrors);
                }
            }

            try {
                $customerErrors = $customerForm->validateData($customerData);
                if ($customerErrors !== true) {
                    $errors = array_merge($customerErrors, $errors);
                } else {
                    $customerForm->compactData($customerData);
                    $customer->setPassword($this->getRequest()->getPost('password'));
                    $customer->setConfirmation($this->getRequest()->getPost('confirmation'));
                    $customerErrors = $customer->validate();
                    if (is_array($customerErrors)) {
                        $errors = array_merge($customerErrors, $errors);
                    }
                }

                $validationResult = count($errors) == 0;

                if (true === $validationResult) {
                    $customer->save();

                    Mage::dispatchEvent('customer_register_success',
                        array('account_controller' => $this, 'customer' => $customer)
                    );

                    if ($customer->isConfirmationRequired()) {
                        $customer->sendNewAccountEmail(
                            'confirmation',
                            $session->getBeforeAuthUrl(),
                            Mage::app()->getStore()->getId()
                        );
                        $response['success_message'] = 'Account confirmation is required. Please, check your email for the confirmation link. To resend the confirmation email please <a href="'.Mage::helper('customer')->getEmailConfirmationUrl($customer->getEmail()).'">click here</a>.';
                        $response['status'] = "success";
                        echo json_encode($response);
                        //$session->addSuccess($this->__('Account confirmation is required. Please, check your email for the confirmation link. To resend the confirmation email please <a href="%s">click here</a>.', Mage::helper('customer')->getEmailConfirmationUrl($customer->getEmail())));
                        //$this->_redirectSuccess(Mage::getUrl('*/*/index', array('_secure'=>true)));
                        return;
                    } else {
						$storeId = $customer->getSendemailStoreId();
                        $customer->sendNewAccountEmail('registered', '', $storeId);
                        $session->setCustomerAsLoggedIn($customer);
                        $response['success_message'] = "Registered Successfully";
                        $response['status'] = "success";
						
						$write = Mage::getSingleton('core/resource')->getConnection('core_write');
                        $write->query("insert into signup_popup_user values(null,'".$customer->getId()."',now())");
						
                        echo json_encode($response);
                        //$url = $this->_welcomeCustomer($customer);
                        //$this->_redirectSuccess($url);
                        return;
                    }
                } else {
                    $session->setCustomerFormData($this->getRequest()->getPost());
                    if (is_array($errors)) {
                        foreach ($errors as $errorMessage) {
                            $session->addError($errorMessage);
                        }
                    } else {
                        //$session->addError($this->__('Invalid customer data'));
                        array_push($errors, "Invalid customer data.");
                    }
                }
            } catch (Mage_Core_Exception $e) {
                $session->setCustomerFormData($this->getRequest()->getPost());
                if ($e->getCode() === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
                    array_push($errors, "Email Already Exists.");
                } else {
                    array_push($errors, $e->getMessage());
                }
            } catch (Exception $e) {
                array_push($errors, "Cannot save the customer");
            }
        }
        $response['status'] = "error";
        $response['errors'] = $errors;
        echo json_encode($response);
        //$this->_redirectError(Mage::getUrl('*/*/create', array('_secure' => true)));
    }


    
}
?>