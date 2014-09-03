<?php
/**
 * J2T RewardsPoint2
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@j2t-design.com so we can send you a copy immediately.
 *
 * @category   Magento extension
 * @package    RewardsPoint2
 * @copyright  Copyright (c) 2012 J2T DESIGN. (http://www.j2t-design.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Rewardpoints_Model_Adminhtml_Ordercreate extends Mage_Adminhtml_Model_Sales_Order_Create
{
    public function importPostData($data)
    {
        if (isset($data['rewardpoints']['qty'])) {
            if (is_numeric($data['rewardpoints']['qty'])){
                $this->applyPoints($data['rewardpoints']['qty']);
            }
        }
        parent::importPostData($data);
        return $this;
    }
    
    public function applyPoints($points)
    {
		/****Admin Applicable Smogi Bucks ****/
		if($points > 0)
		{
		$creditpointsentered = $points;
		}
		
		$resource = Mage::getSingleton('core/resource');
 		$readConnection = $resource->getConnection('core_read');
		
		$items = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getAllItems(); 
		//$itemstotal = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getTotals(); 
	
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
                                    break;
								}
							}
						$tot = $tot + $itemstotal;
				}
			}
		
		$grandTotal = $tot - $cattotal;	
		
		if ($creditpointsentered > $grandTotal)
		{
		$points = $grandTotal;
		}
		else
		{
		$points = $creditpointsentered; 
		}
		//$points = $creditpointsentered;
		/****Admin Applicable Smogi Bucks ****/
		
	
        //check customer max points
        $user_points = $this->customerPoints();
        $points = ($user_points < $points) ? $user_points : $points;
        if ($points > 0){
            Mage::helper('rewardpoints/event')->setCreditPoints($points);
            $this->getQuote()
                    ->setRewardpointsQuantity($points);
                    //->save();
        } else {
            Mage::getSingleton('rewardpoints/session')->setProductChecked(0);
            Mage::helper('rewardpoints/event')->setCreditPoints(0);
            $this->getQuote()
                    ->setRewardpointsQuantity(NULL)
                    ->setRewardpointsDescription(NULL)
                    ->setBaseRewardpoints(NULL)
                    ->setRewardpoints(NULL);
        }
        
        $this->setRecollect(true);
        
        
        //modify in order to process points
        /*$code = trim((string)$points);
        $this->getQuote()->setCouponCode($points);
        $this->setRecollect(true);*/
        return $this;
    }
    
    protected function customerPoints()
    {
        $quote = $this->getQuote();
        $store_id = $quote->getStoreId();
        if ($quote->getCustomerId()){
            $customerId = $quote->getCustomerId();
        } else {
            return 0;
        }
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_model = Mage::getModel('rewardpoints/flatstats');
            $customer_points = $reward_model->collectPointsCurrent($customerId, $store_id);
        } else {
            $reward_model = Mage::getModel('rewardpoints/stats');
            $customer_points = $reward_model->getPointsCurrent($customerId, $store_id);
        }
        return $customer_points;
    }
}
