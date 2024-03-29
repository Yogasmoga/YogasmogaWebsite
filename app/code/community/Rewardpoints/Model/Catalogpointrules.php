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
 * @copyright  Copyright (c) 2009 J2T DESIGN. (http://www.j2t-design.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Rewardpoints_Model_Catalogpointrules extends Mage_Rule_Model_Rule
{
    const RULE_TYPE_CART  = 1;
    const RULE_TYPE_DATAFLOW   = 2;

    const RULE_ACTION_TYPE_ADD = 1;
    const RULE_ACTION_TYPE_DONTPROCESS = 2;
    const RULE_ACTION_TYPE_MULTIPLY = -1;
    const RULE_ACTION_TYPE_DIVIDE = -2;

    protected $_types;
    protected $_action_types;

    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/catalogpointrules');
        //('rewardpoints/catalogpointrules')->checkRule($to_validate);
        $this->_types = array(
            self::RULE_TYPE_CART     => Mage::helper('rewardpoints')->__('Cart rule'),
            self::RULE_TYPE_DATAFLOW   => Mage::helper('rewardpoints')->__('Import rule'),
        );
        $this->_action_types = array(
            self::RULE_ACTION_TYPE_ADD     => Mage::helper('rewardpoints')->__('Add / remove points'),
            self::RULE_ACTION_TYPE_DONTPROCESS   => Mage::helper('rewardpoints')->__("Don't process points"),
            self::RULE_ACTION_TYPE_MULTIPLY   => Mage::helper('rewardpoints')->__("Multiply By"),
            self::RULE_ACTION_TYPE_DIVIDE   => Mage::helper('rewardpoints')->__("Divide By"),
        );
    }


    public function ruletypesToOptionArray()
    {
        return $this->_toOptionArray($this->_types);
    }

    public function ruletypesToArray()
    {
        return $this->_toArray($this->_types);
    }

    public function ruleActionTypesToOptionArray()
    {
        return $this->_toOptionArray($this->_action_types);
    }

    public function ruleActionTypesToArray()
    {
        return $this->_toArray($this->_action_types);
    }

    protected function _toOptionArray($array)
    {
        $res = array();
        foreach ($array as $value => $label) {
        	$res[] = array('value' => $value, 'label' => $label);
        }
        return $res;
    }

    protected function _toArray($array)
    {
        $res = array();
        foreach ($array as $value => $label) {
            $res[$value] = $label;
        }
        return $res;
    }


    public function getConditionsInstance()
    {
        return Mage::getModel('rewardpoints/catalogpointrule_condition_combine');
    }


    public function checkRule($to_validate)
    {

        $storeId = Mage::app()->getStore($request->getStore())->getId();
        $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();

        $rules = Mage::getModel('rewardpoints/catalogpointrules')->getCollection()->setValidationFilter($websiteId, $customerGroupId, $couponCode);

        //$rules = Mage::getModel('rewardpoints/catalogpointrules')->getCollection();
        foreach($rules as $rule)
        {
            //echo "<br /> RULE ID : {$rule->getRuleId()}<br/>";
            if (!$rule->getStatus()) continue;
            $rule_validate = Mage::getModel('rewardpoints/catalogpointrules')->load($rule->getRuleId());

            if ($rule_validate->validate($to_validate)){
                //regle ok
                //echo "ok";
                Mage::getModel('rewardpoints/subscriptions')->updateSegments($to_validate->getEmail(), $rule);
            } else {
                //regle ko
                //echo "ko";
                Mage::getModel('rewardpoints/subscriptions')->unsubscribe($to_validate->getEmail(), $rule);

            }
        }

    }

    public function getPointrulesByIds($ids)
    {
        $segmentsids = explode(',', $ids);
        $segmentstitles = array();
        foreach ($segmentsids as $segmentid)
        {
            $collection = $this->getCollection();
            $collection->getSelect()
                       ->where('rule_id = ?', $segmentid);
            $row = $collection->getFirstItem();
            $segmentstitles[] = $row->getTitle();
        }
        return implode(',', $segmentstitles);
    }

    public function getSegmentsRule()
    {
        $segments = array();
        $collection = $this->getCollection();
        $collection->getSelect()
                   ->order('title');
        $collection->load();

        foreach ($collection as $key=>$values)
        {
            $segments[]=array('label'=>$values->getTitle() ,'value'=>$values->getRuleId());
        }
        return $segments;
    }
    
    public function getCatalogPointsByCart(){
        $points = 0;
        $_cart_products = Mage::getModel("checkout/cart")->getItems();
        foreach($items as $item) {
            if($item->getProduct()->getId()) {
                //get product et cart quantity
                $product = Mage::getModel("catalog/product")->load($item->getProduct()->getId());
                //JON
                $item_default_points = $this->getItemPoints($item, Mage::app()->getStore()->getId());
                $points = getAllCatalogRulePointsGathered($product, $item_default_points);
                if ($points === false){
                    return false;
                } elseif ($points > 0){
                    $points = $points * $item->getQty();
                }
            }
        }
        return $points;
    }


    public function getAllCatalogRulePointsGathered($product = null, $item_default_points = null)
    {
        $points = $this->getCatalogRulePointsGathered($product, $item_default_points);   
        return $points;
    }

    
    public function getCatalogRulePointsGathered($to_validate, $item_default_points = null)
    {
        $points = 0;
        
        $storeId = Mage::app()->getStore()->getId();
        $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();

        $rules = Mage::getModel('rewardpoints/catalogpointrules')->getCollection()->setValidationFilter($websiteId, $customerGroupId);
        foreach($rules as $rule)
        {
            if (!$rule->getStatus()) continue;
            $rule_validate = Mage::getModel('rewardpoints/catalogpointrules')->load($rule->getRuleId());
            if ($rule_validate->validate($to_validate)){
                
                if ($rule_validate->getActionType() == self::RULE_ACTION_TYPE_DONTPROCESS){
                   return false;
                } else if ($rule_validate->getActionType() == self::RULE_ACTION_TYPE_MULTIPLY){
                    $multiply = ($rule_validate->getPoints() <= 0) ? 1 : $rule_validate->getPoints();
                    $points_temp += $item_default_points * $multiply;
                    $points += ceil($points_temp - $item_default_points);
                } else if ($rule_validate->getActionType() == self::RULE_ACTION_TYPE_DIVIDE){
                    $divide = ($rule_validate->getPoints() <= 0) ? 1 : $rule_validate->getPoints();
                    $points_temp += $item_default_points / $divide;
                    $points += ceil($points_temp - $item_default_points);
                } else {
                    $points += $rule_validate->getPoints();
                }
            } else {
                
            }
        }
        return $points;
    }


    public function validateVarienData(Varien_Object $object)
    {
        if($object->getData('from_date') && $object->getData('to_date')){
            $dateStartUnixTime = strtotime($object->getData('from_date'));
            $dateEndUnixTime   = strtotime($object->getData('to_date'));

            if ($dateEndUnixTime < $dateStartUnixTime) {
                return array(Mage::helper('rule')->__("End Date should be greater than Start Date"));
            }
        }
        return true;
    }

}