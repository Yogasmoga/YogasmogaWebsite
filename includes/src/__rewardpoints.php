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
 * @category   Varien
 * @package    Varien_Data
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Form field renderer
 *
 * @category   Varien
 * @package    Varien_Data
 * @author      Magento Core Team <core@magentocommerce.com>
 */
interface Varien_Data_Form_Element_Renderer_Interface
{
    public function render(Varien_Data_Form_Element_Abstract $element);
}
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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml abstract block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Abstract extends Mage_Core_Block_Template
{

    /**
     * Enter description here...
     *
     * @return string
     */
    protected function _getUrlModelClass()
    {
        return 'adminhtml/url';
    }

}
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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Abstract config form element renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_System_Config_Form_Field
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * Enter description here...
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $element->getElementHtml();
    }

    /**
     * Enter description here...
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $id = $element->getHtmlId();

        $html = '<td class="label"><label for="'.$id.'">'.$element->getLabel().'</label></td>';

        //$isDefault = !$this->getRequest()->getParam('website') && !$this->getRequest()->getParam('store');
        $isMultiple = $element->getExtType()==='multiple';

        // replace [value] with [inherit]
        $namePrefix = preg_replace('#\[value\](\[\])?$#', '', $element->getName());

        $options = $element->getValues();

        $addInheritCheckbox = false;
        if ($element->getCanUseWebsiteValue()) {
            $addInheritCheckbox = true;
            $checkboxLabel = Mage::helper('adminhtml')->__('Use Website');
        }
        elseif ($element->getCanUseDefaultValue()) {
            $addInheritCheckbox = true;
            $checkboxLabel = Mage::helper('adminhtml')->__('Use Default');
        }

        if ($addInheritCheckbox) {
            $inherit = $element->getInherit()==1 ? 'checked="checked"' : '';
            if ($inherit) {
                $element->setDisabled(true);
            }
        }

        if ($element->getTooltip()) {
            $html .= '<td class="value with-tooltip">';
            $html .= $this->_getElementHtml($element);
            $html .= '<div class="field-tooltip"><div>' . $element->getTooltip() . '</div></div>';
        } else {
            $html .= '<td class="value">';
            $html .= $this->_getElementHtml($element);
        };
        if ($element->getComment()) {
            $html.= '<p class="note"><span>'.$element->getComment().'</span></p>';
        }
        $html.= '</td>';

        if ($addInheritCheckbox) {

            $defText = $element->getDefaultValue();
            if ($options) {
                $defTextArr = array();
                foreach ($options as $k=>$v) {
                    if ($isMultiple) {
                        if (is_array($v['value']) && in_array($k, $v['value'])) {
                            $defTextArr[] = $v['label'];
                        }
                    } elseif ($v['value']==$defText) {
                        $defTextArr[] = $v['label'];
                        break;
                    }
                }
                $defText = join(', ', $defTextArr);
            }

            // default value
            $html.= '<td class="use-default">';
            //$html.= '<input id="'.$id.'_inherit" name="'.$namePrefix.'[inherit]" type="checkbox" value="1" class="input-checkbox config-inherit" '.$inherit.' onclick="$(\''.$id.'\').disabled = this.checked">';
            $html.= '<input id="'.$id.'_inherit" name="'.$namePrefix.'[inherit]" type="checkbox" value="1" class="checkbox config-inherit" '.$inherit.' onclick="toggleValueElements(this, Element.previous(this.parentNode))" /> ';
            $html.= '<label for="'.$id.'_inherit" class="inherit" title="'.htmlspecialchars($defText).'">'.$checkboxLabel.'</label>';
            $html.= '</td>';
        }

        $html.= '<td class="scope-label">';
        if ($element->getScope()) {
            $html .= $element->getScopeLabel();
        }
        $html.= '</td>';

        $html.= '<td class="">';
        if ($element->getHint()) {
            $html.= '<div class="hint" >';
            $html.= '<div style="display: none;">' . $element->getHint() . '</div>';
            $html.= '</div>';
        }
        $html.= '</td>';

        return $this->_decorateRowHtml($element, $html);
    }

    /**
     * Decorate field row html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @param string $html
     * @return string
     */
    protected function _decorateRowHtml($element, $html)
    {
        return '<tr id="row_' . $element->getHtmlId() . '">' . $html . '</tr>';
    }
}

/**
 * Magento
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

class Rewardpoints_Block_Config_Export extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $url = $this->getUrl('catalog/product'); 


        $buttonBlock = $this->getLayout()->createBlock('adminhtml/widget_button');

        $params = array(
            'website' => $buttonBlock->getRequest()->getParam('website')
        );

        $data = array(
            'label'     => Mage::helper('rewardpoints')->__('Export CSV'),
            'onclick'   => 'setLocation(\''.$this->getUrl("rewardpoints/adminhtml_config/exportTablepoints", $params) . 'rewardpoints.csv\' )',
            'class'     => '',
        );

        $html = $buttonBlock->setData($data)->toHtml();


        /*$html = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData($data)
                    ->setType('button')
                    ->setClass('scalable')
                    ->setLabel('Run Now !')
                    ->setOnClick("setLocation('$url')")
                    ->toHtml();*/

        return $html;
    }

    /*extends Varien_Data_Form_Element_Abstract
{
    public function getElementHtml()
    {
        $buttonBlock = $this->getForm()->getParent()->getLayout()->createBlock('adminhtml/widget_button');

        $params = array(
            'website' => $buttonBlock->getRequest()->getParam('website')
        );

        $data = array(
            'label'     => Mage::helper('rewardpoints')->__('Export CSV'),*/
        //    'onclick'   => 'setLocation(\''.Mage::helper('j2tsmsgateway')->getUrl("*/*/exportTablerates", $params) . '/tablephones.csv\' )',
        /*    'class'     => '',
        );

        $html = $buttonBlock->setData($data)->toHtml();

        return $html;
    }*/
}

/**
 * Magento
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

class Rewardpoints_Block_Config_Import extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $url = $this->getUrl('catalog/product'); 
        
        $img = '';
        switch ($element->getHtmlId()){
            case 'rewardpoints_design_small_inline_image':
                $img = '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). '/j2t_image_small.png' .'" alt="" width="16" height="16" /> ';
                break;
            case 'rewardpoints_design_big_inline_image':
                $img = '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). '/j2t_image_big.png' .'" alt="" width="16" height="16" /> ';
                break;
            default:
                $img = '';
        }
        
        
        $html = $img.'<input id="'.$element->getHtmlId().'" name="'.$element->getName()
             .'" value="'.$element->getEscapedValue().'" type="file" />'."\n";
        $html.= $this->getAfterElementHtml();
        return $html;
    }
    
}
/**
 * Magento
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

class Rewardpoints_Block_Coupon extends Mage_Checkout_Block_Cart_Abstract
{
    /*public function getCouponCode()
    {
        return $this->getQuote()->getCouponCode();
    }*/
    
    protected $points_current;
    
    public function getIllustrationImage(){
        $img = '';
        if (Mage::getStoreConfig('rewardpoints/design/big_inline_image_show', Mage::app()->getStore()->getId())){
            $img_url = Mage::helper('rewardpoints/data')->getResizedUrl("j2t_image_big.png", 32, 32);
            $img = '<img class="j2t-cart-points-image" style="float:left; padding-right:5px;" src="'.$img_url .'" alt="" width="32" height="32" /> ';
        }
        return $img;
    }

    public function isUsable() {
        $isUsable = false;
        $minimumBalance = $this->getMinimumBalance();
        $currentBalance = $this->getCustomerPoints();
        if($currentBalance >= $minimumBalance) {
            $isUsable = true;
        }
        return $isUsable;
    }

    public function getMinimumBalance() {
        $minimumBalance = Mage::getStoreConfig('rewardpoints/default/min_use', Mage::app()->getStore()->getId());
        return $minimumBalance;
    }

    public function getAutoUse(){
        return Mage::getStoreConfig('rewardpoints/default/auto_use', Mage::app()->getStore()->getId());
    }
    public function useSlider(){
        return Mage::getStoreConfig('rewardpoints/default/step_slide', Mage::app()->getStore()->getId());
    }
    
    public function showOnepageSummary(){
        return Mage::getStoreConfig('rewardpoints/default/onepage_summary', Mage::app()->getStore()->getId());
    }

    public function getPointsOnOrder() {
        return Mage::helper('rewardpoints/data')->getPointsOnOrder();
    }

    public function getCustomerId() {
        return Mage::getModel('customer/session')->getCustomerId();
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
								  $cattotal = $cattotal + $itemstotal;
                                    break;
								}
							}
				}
                $count++;
			}
		
		$grandTotal = $grandTotal - $cattotal;	
		
		if ($creditpointsentered > $grandTotal)
		{
		//Mage::getSingleton('core/session')->setCreditPointsApplied($grandTotal);
		return $grandTotal;
		}
		else
		{
		return $creditpointsentered; 
		}
		
    }

    public function canUseCouponCode(){
        return Mage::getStoreConfig('rewardpoints/default/coupon_codes', Mage::app()->getStore()->getId());
    }

    public function getCustomerPoints() {
        
        if ($this->points_current){
            return $this->points_current;
        }
        
        $customerId = Mage::getModel('customer/session')->getCustomerId();
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

    public function getPointsInfo() {
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        $reward_model = Mage::getModel('rewardpoints/stats');
        $store_id = Mage::app()->getStore()->getId();
        
        $customerPoints = $this->getCustomerPoints();
        //$customerPoints = $reward_model->getPointsCurrent($customerId, $store_id);

        //points required to get 1 €
        $points_money = Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId());
        //step to reach to get discount
        $step = Mage::getStoreConfig('rewardpoints/default/step_value', Mage::app()->getStore()->getId());
        //check if step needs to apply
        $step_apply = Mage::getStoreConfig('rewardpoints/default/step_apply', Mage::app()->getStore()->getId());
        $full_use = Mage::getStoreConfig('rewardpoints/default/full_use', Mage::app()->getStore()->getId());

        $order_details = $this->getQuote()->getSubtotal();
        
        $min_use = Mage::getStoreConfig('rewardpoints/default/min_use', Mage::app()->getStore()->getId());
        

        /*if (Mage::getStoreConfig('rewardpoints/default/process_tax', Mage::app()->getStore()->getId()) == 1){
            $order_details = $this->getQuote()->getSubtotalInclTax();
        }*/
        $order_details = Mage::getModel('rewardpoints/discount')->getCartAmount();
        

        $cart_amount = Mage::helper('rewardpoints/data')->processMathValue($order_details);
        $max_use = min(Mage::helper('rewardpoints/data')->convertMoneyToPoints($cart_amount), $customerPoints);

        return array('min_use' => $min_use, 'customer_points' => $customerPoints, 'points_money' => $points_money, 'step' => $step, 'step_apply' => $step_apply, 'full_use' => $full_use, 'max_use' => $max_use);
    }

    public function pointsToAddOptions($customer_points, $step, $slider = false){
        $toHtml = '';
        $toHtmlArr = array();
        $creditToBeAdded = 0;
        //points required to get 1 €
        $points_money = Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId());
        $max_points_tobe_used = Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId());
        
        $step_multiplier = Mage::getStoreConfig('rewardpoints/default/step_multiplier', Mage::app()->getStore()->getId());
        
        if (Mage::getStoreConfig('rewardpoints/default/process_rate', Mage::app()->getStore()->getId())){
            $order_details = $this->getQuote()->getBaseGrandTotal();
            $cart_amount = Mage::helper('rewardpoints/data')->convertBaseMoneyToPoints($order_details); 
            //$toHtml .= "<option>$cart_amount</option>";
        } else {
            $order_details = $this->getQuote()->getGrandTotal();
            $cart_amount = Mage::helper('rewardpoints/data')->convertMoneyToPoints($order_details);
        }        
        $customer_points_origin = $customer_points;
        
        while ($customer_points > 0){
            
            //$creditToBeAdded += $step;            
            $creditToBeAdded = ($creditToBeAdded > 0 && $step_multiplier > 1) ? ($creditToBeAdded*$step_multiplier) : ($creditToBeAdded+$step);  
            $customer_points-=$step;            
            //$toHtml .= "<option>$cart_amount < $creditToBeAdded</option>";
            
            if ($creditToBeAdded > $customer_points_origin || $cart_amount < $creditToBeAdded || ($max_points_tobe_used != 0 && $max_points_tobe_used < $creditToBeAdded)){
                //$toHtml .= "<option>$cart_amount < $creditToBeAdded</option>";
                break;
            }
            //check if credits always lower than total cart amount
            if ($slider){
                $toHtmlArr[] = $creditToBeAdded;
            } else {
                $toHtml .= '<option value="'. $creditToBeAdded .'">'. $this->__("%d loyalty point(s)",$creditToBeAdded) .'</option>';
            }
        }
        if ($toHtmlArr != array()){
            if (sizeof($toHtmlArr) == 1){
                $toHtmlArr[] = $toHtmlArr[0];
                $toHtmlArr[0] = 0;
            }
            $toHtml = implode(',',$toHtmlArr);
        }
        
        return $toHtml;
    }
    
    public function canShowRemoveLink(){
        $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', Mage::app()->getStore()->getId());
        $remove_link = Mage::getStoreConfig('rewardpoints/default/remove_link', Mage::app()->getStore()->getId());
        if (!$auto_use && $remove_link){
            return true;
        }
        return false;
    }

}
/**
 * Magento
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
class Rewardpoints_Block_Dashboard extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('rewardpoints/dashboard_points.phtml');
    }


    public function getPointsCurrent(){
        $store_id = Mage::app()->getStore()->getId();
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            return $reward_flat_model->collectPointsCurrent($customerId, $store_id)+0;
        }        
        
        $reward_model = Mage::getModel('rewardpoints/stats');
        return $reward_model->getPointsCurrent($customerId, $store_id)+0;
    }

    public function getPointsReceived(){
        $store_id = Mage::app()->getStore()->getId();
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            return $reward_flat_model->collectPointsReceived($customerId, $store_id)+0;
        }
        
        $reward_model = Mage::getModel('rewardpoints/stats');
        
        //return $reward_model->getPointsReceived($customerId, $store_id);
        return $reward_model->getRealPointsReceivedNoExpiry($customerId, $store_id)+0;
    }

    public function getPointsSpent(){
        $store_id = Mage::app()->getStore()->getId();
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            return $reward_flat_model->collectPointsSpent($customerId, $store_id)+0;
        }
        
        $reward_model = Mage::getModel('rewardpoints/stats');
        return $reward_model->getPointsSpent($customerId, $store_id)+0;
    }

    public function getPointsWaitingValidation(){
        $store_id = Mage::app()->getStore()->getId();
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            return $reward_flat_model->collectPointsWaitingValidation($customerId, $store_id)+0;
        }
        
        $reward_model = Mage::getModel('rewardpoints/stats');
        return $reward_model->getPointsWaitingValidation($customerId, $store_id)+0;
    }
    
    public function getPointsLost() {
        $store_id = Mage::app()->getStore()->getId();
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            return $reward_flat_model->collectPointsLost($customerId, $store_id)+0;
        }        
        
        $reward_model = Mage::getModel('rewardpoints/stats');
        return $reward_model->getRealPointsLost($customerId, $store_id)+0;
    }

}
/**
 * Magento
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

class Rewardpoints_Block_J2thead extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        /*if (Mage::getStoreConfig('rewardpoints/registration/referral_addthis', Mage::app()->getStore()->getId()) && Mage::getStoreConfig('rewardpoints/registration/referral_addthis_account', Mage::app()->getStore()->getId()) != ""){
            $block = $this->getLayout()->createBlock('Mage_Core_Block_Text');
            $block->setText('<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username='.Mage::getStoreConfig('rewardpoints/registration/referral_addthis_account', Mage::app()->getStore()->getId()).'"></script>');
            $this->getLayout()->getBlock('head')->append($block);
        }*/

    }

}
/**
 * Magento
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
class Rewardpoints_Block_Points extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('referafriend/points.phtml');
        $points = Mage::getModel('rewardpoints/stats')->getCollection()
            ->addClientFilter(Mage::getSingleton('customer/session')->getCustomer()->getId());
        $this->setPoints($points);
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'rewardpoints.points')
            ->setCollection($this->getPoints());
        $this->setChild('pager', $pager);
        $this->getPoints()->load();

        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }


    public function getTypeOfPoint($_point)
    {
        $order_id = $_point->getOrderId();
        $referral_id = $_point->getRewardpointsReferralId();
        $quote_id = $_point->getQuoteId();
        $description = ($_point->getRewardpointsDescription()) ? ' - '.$_point->getRewardpointsDescription() : '';
        
        $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', Mage::app()->getStore()->getId());

        $toHtml = '';
        if($referral_id){
            $referrer = Mage::getModel('rewardpoints/referral')->load($referral_id);
            $toHtml .= '<div class="j2t-in-title">'.$this->__('Referral points (%s)',$referrer->getRewardpointsReferralEmail()).'</div>';
            $order = Mage::getModel('sales/order')->loadByIncrementId($order_id);
            $toHtml .=  '<div class="j2t-in-txt">'.$this->__('Referral order state: %s',$this->__($order->getData($status_field))).'</div>';
        } elseif ($order_id == Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW){
            $toHtml .= '<div class="j2t-in-title">'.$this->__('Review points').'</div>';
        } elseif ($order_id == Rewardpoints_Model_Stats::TYPE_POINTS_REQUIRED){
            $current_order = Mage::getModel('sales/order')->loadByAttribute('quote_id', $quote_id);
            $points_txt = $this->__('Points used on products for order %s', $current_order->getIncrementId());
            $toHtml .= '<div class="j2t-in-title">'.$points_txt.'</div>';
        } elseif ($order_id == Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY){
            if (isset($points_name[$order_id])){
                $toHtml .= '<div class="j2t-in-title">'.$points_name[$order_id].'</div>';
            } else {
                $toHtml .= '<div class="j2t-in-title">'.$this->__('Birthday points').'</div>';
            }
        }
        elseif ($order_id < 0){
            $points_name = array(Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW => $this->__('Review points'), Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN => $this->__('Store input %s', $description), Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION => $this->__('Registration points'));
            if (isset($points_name[$order_id])){
                $toHtml .= '<div class="j2t-in-title">'.$points_name[$order_id].'</div>';
            } else {
                $toHtml .= '<div class="j2t-in-title">'.$this->__('Gift').'</div>';
            }
            //$toHtml .= '<div class="j2t-in-title">'.$this->__('Gift').'</div>';
        } else {
            $toHtml .= '<div class="j2t-in-title">'.$this->__('Order: %s', $order_id).'</div>';
            $order = Mage::getModel('sales/order')->loadByIncrementId($order_id);
            $toHtml .= '<div class="j2t-in-txt">'.$this->__('Order state: %s',$this->__($order->getData($status_field))).'</div>';
        }

        return $toHtml;
    }

}
/**
 * Magento
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
class Rewardpoints_Block_Productpoints extends Mage_Catalog_Block_Product_Abstract
{
    public function getConfigurableProducts($product){
        $childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null,$product);
    }


    public function getOptions($product)
    {
        $product->getTypeInstance(true)->setStoreFilter($product->getStoreId(), $product);
        $optionCollection = $product->getTypeInstance(true)->getOptionsCollection($product);
        $selectionCollection = $product->getTypeInstance(true)->getSelectionsCollection(
            $product->getTypeInstance(true)->getOptionsIds($product),
            $product
        );
        return $optionCollection->appendSelections($selectionCollection, false, false);
    }


    public function formatOptionPrice($price, $product)
    {
        $priceTax = Mage::helper('tax')->getPrice($product, $price);
        $priceIncTax = Mage::helper('tax')->getPrice($product, $price, true);

        return $priceIncTax;
    }

    public function getJsGrouped($product){
        $config = array();
        
        
        $_associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
        $_hasAssociatedProducts = count($_associatedProducts) > 0;
        if ($_hasAssociatedProducts){
            foreach ($_associatedProducts as $_item){
                $priceValue = Mage::helper('rewardpoints/data')->convertProductMoneyToPoints($_item->getFinalPrice());
                $config[$_item->getId()] = $priceValue;
            }
        }
        
        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            return Mage::helper('core')->jsonEncode($config);
        } else {
            return Zend_Json::encode($config);
        }
    }
    
    public function getJsDownloadable($product)
    {
        $config = array();
        //$coreHelper = Mage::helper('core');
        
        $links = $product->getTypeInstance(true)->getLinks($product);

        foreach ($links as $link) {
            //$config[$link->getId()] = $coreHelper->currency($link->getPrice(), false, false);
            $priceValue = Mage::helper('rewardpoints/data')->convertProductMoneyToPoints(($link->getPrice()));
            $config[$link->getId()] = $priceValue;
        }
        
        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            return Mage::helper('core')->jsonEncode($config);
        } else {
            return Zend_Json::encode($config);
        }
    }
    

    public function getJsOptions($product)
    {
        $config = array();

        foreach ($product->getOptions() as $option) {
            $priceValue = 0;
            if ($option->getGroupByType() == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT) {
                $_tmpPriceValues = array();
                foreach ($option->getValues() as $value) {
                    $tmp_price = Mage::helper('rewardpoints/data')->convertProductMoneyToPoints((Mage::helper('core')->currency($value->getPrice(true), false, false)));
                    $_tmpPriceValues[$value->getId()] = $tmp_price;
                }
                $priceValue = $_tmpPriceValues;
            } else {
                $priceValue = Mage::helper('core')->currency($option->getPrice(true), false, false);
                $priceValue = Mage::helper('rewardpoints/data')->convertProductMoneyToPoints(($priceValue));
            }
            $config[$option->getId()] = $priceValue;
        }

        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            return Mage::helper('core')->jsonEncode($config);
        } else {
            return Zend_Json::encode($config);
        }
    }



    public function getJsBundlePoints($product)
    {
        Mage::app()->getLocale()->getJsPriceFormat();
        $store = Mage::app()->getStore();
        $optionsArray = $this->getOptions($product);
        $selected = array();

        $pts_array = array();

        foreach ($optionsArray as $_option) {
            if (!$_option->getSelections()) {
                continue;
            }
            
            $selectionCount = count($_option->getSelections());

            foreach ($_option->getSelections() as $_selection) {
                $_qty = !($_selection->getSelectionQty()*1)?'1':$_selection->getSelectionQty()*1;
                $price_tmp = $product->getPriceModel()->getSelectionPreFinalPrice($product, $_selection, 1);
                $subprice = $this->formatOptionPrice($price_tmp, $product);

                if (!Mage::helper('rewardpoints/data')->isCustomProductPoints($_selection)){
                    $pts = Mage::helper('rewardpoints/data')->convertProductMoneyToPoints(($subprice));
                } else {
                    $pts = Mage::helper('rewardpoints/data')->getProductPoints($_selection);
                }

                $selection = array (
                    'points' => $pts,
                    'subprice' => $subprice,
                    'optionId' => $_option->getId(),
                );
                $responseObject = new Varien_Object();
                $args = array('response_object'=>$responseObject, 'selection'=>$_selection);
                Mage::dispatchEvent('bundle_product_view_config', $args);
                if (is_array($responseObject->getAdditionalOptions())) {
                    foreach ($responseObject->getAdditionalOptions() as $o=>$v) {
                        $selection[$o] = $v;
                    }
                }

                $pts_array[$_selection->getSelectionId()] = $selection;

                if (($_selection->getIsDefault() || ($selectionCount == 1 && $_option->getRequired())) && $_selection->isSalable()) {
                    $selected[$_option->getId()][] = $_selection->getSelectionId();
                }
            }
            
        }

        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            return Mage::helper('core')->jsonEncode($pts_array);
        } else {
            return Zend_Json::encode($pts_array);
        }

    }



    public function getJsPoints($_product) {
        $attributes = array();
        $attribute_credit = array();

        if ($_product->isConfigurable()){
            $allProducts = $_product->getTypeInstance(true)
                            ->getUsedProducts(null, $_product);
            $allowAttributes = $_product->getTypeInstance(true)
                        ->getConfigurableAttributes($_product);
            
            
            foreach ($allProducts as $product) {
                if ($product->isSaleable()) {
                    $attr_values = array();
                    foreach ($allowAttributes as $attribute) {
                        $productAttribute = $attribute->getProductAttribute();
                        $attributeId = $productAttribute->getId();
                        $attributeValue = $product->getData($productAttribute->getAttributeCode());
                        $attr_values[] = $attributeValue;
                    }
                    $return_val[implode("|",$attr_values)] = Mage::helper('rewardpoints/data')->getProductPoints($product, false, false);
                }
            }
            
            if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                return Mage::helper('core')->jsonEncode($return_val);
            } else {
                return Zend_Json::encode($return_val);
            }
            
            // end of modifications
            
            
            foreach ($allProducts as $product) {
                if ($product->isSaleable()) {
                    foreach ($allowAttributes as $attribute) {
                        $productAttribute = $attribute->getProductAttribute();
                        $attributeId = $productAttribute->getId();
                        $attributeValue = $product->getData($productAttribute->getAttributeCode());
                        
                        if (!isset($options[$productAttribute->getId()])) {
                            $options[$productAttribute->getId()] = array();
                        }

                        if (!isset($options[$productAttribute->getId()][$attributeValue])) {
                            $options[$productAttribute->getId()][$attributeValue] = array();
                        }
                        
                        
                        $attribute_credit[$attributeValue] = Mage::helper('rewardpoints/data')->getProductPoints($product, false, false);
                        
                        $prices = $attribute->getPrices();
                        if (is_array($prices)) {
                            $attr_list = array();
                            foreach ($prices as $value) {
                                if(!isset($options[$attributeId][$value['value_index']])) {
                                    continue;
                                }
                                $price = $value['pricing_value'];
                                $isPercent = $value['is_percent'];
                                if ($isPercent && !empty($price)) {
                                    $price = $_product->getFinalPrice()*$price/100;
                                }
                                
                                if (!isset($attribute_credit[$attributeValue])){
                                    $attribute_credit[$attributeValue] = array();
                                }
                                $attr_list[] = $value['value_index'];
                                
                                //$attribute_credit[$attributeValue][$value['value_index']] = Mage::helper('rewardpoints/data')->getProductPoints($product, false, false);
                                
                                //$attribute_credit[$value['value_index']] = Mage::helper('rewardpoints/data')->convertProductMoneyToPoints(($price + $_product->getFinalPrice()));
                            }
                            //$attribute_credit[$attributeValue][implode('_',$attr_list)] = Mage::helper('rewardpoints/data')->getProductPoints($product, false, false);
                        }
                    }
                }
            }
        }
        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            return Mage::helper('core')->jsonEncode($attribute_credit);
        } else {
            return Zend_Json::encode($attribute_credit);
        }
    }
}
/**
 * Magento
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
class Rewardpoints_Block_Referral extends Mage_Core_Block_Template
{
    public function __construct()
    {   
        parent::__construct();
        $this->setTemplate('rewardpoints/referral.phtml');
        $referred = Mage::getResourceModel('rewardpoints/referral_collection')
            ->addClientFilter(Mage::getSingleton('customer/session')->getCustomer()->getId());
        $this->setReferred($referred);
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'rewardpoints.referral')
            ->setCollection($this->getReferred());
        $this->setChild('pager', $pager);
        $this->getReferred()->load();

        return $this;
        //return parent::_prepareLayout();
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getReferringUrl()
    {
        $userId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        //return $this->getUrl('rewardpoints/index/goReferral')."referrer/$userId";
        return $this->getUrl('rewardpoints/index/goReferral', array("referrer" => $userId));
    }

    public function isPermanentLink()
    {
        $return_val = Mage::getStoreConfig('rewardpoints/registration/referral_permanent', Mage::app()->getStore()->getId());
        return $return_val;
    }

    public function isAddthis()
    {
        if (Mage::getStoreConfig('rewardpoints/registration/referral_addthis', Mage::app()->getStore()->getId())
                && Mage::getStoreConfig('rewardpoints/registration/referral_addthis_account', Mage::app()->getStore()->getId()) != ""){
            return true;
        }
        return false;
    }

    public function getReferrerPoints()
    {
        return Mage::getStoreConfig('rewardpoints/registration/referral_points', Mage::app()->getStore()->getId());
    }

    public function getFriendPoints()
    {
        return Mage::getStoreConfig('rewardpoints/registration/referral_child_points', Mage::app()->getStore()->getId());
    }
}
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
 * @copyright  Copyright (c) 2011 J2T DESIGN. (http://www.j2t-design.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Rewardpoints_Helper_Data extends Mage_Core_Helper_Abstract {
    public function getReferalUrl()
    {
        return $this->_getUrl('rewardpoints/');
    }
    
    
    public function getResizedUrl($imgName,$x,$y=NULL){
        $imgPathFull=Mage::getBaseDir("media").DS.$imgName;
 
        $widht=$x;
        $y?$height=$y:$height=$x;
        $resizeFolder="j2t_resized";
        $imageResizedPath=Mage::getBaseDir("media").DS.$resizeFolder.DS.$imgName;
        
        if (!file_exists($imageResizedPath) && file_exists($imgPathFull)){
            $imageObj = new Varien_Image($imgPathFull);
            $imageObj->constrainOnly(true);
            $imageObj->keepAspectRatio(true);
            $imageObj->keepTransparency(true);
            $imageObj->resize($widht,$height);
            $imageObj->save($imageResizedPath);
        }
        
        //return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$resizeFolder.DS.$imgName;
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$resizeFolder.'/'.$imgName;
    }
    
    
    
    public function getProductPointsText($product, $noCeil = false, $from_list = false){
        $math_method = Mage::getStoreConfig('rewardpoints/default/math_method', Mage::app()->getStore()->getId());
        if ($math_method == 1 || $math_method == 2){
            $noCeil = true;
        }
        
        $points = $this->getProductPoints($product, $noCeil, $from_list);        
        $img = '';
        if ($points){
            if (Mage::getStoreConfig('rewardpoints/design/small_inline_image_show', Mage::app()->getStore()->getId())){
                $img = '<img src="'.$this->getResizedUrl('j2t_image_small.png', 16, 16) .'" alt="" width="16" height="16" /> ';
            }
            
            $return = '<p class="j2t-loyalty-points inline-points">'.$img. Mage::helper('rewardpoints')->__("earn <span id='j2t-pts'>%d</span> smogi bucks with this purchase.", $points) . $this->getEquivalence($points) . '</p>';
            return $return;
        }
        return '<p class="j2t-loyalty-points inline-points" style="display:none;">'.$img. Mage::helper('rewardpoints')->__("earn <span id='j2t-pts'>%d</span> smogi bucks with this purchase.", $points) . $this->getEquivalence($points) . '</p>';
    }
    
    public function getEquivalence($points){
        $equivalence = '';
        if ($points > 0){
            if (Mage::getStoreConfig('rewardpoints/default/point_equivalence', Mage::app()->getStore()->getId())){
                $formattedPrice = Mage::helper('core')->currency($this->convertPointsToMoneyEquivalence(floor($points)), true, false);
                $equivalence = ' '.Mage::helper('rewardpoints')->__("%d points = %s.", $points, $formattedPrice);
            }
        }
        
        return $equivalence;
    }
    
    
    public function processMathBaseValue($amount, $specific_rate = null){
        $math_method = Mage::getStoreConfig('rewardpoints/default/math_method', Mage::app()->getStore()->getId());
        if ($math_method == 1){
            $amount = round($amount);
        } elseif ($math_method == 0) {
            $amount = floor($amount);
        }
        return $amount;
    }
    

    public function processMathValue($amount, $specific_rate = null){
        $math_method = Mage::getStoreConfig('rewardpoints/default/math_method', Mage::app()->getStore()->getId());
        if ($math_method == 1){
            $amount = round($amount);
        } elseif ($math_method == 0) {
            $amount = floor($amount);
        }
        return $this->ratePointCorrection($amount, $specific_rate);
    }

    public function processMathValueCart($amount, $specific_rate = null){
        $math_method = Mage::getStoreConfig('rewardpoints/default/math_method', Mage::app()->getStore()->getId());
        if ($math_method == 1){
            $amount = round($amount);
        } elseif ($math_method == 0) {
            $amount = floor($amount);
        }
        return $amount;
        //return $this->ratePointCorrection($amount, $specific_rate);
    }

    public function ratePointCorrection($points, $rate = null){
        if ($rate == null){
            $baseCurrency = Mage::app()->getBaseCurrencyCode();
            $currentCurrency = Mage::app()->getStore()->getCurrentCurrencyCode();
            $rate = Mage::getModel('directory/currency')->load($baseCurrency)->getRate($currentCurrency);
        }
        if (Mage::getStoreConfig('rewardpoints/default/process_rate', Mage::app()->getStore()->getId())){
            /*if ($rate > 1){
                return $points * $rate;
            } else {*/
                return $points / $rate;
            //}
        } else {
            return $points;
        }
    }

    public function rateMoneyCorrection($money, $rate = null){
        if ($rate == null){
            $baseCurrency = Mage::app()->getBaseCurrencyCode();
            $currentCurrency = Mage::app()->getStore()->getCurrentCurrencyCode();
            $rate = Mage::getModel('directory/currency')->load($baseCurrency)->getRate($currentCurrency);
        }
        
        if (Mage::getStoreConfig('rewardpoints/default/process_rate', Mage::app()->getStore()->getId())){
            /*if ($rate < 1){
                return $money / $rate;
            } else {
                return $money * $rate;
            }*/
                
            return $money * $rate;
        } else {
            return $money;
        }
        
    }

    public function isCustomProductPoints($product){
        $product_default_points = $this->getDefaultProductPoints($product, Mage::app()->getStore()->getId());
        $catalog_points = Mage::getModel('rewardpoints/catalogpointrules')->getAllCatalogRulePointsGathered($product, $product_default_points);
        if ($catalog_points === false){
            return true;
        }
        $attribute_restriction = Mage::getStoreConfig('rewardpoints/default/process_restriction', Mage::app()->getStore()->getId());
        $product_points = $product->getData('reward_points');
        if ($product_points > 0){
            return true;
        }
        return false;
    }
    

    public function getProductPoints($product, $noCeil = false, $from_list = false){
        if ($from_list){
            $product = Mage::getModel('catalog/product')->load($product->getId());            
        }
        
        $product_default_points = $this->getDefaultProductPoints($product, Mage::app()->getStore()->getId());
        $catalog_points = Mage::getModel('rewardpoints/catalogpointrules')->getAllCatalogRulePointsGathered($product, $product_default_points);
        
        if ($catalog_points === false){
            return 0;
        }
        
        $attribute_restriction = Mage::getStoreConfig('rewardpoints/default/process_restriction', Mage::app()->getStore()->getId());
        $product_points = $product->getRewardPoints();
        $points_tobeused = 0;
        
        if ($product_points > 0){
            $points_tobeused = $product_points + (int)$catalog_points;
            if (Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId())){
                if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId()) < $points_tobeused){
                    return Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId());
                }
            }
            return ($points_tobeused);
        } else if (!$attribute_restriction) {
            //get product price include vat
            $_finalPriceInclTax = Mage::helper('tax')->getPrice($product, $product->getFinalPrice(), true);
            $_weeeTaxAmount = Mage::helper('weee')->getAmount($product);
            
            // fix for amount issue
            if (Mage::getStoreConfig('rewardpoints/default/exclude_tax', Mage::app()->getStore()->getId())){
                $price = Mage::helper('tax')->getPrice($product, $product->getFinalPrice(), false);
            } else {
                $price = $_finalPriceInclTax+$_weeeTaxAmount;
            }
            $price = ceil($price);
            $money_to_points = Mage::getStoreConfig('rewardpoints/default/money_points', Mage::app()->getStore()->getId());
            if ($money_to_points > 0){
                $price = $price * $money_to_points;
                $points_tobeused = $this->processMathValue($price + (int)$catalog_points);
            } else {
                $points_tobeused += (int)$catalog_points;
            }
            if (Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId())){
                if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId()) < $points_tobeused){
                    return Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId());
                }
            }
            if ($noCeil)
                return $points_tobeused;
            else {
                return ceil($points_tobeused);
            }

        }
        return 0;
    }

    public function convertMoneyToPoints($money){
        $points_to_get_money = Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId());
        $money_amount = $this->processMathValue($money*$points_to_get_money);
        
        return $this->rateMoneyCorrection($money_amount);
        //return $money_amount;
    }
    
    
    public function convertBaseMoneyToPoints($money){
        $points_to_get_money = Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId());
        $money_amount = $this->processMathBaseValue($money*$points_to_get_money);
        
        return $money_amount;
    }


    public function convertProductMoneyToPoints($money){
        $points_to_get_money = Mage::getStoreConfig('rewardpoints/default/money_points', Mage::app()->getStore()->getId());
        $money_amount = $this->processMathValue($money*$points_to_get_money);
        return $this->rateMoneyCorrection($money_amount);
        //return $money_amount;
    }
    
    public function convertPointsToMoneyEquivalence($points_to_be_used){
        $points_to_get_money = Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId());
        $return_value = $this->processMathValueCart($points_to_be_used/$points_to_get_money);
        return $return_value;
    }
    

    public function convertPointsToMoney($points_to_be_used, $customer_id = null){
        if ($customer_id != null){
            $customerId = $customer_id;
        } else {
            $customerId = Mage::getModel('customer/session')
                                        ->getCustomerId();
        }
        
        $reward_model = Mage::getModel('rewardpoints/stats');
        $current = $reward_model->getPointsCurrent($customerId, Mage::app()->getStore()->getId());
        
        
        //echo "$current < $points_to_be_used";
        //die;
        if ($current < $points_to_be_used) {
            Mage::getSingleton('checkout/session')->addError(Mage::helper('rewardpoints')->__('Not enough points available.'));
            Mage::helper('rewardpoints/event')->setCreditPoints(0);
            Mage::helper('checkout/cart')->getCart()->getQuote()
                ->setRewardpointsQuantity(NULL)
                ->setRewardpointsDescription(NULL)
                ->setBaseRewardpoints(NULL)
                ->setRewardpoints(NULL)
                ->save();
            return 0;
        }
        $step = Mage::getStoreConfig('rewardpoints/default/step_value', Mage::app()->getStore()->getId());
        $step_apply = Mage::getStoreConfig('rewardpoints/default/step_apply', Mage::app()->getStore()->getId());
        if ($step > $points_to_be_used && $step_apply){
            Mage::getSingleton('checkout/session')->addError(Mage::helper('rewardpoints')->__('The minimum required points is not reached.'));
            Mage::helper('rewardpoints/event')->setCreditPoints(0);
            Mage::helper('checkout/cart')->getCart()->getQuote()
                ->setRewardpointsQuantity(NULL)
                ->setRewardpointsDescription(NULL)
                ->setBaseRewardpoints(NULL)
                ->setRewardpoints(NULL)
                ->save();
            return 0;
        }

        
        if ($step_apply){
            if (($points_to_be_used % $step) != 0){
                Mage::getSingleton('checkout/session')->addError(Mage::helper('rewardpoints')->__('Amount of points wrongly used.'));
                Mage::helper('rewardpoints/event')->setCreditPoints(0);
                Mage::helper('checkout/cart')->getCart()->getQuote()
                    ->setRewardpointsQuantity(NULL)
                    ->setRewardpointsDescription(NULL)
                    ->setBaseRewardpoints(NULL)
                    ->setRewardpoints(NULL)
                    ->save();
                return 0;
            }
        }

        $points_to_get_money = Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId());
        $discount_amount = $this->processMathValueCart($points_to_be_used/$points_to_get_money);

        //return $this->ratePointCorrection($discount_amount);
        return $discount_amount;
    }

    public function getPointsOnOrder($cartLoaded = null, $cartQuote = null, $specific_rate = null, $exclude_rules = false, $storeId = false){
		
		$coupon_code = Mage::getSingleton('checkout/session')->getQuote()->getCouponCode();
		$bucksused = Mage::helper('rewardpoints/event')->getCreditPoints();
		//$gcard = Mage::getSingleton('giftcards/session')->getActive();
		$gcard = (Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()));
		
		if(!($coupon_code  || $bucksused || $gcard))
		//if (! in_array(11, $catid)) 
		{		
		$rewardPoints = 0;
        $rewardPointsAtt = 0;

        if (!$storeId){
            $storeId = Mage::app()->getStore()->getId();
        }
        
        //get points cart rule
        if (!$exclude_rules){
            if ($cartLoaded != null){
                $points_rules = Mage::getModel('rewardpoints/pointrules')->getAllRulePointsGathered($cartLoaded);
            } else {
                $points_rules = Mage::getModel('rewardpoints/pointrules')->getAllRulePointsGathered();
            }
            if ($points_rules === false){
                return 0;
            }
            $rewardPoints += $this->processMathBaseValue($points_rules);//(int)$points_rules;
        }
        
        
        if ($cartLoaded == null){
            $cartHelper = Mage::helper('checkout/cart');
            $items = $cartHelper->getCart()->getItems();
        } elseif ($cartQuote != null){
            $items = $cartQuote->getAllItems();
        }else {
            $items = $cartLoaded->getAllItems();
        }

        $attribute_restriction = Mage::getStoreConfig('rewardpoints/default/process_restriction', $storeId);

        foreach ($items as $_item){
            $item_default_points = $this->getItemPoints($_item, $storeId);
            if ($_item->getHasChildren()){                
                $child_points = Mage::getModel('rewardpoints/catalogpointrules')->getAllCatalogRulePointsGathered($_item->getProduct(), $item_default_points);
                if ($child_points === false){
                    continue;
                } else if(!$attribute_restriction) {
                    //JON COMMENT
                    /*if ($cartLoaded == null || $cartQuote != null){
                        $item_qty = $_item->getQty();
                    } else {
                        $item_qty = $_item->getQtyOrdered();
                    }
                    $bundle_price = $this->getSubtotalInclTax($_item, $storeId);
                    $rewardPoints += $this->processMathBaseValue(Mage::getStoreConfig('rewardpoints/default/money_points', $storeId) * $bundle_price);*/
                    $rewardPoints += $item_default_points;
                }
                
                continue;
            }
            
            /*if ($_item->getHasChildren() && ($_item->getProduct()->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE || $_item->getProduct()->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE)) {
                continue;
            }*/
            
            if ($_item->getParentItemId()) {
                if ($cartLoaded == null || $cartQuote != null){
                    $item_qty = $_item->getParentItem()->getQty();
                } else {
                    $item_qty = $_item->getParentItem()->getQtyOrdered();
                }
            } else {
                if ($cartLoaded == null || $cartQuote != null){
                    $item_qty = $_item->getQty();
                } else {
                    $item_qty = $_item->getQtyOrdered();
                }
            }
            
            $_product = Mage::getModel('catalog/product')->load($_item->getProductId());
            $catalog_points = Mage::getModel('rewardpoints/catalogpointrules')->getAllCatalogRulePointsGathered($_product, $item_default_points);
            if ($catalog_points === false){
                continue;
            } else if(!$attribute_restriction) {
                $rewardPoints += $this->processMathBaseValue($catalog_points * $item_qty);
            }
            $product_points = $_product->getData('reward_points');
            
            if ($product_points > 0){
                if ($_item->getQty() > 0 || $_item->getQtyOrdered() > 0){
                    $rewardPointsAtt += $this->processMathBaseValue($product_points * $item_qty);
                }
            } else if(!$attribute_restriction) {
                //check if product is option product (bundle product)
                if (!$_item->getParentItemId()) {
                    //v.2.0.0 exclude_tax
                    //JON
                    /*if (Mage::getStoreConfig('rewardpoints/default/exclude_tax', $storeId)){
                        $tax_amount = 0;
                    } else {
                        $tax_amount = $_item->getBaseTaxAmount();
                    }
                    $price = $_item->getBaseRowTotal() + $tax_amount - $_item->getBaseDiscountAmount();
                    $rewardPoints += $this->processMathBaseValue(Mage::getStoreConfig('rewardpoints/default/money_points', $storeId) * $price);*/
                    $rewardPoints += $item_default_points;
                } else {
                }
                
            }
        }
        $rewardPoints = $this->processMathBaseValue($this->processMathValue($rewardPoints, $specific_rate) + $rewardPointsAtt);

        if (Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', $storeId)){
            if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', $storeId) < $rewardPoints){
                return ceil(Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', $storeId));
            }
        }
        return ceil($rewardPoints);
		}
		else
		{
		return $rewardPoints = 0;
		}
    }
    
    protected function getDefaultProductPoints($product, $storeId){
        $points = 0;
        $_finalPriceInclTax = Mage::helper('tax')->getPrice($product, $product->getFinalPrice(), true);
        $_weeeTaxAmount = Mage::helper('weee')->getAmount($product);

        if (Mage::getStoreConfig('rewardpoints/default/exclude_tax', Mage::app()->getStore()->getId())){
            $price = Mage::helper('tax')->getPrice($product, $product->getFinalPrice(), false);
        } else {
            $price = $_finalPriceInclTax+$_weeeTaxAmount;
        }
        $points = $this->processMathBaseValue(Mage::getStoreConfig('rewardpoints/default/money_points', $storeId) * $price);
        return $points;
    }
    
    protected function getItemPoints($_item, $storeId){
        $_product = Mage::getModel('catalog/product')->load($_item->getProductId());
        //$points = $_product->getData('reward_points');
        //if ($points > 0){
            $price = $this->getSubtotalInclTax($_item, $storeId);
            $points = $this->processMathBaseValue(Mage::getStoreConfig('rewardpoints/default/money_points', $storeId) * $price);
        //}
        return $points;
    }
    
    
    protected function getSubtotalInclTax($item, $storeId)
    {
        $baseTax = ($item->getTaxBeforeDiscount() ? $item->getTaxBeforeDiscount() : ($item->getTaxAmount() ? $item->getTaxAmount() : 0));
        $tax = ($item->getBaseTaxBeforeDiscount() ? $item->getBaseTaxBeforeDiscount() : ($item->getBaseTaxAmount() ? $item->getBaseTaxAmount() : 0));
        
        if (Mage::getStoreConfig('rewardpoints/default/exclude_tax', $storeId)){
            return $item->getBaseRowTotal();
        }
        return $item->getBaseRowTotal()+$tax;
    }

    //Send email confirmation to earn 50% discount if referal purchase order greater than $200.

    public function getSendEmailWithCouponCode($name,$email, $refName){
        $templateId = "50percent_discount";

        $emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateId);
        $coupon = "YOGASMOGATECHNOLOGY";
        $vars = array(
                    'name' => $name,
                    'coupon'=>$coupon,
                    'referal'=>$refName
                    );
        $storeId = Mage::app()->getStore()->getId();
        $emailTemplate->getProcessedTemplate($vars);
        $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
        $emailTemplate->send($email,$name, $vars);
    }
    
}
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
class Rewardpoints_Helper_Event extends Mage_Core_Helper_Abstract
{
    
    public function setCreditPoints($points_value){
        Mage::getSingleton('rewardpoints/session')->setCreditPoints($points_value);
    }

    public function getCreditPoints($quote = null){
        //return ceil(Mage::getSingleton('rewardpoints/session')->getCreditPoints());
        if ($quote == null){
             $quote = Mage::helper('checkout/cart')->getCart()->getQuote();
        }
        return ceil($quote->getRewardpointsQuantity());
    }
    
    public function removeCreditPoints($quote = null){
        if ($quote == null){
             $quote = Mage::helper('checkout/cart')->getCart()->getQuote();
        }
        $quote->setRewardpointsQuantity(NULL)
                ->setRewardpointsDescription(NULL)
                ->setBaseRewardpoints(NULL)
                ->setRewardpoints(NULL)
                ->save();
    }
}
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
class Rewardpoints_Model_Account extends Mage_Core_Model_Abstract {
            protected $customerId = -1;
            public $storeId = -1;
            protected $pointsCurrent = NULL;
            protected $pointsSpent = NULL;
            protected $rewardpointsAccountId = NULL;
            
            public function saveCheckedOrder($orderId, $customerId, $storeId, $pointsCurrent, $referral = null, $no_check = false){
                $this->customerId = $customerId;
                $this->storeId = $storeId;
                $this->pointsCurrent = $pointsCurrent;
                $this->save($orderId, $no_check, $referral);
            }

            public function save($orderId = null, $no_check = false, $referral = null) {
                if (!$no_check){
                    $reward_model = Mage::getModel('rewardpoints/stats')
                                ->getResourceCollection()
                                ->addCustomerFilter($this->customerId)
                                ->addOrderFilter($orderId)
                                ->addStoreFilter($this->storeId);

                    $data['nb_rewards'] = $reward_model->getSize();
                } else {
                    $data['nb_rewards'] = 0;
                }

                if($data['nb_rewards'] == 0){
                    $reward_model = Mage::getModel('rewardpoints/stats');
                    $fields = array();
                    $fields['customer_id'] = $this->customerId;
                    $fields['store_id'] = $this->storeId;
                    $fields['points_current'] = $this->pointsCurrent;
                    //$fields['points_received'] = $this->pointsReceived;
                    if ($referral != null){
                        $fields['rewardpoints_referral_id'] = $referral;
                    }
                    $fields['points_spent'] = $this->pointsSpent;
                    $fields['order_id'] = $orderId;
                    try {
                        if (is_null($this->rewardpointsAccountId)) {
                            $fields['date_start'] = date('Y-m-d');
                            $extra_days = Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId());
                            if ($extra_days){
                                $fields['date_end'] = date("Y-m-d", mktime(date("H"), date("i"), date("s"), date("n"), date("j") + $extra_days, date("Y")));
                            }
                        }
                        $reward_model->setData($fields);
                        $reward_model->setId($this->rewardpointsAccountId);
                        $reward_model->save();

                    }
                    catch (Exception $e) {
                            $connection->rollBack();
                            throw $e;
                    }
                }

                return $this;
            }

            public function load($id, $field=null) {
                    if ($field === null) {
                            $field = 'customer_id';
                    }
                    $this->customerId = $id;
                    $this->storeId = Mage::app()->getStore()->getId();

                    $reward_model = Mage::getModel('rewardpoints/stats');
                    
                    return $this;
            }

            //add and subtract points methods
            public function addPoints($p) {
                    $this->pointsCurrent += $p;
                    
            }

            public function subtractPoints($p) {
                    $this->pointsSpent = $p;
            }

            /**
             * Setters
             *
             * @param unknown_type $value
             */
            public function setRewardpointsAccountId($value){
                    $this->rewardpointsAccountId = $value;
            }

            public function setCustomerId($value){
                    $this->cutomerId = $value;
            }

            public function setStoreId($value){
                    $this->storeId = $value;
            }

            public function setPointsCurrent($value){
                    $this->pointsCurrent = $value;
            }

            

            public function setPointsSpent($value){
                    $this->pointsSpent = $value;
            }


            /**
             * Getters
             *
             * @return unknown
             */
            public function getPointsCurrent(){

                    $total = $this->getPointsReceived() - $this->getPointsSpent();
                    if ($total > 0){
                            return $total;
                    } else {
                            return 0;
                    }
            }


            

            public function getPointsReceived(){

                    $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
                    $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', Mage::app()->getStore()->getId());
                    
                    $order_states = explode(",", $statuses);
                    //$order_states = array("processing","complete");
                    
                    $connection = Mage::getSingleton('core/resource')
                                                            ->getConnection('rewardpoints_read');

                    
                    $select = $connection->select()->from(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account'),array(new Zend_Db_Expr('SUM('.Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.points_current) AS nb_credit'),new Zend_Db_Expr('SUM('.Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.points_spent)')));
                    if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                        $select->where(" (".Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."' or ".Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'
                                    or ".Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id in (SELECT increment_id
                                       FROM ".Mage::getSingleton('core/resource')->getTableName('sales_order')." AS orders
                                       WHERE orders.".$status_field." IN (?))
                                         ) ", $order_states);
                    } else {
                        $select->where(" (".Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."' or ".Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'
                                    or ".Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id in (SELECT increment_id
                                       FROM ".Mage::getSingleton('core/resource')->getTableName('sales_order')." AS orders
                                       WHERE orders.entity_id IN (
                                           SELECT order_state.entity_id
                                           FROM ".Mage::getSingleton('core/resource')->getTableName('sales_order_varchar')." AS order_state
                                           WHERE order_state.value <> 'canceled'
                                           AND order_state.value in (?))
                                        ) ) ", $order_states);
                    }
                                                            

                    $select->where(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.customer_id=?', $this->customerId);
                    if (Mage::getStoreConfig('rewardpoints/default/store_scope', Mage::app()->getStore()->getId()) == 1){
                        $select->where('find_in_set(?, '.Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.store_id)', Mage::app()->getStore()->getId());
                    }

                    if (Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId())){
                        $select->where('( date_end >= NOW() or date_end IS NULL)');
                    }

                    $select->group(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.customer_id');

                    $data = $connection->fetchRow($select);

                    return $data['nb_credit'];

            }

            public function getPointsWaitingValidation(){

                    $connection = Mage::getSingleton('core/resource')
                                    ->getConnection('rewardpoints_read');
                    $select = $connection->select()
                                ->from(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account'), array('SUM(points_current) AS nb_credit'))
                                ->where(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.customer_id=?', $this->customerId);
                                if (Mage::getStoreConfig('rewardpoints/default/store_scope', Mage::app()->getStore()->getId()) == 1){
                                    $select->where('find_in_set(?, '.Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.store_id)', Mage::app()->getStore()->getId());
                                }
                                //$select->where(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id <> '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."'");
                                //$select->where(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id <> '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'");

                                if (Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId())){
                                    $select->where('( date_end >= NOW() OR date_end IS NULL)');
                                }

                                $select->group(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.customer_id');

                    $data = $connection->fetchRow($select);
                    //return $data['nb_credit'] - $this->getPointsCurrent();
                    return $data['nb_credit'] - $this->getPointsReceived();
            }

            public function getPointsSpent(){
                    $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
                    $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', Mage::app()->getStore()->getId());

                    $order_states = explode(",", $statuses);
                    $order_states[] = 'new';

                    //$order_states = array("processing","complete","new");
                    $orders = Mage::getModel('sales/order')->getCollection()
                        ->addAttributeToSelect('*')
                        ->addAttributeToFilter('customer_id', $this->customerId)
                        ->addAttributeToFilter($status_field, array('in' => $order_states))
                        ->joinAttribute('status', 'order/status', 'entity_id', null, 'left');

                    $orders_array =array();

                    $orders_array[] = "'".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."'";
                    $orders_array[] = "'".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."'";
                    
                    $orders_array[] = "'".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'";
                    $orders_array[] = "'".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."'";


                    foreach ($orders as $order){
                            $orders_array[] = "'".$order->getIncrementId()."'";
                    }

                    $connection = Mage::getSingleton('core/resource')
                                                            ->getConnection('rewardpoints_read');
                    $select = $connection->select()
                            ->from(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account'), array('SUM(points_spent) AS nb_credit'))
                            ->where(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.customer_id=?', $this->customerId)
                            ->where(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').".order_id IN (".implode(',',$orders_array).')');
                            if (Mage::getStoreConfig('rewardpoints/default/store_scope', Mage::app()->getStore()->getId()) == 1){
                                $select->where('find_in_set(?, '.Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.store_id)', Mage::app()->getStore()->getId());
                            }

                            //if (Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId())){
                                //WHERE TO_DAYS(NOW()) - TO_DAYS(date_col) <= 30;
                                //$select->where('( date_end >= NOW() OR date_end IS NULL)');
                                /*$select->where('( (date_start IS NULL AND date_end IS NULL)
                                            OR ( (TO_DAYS(date_end) - TO_DAYS(date_start)) - (TO_DAYS(NOW()) - TO_DAYS(date_start)) ) <= '.Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId()).'
                                            OR (NOW() >= date_start AND date_end IS NULL)
                                                )');*/
                            //}

                    $select->group(Mage::getSingleton('core/resource')->getTableName('rewardpoints_account').'.customer_id');

                    $data = $connection->fetchRow($select);

                    return $data['nb_credit'];

            }
	}
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
 * @package     Mage_Rule
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


interface Mage_Rule_Model_Condition_Interface
{
    
}
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
 * @package     Mage_Rule
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Abstract Rule condition data model
 *
 * @category Mage
 * @package Mage_Rule
 * @author Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Rule_Model_Condition_Abstract
    extends Varien_Object
    implements Mage_Rule_Model_Condition_Interface
{
    /**
     * Defines which operators will be available for this condition
     *
     * @var string
     */
    protected $_inputType = null;

    /**
     * Default values for possible operator options
     * @var array
     */
    protected $_defaultOperatorOptions = null;

    /**
     * Default combinations of operator options, depending on input type
     * @var array
     */
    protected $_defaultOperatorInputByType = null;

    /**
     * List of input types for values which should be array
     * @var array
     */
    protected $_arrayInputTypes = array();

    public function __construct()
    {
        parent::__construct();

        $this->loadAttributeOptions()->loadOperatorOptions()->loadValueOptions();

        if ($options = $this->getAttributeOptions()) {
            foreach ($options as $attr=>$dummy) { $this->setAttribute($attr); break; }
        }
        if ($options = $this->getOperatorOptions()) {
            foreach ($options as $operator=>$dummy) { $this->setOperator($operator); break; }
        }
    }

    /**
     * Default operator input by type map getter
     *
     * @return array
     */
    public function getDefaultOperatorInputByType()
    {
        if (null === $this->_defaultOperatorInputByType) {
            $this->_defaultOperatorInputByType = array(
                'string'      => array('==', '!=', '>=', '>', '<=', '<', '{}', '!{}', '()', '!()'),
                'numeric'     => array('==', '!=', '>=', '>', '<=', '<', '()', '!()'),
                'date'        => array('==', '>=', '<='),
                'select'      => array('==', '!='),
                'boolean'     => array('==', '!='),
                'multiselect' => array('{}', '!{}', '()', '!()'),
                'grid'        => array('()', '!()'),
            );
            $this->_arrayInputTypes = array('multiselect', 'grid');
        }
        return $this->_defaultOperatorInputByType;
    }

    /**
     * Default operator options getter
     * Provides all possible operator options
     *
     * @return array
     */
    public function getDefaultOperatorOptions()
    {
        if (null === $this->_defaultOperatorOptions) {
            $this->_defaultOperatorOptions = array(
                '=='  => Mage::helper('rule')->__('is'),
                '!='  => Mage::helper('rule')->__('is not'),
                '>='  => Mage::helper('rule')->__('equals or greater than'),
                '<='  => Mage::helper('rule')->__('equals or less than'),
                '>'   => Mage::helper('rule')->__('greater than'),
                '<'   => Mage::helper('rule')->__('less than'),
                '{}'  => Mage::helper('rule')->__('contains'),
                '!{}' => Mage::helper('rule')->__('does not contain'),
                '()'  => Mage::helper('rule')->__('is one of'),
                '!()' => Mage::helper('rule')->__('is not one of')
            );
        }
        return $this->_defaultOperatorOptions;
    }

    public function getForm()
    {
        return $this->getRule()->getForm();
    }

    public function asArray(array $arrAttributes = array())
    {
        $out = array(
            'type'=>$this->getType(),
            'attribute'=>$this->getAttribute(),
            'operator'=>$this->getOperator(),
            'value'=>$this->getValue(),
            'is_value_processed'=>$this->getIsValueParsed(),
        );
        return $out;
    }

    public function asXml()
    {
        $xml = "<type>".$this->getType()."</type>"
            ."<attribute>".$this->getAttribute()."</attribute>"
            ."<operator>".$this->getOperator()."</operator>"
            ."<value>".$this->getValue()."</value>";
        return $xml;
    }

    public function loadArray($arr)
    {
        $this->setType($arr['type']);
        $this->setAttribute(isset($arr['attribute']) ? $arr['attribute'] : false);
        $this->setOperator(isset($arr['operator']) ? $arr['operator'] : false);
        $this->setValue(isset($arr['value']) ? $arr['value'] : false);
        $this->setIsValueParsed(isset($arr['is_value_parsed']) ? $arr['is_value_parsed'] : false);

//        $this->loadAttributeOptions();
//        $this->loadOperatorOptions();
//        $this->loadValueOptions();
        return $this;
    }

    public function loadXml($xml)
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml);
        }
        $arr = (array)$xml;
        $this->loadArray($arr);
        return $this;
    }

    public function loadAttributeOptions()
    {
        return $this;
    }

    public function getAttributeOptions()
    {
        return array();
    }

    public function getAttributeSelectOptions()
    {
        $opt = array();
        foreach ($this->getAttributeOption() as $k=>$v) {
            $opt[] = array('value'=>$k, 'label'=>$v);
        }
        return $opt;
    }

    public function getAttributeName()
    {
        return $this->getAttributeOption($this->getAttribute());
    }

    public function loadOperatorOptions()
    {
        $this->setOperatorOption($this->getDefaultOperatorOptions());
        $this->setOperatorByInputType($this->getDefaultOperatorInputByType());
        return $this;
    }

    /**
     * This value will define which operators will be available for this condition.
     *
     * Possible values are: string, numeric, date, select, multiselect, grid, boolean
     *
     * @return string
     */
    public function getInputType()
    {
        if (null === $this->_inputType) {
            return 'string';
        }
        return $this->_inputType;
    }

    public function getOperatorSelectOptions()
    {
        $type = $this->getInputType();
        $opt = array();
        $operatorByType = $this->getOperatorByInputType();
        foreach ($this->getOperatorOption() as $k => $v) {
            if (!$operatorByType || in_array($k, $operatorByType[$type])) {
                $opt[] = array('value' => $k, 'label' => $v);
            }
        }
        return $opt;
    }

    public function getOperatorName()
    {
        return $this->getOperatorOption($this->getOperator());
    }

    public function loadValueOptions()
    {
//        $this->setValueOption(array(
//            true  => Mage::helper('rule')->__('TRUE'),
//            false => Mage::helper('rule')->__('FALSE'),
//        ));
        $this->setValueOption(array());
        return $this;
    }

    public function getValueSelectOptions()
    {
        $valueOption = $opt = array();
        if ($this->hasValueOption()) {
            $valueOption = (array) $this->getValueOption();
        }
        foreach ($valueOption as $k => $v) {
            $opt[] = array('value' => $k, 'label' => $v);
        }
        return $opt;
    }

    /**
     * Retrieve parsed value
     *
     * @return array|string|int|float
     */
    public function getValueParsed()
    {
        if (!$this->hasValueParsed()) {
            $value = $this->getData('value');
            if ($this->isArrayOperatorType() && is_string($value)) {
                $value = preg_split('#\s*[,;]\s*#', $value, null, PREG_SPLIT_NO_EMPTY);
            }
            $this->setValueParsed($value);
        }
        return $this->getData('value_parsed');
    }

    /**
     * Check if value should be array
     *
     * Depends on operator input type
     *
     * @return bool
     */
    public function isArrayOperatorType()
    {
        $op = $this->getOperator();
        return $op === '()' || $op === '!()' || in_array($this->getInputType(), $this->_arrayInputTypes);
    }

    public function getValue()
    {
        if ($this->getInputType()=='date' && !$this->getIsValueParsed()) {
            // date format intentionally hard-coded
            $this->setValue(
                Mage::app()->getLocale()->date($this->getData('value'),
                Varien_Date::DATE_INTERNAL_FORMAT, null, false)->toString(Varien_Date::DATE_INTERNAL_FORMAT)
            );
            $this->setIsValueParsed(true);
        }
        return $this->getData('value');
    }

    public function getValueName()
    {
        $value = $this->getValue();
        if (is_null($value) || '' === $value) {
            return '...';
        }

        $options = $this->getValueSelectOptions();
        $valueArr = array();
        if (!empty($options)) {
            foreach ($options as $o) {
                if (is_array($value)) {
                    if (in_array($o['value'], $value)) {
                        $valueArr[] = $o['label'];
                    }
                } else {
                    if (is_array($o['value'])) {
                        foreach ($o['value'] as $v) {
                            if ($v['value']==$value) {
                                return $v['label'];
                            }
                        }
                    }
                    if ($o['value'] == $value) {
                        return $o['label'];
                    }
                }
            }
        }
        if (!empty($valueArr)) {
            $value = implode(', ', $valueArr);
        }
        return $value;
    }

    /**
     * Get inherited conditions selectors
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        return array(
            array('value'=>'', 'label'=>Mage::helper('rule')->__('Please choose a condition to add...')),
        );
    }

    public function getNewChildName()
    {
        return $this->getAddLinkHtml();
    }

    public function asHtml()
    {
        $html = $this->getTypeElementHtml()
           .$this->getAttributeElementHtml()
           .$this->getOperatorElementHtml()
           .$this->getValueElementHtml()
           .$this->getRemoveLinkHtml()
           .$this->getChooserContainerHtml();
        return $html;
    }

    public function asHtmlRecursive()
    {
        $html = $this->asHtml();
        return $html;
    }

    public function getTypeElement()
    {
        return $this->getForm()->addField($this->getPrefix() . '__' . $this->getId() . '__type', 'hidden', array(
            'name'    => 'rule[' . $this->getPrefix() . '][' . $this->getId() . '][type]',
            'value'   => $this->getType(),
            'no_span' => true,
            'class'   => 'hidden',
        ));
    }

    public function getTypeElementHtml()
    {
        return $this->getTypeElement()->getHtml();
    }

    public function getAttributeElement()
    {
        if (is_null($this->getAttribute())) {
            foreach ($this->getAttributeOption() as $k => $v) {
                $this->setAttribute($k);
                break;
            }
        }
        return $this->getForm()->addField($this->getPrefix().'__'.$this->getId().'__attribute', 'select', array(
            'name'=>'rule['.$this->getPrefix().']['.$this->getId().'][attribute]',
            'values'=>$this->getAttributeSelectOptions(),
            'value'=>$this->getAttribute(),
            'value_name'=>$this->getAttributeName(),
        ))->setRenderer(Mage::getBlockSingleton('rule/editable'));
    }

    public function getAttributeElementHtml()
    {
        return $this->getAttributeElement()->getHtml();
    }

    /**
     * Retrieve Condition Operator element Instance
     * If the operator value is empty - define first available operator value as default
     *
     * @return Varien_Data_Form_Element_Select
     */
    public function getOperatorElement()
    {
        $options = $this->getOperatorSelectOptions();
        if (is_null($this->getOperator())) {
            foreach ($options as $option) {
                $this->setOperator($option['value']);
                break;
            }
        }

        $elementId   = sprintf('%s__%s__operator', $this->getPrefix(), $this->getId());
        $elementName = sprintf('rule[%s][%s][operator]', $this->getPrefix(), $this->getId());
        $element     = $this->getForm()->addField($elementId, 'select', array(
            'name'          => $elementName,
            'values'        => $options,
            'value'         => $this->getOperator(),
            'value_name'    => $this->getOperatorName(),
        ));
        $element->setRenderer(Mage::getBlockSingleton('rule/editable'));

        return $element;
    }

    public function getOperatorElementHtml()
    {
        return $this->getOperatorElement()->getHtml();
    }

    /**
     * Value element type will define renderer for condition value element
     *
     * @see Varien_Data_Form_Element
     * @return string
     */
    public function getValueElementType()
    {
        return 'text';
    }

    public function getValueElementRenderer()
    {
        if (strpos($this->getValueElementType(), '/')!==false) {
            return Mage::getBlockSingleton($this->getValueElementType());
        }
        return Mage::getBlockSingleton('rule/editable');
    }

    public function getValueElement()
    {
        $elementParams = array(
            'name'               => 'rule['.$this->getPrefix().']['.$this->getId().'][value]',
            'value'              => $this->getValue(),
            'values'             => $this->getValueSelectOptions(),
            'value_name'         => $this->getValueName(),
            'after_element_html' => $this->getValueAfterElementHtml(),
            'explicit_apply'     => $this->getExplicitApply(),
        );
        if ($this->getInputType()=='date') {
            // date format intentionally hard-coded
            $elementParams['input_format'] = Varien_Date::DATE_INTERNAL_FORMAT;
            $elementParams['format']       = Varien_Date::DATE_INTERNAL_FORMAT;
        }
        return $this->getForm()->addField($this->getPrefix().'__'.$this->getId().'__value',
            $this->getValueElementType(),
            $elementParams
        )->setRenderer($this->getValueElementRenderer());
    }

    public function getValueElementHtml()
    {
        return $this->getValueElement()->getHtml();
    }

    public function getAddLinkHtml()
    {
        $src = Mage::getDesign()->getSkinUrl('images/rule_component_add.gif');
        $html = '<img src="' . $src . '" class="rule-param-add v-middle" alt="" title="' . Mage::helper('rule')->__('Add') . '"/>';
        return $html;
    }

    public function getRemoveLinkHtml()
    {
        $src = Mage::getDesign()->getSkinUrl('images/rule_component_remove.gif');
        $html = ' <span class="rule-param"><a href="javascript:void(0)" class="rule-param-remove" title="' . Mage::helper('rule')->__('Remove') . '"><img src="' . $src . '"  alt="" class="v-middle" /></a></span>';
        return $html;
    }

    public function getChooserContainerHtml()
    {
        $url = $this->getValueElementChooserUrl();
        $html = '';
        if ($url) {
            $html = '<div class="rule-chooser" url="' . $url . '"></div>';
        }
        return $html;
    }

    public function asString($format = '')
    {
        $str = $this->getAttributeName() . ' ' . $this->getOperatorName() . ' ' . $this->getValueName();
        return $str;
    }

    public function asStringRecursive($level=0)
    {
        $str = str_pad('', $level * 3, ' ', STR_PAD_LEFT) . $this->asString();
        return $str;
    }

    /**
     * Validate product attrbute value for condition
     *
     * @param   mixed $validatedValue product attribute value
     * @return  bool
     */
    public function validateAttribute($validatedValue)
    {
        if (is_object($validatedValue)) {
            return false;
        }

        /**
         * Condition attribute value
         */
        $value = $this->getValueParsed();

        /**
         * Comparison operator
         */
        $op = $this->getOperatorForValidate();

        // if operator requires array and it is not, or on opposite, return false
        if ($this->isArrayOperatorType() xor is_array($value)) {
            return false;
        }

        $result = false;

        switch ($op) {
            case '==': case '!=':
                if (is_array($value)) {
                    if (is_array($validatedValue)) {
                        $result = array_intersect($value, $validatedValue);
                        $result = !empty($result);
                    } else {
                        return false;
                    }
                } else {
                    if (is_array($validatedValue)) {
                        $result = count($validatedValue) == 1 && array_shift($validatedValue) == $value;
                    } else {
                        $result = $this->_compareValues($validatedValue, $value);
                    }
                }
                break;

            case '<=': case '>':
                if (!is_scalar($validatedValue)) {
                    return false;
                } else {
                    $result = $validatedValue <= $value;
                }
                break;

            case '>=': case '<':
                if (!is_scalar($validatedValue)) {
                    return false;
                } else {
                    $result = $validatedValue >= $value;
                }
                break;

            case '{}': case '!{}':
                if (is_scalar($validatedValue) && is_array($value)) {
                    foreach ($value as $item) {
                        if (stripos($validatedValue,$item)!==false) {
                            $result = true;
                            break;
                        }
                    }
                } elseif (is_array($value)) {
                    if (is_array($validatedValue)) {
                        $result = array_intersect($value, $validatedValue);
                        $result = !empty($result);
                    } else {
                        return false;
                    }
                } else {
                    if (is_array($validatedValue)) {
                        $result = in_array($value, $validatedValue);
                    } else {
                        $result = $this->_compareValues($value, $validatedValue, false);
                    }
                }
                break;

            case '()': case '!()':
                if (is_array($validatedValue)) {
                    $result = count(array_intersect($validatedValue, (array)$value))>0;
                } else {
                    $value = (array)$value;
                    foreach ($value as $item) {
                        if ($this->_compareValues($validatedValue, $item)) {
                            $result = true;
                            break;
                        }
                    }
                }
                break;
        }

        if ('!=' == $op || '>' == $op || '<' == $op || '!{}' == $op || '!()' == $op) {
            $result = !$result;
        }

        return $result;
    }

    /**
     * Case and type insensitive comparison of values
     *
     * @param  string|int|float $validatedValue
     * @param  string|int|float $value
     * @return bool
     */
    protected function _compareValues($validatedValue, $value, $strict = true)
    {
        if ($strict && is_numeric($validatedValue) && is_numeric($value)) {
            return $validatedValue == $value;
        } else {
            $validatePattern = preg_quote($validatedValue, '~');
            if ($strict) {
                $validatePattern = '^' . $validatePattern . '$';
            }
            return (bool)preg_match('~' . $validatePattern . '~iu', $value);
        }
    }

    public function validate(Varien_Object $object)
    {
        return $this->validateAttribute($object->getData($this->getAttribute()));
    }

    /**
     * Retrieve operator for php validation
     *
     * @return string
     */
    public function getOperatorForValidate()
    {
        return $this->getOperator();
    }
}
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
 * @package     Mage_Rule
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Mage_Rule_Model_Condition_Combine extends Mage_Rule_Model_Condition_Abstract
{
    /**
     * Store all used condition models
     *
     * @var array
     */
    static protected $_conditionModels = array();





    /**
     * Retrieve new object for each requested model.
     * If model is requested first time, store it at static array.
     *
     * It's made by performance reasons to avoid initialization of same models each time when rules are being processed.
     *
     * @param  string $modelClass
     * @return Mage_Rule_Model_Condition_Abstract|bool
     */
    protected function _getNewConditionModelInstance($modelClass)
    {
        if (empty($modelClass)) {
            return false;
        }

        if (!array_key_exists($modelClass, self::$_conditionModels)) {
            $model = Mage::getModel($modelClass);
            self::$_conditionModels[$modelClass] = $model;
        } else {
            $model = self::$_conditionModels[$modelClass];
        }

        if (!$model) {
            return false;
        }

        $newModel = clone $model;
        return $newModel;
    }

    public function __construct()
    {
        parent::__construct();
        $this->setType('rule/condition_combine')
            ->setAggregator('all')
            ->setValue(true)
            ->setConditions(array())
            ->setActions(array());


        $this->loadAggregatorOptions();
        if ($options = $this->getAggregatorOptions()) {
            foreach ($options as $aggregator=>$dummy) { $this->setAggregator($aggregator); break; }
        }
    }
/* start aggregator methods */
    public function loadAggregatorOptions()
    {
        $this->setAggregatorOption(array(
            'all' => Mage::helper('rule')->__('ALL'),
            'any' => Mage::helper('rule')->__('ANY'),
        ));
        return $this;
    }

    public function getAggregatorSelectOptions()
    {
        $opt = array();
        foreach ($this->getAggregatorOption() as $k=>$v) {
            $opt[] = array('value'=>$k, 'label'=>$v);
        }
        return $opt;
    }

    public function getAggregatorName()
    {
        return $this->getAggregatorOption($this->getAggregator());
    }

    public function getAggregatorElement()
    {
        if (is_null($this->getAggregator())) {
            foreach ($this->getAggregatorOption() as $k=>$v) {
                $this->setAggregator($k);
                break;
            }
        }
        return $this->getForm()->addField($this->getPrefix().'__'.$this->getId().'__aggregator', 'select', array(
            'name'=>'rule['.$this->getPrefix().']['.$this->getId().'][aggregator]',
            'values'=>$this->getAggregatorSelectOptions(),
            'value'=>$this->getAggregator(),
            'value_name'=>$this->getAggregatorName(),
        ))->setRenderer(Mage::getBlockSingleton('rule/editable'));
    }
/* end aggregator methods */

    public function loadValueOptions()
    {
        $this->setValueOption(array(
            1 => Mage::helper('rule')->__('TRUE'),
            0 => Mage::helper('rule')->__('FALSE'),
        ));
        return $this;
    }

    public function addCondition($condition)
    {
        $condition->setRule($this->getRule());
        $condition->setObject($this->getObject());
        $condition->setPrefix($this->getPrefix());

        $conditions = $this->getConditions();
        $conditions[] = $condition;

        if (!$condition->getId()) {
            $condition->setId($this->getId().'--'.sizeof($conditions));
        }

        $this->setData($this->getPrefix(), $conditions);
        return $this;
    }

    public function getValueElementType()
    {
        return 'select';
    }

    /**
     * Returns array containing conditions in the collection
     *
     * Output example:
     * array(
     *   'type'=>'combine',
     *   'operator'=>'ALL',
     *   'value'=>'TRUE',
     *   'conditions'=>array(
     *     {condition::asArray},
     *     {combine::asArray},
     *     {quote_item_combine::asArray}
     *   )
     * )
     *
     * @return array
     */
    public function asArray(array $arrAttributes = array())
    {
        $out = parent::asArray();
        $out['aggregator'] = $this->getAggregator();

        foreach ($this->getConditions() as $condition) {
            $out['conditions'][] = $condition->asArray();
        }

        return $out;
    }

    public function asXml($containerKey='conditions', $itemKey='condition')
    {
        $xml = "<aggregator>".$this->getAggregator()."</aggregator>"
            ."<value>".$this->getValue()."</value>"
            ."<$containerKey>";
        foreach ($this->getConditions() as $condition) {
            $xml .= "<$itemKey>".$condition->asXml()."</$itemKey>";
        }
        $xml .= "</$containerKey>";
        return $xml;
    }

    public function loadArray($arr, $key='conditions')
    {
        $this->setAggregator(isset($arr['aggregator']) ? $arr['aggregator']
                : (isset($arr['attribute']) ? $arr['attribute'] : null))
            ->setValue(isset($arr['value']) ? $arr['value']
                : (isset($arr['operator']) ? $arr['operator'] : null));

        if (!empty($arr[$key]) && is_array($arr[$key])) {
            foreach ($arr[$key] as $condArr) {
                try {
                    $cond = $this->_getNewConditionModelInstance($condArr['type']);
                    if ($cond) {
                        $this->addCondition($cond);
                        $cond->loadArray($condArr, $key);
                    }
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
        }
        return $this;
    }

    public function loadXml($xml)
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml);
        }
        $arr = parent::loadXml($xml);
        foreach ($xml->conditions->children() as $condition) {
            $arr['conditions'] = parent::loadXml($condition);
        }
        $this->loadArray($arr);
        return $this;
    }

    public function asHtml()
    {
           $html = $this->getTypeElement()->getHtml().
               Mage::helper('rule')->__('If %s of these conditions are %s:', $this->getAggregatorElement()->getHtml(), $this->getValueElement()->getHtml());
           if ($this->getId() != '1') {
               $html.= $this->getRemoveLinkHtml();
           }
        return $html;
    }

    public function getNewChildElement()
    {
        return $this->getForm()->addField($this->getPrefix().'__'.$this->getId().'__new_child', 'select', array(
            'name'=>'rule['.$this->getPrefix().']['.$this->getId().'][new_child]',
            'values'=>$this->getNewChildSelectOptions(),
            'value_name'=>$this->getNewChildName(),
        ))->setRenderer(Mage::getBlockSingleton('rule/newchild'));
    }

    public function asHtmlRecursive()
    {
        $html = $this->asHtml().'<ul id="'.$this->getPrefix().'__'.$this->getId().'__children" class="rule-param-children">';
        foreach ($this->getConditions() as $cond) {
            $html .= '<li>'.$cond->asHtmlRecursive().'</li>';
        }
        $html .= '<li>'.$this->getNewChildElement()->getHtml().'</li></ul>';
        return $html;
    }

    public function asString($format='')
    {
        $str = Mage::helper('rule')->__("If %s of these conditions are %s:", $this->getAggregatorName(), $this->getValueName());
        return $str;
    }

    public function asStringRecursive($level=0)
    {
        $str = parent::asStringRecursive($level);
        foreach ($this->getConditions() as $cond) {
            $str .= "\n".$cond->asStringRecursive($level+1);
        }
        return $str;
    }

    public function validate(Varien_Object $object)
    {
        if (!$this->getConditions()) {
            return true;
        }

        $all    = $this->getAggregator() === 'all';
        $true   = (bool)$this->getValue();

        foreach ($this->getConditions() as $cond) {
            $validated = $cond->validate($object);

            if ($all && $validated !== $true) {
                return false;
            } elseif (!$all && $validated === $true) {
                return true;
            }
        }
        return $all ? true : false;
    }

    public function setJsFormObject($form)
    {
        $this->setData('js_form_object', $form);
        foreach ($this->getConditions() as $condition) {
            $condition->setJsFormObject($form);
        }
        return $this;
    }

    /**
     * Get conditions, if current prefix is undefined use 'conditions' key
     *
     * @return array
     */
    public function getConditions()
    {
        $key = $this->getPrefix() ? $this->getPrefix() : 'conditions';
        return $this->getData($key);
    }

    /**
     * Set conditions, if current prefix is undefined use 'conditions' key
     *
     * @param array $conditions
     * @return Mage_Rule_Model_Condition_Combine
     */
    public function setConditions($conditions)
    {
        $key = $this->getPrefix() ? $this->getPrefix() : 'conditions';
        return $this->setData($key, $conditions);
    }

    /**
     * Getter for "Conditions Combination" select option for recursive combines
     */
    protected function _getRecursiveChildSelectOption()
    {
        return array('value' => $this->getType(), 'label' => Mage::helper('rule')->__('Conditions Combination'));
    }
}
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

class Rewardpoints_Model_Catalogpointrule_Condition_Combine extends Mage_Rule_Model_Condition_Combine
{
    public function __construct()
    {
	parent::__construct();
        $this->setType('rewardpoints/catalogpointrule_condition_combine');
    }

    public function getNewChildSelectOptions()
    {
        
        $productCondition = Mage::getModel('catalogrule/rule_condition_product');
        //$productCondition = Mage::getModel('rewardpoints/catalogpointrule_condition_product');
        $productAttributes = $productCondition->loadAttributeOptions()->getAttributeOption();
        $attributes = array();
        foreach ($productAttributes as $code=>$label) {
            $attributes[] = array('value'=>'catalogrule/rule_condition_product|'.$code, 'label'=>$label);
        }
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive($conditions, array(
            array('value'=>'rewardpoints/catalogpointrule_condition_combine', 'label'=>Mage::helper('catalogrule')->__('Conditions Combination')),
            array('label'=>Mage::helper('rewardpoints')->__('Product Attribute'), 'value'=>$attributes),
        ));

        return $conditions;
    }

    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml().
            Mage::helper('rewardpoints')->__("If %s of these order conditions are %s",
              $this->getAggregatorElement()->getHtml(),
			  $this->getValueElement()->getHtml()
           );
           if ($this->getId()!='1') {
               $html.= $this->getRemoveLinkHtml();
           }

        return $html;
    }


    public function collectValidatedAttributes($productCollection)
    {
        foreach ($this->getConditions() as $condition) {
            $condition->collectValidatedAttributes($productCollection);
        }
        return $this;
    }
}
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
class Rewardpoints_Model_Catalogpointrule_Condition_Order_Params extends Mage_Rule_Model_Condition_Abstract
{
    /**
     * Retrieve attribute object
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */
    
    public function __construct()
    {
        parent::__construct();
        $this->setType('rewardpoints/rule_condition_order_params')
            ->setValue(null);
    }

    public function loadAttributeOptions()
    {
	$hlp = Mage::helper('rewardpoints');
        $this->setAttributeOption(array(
            'store'  => $hlp->__('Store'),
            'category' => $hlp->__('Category'),
			'order_status' => $hlp->__('Order status'),
			'sku' => $hlp->__('Contains any of these SKUs'),
        ));
        return $this;
    }

    public function getValueSelectOptions()
    {
		$hlp = Mage::helper('rewardpoints');
		if ($this->getAttribute()=='store')
		{
			$stores = Mage::helper('rewardpoints')->getStoresForRule();
			$stores_options = array();
			foreach ($stores as $key => $store)
				$stores_options[] = array('label' => $store, 'value' => $key);

			$this->setData('value_select_options', $stores);
		}
		if ($this->getAttribute()=='category')
		{
			$categories = Mage::helper('rewardpoints')->getCategoriesArray();

			foreach ($categories as $key => $category)
				$categories[$key]['label'] = str_replace('&nbsp;', '', $category['label']);

			$this->setData('value_select_options', $categories);
		}
		if ($this->getAttribute()=='order_status')
		{
			$this->setData('value_select_options',
				Mage::getSingleton('sales/order_config')->getStatuses());
		}

        return $this->getData('value_select_options');
    }

    public function loadOperatorOptions()
    {
        $this->setOperatorOption(array(
                '=='  => Mage::helper('rewardpoints')->__('is'),
                '!='  => Mage::helper('rewardpoints')->__('is not')
        ));
        return $this;
    }

    public function asHtml()
    {
        if ($this->getAttribute()=='sku')
		{
			$html = $this->getTypeElement()->getHtml().
				Mage::helper('rewardpoints')->__("%s %s",
				   $this->getAttributeElement()->getHtml(),
				   $this->getValueElement()->getHtml()
			   );
			   if ($this->getId()!='1') {
				   $html.= $this->getRemoveLinkHtml();
			   }
			return $html;
		}

		return parent::asHtml();
    }

    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    public function getValueElementType()
    {
        if ($this->getAttribute()=='store'||$this->getAttribute()=='category'||$this->getAttribute()=='order_status') return 'select';
		return 'text';
    }

    public function validate(Varien_Object $object)
    {
        if ($this->getAttribute()=='sku')
        {
            $sku = explode(',',$this->getValue());
            foreach($sku as $skuA)
            {
                foreach($object->getSku() as $skuB)
                {
                    if ($skuA == $skuB) return true;
                }
            }
            return false;
        }

        if ($this->getAttribute()=='category')
                return $this->validateAttribute($object->getCategories());

        return parent::validate($object);
    }
}
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
 * @package     Mage_Rule
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Abstract Rule entity data model
 *
 * @category Mage
 * @package Mage_Rule
 * @author Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Rule_Model_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * Store rule combine conditions model
     *
     * @var Mage_Rule_Model_Condition_Combine
     */
    protected $_conditions;

    /**
     * Store rule actions model
     *
     * @var Mage_Rule_Model_Action_Collection
     */
    protected $_actions;

    /**
     * Store rule form instance
     *
     * @var Varien_Data_Form
     */
    protected $_form;

    /**
     * Is model can be deleted flag
     *
     * @var bool
     */
    protected $_isDeleteable = true;

    /**
     * Is model readonly
     *
     * @var bool
     */
    protected $_isReadonly = false;

    /**
     * Getter for rule combine conditions instance
     *
     * @return Mage_Rule_Model_Condition_Combine
     */
    abstract public function getConditionsInstance();

    /**
     * Getter for rule actions collection instance
     *
     * @return Mage_Rule_Model_Action_Collection
     */
    abstract public function getActionsInstance();

    /**
     * Prepare data before saving
     *
     * @return Mage_Rule_Model_Abstract
     */
    protected function _beforeSave()
    {
        // Check if discount amount not negative
        if ($this->hasDiscountAmount()) {
            if ((int)$this->getDiscountAmount() < 0) {
                Mage::throwException(Mage::helper('rule')->__('Invalid discount amount.'));
            }
        }

        // Serialize conditions
        if ($this->getConditions()) {
            $this->setConditionsSerialized(serialize($this->getConditions()->asArray()));
            $this->unsConditions();
        }

        // Serialize actions
        if ($this->getActions()) {
            $this->setActionsSerialized(serialize($this->getActions()->asArray()));
            $this->unsActions();
        }

        /**
         * Prepare website Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasWebsiteIds()) {
            $websiteIds = $this->getWebsiteIds();
            if (is_string($websiteIds) && !empty($websiteIds)) {
                $this->setWebsiteIds(explode(',', $websiteIds));
            }
        }

        /**
         * Prepare customer group Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasCustomerGroupIds()) {
            $groupIds = $this->getCustomerGroupIds();
            if (is_string($groupIds) && !empty($groupIds)) {
                $this->setCustomerGroupIds(explode(',', $groupIds));
            }
        }

        parent::_beforeSave();
        return $this;
    }

    /**
     * Set rule combine conditions model
     *
     * @param Mage_Rule_Model_Condition_Combine $conditions
     *
     * @return Mage_Rule_Model_Abstract
     */
    public function setConditions($conditions)
    {
        $this->_conditions = $conditions;
        return $this;
    }

    /**
     * Retrieve rule combine conditions model
     *
     * @return Mage_Rule_Model_Condition_Combine
     */
    public function getConditions()
    {
        if (empty($this->_conditions)) {
            $this->_resetConditions();
        }

        // Load rule conditions if it is applicable
        if ($this->hasConditionsSerialized()) {
            $conditions = $this->getConditionsSerialized();
            if (!empty($conditions)) {
                $conditions = unserialize($conditions);
                if (is_array($conditions) && !empty($conditions)) {
                    $this->_conditions->loadArray($conditions);
                }
            }
            $this->unsConditionsSerialized();
        }

        return $this->_conditions;
    }

    /**
     * Set rule actions model
     *
     * @param Mage_Rule_Model_Action_Collection $actions
     *
     * @return Mage_Rule_Model_Abstract
     */
    public function setActions($actions)
    {
        $this->_actions = $actions;
        return $this;
    }

    /**
     * Retrieve rule actions model
     *
     * @return Mage_Rule_Model_Action_Collection
     */
    public function getActions()
    {
        if (!$this->_actions) {
            $this->_resetActions();
        }

        // Load rule actions if it is applicable
        if ($this->hasActionsSerialized()) {
            $actions = $this->getActionsSerialized();
            if (!empty($actions)) {
                $actions = unserialize($actions);
                if (is_array($actions) && !empty($actions)) {
                    $this->_actions->loadArray($actions);
                }
            }
            $this->unsActionsSerialized();
        }

        return $this->_actions;
    }

    /**
     * Reset rule combine conditions
     *
     * @param null|Mage_Rule_Model_Condition_Combine $conditions
     *
     * @return Mage_Rule_Model_Abstract
     */
    protected function _resetConditions($conditions = null)
    {
        if (is_null($conditions)) {
            $conditions = $this->getConditionsInstance();
        }
        $conditions->setRule($this)->setId('1')->setPrefix('conditions');
        $this->setConditions($conditions);

        return $this;
    }

    /**
     * Reset rule actions
     *
     * @param null|Mage_Rule_Model_Action_Collection $actions
     *
     * @return Mage_Rule_Model_Abstract
     */
    protected function _resetActions($actions = null)
    {
        if (is_null($actions)) {
            $actions = $this->getActionsInstance();
        }
        $actions->setRule($this)->setId('1')->setPrefix('actions');
        $this->setActions($actions);

        return $this;
    }

    /**
     * Rule form getter
     *
     * @return Varien_Data_Form
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = new Varien_Data_Form();
        }
        return $this->_form;
    }

    /**
     * Initialize rule model data from array
     *
     * @param array $data
     *
     * @return Mage_Rule_Model_Abstract
     */
    public function loadPost(array $data)
    {
        $arr = $this->_convertFlatToRecursive($data);
        if (isset($arr['conditions'])) {
            $this->getConditions()->setConditions(array())->loadArray($arr['conditions'][1]);
        }
        if (isset($arr['actions'])) {
            $this->getActions()->setActions(array())->loadArray($arr['actions'][1], 'actions');
        }

        return $this;
    }

    /**
     * Set specified data to current rule.
     * Set conditions and actions recursively.
     * Convert dates into Zend_Date.
     *
     * @param array $data
     *
     * @return array
     */
    protected function _convertFlatToRecursive(array $data)
    {
        $arr = array();
        foreach ($data as $key => $value) {
            if (($key === 'conditions' || $key === 'actions') && is_array($value)) {
                foreach ($value as $id=>$data) {
                    $path = explode('--', $id);
                    $node =& $arr;
                    for ($i=0, $l=sizeof($path); $i<$l; $i++) {
                        if (!isset($node[$key][$path[$i]])) {
                            $node[$key][$path[$i]] = array();
                        }
                        $node =& $node[$key][$path[$i]];
                    }
                    foreach ($data as $k => $v) {
                        $node[$k] = $v;
                    }
                }
            } else {
                /**
                 * Convert dates into Zend_Date
                 */
                if (in_array($key, array('from_date', 'to_date')) && $value) {
                    $value = Mage::app()->getLocale()->date(
                        $value,
                        Varien_Date::DATE_INTERNAL_FORMAT,
                        null,
                        false
                    );
                }
                $this->setData($key, $value);
            }
        }

        return $arr;
    }

    /**
     * Validate rule conditions to determine if rule can run
     *
     * @param Varien_Object $object
     *
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        return $this->getConditions()->validate($object);
    }

    /**
     * Validate rule data
     *
     * @param Varien_Object $object
     *
     * @return bool|array - return true if validation passed successfully. Array with errors description otherwise
     */
    public function validateData(Varien_Object $object)
    {
        $result   = array();
        $fromDate = $toDate = null;

        if ($object->hasFromDate() && $object->hasToDate()) {
            $fromDate = $object->getFromDate();
            $toDate = $object->getToDate();
        }

        if ($fromDate && $toDate) {
            $fromDate = new Zend_Date($fromDate, Varien_Date::DATE_INTERNAL_FORMAT);
            $toDate = new Zend_Date($toDate, Varien_Date::DATE_INTERNAL_FORMAT);

            if ($fromDate->compare($toDate) === 1) {
                $result[] = Mage::helper('rule')->__('End Date must be greater than Start Date.');
            }
        }

        if ($object->hasWebsiteIds()) {
            $websiteIds = $object->getWebsiteIds();
            if (empty($websiteIds)) {
                $result[] = Mage::helper('rule')->__('Websites must be specified.');
            }
        }
        if ($object->hasCustomerGroupIds()) {
            $customerGroupIds = $object->getCustomerGroupIds();
            if (empty($customerGroupIds)) {
                $result[] = Mage::helper('rule')->__('Customer Groups must be specified.');
            }
        }

        return !empty($result) ? $result : true;
    }

    /**
     * Check availability to delete rule
     *
     * @return bool
     */
    public function isDeleteable()
    {
        return $this->_isDeleteable;
    }

    /**
     * Set is rule can be deleted flag
     *
     * @param bool $value
     *
     * @return Mage_Rule_Model_Abstract
     */
    public function setIsDeleteable($value)
    {
        $this->_isDeleteable = (bool) $value;
        return $this;
    }

    /**
     * Check if rule is readonly
     *
     * @return bool
     */
    public function isReadonly()
    {
        return $this->_isReadonly;
    }

    /**
     * Set is readonly flag to rule
     *
     * @param bool $value
     *
     * @return Mage_Rule_Model_Abstract
     */
    public function setIsReadonly($value)
    {
        $this->_isReadonly = (bool) $value;
        return $this;
    }

    /**
     * Get rule associated website Ids
     *
     * @return array
     */
    public function getWebsiteIds()
    {
        if (!$this->hasWebsiteIds()) {
            $websiteIds = $this->_getResource()->getWebsiteIds($this->getId());
            $this->setData('website_ids', (array)$websiteIds);
        }
        return $this->_getData('website_ids');
    }




    /**
     * @deprecated since 1.7.0.0
     *
     * @param string $format
     *
     * @return string
     */
    public function asString($format='')
    {
        return '';
    }

    /**
     * @deprecated since 1.7.0.0
     *
     * @return string
     */
    public function asHtml()
    {
        return '';
    }

    /**
     * Returns rule as an array for admin interface
     *
     * @deprecated since 1.7.0.0
     *
     * @param array $arrAttributes
     *
     * @return array
     */
    public function asArray(array $arrAttributes = array())
    {
        return array();
    }

    /**
     * Combine website ids to string
     *
     * @deprecated since 1.7.0.0
     *
     * @return Mage_Rule_Model_Abstract
     */
    protected function _prepareWebsiteIds()
    {
        return $this;
    }
}
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
 * @package     Mage_Rule
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Abstract Rule entity data model
 *
 * @deprecated since 1.7.0.0 use Mage_Rule_Model_Abstract instead
 *
 * @category Mage
 * @package Mage_Rule
 * @author Magento Core Team <core@magentocommerce.com>
 */
class Mage_Rule_Model_Rule extends Mage_Rule_Model_Abstract
{
    /**
     * Getter for rule combine conditions instance
     *
     * @return Mage_Rule_Model_Condition_Combine
     */
    public function getConditionsInstance()
    {
        return Mage::getModel('rule/condition_combine');
    }

    /**
     * Getter for rule actions collection instance
     *
     * @return Mage_Rule_Model_Action_Collection
     */
    public function getActionsInstance()
    {
        return Mage::getModel('rule/action_collection');
    }
}
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
class Rewardpoints_Model_Columns
{

    
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label'=>Mage::helper('rewardpoints')->__('First column')),
            array('value' => 1, 'label'=>Mage::helper('rewardpoints')->__('Second column')),
            array('value' => 2, 'label'=>Mage::helper('rewardpoints')->__('Third column')),
            array('value' => 3, 'label'=>Mage::helper('rewardpoints')->__('Forth column')),
        );
    }

}
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
class Rewardpoints_Model_Columns2
{

    
    public function toOptionArray()
    {
        return array(
            array('value' => -1, 'label'=>Mage::helper('rewardpoints')->__('Not available')),
            array('value' => 0, 'label'=>Mage::helper('rewardpoints')->__('First column')),
            array('value' => 1, 'label'=>Mage::helper('rewardpoints')->__('Second column')),
            array('value' => 2, 'label'=>Mage::helper('rewardpoints')->__('Third column')),
            array('value' => 3, 'label'=>Mage::helper('rewardpoints')->__('Forth column')),
        );
    }

}
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
class Rewardpoints_Model_Config_Imageimport extends Mage_Core_Model_Config_Data
{
    public function _afterSave()
    {
        Mage::getResourceModel('rewardpoints/stats')->uploadImage($this);
    }
}
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
class Rewardpoints_Model_Config_Tablecell extends Mage_Core_Model_Config_Data
{
    public function _afterSave()
    {
        Mage::getResourceModel('rewardpoints/stats')->uploadAndImport($this);
    }
}
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
class Rewardpoints_Model_Discount extends Mage_Core_Model_Abstract
{

    protected $_discount;
    protected $_quote;
    protected $_couponCode;


    public function getCartAmount(){
        
        
        if ($this->_quote){
            $totalPrices = $this->_quote->getTotals();
        } else {
            $totalPrices = Mage::helper('checkout/cart')->getCart()->getQuote()->getTotals();
        }
        $tax = 0;
        $subtotalPrice = 0;
        
        if (Mage::getStoreConfig('rewardpoints/default/process_tax', Mage::app()->getStore()->getId()) == 1 && Mage::getStoreConfig('tax/calculation/apply_after_discount', Mage::app()->getStore()->getId()) == 0){
            if (isset($totalPrices['tax'])){
                $tax_val = $totalPrices['tax'];
                $tax = $tax_val->getData('value');
            }
        }
        
        $shipping = 0;

        $shipping_process = Mage::getStoreConfig('rewardpoints/default/process_shipping', Mage::app()->getStore()->getId());
        if (version_compare(Mage::getVersion(), '1.4.0', '>=') && $shipping_process){
            if (isset($totalPrices['shipping'])){
                $shipping_val = $totalPrices['shipping'];
                $shipping = $shipping_val->getData('value');
            }
        }        

        $subtotalPrice = $totalPrices['subtotal'];
        if ($val_sub = $subtotalPrice->getData('value_excl_tax')){
            $order_details = $val_sub + $tax + $shipping;
        } else {
            $order_details = $subtotalPrice->getData('value') + $tax + $shipping;
        }
        
        return $order_details;
    }


    public function checkMaxPointsToApply($points){
        $order_details = $this->getCartAmount();
        $cart_amount = Mage::helper('rewardpoints/data')->processMathValue($order_details);
        $maxpoints = min(Mage::helper('rewardpoints/data')->convertMoneyToPoints($cart_amount), $points);
        return $maxpoints;
    }


    public function applyShipping(Mage_Sales_Model_Quote_Address $address)
    {

        
        $shippingAmount = $address->getShippingAmountForDiscount();
        if ($shippingAmount!==null) {
            $baseShippingAmount = $address->getBaseShippingAmountForDiscount();
        } else {
            $shippingAmount     = $address->getShippingAmount();
            $baseShippingAmount = $address->getBaseShippingAmount();
        }


        $points_apply = (int) Mage::helper('rewardpoints/event')->getCreditPoints();


        $this->_quote = $quote = $address->getQuote();
        $customer = $quote->getCustomer();
        $customerId = $customer->getId();

        if ($points_apply > 0 && $customerId != null){
            

            $points_apply = Mage::helper('rewardpoints/data')->convertMoneyToPoints(Mage::getSingleton('rewardpoints/session')->getDiscountleft());

            $points_apply_amount = Mage::getSingleton('rewardpoints/session')->getDiscountleft();
            if (!$this->_discount){
                //$reward_model = Mage::getModel('rewardpoints/stats');
                
                if (Mage::getStoreConfig('rewardpoints/default/flatstats', Mage::app()->getStore()->getId())){
                    $reward_model = Mage::getModel('rewardpoints/flatstats');
                    $customer_points = $reward_model->collectPointsCurrent($customerId, Mage::app()->getStore()->getId());
                } else {
                    $reward_model = Mage::getModel('rewardpoints/stats');
                    $customer_points = $reward_model->getPointsCurrent($customerId, Mage::app()->getStore()->getId());
                }
                
                
                //if ($points_apply > $reward_model->getPointsCurrent($customerId, Mage::app()->getStore()->getId())){
                if ($points_apply > $customer_points){
                    return false;
                } else {
                    $discounts = $points_apply_amount;
                }

                if (Mage::getSingleton('rewardpoints/session')->getDiscountleft() && (!Mage::getSingleton('rewardpoints/session')->getShippingChecked() && $discounts > 0) || Mage::getSingleton('rewardpoints/session')->getProductChecked() == 0){
                    Mage::getSingleton('rewardpoints/session')->setShippingChecked(0);
                    Mage::getSingleton('rewardpoints/session')->setDiscountleft($points_apply_amount);
                    $this->_discount = $discounts;
                    $this->_couponCode = $points_apply;
                } else {
                    $this->_discount = Mage::getSingleton('rewardpoints/session')->getDiscountleft();
                    $this->_couponCode = $points_apply;
                }
            }

            $discountAmount = 0;
            $baseDiscountAmount = 0;

            ////////////////////////////

            $discountAmount = min($shippingAmount - $address->getShippingDiscountAmount(), $quote->getStore()->convertPrice($this->_discount));
            $baseDiscountAmount = min($baseShippingAmount - $address->getBaseShippingDiscountAmount(), $this->_discount);

            

            //$discountAmount = Mage::helper('rewardpoints/data')->ratePointCorrection($discountAmount);
            //$baseDiscountAmount = Mage::helper('rewardpoints/data')->ratePointCorrection($baseDiscountAmount);

            Mage::getSingleton('rewardpoints/session')->setShippingChecked(1);
            //$quote_id = Mage::helper('checkout/cart')->getCart()->getQuote()->getId();
            Mage::getSingleton('rewardpoints/session')->setDiscountleft(Mage::getSingleton('rewardpoints/session')->getDiscountleft() - $baseDiscountAmount);
            $discountAmount     = min($discountAmount + $address->getShippingDiscountAmount(), $shippingAmount);
            $baseDiscountAmount = min($baseDiscountAmount + $address->getBaseShippingDiscountAmount(), $baseShippingAmount);

            $address->setShippingDiscountAmount($discountAmount);
            $address->setBaseShippingDiscountAmount($baseDiscountAmount);
        }
    }

    public function getFullItemNumber(Mage_Sales_Model_Quote_Address $address)
    {
        $quote = $address->getQuote();
        $items = $address->getAllItems();
        if (!count($items)) {
            return $this;
        } 
        $i = 0;
        foreach ($items as $item) {
            if (!$item->getParentItemId()) {
                if ($item->getHasChildren() && $item->isChildrenCalculated()) {
                    foreach ($item->getChildren() as $child) {
                        $i = $i + $child->getQty();
                    }
                } else {
                    $i = $i + $item->getQty();
                }
            }
        }
        return $i;
    }


    public function apply(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        $points_apply = (int) Mage::helper('rewardpoints/event')->getCreditPoints();

        $this->_quote = $quote = $item->getQuote();
        $customer = $quote->getCustomer();
        $customerId = $customer->getId();

        if ($points_apply > 0 && $customerId != null){
            $test_points = $this->checkMaxPointsToApply($points_apply);

            if ($points_apply > $test_points){
                $points_apply = $test_points;
                Mage::helper('rewardpoints/event')->setCreditPoints($points_apply);
            }            
            $points_apply_amount = Mage::helper('rewardpoints/data')->convertPointsToMoney($points_apply);
            
            $address = $this->_getAddress($item);

            //$cart_summury_count = Mage::helper('checkout/cart')->getSummaryCount();
            $cart_summury_count = $this->getFullItemNumber($address);

            if (!$this->_discount){
                //$reward_model = Mage::getModel('rewardpoints/stats');
                
                if (Mage::getStoreConfig('rewardpoints/default/flatstats', Mage::app()->getStore()->getId())){
                    $reward_model = Mage::getModel('rewardpoints/flatstats');
                    $customer_points = $reward_model->collectPointsCurrent($customerId, Mage::app()->getStore()->getId());
                } else {
                    $reward_model = Mage::getModel('rewardpoints/stats');
                    $customer_points = $reward_model->getPointsCurrent($customerId, Mage::app()->getStore()->getId());
                }
                
                //if ($points_apply > $reward_model->getPointsCurrent($customerId, Mage::app()->getStore()->getId())){
                if ($points_apply > $customer_points){
                    return false;
                } else {
                    $discounts = $points_apply_amount;
                }

                //echo "remise $discounts ";
                
                if ((Mage::getSingleton('rewardpoints/session')->getProductChecked() >= $cart_summury_count && $discounts > 0) || !Mage::getSingleton('rewardpoints/session')->getProductChecked() || Mage::getSingleton('rewardpoints/session')->getProductChecked() == 0){
                    Mage::getSingleton('rewardpoints/session')->setProductChecked(0);
                    Mage::getSingleton('rewardpoints/session')->setDiscountleft($points_apply_amount);

                    $this->_discount = $discounts;
                    $this->_couponCode = $points_apply;
                } else {
                    $this->_discount = Mage::getSingleton('rewardpoints/session')->getDiscountleft();
                    $this->_couponCode = $points_apply;
                }
            }


            $discountAmount = 0;
            $baseDiscountAmount = 0;

            //process_tax
            if (Mage::getStoreConfig('rewardpoints/default/process_tax', Mage::app()->getStore()->getId()) == 1 && Mage::getStoreConfig('tax/calculation/apply_after_discount', Mage::app()->getStore()->getId()) == 0){
                $row_total = $item->getRowTotal() + $item->getTaxAmount();
                $tax = ($item->getTaxBeforeDiscount() ? $item->getTaxBeforeDiscount() : $item->getTaxAmount());
                $row_base_total = $item->getBaseRowTotal() + $tax;
            } else {
                $row_total = $item->getRowTotal();
                $row_base_total = $item->getBaseRowTotal();
            }

            $discountAmount = min($row_total - $item->getDiscountAmount(), $quote->getStore()->convertPrice($this->_discount));
            $baseDiscountAmount = min($row_base_total - $item->getBaseDiscountAmount(), $this->_discount);

           
            Mage::getSingleton('rewardpoints/session')->setProductChecked(Mage::getSingleton('rewardpoints/session')->getProductChecked() + $item->getQty());
            //$quote_id = Mage::helper('checkout/cart')->getCart()->getQuote()->getId();
            Mage::getSingleton('rewardpoints/session')->setDiscountleft(Mage::getSingleton('rewardpoints/session')->getDiscountleft() - $baseDiscountAmount);

            

            $discountAmount     = min($discountAmount + $item->getDiscountAmount(), $row_total);
            $baseDiscountAmount = min($baseDiscountAmount + $item->getBaseDiscountAmount(), $row_base_total);


            $item->setDiscountAmount($discountAmount);
            $item->setBaseDiscountAmount($baseDiscountAmount);
            //store_labels
            $couponCode = explode(', ', $address->getCouponCode());

            
            $descriptionPromo = $address->getDiscountDescriptionArray();
            if (sizeof($descriptionPromo)){
                $return_array = array();
                foreach($descriptionPromo as $val_desc){
                    $return_array[] = $val_desc;
                }
                $descriptionPromo = $return_array;
            }
            if (sizeof($couponCode)){
                foreach($couponCode as $key_promo => $value_promo){
                    if (isset($descriptionPromo[$key_promo])){
                        $couponCode[$key_promo] = $descriptionPromo[$key_promo];
                    }
                }
            }

            $couponCode[] = Mage::helper('rewardpoints/data')->__('%s credit points', ceil($this->_couponCode));
            $couponCode = array_unique(array_filter($couponCode));
            if (version_compare(Mage::getVersion(), '1.4.0', '<')){
                $address->setCouponCode(implode(', ', $couponCode));
            }
            //$address->setCouponCode(implode(', ', $couponCode));
            $address->setDiscountDescriptionArray($couponCode);
        }
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
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }


    /**
     * Get address object which can be used for discount calculation
     *
     * @param   Mage_Sales_Model_Quote_Item_Abstract $item
     * @return  Mage_Sales_Model_Quote_Address
     */
    protected function _getAddress(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        if ($item instanceof Mage_Sales_Model_Quote_Address_Item) {
            $address = $item->getAddress();
        } elseif ($item->getQuote()->isVirtual()) {
            $address = $item->getQuote()->getBillingAddress();
        } else {
            $address = $item->getQuote()->getShippingAddress();
        }
        return $address;
    }

}
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
class Rewardpoints_Model_Mathmethod
{

    
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('rewardpoints')->__('Round up points')),
            array('value' => 0, 'label'=>Mage::helper('rewardpoints')->__('Floor up points')),
            array('value' => 2, 'label'=>Mage::helper('rewardpoints')->__('Exact points value')),
        );
    }

}
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
 * @package     Mage_Core
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Abstract resource model class
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Core_Model_Mysql4_Abstract extends Mage_Core_Model_Resource_Db_Abstract
{
}
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
abstract class Rewardpoints_Model_Mysql4_Abstract extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Primery key auto increment flag
     *
     * @var bool
     */
    protected $_isPkAutoIncrement = true;

    /**
	 *  Magento bug fix
     */
    public function save(Mage_Core_Model_Abstract $object)
    {
        if ($object->isDeleted()) {
            return $this->delete($object);
        }

        $this->_beforeSave($object);
        $this->_checkUnique($object);

        if (!is_null($object->getId())) {
            $condition = $this->_getWriteAdapter()->quoteInto($this->getIdFieldName().'=?', $object->getId());
            /**
             * Not auto increment primary key support
             */
            if ($this->_isPkAutoIncrement) {
                $this->_getWriteAdapter()->update($this->getMainTable(), $this->_prepareDataForSave($object), $condition);
            } else {
                $select = $this->_getWriteAdapter()->select()->from($this->getMainTable(), array($this->getIdFieldName()))
                    ->where($condition);
                if ($this->_getWriteAdapter()->fetchOne($select) !== false) {
                    $this->_getWriteAdapter()->update($this->getMainTable(), $this->_prepareDataForSave($object), $condition);
                } else {
                    $this->_getWriteAdapter()->insert($this->getMainTable(), $this->_prepareDataForSave($object));
                }
            }
        } else {
            $this->_getWriteAdapter()->insert($this->getMainTable(), $this->_prepareDataForSave($object));
            $object->setId($this->_getWriteAdapter()->lastInsertId($this->getMainTable()));
        }

        $this->_afterSave($object);

        return $this;
    }

    protected function _prepareDataForSave(Mage_Core_Model_Abstract $object)
    {
        if ($this->_isPkAutoIncrement && !$object->getId()) {
            $object->setCreatedAt(now());
        } else {
            $object->setCreatedAt(now());
        }
        $object->setUpdatedAt(now());
        $data = parent::_prepareDataForSave($object);
        return $data;
    }

}
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
class Rewardpoints_Model_Mysql4_Catalogpointrules extends Mage_Core_Model_Mysql4_Abstract
{
    const SECONDS_IN_DAY = 86400;

    public function _construct()
    {    
        $this->_init('rewardpoints/catalogpointrules', 'rule_id');
    }
    
    /**
     * Prepare object data for saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    public function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getFromDate()) {
            $date = Mage::app()->getLocale()->date();
            $date->setHour(0)
                ->setMinute(0)
                ->setSecond(0);
            $object->setFromDate($date);
        }
        if ($object->getFromDate() instanceof Zend_Date) {
            $object->setFromDate($object->getFromDate()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
        }
       

        if (!$object->getToDate()) {
            $object->setToDate(new Zend_Db_Expr('NULL'));
        }
        else {
            if ($object->getToDate() instanceof Zend_Date) {
                $object->setToDate($object->getToDate()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
            }
        }
        parent::_beforeSave($object);
    }
}
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
 * @package     Mage_Core
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Abstract Core Resource Collection
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Core_Model_Mysql4_Collection_Abstract extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
}
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

class Rewardpoints_Model_Mysql4_Catalogpointrules_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
	parent::_construct();
        $this->_init('rewardpoints/catalogpointrules');
    }


    public function setValidationFilter($websiteId, $customerGroupId, $now=null)
    {
        if (is_null($now)) {
            $now = Mage::getModel('core/date')->date('Y-m-d');
        }

        $this->getSelect()->where('status=1');
        $this->getSelect()->where('find_in_set(?, website_ids)', (int)$websiteId);
        $this->getSelect()->where('find_in_set(?, customer_group_ids)', (int)$customerGroupId);

        $this->getSelect()->where('from_date is null or from_date<=?', $now);
        $this->getSelect()->where('to_date is null or to_date>=?', $now);
        $this->getSelect()->order('sort_order');

        return $this;
    }

    /**
     * Filter collection by specified website IDs
     *
     * @param int|array $websiteIds
     * @return Mage_CatalogRule_Model_Mysql4_Rule_Collection
     */
    public function addWebsiteFilter($websiteIds)
    {
        if (!is_array($websiteIds)) {
            $websiteIds = array($websiteIds);
        }
        $parts = array();
        foreach ($websiteIds as $websiteId) {
            $parts[] = $this->getConnection()->quoteInto('FIND_IN_SET(?, main_table.website_ids)', $websiteId);
        }
        if ($parts) {
            $this->getSelect()->where(new Zend_Db_Expr(implode(' OR ', $parts)));
        }
        return $this;
    }
}
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
 * @package     Mage_Eav
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Entity/Attribute/Model - collection abstract
 *
 * @category   Mage
 * @package    Mage_Eav
 * @author      Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Eav_Model_Entity_Collection_Abstract extends Varien_Data_Collection_Db
{
    /**
     * Array of items with item id key
     *
     * @var array
     */
    protected $_itemsById                  = array();

    /**
     * Entity static fields
     *
     * @var array
     */
    protected $_staticFields               = array();

    /**
     * Entity object to define collection's attributes
     *
     * @var Mage_Eav_Model_Entity_Abstract
     */
    protected $_entity;

    /**
     * Entity types to be fetched for objects in collection
     *
     * @var array
     */
    protected $_selectEntityTypes         = array();

    /**
     * Attributes to be fetched for objects in collection
     *
     * @var array
     */
    protected $_selectAttributes          = array();

    /**
     * Attributes to be filtered order sorted by
     *
     * @var array
     */
    protected $_filterAttributes          = array();

    /**
     * Joined entities
     *
     * @var array
     */
    protected $_joinEntities              = array();

    /**
     * Joined attributes
     *
     * @var array
     */
    protected $_joinAttributes            = array();

    /**
     * Joined fields data
     *
     * @var array
     */
    protected $_joinFields                = array();

    /**
     * Use analytic function flag
     * If true - allows to prepare final select with analytic functions
     *
     * @var bool
     */
    protected $_useAnalyticFunction         = false;

    /**
     * Cast map for attribute order
     *
     * @var array
     */
    protected $_castToIntMap = array(
        'validate-digits'
    );

    /**
     * Collection constructor
     *
     * @param Mage_Core_Model_Resource_Abstract $resource
     */
    public function __construct($resource = null)
    {
        parent::__construct();
        $this->_construct();
        $this->setConnection($this->getEntity()->getReadConnection());
        $this->_prepareStaticFields();
        $this->_initSelect();
    }

    /**
     * Initialize collection
     */
    protected function _construct()
    {

    }

    /**
     * Retreive table name
     *
     * @param string $table
     * @return string
     */
    public function getTable($table)
    {
        return $this->getResource()->getTable($table);
    }

    /**
     * Prepare static entity fields
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _prepareStaticFields()
    {
        foreach ($this->getEntity()->getDefaultAttributes() as $field) {
            $this->_staticFields[$field] = $field;
        }
        return $this;
    }

    /**
     * Init select
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _initSelect()
    {
        $this->getSelect()->from(array('e' => $this->getEntity()->getEntityTable()));
        if ($this->getEntity()->getTypeId()) {
            $this->addAttributeToFilter('entity_type_id', $this->getEntity()->getTypeId());
        }
        return $this;
    }

    /**
     * Standard resource collection initalization
     *
     * @param string $model
     * @return Mage_Core_Model_Mysql4_Collection_Abstract
     */
    protected function _init($model, $entityModel = null)
    {
        $this->setItemObjectClass(Mage::getConfig()->getModelClassName($model));
        if ($entityModel === null) {
            $entityModel = $model;
        }
        $entity = Mage::getResourceSingleton($entityModel);
        $this->setEntity($entity);

        return $this;
    }

    /**
     * Set entity to use for attributes
     *
     * @param Mage_Eav_Model_Entity_Abstract $entity
     * @throws Mage_Eav_Exception
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function setEntity($entity)
    {
        if ($entity instanceof Mage_Eav_Model_Entity_Abstract) {
            $this->_entity = $entity;
        } elseif (is_string($entity) || $entity instanceof Mage_Core_Model_Config_Element) {
            $this->_entity = Mage::getModel('eav/entity')->setType($entity);
        } else {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Invalid entity supplied: %s', print_r($entity, 1)));
        }
        return $this;
    }

    /**
     * Get collection's entity object
     *
     * @return Mage_Eav_Model_Entity_Abstract
     */
    public function getEntity()
    {
        if (empty($this->_entity)) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Entity is not initialized'));
        }
        return $this->_entity;
    }

    /**
     * Get resource instance
     *
     * @return Mage_Core_Model_Mysql4_Abstract
     */
    public function getResource()
    {
        return $this->getEntity();
    }

    /**
     * Set template object for the collection
     *
     * @param   Varien_Object $object
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function setObject($object=null)
    {
        if (is_object($object)) {
            $this->setItemObjectClass(get_class($object));
        } else {
            $this->setItemObjectClass($object);
        }

        return $this;
    }


    /**
     * Add an object to the collection
     *
     * @param Varien_Object $object
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addItem(Varien_Object $object)
    {
        if (get_class($object) !== $this->_itemObjectClass) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Attempt to add an invalid object'));
        }
        return parent::addItem($object);
    }

    /**
     * Retrieve entity attribute
     *
     * @param   string $attributeCode
     * @return  Mage_Eav_Model_Entity_Attribute_Abstract
     */
    public function getAttribute($attributeCode)
    {
        if (isset($this->_joinAttributes[$attributeCode])) {
            return $this->_joinAttributes[$attributeCode]['attribute'];
        }

        return $this->getEntity()->getAttribute($attributeCode);
    }

    /**
     * Add attribute filter to collection
     *
     * If $attribute is an array will add OR condition with following format:
     * array(
     *     array('attribute'=>'firstname', 'like'=>'test%'),
     *     array('attribute'=>'lastname', 'like'=>'test%'),
     * )
     *
     * @see self::_getConditionSql for $condition
     * @param Mage_Eav_Model_Entity_Attribute_Interface|integer|string|array $attribute
     * @param null|string|array $condition
     * @param string $operator
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addAttributeToFilter($attribute, $condition = null, $joinType = 'inner')
    {
        if ($attribute === null) {
            $this->getSelect();
            return $this;
        }

        if (is_numeric($attribute)) {
            $attribute = $this->getEntity()->getAttribute($attribute)->getAttributeCode();
        } else if ($attribute instanceof Mage_Eav_Model_Entity_Attribute_Interface) {
            $attribute = $attribute->getAttributeCode();
        }

        if (is_array($attribute)) {
            $sqlArr = array();
            foreach ($attribute as $condition) {
                $sqlArr[] = $this->_getAttributeConditionSql($condition['attribute'], $condition, $joinType);
            }
            $conditionSql = '('.implode(') OR (', $sqlArr).')';
        } else if (is_string($attribute)) {
            if ($condition === null) {
                $condition = '';
            }
            $conditionSql = $this->_getAttributeConditionSql($attribute, $condition, $joinType);
        }

        if (!empty($conditionSql)) {
            $this->getSelect()->where($conditionSql, null, Varien_Db_Select::TYPE_CONDITION);
        } else {
            Mage::throwException('Invalid attribute identifier for filter ('.get_class($attribute).')');
        }

        return $this;
    }

    /**
     * Wrapper for compatibility with Varien_Data_Collection_Db
     *
     * @param mixed $attribute
     * @param mixed $condition
     */
    public function addFieldToFilter($attribute, $condition = null)
    {
        return $this->addAttributeToFilter($attribute, $condition);
    }

    /**
     * Add attribute to sort order
     *
     * @param string $attribute
     * @param string $dir
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addAttributeToSort($attribute, $dir = self::SORT_ORDER_ASC)
    {
        if (isset($this->_joinFields[$attribute])) {
            $this->getSelect()->order($this->_getAttributeFieldName($attribute).' '.$dir);
            return $this;
        }
        if (isset($this->_staticFields[$attribute])) {
            $this->getSelect()->order("e.{$attribute} {$dir}");
            return $this;
        }
        if (isset($this->_joinAttributes[$attribute])) {
            $attrInstance = $this->_joinAttributes[$attribute]['attribute'];
            $entityField = $this->_getAttributeTableAlias($attribute) . '.' . $attrInstance->getAttributeCode();
        } else {
            $attrInstance = $this->getEntity()->getAttribute($attribute);
            $entityField = 'e.' . $attribute;
        }

        if ($attrInstance) {
            if ($attrInstance->getBackend()->isStatic()) {
                $orderExpr = $entityField;
            } else {
                $this->_addAttributeJoin($attribute, 'left');
                if (isset($this->_joinAttributes[$attribute])||isset($this->_joinFields[$attribute])) {
                    $orderExpr = $attribute;
                } else {
                    $orderExpr = $this->_getAttributeTableAlias($attribute).'.value';
                }
            }

            if (in_array($attrInstance->getFrontendClass(), $this->_castToIntMap)) {
                $orderExpr = Mage::getResourceHelper('eav')->getCastToIntExpression(
                    $this->_prepareOrderExpression($orderExpr)
                );
            }

            $orderExpr .= ' ' . $dir;
            $this->getSelect()->order($orderExpr);
        }
        return $this;
    }

    /**
     * Retrieve attribute expression by specified column
     *
     * @param string $field
     * @return string|Zend_Db_Expr
     */
    protected function _prepareOrderExpression($field)
    {
        foreach ($this->getSelect()->getPart(Zend_Db_Select::COLUMNS) as $columnEntry) {
            if ($columnEntry[2] != $field) {
                continue;
            }
            if ($columnEntry[1] instanceof Zend_Db_Expr) {
                return $columnEntry[1];
            }
        }
        return $field;
    }

    /**
     * Add attribute to entities in collection
     *
     * If $attribute=='*' select all attributes
     *
     * @param   array|string|integer|Mage_Core_Model_Config_Element $attribute
     * @param   false|string $joinType flag for joining attribute
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addAttributeToSelect($attribute, $joinType = false)
    {
        if (is_array($attribute)) {
            Mage::getSingleton('eav/config')->loadCollectionAttributes($this->getEntity()->getType(), $attribute);
            foreach ($attribute as $a) {
                $this->addAttributeToSelect($a, $joinType);
            }
            return $this;
        }
        if ($joinType !== false && !$this->getEntity()->getAttribute($attribute)->isStatic()) {
            $this->_addAttributeJoin($attribute, $joinType);
        } elseif ('*' === $attribute) {
            $entity = clone $this->getEntity();
            $attributes = $entity
                ->loadAllAttributes()
                ->getAttributesByCode();
            foreach ($attributes as $attrCode=>$attr) {
                $this->_selectAttributes[$attrCode] = $attr->getId();
            }
        } else {
            if (isset($this->_joinAttributes[$attribute])) {
                $attrInstance = $this->_joinAttributes[$attribute]['attribute'];
            } else {
                $attrInstance = Mage::getSingleton('eav/config')
                    ->getCollectionAttribute($this->getEntity()->getType(), $attribute);
            }
            if (empty($attrInstance)) {
                throw Mage::exception(
                    'Mage_Eav',
                    Mage::helper('eav')->__('Invalid attribute requested: %s', (string)$attribute)
                );
            }
            $this->_selectAttributes[$attrInstance->getAttributeCode()] = $attrInstance->getId();
        }
        return $this;
    }

    public function addEntityTypeToSelect($entityType, $prefix)
    {
        $this->_selectEntityTypes[$entityType] = array(
            'prefix' => $prefix,
        );
        return $this;
    }

    /**
     * Add field to static
     *
     * @param string $field
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addStaticField($field)
    {
        if (!isset($this->_staticFields[$field])) {
            $this->_staticFields[$field] = $field;
        }
        return $this;
    }

    /**
     * Add attribute expression (SUM, COUNT, etc)
     *
     * Example: ('sub_total', 'SUM({{attribute}})', 'revenue')
     * Example: ('sub_total', 'SUM({{revenue}})', 'revenue')
     *
     * For some functions like SUM use groupByAttribute.
     *
     * @param string $alias
     * @param string $expression
     * @param string $attribute
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addExpressionAttributeToSelect($alias, $expression, $attribute)
    {
        // validate alias
        if (isset($this->_joinFields[$alias])) {
            throw Mage::exception(
                'Mage_Eav',
                Mage::helper('eav')->__('Joint field or attribute expression with this alias is already declared')
            );
        }
        if (!is_array($attribute)) {
            $attribute = array($attribute);
        }

        $fullExpression = $expression;
        // Replacing multiple attributes
        foreach ($attribute as $attributeItem) {
            if (isset($this->_staticFields[$attributeItem])) {
                $attrField = sprintf('e.%s', $attributeItem);
            } else {
                $attributeInstance = $this->getAttribute($attributeItem);

                if ($attributeInstance->getBackend()->isStatic()) {
                    $attrField = 'e.' . $attributeItem;
                } else {
                    $this->_addAttributeJoin($attributeItem, 'left');
                    $attrField = $this->_getAttributeFieldName($attributeItem);
                }
            }

            $fullExpression = str_replace('{{attribute}}', $attrField, $fullExpression);
            $fullExpression = str_replace('{{' . $attributeItem . '}}', $attrField, $fullExpression);
        }

        $this->getSelect()->columns(array($alias => $fullExpression));

        $this->_joinFields[$alias] = array(
            'table' => false,
            'field' => $fullExpression
        );

        return $this;
    }


    /**
     * Groups results by specified attribute
     *
     * @param string|array $attribute
     */
    public function groupByAttribute($attribute)
    {
        if (is_array($attribute)) {
            foreach ($attribute as $attributeItem) {
                $this->groupByAttribute($attributeItem);
            }
        } else {
            if (isset($this->_joinFields[$attribute])) {
                $this->getSelect()->group($this->_getAttributeFieldName($attribute));
                return $this;
            }

            if (isset($this->_staticFields[$attribute])) {
                $this->getSelect()->group(sprintf('e.%s', $attribute));
                return $this;
            }

            if (isset($this->_joinAttributes[$attribute])) {
                $attrInstance = $this->_joinAttributes[$attribute]['attribute'];
                $entityField = $this->_getAttributeTableAlias($attribute) . '.' . $attrInstance->getAttributeCode();
            } else {
                $attrInstance = $this->getEntity()->getAttribute($attribute);
                $entityField = 'e.' . $attribute;
            }

            if ($attrInstance->getBackend()->isStatic()) {
                $this->getSelect()->group($entityField);
            } else {
                $this->_addAttributeJoin($attribute);
                $this->getSelect()->group($this->_getAttributeTableAlias($attribute).'.value');
            }
        }

        return $this;
    }

    /**
     * Add attribute from joined entity to select
     *
     * Examples:
     * ('billing_firstname', 'customer_address/firstname', 'default_billing')
     * ('billing_lastname', 'customer_address/lastname', 'default_billing')
     * ('shipping_lastname', 'customer_address/lastname', 'default_billing')
     * ('shipping_postalcode', 'customer_address/postalcode', 'default_shipping')
     * ('shipping_city', $cityAttribute, 'default_shipping')
     *
     * Developer is encouraged to use existing instances of attributes and entities
     * After first use of string entity name it will be cached in the collection
     *
     * @todo connect between joined attributes of same entity
     * @param string $alias alias for the joined attribute
     * @param string|Mage_Eav_Model_Entity_Attribute_Abstract $attribute
     * @param string $bind attribute of the main entity to link with joined $filter
     * @param string $filter primary key for the joined entity (entity_id default)
     * @param string $joinType inner|left
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function joinAttribute($alias, $attribute, $bind, $filter=null, $joinType='inner', $storeId=null)
    {
        // validate alias
        if (isset($this->_joinAttributes[$alias])) {
            throw Mage::exception(
                'Mage_Eav',
                Mage::helper('eav')->__('Invalid alias, already exists in joint attributes')
            );
        }

        // validate bind attribute
        if (is_string($bind)) {
            $bindAttribute = $this->getAttribute($bind);
        }

        if (!$bindAttribute || (!$bindAttribute->isStatic() && !$bindAttribute->getId())) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Invalid foreign key'));
        }

        // try to explode combined entity/attribute if supplied
        if (is_string($attribute)) {
            $attrArr = explode('/', $attribute);
            if (isset($attrArr[1])) {
                $entity    = $attrArr[0];
                $attribute = $attrArr[1];
            }
        }

        // validate entity
        if (empty($entity) && $attribute instanceof Mage_Eav_Model_Entity_Attribute_Abstract) {
            $entity = $attribute->getEntity();
        } elseif (is_string($entity)) {
            // retrieve cached entity if possible
            if (isset($this->_joinEntities[$entity])) {
                $entity = $this->_joinEntities[$entity];
            } else {
                $entity = Mage::getModel('eav/entity')->setType($attrArr[0]);
            }
        }
        if (!$entity || !$entity->getTypeId()) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Invalid entity type'));
        }

        // cache entity
        if (!isset($this->_joinEntities[$entity->getType()])) {
            $this->_joinEntities[$entity->getType()] = $entity;
        }

        // validate attribute
        if (is_string($attribute)) {
            $attribute = $entity->getAttribute($attribute);
        }
        if (!$attribute) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Invalid attribute type'));
        }

        if (empty($filter)) {
            $filter = $entity->getEntityIdField();
        }

        // add joined attribute
        $this->_joinAttributes[$alias] = array(
            'bind'          => $bind,
            'bindAttribute' => $bindAttribute,
            'attribute'     => $attribute,
            'filter'        => $filter,
            'store_id'      => $storeId,
        );

        $this->_addAttributeJoin($alias, $joinType);

        return $this;
    }

    /**
     * Join regular table field and use an attribute as fk
     *
     * Examples:
     * ('country_name', 'directory/country_name', 'name', 'country_id=shipping_country',
     *      "{{table}}.language_code='en'", 'left')
     *
     * @param string $alias 'country_name'
     * @param string $table 'directory/country_name'
     * @param string $field 'name'
     * @param string $bind 'PK(country_id)=FK(shipping_country_id)'
     * @param string|array $cond "{{table}}.language_code='en'" OR array('language_code'=>'en')
     * @param string $joinType 'left'
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function joinField($alias, $table, $field, $bind, $cond=null, $joinType='inner')
    {
        // validate alias
        if (isset($this->_joinFields[$alias])) {
            throw Mage::exception(
                'Mage_Eav',
                Mage::helper('eav')->__('Joined field with this alias is already declared')
            );
        }

        // validate table
        if (strpos($table, '/')!==false) {
            $table = Mage::getSingleton('core/resource')->getTableName($table);
        }
        $tableAlias = $this->_getAttributeTableAlias($alias);

        // validate bind
        list($pk, $fk) = explode('=', $bind);
        $pk = $this->getSelect()->getAdapter()->quoteColumnAs(trim($pk), null);
        $bindCond = $tableAlias . '.' . trim($pk) . '=' . $this->_getAttributeFieldName(trim($fk));

        // process join type
        switch ($joinType) {
            case 'left':
                $joinMethod = 'joinLeft';
                break;

            default:
                $joinMethod = 'join';
        }
        $condArr = array($bindCond);

        // add where condition if needed
        if ($cond !== null) {
            if (is_array($cond)) {
                foreach ($cond as $k=>$v) {
                    $condArr[] = $this->_getConditionSql($tableAlias.'.'.$k, $v);
                }
            } else {
                $condArr[] = str_replace('{{table}}', $tableAlias, $cond);
            }
        }
        $cond = '(' . implode(') AND (', $condArr) . ')';

        // join table
        $this->getSelect()
            ->$joinMethod(array($tableAlias => $table), $cond, ($field ? array($alias=>$field) : array()));

        // save joined attribute
        $this->_joinFields[$alias] = array(
            'table' => $tableAlias,
            'field' => $field,
        );

        return $this;
    }

    /**
     * Join a table
     *
     * @param string|array $table
     * @param string $bind
     * @param string|array $fields
     * @param null|array $cond
     * @param string $joinType
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function joinTable($table, $bind, $fields = null, $cond = null, $joinType = 'inner')
    {
        $tableAlias = null;
        if (is_array($table)) {
            list($tableAlias, $tableName) = each($table);
        } else {
            $tableName = $table;
        }

        // validate table
        if (strpos($tableName, '/') !== false) {
            $tableName = Mage::getSingleton('core/resource')->getTableName($tableName);
        }
        if (empty($tableAlias)) {
            $tableAlias = $tableName;
        }

        // validate fields and aliases
        if (!$fields) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Invalid joint fields'));
        }
        foreach ($fields as $alias=>$field) {
            if (isset($this->_joinFields[$alias])) {
                throw Mage::exception(
                    'Mage_Eav',
                    Mage::helper('eav')->__('A joint field with this alias (%s) is already declared', $alias)
                );
            }
            $this->_joinFields[$alias] = array(
                'table' => $tableAlias,
                'field' => $field,
            );
        }

        // validate bind
        list($pk, $fk) = explode('=', $bind);
        $bindCond = $tableAlias . '.' . $pk . '=' . $this->_getAttributeFieldName($fk);

        // process join type
        switch ($joinType) {
            case 'left':
                $joinMethod = 'joinLeft';
                break;

            default:
                $joinMethod = 'join';
        }
        $condArr = array($bindCond);

        // add where condition if needed
        if ($cond !== null) {
            if (is_array($cond)) {
                foreach ($cond as $k => $v) {
                    $condArr[] = $this->_getConditionSql($tableAlias.'.'.$k, $v);
                }
            } else {
                $condArr[] = str_replace('{{table}}', $tableAlias, $cond);
            }
        }
        $cond = '('.implode(') AND (', $condArr).')';

// join table
        $this->getSelect()->$joinMethod(array($tableAlias => $tableName), $cond, $fields);

        return $this;
    }

    /**
     * Remove an attribute from selection list
     *
     * @param string $attribute
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function removeAttributeToSelect($attribute = null)
    {
        if ($attribute === null) {
            $this->_selectAttributes = array();
        } else {
            unset($this->_selectAttributes[$attribute]);
        }
        return $this;
    }

    /**
     * Set collection page start and records to show
     *
     * @param integer $pageNum
     * @param integer $pageSize
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function setPage($pageNum, $pageSize)
    {
        $this->setCurPage($pageNum)
            ->setPageSize($pageSize);
        return $this;
    }

    /**
     * Load collection data into object items
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function load($printQuery = false, $logQuery = false)
    {
        if ($this->isLoaded()) {
            return $this;
        }
        Varien_Profiler::start('__EAV_COLLECTION_BEFORE_LOAD__');
        Mage::dispatchEvent('eav_collection_abstract_load_before', array('collection' => $this));
        $this->_beforeLoad();
        Varien_Profiler::stop('__EAV_COLLECTION_BEFORE_LOAD__');

        $this->_renderFilters();
        $this->_renderOrders();

        Varien_Profiler::start('__EAV_COLLECTION_LOAD_ENT__');
        $this->_loadEntities($printQuery, $logQuery);
        Varien_Profiler::stop('__EAV_COLLECTION_LOAD_ENT__');
        Varien_Profiler::start('__EAV_COLLECTION_LOAD_ATTR__');
        $this->_loadAttributes($printQuery, $logQuery);
        Varien_Profiler::stop('__EAV_COLLECTION_LOAD_ATTR__');

        Varien_Profiler::start('__EAV_COLLECTION_ORIG_DATA__');
        foreach ($this->_items as $item) {
            $item->setOrigData();
        }
        Varien_Profiler::stop('__EAV_COLLECTION_ORIG_DATA__');

        $this->_setIsLoaded();
        Varien_Profiler::start('__EAV_COLLECTION_AFTER_LOAD__');
        $this->_afterLoad();
        Varien_Profiler::stop('__EAV_COLLECTION_AFTER_LOAD__');
        return $this;
    }

    /**
     * Clone and reset collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getAllIdsSelect($limit = null, $offset = null)
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Zend_Db_Select::ORDER);
        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $idsSelect->reset(Zend_Db_Select::COLUMNS);
        $idsSelect->columns('e.' . $this->getEntity()->getIdFieldName());
        $idsSelect->limit($limit, $offset);

        return $idsSelect;
    }

    /**
     * Retrive all ids for collection
     *
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * Retrive all ids sql
     *
     * @return array
     */
    public function getAllIdsSql()
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Zend_Db_Select::ORDER);
        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $idsSelect->reset(Zend_Db_Select::COLUMNS);
        $idsSelect->reset(Zend_Db_Select::GROUP);
        $idsSelect->columns('e.'.$this->getEntity()->getIdFieldName());

        return $idsSelect;
    }

    /**
     * Save all the entities in the collection
     *
     * @todo make batch save directly from collection
     */
    public function save()
    {
        foreach ($this->getItems() as $item) {
            $item->save();
        }
        return $this;
    }


    /**
     * Delete all the entities in the collection
     *
     * @todo make batch delete directly from collection
     */
    public function delete()
    {
        foreach ($this->getItems() as $k=>$item) {
            $this->getEntity()->delete($item);
            unset($this->_items[$k]);
        }
        return $this;
    }

    /**
     * Import 2D array into collection as objects
     *
     * If the imported items already exist, update the data for existing objects
     *
     * @param array $arr
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function importFromArray($arr)
    {
        $entityIdField = $this->getEntity()->getEntityIdField();
        foreach ($arr as $row) {
            $entityId = $row[$entityIdField];
            if (!isset($this->_items[$entityId])) {
                $this->_items[$entityId] = $this->getNewEmptyItem();
                $this->_items[$entityId]->setData($row);
            } else {
                $this->_items[$entityId]->addData($row);
            }
        }
        return $this;
    }

    /**
     * Get collection data as a 2D array
     *
     * @return array
     */
    public function exportToArray()
    {
        $result = array();
        $entityIdField = $this->getEntity()->getEntityIdField();
        foreach ($this->getItems() as $item) {
            $result[$item->getData($entityIdField)] = $item->getData();
        }
        return $result;
    }

    /**
     * Retreive row id field name
     *
     * @return string
     */
    public function getRowIdFieldName()
    {
        if ($this->_idFieldName === null) {
            $this->_setIdFieldName($this->getEntity()->getIdFieldName());
        }
        return $this->getIdFieldName();
    }

    /**
     * Set row id field name
     * @param string $fieldName
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function setRowIdFieldName($fieldName)
    {
        return $this->_setIdFieldName($fieldName);
    }

    /**
     * Load entities records into items
     *
     * @throws Exception
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function _loadEntities($printQuery = false, $logQuery = false)
    {
        $entity = $this->getEntity();

        if ($this->_pageSize) {
            $this->getSelect()->limitPage($this->getCurPage(), $this->_pageSize);
        }

        $this->printLogQuery($printQuery, $logQuery);

        try {
            /**
             * Prepare select query
             * @var string $query
             */
            $query = $this->_prepareSelect($this->getSelect());
            $rows = $this->_fetchAll($query);
        } catch (Exception $e) {
            Mage::printException($e, $query);
            $this->printLogQuery(true, true, $query);
            throw $e;
        }

        foreach ($rows as $v) {
            $object = $this->getNewEmptyItem()
                ->setData($v);
            $this->addItem($object);
            if (isset($this->_itemsById[$object->getId()])) {
                $this->_itemsById[$object->getId()][] = $object;
            } else {
                $this->_itemsById[$object->getId()] = array($object);
            }
        }

        return $this;
    }

    /**
     * Load attributes into loaded entities
     *
     * @throws Exception
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function _loadAttributes($printQuery = false, $logQuery = false)
    {
        if (empty($this->_items) || empty($this->_itemsById) || empty($this->_selectAttributes)) {
            return $this;
        }

        $entity = $this->getEntity();

        $tableAttributes = array();
        $attributeTypes  = array();
        foreach ($this->_selectAttributes as $attributeCode => $attributeId) {
            if (!$attributeId) {
                continue;
            }
            $attribute = Mage::getSingleton('eav/config')->getCollectionAttribute($entity->getType(), $attributeCode);
            if ($attribute && !$attribute->isStatic()) {
                $tableAttributes[$attribute->getBackendTable()][] = $attributeId;
                if (!isset($attributeTypes[$attribute->getBackendTable()])) {
                    $attributeTypes[$attribute->getBackendTable()] = $attribute->getBackendType();
                }
            }
        }

        $selects = array();
        foreach ($tableAttributes as $table=>$attributes) {
            $select = $this->_getLoadAttributesSelect($table, $attributes);
            $selects[$attributeTypes[$table]][] = $this->_addLoadAttributesSelectValues(
                $select,
                $table,
                $attributeTypes[$table]
            );
        }
        $selectGroups = Mage::getResourceHelper('eav')->getLoadAttributesSelectGroups($selects);
        foreach ($selectGroups as $selects) {
            if (!empty($selects)) {
                try {
                    $select = implode(' UNION ALL ', $selects);
                    $values = $this->getConnection()->fetchAll($select);
                } catch (Exception $e) {
                    Mage::printException($e, $select);
                    $this->printLogQuery(true, true, $select);
                    throw $e;
                }

                foreach ($values as $value) {
                    $this->_setItemAttributeValue($value);
                }
            }
        }

        return $this;
    }

    /**
     * Retrieve attributes load select
     *
     * @param   string $table
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getLoadAttributesSelect($table, $attributeIds = array())
    {
        if (empty($attributeIds)) {
            $attributeIds = $this->_selectAttributes;
        }
        $helper = Mage::getResourceHelper('eav');
        $entityIdField = $this->getEntity()->getEntityIdField();
        $select = $this->getConnection()->select()
            ->from($table, array($entityIdField, 'attribute_id'))
            ->where('entity_type_id =?', $this->getEntity()->getTypeId())
            ->where("$entityIdField IN (?)", array_keys($this->_itemsById))
            ->where('attribute_id IN (?)', $attributeIds);
        return $select;
    }

    /**
     * @param Varien_Db_Select $select
     * @param string $table
     * @param string $type
     * @return Varien_Db_Select
     */
    protected function _addLoadAttributesSelectValues($select, $table, $type)
    {
        $helper = Mage::getResourceHelper('eav');
        $select->columns(array(
            'value' => $helper->prepareEavAttributeValue($table. '.value', $type),
        ));

        return $select;
    }

    /**
     * Initialize entity ubject property value
     *
     * $valueInfo is _getLoadAttributesSelect fetch result row
     *
     * @param   array $valueInfo
     * @throws Mage_Eav_Exception
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _setItemAttributeValue($valueInfo)
    {
        $entityIdField  = $this->getEntity()->getEntityIdField();
        $entityId       = $valueInfo[$entityIdField];
        if (!isset($this->_itemsById[$entityId])) {
            throw Mage::exception('Mage_Eav',
                Mage::helper('eav')->__('Data integrity: No header row found for attribute')
            );
        }
        $attributeCode = array_search($valueInfo['attribute_id'], $this->_selectAttributes);
        if (!$attributeCode) {
            $attribute = Mage::getSingleton('eav/config')->getCollectionAttribute(
                $this->getEntity()->getType(),
                $valueInfo['attribute_id']
            );
            $attributeCode = $attribute->getAttributeCode();
        }

        foreach ($this->_itemsById[$entityId] as $object) {
            $object->setData($attributeCode, $valueInfo['value']);
        }

        return $this;
    }

    /**
     * Get alias for attribute value table
     *
     * @param string $attributeCode
     * @return string
     */
    protected function _getAttributeTableAlias($attributeCode)
    {
        return 'at_' . $attributeCode;
    }

    /**
     * Retreive attribute field name by attribute code
     *
     * @param string $attributeCode
     * @return string
     */
    protected function _getAttributeFieldName($attributeCode)
    {
        $attributeCode = trim($attributeCode);
        if (isset($this->_joinAttributes[$attributeCode]['condition_alias'])) {
            return $this->_joinAttributes[$attributeCode]['condition_alias'];
        }
        if (isset($this->_staticFields[$attributeCode])) {
            return sprintf('e.%s', $attributeCode);
        }
        if (isset($this->_joinFields[$attributeCode])) {
            $attr = $this->_joinFields[$attributeCode];
            return $attr['table'] ? $attr['table'] . '.' . $attr['field'] : $attr['field'];
        }

        $attribute = $this->getAttribute($attributeCode);
        if (!$attribute) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Invalid attribute name: %s', $attributeCode));
        }

        if ($attribute->isStatic()) {
            if (isset($this->_joinAttributes[$attributeCode])) {
                $fieldName = $this->_getAttributeTableAlias($attributeCode) . '.' . $attributeCode;
            } else {
                $fieldName = 'e.' . $attributeCode;
            }
        } else {
            $fieldName = $this->_getAttributeTableAlias($attributeCode) . '.value';
        }

        return $fieldName;
    }

    /**
     * Add attribute value table to the join if it wasn't added previously
     *
     * @param   string $attributeCode
     * @param   string $joinType inner|left
     * @throws  Mage_Eav_Exception
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _addAttributeJoin($attributeCode, $joinType = 'inner')
    {
        if (!empty($this->_filterAttributes[$attributeCode])) {
            return $this;
        }

        $adapter = $this->getConnection();

        $attrTable = $this->_getAttributeTableAlias($attributeCode);
        if (isset($this->_joinAttributes[$attributeCode])) {
            $attribute      = $this->_joinAttributes[$attributeCode]['attribute'];
            $entity         = $attribute->getEntity();
            $entityIdField  = $entity->getEntityIdField();
            $fkName         = $this->_joinAttributes[$attributeCode]['bind'];
            $fkAttribute    = $this->_joinAttributes[$attributeCode]['bindAttribute'];
            $fkTable        = $this->_getAttributeTableAlias($fkName);

            if ($fkAttribute->getBackend()->isStatic()) {
                if (isset($this->_joinAttributes[$fkName])) {
                    $fk = $fkTable . '.' . $fkAttribute->getAttributeCode();
                } else {
                    $fk = 'e.' . $fkAttribute->getAttributeCode();
                }
            } else {
                $this->_addAttributeJoin($fkAttribute->getAttributeCode(), $joinType);
                $fk = $fkTable . '.value';
            }
            $pk = $attrTable . '.' . $this->_joinAttributes[$attributeCode]['filter'];
        } else {
            $entity         = $this->getEntity();
            $entityIdField  = $entity->getEntityIdField();
            $attribute      = $entity->getAttribute($attributeCode);
            $fk             = 'e.' . $entityIdField;
            $pk             = $attrTable . '.' . $entityIdField;
        }

        if (!$attribute) {
            throw Mage::exception('Mage_Eav', Mage::helper('eav')->__('Invalid attribute name: %s', $attributeCode));
        }

        if ($attribute->getBackend()->isStatic()) {
            $attrFieldName = $attrTable . '.' . $attribute->getAttributeCode();
        } else {
            $attrFieldName = $attrTable . '.value';
        }

        $fk = $adapter->quoteColumnAs($fk, null);
        $pk = $adapter->quoteColumnAs($pk, null);

        $condArr = array("$pk = $fk");
        if (!$attribute->getBackend()->isStatic()) {
            $condArr[] = $this->getConnection()->quoteInto(
                $adapter->quoteColumnAs("$attrTable.attribute_id", null) . ' = ?', $attribute->getId());
        }

        /**
         * process join type
         */
        $joinMethod = ($joinType == 'left') ? 'joinLeft' : 'join';

        $this->_joinAttributeToSelect($joinMethod, $attribute, $attrTable, $condArr, $attributeCode, $attrFieldName);

        $this->removeAttributeToSelect($attributeCode);
        $this->_filterAttributes[$attributeCode] = $attribute->getId();

        /**
         * Fix double join for using same as filter
         */
        $this->_joinFields[$attributeCode] = array(
            'table' => '',
            'field' => $attrFieldName,
        );

        return $this;
    }

    /**
     * Adding join statement to collection select instance
     *
     * @param   string $method
     * @param   object $attribute
     * @param   string $tableAlias
     * @param   array $condition
     * @param   string $fieldCode
     * @param   string $fieldAlias
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _joinAttributeToSelect($method, $attribute, $tableAlias, $condition, $fieldCode, $fieldAlias)
    {
        $this->getSelect()->$method(
            array($tableAlias => $attribute->getBackend()->getTable()),
            '('.implode(') AND (', $condition).')',
            array($fieldCode => $fieldAlias)
        );
        return $this;
    }

    /**
     * Get condition sql for the attribute
     *
     * @see self::_getConditionSql
     * @param string $attribute
     * @param mixed $condition
     * @param string $joinType
     * @return string
     */
    protected function _getAttributeConditionSql($attribute, $condition, $joinType = 'inner')
    {
        if (isset($this->_joinFields[$attribute])) {

            return $this->_getConditionSql($this->_getAttributeFieldName($attribute), $condition);
        }
        if (isset($this->_staticFields[$attribute])) {
            return $this->_getConditionSql($this->getConnection()->quoteIdentifier('e.' . $attribute), $condition);
        }
        // process linked attribute
        if (isset($this->_joinAttributes[$attribute])) {
            $entity      = $this->getAttribute($attribute)->getEntity();
            $entityTable = $entity->getEntityTable();
        } else {
            $entity      = $this->getEntity();
            $entityTable = 'e';
        }

        if ($entity->isAttributeStatic($attribute)) {
            $conditionSql = $this->_getConditionSql(
                $this->getConnection()->quoteIdentifier('e.' . $attribute),
                $condition
            );
        } else {
            $this->_addAttributeJoin($attribute, $joinType);
            if (isset($this->_joinAttributes[$attribute]['condition_alias'])) {
                $field = $this->_joinAttributes[$attribute]['condition_alias'];
            } else {
                $field = $this->_getAttributeTableAlias($attribute) . '.value';

            }

            $conditionSql = $this->_getConditionSql($field, $condition);
        }

        return $conditionSql;
    }

    /**
     * Set sorting order
     *
     * $attribute can also be an array of attributes
     *
     * @param string|array $attribute
     * @param string $dir
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function setOrder($attribute, $dir = self::SORT_ORDER_ASC)
    {
        if (is_array($attribute)) {
            foreach ($attribute as $attr) {
                parent::setOrder($attr, $dir);
            }
        }
        return parent::setOrder($attribute, $dir);
    }

    /**
     * Retreive array of attributes
     *
     * @param array $arrAttributes
     * @return array
     */
    public function toArray($arrAttributes = array())
    {
        $arr = array();
        foreach ($this->_items as $k => $item) {
            $arr[$k] = $item->toArray($arrAttributes);
        }
        return $arr;
    }

    /**
     * Treat "order by" items as attributes to sort
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _renderOrders()
    {
        if (!$this->_isOrdersRendered) {
            foreach ($this->_orders as $attribute => $direction) {
                $this->addAttributeToSort($attribute, $direction);
            }
            $this->_isOrdersRendered = true;
        }
        return $this;
    }

    /**
     * After load method
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _afterLoad()
    {
        return $this;
    }

    /**
     * Reset collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _reset()
    {
        parent::_reset();

        $this->_selectEntityTypes = array();
        $this->_selectAttributes  = array();
        $this->_filterAttributes  = array();
        $this->_joinEntities      = array();
        $this->_joinAttributes    = array();
        $this->_joinFields        = array();

        return $this;
    }

    /**
     * Returns already loaded element ids
     *
     * return array
     */
    public function getLoadedIds()
    {
        return array_keys($this->_items);
    }

    /**
     * Prepare select for load
     *
     * @param Varien_Db_Select $select OPTIONAL
     * @return string
     */
    public function _prepareSelect(Varien_Db_Select $select)
    {
        if ($this->_useAnalyticFunction) {
            $helper = Mage::getResourceHelper('core');
            return $helper->getQueryUsingAnalyticFunction($select);
        }

        return (string)$select;
    }
}
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
 * @package     Mage_Customer
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Customers collection
 *
 * @category    Mage
 * @package     Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Customer_Model_Resource_Customer_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('customer/customer');
    }

    /**
     * Group result by customer email
     *
     * @return Mage_Customer_Model_Resource_Customer_Collection
     */
    public function groupByEmail()
    {
        $this->getSelect()
            ->from(
                array('email' => $this->getEntity()->getEntityTable()),
                array('email_count' => new Zend_Db_Expr('COUNT(email.entity_id)'))
            )
            ->where('email.entity_id = e.entity_id')
            ->group('email.email');

        return $this;
    }

    /**
     * Add Name to select
     *
     * @return Mage_Customer_Model_Resource_Customer_Collection
     */
    public function addNameToSelect()
    {
        $fields = array();
        $customerAccount = Mage::getConfig()->getFieldset('customer_account');
        foreach ($customerAccount as $code => $node) {
            if ($node->is('name')) {
                $fields[$code] = $code;
            }
        }

        $adapter = $this->getConnection();
        $concatenate = array();
        if (isset($fields['prefix'])) {
            $concatenate[] = $adapter->getCheckSql(
                '{{prefix}} IS NOT NULL AND {{prefix}} != \'\'',
                $adapter->getConcatSql(array('LTRIM(RTRIM({{prefix}}))', '\' \'')),
                '\'\'');
        }
        $concatenate[] = 'LTRIM(RTRIM({{firstname}}))';
        $concatenate[] = '\' \'';
        if (isset($fields['middlename'])) {
            $concatenate[] = $adapter->getCheckSql(
                '{{middlename}} IS NOT NULL AND {{middlename}} != \'\'',
                $adapter->getConcatSql(array('LTRIM(RTRIM({{middlename}}))', '\' \'')),
                '\'\'');
        }
        $concatenate[] = 'LTRIM(RTRIM({{lastname}}))';
        if (isset($fields['suffix'])) {
            $concatenate[] = $adapter
                    ->getCheckSql('{{suffix}} IS NOT NULL AND {{suffix}} != \'\'',
                $adapter->getConcatSql(array('\' \'', 'LTRIM(RTRIM({{suffix}}))')),
                '\'\'');
        }

        $nameExpr = $adapter->getConcatSql($concatenate);

        $this->addExpressionAttributeToSelect('name', $nameExpr, $fields);

        return $this;
    }

    /**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $select = parent::getSelectCountSql();
        $select->resetJoinLeft();

        return $select;
    }

    /**
     * Reset left join
     *
     * @param int $limit
     * @param int $offset
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getAllIdsSelect($limit = null, $offset = null)
    {
        $idsSelect = parent::_getAllIdsSelect($limit, $offset);
        $idsSelect->resetJoinLeft();
        return $idsSelect;
    }
}
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
 * @package     Mage_Customer
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Customers collection
 *
 * @category    Mage
 * @package     Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Customer_Model_Entity_Customer_Collection extends Mage_Customer_Model_Resource_Customer_Collection
{
}
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
class Rewardpoints_Model_Mysql4_Customer_Collection extends Mage_Customer_Model_Entity_Customer_Collection
{
    public function restrictRewardPoints()
    {

        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', Mage::app()->getStore()->getId());

        $order_states = explode(",", $statuses);

        //parent::_initSelect();
        $select = $this->getSelect();
        $select
            ->from($this->getTable('rewardpoints/rewardpoints_account'),array(new Zend_Db_Expr('SUM('.$this->getTable('rewardpoints/rewardpoints_account').'.points_current) AS all_points_accumulated'),new Zend_Db_Expr('SUM('.$this->getTable('rewardpoints/rewardpoints_account').'.points_spent) AS all_points_spent')))
            ->where($this->getTable('rewardpoints/rewardpoints_account').'.customer_id = e.entity_id');

        
        $sql_share = "";
        if (class_exists (J2t_Rewardshare_Model_Stats)){
            $sql_share = $this->getTable('rewardpoints/rewardpoints_account').".order_id = '".J2t_Rewardshare_Model_Stats::TYPE_POINTS_SHARE."' or";
        }

        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            $select->where(" ($sql_share ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."' or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'
                   or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id in  (SELECT increment_id
                       FROM ".$this->getTable('sales/order')." AS orders
                       WHERE orders.$status_field IN (?))
                 ) ", $order_states);
        } else {
            $table_sales_order = $this->getTable('sales/order').'_varchar';
            $select->where(" ($sql_share ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."' or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'
                   or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id in (SELECT increment_id
                                       FROM ".$this->getTable('sales/order')." AS orders
                                       WHERE orders.entity_id IN (
                                           SELECT order_state.entity_id
                                           FROM ".$table_sales_order." AS order_state
                                           WHERE order_state.value <> 'canceled'
                                           AND order_state.value in (?))
                                        ) ) ", $order_states);
        }


        //v.2.0.0
        if (Mage::getStoreConfig('rewardpoints/default/points_delay', Mage::app()->getStore()->getId())){
            $this->getSelect()->where('( NOW() >= '.$this->getTable('rewardpoints/rewardpoints_account').'.date_start OR '.$this->getTable('rewardpoints/rewardpoints_account').'.date_start IS NULL)');
        }
        
        if (Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId())){
            $select->where('( '.$this->getTable('rewardpoints/rewardpoints_account').'.date_end >= NOW() OR '.$this->getTable('rewardpoints/rewardpoints_account').'.date_end IS NULL)');
        }

        $select->group($this->getTable('rewardpoints/rewardpoints_account').'.customer_id');

        /*echo $this->getSelect()->__toString();
        die;*/
        
        return $this;
    }

}
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
class Rewardpoints_Model_Mysql4_Pointrules extends Mage_Core_Model_Mysql4_Abstract
{
    const SECONDS_IN_DAY = 86400;

    public function _construct()
    {    
        $this->_init('rewardpoints/pointrules', 'rule_id');
    }
    
    /**
     * Prepare object data for saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    public function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getFromDate()) {
            $date = Mage::app()->getLocale()->date();
            $date->setHour(0)
                ->setMinute(0)
                ->setSecond(0);
            $object->setFromDate($date);
        }
        if ($object->getFromDate() instanceof Zend_Date) {
            $object->setFromDate($object->getFromDate()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
        }
       

        if (!$object->getToDate()) {
            $object->setToDate(new Zend_Db_Expr('NULL'));
        }
        else {
            if ($object->getToDate() instanceof Zend_Date) {
                $object->setToDate($object->getToDate()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
            }
        }
        parent::_beforeSave($object);
    }
}
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

class Rewardpoints_Model_Mysql4_Pointrules_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
	parent::_construct();
        $this->_init('rewardpoints/pointrules');
    }


    public function setValidationFilter($websiteId, $customerGroupId, $now=null)
    {
        if (is_null($now)) {
            $now = Mage::getModel('core/date')->date('Y-m-d');
        }

        $this->getSelect()->where('status=1');
        $this->getSelect()->where('find_in_set(?, website_ids)', (int)$websiteId);
        $this->getSelect()->where('find_in_set(?, customer_group_ids)', (int)$customerGroupId);

        $this->getSelect()->where('from_date is null or from_date<=?', $now);
        $this->getSelect()->where('to_date is null or to_date>=?', $now);
        $this->getSelect()->order('sort_order');

        return $this;
    }

    /**
     * Filter collection by specified website IDs
     *
     * @param int|array $websiteIds
     * @return Mage_CatalogRule_Model_Mysql4_Rule_Collection
     */
    public function addWebsiteFilter($websiteIds)
    {
        if (!is_array($websiteIds)) {
            $websiteIds = array($websiteIds);
        }
        $parts = array();
        foreach ($websiteIds as $websiteId) {
            $parts[] = $this->getConnection()->quoteInto('FIND_IN_SET(?, main_table.website_ids)', $websiteId);
        }
        if ($parts) {
            $this->getSelect()->where(new Zend_Db_Expr(implode(' OR ', $parts)));
        }
        return $this;
    }
}
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
class Rewardpoints_Model_Mysql4_Referral extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('rewardpoints/referral', 'rewardpoints_referral_id');
    }

    public function loadByEmail($customerEmail)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('rewardpoints/rewardpoints_referral'))
            ->where('rewardpoints_referral_email = ?',$customerEmail);
        $result = $this->_getReadAdapter()->fetchRow($select);
        if(!$result) {
            return array();
        }

        return $result;
    }
    
    //J2T Check referral
    public function loadByChildId($child_id)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('rewardpoints/rewardpoints_referral'))
            ->where('rewardpoints_referral_child_id = ?',$child_id);
        $result = $this->_getReadAdapter()->fetchRow($select);
        if(!$result) {
            return array();
        }
        

        return $result;
    }
    
}
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
class Rewardpoints_Model_Mysql4_Referral_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/referral');
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $select = $this->getSelect();
        $select->join(
            array('cust' => $this->getTable('rewardpoints/customer_entity')),
            'rewardpoints_referral_parent_id = cust.entity_id'
        );
        return $this;
    }

    public function addEmailFilter($email)
    {
        $this->getSelect()->where('rewardpoints_referral_email = ?', $email);
        return $this;
    }

    public function addFlagFilter($status)
    {
        $this->getSelect()->where('rewardpoints_referral_status = ?', $status);
        return $this;
    }

    public function addClientFilter($id)
    {
        $this->getSelect()->where('rewardpoints_referral_parent_id = ?', $id);
        return $this;
    }
}
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
class Rewardpoints_Model_Mysql4_Rewardpoints extends Rewardpoints_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('rewardpoints/rewardpoints_account', 'rewardpoints_account_id');
    }
}
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
class Rewardpoints_Model_Mysql4_Rewardpoints_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_selectedColumns = array(
        'rewardpoints_account_id'   => 'rewardpoints_account_id',
        'customer_id'               => 'customer_id',
        'cust.email'                     => 'cust.email',
        'order_id'                  => 'order_id',
        'points_current'            => 'points_current',
        'points_spent'              => 'points_spent',
        'rewardpoints_description'  => 'rewardpoints_description',
        'store_ids'       => 'main_table.store_id'
    );

    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/stats');
    }


    

    protected function _initSelect()
    {
        /*parent::_initSelect();
        
        $select = $this->getSelect();
        $select->join(
            array('cust' => $this->getTable('rewardpoints/customer_entity')),
            'customer_id = cust.entity_id'
        );
        return $this;*/

        $select = $this->getSelect();
        //$select->from(array('main_table' => $this->getMainTable()), $this->_selectedColumns);
        //$select->from(array('main_table' => $this->getTable('rewardpoints/stats')), $this->_selectedColumns);
        $select->from(array('main_table' => $this->getResource()->getMainTable()), $this->_selectedColumns);

        $select->join(
            array('cust' => $this->getTable('rewardpoints/customer_entity')),
            'main_table.customer_id = cust.entity_id'
        );

        return $this;
    }


    public function joinUser()
    {
        /*$this->getSelect()->join(
            array('cust' => $this->getTable('j2tbooster/customer_entity')),
            'main_table.customer_id = cust.entity_id'
        );*/

        $this->getSelect()
            ->joinLeft($this->getTable('j2tbooster/customer_entity'),
                $this->getTable('j2tbooster/customer_entity').".entity_id=main_table.customer_id",
            array('email'));


        return $this;
    }


    public function joinValidOrders($customer_id)
    {
        $order_states = array("processing","complete","new");
        
        $this->getSelect()->joinLeft(
            array('ord' => $this->getTable('sales/order')),
            'main_table.order_id = ord.entity_id'
        );

        $this->getSelect()->where('ord.customer_id = ?', $customer_id);
        $this->getSelect()->where('state in (?)', $order_states);


        return $this;
    }

    public function addCustomerFilter($id)
    {
        $this->getSelect()->where('customer_id = ?', $id);
        return $this;
    }

    public function addOrderFilter($id)
    {
        $this->getSelect()->where('order_id = ?', $id);
        return $this;
    }
    
    public function addStoreFilter($id)
    {
        //$this->getSelect()->where('main_table.store_id in (?)', $id);
        $this->getSelect()->where('FIND_IN_SET(?, main_table.store_id) > 0', $id);
        return $this;
    }
    
    /*public function groupByCustomer()
    {
        $this->group('main_table.customer_id');
        return $this;
    }*/



    public function addStoreData()
    {
        foreach ($this as $item) {
            $item->setStores(explode(',',$item->getStoreIds()));
        }

        return $this;
    }


    public function addFieldToFilter($field, $condition=null)
    {
        if ($field == 'stores') {
            return $this->addStoresFilter($condition);
        }
        else {
            return parent::addFieldToFilter($field, $condition);
        }
    }


    public function addStoresFilter($store)
    {
        return $this->addStoreFilter($store);
    }


    


}
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
class Rewardpoints_Model_Mysql4_Rules extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('rewardpoints/rules', 'rewardpoints_rule_id');
        
    }
}
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
class Rewardpoints_Model_Mysql4_Rules_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/rules');
    }


    public function setValidationFilter($websiteId, $now = null)
    {
        if (is_null($now)) {
            $now = Mage::getModel('core/date')->date('Y-m-d');
        }
 
        $this->getSelect()->where('rewardpoints_rule_activated=1');
        $this->getSelect()->where('find_in_set(?, website_ids)', (int)$websiteId);
        //$this->getSelect()->where('find_in_set(?, customer_group_ids)', (int)$customerGroupId);

        $this->getSelect()->where('rewardpoints_rule_start is null or rewardpoints_rule_start<=?', $now);
        $this->getSelect()->where('rewardpoints_rule_end is null or rewardpoints_rule_end>=?', $now);
        //$this->getSelect()->order('sort_order');

        return $this;

    }


}
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
class Rewardpoints_Model_Mysql4_Stats extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('rewardpoints/stats', 'rewardpoints_account_id');
    }
    
    //J2T Check referral
    public function loadByReferralId($referral_id, $referral_customer_id = null)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('rewardpoints/rewardpoints_account'))
            ->where('rewardpoints_referral_id = ?',$referral_id);
        
        if ($referral_customer_id != null){
            $select->where('customer_id <> ?', $referral_customer_id);
        }        
        $result = $this->_getReadAdapter()->fetchRow($select);        
        if(!$result) {
            return array();
        }

        return $result;
    }
    
    public function getExtension($file_name)
    {
        return substr($file_name, strrpos($file_name, '.')+1);
    }
    
    public function uploadImage(Varien_Object $object)
    {
        $imageFileSmall = $_FILES['groups']['tmp_name']['design']['fields']['small_inline_image']['value'];
        $imageFileBig = $_FILES['groups']['tmp_name']['design']['fields']['big_inline_image']['value'];
        
        $absolute_path = Mage::getBaseDir('media') . DS ; 
        $relative_path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA); 
        
        if (!empty($imageFileSmall)) {
            //Mage::getDesign()->getSkinBaseDir() . DS . 'images' . DS . 'widget';
            
            // File Upload 
            try {
                $file = array();
                $file['tmp_name'] = $_FILES['groups']['tmp_name']['design']['fields']['small_inline_image']['value'];
                $file['name'] = $_FILES['groups']['name']['design']['fields']['small_inline_image']['value'];
                
                $uploader = new Varien_File_Uploader($file);
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false); 
                $test = $uploader->save($absolute_path, 'j2t_image_small.'.$this->getExtension($file['name']));
                $resizeFolder="j2t_resized";
                $imageResizedPath=Mage::getBaseDir("media").DS.$resizeFolder.DS.'j2t_image_small.'.$this->getExtension($file['name']);
                if(is_file($imageResizedPath)){
                    unlink($imageResizedPath);
                }
                if (!$test){
                    $message = Mage::helper('rewardpoints')->__('Error when submitting image');
                    Mage::getSingleton('adminhtml/session')->addError($message);
                }
                
                
            } 
            catch(Exception $e) { 
                /*Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return $this;*/
            } 
            // Your uploaded file Url will be 
            //echo $file_url = $relative_path.$files; 
        }
        
        if (!empty($imageFileBig)) {
            // File Upload 
            try { 
                $file = array();
                $file['tmp_name'] = $_FILES['groups']['tmp_name']['design']['fields']['big_inline_image']['value'];
                $file['name'] = $_FILES['groups']['name']['design']['fields']['big_inline_image']['value'];
                
                $uploader = new Varien_File_Uploader($file);
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false); 
                $test = $uploader->save($absolute_path, 'j2t_image_big.'.$this->getExtension($file['name']));
                $imageResizedPath=Mage::getBaseDir("media").DS.$resizeFolder.DS.'j2t_image_big.'.$this->getExtension($file['name']);
                if(is_file($imageResizedPath)){
                    unlink($imageResizedPath);
                }
                if (!$test){
                    $message = Mage::helper('rewardpoints')->__('Error when submitting image');
                    Mage::getSingleton('adminhtml/session')->addError($message);
                }
            } 
            catch(Exception $e) { 
                /*Mage::getSingleton('adminhtml/session')->addError($e->getMessage()); 
                return $this;*/
            } 
        }
    }


    public function uploadAndImport(Varien_Object $object)
    {
	$field_email_id = Mage::getStoreConfig('rewardpoints/dataflow_profile/field_email');
        $field_points_id = Mage::getStoreConfig('rewardpoints/dataflow_profile/field_points');
        $field_order_id = Mage::getStoreConfig('rewardpoints/dataflow_profile/field_order');
        $field_store_id = Mage::getStoreConfig('rewardpoints/dataflow_profile/field_store');
        
        if (!isset($_FILES['groups'])) {
            return false;
        }
        $csvFile = $_FILES['groups']['tmp_name']['dataflow_profile']['fields']['import']['value'];

        if (!empty($csvFile)) {
            $csv = trim(file_get_contents($csvFile));
            $table = Mage::getSingleton('core/resource')->getTableName('rewardpoints/rewardpoints_account');

            $websiteId = $object->getScopeId();
            $websiteModel = Mage::app()->getWebsite($websiteId);

            $websiteStores = $websiteModel->getStores();

            $storeIds = array();
            foreach ($websiteStores as $store) {
                /*if (!$store->getIsActive()) {
                    continue;
                }*/
                $storeIds[] = $store->getId();
            }
            

            if (!empty($csv)) {
                $exceptions = array();
                $csvLines = explode("\n", $csv);
                $csvLine = array_shift($csvLines);
                $csvLine = $this->_getCsvValues($csvLine);

                if (count($csvLine) < 3) {
                    $exceptions[0] = Mage::helper('rewardpoints')->__('Invalid File Format');
                }

                $emailAddress = array();
                //$regionCodes = array();
                foreach ($csvLines as $k=>$csvLine) {
                    $csvLine = $this->_getCsvValues($csvLine);
                    if (count($csvLine) > 0 && count($csvLine) < 3) {
                        $exceptions[0] = Mage::helper('rewardpoints')->__('Invalid File Format');
                    } /*else {
                        $emailAddress[] = $csvLine[$field_email_id];
                    }*/
                }

                if (empty($exceptions)) {
                    $data = array();
                    $emailAddressToIds = array();
                    $k = 0;
                    
                    $processed = 0;
                    
                    foreach ($csvLines as $k=>$csvLine) {
                        $csvLine = $this->_getCsvValues($csvLine);

                        $customer = null;
                        $customer_id = '';
                        $points = '';
                        $order_id = '';
                        $store_id = '';
                        
                        $error_found = false;
                        
                        if (!isset($csvLine[$field_email_id])) {
                            $exceptions[] = Mage::helper('rewardpoints')->__('Email address is missing in the Row #%s', ($k+1));
                            $error_found = true;
                        } else {
                            $customer = Mage::getModel('customer/customer')->setWebsiteId($websiteId)->loadByEmail($csvLine[$field_email_id]);

                            if ($customer == null) {
                                $exceptions[] = Mage::helper('rewardpoints')->__('Invalid email address "%s" in the Row #%s (customer might not exist)', $csvLine[$field_email_id], ($k+1));
                                $error_found = true;
                            } else {
                                $customer_id = $customer->getId();
                            }
                        }

                        if (!isset($csvLine[$field_points_id])) {
                            $exceptions[] = Mage::helper('rewardpoints')->__('Points missing in the Row #%s', ($k+1));
                            $error_found = true;
                        } else {
                            if (!is_numeric($csvLine[$field_points_id])) {
                                $exceptions[] = Mage::helper('rewardpoints')->__('Invalid point format "%s" in the Row #%s', $csvLine[$field_points_id], ($k+1));
                                $error_found = true;
                            } else {
                                $points = $csvLine[$field_points_id];
                            }
                        }

                        if ($field_order_id < 0){
                            $order_id = $field_order_id;
                        } else {
                            if (!isset($csvLine[$field_order_id])) {
                                $exceptions[] = Mage::helper('rewardpoints')->__('Order id missing in the Row #%s', ($k+1));
                                $error_found = true;
                                
                            } else{
                                $order_id = $csvLine[$field_order_id];
                                $order_check = Mage::getModel('sales/order')->loadByIncrementId($order_id);
                                if (!$order_check->getId()){
                                    $exceptions[] = Mage::helper('rewardpoints')->__('Invalid order Id "%s" in the Row #%s', $order_id, ($k+1));
                                    $error_found = true;
                                }
                            }
                        }

                        if ($field_store_id == -1){
                            $store_id = implode(',',$storeIds);
                        } else {
                            if (!isset($csvLine[$field_store_id])) {
                                $exceptions[] = Mage::helper('rewardpoints')->__('Store id(s) missing in the Row #%s', ($k+1));
                                $error_found = true;
                            } else {
                                $store_id = $csvLine[$field_store_id];
                            }
                        }
                        
                        if (!$error_found){
                            if ($points > 0){
                                $data[] = array('customer_id' => $customer_id, 'store_id' => $store_id, 'points_current' => $points, 'order_id' => $order_id);
                            } else {
                                $data[] = array('customer_id' => $customer_id, 'store_id' => $store_id, 'points_spent' => $points, 'order_id' => $order_id);
                            }
                        }
                        
                        $k++;
                        
                    }
                }
                
                
                if (sizeof($data)) {
                    
                    foreach($data as $k=>$dataLine) {
                        
                        try {
                            $this->_getWriteAdapter()->insert($table, $dataLine);
                        } catch (Exception $e) {
                            $exceptions[] = Mage::helper('rewardpoints')->__('Problem importing Row #%s (customer "%s")', ($k+1), $dataDetails[$k]['customer_id']);
                        }
                    }
                }
                
                if (sizeof($data)){
                    $this->_getWriteAdapter()->commit();
                    $message = Mage::helper('rewardpoints')->__('%s line(s) processed', sizeof($data));
                    Mage::getSingleton('adminhtml/session')->addSuccess($message);
                }

                if (!empty($exceptions)) {
                    //throw new Exception( "<br />" . implode("<br />", $exceptions) );
                    Mage::getSingleton('adminhtml/session')->addError(implode("<br />", $exceptions));
                } else {
                    $message = Mage::helper('rewardpoints')->__('%s line(s) processed', sizeof($data));
                    Mage::getSingleton('adminhtml/session')->addSuccess($message);
                }
            }
        }
        return $this;
    }

    protected function _getCsvValues($string, $separator=",")
    {
        
        $elements = explode($separator, trim($string));
        for ($i = 0; $i < count($elements); $i++) {
            $nquotes = substr_count($elements[$i], '"');
            if ($nquotes %2 == 1) {
                for ($j = $i+1; $j < count($elements); $j++) {
                    if (substr_count($elements[$j], '"') > 0) {
                        // Put the quoted string's pieces back together again
                        array_splice($elements, $i, $j-$i+1, implode($separator, array_slice($elements, $i, $j-$i+1)));
                        break;
                    }
                }
            }
            if ($nquotes > 0) {
                // Remove first and last quotes, then merge pairs of quotes
                $qstr =& $elements[$i];
                $qstr = substr_replace($qstr, '', strpos($qstr, '"'), 1);
                $qstr = substr_replace($qstr, '', strrpos($qstr, '"'), 1);
                $qstr = str_replace('""', '"', $qstr);
            }
            $elements[$i] = trim($elements[$i]);
        }
        return $elements;
        
    }

    protected function _isPositiveDecimalNumber($n)
    {
        return preg_match ("/^[0-9]+(\.[0-9]*)?$/", $n);
    }


}
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
 * @copyright  Copyright (c) 2011 J2T DESIGN. (http://www.j2t-design.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Rewardpoints_Model_Mysql4_Stats_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_countAttribute = 'main_table.customer_id';
    //main_table.rewardpoints_account_id
    protected $_allowDisableGrouping = true;

    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/stats');
    }

    public function setCountAttribute($value)
    {
        $this->_countAttribute = $value;
        return $this;
    }


    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();

        if ($this->_allowDisableGrouping) {
            $countSelect->reset(Zend_Db_Select::COLUMNS);
            $countSelect->reset(Zend_Db_Select::GROUP);
            $countSelect->columns('COUNT(DISTINCT ' . $this->getCountAttribute() . ')');
        }
        return $countSelect;
    }

    public function getCountAttribute()
    {
        return $this->_countAttribute;
    }



    public function addListRestriction()
    {
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', Mage::app()->getStore()->getId());

        $order_states = explode(",", $statuses);

        parent::_initSelect();
        $select = $this->getSelect();


        $select
            ->from($this->getTable('rewardpoints/rewardpoints_account'),array(new Zend_Db_Expr('SUM('.$this->getTable('rewardpoints/rewardpoints_account').'.points_current) AS all_points_accumulated'),new Zend_Db_Expr('SUM('.$this->getTable('rewardpoints/rewardpoints_account').'.points_spent) AS all_points_spent')))
            ->where($this->getTable('rewardpoints/rewardpoints_account').'.customer_id = e.entity_id');


        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            $select->where(" (".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."' or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'
                   or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id in  (SELECT increment_id
                       FROM ".$this->getTable('sales/order')." AS orders
                       WHERE orders.$status_field IN (?))
                 ) ", $order_states);
        } else {
            $table_sales_order = $this->getTable('sales/order').'_varchar';
            $select->where(" (".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."' or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."'
                   or ".$this->getTable('rewardpoints/rewardpoints_account').".order_id in (SELECT increment_id
                                       FROM ".$this->getTable('sales/order')." AS orders
                                       WHERE orders.entity_id IN (
                                           SELECT order_state.entity_id
                                           FROM ".$table_sales_order." AS order_state
                                           WHERE order_state.value <> 'canceled'
                                           AND order_state.value in (?))
                                        ) ) ", $order_states);
        }


        //v.2.0.0
        if (Mage::getStoreConfig('rewardpoints/default/points_delay', Mage::app()->getStore()->getId())){
            $this->getSelect()->where('( NOW() >= '.$this->getTable('rewardpoints/rewardpoints_account').'.date_start OR '.$this->getTable('rewardpoints/rewardpoints_account').'.date_start IS NULL)');
        }

        if (Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId())){
            $select->where('( '.$this->getTable('rewardpoints/rewardpoints_account').'.date_end >= NOW() OR '.$this->getTable('rewardpoints/rewardpoints_account').'.date_end IS NULL)');
        }

        $select->group($this->getTable('rewardpoints/rewardpoints_account').'.customer_id');


        return $this;
    }




    public function setPriorityOrder($dir = 'ASC')
    {
        $this->setOrder('main_table.priority', $dir);
        return $this;
    }

    public function addClientFilter($id)
    {
        $this->_countAttribute = 'main_table.rewardpoints_account_id';
        $this->getSelect()->where('customer_id = ?', $id);
        return $this;
    }


    public function groupByCustomer()
    {
        //$this->groupByAttribute('customer_id');
        $this->getSelect()->group('main_table.customer_id');
        $this->_allowDisableGrouping = false;

        return $this;
    }

    public function addFinishFilter($days)
    {
        //for example, DATEDIFF('1997-12-30','1997-12-25') returns 5
        $this->getSelect()->where('( DATEDIFF(main_table.date_end, NOW()) = ? AND main_table.date_end IS NOT NULL)', $days);
        return $this;
    }


    public function showCustomerInfo()
    {
        $customer = Mage::getModel('customer/customer');
        /* @var $customer Mage_Customer_Model_Customer */
        $firstname  = $customer->getAttribute('firstname');
        $lastname   = $customer->getAttribute('lastname');

//        $customersCollection = Mage::getModel('customer/customer')->getCollection();
//        /* @var $customersCollection Mage_Customer_Model_Entity_Customer_Collection */
//        $firstname = $customersCollection->getAttribute('firstname');
//        $lastname  = $customersCollection->getAttribute('lastname');

        $this->getSelect()
            ->joinLeft(
                array('customer_lastname_table'=>$lastname->getBackend()->getTable()),
                'customer_lastname_table.entity_id=main_table.customer_id
                 AND customer_lastname_table.attribute_id = '.(int) $lastname->getAttributeId() . '
                 ',
                array('customer_lastname'=>'value')
            )
            ->joinLeft(
                array('customer_firstname_table'=>$firstname->getBackend()->getTable()),
                'customer_firstname_table.entity_id=main_table.customer_id
                 AND customer_firstname_table.attribute_id = '.(int) $firstname->getAttributeId() . '
                 ',
                array('customer_firstname'=>'value')
            );



        return $this;
    }



    public function joinEavTablesIntoCollection($mainTableForeignKey, $eavType){


        $entityType = Mage::getModel('eav/entity_type')->loadByCode($eavType);
        $attributes = $entityType->getAttributeCollection();
        $entityTable = $this->getTable($entityType->getEntityTable());

        //Use an incremented index to make sure all of the aliases for the eav attribute tables are unique.
        $index = 1;


        $fields = array();
        foreach (Mage::getConfig()->getFieldset('customer_account') as $code=>$node) {
            if ($node->is('name')) {
                //$this->addAttributeToSelect($code);
                $fields[$code] = $code;
            }
        }

        $expr = 'CONCAT('
            .(isset($fields['prefix']) ? 'IF({{prefix}} IS NOT NULL AND {{prefix}} != "", CONCAT({{prefix}}," "), ""),' : '')
            .'{{firstname}}'.(isset($fields['middlename']) ?  ',IF({{middlename}} IS NOT NULL AND {{middlename}} != "", CONCAT(" ",{{middlename}}), "")' : '').'," ",{{lastname}}'
            .(isset($fields['suffix']) ? ',IF({{suffix}} IS NOT NULL AND {{suffix}} != "", CONCAT(" ",{{suffix}}), "")' : '')
            .')';


        foreach ($attributes->getItems() as $attribute){
            $alias = 'table'.$index;
            if ($attribute->getBackendType() != 'static'){
                $table = $entityTable. '_'.$attribute->getBackendType();
                $field = $alias.'.value';
                $this->getSelect()
                    ->joinLeft(array($alias => $table),
                        'main_table.'.$mainTableForeignKey.' = '.$alias.'.entity_id and '.$alias.'.attribute_id = '.$attribute->getAttributeId(),
                        array($attribute->getAttributeCode() => $field)
                    );
                $expr = str_replace('{{'.$attribute->getAttributeCode().'}}', $field, $expr);

            }
            $index++;
        }



        //Join in all of the static attributes by joining the base entity table.
        $this->getSelect()->joinLeft($entityTable, 'main_table.'.$mainTableForeignKey.' = '.$entityTable.'.entity_id');

        $this->getSelect()->columns(array('name' => $expr));



        return $this;
    }


    public function addClientEntries()
    {
        $this->getSelect()->joinLeft(
            array('cust' => $this->getTable('customer/entity')),
            'main_table.customer_id = cust.entity_id'
        );

        return $this;
    }


    /*public function addpointsbydate($store_id, $customer_id, $date){
        $this->getSelect()->where("customer_id = ?", $customer_id);
        
        $this->getSelect()->where("( ? >= main_table.date_start )", $date);
        $this->getSelect()->where("( main_table.date_end >= ? )", $date);
        
        $this->addValidPoints($store_id, true);
        return $this;
    }*/

    public function addUsedpointsbydate($store_id, $customer_id){
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', $store_id);
        $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', $store_id);

        $order_states = explode(",", $statuses);

        $cols['points_spent'] = 'SUM(main_table.points_spent) as nb_credit_spent';


        //selection de tous les points utilisés à x date
        $this->getSelect()->from($this->getResource()->getMainTable().' as child_table', $cols);
        $cols_order['date_order'] = 'DATE_FORMAT(orders.created_at, "%Y-%m-%d") as date_order';

        $this->getSelect()->from($this->getTable('sales/order').' as orders', $cols_order);


        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            $this->getSelect()->where(" main_table.customer_id = $customer_id 
                                        AND main_table.points_spent > 0 
                                        AND main_table.order_id > 0 
                                        AND main_table.order_id = orders.increment_id"
            );


            $this->getSelect()->where("orders.customer_id = main_table.customer_id");
            $this->getSelect()->where("orders.$status_field IN (?) OR (orders.$status_field = 'new' AND orders.customer_id = main_table.customer_id)",$order_states);

        } else {

            //J2T magento 1.3.x fix

            $table_sales_order = $this->getTable('sales/order').'_varchar';

            $this->getSelect()->where("main_table.customer_id = $customer_id 
                                       AND main_table.points_spent > 0 
                                       AND main_table.order_id > 0
                                       AND main_table.order_id = orders.increment_id
                    
                                       AND main_table.order_id IN  (
                                                                       SELECT increment_id
                                                                       FROM ".$this->getTable('sales/order')." AS orders_checked
                                                                       WHERE orders_checked.entity_id IN (
                                                                                   SELECT order_state.entity_id
                                                                                   FROM ".$table_sales_order." AS order_state
                                                                                   WHERE  order_state.value <> 'canceled'
                                                                                   AND (order_state.value in (?)
                                                                                   OR (order_state.value = 'new'))
                                                                               )
                                                                               AND orders_checked.customer_id = main_table.customer_id
                                                                   )
                                                                
                    
                                       
                                       ", $order_states);

        }

        $this->getSelect()->where('main_table.rewardpoints_account_id = child_table.rewardpoints_account_id');

        if (Mage::getStoreConfig('rewardpoints/default/store_scope', $store_id)){
            $this->getSelect()->where('find_in_set(?, main_table.store_id)', $store_id);
        }


        //$this->getSelect()->group('orders.created_at');
        $this->getSelect()->group('date_order');


        /*echo $this->getSelect()->__toString();
        die;*/

        return $this;

    }

    public function addValidPoints($store_id, $unset_date_limits = false)
    {
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', $store_id);
        $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', $store_id);

        $order_states = explode(",", $statuses);
        $order_states_str = "'".implode("',",$order_states)."'";


        $cols['points_current'] = 'SUM(main_table.points_current) as nb_credit';
        $cols['points_spent'] = 'SUM(main_table.points_spent) as nb_credit_spent';

        $cols['points_available'] = '(SUM(main_table.points_current) - SUM(main_table.points_spent)) as nb_credit_available';


        $this->getSelect()->from($this->getResource()->getMainTable().' as child_table', $cols);

        // checking if module rewardshare is available
        $sql_share = "";
        $sql_required = "";
        //J2T magento 1.3.x fix
        if (class_exists('J2t_Rewardshare_Model_Stats', false)){
            $sql_share = "main_table.order_id = '".J2t_Rewardshare_Model_Stats::TYPE_POINTS_SHARE."' or";
        }

        if (Mage::getConfig()->getModuleConfig('J2t_Rewardproductvalue')->is('active', 'true')){
            if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                $sql_required = "(  
                                    main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REQUIRED ."'
                                    AND main_table.quote_id IN 
                                        (
                                            SELECT quote_id FROM ".$this->getTable('sales/order')." AS orders_quote
                                            WHERE orders_quote.quote_id = main_table.quote_id
                                            AND orders_quote.customer_id = main_table.customer_id
                                            AND orders_quote.$status_field IN (?,'new')
                                        ) 
                                        
                                 ) or ";
            }
        }


        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            //main_table.order_id = '".J2t_Rewardshare_Model_Stats::TYPE_POINTS_SHARE."' or
            $this->getSelect()->where("($sql_required $sql_share main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' 
                    OR main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."'
                    OR main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."'
                    OR main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."' 
                        
                        OR (main_table.order_id in (
                                    SELECT increment_id FROM ".$this->getTable('sales/order')." AS orders_new 
                                    WHERE orders_new.$status_field = 'new' 
                                    AND orders_new.customer_id = main_table.customer_id
                                ) 
                            AND main_table.points_spent > 0
                            )
                        
                        OR main_table.order_id in (
                        SELECT increment_id FROM ".$this->getTable('sales/order')." AS orders 
                            WHERE (orders.customer_id = main_table.customer_id 
                            OR orders.customer_id IN (
                                    SELECT referral_table.rewardpoints_referral_child_id 
                                    FROM ".$this->getTable('rewardpoints/referral')." AS referral_table 
                                    WHERE main_table.rewardpoints_referral_id = referral_table.rewardpoints_referral_id)) 
                                    AND orders.$status_field IN (?)
                            )
                        )", $order_states);
        } else {

            //J2T magento 1.3.x fix

            $table_sales_order = $this->getTable('sales/order').'_varchar';
            $this->getSelect()->where(" ($sql_required $sql_share main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' 
                            OR main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."'
                            OR main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."'
                            OR main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."' 

                            OR (
                                main_table.order_id in (
                                       SELECT increment_id
                                       FROM ".$this->getTable('sales/order')." AS orders_new
                                       WHERE orders_new.entity_id IN (
                                               SELECT order_state_new.entity_id
                                               FROM ".$table_sales_order." AS order_state_new
                                               WHERE order_state_new.value in ('new')
                                               AND orders_new.customer_id = main_table.customer_id
                                           )
                                       )
                                AND main_table.points_spent > 0
                               )
                                       
                            OR main_table.order_id in (SELECT increment_id
                                       FROM ".$this->getTable('sales/order')." AS orders
                                       WHERE orders.entity_id IN (
                                           SELECT order_state.entity_id
                                           FROM ".$table_sales_order." AS order_state
                                           WHERE order_state.value <> 'canceled'
                                           AND (order_state.value in (?))
                                           )
                                        ) ) ", $order_states);

            /*
             * or (orders.entity_id in (
                                SELECT orders_new.entity_id FROM ".$table_sales_order." AS orders_new 
                                WHERE orders_new.order_state = 'new') 
                                AND main_table.points_spent > 0)
             */

        }



        //$this->getSelect()->where('main_table.customer_id IS NOT NULL');
        $this->getSelect()->where('main_table.rewardpoints_account_id = child_table.rewardpoints_account_id');

        if (Mage::getStoreConfig('rewardpoints/default/store_scope', $store_id)){
            $this->getSelect()->where('find_in_set(?, main_table.store_id)', $store_id);
        }

        //v.2.0.0
        if (Mage::getStoreConfig('rewardpoints/default/points_delay', $store_id) && !$unset_date_limits){
            $this->getSelect()->where('( NOW() >= main_table.date_start OR main_table.date_start IS NULL)');
        }

        if (Mage::getStoreConfig('rewardpoints/default/points_duration', $store_id) && !$unset_date_limits){
            $this->getSelect()->where('( main_table.date_end >= NOW() or main_table.date_end IS NULL)');
        }
        $this->getSelect()->group('main_table.customer_id');

        /*echo $this->getSelect()->__toString();
        die;*/

        return $this;
    }


    public function joinValidOrders($customer_id, $order_states)
    {

        $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', Mage::app()->getStore()->getId());

        $this->getSelect()->joinLeft(
            array('ord' => $this->getTable('sales/order')),
            'main_table.order_id = ord.entity_id'
        );
        $this->getSelect()->where('ord.customer_id = ?', $customer_id);
        $this->getSelect()->where($status_field.' in (?)', $order_states);


        return $this;
    }

    public function joinFullCustomerPoints($customer_id, $store_id){

        $cols['points_current'] = 'SUM(main_table.points_current) as nb_credit';

        $this->getSelect()->from($this->getResource()->getMainTable().' as child_table', $cols)
            ->where('main_table.customer_id=?', $customer_id)
            ->where('main_table.rewardpoints_account_id = child_table.rewardpoints_account_id');

        if (Mage::getStoreConfig('rewardpoints/default/store_scope', $store_id) == 1){
            $this->getSelect()->where('find_in_set(?, main_table.store_id)', $store_id);
        }


        //v.2.0.0
        /*if (Mage::getStoreConfig('rewardpoints/default/points_delay', $store_id)){
            $this->getSelect()->where('( NOW() >= main_table.date_start OR main_table.date_start IS NULL)');
        }*/

        if (Mage::getStoreConfig('rewardpoints/default/points_duration', $store_id)){
            $this->getSelect()->where('( main_table.date_end >= NOW() OR main_table.date_end IS NULL)');
        }
        $this->getSelect()->group('main_table.customer_id');

        return $this;
    }

    public function joinValidPointsOrder($customer_id, $store_id, $order_states, $spent = false, $remove_end = false)
    {
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $status_field = Mage::getStoreConfig('rewardpoints/default/status_used', Mage::app()->getStore()->getId());

        $order_states_str = "'".implode("',",$order_states)."'";

        $sql_required = "";

        if (Mage::getConfig()->getModuleConfig('J2t_Rewardproductvalue')->is('active', 'true')){
            if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                $sql_required = "(  
                                    main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REQUIRED ."'
                                    AND main_table.quote_id IN 
                                        (
                                            SELECT quote_id FROM ".$this->getTable('sales/order')." AS orders_quote
                                            WHERE orders_quote.quote_id = main_table.quote_id
                                            AND orders_quote.customer_id = main_table.customer_id
                                            AND orders_quote.$status_field IN (?)
                                        ) 
                                        
                                 ) or";
            }
        }


        if ($spent){
            $cols['points_spent'] = 'SUM(main_table.points_spent) as nb_credit';
        } else {
            $cols['points_current'] = 'SUM(main_table.points_current) as nb_credit';
            $cols['points_spent'] = 'SUM(main_table.points_spent)';
        }

        $this->getSelect()->from($this->getResource()->getMainTable().' as child_table', $cols);

        if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
            //(orders.customer_id = main_table.customer_id or orders.customer_id = main_table.rewardpoints_referral_id)
            /*$this->getSelect()->where("( main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."'
                    or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."' or main_table.order_id in (
                        SELECT increment_id FROM ".$this->getTable('sales/order')." AS orders WHERE orders.customer_id = '".$customer_id."' AND orders.state IN (".implode(',',$order_states)."))
                        )");*/
            $this->getSelect()->where("( $sql_required main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."'
                    or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."' or main_table.order_id in (
                        SELECT increment_id FROM ".$this->getTable('sales/order')." AS orders WHERE (orders.customer_id = main_table.customer_id OR orders.customer_id IN (SELECT referral_table.rewardpoints_referral_child_id FROM ".$this->getTable('rewardpoints/referral')." AS referral_table WHERE main_table.rewardpoints_referral_id = referral_table.rewardpoints_referral_id)) AND orders.$status_field IN (?))
                        )", $order_states);
        } else {
            $table_sales_order = $this->getTable('sales/order').'_varchar';
            $this->getSelect()->where(" ( $sql_required main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW."' or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_BIRTHDAY."' or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN."'
                            or main_table.order_id = '".Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION."' or main_table.order_id in (SELECT increment_id
                                       FROM ".$this->getTable('sales/order')." AS orders
                                       WHERE orders.entity_id IN (
                                           SELECT order_state.entity_id
                                           FROM ".$table_sales_order." AS order_state
                                           WHERE order_state.value <> 'canceled'
                                           AND order_state.value in (?))
                                        ) ) ", $order_states);
        }

        $this->getSelect()->where('main_table.customer_id = ?', $customer_id)
            ->where('main_table.rewardpoints_account_id = child_table.rewardpoints_account_id');

        if (Mage::getStoreConfig('rewardpoints/default/store_scope', Mage::app()->getStore()->getId()) == 1){
            $this->getSelect()->where('find_in_set(?, main_table.store_id)', $store_id);
        }

        //v.2.0.0
        if ((Mage::getStoreConfig('rewardpoints/default/points_delay', $store_id) && !$spent)){
            $this->getSelect()->where('( NOW() >= main_table.date_start OR main_table.date_start IS NULL)');
        }

        if ((Mage::getStoreConfig('rewardpoints/default/points_duration', $store_id) && !$spent) && !$remove_end){
            $this->getSelect()->where('( main_table.date_end >= NOW() or main_table.date_end IS NULL)');
        }
        $this->getSelect()->group('main_table.customer_id');

        //echo $this->getSelect()->__toString();
        //die;

        return $this;
    }


    public function pointsByDate($dir = self::SORT_ORDER_DESC)
    {
        $this->setOrder('date_start ',  $dir);
        return $this;
    }


}
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
class Rewardpoints_Model_Observer extends Mage_Core_Model_Abstract {
    
    const XML_PATH_NOTIFICATION_NOTIFICATION_DAYS       = 'rewardpoints/notifications/notification_days'; 
    const XML_PATH_POINTS_DURATION                      = 'rewardpoints/default/points_duration';
    
    
    
    public function processRuleSave($observer){
        //if (version_compare(Mage::getVersion(), '1.7.0', '>=')){
            $object = $observer->getEvent()->getObject();
            if ($object instanceof Rewardpoints_Model_Pointrules || $object instanceof Rewardpoints_Model_Catalogpointrules) {
		if (is_array($object->getWebsiteIds())){
                    $object->setWebsiteIds(implode(',',$object->getWebsiteIds()));
                }
                if (is_array($object->getCustomerGroupIds())){
                    $object->setCustomerGroupIds(implode(',',$object->getCustomerGroupIds()));
                }
	    }  
        //}    
    }
    
    
    //J2T Check referral
    public function checkReferral($observer){
        $event = $observer->getEvent();
        $invoice = $event->getInvoice();
        $order = $invoice->getOrder();
        //$order = $observer->getEvent()->getInvoice()->getOrder();
        
        //load referral by referral customer id
        $referralModel = Mage::getModel('rewardpoints/referral');
        $referralModel->loadByChildId($order->getCustomerId());
        if ($referral_id = $referralModel->getRewardpointsReferralId()){
            //load points by referral_id
            $pointsModel = Mage::getModel('rewardpoints/stats');
            $pointsModel->loadByReferralId($referral_id, $order->getCustomerId());
            if ($order_id = $pointsModel->getOrderId()){
                if ($order_id != $order->getIncrementId()){
                    //check if order has correct status
                    if($loadedOrder = Mage::getModel('sales/order')->loadByIncrementId($order_id)){
                        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', $loadedOrder->getStoreId());
                        $order_states = explode(",", $statuses);                        
                        $status_state = Mage::getStoreConfig('rewardpoints/default/status_used', $loadedOrder->getStoreId());
                        
                        if (!in_array($loadedOrder->getStatus(),$order_states) && $status_state == 'status'){
                            //modify order_id to current order id (from invoice)
                            //if (in_array($order->getStatus(),$order_states)){
                                $pointsModel->setOrderId($order->getIncrementId());
                                $pointsModel->save();
                            //}
                        } else if(!in_array($loadedOrder->getState(),$order_states) && $status_state == 'state'){
                            //modify order_id to current order id (from invoice)
                            //if (in_array($order->getState(),$order_states)){
                                $pointsModel->setOrderId($order->getIncrementId());
                                $pointsModel->save();
                            //}
                        }
                    }
                }
            }
        }
    }
    
    
    public function aggregateRewardpointsData(){
        //1. Get all points per customer
        //1.1 Browse all store ids : $store_id
        $allStores = Mage::app()->getStores();
        foreach ($allStores as $_eachStoreId => $val) 
        {
            /*$duration = Mage::getStoreConfig(self::XML_PATH_POINTS_DURATION, $store_id);
            if ($duration){*/
                $store_id = Mage::app()->getStore($_eachStoreId)->getId();
                $days = Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_NOTIFICATION_DAYS, $store_id);
                if($days == 0)
                {
                    continue;
                }
                $points = Mage::getModel('rewardpoints/stats')
                        ->getResourceCollection()
                        ->addFinishFilter($days)
                        ->addValidPoints($store_id);
                if ($points->getSize()){
                    foreach ($points as $current_point){
                        $customer_id = $current_point->getCustomerId();
                        $points = $current_point->getNbCredit();
                        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
                            $points_received = Mage::getModel('rewardpoints/flatstats')->collectPointsCurrent($customer_id, $store_id);
                        } else {
                            $points_received = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id, $store_id);
                        }
                        
                        //2. check if total points >= points available
                        if ($points_received >= $points){
                            //3. send notification email
                            $customer = Mage::getModel('customer/customer')->load($customer_id);
                            Mage::getModel('rewardpoints/stats')->sendNotification($customer, $store_id, $points, $days);
                            Mage::log("Email sent to coustomer id:".$customer_id.",Points:".$points,null,"smogiexpireemail.log");
                        }
                    }
                }
            //}            
        }        
    }

    public function pointsRefresh($observer){
        $userId = Mage::getSingleton('rewardpoints/session')->getReferralUser();
        Mage::getSingleton('rewardpoints/session')->unsetAll();
        Mage::getSingleton('rewardpoints/session')->setReferralUser($userId);
    }

    public function recordPointsUponRegistration($observer){
        //Mage::log('got in'.$observer->getEvent()->getCustomer()->getEntityId(),null,'testlog.log');
        $customerId = $observer->getEvent()->getCustomer()->getEntityId();
        $customerData = Mage::getModel('customer/customer')->load($customerId)->getData();
        //Mage::log('got in'.$observer->getEvent()->getCustomer()->getEntityId().'   '.strtotime($customerData['created_at']).'     '.strtotime('2013-05-13 00:00:00'),null,'testlog.log');
        if(strtotime($customerData['created_at']) < strtotime('2013-05-13 00:00:00'))
            return;

        if (Mage::getStoreConfig('rewardpoints/registration/registration_points', Mage::app()->getStore()->getId()) > 0){
			$from = strtotime('2014-02-14 00:00:00');
			$to = strtotime('2020-03-15 00:00:00');
			$valid_reg_date = strtotime($customerData['created_at']);
//			if(!($from <= $valid_reg_date && $to >= $valid_reg_date)) {
//			return;
//			}
            if(!($from <= $valid_reg_date && $to >= $valid_reg_date)) {
			return;
			}

            //check if points already earned
            $customerId = $observer->getEvent()->getCustomer()->getEntityId();
            $points = Mage::getStoreConfig('rewardpoints/registration/registration_points', Mage::app()->getStore()->getId());
            //$orderId = -2;
            $this->recordPoints($points, $customerId, Rewardpoints_Model_Stats::TYPE_POINTS_REGISTRATION, false);
			
        }
    }
    
    
    public function recordPointsAdminEvent($observer) {
        $event = $observer->getEvent();
        $customer = $event->getCustomer();
        $request = $event->getRequest();
       
        if ($data = $request->getPost()){        
            if (isset($data['points_current']) || isset($data['points_spent'])){
                if ($data['points_current'] > 0 || $data['points_spent'] > 0){
                    $model = Mage::getModel('rewardpoints/stats');
                    if (trim($data['date_start'])){                    
                        $date = Mage::app()->getLocale()->date($data['date_start'], Zend_Date::DATE_SHORT, null, false);
                        $time = $date->getTimestamp();
                        $model->setDateStart(Mage::getModel('core/date')->gmtDate(null, $time));
                    } else {                    
                        $model->setDateStart(Mage::getModel('core/date')->gmtDate(null, Mage::getModel('core/date')->timestamp(time())));
                    }
                    if (trim($data['date_end'])){
                        if ($data['date_end'] != ""){
                            $date = Mage::app()->getLocale()->date($data['date_end'], Zend_Date::DATE_SHORT, null, false);
                            $time = $date->getTimestamp();
                            $model->setDateEnd(Mage::getModel('core/date')->gmtDate(null, $time));
                        }
                    }
                    if (trim($data['points_current'])){
                        $model->setPointsCurrent($data['points_current']);
                    }
                    if (trim($data['points_spent'])){
                        $model->setPointsSpent($data['points_spent']);
                    }
                    if (trim($data['rewardpoints_description'])){
                        $model->setRewardpointsDescription($data['rewardpoints_description']);
                    }
                    
                    $store_ids = array();
                    if ($store_id = $customer->getStore()->getId()){
                        $model->setStoreId($store_id);
                    } else {
                        $allStores = Mage::app()->getStores();
                        foreach ($allStores as $_eachStoreId => $val) {
                            $store_ids[] = Mage::app()->getStore($_eachStoreId)->getId();
                        }
                        $model->setStoreId(implode(",",$store_ids));
                    }

                    $model->setCustomerId($customer->getId());
                    
                    $model->setOrderId(Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN);                
                    $model->save();

                    //flatstats record
                    if ($store_id = $customer->getStore()->getId()){
                        Mage::getModel('rewardpoints/flatstats')->processRecordFlat($customer->getId(), $store_id);
                    } else {
                        $allStores = Mage::app()->getStores();
                        foreach ($allStores as $_eachStoreId => $val) {
                            $this->processRecordFlatAction($customer->getId(), Mage::app()->getStore($_eachStoreId)->getId());
                        }
                    }
                }
                
            }
        }
    }
    

    public function recordPointsForOrderEvent($observer) {
        
        //J2T magento 1.3.x fix
        if (version_compare(Mage::getVersion(), '1.4.0', '<')){
            //$order = new Mage_Sales_Model_Order();
            $order = Mage::getModel('sales/order');
            $incrementId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
            $order->loadByIncrementId($incrementId);

            $quote = Mage::getModel('sales/quote');
            $quoteId = Mage::getSingleton('checkout/session')->getLastQuoteId();
            $quote->load($quoteId);
            $this->pointsOnOrder($order, $quote);

        } else {
            $event = $observer->getEvent();
            $order = $event->getOrder();
            $quote = $event->getQuote();

            $this->pointsOnOrder($order, $quote);
        }
        
        
        /*$event = $observer->getEvent();
        $order = $event->getOrder();
        $quote = $event->getQuote();
        
        $this->pointsOnOrder($order, $quote);*/
/*
        $rate = $order->getBaseToOrderRate();

        $order->setQuote($quote);
        $rewardPoints = Mage::helper('rewardpoints/data')->getPointsOnOrder($order, null, $rate);

        if (Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId())){
            if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId()) < $rewardPoints){
                $rewardPoints = Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId());
            }
        }


        $customerId = $order->getCustomerId();

        //record points for item into db
        if ($rewardPoints > 0){
            $this->recordPoints($rewardPoints, $customerId, $order->getIncrementId());
        }



        //subtract points for this order
        $points_apply = (int) Mage::helper('rewardpoints/event')->getCreditPoints();
        if ($points_apply > 0){
            $this->useCouponPoints($points_apply, $customerId, $order->getIncrementId());
        }

        //$this->sales_order_success_referral($order->getIncrementId());
        $this->sales_order_success_referral($order);
 */
    }

    protected function getMultishippingQuote($order) {
        $order_shipping_address = Mage::getModel('sales/order_address')->load($order->getShippingAddressId());
        $customer_shipping_address = $order_shipping_address->getCustomerAddressId();

        $order_billing_address = Mage::getModel('sales/order_address')->load($order->getBillingAddressId());
        $customer_billing_address = $order_billing_address->getCustomerAddressId();

        $quote_tmp = Mage::getModel('sales/quote');
        $quote = Mage::getModel('sales/quote')->load($order->getQuoteId());
        foreach($quote->getAddressesCollection() as $my_quote){
            if ($my_quote->getAddressType() == 'shipping' && $my_quote->getCustomerAddressId() == $customer_shipping_address){
                $quote_tmp->setShippingAddress($my_quote);
            } elseif($my_quote->getAddressType() == 'billing' && $my_quote->getCustomerAddressId() == $customer_billing_address) {
                $quote_tmp->setBillingAddress($my_quote);
            }
        }
        return $quote_tmp;
    }


    public function recordPointsForMultiOrderEvent($observer) {

        $event = $observer->getEvent();
        $orders = $event->getOrders();
        $quote = $event->getQuote();

        if ($orders == array()){
            $this->recordPointsForOrderEvent($observer);
            return true;
        }
        
        $customerId = "";
        $store_id = "";
        
        foreach($orders as $order){
            
            $order->setQuote($this->getMultishippingQuote($order));
            $rate = $order->getBaseToOrderRate();
            $customerId = $order->getCustomerId();            
            $store_id = Mage::app()->getStore()->getId();


            $rewardPoints = Mage::helper('rewardpoints/data')->getPointsOnOrder($order, null, $rate);

            if (Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId())){
                if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId()) < $rewardPoints){
                    $rewardPoints = Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId());
                }
            }

            //record points for item into db
            if ($rewardPoints > 0){
                $this->recordPoints($rewardPoints, $customerId, $order->getIncrementId());
            }

            //subtract points for this order
            $points_apply = (int) Mage::helper('rewardpoints/event')->getCreditPoints();
            if ($points_apply > 0){
                $this->useCouponPoints($points_apply, $customerId, $order->getIncrementId());
            }

            $this->sales_order_success_referral($order, $quote);
        }
        if ($customerId && $store_id){
            $this->processRecordFlat($customerId, $store_id);
        }        
    }




    public function useCouponPoints($pointsAmt, $customerId, $orderId) {
        $reward_model = Mage::getModel('rewardpoints/stats');
        //money_points
        //points_money

        $test_points = $reward_model->checkProcessedOrder($customerId, $orderId, false);
        if (!$test_points->getId()){
            $post = array('order_id' => $orderId, 'customer_id' => $customerId, 'store_id' => Mage::app()->getStore()->getId(), 'points_spent' => $pointsAmt, 'convertion_rate' => Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId()));
            $reward_model->setData($post);
            $reward_model->save();
            Mage::helper('rewardpoints/event')->setCreditPoints(0);
        }
    }
    
    public function processAddModelCallback($observer) {
        //J2T magento 1.3.x fix
        $object = $observer->getEvent()->getObject();
        if ($object instanceof Mage_Sales_Model_Order) { //check points on saving orders
            $order = $object;
            //$quote = $object->getQuote();
            $quote = Mage::getModel('sales/quote')->load($order->getQuoteId());
            $this->pointsOnOrder($order, $quote);
        }
    }
    
    public function processAddModelOrderSave($observer){
        $order = $observer->getEvent()->getOrder();
        $quote = Mage::getModel("sales/quote")->load($order->getQuote());
        $this->pointsOnOrder($order, $quote);
    }


    public function processAddCallback($observer){
        //if (!version_compare(Mage::getVersion(), '1.4.0', '>=')){
        $object = $observer->getEvent()->getObject();
        if ($object instanceof Mage_Review_Model_Review) {
            if ($object->getStatusId() == Mage_Review_Model_Review::STATUS_APPROVED){
                if ($pointsInt = Mage::getStoreConfig('rewardpoints/registration/review_points', $object->getStoreId())){
                    if ($object->getCustomerId()){
                        $reward_model = Mage::getModel('rewardpoints/stats');
                        $data = array('customer_id' => $object->getCustomerId(), 'store_id' => $object->getStoreId(), 'points_current' => $pointsInt, 'order_id' => Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW);
                        $reward_model->setData($data);
                        $reward_model->save();
                    }
                }
            }
        }
        
        if ($object instanceof Mage_Sales_Model_Order) {
            if (($customer_id = $object->getCustomerId()) && ($store_id = $object->getStoreId())){
                $this->processRecordFlat($customer_id, $store_id);
                //check referred friend in order to refresh referrer flat points
                $reward_model = Mage::getModel('rewardpoints/stats');
                $reward_object = $reward_model->loadReferrer($customer_id, $object->getIncrementId());
                if ($reward_object->getCustomerId()){
                    $this->processRecordFlat($reward_object->getCustomerId(), $store_id);
                }
            }            
        }
        
        //}
    }
    
    public function processLoadModelCallback($observer){
        $object = $observer->getEvent()->getObject();
        if ($object instanceof Mage_Customer_Model_Customer) {
            if (($customer_id = $object->getId()) && ($store_id = $object->getStoreId())){
                $this->processRecordFlat($customer_id, $store_id, true);
            }
        }
        if ($object instanceof Mage_Sales_Model_Quote) {
            if (($customer_id = $object->getCustomerId()) && ($store_id = $object->getStoreId())){
                $this->processRecordFlat($customer_id, $store_id, true);
            }
        }
    }
    
    protected function processRecordFlatAction ($customerId, $store_id, $check_date = false) {
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id) && $customerId){
            $reward_model = Mage::getModel('rewardpoints/stats');
            $points_current = $reward_model->getPointsCurrent($customerId, $store_id);
            $points_received = $reward_model->getRealPointsReceivedNoExpiry($customerId, $store_id);
            $points_spent = $reward_model->getPointsSpent($customerId, $store_id);
            $points_awaiting_validation = $reward_model->getPointsWaitingValidation($customerId, $store_id);
            $points_lost = $reward_model->getRealPointsLost($customerId, $store_id);

            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            $reward_flat_model->loadByCustomerStore($customerId, $store_id);
            $reward_flat_model->setPointsCollected($points_received);
            $reward_flat_model->setPointsUsed($points_spent);
            $reward_flat_model->setPointsWaiting($points_awaiting_validation);
            $reward_flat_model->setPointsCurrent($points_current);
            $reward_flat_model->setPointsLost($points_lost);
            $reward_flat_model->setStoreId($store_id);
            $reward_flat_model->setUserId($customerId);
            
            if ($check_date && ($date_check = $reward_flat_model->getLastCheck())){
                $date_array = explode("-", $reward_flat_model->getLastCheck());
                if ($reward_flat_model->getLastCheck() == date("Y-m-d")){
                    return false;
                }
            }
            
            $reward_flat_model->setLastCheck(date("Y-m-d"));
            
            $reward_flat_model->save();
        }
    }
    
    public function processRecordFlat($customerId, $store_id, $check_date = false){
        if (Mage::getStoreConfig('rewardpoints/default/store_scope', $store_id)){
            $this->processRecordFlatAction ($customerId, $store_id, $check_date);
        } else {
            //get all stores
            $allStores = Mage::app()->getStores();
            foreach ($allStores as $_eachStoreId => $val) {
                $this->processRecordFlatAction ($customerId, Mage::app()->getStore($_eachStoreId)->getId(), $check_date);
                
                /*$_storeCode = Mage::app()->getStore($_eachStoreId)->getCode();
                $_storeName = Mage::app()->getStore($_eachStoreId)->getName();
                $_storeId = Mage::app()->getStore($_eachStoreId)->getId();
                echo $_storeId;
                echo $_storeCode;
                echo $_storeName;*/
            }
        }
    }
    
    public function processOrderSaveRecordPoints($observer) {
        $object = $observer->getEvent()->getObject();
        if ($object instanceof Mage_Checkout_Model_Cart) {
            //refresh points
            $customerId = $object->getCustomerId();
            $store_id = $object->getStoreId();
            $this->processRecordFlat($customerId, $store_id);
        }
    }
    
    
    public function recordPointsMultiOrSingle($observer){   
        if ($order = $observer->getEvent()->getOrder()) {
            $this->pointsOnOrder($order, $order->getQuote());
        } elseif ($orders = $observer->getEvent()->getOrders()) {
            $this->recordPointsForMultiOrderEvent($observer);
        }
    }
    
    
    
    protected function pointsOnOrder($order, $quote){
		
        if ($order->getCustomerId() == 0){
            return;
        }
        
        $rate = $order->getBaseToOrderRate();
        
        if (!$quote->getId() && ($order_quote = $order->getQuote())){
            $quote = $order_quote;
        } elseif (!$order->getQuote() && ($quote_id = $order->getQuoteId()) && !$quote->getId()) {
            $quote = Mage::getModel('sales/quote')->load($quote_id);
            if($quote->getId()){
                $order->setQuote($quote);
            }
        } else {
            $order->setQuote($quote);
        }
        
        if (!$order->getQuote() && !$quote->getId() && Mage::getSingleton('adminhtml/session_quote')->getQuote()){
            $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
            $order->setQuote($quote);
        }
        
        
        if (!$quote->getId() && ($order_quote = $order->getQuote())){
            $quote = $order_quote;
        } else {
            $order->setQuote($quote);
        }        
        $rewardPoints = Mage::helper('rewardpoints/data')->getPointsOnOrder($order, null, $rate);

        if (Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId())){
            if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId()) < $rewardPoints){
                $rewardPoints = Mage::getStoreConfig('rewardpoints/default/max_point_collect_order', Mage::app()->getStore()->getId());
            }
        }
        $customerId = $order->getCustomerId();
        //$store_id = Mage::app()->getStore()->getId();
        $store_id = $order->getStoreId();
			 
	
		$discountamt = $order->getBaseDiscountAmount();	
		Mage::log($discountamt,null,'smogi.log');
		
		if($discountamt >= 0)
		{			
		
        //record points for item into db
        if ($rewardPoints > 0){
            $this->recordPoints($rewardPoints, $customerId, $order->getIncrementId());
        }
		}
		
		/* for category Accessories
		
				$items = $order->getAllItems();
                        
                        foreach ($items as $item)
                        {
                           $product = Mage::getModel('catalog/product')->load($item->getProductId());
						   $pid= $item->getProductId();
                        }
						
		$catids = $product->getCategoryIds();
		if(in_array(11, $catids))
		{
		Mage::throwException(
                    Mage::helper('sales')->__("cat ids".$catids.$pid)
                );
        } */
		//subtract points for this order
        $points_apply = (int) Mage::helper('rewardpoints/event')->getCreditPoints($quote);
        
        if ($points_apply > 0){
            $this->useCouponPoints($points_apply, $customerId, $order->getIncrementId());
        }
        
        //$this->sales_order_success_referral($order->getIncrementId());
        $this->sales_order_success_referral($order, $quote);
        
        $this->processRecordFlat($customerId, $store_id);
		
    }
    
    

    public function recordPoints($pointsInt, $customerId, $orderId, $no_check = true) {
        $reward_model = Mage::getModel('rewardpoints/stats');
        //check if points are already processed
        $test_points = $reward_model->checkProcessedOrder($customerId, $orderId, true);
        if (!$test_points->getId()){
            $post = array('order_id' => $orderId, 'customer_id' => $customerId, 'store_id' => Mage::app()->getStore()->getId(), 'points_current' => $pointsInt, 'convertion_rate' => Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId()));
            //v.2.0.0
            $add_delay = 0;
            if ($delay = Mage::getStoreConfig('rewardpoints/default/points_delay', Mage::app()->getStore()->getId())){
                if (is_numeric($delay)){
                    $post['date_start'] = $reward_model->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$delay, date("Y")));
                    $add_delay = $delay;
                }
            }
            
            if ($duration = Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId())){
                if (is_numeric($duration)){
                    if (!isset($post['date_start'])){
                        $post['date_start'] = $reward_model->getResource()->formatDate(time());
                    }
                    $post['date_end'] = $reward_model->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$duration+$add_delay, date("Y")));
                }
            }
            $reward_model->setData($post);
            $reward_model->save();
        } elseif (Mage::getStoreConfig('rewardpoints/default/allow_recalculate', Mage::app()->getStore()->getId())) {            
            $reward_model->load($test_points->getId());
            $reward_model->setPointsCurrent($pointsInt);
            $reward_model->save();
        }
    }


    public function sales_order_success_referral($order, $quote = null)
    {
        if (!$order->getCustomerId()){
            return;
        }
        
        if (!$quote->getId()){
            $quote = Mage::getModel('sales/quote')->load($order->getQuoteId());
        }
        
        $userId = 0;
        if (Mage::getSingleton('rewardpoints/session')->getReferralUser()){
            $userId = Mage::getSingleton('rewardpoints/session')->getReferralUser();
        } else if ($quote->getRewardpointsReferrer()){
            $userId = (int)$quote->getRewardpointsReferrer();
        }

        //check if referral from link...
        //if ($userId = Mage::getSingleton('rewardpoints/session')->getReferralUser()){
        if ($userId){
            $referrer = Mage::getModel('customer/customer')->load($userId);
            $referree_email = $order->getCustomerEmail();
            $referree_name = $order->getCustomerName();

            $referralModel = Mage::getModel('rewardpoints/referral');
            if (!$referralModel->isSubscribed($referree_email) && $referrer->getEmail() != $referree_email) {
                $referralModel->setRewardpointsReferralParentId($userId)
                         ->setRewardpointsReferralEmail($referree_email)
                         ->setRewardpointsReferralName($referree_name);
                $referralModel->save();
            }
            Mage::getSingleton('rewardpoints/session')->setReferralUser(null);
            Mage::getSingleton('rewardpoints/session')->unsetAll();
        }

        $rewardPoints = Mage::getStoreConfig('rewardpoints/registration/referral_points', Mage::app()->getStore()->getId());
        $rewardPointsChild = Mage::getStoreConfig('rewardpoints/registration/referral_child_points', Mage::app()->getStore()->getId());

        if ($rewardPoints > 0 || $rewardPointsChild > 0 && $order->getCustomerEmail()){
            //$order = $observer->getEvent()->getInvoice()->getOrder();
            $referralModel = Mage::getModel('rewardpoints/referral');
            if ($referralModel->isSubscribed($order->getCustomerEmail())) {
                
                if (!$referralModel->isConfirmed($order->getCustomerEmail())) {
                    $referralModel->loadByEmail($order->getCustomerEmail());
                    $referralModel->setData('rewardpoints_referral_status', true);
                    $referralModel->setData('rewardpoints_referral_child_id', $order->getCustomerId());
                    $referralModel->save();

                    $parent = Mage::getModel('customer/customer')->load($referralModel->getData('rewardpoints_referral_parent_id'));
                    $child    = Mage::getModel('customer/customer')->load($referralModel->getData('rewardpoints_referral_child_id'));

                    try {
                        if ($rewardPoints > 0){
                            $config_days = Mage::getStoreConfig('rewardpoints/default/points_duration');
                            $reward_model = Mage::getModel('rewardpoints/stats');
//                            $post = array('order_id' => $order->getIncrementId(), 'customer_id' => $referralModel->getData('rewardpoints_referral_parent_id'),
//                                'store_id' => $order->getStoreId(), 'points_current' => $rewardPoints, 'rewardpoints_referral_id' => $referralModel->getData('rewardpoints_referral_id'));
                            $post = array('order_id' => $order->getIncrementId(), 'customer_id' => $referralModel->getData('rewardpoints_referral_parent_id'),
                                'store_id' => $order->getStoreId(), 'points_current' => $rewardPoints, 'rewardpoints_referral_id' => $referralModel->getData('rewardpoints_referral_id'), 'date_start'=>date("Y-m-d"),'date_end'=>date('Y-m-d',strtotime('+ '.$config_days.' days' ) ));

                            $reward_model->setData($post);
                            $reward_model->save();
                        }

                        if ($rewardPointsChild > 0){
                            
                            $reward_model = Mage::getModel('rewardpoints/stats');
                            $post = array('order_id' => $order->getIncrementId(), 'customer_id' => $referralModel->getData('rewardpoints_referral_child_id'),
                                'store_id' => $order->getStoreId(), 'points_current' => $rewardPointsChild, 'rewardpoints_referral_id' => $referralModel->getData('rewardpoints_referral_id'));
                            $reward_model->setData($post);
                            $reward_model->save();


                        }

                    } catch (Exception $e) {
                        //Mage::getSingleton('session')->addError($e->getMessage());
                    }
                    $referralModel->sendConfirmation($parent, $child, $parent->getEmail());
                    // Add code for specific coupon Email by Fahim Khan.
                    /*$parentName  = $parent->getName();
                    $parentEmail = $parent->getEmail();
                    $refName = $child->getName();
                    $orderTotal = (int)$order->getBaseGrandTotal();
                    if($orderTotal == 1){
                        Mage::helper('rewardpoints')->getSendEmailWithCouponCode($parentName,$parentEmail,$refName);
                    }*/


                }
            }
        }
    }

    public function sales_order_invoice_pay($observer)
    {
        $rewardPoints = Mage::getStoreConfig('rewardpoints/registration/referral_points', Mage::app()->getStore()->getId());
        $rewardPointsChild = Mage::getStoreConfig('rewardpoints/registration/referral_child_points', Mage::app()->getStore()->getId());
        if ($rewardPoints > 0 || $rewardPointsChild > 0){
            $order = $observer->getEvent()->getInvoice()->getOrder();
            $referralModel = Mage::getModel('rewardpoints/referral');
            if ($referralModel->isSubscribed($order->getCustomerEmail())) {
                if (!$referralModel->isConfirmed($order->getCustomerEmail())) {
                    $referralModel->loadByEmail($order->getCustomerEmail());
                    $referralModel->setData('rewardpoints_referral_status', true);
                    $referralModel->setData('rewardpoints_referral_child_id', $order->getCustomerId());
                    $referralModel->save();

                    $parent = Mage::getModel('customer/customer')->load($referralModel->getData('rewardpoints_referral_parent_id'));
                    $child    = Mage::getModel('customer/customer')->load($referralModel->getData('rewardpoints_referral_child_id'));
                    $referralModel->sendConfirmation($parent, $child, $parent->getEmail());

                    try {
                        if ($rewardPoints > 0){
                            //$reward_points = Mage::getModel('rewardpoints/account');
                            //$reward_points->saveCheckedOrder($order->getIncrementId(), $referralModel->getData('rewardpoints_referral_parent_id'), $order->getStoreId(), $rewardPoints, $referralModel->getData('rewardpoints_referral_id'), true);



                            $reward_model = Mage::getModel('rewardpoints/stats');
                            $post = array('order_id' => $order->getIncrementId(), 'customer_id' => $referralModel->getData('rewardpoints_referral_parent_id'),
                                'store_id' => $order->getStoreId(), 'points_current' => $rewardPoints, 'rewardpoints_referral_id' => $referralModel->getData('rewardpoints_referral_id'));
                            $reward_model->setData($post);
                            $reward_model->save();

                        }


                        if ($rewardPointsChild > 0){
                            //$reward_points2 = Mage::getModel('rewardpoints/account');
                            //$reward_points2->saveCheckedOrder($order->getIncrementId(), $referralModel->getData('rewardpoints_referral_child_id'), $order->getStoreId(), $rewardPointsChild, $referralModel->getData('rewardpoints_referral_id'), true);


                            $reward_model = Mage::getModel('rewardpoints/stats');
                            $post = array('order_id' => $order->getIncrementId(), 'customer_id' => $referralModel->getData('rewardpoints_referral_child_id'),
                                'store_id' => $order->getStoreId(), 'points_current' => $rewardPointsChild, 'rewardpoints_referral_id' => $referralModel->getData('rewardpoints_referral_id'));
                            $reward_model->setData($post);
                            $reward_model->save();

                        }

                    } catch (Exception $e) {
                        //Mage::getSingleton('session')->addError($e->getMessage());
                    }
                }
            }
        }
    }

    public function applyDiscount($observer)
    {
        /*try {

            $customer = Mage::getSingleton('customer/session');
            if ($customer->isLoggedIn()){
                return Mage::getModel('rewardpoints/discount')->apply($observer->getEvent()->getItem());
            } else return null;

            //return $this->_discount->apply($observer->getEvent()->getItem());
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
        } catch (Exception $e) {
           Mage::getSingleton('checkout/session')->addError($e);
        }*/
    }
    
    
    /*
    public function attachRewardPointsAttributes($observer) {
        
        if($observer->getEvent()->getRequest()->isPost()) {
            $rewardpoints_description = $observer->getEvent()->getRequest()->getPost('rewardpoints_description', '');
            $rewardpoints = $observer->getEvent()->getRequest()->getPost('rewardpoints', '');
            $base_rewardpoints = $observer->getEvent()->getRequest()->getPost('base_rewardpoints', '');
            
            $quote = $observer->getEvent()->getQuote();
            $quote->setRewardpointsDescription($rewardpoints_description);
            $quote->setRewardpoints($rewardpoints);
            $quote->setBaseRewardpoints($base_rewardpoints);
        }
    }
    */
    
    
    

}
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

class Rewardpoints_Model_Pointrules extends Mage_Rule_Model_Rule
{
    const RULE_TYPE_CART  = 1;
    const RULE_TYPE_DATAFLOW   = 2;

    const RULE_ACTION_TYPE_ADD = 1;
    const RULE_ACTION_TYPE_DONTPROCESS = 2;
    //const RULE_ACTION_TYPE_MULTIPLY = -1;
    //const RULE_ACTION_TYPE_DIVIDE = -2;

    protected $_types;
    protected $_action_types;

    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/pointrules');
        //('rewardpoints/pointrules')->checkRule($to_validate);
        $this->_types = array(
            self::RULE_TYPE_CART     => Mage::helper('rewardpoints')->__('Cart rule'),
            self::RULE_TYPE_DATAFLOW   => Mage::helper('rewardpoints')->__('Import rule'),
        );
        $this->_action_types = array(
            self::RULE_ACTION_TYPE_ADD     => Mage::helper('rewardpoints')->__('Add / remove points'),
            self::RULE_ACTION_TYPE_DONTPROCESS   => Mage::helper('rewardpoints')->__("Don't process points"),
            //self::RULE_ACTION_TYPE_MULTIPLY   => Mage::helper('rewardpoints')->__("Multiply By"),
            //self::RULE_ACTION_TYPE_DIVIDE   => Mage::helper('rewardpoints')->__("Divide By"),
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
        return Mage::getModel('rewardpoints/rule_condition_combine');
    }
    

    public function checkRule($to_validate)
    {
        $storeId = Mage::app()->getStore($request->getStore())->getId();
        $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $rules = Mage::getModel('rewardpoints/pointrules')->getCollection()->setValidationFilter($websiteId, $customerGroupId, $couponCode);
        foreach($rules as $rule)
        {
            if (!$rule->getStatus()) continue;
            $rule_validate = Mage::getModel('rewardpoints/pointrules')->load($rule->getRuleId());

            if ($rule_validate->validate($to_validate)){
                //regle ok
                Mage::getModel('rewardpoints/subscriptions')->updateSegments($to_validate->getEmail(), $rule);
            } else {
                //regle ko
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

    public function getAllRulePointsGathered($cart = null)
    {
        if ($cart == null){
            $cart = Mage::getSingleton('checkout/cart');
        }
        $points = $this->getRulePointsGathered($cart);
        return $points;
    }

    public function getRulePointsGathered($to_validate)
    {
        $points = 0;
        $storeId = Mage::app()->getStore()->getId();
        $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();

        $rules = Mage::getModel('rewardpoints/pointrules')->getCollection()->setValidationFilter($websiteId, $customerGroupId);
        foreach($rules as $rule)
        {
            if (!$rule->getStatus()) continue;
            $rule_validate = Mage::getModel('rewardpoints/pointrules')->load($rule->getRuleId());
            
            if ($rule_validate->validate($to_validate)){
                //regle ok
                if ($rule_validate->getActionType() == self::RULE_ACTION_TYPE_DONTPROCESS){
                    return false;
                } /*else if ($rule_validate->getActionType() == self::RULE_ACTION_TYPE_MULTIPLY){
                    $multiply = ($rule_validate->getPoints() <= 0) ? 1 : $rule_validate->getPoints();
                } else if ($rule_validate->getActionType() == self::RULE_ACTION_TYPE_DIVIDE){
                    $divide = ($rule_validate->getPoints() <= 0) ? 1 : $rule_validate->getPoints();
                } */else {
                   $points += $rule_validate->getPoints(); 
                }
            } else {
                //regle ko
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
 * Quote model
 *
 * Supported events:
 *  sales_quote_load_after
 *  sales_quote_save_before
 *  sales_quote_save_after
 *  sales_quote_delete_before
 *  sales_quote_delete_after
 *
 * @method Mage_Sales_Model_Resource_Quote _getResource()
 * @method Mage_Sales_Model_Resource_Quote getResource()
 * @method Mage_Sales_Model_Quote setStoreId(int $value)
 * @method string getCreatedAt()
 * @method Mage_Sales_Model_Quote setCreatedAt(string $value)
 * @method string getUpdatedAt()
 * @method Mage_Sales_Model_Quote setUpdatedAt(string $value)
 * @method string getConvertedAt()
 * @method Mage_Sales_Model_Quote setConvertedAt(string $value)
 * @method int getIsActive()
 * @method Mage_Sales_Model_Quote setIsActive(int $value)
 * @method Mage_Sales_Model_Quote setIsVirtual(int $value)
 * @method int getIsMultiShipping()
 * @method Mage_Sales_Model_Quote setIsMultiShipping(int $value)
 * @method int getItemsCount()
 * @method Mage_Sales_Model_Quote setItemsCount(int $value)
 * @method float getItemsQty()
 * @method Mage_Sales_Model_Quote setItemsQty(float $value)
 * @method int getOrigOrderId()
 * @method Mage_Sales_Model_Quote setOrigOrderId(int $value)
 * @method float getStoreToBaseRate()
 * @method Mage_Sales_Model_Quote setStoreToBaseRate(float $value)
 * @method float getStoreToQuoteRate()
 * @method Mage_Sales_Model_Quote setStoreToQuoteRate(float $value)
 * @method string getBaseCurrencyCode()
 * @method Mage_Sales_Model_Quote setBaseCurrencyCode(string $value)
 * @method string getStoreCurrencyCode()
 * @method Mage_Sales_Model_Quote setStoreCurrencyCode(string $value)
 * @method string getQuoteCurrencyCode()
 * @method Mage_Sales_Model_Quote setQuoteCurrencyCode(string $value)
 * @method float getGrandTotal()
 * @method Mage_Sales_Model_Quote setGrandTotal(float $value)
 * @method float getBaseGrandTotal()
 * @method Mage_Sales_Model_Quote setBaseGrandTotal(float $value)
 * @method Mage_Sales_Model_Quote setCheckoutMethod(string $value)
 * @method int getCustomerId()
 * @method Mage_Sales_Model_Quote setCustomerId(int $value)
 * @method Mage_Sales_Model_Quote setCustomerTaxClassId(int $value)
 * @method Mage_Sales_Model_Quote setCustomerGroupId(int $value)
 * @method string getCustomerEmail()
 * @method Mage_Sales_Model_Quote setCustomerEmail(string $value)
 * @method string getCustomerPrefix()
 * @method Mage_Sales_Model_Quote setCustomerPrefix(string $value)
 * @method string getCustomerFirstname()
 * @method Mage_Sales_Model_Quote setCustomerFirstname(string $value)
 * @method string getCustomerMiddlename()
 * @method Mage_Sales_Model_Quote setCustomerMiddlename(string $value)
 * @method string getCustomerLastname()
 * @method Mage_Sales_Model_Quote setCustomerLastname(string $value)
 * @method string getCustomerSuffix()
 * @method Mage_Sales_Model_Quote setCustomerSuffix(string $value)
 * @method string getCustomerDob()
 * @method Mage_Sales_Model_Quote setCustomerDob(string $value)
 * @method string getCustomerNote()
 * @method Mage_Sales_Model_Quote setCustomerNote(string $value)
 * @method int getCustomerNoteNotify()
 * @method Mage_Sales_Model_Quote setCustomerNoteNotify(int $value)
 * @method int getCustomerIsGuest()
 * @method Mage_Sales_Model_Quote setCustomerIsGuest(int $value)
 * @method string getRemoteIp()
 * @method Mage_Sales_Model_Quote setRemoteIp(string $value)
 * @method string getAppliedRuleIds()
 * @method Mage_Sales_Model_Quote setAppliedRuleIds(string $value)
 * @method string getReservedOrderId()
 * @method Mage_Sales_Model_Quote setReservedOrderId(string $value)
 * @method string getPasswordHash()
 * @method Mage_Sales_Model_Quote setPasswordHash(string $value)
 * @method string getCouponCode()
 * @method Mage_Sales_Model_Quote setCouponCode(string $value)
 * @method string getGlobalCurrencyCode()
 * @method Mage_Sales_Model_Quote setGlobalCurrencyCode(string $value)
 * @method float getBaseToGlobalRate()
 * @method Mage_Sales_Model_Quote setBaseToGlobalRate(float $value)
 * @method float getBaseToQuoteRate()
 * @method Mage_Sales_Model_Quote setBaseToQuoteRate(float $value)
 * @method string getCustomerTaxvat()
 * @method Mage_Sales_Model_Quote setCustomerTaxvat(string $value)
 * @method string getCustomerGender()
 * @method Mage_Sales_Model_Quote setCustomerGender(string $value)
 * @method float getSubtotal()
 * @method Mage_Sales_Model_Quote setSubtotal(float $value)
 * @method float getBaseSubtotal()
 * @method Mage_Sales_Model_Quote setBaseSubtotal(float $value)
 * @method float getSubtotalWithDiscount()
 * @method Mage_Sales_Model_Quote setSubtotalWithDiscount(float $value)
 * @method float getBaseSubtotalWithDiscount()
 * @method Mage_Sales_Model_Quote setBaseSubtotalWithDiscount(float $value)
 * @method int getIsChanged()
 * @method Mage_Sales_Model_Quote setIsChanged(int $value)
 * @method int getTriggerRecollect()
 * @method Mage_Sales_Model_Quote setTriggerRecollect(int $value)
 * @method string getExtShippingInfo()
 * @method Mage_Sales_Model_Quote setExtShippingInfo(string $value)
 * @method int getGiftMessageId()
 * @method Mage_Sales_Model_Quote setGiftMessageId(int $value)
 * @method bool|null getIsPersistent()
 * @method Mage_Sales_Model_Quote setIsPersistent(bool $value)
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Quote extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'sales_quote';
    protected $_eventObject = 'quote';

    /**
     * Quote customer model object
     *
     * @var Mage_Customer_Model_Customer
     */
    protected $_customer;

    /**
     * Quote addresses collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_addresses = null;

    /**
     * Quote items collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_items = null;

    /**
     * Quote payments
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_payments = null;

    /**
     * Different groups of error infos
     *
     * @var array
     */
    protected $_errorInfoGroups = array();

    /**
     * Whether quote should not be saved
     *
     * @var bool
     */
    protected $_preventSaving = false;

    /**
     * Init resource model
     */
    protected function _construct()
    {
        $this->_init('sales/quote');
    }

    /**
     * Init mapping array of short fields to
     * its full names
     *
     * @return Varien_Object
     */
    protected function _initOldFieldsMap()
    {
        $this->_oldFieldsMap = Mage::helper('sales')->getOldFieldMap('quote');
        return $this;
    }

    /**
     * Get quote store identifier
     *
     * @return int
     */
    public function getStoreId()
    {
        if (!$this->hasStoreId()) {
            return Mage::app()->getStore()->getId();
        }
        return $this->_getData('store_id');
    }

    /**
     * Get quote store model object
     *
     * @return  Mage_Core_Model_Store
     */
    public function getStore()
    {
        return Mage::app()->getStore($this->getStoreId());
    }

    /**
     * Declare quote store model
     *
     * @param   Mage_Core_Model_Store $store
     * @return  Mage_Sales_Model_Quote
     */
    public function setStore(Mage_Core_Model_Store $store)
    {
        $this->setStoreId($store->getId());
        return $this;
    }

    /**
     * Get all available store ids for quote
     *
     * @return array
     */
    public function getSharedStoreIds()
    {
        $ids = $this->_getData('shared_store_ids');
        if (is_null($ids) || !is_array($ids)) {
            if ($website = $this->getWebsite()) {
                return $website->getStoreIds();
            }
            return $this->getStore()->getWebsite()->getStoreIds();
        }
        return $ids;
    }

    /**
     * Prepare data before save
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _beforeSave()
    {
        /**
         * Currency logic
         *
         * global - currency which is set for default in backend
         * base - currency which is set for current website. all attributes that
         *      have 'base_' prefix saved in this currency
         * store - all the time it was currency of website and all attributes
         *      with 'base_' were saved in this currency. From now on it is
         *      deprecated and will be duplication of base currency code.
         * quote/order - currency which was selected by customer or configured by
         *      admin for current store. currency in which customer sees
         *      price thought all checkout.
         *
         * Rates:
         *      store_to_base & store_to_quote/store_to_order - are deprecated
         *      base_to_global & base_to_quote/base_to_order - must be used instead
         */

        $globalCurrencyCode  = Mage::app()->getBaseCurrencyCode();
        $baseCurrency = $this->getStore()->getBaseCurrency();

        if ($this->hasForcedCurrency()){
            $quoteCurrency = $this->getForcedCurrency();
        } else {
            $quoteCurrency = $this->getStore()->getCurrentCurrency();
        }

        $this->setGlobalCurrencyCode($globalCurrencyCode);
        $this->setBaseCurrencyCode($baseCurrency->getCode());
        $this->setStoreCurrencyCode($baseCurrency->getCode());
        $this->setQuoteCurrencyCode($quoteCurrency->getCode());

        //deprecated, read above
        $this->setStoreToBaseRate($baseCurrency->getRate($globalCurrencyCode));
        $this->setStoreToQuoteRate($baseCurrency->getRate($quoteCurrency));

        $this->setBaseToGlobalRate($baseCurrency->getRate($globalCurrencyCode));
        $this->setBaseToQuoteRate($baseCurrency->getRate($quoteCurrency));

        if (!$this->hasChangedFlag() || $this->getChangedFlag() == true) {
            $this->setIsChanged(1);
        } else {
            $this->setIsChanged(0);
        }

        if ($this->_customer) {
            $this->setCustomerId($this->_customer->getId());
        }

        parent::_beforeSave();
    }

    /**
     * Save related items
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _afterSave()
    {
        parent::_afterSave();

        if (null !== $this->_addresses) {
            $this->getAddressesCollection()->save();
        }

        if (null !== $this->_items) {
            $this->getItemsCollection()->save();
        }

        if (null !== $this->_payments) {
            $this->getPaymentsCollection()->save();
        }
        return $this;
    }

    /**
     * Loading quote data by customer
     *
     * @return Mage_Sales_Model_Quote
     */
    public function loadByCustomer($customer)
    {
        if ($customer instanceof Mage_Customer_Model_Customer) {
            $customerId = $customer->getId();
        }
        else {
            $customerId = (int) $customer;
        }
        $this->_getResource()->loadByCustomerId($this, $customerId);
        $this->_afterLoad();
        return $this;
    }

    /**
     * Loading only active quote
     *
     * @param int $quoteId
     * @return Mage_Sales_Model_Quote
     */
    public function loadActive($quoteId)
    {
        $this->_getResource()->loadActive($this, $quoteId);
        $this->_afterLoad();
        return $this;
    }

    /**
     * Loading quote by identifier
     *
     * @param int $quoteId
     * @return Mage_Sales_Model_Quote
     */
    public function loadByIdWithoutStore($quoteId)
    {
        $this->_getResource()->loadByIdWithoutStore($this, $quoteId);
        $this->_afterLoad();
        return $this;
    }

    /**
     * Assign customer model object data to quote
     *
     * @param   Mage_Customer_Model_Customer $customer
     * @return  Mage_Sales_Model_Quote
     */
    public function assignCustomer(Mage_Customer_Model_Customer $customer)
    {
        return $this->assignCustomerWithAddressChange($customer);
    }

    /**
     * Assign customer model to quote with billing and shipping address change
     *
     * @param  Mage_Customer_Model_Customer    $customer
     * @param  Mage_Sales_Model_Quote_Address  $billingAddress
     * @param  Mage_Sales_Model_Quote_Address  $shippingAddress
     * @return Mage_Sales_Model_Quote
     */
    public function assignCustomerWithAddressChange(
        Mage_Customer_Model_Customer    $customer,
        Mage_Sales_Model_Quote_Address  $billingAddress  = null,
        Mage_Sales_Model_Quote_Address  $shippingAddress = null
    )
    {
        if ($customer->getId()) {
            $this->setCustomer($customer);

            if (!is_null($billingAddress)) {
                $this->setBillingAddress($billingAddress);
            } else {
                $defaultBillingAddress = $customer->getDefaultBillingAddress();
                if ($defaultBillingAddress && $defaultBillingAddress->getId()) {
                    $billingAddress = Mage::getModel('sales/quote_address')
                        ->importCustomerAddress($defaultBillingAddress);
                    $this->setBillingAddress($billingAddress);
                }
            }

            if (is_null($shippingAddress)) {
                $defaultShippingAddress = $customer->getDefaultShippingAddress();
                if ($defaultShippingAddress && $defaultShippingAddress->getId()) {
                    $shippingAddress = Mage::getModel('sales/quote_address')
                        ->importCustomerAddress($defaultShippingAddress);
                } else {
                    $shippingAddress = Mage::getModel('sales/quote_address');
                }
            }
            $this->setShippingAddress($shippingAddress);
        }

        return $this;
    }

    /**
     * Define customer object
     *
     * @param   Mage_Customer_Model_Customer $customer
     * @return  Mage_Sales_Model_Quote
     */
    public function setCustomer(Mage_Customer_Model_Customer $customer)
    {
        $this->_customer = $customer;
        $this->setCustomerId($customer->getId());
        Mage::helper('core')->copyFieldset('customer_account', 'to_quote', $customer, $this);
        return $this;
    }

    /**
     * Retrieve customer model object
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomer()
    {
        if (is_null($this->_customer)) {
            $this->_customer = Mage::getModel('customer/customer');
            if ($customerId = $this->getCustomerId()) {
                $this->_customer->load($customerId);
                if (!$this->_customer->getId()) {
                    $this->_customer->setCustomerId(null);
                }
            }
        }
        return $this->_customer;
    }

    /**
     * Retrieve customer group id
     *
     * @return int
     */
    public function getCustomerGroupId()
    {
        if ($this->hasData('customer_group_id')) {
            return $this->getData('customer_group_id');
        } else if ($this->getCustomerId()) {
            return $this->getCustomer()->getGroupId();
        } else {
            return Mage_Customer_Model_Group::NOT_LOGGED_IN_ID;
        }
    }

    public function getCustomerTaxClassId()
    {
        /*
        * tax class can vary at any time. so instead of using the value from session,
        * we need to retrieve from db every time to get the correct tax class
        */
        //if (!$this->getData('customer_group_id') && !$this->getData('customer_tax_class_id')) {
        $classId = Mage::getModel('customer/group')->getTaxClassId($this->getCustomerGroupId());
        $this->setCustomerTaxClassId($classId);
        //}

        return $this->getData('customer_tax_class_id');
    }

    /**
     * Retrieve quote address collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getAddressesCollection()
    {
        if (is_null($this->_addresses)) {
            $this->_addresses = Mage::getModel('sales/quote_address')->getCollection()
                ->setQuoteFilter($this->getId());

            if ($this->getId()) {
                foreach ($this->_addresses as $address) {
                    $address->setQuote($this);
                }
            }
        }
        return $this->_addresses;
    }

    /**
     * Retrieve quote address by type
     *
     * @param   string $type
     * @return  Mage_Sales_Model_Quote_Address
     */
    protected function _getAddressByType($type)
    {
        foreach ($this->getAddressesCollection() as $address) {
            if ($address->getAddressType() == $type && !$address->isDeleted()) {
                return $address;
            }
        }

        $address = Mage::getModel('sales/quote_address')->setAddressType($type);
        $this->addAddress($address);
        return $address;
    }

    /**
     * Retrieve quote billing address
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getBillingAddress()
    {
        return $this->_getAddressByType(Mage_Sales_Model_Quote_Address::TYPE_BILLING);
    }

    /**
     * retrieve quote shipping address
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getShippingAddress()
    {
        return $this->_getAddressByType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING);
    }

    public function getAllShippingAddresses()
    {
        $addresses = array();
        foreach ($this->getAddressesCollection() as $address) {
            if ($address->getAddressType()==Mage_Sales_Model_Quote_Address::TYPE_SHIPPING
                && !$address->isDeleted()) {
                $addresses[] = $address;
            }
        }
        return $addresses;
    }

    public function getAllAddresses()
    {
        $addresses = array();
        foreach ($this->getAddressesCollection() as $address) {
            if (!$address->isDeleted()) {
                $addresses[] = $address;
            }
        }
        return $addresses;
    }

    /**
     *
     * @param int $addressId
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getAddressById($addressId)
    {
        foreach ($this->getAddressesCollection() as $address) {
            if ($address->getId()==$addressId) {
                return $address;
            }
        }
        return false;
    }

    public function getAddressByCustomerAddressId($addressId)
    {
        foreach ($this->getAddressesCollection() as $address) {
            if (!$address->isDeleted() && $address->getCustomerAddressId()==$addressId) {
                return $address;
            }
        }
        return false;
    }

    public function getShippingAddressByCustomerAddressId($addressId)
    {
        foreach ($this->getAddressesCollection() as $address) {
            if (!$address->isDeleted() && $address->getAddressType()==Mage_Sales_Model_Quote_Address::TYPE_SHIPPING
                && $address->getCustomerAddressId()==$addressId) {
                return $address;
            }
        }
        return false;
    }

    public function removeAddress($addressId)
    {
        foreach ($this->getAddressesCollection() as $address) {
            if ($address->getId()==$addressId) {
                $address->isDeleted(true);
                break;
            }
        }
        return $this;
    }

    public function removeAllAddresses()
    {
        foreach ($this->getAddressesCollection() as $address) {
            $address->isDeleted(true);
        }
        return $this;
    }

    public function addAddress(Mage_Sales_Model_Quote_Address $address)
    {
        $address->setQuote($this);
        if (!$address->getId()) {
            $this->getAddressesCollection()->addItem($address);
        }
        return $this;
    }

    /**
     * Enter description here...
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote
     */
    public function setBillingAddress(Mage_Sales_Model_Quote_Address $address)
    {
        $old = $this->getBillingAddress();

        if (!empty($old)) {
            $old->addData($address->getData());
        } else {
            $this->addAddress($address->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING));
        }
        return $this;
    }

    /**
     * Enter description here...
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote
     */
    public function setShippingAddress(Mage_Sales_Model_Quote_Address $address)
    {
        if ($this->getIsMultiShipping()) {
            $this->addAddress($address->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING));
        }
        else {
            $old = $this->getShippingAddress();

            if (!empty($old)) {
                $old->addData($address->getData());
            } else {
                $this->addAddress($address->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING));
            }
        }
        return $this;
    }

    public function addShippingAddress(Mage_Sales_Model_Quote_Address $address)
    {
        $this->setShippingAddress($address);
        return $this;
    }

    /**
     * Retrieve quote items collection
     *
     * @param   bool $loaded
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getItemsCollection($useCache = true)
    {
        if ($this->hasItemsCollection()) {
            return $this->getData('items_collection');
        }
        if (is_null($this->_items)) {
            $this->_items = Mage::getModel('sales/quote_item')->getCollection();
            $this->_items->setQuote($this);
        }
        return $this->_items;
    }

    /**
     * Retrieve quote items array
     *
     * @return array
     */
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

    /**
     * Get array of all items what can be display directly
     *
     * @return array
     */
    public function getAllVisibleItems()
    {
        $items = array();
        foreach ($this->getItemsCollection() as $item) {
            if (!$item->isDeleted() && !$item->getParentItemId()) {
                $items[] =  $item;
            }
        }
        return $items;
    }

    /**
     * Checking items availability
     *
     * @return bool
     */
    public function hasItems()
    {
        return sizeof($this->getAllItems())>0;
    }

    /**
     * Checking availability of items with decimal qty
     *
     * @return bool
     */
    public function hasItemsWithDecimalQty()
    {
        foreach ($this->getAllItems() as $item) {
            if ($item->getProduct()->getStockItem()
                && $item->getProduct()->getStockItem()->getIsQtyDecimal()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checking product exist in Quote
     *
     * @param int $productId
     * @return bool
     */
    public function hasProductId($productId)
    {
        foreach ($this->getAllItems() as $item) {
            if ($item->getProductId() == $productId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve item model object by item identifier
     *
     * @param   int $itemId
     * @return  Mage_Sales_Model_Quote_Item
     */
    public function getItemById($itemId)
    {
        return $this->getItemsCollection()->getItemById($itemId);
    }

    /**
     * Remove quote item by item identifier
     *
     * @param   int $itemId
     * @return  Mage_Sales_Model_Quote
     */
    public function removeItem($itemId)
    {
        $item = $this->getItemById($itemId);

        if ($item) {
            $item->setQuote($this);
            /**
             * If we remove item from quote - we can't use multishipping mode
             */
            $this->setIsMultiShipping(false);
            $item->isDeleted(true);
            if ($item->getHasChildren()) {
                foreach ($item->getChildren() as $child) {
                    $child->isDeleted(true);
                }
            }

            $parent = $item->getParentItem();
            if ($parent) {
                $parent->isDeleted(true);
            }

            Mage::dispatchEvent('sales_quote_remove_item', array('quote_item' => $item));
        }

        return $this;
    }

    /**
     * Mark all quote items as deleted (empty quote)
     *
     * @return Mage_Sales_Model_Quote
     */
    public function removeAllItems()
    {
        foreach ($this->getItemsCollection() as $itemId => $item) {
            if (is_null($item->getId())) {
                $this->getItemsCollection()->removeItemByKey($itemId);
            } else {
                $item->isDeleted(true);
            }
        }
        return $this;
    }

    /**
     * Adding new item to quote
     *
     * @param   Mage_Sales_Model_Quote_Item $item
     * @return  Mage_Sales_Model_Quote
     */
    public function addItem(Mage_Sales_Model_Quote_Item $item)
    {
        /**
         * Temporary workaround for purchase process: it is too dangerous to purchase more than one nominal item
         * or a mixture of nominal and non-nominal items, although technically possible.
         *
         * The problem is that currently it is implemented as sequential submission of nominal items and order, by one click.
         * It makes logically impossible to make the process of the purchase failsafe.
         * Proper solution is to submit items one by one with customer confirmation each time.
         */
        if ($item->isNominal() && $this->hasItems() || $this->hasNominalItems()) {
            Mage::throwException(
                Mage::helper('sales')->__('Nominal item can be purchased standalone only. To proceed please remove other items from the quote.')
            );
        }

        $item->setQuote($this);
        if (!$item->getId()) {
            $this->getItemsCollection()->addItem($item);
            Mage::dispatchEvent('sales_quote_add_item', array('quote_item' => $item));
        }
        return $this;
    }

    /**
     * Advanced func to add product to quote - processing mode can be specified there.
     * Returns error message if product type instance can't prepare product.
     *
     * @param mixed $product
     * @param null|float|Varien_Object $request
     * @param null|string $processMode
     * @return Mage_Sales_Model_Quote_Item|string
     */
    public function addProductAdvanced(Mage_Catalog_Model_Product $product, $request = null, $processMode = null)
    {
        if ($request === null) {
            $request = 1;
        }
        if (is_numeric($request)) {
            $request = new Varien_Object(array('qty'=>$request));
        }
        if (!($request instanceof Varien_Object)) {
            Mage::throwException(Mage::helper('sales')->__('Invalid request for adding product to quote.'));
        }

        $cartCandidates = $product->getTypeInstance(true)
            ->prepareForCartAdvanced($request, $product, $processMode);

        /**
         * Error message
         */
        if (is_string($cartCandidates)) {
            return $cartCandidates;
        }

        /**
         * If prepare process return one object
         */
        if (!is_array($cartCandidates)) {
            $cartCandidates = array($cartCandidates);
        }

        $parentItem = null;
        $errors = array();
        $items = array();
        foreach ($cartCandidates as $candidate) {
            // Child items can be sticked together only within their parent
            $stickWithinParent = $candidate->getParentProductId() ? $parentItem : null;
            $candidate->setStickWithinParent($stickWithinParent);
            $item = $this->_addCatalogProduct($candidate, $candidate->getCartQty());
            if($request->getResetCount() && !$stickWithinParent && $item->getId() === $request->getId()) {
                $item->setData('qty', 0);
            }
            $items[] = $item;

            /**
             * As parent item we should always use the item of first added product
             */
            if (!$parentItem) {
                $parentItem = $item;
            }
            if ($parentItem && $candidate->getParentProductId()) {
                $item->setParentItem($parentItem);
            }

            /**
             * We specify qty after we know about parent (for stock)
             */
            $item->addQty($candidate->getCartQty());

            // collect errors instead of throwing first one
            if ($item->getHasError()) {
                $message = $item->getMessage();
                if (!in_array($message, $errors)) { // filter duplicate messages
                    $errors[] = $message;
                }
            }
        }
        if (!empty($errors)) {
            Mage::throwException(implode("\n", $errors));
        }

        Mage::dispatchEvent('sales_quote_product_add_after', array('items' => $items));

        return $item;
    }


    /**
     * Add product to quote
     *
     * return error message if product type instance can't prepare product
     *
     * @param mixed $product
     * @param null|float|Varien_Object $request
     * @return Mage_Sales_Model_Quote_Item|string
     */
    public function addProduct(Mage_Catalog_Model_Product $product, $request = null)
    {
        return $this->addProductAdvanced(
            $product,
            $request,
            Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL
        );
    }

    /**
     * Adding catalog product object data to quote
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  Mage_Sales_Model_Quote_Item
     */
    protected function _addCatalogProduct(Mage_Catalog_Model_Product $product, $qty = 1)
    {
        $newItem = false;
        $item = $this->getItemByProduct($product);
        if (!$item) {
            $item = Mage::getModel('sales/quote_item');
            $item->setQuote($this);
            if (Mage::app()->getStore()->isAdmin()) {
                $item->setStoreId($this->getStore()->getId());
            }
            else {
                $item->setStoreId(Mage::app()->getStore()->getId());
            }
            $newItem = true;
        }

        /**
         * We can't modify existing child items
         */
        if ($item->getId() && $product->getParentProductId()) {
            return $item;
        }

        $item->setOptions($product->getCustomOptions())
            ->setProduct($product);

        // Add only item that is not in quote already (there can be other new or already saved item
        if ($newItem) {
            $this->addItem($item);
        }

        return $item;
    }

    /**
     * Updates quote item with new configuration
     *
     * $params sets how current item configuration must be taken into account and additional options.
     * It's passed to Mage_Catalog_Helper_Product->addParamsToBuyRequest() to compose resulting buyRequest.
     *
     * Basically it can hold
     * - 'current_config', Varien_Object or array - current buyRequest that configures product in this item,
     *   used to restore currently attached files
     * - 'files_prefix': string[a-z0-9_] - prefix that was added at frontend to names of file options (file inputs), so they won't
     *   intersect with other submitted options
     *
     * For more options see Mage_Catalog_Helper_Product->addParamsToBuyRequest()
     *
     * @param int $itemId
     * @param Varien_Object $buyRequest
     * @param null|array|Varien_Object $params
     * @return Mage_Sales_Model_Quote_Item
     *
     * @see Mage_Catalog_Helper_Product::addParamsToBuyRequest()
     */
    public function updateItem($itemId, $buyRequest, $params = null)
    {
        $item = $this->getItemById($itemId);
        if (!$item) {
            Mage::throwException(Mage::helper('sales')->__('Wrong quote item id to update configuration.'));
        }
        $productId = $item->getProduct()->getId();

        //We need to create new clear product instance with same $productId
        //to set new option values from $buyRequest
        $product = Mage::getModel('catalog/product')
            ->setStoreId($this->getStore()->getId())
            ->load($productId);

        if (!$params) {
            $params = new Varien_Object();
        } else if (is_array($params)) {
            $params = new Varien_Object($params);
        }
        $params->setCurrentConfig($item->getBuyRequest());
        $buyRequest = Mage::helper('catalog/product')->addParamsToBuyRequest($buyRequest, $params);

        $buyRequest->setResetCount(true);
        $resultItem = $this->addProduct($product, $buyRequest);

        if (is_string($resultItem)) {
            Mage::throwException($resultItem);
        }

        if ($resultItem->getParentItem()) {
            $resultItem = $resultItem->getParentItem();
        }

        if ($resultItem->getId() != $itemId) {
            /*
             * Product configuration didn't stick to original quote item
             * It either has same configuration as some other quote item's product or completely new configuration
             */
            $this->removeItem($itemId);

            $items = $this->getAllItems();
            foreach ($items as $item) {
                if (($item->getProductId() == $productId) && ($item->getId() != $resultItem->getId())) {
                    if ($resultItem->compare($item)) {
                        // Product configuration is same as in other quote item
                        $resultItem->setQty($resultItem->getQty() + $item->getQty());
                        $this->removeItem($item->getId());
                        break;
                    }
                }
            }
        } else {
            $resultItem->setQty($buyRequest->getQty());
        }

        return $resultItem;
    }

    /**
     * Retrieve quote item by product id
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  Mage_Sales_Model_Quote_Item || false
     */
    public function getItemByProduct($product)
    {
        foreach ($this->getAllItems() as $item) {
            if ($item->representProduct($product)) {
                return $item;
            }
        }
        return false;
    }

    public function getItemsSummaryQty()
    {
        $qty = $this->getData('all_items_qty');
        if (is_null($qty)) {
            $qty = 0;
            foreach ($this->getAllItems() as $item) {
                if ($item->getParentItem()) {
                    continue;
                }

                if (($children = $item->getChildren()) && $item->isShipSeparately()) {
                    foreach ($children as $child) {
                        $qty+= $child->getQty()*$item->getQty();
                    }
                } else {
                    $qty+= $item->getQty();
                }
            }
            $this->setData('all_items_qty', $qty);
        }
        return $qty;
    }

    public function getItemVirtualQty()
    {
        $qty = $this->getData('virtual_items_qty');
        if (is_null($qty)) {
            $qty = 0;
            foreach ($this->getAllItems() as $item) {
                if ($item->getParentItem()) {
                    continue;
                }

                if (($children = $item->getChildren()) && $item->isShipSeparately()) {
                    foreach ($children as $child) {
                        if ($child->getProduct()->getIsVirtual()) {
                            $qty+= $child->getQty();
                        }
                    }
                } else {
                    if ($item->getProduct()->getIsVirtual()) {
                        $qty+= $item->getQty();
                    }
                }
            }
            $this->setData('virtual_items_qty', $qty);
        }
        return $qty;
    }

    /*********************** PAYMENTS ***************************/
    public function getPaymentsCollection()
    {
        if (is_null($this->_payments)) {
            $this->_payments = Mage::getModel('sales/quote_payment')->getCollection()
                ->setQuoteFilter($this->getId());

            if ($this->getId()) {
                foreach ($this->_payments as $payment) {
                    $payment->setQuote($this);
                }
            }
        }
        return $this->_payments;
    }

    /**
     * @return Mage_Sales_Model_Quote_Payment
     */
    public function getPayment()
    {
        foreach ($this->getPaymentsCollection() as $payment) {
            if (!$payment->isDeleted()) {
                return $payment;
            }
        }
        $payment = Mage::getModel('sales/quote_payment');
        $this->addPayment($payment);
        return $payment;
    }

    public function getPaymentById($paymentId)
    {
        foreach ($this->getPaymentsCollection() as $payment) {
            if ($payment->getId()==$paymentId) {
                return $payment;
            }
        }
        return false;
    }

    public function addPayment(Mage_Sales_Model_Quote_Payment $payment)
    {
        $payment->setQuote($this);
        if (!$payment->getId()) {
            $this->getPaymentsCollection()->addItem($payment);
        }
        return $this;
    }

    public function setPayment(Mage_Sales_Model_Quote_Payment $payment)
    {
        if (!$this->getIsMultiPayment() && ($old = $this->getPayment())) {
            $payment->setId($old->getId());
        }
        $this->addPayment($payment);

        return $payment;
    }

    public function removePayment()
    {
        $this->getPayment()->isDeleted(true);
        return $this;
    }

    /**
     * Collect totals
     *
     * @return Mage_Sales_Model_Quote
     */
    public function collectTotals()
    {
        /**
         * Protect double totals collection
         */
        if ($this->getTotalsCollectedFlag()) {
            return $this;
        }
        Mage::dispatchEvent($this->_eventPrefix . '_collect_totals_before', array($this->_eventObject => $this));

        $this->setSubtotal(0);
        $this->setBaseSubtotal(0);

        $this->setSubtotalWithDiscount(0);
        $this->setBaseSubtotalWithDiscount(0);

        $this->setGrandTotal(0);
        $this->setBaseGrandTotal(0);

        foreach ($this->getAllAddresses() as $address) {
            $address->setSubtotal(0);
            $address->setBaseSubtotal(0);

            $address->setGrandTotal(0);
            $address->setBaseGrandTotal(0);

            $address->collectTotals();

            $this->setSubtotal((float) $this->getSubtotal() + $address->getSubtotal());
            $this->setBaseSubtotal((float) $this->getBaseSubtotal() + $address->getBaseSubtotal());

            $this->setSubtotalWithDiscount(
                (float) $this->getSubtotalWithDiscount() + $address->getSubtotalWithDiscount()
            );
            $this->setBaseSubtotalWithDiscount(
                (float) $this->getBaseSubtotalWithDiscount() + $address->getBaseSubtotalWithDiscount()
            );

            $this->setGrandTotal((float) $this->getGrandTotal() + $address->getGrandTotal());
            $this->setBaseGrandTotal((float) $this->getBaseGrandTotal() + $address->getBaseGrandTotal());
        }

        Mage::helper('sales')->checkQuoteAmount($this, $this->getGrandTotal());
        Mage::helper('sales')->checkQuoteAmount($this, $this->getBaseGrandTotal());

        $this->setItemsCount(0);
        $this->setItemsQty(0);
        $this->setVirtualItemsQty(0);

        foreach ($this->getAllVisibleItems() as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            $children = $item->getChildren();
            if ($children && $item->isShipSeparately()) {
                foreach ($children as $child) {
                    if ($child->getProduct()->getIsVirtual()) {
                        $this->setVirtualItemsQty($this->getVirtualItemsQty() + $child->getQty()*$item->getQty());
                    }
                }
            }

            if ($item->getProduct()->getIsVirtual()) {
                $this->setVirtualItemsQty($this->getVirtualItemsQty() + $item->getQty());
            }
            $this->setItemsCount($this->getItemsCount()+1);
            $this->setItemsQty((float) $this->getItemsQty()+$item->getQty());
        }

        $this->setData('trigger_recollect', 0);
        $this->_validateCouponCode();

        Mage::dispatchEvent($this->_eventPrefix . '_collect_totals_after', array($this->_eventObject => $this));

        $this->setTotalsCollectedFlag(true);
        return $this;
    }

    /**
     * Get all quote totals (sorted by priority)
     * Method process quote states isVirtual and isMultiShipping
     *
     * @return array
     */
    public function getTotals()
    {
        /**
         * If quote is virtual we are using totals of billing address because
         * all items assigned to it
         */
        if ($this->isVirtual()) {
            return $this->getBillingAddress()->getTotals();
        }

        $shippingAddress = $this->getShippingAddress();
        $totals = $shippingAddress->getTotals();
        // Going through all quote addresses and merge their totals
        foreach ($this->getAddressesCollection() as $address) {
            if ($address->isDeleted() || $address === $shippingAddress) {
                continue;
            }
            foreach ($address->getTotals() as $code => $total) {
                if (isset($totals[$code])) {
                    $totals[$code]->merge($total);
                } else {
                    $totals[$code] = $total;
                }
            }
        }

        $sortedTotals = array();
        foreach ($this->getBillingAddress()->getTotalModels() as $total) {
            /* @var $total Mage_Sales_Model_Quote_Address_Total_Abstract */
            if (isset($totals[$total->getCode()])) {
                $sortedTotals[$total->getCode()] = $totals[$total->getCode()];
            }
        }
        return $sortedTotals;
    }

    public function addMessage($message, $index = 'error')
    {
        $messages = $this->getData('messages');
        if (is_null($messages)) {
            $messages = array();
        }

        if (isset($messages[$index])) {
            return $this;
        }

        if (is_string($message)) {
            $message = Mage::getSingleton('core/message')->error($message);
        }

        $messages[$index] = $message;
        $this->setData('messages', $messages);
        return $this;
    }

    /**
     * Retrieve current quote messages
     *
     * @return array
     */
    public function getMessages()
    {
        $messages = $this->getData('messages');
        if (is_null($messages)) {
            $messages = array();
            $this->setData('messages', $messages);
        }
        return $messages;
    }

    /**
     * Retrieve current quote errors
     *
     * @return array
     */
    public function getErrors()
    {
        $errors = array();
        foreach ($this->getMessages() as $message) {
            /* @var $error Mage_Core_Model_Message_Abstract */
            if ($message->getType() == Mage_Core_Model_Message::ERROR) {
                array_push($errors, $message);
            }
        }
        return $errors;
    }

    /**
     * Sets flag, whether this quote has some error associated with it.
     *
     * @param bool $flag
     * @return Mage_Sales_Model_Quote
     */
    protected function _setHasError($flag)
    {
        return $this->setData('has_error', $flag);
    }

    /**
     * Sets flag, whether this quote has some error associated with it.
     * When TRUE - also adds 'unknown' error information to list of quote errors.
     * When FALSE - clears whole list of quote errors.
     * It's recommended to use addErrorInfo() instead - to be able to remove error statuses later.
     *
     * @param bool $flag
     * @return Mage_Sales_Model_Quote
     * @see addErrorInfo()
     */
    public function setHasError($flag)
    {
        if ($flag) {
            $this->addErrorInfo();
        } else {
            $this->_clearErrorInfo();
        }
        return $this;
    }

    /**
     * Clears list of errors, associated with this quote.
     * Also automatically removes error-flag from oneself.
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _clearErrorInfo()
    {
        $this->_errorInfoGroups = array();
        $this->_setHasError(false);
        return $this;
    }

    /**
     * Adds error information to the quote.
     * Automatically sets error flag.
     *
     * @param string $type An internal error type ('error', 'qty', etc.), passed then to adding messages routine
     * @param string|null $origin Usually a name of module, that embeds error
     * @param int|null $code Error code, unique for origin, that sets it
     * @param string|null $message Error message
     * @param Varien_Object|null $additionalData Any additional data, that caller would like to store
     * @return Mage_Sales_Model_Quote
     */
    public function addErrorInfo($type = 'error', $origin = null, $code = null, $message = null, $additionalData = null)
    {
        if (!isset($this->_errorInfoGroups[$type])) {
            $this->_errorInfoGroups[$type] = Mage::getModel('sales/status_list');
        }

        $this->_errorInfoGroups[$type]->addItem($origin, $code, $message, $additionalData);

        if ($message !== null) {
            $this->addMessage($message, $type);
        }
        $this->_setHasError(true);

        return $this;
    }

    /**
     * Removes error infos, that have parameters equal to passed in $params.
     * $params can have following keys (if not set - then any item is good for this key):
     *   'origin', 'code', 'message'
     *
     * @param string $type An internal error type ('error', 'qty', etc.), passed then to adding messages routine
     * @param array $params
     * @return Mage_Sales_Model_Quote
     */
    public function removeErrorInfosByParams($type = 'error', $params)
    {
        if ($type && !isset($this->_errorInfoGroups[$type])) {
            return $this;
        }

        $errorLists = array();
        if ($type) {
            $errorLists[] = $this->_errorInfoGroups[$type];
        } else {
            $errorLists = $this->_errorInfoGroups;
        }

        foreach ($errorLists as $type => $errorList) {
            $removedItems = $errorList->removeItemsByParams($params);
            foreach ($removedItems as $item) {
                if ($item['message'] !== null) {
                    $this->removeMessageByText($type, $item['message']);
                }
            }
        }

        $errorsExist = false;
        foreach ($this->_errorInfoGroups as $errorListCheck) {
            if ($errorListCheck->getItems()) {
                $errorsExist = true;
                break;
            }
        }
        if (!$errorsExist) {
            $this->_setHasError(false);
        }

        return $this;
    }

    /**
     * Removes message by text
     *
     * @param string $type
     * @param string $text
     * @return Mage_Sales_Model_Quote
     */
    public function removeMessageByText($type = 'error', $text)
    {
        $messages = $this->getData('messages');
        if (is_null($messages)) {
            $messages = array();
        }

        if (!isset($messages[$type])) {
            return $this;
        }

        $message = $messages[$type];
        if ($message instanceof Mage_Core_Model_Message_Abstract) {
            $message = $message->getText();
        } else if (!is_string($message)) {
            return $this;
        }
        if ($message == $text) {
            unset($messages[$type]);
            $this->setData('messages', $messages);
        }
        return $this;
    }

    /**
     * Generate new increment order id and associate it with current quote
     *
     * @return Mage_Sales_Model_Quote
     */
    public function reserveOrderId()
    {
        if (!$this->getReservedOrderId()) {
            $this->setReservedOrderId($this->_getResource()->getReservedOrderId($this));
        } else {
            //checking if reserved order id was already used for some order
            //if yes reserving new one if not using old one
            if ($this->_getResource()->isOrderIncrementIdUsed($this->getReservedOrderId())) {
                $this->setReservedOrderId($this->_getResource()->getReservedOrderId($this));
            }
        }
        return $this;
    }

    public function validateMinimumAmount($multishipping = false)
    {
        $storeId = $this->getStoreId();
        $minOrderActive = Mage::getStoreConfigFlag('sales/minimum_order/active', $storeId);
        $minOrderMulti  = Mage::getStoreConfigFlag('sales/minimum_order/multi_address', $storeId);
        $minAmount      = Mage::getStoreConfig('sales/minimum_order/amount', $storeId);

        if (!$minOrderActive) {
            return true;
        }

        $addresses = $this->getAllAddresses();

        if ($multishipping) {
            if ($minOrderMulti) {
                foreach ($addresses as $address) {
                    foreach ($address->getQuote()->getItemsCollection() as $item) {
                        $amount = $item->getBaseRowTotal() - $item->getBaseDiscountAmount();
                        if ($amount < $minAmount) {
                            return false;
                        }
                    }
                }
            } else {
                $baseTotal = 0;
                foreach ($addresses as $address) {
                    /* @var $address Mage_Sales_Model_Quote_Address */
                    $baseTotal += $address->getBaseSubtotalWithDiscount();
                }
                if ($baseTotal < $minAmount) {
                    return false;
                }
            }
        } else {
            foreach ($addresses as $address) {
                /* @var $address Mage_Sales_Model_Quote_Address */
                if (!$address->validateMinimumAmount()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Check quote for virtual product only
     *
     * @return bool
     */
    public function isVirtual()
    {
        $isVirtual = true;
        $countItems = 0;
        foreach ($this->getItemsCollection() as $_item) {
            /* @var $_item Mage_Sales_Model_Quote_Item */
            if ($_item->isDeleted() || $_item->getParentItemId()) {
                continue;
            }
            $countItems ++;
            if (!$_item->getProduct()->getIsVirtual()) {
                $isVirtual = false;
                break;
            }
        }
        return $countItems == 0 ? false : $isVirtual;
    }

    /**
     * Check quote for virtual product only
     *
     * @return bool
     */
    public function getIsVirtual()
    {
        return intval($this->isVirtual());
    }

    /**
     * Has a virtual products on quote
     *
     * @return bool
     */
    public function hasVirtualItems()
    {
        $hasVirtual = false;
        foreach ($this->getItemsCollection() as $_item) {
            if ($_item->getParentItemId()) {
                continue;
            }
            if ($_item->getProduct()->isVirtual()) {
                $hasVirtual = true;
            }
        }
        return $hasVirtual;
    }

    /**
     * Merge quotes
     *
     * @param   Mage_Sales_Model_Quote $quote
     * @return  Mage_Sales_Model_Quote
     */
    public function merge(Mage_Sales_Model_Quote $quote)
    {
        Mage::dispatchEvent(
            $this->_eventPrefix . '_merge_before',
            array(
                 $this->_eventObject=>$this,
                 'source'=>$quote
            )
        );

        foreach ($quote->getAllVisibleItems() as $item) {
            $found = false;
            foreach ($this->getAllItems() as $quoteItem) {
                if ($quoteItem->compare($item)) {
                    $quoteItem->setQty($quoteItem->getQty() + $item->getQty());
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $newItem = clone $item;
                $this->addItem($newItem);
                if ($item->getHasChildren()) {
                    foreach ($item->getChildren() as $child) {
                        $newChild = clone $child;
                        $newChild->setParentItem($newItem);
                        $this->addItem($newChild);
                    }
                }
            }
        }

        /**
         * Init shipping and billing address if quote is new
         */
        if (!$this->getId()) {
            $this->getShippingAddress();
            $this->getBillingAddress();
        }

        if ($quote->getCouponCode()) {
            $this->setCouponCode($quote->getCouponCode());
        }

        Mage::dispatchEvent(
            $this->_eventPrefix . '_merge_after',
            array(
                 $this->_eventObject=>$this,
                 'source'=>$quote
            )
        );

        return $this;
    }

    /**
     * Whether there are recurring items
     *
     * @return bool
     */
    public function hasRecurringItems()
    {
        foreach ($this->getAllVisibleItems() as $item) {
            if ($item->getProduct() && $item->getProduct()->isRecurring()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Getter whether quote has nominal items
     * Can bypass treating virtual items as nominal
     *
     * @param bool $countVirtual
     * @return bool
     */
    public function hasNominalItems($countVirtual = true)
    {
        foreach ($this->getAllVisibleItems() as $item) {
            if ($item->isNominal()) {
                if ((!$countVirtual) && $item->getProduct()->isVirtual()) {
                    continue;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Whether quote has nominal items only
     *
     * @return bool
     */
    public function isNominal()
    {
        foreach ($this->getAllVisibleItems() as $item) {
            if (!$item->isNominal()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Create recurring payment profiles basing on the current items
     *
     * @return array
     */
    public function prepareRecurringPaymentProfiles()
    {
        if (!$this->getTotalsCollectedFlag()) {
            // Whoops! Make sure nominal totals must be calculated here.
            throw new Exception('Quote totals must be collected before this operation.');
        }

        $result = array();
        foreach ($this->getAllVisibleItems() as $item) {
            $product = $item->getProduct();
            if (is_object($product) && ($product->isRecurring())
                && $profile = Mage::getModel('sales/recurring_profile')->importProduct($product)
            ) {
                $profile->importQuote($this);
                $profile->importQuoteItem($item);
                $result[] = $profile;
            }
        }
        return $result;
    }

    protected function _validateCouponCode()
    {
        $code = $this->_getData('coupon_code');
        if (strlen($code)) {
            $addressHasCoupon = false;
            $addresses = $this->getAllAddresses();
            if (count($addresses)>0) {
                foreach ($addresses as $address) {
                    if ($address->hasCouponCode()) {
                        $addressHasCoupon = true;
                    }
                }
                if (!$addressHasCoupon) {
                    $this->setCouponCode('');
                }
            }
        }
        return $this;
    }

    /**
     * Trigger collect totals after loading, if required
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _afterLoad()
    {
        // collect totals and save me, if required
        if (1 == $this->getData('trigger_recollect')) {
            $this->collectTotals()->save();
        }
        return parent::_afterLoad();
    }

    /**
     * @deprecated after 1.4 beta1 - one page checkout responsibility
     */
    const CHECKOUT_METHOD_REGISTER  = 'register';
    const CHECKOUT_METHOD_GUEST     = 'guest';
    const CHECKOUT_METHOD_LOGIN_IN  = 'login_in';

    /**
     * Return quote checkout method code
     *
     * @deprecated after 1.4 beta1 it is checkout module responsibility
     * @param boolean $originalMethod if true return defined method from begining
     * @return string
     */
    public function getCheckoutMethod($originalMethod = false)
    {
        if ($this->getCustomerId() && !$originalMethod) {
            return self::CHECKOUT_METHOD_LOGIN_IN;
        }
        return $this->_getData('checkout_method');
    }

    /**
     * Check is allow Guest Checkout
     *
     * @deprecated after 1.4 beta1 it is checkout module responsibility
     * @return bool
     */
    public function isAllowedGuestCheckout()
    {
        return Mage::helper('checkout')->isAllowedGuestCheckout($this, $this->getStoreId());
    }

    /**
     * Prevent quote from saving
     *
     * @return Mage_Sales_Model_Quote
     */
    public function preventSaving()
    {
        $this->_preventSaving = true;
        return $this;
    }

    /**
     * Save quote with prevention checking
     *
     * @return Mage_Sales_Model_Quote
     */
    public function save()
    {
        if ($this->_preventSaving) {
            return $this;
        }
        return parent::save();
    }
}
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
class Rewardpoints_Model_Quote extends Mage_Sales_Model_Quote
{
    protected function _validateCouponCode()
    {
        $code = $this->_getData('coupon_code');
        if ($code) {
            $addressHasCoupon = false;
            $addresses = $this->getAllAddresses();
            if (count($addresses)>0) {
                foreach ($addresses as $address) {
                    //if ($address->hasCouponCode()) {
                    if (preg_match("/".$code."/i", $address->getCouponCode())) {
                        $addressHasCoupon = true;
                    }
                }
                if (!$addressHasCoupon) {
                    $this->setCouponCode('');
                }
            }
        }
        return $this;
    }
    
    
    public function isAllowedGuestCheckout()
    {
        if (Mage::getStoreConfig('rewardpoints/registration/referral_guestallow', $this->getStoreId()) && Mage::getSingleton('rewardpoints/session')->getReferralUser()){
            return false;
        }
        return Mage::helper('checkout')->isAllowedGuestCheckout($this, $this->getStoreId());
    }
}
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
class Rewardpoints_Model_Referral extends Mage_Core_Model_Abstract
{
    
    const XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE       = 'rewardpoints/registration/subscription_email_template';
    const XML_PATH_SUBSCRIPTION_EMAIL_IDENTITY       = 'rewardpoints/registration/subscription_email_identity';

    const XML_PATH_CONFIRMATION_EMAIL_TEMPLATE       = 'rewardpoints/registration/confirmation_email_template';
    const XML_PATH_CONFIRMATION_EMAIL_IDENTITY       = 'rewardpoints/registration/confirmation_email_identity';
    


    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/referral');
    }

    public function getInvites($id){
        return $this->getCollection()->addClientFilter($id);
    }

    public function loadByEmail($customerEmail)
    {
        $this->addData($this->getResource()->loadByEmail($customerEmail));
        return $this;
    }
    
    //J2T Check referral
    public function loadByChildId($child_id)
    {
        $this->addData($this->getResource()->loadByChildId($child_id));
        return $this;
    }

    public function subscribe(Mage_Customer_Model_Customer $parent, $email, $name)
    {
        $this->setRewardpointsReferralParentId($parent->getId())
             ->setRewardpointsReferralEmail($email)
             ->setRewardpointsReferralName($name);
             
        if($this->sendSubscription($parent, $email, $name))
        {
            if($this->save())
                return true;
            else
                return false;
        }
        else
            return false;
        //return $this->save() && $this->sendSubscription($parent, $email, $name);
    }

    public function isSubscribed($email)
    {
        $collection = $this->getCollection()->addEmailFilter($email);
        return $collection->count() ? true : false;
    }

    public function isConfirmed($email)
    {
        $collection = $this->getCollection()->addFlagFilter(0);
        $collection->addEmailFilter($email);
        return $collection->count() ? false : true;
    }

    public function sendSubscription(Mage_Customer_Model_Customer $parent, $destination, $destination_name)
    {
        $this->setRewardpointsReferralParentId($parent->getId())
             ->setRewardpointsReferralEmail($destination)
             ->setRewardpointsReferralName($destination_name);
        
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        
        //$template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, $this->getStoreId());

        $email = Mage::getModel('core/email_template');
        /* @var $email Mage_Core_Model_Email_Template */
        //$email->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()));


        $template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        $recipient = array(
            'email' => $destination,
            'name'  => $destination_name
        );

        $sender  = array(
            //'name' => strip_tags($parent->getFirstname().' '.$parent->getLastname()),
            'name' => 'YOGASMOGA',
            //'email' => strip_tags($parent->getEmail())
            'email' => 'hello@yogasmoga.com'
        );

        $email->setDesignConfig(array('area'=>'frontend', 'store'=> Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template,
                    $sender,
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'parent'        => $parent,
                        'referral'      => $this,
                        'store_name'    => Mage::getModel('core/store')->load(Mage::app()->getStore()->getCode())->getName(),
                        'referral_url'  => Mage::getUrl('rewardpoints/index/goReferral', array("referrer" => $parent->getId()))
                        //'comment' => "This is test comment for testing purpose"
                    )
                );

        $translate->setTranslateInline(true);

        return $email->getSentSuccess();
    }

    public function sendConfirmation(Mage_Customer_Model_Customer $parent, Mage_Customer_Model_Customer $child, $destination)
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT COUNT(rewardpoints_referral_email) as cnt, rewardpoints_referral_parent_id as Id,CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=5),' ',(SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=7)) AS 'Name' FROM rewardpoints_referral rr WHERE rewardpoints_referral_status=1 AND rewardpoints_referral_parent_id=(SELECT entity_id FROM customer_entity ce WHERE ce.email='".$parent->getEmail()."')");
        $successreferalcount = 0;
        $customerId = 0;
        $customername = "";
        while ($row = $readresult->fetch() ) {
            $successreferalcount = $row['cnt'];
            $customerId = $row['Id'];
            $customername = $row['Name'];
        }
        if($successreferalcount >= 2)
        {
            try {
                $storeObj = Mage::getModel('core/store')->load(Mage::app()->getStore()->getId());
                $customerEmailId = $parent->getEmail();
                $customerFName = $parent->getFirstname();
                $customerLName = $parent->getLastname();
                        
    
                //load the custom template to the email  
                $emailTemplate = Mage::getModel('core/email_template')
                        ->loadDefault('custom_notification_template1');
               
                // it depends on the template variables
                $emailTemplateVariables = array();
                
                
                
                $emailTemplateVariables['customername'] = $customername;
                $emailTemplateVariables['customeremail'] = $customerEmailId;
                $emailTemplateVariables['referralcount'] = $successreferalcount;
                
                $readresult=$write->query("SELECT CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_child_id AND attribute_id=5),' ',(SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_child_id AND attribute_id=7)) AS 'Name',rewardpoints_referral_email AS 'Email' FROM rewardpoints_referral rr WHERE rr.rewardpoints_referral_parent_id=".$customerId." AND rr.rewardpoints_referral_status=1");
                $tableoutput = "<table border='1'><thead><tr><th>Name</th><th>Email</th></tr></thead><tbody>";
                while ($row = $readresult->fetch() ) {
                    $tableoutput .= "<tr><td>".$row['Name']."</td><td>".$row['Email']."</td></tr>";
                }
                $tableoutput .= "</tbody></table>";
                
                $emailTemplateVariables['referraldetails'] = $tableoutput;
                //$emailTemplateVariables['store'] = $storeObj;
                //$emailTemplateVariables['payment_html'] = $method;
           
    
                $emailTemplate->setSenderName('Referral Notification');
                $emailTemplate->setSenderEmail('report@yogasmoga.com');
                $emailTemplate->setType('html');
                $emailTemplate->setTemplateSubject($customername." (".$customerEmailId.") got ".$successreferalcount." successfull referrals");
                $emailTemplate->send("oksana.gervas@yogasmoga.com", "Oksana Gervas", $emailTemplateVariables);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                //return $errorMessage;
                Mage::log($errorMessage,null,'notification.log');
            }      
        }
        
        
        
        
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');
        /* @var $email Mage_Core_Model_Email_Template */        

        $template = Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        $recipient = array(
            'email' => $destination,
            'name'  => $destination
        );

        $sender  = Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_EMAIL_IDENTITY);

        $email->setDesignConfig(array('area'=>'frontend', 'store'=>Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template,
                    $sender,
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'parent'   => $parent,
                        'child'   => $child,
                        'referral' => $this,
                        'store_name' => Mage::getModel('core/store')->load(Mage::app()->getStore()->getCode())->getName()
                    )
                );

        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }

}
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
 * @package     Mage_Review
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Review model
 *
 * @method Mage_Review_Model_Resource_Review _getResource()
 * @method Mage_Review_Model_Resource_Review getResource()
 * @method string getCreatedAt()
 * @method Mage_Review_Model_Review setCreatedAt(string $value)
 * @method Mage_Review_Model_Review setEntityId(int $value)
 * @method int getEntityPkValue()
 * @method Mage_Review_Model_Review setEntityPkValue(int $value)
 * @method int getStatusId()
 * @method Mage_Review_Model_Review setStatusId(int $value)
 *
 * @category    Mage
 * @package     Mage_Review
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Review_Model_Review extends Mage_Core_Model_Abstract
{

    /**
     * Event prefix for observer
     *
     * @var string
     */
    protected $_eventPrefix = 'review';

    /**
     * @deprecated after 1.3.2.4
     *
     */
    const ENTITY_PRODUCT = 1;

    /**
     * Review entity codes
     *
     */
    const ENTITY_PRODUCT_CODE   = 'product';
    const ENTITY_CUSTOMER_CODE  = 'customer';
    const ENTITY_CATEGORY_CODE  = 'category';

    const STATUS_APPROVED       = 1;
    const STATUS_PENDING        = 2;
    const STATUS_NOT_APPROVED   = 3;

    protected function _construct()
    {
        $this->_init('review/review');
    }

    public function getProductCollection()
    {
        return Mage::getResourceModel('review/review_product_collection');
    }

    public function getStatusCollection()
    {
        return Mage::getResourceModel('review/review_status_collection');
    }

    public function getTotalReviews($entityPkValue, $approvedOnly=false, $storeId=0)
    {
        return $this->getResource()->getTotalReviews($entityPkValue, $approvedOnly, $storeId);
    }

    public function aggregate()
    {
        $this->getResource()->aggregate($this);
        return $this;
    }

    public function getEntitySummary($product, $storeId=0)
    {
        $summaryData = Mage::getModel('review/review_summary')
            ->setStoreId($storeId)
            ->load($product->getId());
        $summary = new Varien_Object();
        $summary->setData($summaryData->getData());
        $product->setRatingSummary($summary);
    }

    public function getPendingStatus()
    {
        return self::STATUS_PENDING;
    }

    public function getReviewUrl()
    {
        return Mage::getUrl('review/product/view', array('id' => $this->getReviewId()));
    }

    public function validate()
    {
        $errors = array();

        if (!Zend_Validate::is($this->getTitle(), 'NotEmpty')) {
            $errors[] = Mage::helper('review')->__('Review summary can\'t be empty');
        }

        if (!Zend_Validate::is($this->getNickname(), 'NotEmpty')) {
            $errors[] = Mage::helper('review')->__('Nickname can\'t be empty');
        }

        if (!Zend_Validate::is($this->getDetail(), 'NotEmpty')) {
            $errors[] = Mage::helper('review')->__('Review can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    /**
     * Perform actions after object delete
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _afterDeleteCommit()
    {
        $this->getResource()->afterDeleteCommit($this);
        return parent::_afterDeleteCommit();
    }

    /**
     * Append review summary to product collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $collection
     * @return Mage_Review_Model_Review
     */
    public function appendSummary($collection)
    {
        $entityIds = array();
        foreach ($collection->getItems() as $_itemId => $_item) {
            $entityIds[] = $_item->getEntityId();
        }

        if (sizeof($entityIds) == 0) {
            return $this;
        }

        $summaryData = Mage::getResourceModel('review/review_summary_collection')
            ->addEntityFilter($entityIds)
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->load();

        foreach ($collection->getItems() as $_item ) {
            foreach ($summaryData as $_summary) {
                if ($_summary->getEntityPkValue() == $_item->getEntityId()) {
                    $_item->setRatingSummary($_summary);
                }
            }
        }

        return $this;
    }

    protected function _beforeDelete()
    {
        $this->_protectFromNonAdmin();
        return parent::_beforeDelete();
    }

    /**
     * Check if current review approved or not
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->getStatusId() == self::STATUS_APPROVED;
    }

    /**
     * Check if current review available on passed store
     *
     * @param int|Mage_Core_Model_Store $store
     * @return bool
     */
    public function isAvailableOnStore($store = null)
    {
        $store = Mage::app()->getStore($store);
        if ($store) {
            return in_array($store->getId(), (array)$this->getStores());
        }

        return false;
    }

    /**
     * Get review entity type id by code
     *
     * @param string $entityCode
     * @return int|bool
     */
    public function getEntityIdByCode($entityCode)
    {
        return $this->getResource()->getEntityIdByCode($entityCode);
    }
}
class Rewardpoints_Model_Review extends Mage_Review_Model_Review
{
    
    public function aggregate()
    {
        //if ($this->isApproved()){
        if ($this->getStatusId() == self::STATUS_APPROVED){
            if ($pointsInt = Mage::getStoreConfig('rewardpoints/registration/review_points', Mage::app()->getStore()->getId())){
                //ret review id... $this->getId();
                //check store id
                if ($this->getCustomerId()){
                    $reward_model = Mage::getModel('rewardpoints/stats');
                    $data = array('customer_id' => $this->getCustomerId(), 'store_id' => $this->getStoreId(), 'points_current' => $pointsInt, 'order_id' => Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW);
                    $reward_model->setData($data);
                    $reward_model->save();

                    /*$points = Mage::getModel('rewardpoints/account')->load($this->getCustomerId());
                    $points->addPoints($pointsInt);
                    $points->storeId = $this->getStoreId();
                    $points->save(Rewardpoints_Model_Stats::TYPE_POINTS_REVIEW, true);*/
                }
            }
        }
        parent::aggregate();
        return $this;
    }
}
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

class Rewardpoints_Model_Rule_Condition_Combine extends Mage_Rule_Model_Condition_Combine
{
    public function __construct()
    {
	parent::__construct();
        $this->setType('rewardpoints/rule_condition_combine');
    }

    public function getNewChildSelectOptions()
    {
        $conditions = parent::getNewChildSelectOptions();

        $conditions = array_merge_recursive($conditions, array(array('value'=>'rewardpoints/rule_condition_combine', 'label'=>Mage::helper('rewardpoints')->__('Conditions Combination'))));

        $c_attributes = array(
            array('value'=>'rewardpoints/rule_condition_customeraddress_params|postcode', 'label'=>Mage::helper('rewardpoints')->__('User post code')),
            array('value'=>'rewardpoints/rule_condition_customeraddress_params|region_id', 'label'=>Mage::helper('rewardpoints')->__('User region')),
            array('value'=>'rewardpoints/rule_condition_customeraddress_params|country_id', 'label'=>Mage::helper('rewardpoints')->__('User country'))
        );

        
        /*$customer = Mage::getModel('customer/customer');
        $c2_attributes = array();
        foreach ($customer->getAttributes() as $attribute){
            //echo $attribute->getAttributeCode();
            //echo $attribute->getFrontendLabel();
            //backend_type
            if ($attribute->getBackendModel() == "" && $attribute->getFrontendLabel() != ""){
                $c2_attributes[] = array('value'=>'rewardpoints/rule_condition_customerattribute_params|'.$attribute->getAttributeCode(), 'label'=> $attribute->getFrontendLabel());
            }
            
        }*/

        $conditions = array_merge_recursive($conditions, array(
            array('label'=>Mage::helper('rewardpoints')->__('User location'), 'value'=>$c_attributes),
        ));

        /*$conditions = array_merge_recursive($conditions, array(
            array('label'=>Mage::helper('rewardpoints')->__('User Attributes'), 'value'=>$c2_attributes),
        ));*/


        $addressCondition = Mage::getModel('salesrule/rule_condition_address');
        $addressAttributes = $addressCondition->loadAttributeOptions()->getAttributeOption();
        $cart_attributes = array();
        foreach ($addressAttributes as $code=>$label) {
            $cart_attributes[] = array('value'=>'salesrule/rule_condition_address|'.$code, 'label'=>$label);
        }

        $conditions = array_merge_recursive($conditions, array(
            array('label'=>Mage::helper('salesrule')->__('Cart Attributes'), 'value'=>$cart_attributes),
        ));


        return $conditions;
    }

    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml().
            Mage::helper('rewardpoints')->__("If %s of these order conditions are %s",
              $this->getAggregatorElement()->getHtml(),
			  $this->getValueElement()->getHtml()
           );
           if ($this->getId()!='1') {
               $html.= $this->getRemoveLinkHtml();
           }

        return $html;
    }
}
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
class Rewardpoints_Model_Rule_Condition_Customeraddress_Params extends Mage_Rule_Model_Condition_Abstract
{
    /**
     * Retrieve attribute object
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */

    public function __construct()
    {
        parent::__construct();
        $this->setType('rewardpoints/rule_condition_customeraddress_params')
            ->setValue(null);
    }

    

    public function loadAttributeOptions()
    {
        $hlp = Mage::helper('rewardpoints');
	$attributes = array(
            'postcode' => Mage::helper('rewardpoints')->__('Zip/Postal Code'),
            'region_id' => Mage::helper('rewardpoints')->__('Region'),
            'country_id' => Mage::helper('rewardpoints')->__('Country'),
        );

        $this->setAttributeOption($attributes);        
        return $this;

    }

    
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(array(
            '=='  => Mage::helper('rewardpoints')->__('is'),
            '!='  => Mage::helper('rewardpoints')->__('is not'),
            '>='  => Mage::helper('rewardpoints')->__('equals or greater than'),
            '<='  => Mage::helper('rewardpoints')->__('equals or less than'),
            '>'   => Mage::helper('rewardpoints')->__('greater than'),
            '<'   => Mage::helper('rewardpoints')->__('less than'),
        ));
        return $this;
    }




    /**
     * Retrieve Explicit Apply
     *
     * @return bool
     */
    public function getExplicitApply()
    {
        switch ($this->getAttribute()) {
            case 'sku': case 'category_ids':
                return true;
        }
        
        return false;
    }

    

    /**
     * Retrieve value element
     *
     * @return Varien_Data_Form_Element_Abstract
     */
    public function getValueElement()
    {
        $element = parent::getValueElement();

        return $element;
    }


    /**
     * Retrieve value element chooser URL
     *
     * @return string
     */
    public function getValueElementChooserUrl()
    {
        $url = false;
        switch ($this->getAttribute()) {
            case 'sku': case 'category_ids':
                $url = 'adminhtml/promo_widget/chooser'
                    .'/attribute/'.$this->getAttribute();
                if ($this->getJsFormObject()) {
                    $url .= '/form/'.$this->getJsFormObject();
                }
                break;
        }
        return $url!==false ? Mage::helper('adminhtml')->getUrl($url) : '';
    }


    public function asHtml()
    {
        if ($this->getAttribute()=='sku')
        {
                $html = $this->getTypeElement()->getHtml().
                        Mage::helper('rewardpoints')->__("%s %s",
                           $this->getAttributeElement()->getHtml(),
                           $this->getValueElement()->getHtml()
                   );
                   if ($this->getId()!='1') {
                           $html.= $this->getRemoveLinkHtml();
                   }
                return $html;
        }

        return parent::asHtml();
    }

    public function getInputType()
    {
        switch ($this->getAttribute()) {
            case 'base_subtotal': case 'weight': case 'total_qty':
                return 'numeric';

            case 'shipping_method': case 'payment_method': case 'country_id': case 'region_id':
                return 'select';
        }

        



        return 'string';
    }

    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    public function getValueElementType()
    {
        switch ($this->getAttribute()) {
            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
                return 'select';
        }

        

        return 'text';
    }

    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {

            $options = array();

            

            if ($options == array()){
                switch ($this->getAttribute()) {
                    case 'confirmation':
                        $options = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();
                        break;
                    case 'country_id':
                        $options = Mage::getModel('adminhtml/system_config_source_country')
                            ->toOptionArray();
                        break;

                    case 'region_id':
                        $options = Mage::getModel('adminhtml/system_config_source_allregion')
                            ->toOptionArray();
                        break;
                    default:
                        $options = array();
                }
            }
            
            $this->setData('value_select_options', $options);
        }
        return $this->getData('value_select_options');
    }

    public function validate(Varien_Object $object)
    {
	/*$customerId = $object->getQuote()->getCustomerId();
        if ($customerId){
            $customer = Mage::getModel('customer/customer')->load($customerId);
            $address = $customer->getPrimaryBillingAddress();
        } else {
            return false;
        }*/
        //Mage_Checkout_Model_Cart
        //if ($object instanceof Mage_Sales_Model_Order && $order->getId())

        //print_r(Mage::helper('checkout/cart')->getCart());

        $customerId = $object->getQuote()->getCustomerId();
        if ($customerId){
            $customer = Mage::getModel('customer/customer')->load($customerId);
            if ($address = $object->getPrimaryBillingAddress()){
                return parent::validate($address);
            }
        }
        
        return false;
        /*if ($address = $object->getPrimaryBillingAddress()){
            return parent::validate($address);
        } else {
            return false;
        }*/
    }
}
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
class Rewardpoints_Model_Rule_Condition_Customerattribute_Params extends Mage_Rule_Model_Condition_Abstract
{
    /**
     * Retrieve attribute object
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */

    public function __construct()
    {
        parent::__construct();
        $this->setType('rewardpoints/rule_condition_customerattribute_params')
            ->setValue(null);
    }

    

    public function loadAttributeOptions()
    {
        $hlp = Mage::helper('rewardpoints');
	$attributes = array();

        $customer = Mage::getModel('customer/customer');
        foreach ($customer->getAttributes() as $attribute){
            if ($attribute->getBackendModel() == "" && $attribute->getFrontendLabel() != ""){
                $attributes[$attribute->getAttributeCode()] = $attribute->getFrontendLabel();
            }
        }

        $this->setAttributeOption($attributes);        
        return $this;

    }

    
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(array(
            '=='  => Mage::helper('rewardpoints')->__('is'),
            '!='  => Mage::helper('rewardpoints')->__('is not'),
            '>='  => Mage::helper('rewardpoints')->__('equals or greater than'),
            '<='  => Mage::helper('rewardpoints')->__('equals or less than'),
            '>'   => Mage::helper('rewardpoints')->__('greater than'),
            '<'   => Mage::helper('rewardpoints')->__('less than'),
        ));
        return $this;
    }




    /**
     * Retrieve Explicit Apply
     *
     * @return bool
     */
    public function getExplicitApply()
    {
        switch ($this->getAttribute()) {
            case 'sku': case 'category_ids':
                return true;
        }
        $customer = Mage::getModel('customer/customer');
        foreach ($customer->getAttributes() as $attribute){
            if ($attribute->getBackendModel() == "" && $attribute->getFrontendLabel() != ""){
                if ($attribute->getAttributeCode() == $this->getAttribute()){
                    switch ($attribute->getBackendType()) {
                        case 'date':
                        case 'datetime':
                            return true;
                    }
                }
            }
        }
        return false;
    }

    

    /**
     * Retrieve value element
     *
     * @return Varien_Data_Form_Element_Abstract
     */
    public function getValueElement()
    {
        $element = parent::getValueElement();
        $customer = Mage::getModel('customer/customer');
        foreach ($customer->getAttributes() as $attribute){
            if ($attribute->getBackendModel() == "" && $attribute->getFrontendLabel() != ""){
                if ($attribute->getAttributeCode() == $this->getAttribute()){
                    switch ($attribute->getBackendType()) {
                        case 'date':
                        case 'datetime':
                            $element->setImage(Mage::getDesign()->getSkinUrl('images/grid-cal.gif'));
                            break;
                    }
                }
            }
        }

        return $element;
    }


    /**
     * Retrieve value element chooser URL
     *
     * @return string
     */
    public function getValueElementChooserUrl()
    {
        $url = false;
        switch ($this->getAttribute()) {
            case 'sku': case 'category_ids':
                $url = 'adminhtml/promo_widget/chooser'
                    .'/attribute/'.$this->getAttribute();
                if ($this->getJsFormObject()) {
                    $url .= '/form/'.$this->getJsFormObject();
                }
                break;
        }
        return $url!==false ? Mage::helper('adminhtml')->getUrl($url) : '';
    }


    public function asHtml()
    {
        if ($this->getAttribute()=='sku')
        {
                $html = $this->getTypeElement()->getHtml().
                        Mage::helper('rewardpoints')->__("%s %s",
                           $this->getAttributeElement()->getHtml(),
                           $this->getValueElement()->getHtml()
                   );
                   if ($this->getId()!='1') {
                           $html.= $this->getRemoveLinkHtml();
                   }
                return $html;
        }

        return parent::asHtml();
    }

    public function getInputType()
    {
        switch ($this->getAttribute()) {
            case 'base_subtotal': case 'weight': case 'total_qty':
                return 'numeric';

            case 'shipping_method': case 'payment_method': case 'country_id': case 'region_id': case 'group_id':
                return 'select';
        }

        $customer = Mage::getModel('customer/customer');
        foreach ($customer->getAttributes() as $attribute){
            if ($attribute->getBackendModel() == "" && $attribute->getFrontendLabel() != ""){
                if ($attribute->getAttributeCode() == $this->getAttribute()){
                    switch ($attribute->getBackendType()) {
                        case 'date':
                        case 'datetime':
                            return 'date';
                        case 'varchar':
                            return 'string';
                        case 'int':
                            return 'numeric';
                        case 'static':
                            return 'select';
                    }
                }
            }
        }



        return 'string';
    }

    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    public function getValueElementType()
    {
        switch ($this->getAttribute()) {
            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
            case 'group_id':
                return 'select';
        }

        $customer = Mage::getModel('customer/customer');
        foreach ($customer->getAttributes() as $attribute){
            if ($attribute->getBackendModel() == "" && $attribute->getFrontendLabel() != ""){
                if ($attribute->getAttributeCode() == $this->getAttribute()){
                    switch ($attribute->getBackendType()) {
                        case 'date':
                        case 'datetime':
                            return 'date';
                        case 'text':
                            return 'text';
                        case 'int':
                            return 'numeric';
                        case 'static':
                            //return 'select';
                            return 'text';
                    }
                }
            }
        }


        return 'text';
    }

    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {

            $options = array();

            $customer = Mage::getModel('customer/customer');
            foreach ($customer->getAttributes() as $attribute){
                if ($attribute->getBackendModel() == "" && $attribute->getFrontendLabel() != ""){
                    if ($attribute->getAttributeCode() == $this->getAttribute()){
                        switch ($attribute->getBackendType()) {
                            case 'static':
                                /*$att = Mage::getModel('eav/entity_attribute');
                                $att->loadByCode($attribute->getEntityTypeId(), $attribute->getAttributeCode());
                                $options = Mage::getResourceModel('eav/entity_attribute_option_collection')
                                    ->setStoreFilter()
                                    ->setAttributeFilter($att->getId())
                                    ->load()
                                    ->toOptionArray();
                            break;*/
                            default:
                                $options = array();
                        }
                    }
                }
            }

            if ($options == array()){
                switch ($this->getAttribute()) {
                    case 'confirmation':
                        $options = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();
                        break;
                    case 'country_id':
                        $options = Mage::getModel('adminhtml/system_config_source_country')
                            ->toOptionArray();
                        break;

                    case 'region_id':
                        $options = Mage::getModel('adminhtml/system_config_source_allregion')
                            ->toOptionArray();
                        break;

                    case 'group_id':
                        /*$options = Mage::getModel('adminhtml/system_config_source_allregion')
                            ->toOptionArray();*/
                        $options = Mage::getResourceModel('customer/group_collection')
                             ->load()->toOptionArray();
                        break;

                    default:
                        $options = array();
                }
            }            
            $this->setData('value_select_options', $options);
        }
        return $this->getData('value_select_options');
    }

    public function validate(Varien_Object $object)
    {
	$customerId = $object->getQuote()->getCustomerId();
        if ($customerId){
            $customer = Mage::getModel('customer/customer')->load($customerId);
            $datas = $customer->getData();
            return parent::validate($datas);
        }

        return false;
        
        

        //if ($object instanceof Mage_Sales_Model_Order && $order->getId())
        /*
        if ($datas = $object->getData()){
            return parent::validate($object);
        } else {
            return false;
        }*/

    }
}
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
class Rewardpoints_Model_Rule_Condition_Order_Params extends Mage_Rule_Model_Condition_Abstract
{
    /**
     * Retrieve attribute object
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */
    
    public function __construct()
    {
        parent::__construct();
        $this->setType('rewardpoints/rule_condition_order_params')
            ->setValue(null);
    }

    public function loadAttributeOptions()
    {
	$hlp = Mage::helper('rewardpoints');
        $this->setAttributeOption(array(
            'store'  => $hlp->__('Store'),
            'category' => $hlp->__('Category'),
			'order_status' => $hlp->__('Order status'),
			'sku' => $hlp->__('Contains any of these SKUs'),
        ));
        return $this;
    }

    public function getValueSelectOptions()
    {
		$hlp = Mage::helper('rewardpoints');
		if ($this->getAttribute()=='store')
		{
			$stores = Mage::helper('rewardpoints')->getStoresForRule();
			$stores_options = array();
			foreach ($stores as $key => $store)
				$stores_options[] = array('label' => $store, 'value' => $key);

			$this->setData('value_select_options', $stores);
		}
		if ($this->getAttribute()=='category')
		{
			$categories = Mage::helper('rewardpoints')->getCategoriesArray();

			foreach ($categories as $key => $category)
				$categories[$key]['label'] = str_replace('&nbsp;', '', $category['label']);

			$this->setData('value_select_options', $categories);
		}
		if ($this->getAttribute()=='order_status')
		{
			$this->setData('value_select_options',
				Mage::getSingleton('sales/order_config')->getStatuses());
		}

        return $this->getData('value_select_options');
    }

    public function loadOperatorOptions()
    {
        $this->setOperatorOption(array(
                '=='  => Mage::helper('rewardpoints')->__('is'),
                '!='  => Mage::helper('rewardpoints')->__('is not')
        ));
        return $this;
    }

    public function asHtml()
    {
        if ($this->getAttribute()=='sku')
		{
			$html = $this->getTypeElement()->getHtml().
				Mage::helper('rewardpoints')->__("%s %s",
				   $this->getAttributeElement()->getHtml(),
				   $this->getValueElement()->getHtml()
			   );
			   if ($this->getId()!='1') {
				   $html.= $this->getRemoveLinkHtml();
			   }
			return $html;
		}

		return parent::asHtml();
    }

    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    public function getValueElementType()
    {
        if ($this->getAttribute()=='store'||$this->getAttribute()=='category'||$this->getAttribute()=='order_status') return 'select';
		return 'text';
    }

    public function validate(Varien_Object $object)
    {
        if ($this->getAttribute()=='sku')
        {
            $sku = explode(',',$this->getValue());
            foreach($sku as $skuA)
            {
                foreach($object->getSku() as $skuB)
                {
                    if ($skuA == $skuB) return true;
                }
            }
            return false;
        }

        if ($this->getAttribute()=='category')
                return $this->validateAttribute($object->getCategories());

        return parent::validate($object);
    }
}
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
class Rewardpoints_Model_Rules extends Mage_Core_Model_Abstract
{
    const TARGET_CART  = 'cart_amount';
    const TARGET_SKU   = 'sku_value';
    const ACTIVATED_YES = 1;
    const ACTIVATED_NO  = 0;
    const OPERATOR_1 = '=';
    const OPERATOR_2 = '<';
    const OPERATOR_3 = '<=';
    const OPERATOR_4 = '>';
    const OPERATOR_5 = '>=';
    const OPERATOR_6 = 'between';

    protected $_targets;
    protected $_activated;
    protected $_operator;

    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/rules ');

        $this->_targets = array(
            self::TARGET_CART     => Mage::helper('rewardpoints')->__('Cart amount'),
            self::TARGET_SKU   => Mage::helper('rewardpoints')->__('Product sku'),
        );
        $this->_activated = array(
            self::ACTIVATED_YES     => Mage::helper('rewardpoints')->__('Active'),
            self::ACTIVATED_NO   => Mage::helper('rewardpoints')->__('Inactive'),
        );
        $this->_operator = array(
            self::OPERATOR_1     => Mage::helper('rewardpoints')->__('='),
            self::OPERATOR_2   => Mage::helper('rewardpoints')->__('<'),
            self::OPERATOR_3   => Mage::helper('rewardpoints')->__('<='),
            self::OPERATOR_4   => Mage::helper('rewardpoints')->__('>'),
            self::OPERATOR_5   => Mage::helper('rewardpoints')->__('>='),
            self::OPERATOR_6   => Mage::helper('rewardpoints')->__('Between'),
        );

    }

    public function getPointsByRule(){
        
        $websiteId = Mage::app()->getStore(Mage::app()->getStore()->getWebsiteId())->getWebsiteId();
        $collection = Mage::getResourceModel('rewardpoints/rules_collection')
                        ->setValidationFilter($websiteId)
                        ->load();
        //$collection = $this->getCollection()->setValidationFilter($websiteId);

        $arr_rule = array();
        if ($collection->getSize()){
            foreach ($collection as $points_rule){
                $arr_rule[] = array(
                                'name' => $points_rule->getRewardpointsRuleName(),
                                'type' => $points_rule->getRewardpointsRuleType(),
                                'operator' => $points_rule->getRewardpointsRuleOperator(),
                                'test_value' => $points_rule->getRewardpointsRuleTest(),
                                'points' => $points_rule->getRewardpointsRulePoints()
                              );
            }
        }
        return $arr_rule;
        
    }

    
    public function getOperatorArray()
    {
        return $this->_operator;
    }

    public function operatorToOptionArray()
    {
        return $this->_toOptionArray($this->_operator);
    }


    public function getActivatedArray()
    {
        return $this->_activated;
    }

    public function activatedToOptionArray()
    {
        return $this->_toOptionArray($this->_activated);
    }


    public function getTargetsArray()
    {
        return $this->_targets;
    }

    public function targetsToOptionArray()
    {
        return $this->_toOptionArray($this->_targets);
    }

    protected function _toOptionArray($array)
    {
        $res = array();
        foreach ($array as $value => $label) {
        	$res[] = array('value' => $value, 'label' => $label);
        }
        return $res;
    }
}


class Rewardpoints_Model_Session extends Mage_Core_Model_Session_Abstract
{
    public function __construct()
    {
        $namespace = 'rewardpoints';
        $this->init($namespace);
    }

    public function unsetAll()
    {
        parent::unsetAll();
    }
}
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
class Rewardpoints_Model_Stats extends Mage_Core_Model_Abstract
{
    const TARGET_PER_ORDER     = 1;
    const TARGET_FREE   = 2;
    const APPLY_ALL_ORDERS  = '-1';

    const TYPE_POINTS_ADMIN  = '-1';
    const TYPE_POINTS_REVIEW  = '-2';
    const TYPE_POINTS_REGISTRATION  = '-3';
    const TYPE_POINTS_REQUIRED  = '-10';
    const TYPE_POINTS_BIRTHDAY  = '-20';

    protected $_targets;

    protected $_eventPrefix = 'rewardpoints_account';
    protected $_eventObject = 'stats';

    protected $points_received;
    protected $points_received_no_exp;
    // J2T points validation date
    protected $points_received_reajust;
    protected $points_spent;

    protected $points_lost;

    const XML_PATH_NOTIFICATION_EMAIL_TEMPLATE       = 'rewardpoints/notifications/notification_email_template';
    const XML_PATH_NOTIFICATION_EMAIL_IDENTITY       = 'rewardpoints/notifications/notification_email_identity';

    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/stats');

        $this->_targets = array(
            self::TARGET_PER_ORDER     => Mage::helper('rewardpoints')->__('Related to Order ID'),
            self::TARGET_FREE   => Mage::helper('rewardpoints')->__('Not related to Order ID'),
        );

    }

    public function getTargetsArray()
    {
        return $this->_targets;
    }

    public function targetsToOptionArray()
    {
        return $this->_toOptionArray($this->_targets);
    }

    protected function _toOptionArray($array)
    {
        $res = array();
        foreach ($array as $value => $label) {
            $res[] = array('value' => $value, 'label' => $label);
        }
        return $res;
    }


    //J2T Check referral
    public function loadByReferralId($referral_id, $referral_customer_id = null)
    {
        $this->addData($this->getResource()->loadByReferralId($referral_id, $referral_customer_id));
        return $this;
    }

    public function loadpointsbydate($store_id, $customer_id, $date){
        $collection = $this->getCollection();
        $collection->getSelect()->where("main_table.customer_id = ?", $customer_id);
        $collection->getSelect()->where("( ? >= main_table.date_start )", $date);
        $collection->getSelect()->where("( main_table.date_end >= ? )", $date);
        $collection->getSelect()->where("( main_table.date_end <= NOW() )");
        $collection->addValidPoints($store_id, true);

        //echo $collection->getSelect()->__toString();
        //die;

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function getDobPoints($store_id, $customer_id)
    {
        //self::TYPE_POINTS_BIRTHDAY
        $collection = $this->getCollection();
        $collection->getSelect()->where("main_table.customer_id = ?", $customer_id);
        //$collection->getSelect()->where("( ? >= main_table.date_start )", $date);
        $collection->getSelect()->where("main_table.order_id  = ?", self::TYPE_POINTS_BIRTHDAY);
        $collection->pointsByDate();

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function loadByCustomerId($customer_id)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id = ?', $customer_id);

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function loadReferrer($customer_id, $order_id)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id <> ?', $customer_id);
        $collection->getSelect()->where('order_id = ?', $order_id);


        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function checkProcessedOrder($customer_id, $order_id, $isCredit = true)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id = ?', $customer_id);
        $collection->getSelect()->where('order_id = ?', $order_id);
        if ($isCredit){
            $collection->getSelect()->where('points_current > 0');
        } else {
            $collection->getSelect()->where('points_spent > 0');
        }

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }


    public function getPointsUsed($order_id, $customer_id)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id = ?', $customer_id);
        $collection->getSelect()->where('order_id = ?', $order_id);
        $collection->getSelect()->where('points_spent > ?', '0');

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }


    public function getPointsWaitingValidation($customer_id, $store_id){
        $collection = $this->getCollection()->joinFullCustomerPoints($customer_id, $store_id);
        $row = $collection->getFirstItem();
        return $row->getNbCredit() - $this->getPointsReceived($customer_id, $store_id) + $this->getPointsReceivedReajustment($customer_id, $store_id);
    }


    public function sendNotification(Mage_Customer_Model_Customer $customer, $store_id, $points, $days)
    {
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');

        $template = Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_EMAIL_TEMPLATE, $store_id);
        $recipient = array(
            'email' => $customer->getEmail(),
            'name'  => $customer->getName()
        );

        $sender  = Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_EMAIL_IDENTITY, $store_id);
        $email->setDesignConfig(array('area'=>'frontend', 'store'=>$store_id))
            ->sendTransactional(
                $template,
                $sender,
                $recipient['email'],
                $recipient['name'],
                array(
                    'points'   => $points,
                    'days'   => $days,
                    'customer' => $customer
                )
            );
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }

    /**
     * J2T modification fixing issue related to points validation dates
     * getPointsReceivedReajustment protected function allowing to readjust points regarding points validation dates
     * @param int $customer_id
     * @param int $store_id
     * @return int
     */
    protected function getPointsReceivedReajustment($customer_id, $store_id) {
        /*$points = Mage::getModel('rewardpoints/stats')
                                ->getResourceCollection()
                                ->addUsedpointsbydate($store_id, $customer_id);*/

        if ($this->points_received_reajust != null){
            return $this->points_received_reajust;
        } else {
            //get all points used groupped by date
            $points = $this
                ->getResourceCollection()
                ->addUsedpointsbydate($store_id, $customer_id);
            $acc_fix_points = 0;
            if ($points->getSize()){
                foreach ($points as $current_point){
                    //validate points per date
                    $points_accum = Mage::getModel('rewardpoints/stats')->loadpointsbydate($store_id, $customer_id, $current_point->getData('date_order'));
                    //if ($points_accum->getData('nb_credit') >= $current_point->getData('nb_credit_spent')){
                    //FIX POINTS READJUST!!!!
                    if ($points_accum->getData('nb_credit') >= $current_point->getData('nb_credit_spent')){
                        $acc_fix_points += $current_point->getData('nb_credit_spent');
                    }
                }
            }
            $this->points_received_reajust = $acc_fix_points;
            return $acc_fix_points;
        }
    }


    public function getRealPointsLost($customerId, $store_id) {
        if ($this->points_lost){
            return $this->points_lost;
        }
        $this->points_lost = $this->getRealPointsReceivedNoExpiry($customerId, $store_id) - $this->getPointsReceived($customerId, $store_id);
        return $this->points_lost;
    }


    public function getPointsReceived($customer_id, $store_id){
        if ($this->points_received){
            return $this->points_received;
        }
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $order_states = explode(",", $statuses);

        //$order_states = array("'processing'","'complete'");
        $collection = $this->getCollection();
        $collection->joinValidPointsOrder($customer_id, $store_id, $order_states);

        /*$collection->printlogquery(true);
        die;*/
        $row = $collection->getFirstItem();
        $this->points_received = $row->getNbCredit() + $this->getPointsReceivedReajustment($customer_id, $store_id);

        //J2T modification fixing issue related to points validation dates
        //return $row->getNbCredit();
        //echo $collection->getSelect()->__toString();
        //die;
        //echo ">> ".($row->getNbCredit() + $this->getPointsReceivedReajustment($customer_id, $store_id)) . " <<";
        //die;
        return $row->getNbCredit() + $this->getPointsReceivedReajustment($customer_id, $store_id);
    }



    public function getRealPointsReceivedNoExpiry($customer_id, $store_id){
        if ($this->points_received_no_exp){
            return $this->points_received_no_exp;
        }
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $order_states = explode(",", $statuses);

        //$order_states = array("'processing'","'complete'");
        $collection = $this->getCollection();
        $collection->joinValidPointsOrder($customer_id, $store_id, $order_states, false, true);

        /*$collection->printlogquery(true);
        die;*/
        $row = $collection->getFirstItem();
        $this->points_received_no_exp = $row->getNbCredit();

        //J2T modification fixing issue related to points validation dates
        //return $row->getNbCredit();
        //echo $collection->getSelect()->__toString();
        //die;
        return $row->getNbCredit();
    }

    public function getPointsSpent($customer_id, $store_id){

        if ($this->points_spent){
            return $this->points_spent;
        }

        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $order_states = explode(",", $statuses);
        $order_states[] = 'new';


        //$order_states = array("'processing'","'complete'","'new'");

        $collection = $this->getCollection();
        $collection->joinValidPointsOrder($customer_id, $store_id, $order_states, true);

        $row = $collection->getFirstItem();

        $this->points_spent = $row->getNbCredit();

        return $row->getNbCredit();
    }
    
    public function getPointsCurrent($customerid, $store_id, $date = null, $arraymode = false, $excludelast = false){
        if($date == null)
            $date = date('Y-m-d');
        $balanceon = strtotime($date);
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query = "SELECT * FROM (SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id, order_id FROM rewardpoints_account WHERE customer_id = ".$customerid." AND order_id IN (-3,-2,-1,-20) UNION SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id, order_id FROM rewardpoints_account, sales_flat_order WHERE rewardpoints_account.customer_id = ".$customerid." AND order_id NOT IN (-3,-2,-1,-20) AND sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending','processing','complete')) AS smogihistory ORDER BY rewardpoints_account_id";
        $smogihistory = $read->fetchAll($query);

        $unsetarray = array();
        for($i = 0; $i < count($smogihistory); $i++)
        {
            $orderid = $smogihistory[$i]['order_id'];
            if(($orderid != -3 || $orderid != -2 || $orderid != -1 || $orderid != -20) && $smogihistory[$i]['points_spent'] > 0)
            {
                $temp = $smogihistory[$i]['points_spent'];
                for($j = $i - 1; $j >= 0; $j--)
                {
                    if(($smogihistory[$j]['order_id'] == $smogihistory[$i]['order_id']) && $smogihistory[$j]['points_current'] > 0)
                    {
                        if($smogihistory[$j]['points_current'] >= $temp)
                        {
                            $smogihistory[$j]['points_current'] -= $temp;
                            $smogihistory[$j]['balance'] -= $temp;
                            array_push($unsetarray,$i);
                            $smogihistory[$i]['points_spent'] = 0;
                        }
                    }
                }
            }
        }

        $lastindex = count($smogihistory);
        if($excludelast)
            $lastindex--;
        for($i = 0; $i < $lastindex; $i++)
        {
            if($smogihistory[$i]['points_spent'] <= 0)
                continue;
            $temp = $smogihistory[$i]['points_spent'];
            $negativebalance = 0;


            $temparray = array();
            for($j = 0; $j < $i; $j++)
            {
                array_push($temparray, array(
                    "index" => $j,
                    "date_end" => $smogihistory[$j]['date_end'],
                    "balance" => $smogihistory[$j]['balance']
                ));
            }
            $date_end = array();
            foreach($temparray as $key => $value)
            {
                $date_end[$key] = $value['date_end'];
            }
            array_multisort($date_end, SORT_ASC, $temparray);
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($temparray[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $temparray[$j]['balance'] > 0)
                {
                    if($temparray[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$temparray[$j]['index']]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $temparray[$j]['balance'];
                        $smogihistory[$temparray[$j]['index']]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }

            /*
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($smogihistory[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $smogihistory[$j]['balance'] > 0)
                {
                    if($smogihistory[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$j]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $smogihistory[$j]['balance'];
                        $smogihistory[$j]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }
            */
        }
        $negativebalance += $temp;
        $balance = 0;
        for($i = 0; $i < count($smogihistory); $i++)
        {
            //if(strtotime($smogihistory[$i]['date_end']) > strtotime($date))
            if(strtotime($smogihistory[$i]['date_end']) > $balanceon)
            {
                $balance += $smogihistory[$i]['balance'];
            }
        }
        if(!$arraymode)
            return $balance;
        else
            return array("history" => $smogihistory,"balance" => $balance,"negativebalance" => $negativebalance);
//        echo "<pre>";
//        print_r($smogihistory);
//        echo "<pre>";
        //echo 'Current Balance -> '.$balance;
    }

    public function getPointsCurrent_excludelast($customerid, $store_id, $date = null, $arraymode = false){
        if($date == null)
            $date = date('Y-m-d');
        $balanceon = strtotime($date);
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query = "SELECT * FROM (SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id FROM rewardpoints_account WHERE customer_id = ".$customerid." AND order_id IN (-3,-2,-1,-20) UNION SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id FROM rewardpoints_account, sales_flat_order WHERE rewardpoints_account.customer_id = ".$customerid." AND order_id NOT IN (-3,-2,-1,-20) AND sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending','processing','complete')) AS smogihistory ORDER BY rewardpoints_account_id";
        $smogihistory = $read->fetchAll($query);
        for($i = 0; $i < count($smogihistory) - 1; $i++)
        {
            if($smogihistory[$i]['points_spent'] <= 0)
                continue;
            $temp = $smogihistory[$i]['points_spent'];
            $negativebalance = 0;
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($smogihistory[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $smogihistory[$j]['balance'] > 0)
                {
                    if($smogihistory[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$j]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $smogihistory[$j]['balance'];
                        $smogihistory[$j]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }
        }
        $negativebalance += $temp;
        $balance = 0;
        for($i = 0; $i < count($smogihistory); $i++)
        {
            if(strtotime($smogihistory[$i]['date_end']) > strtotime($date))
            {
                $balance += $smogihistory[$i]['balance'];
            }
        }
        if(!$arraymode)
            return $balance;
        else
            return array("history" => $smogihistory,"balance" => $balance,"negativebalance" => $negativebalance);
//        echo "<pre>";
//        print_r($smogihistory);
//        echo "<pre>";
        //echo 'Current Balance -> '.$balance;
    }



    public function recordPoints($pointsInt, $customerId, $orderId, $store_id, $force_nodelay = false) {
        $post = array(
            'order_id' => $orderId,
            'customer_id' => $customerId,
            'store_id' => $store_id,
            'points_current' => $pointsInt,
            'convertion_rate' => Mage::getStoreConfig('rewardpoints/default/points_money', $store_id)
        );
        //v.2.0.0
        $add_delay = 0;
        if ($delay = Mage::getStoreConfig('rewardpoints/default/points_delay', $store_id) && $force_nodelay){
            if (is_numeric($delay)){
                $post['date_start'] = $this->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$delay, date("Y")));
                $add_delay = $delay;
            }
        }

        if ($duration = Mage::getStoreConfig('rewardpoints/default/points_duration', $store_id)){
            if (is_numeric($duration)){
                if (!isset($post['date_start'])){
                    $post['date_start'] = $this->getResource()->formatDate(time());
                }
                $post['date_end'] = $this->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$duration+$add_delay, date("Y")));
            }
        }
        $this->setData($post);
        $this->save();
    }
    public function orderLog($orderNumber, $process, $creditMemoId = null, $log, $logType )
    {
        $resource = Mage::getSingleton('core/resource');
 		$readConnection = $resource->getConnection('core_write');
        Mage::log("Insert into smogi_debug_info values (NULL, '$orderNumber', '$process','$creditMemoId','$logType','$log',NOW())",null,'distribution.log');
		$readConnection->query("Insert into smogi_debug_info values (NULL, '$orderNumber', '$process','$creditMemoId','$logType','$log',NOW())");
    }

    public function getPointsCurrentdefault($customer_id, $store_id){
        $total = $this->getPointsReceived($customer_id, $store_id) - $this->getPointsSpent($customer_id, $store_id);
        if ($total > 0){
            return $total;
        } else {
            return 0;
        }
    }
    
    public function distributediscount($order, $row, $lastOrderId)
    {
        $couponcode = $row['coupon_code'];
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $smogiused = false;
        $discount_amount = $row['base_discount_amount'] * -1;
        if($row['rewardpoints_quantity'] > 0)
        {
            $smogiused = true;
        }        
        $readresult=$write->query("Select entity_id from sales_flat_invoice where order_id=".$lastOrderId);
        $row = $readresult->fetch();
        if($row)
            $invoiceid = $row['entity_id'];
        else{
            $invoiceid = '';
        }
        $arrOrderItem = array();
        $readresult=$write->query("Select product_id, row_total_incl_tax, item_id from sales_flat_order_item where order_id=".$lastOrderId." and price > 0");
        while ($row = $readresult->fetch() ) {
            $temp = array();
            $temp['product_id'] = $row['product_id'];
            $temp['price'] = $row['row_total_incl_tax'];
            $temp['item_id'] = $row['item_id'];
            $temp['exclude'] = 0;
            if($smogiused)
            {
                $write1 = Mage::getSingleton('core/resource')->getConnection('core_write');
                $readresult1=$write1->query("SELECT COUNT(*) AS cnt FROM catalog_category_product ccp, catalog_category_flat_store_1 ccfs WHERE ccp.product_id = ".$row['product_id']." AND ccfs.entity_id = ccp.category_id AND category_id IN (".Mage::getModel('core/variable')->loadByCode('nosmogicategories ')->getValue('plain').")");
                $row1 = $readresult1->fetch();
                if($row1['cnt'] > 0)
                {
                    $temp['exclude'] = 1;
                    $this->orderLog($order->getIncrementId(), 'discount distribution', '',$row['product_id'], 'Excluding Product ID for distribution');            
                }
            }
            array_push($arrOrderItem, $temp);
        }
        $total = 0;
        for($i = 0; $i < count($arrOrderItem); $i++)
        {
            if($arrOrderItem[$i]['exclude'] == 0)
                $total += $arrOrderItem[$i]['price'];
        }
		$this->orderLog($order->getIncrementId(), 'discount distribution', '',$total, 'Total Amount of products applicable for discount.');
        $temp = 0;
        for($i = 0; $i < count($arrOrderItem); $i++)
        {
            if($arrOrderItem[$i]['exclude'] == 1)
            {
                $arrOrderItem[$i]['price'] = 0;    
            }
            else
            {
                if($couponcode == '')
                {
                    $percent = round((($arrOrderItem[$i]['price'] / $total) * 100), 2);
                    $discount = round(($discount_amount * $percent) / 100);    
                }
                else
                {
                    $percent = ($arrOrderItem[$i]['price'] / $total) * 100;
                    $discount = round((($discount_amount * $percent) / 100), 2);
                    Mage::log($arrOrderItem[$i]['product_id']." - ".$percent."% - ".$discount,null,'distribution.log');
                }
                $temp += $discount;
                $arrOrderItem[$i]['price'] = $discount;   
            }
            //Mage::log($arrOrderItem[$i]['price']."  ".$arrOrderItem[$i]['product_id'] ,null,'distribution.log');
            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'New Discount for Product ID = '.$arrOrderItem[$i]['product_id']);
        }
        $this->orderLog($order->getIncrementId(), 'discount distribution', '',$temp, 'Sum of all allocated discounts');
        if($temp < $discount_amount)
        {
            for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
            {
                if($arrOrderItem[$i]['exclude'] == 0)
                {
                    $arrOrderItem[$i]['price'] += ($discount_amount - $temp);
                    $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is less than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                    break;
                }
                //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
            }

        }
        if($temp > $discount_amount)
        {
            for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
            {
                if($arrOrderItem[$i]['exclude'] == 0)
                {
                    $arrOrderItem[$i]['price'] -= ($temp - $discount_amount);
                    $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is more than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                    break;
                }
                //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
            }

        }
        for($i = 0; $i < count($arrOrderItem); $i++)
        {
            //$readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and product_id=".$arrOrderItem[$i]['product_id']);
            $readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and item_id=".$arrOrderItem[$i]['item_id']);
            if($invoiceid !='')
            $readresult=$write->query("Update sales_flat_invoice_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price']." where parent_id=".$invoiceid." and order_item_id=".$arrOrderItem[$i]['item_id']);
        }
        //Mage::log($temp."   ".$discount_amount,null,'distribution.log');
    }
    
    public function ordercompleteoperations($order, $source)
    {
        $lastOrderId = $order->getId();
        $this->orderLog($order->getIncrementId(), 'discount distribution', '',$source, 'Source');
        try{
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $readresult=$write->query("Select base_discount_amount, rewardpoints_quantity, grand_total, coupon_code,store_id,entity_id,customer_id,increment_id from sales_flat_order where entity_id=".$lastOrderId);
            $row = $readresult->fetch();
            $smogiused = false;
			//Mage::log("Base Discount = ".$row['base_discount_amount'],null,'distribution.log');
            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$row['base_discount_amount'], 'Base Discount Amount');    
            $couponcode = $row['coupon_code'];
            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$couponcode, 'Coupon Code');
            //if($row['base_discount_amount'] < 0 && $row['grand_total'] > 0)
            if($row['base_discount_amount'] < 0 && $row['grand_total'] > 0 && $row['coupon_code'] == '')
            {
                $this->orderLog($order->getIncrementId(), 'discount distribution', '','Yes', 'Applicable for distribution');
                $this->distributediscount($order, $row, $lastOrderId);
                //distribute discount
            }
            else
                $this->orderLog($order->getIncrementId(), 'discount distribution', '','No', 'Applicable for distribution');
            if($row['base_discount_amount'] < 0 && $row['rewardpoints_quantity'] > 0)
            {
                $this->orderLog($order->getIncrementId(), 'smogi used point date', '','Yes', 'Applicable for smogi store');
                $this->smogi_setstartdate($order->getIncrementId());
                $this->smogi_storeExpiryDate($row);
                //store smogi expiry
            }
            else
            {
                $this->orderLog($order->getIncrementId(), 'smogi used point date', '','No', 'Applicable for smogi store');
            }
            /*
            if($row['base_discount_amount'] < 0 && $row['grand_total'] > 0 && $row['coupon_code'] == '')
            {
                $discount_amount = $row['base_discount_amount'] * -1;
				//Mage::log("Rewardpoints = ".$row['rewardpoints_quantity'],null,'distribution.log');
                $this->orderLog($order->getIncrementId(), 'discount distribution', '',$row['rewardpoints_quantity'], 'SMOGI Bucks Used');
                if($row['rewardpoints_quantity'] > 0)
                {
                    $this->smogi_setstartdate($order->getIncrementId());
                    $smogiused = true;
                    $this->smogi_storeExpiryDate($row);
                }

                //Mage::log("Smogi used = $smogiused",null,'distribution.log');        
                $readresult=$write->query("Select entity_id from sales_flat_invoice where order_id=".$lastOrderId);
                $row = $readresult->fetch();
                if($row)
                    $invoiceid = $row['entity_id'];
                else{
                    $invoiceid = '';
                }
                $arrOrderItem = array();
                $readresult=$write->query("Select product_id, row_total_incl_tax, item_id from sales_flat_order_item where order_id=".$lastOrderId." and price > 0");
                while ($row = $readresult->fetch() ) {
                    $temp = array();
                    $temp['product_id'] = $row['product_id'];
                    $temp['price'] = $row['row_total_incl_tax'];
                    $temp['item_id'] = $row['item_id'];
                    $temp['exclude'] = 0;
                    if($smogiused)
                    {
                        $write1 = Mage::getSingleton('core/resource')->getConnection('core_write');
                        $readresult1=$write1->query("SELECT COUNT(*) AS cnt FROM catalog_category_product ccp, catalog_category_flat_store_1 ccfs WHERE ccp.product_id = ".$row['product_id']." AND ccfs.entity_id = ccp.category_id AND category_id IN (".Mage::getModel('core/variable')->loadByCode('nosmogicategories ')->getValue('plain').")");
                        //Mage::log("SELECT COUNT(*) AS cnt FROM catalog_category_product ccp, catalog_category_flat_store_1 ccfs WHERE ccp.product_id = ".$row['product_id']." AND ccfs.entity_id = ccp.category_id AND category_id IN (".Mage::getModel('core/variable')->loadByCode('nosmogicategories ')->getValue('plain').")",null,'distribution.log');
                        $row1 = $readresult1->fetch();
                        if($row1['cnt'] > 0)
                        {
                            $temp['exclude'] = 1;
                            Mage::log("Excluded = ".$row['product_id'],null,'distribution.log');
                            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$row['product_id'], 'Excluding Product ID for distribution');            
                        }
                    }
                    array_push($arrOrderItem, $temp);
                }
                $total = 0;
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    if($arrOrderItem[$i]['exclude'] == 0)
                        $total += $arrOrderItem[$i]['price'];
                }
				//Mage::log("Total Calculatable = ".$total,null,'distribution.log');
                $this->orderLog($order->getIncrementId(), 'discount distribution', '',$total, 'Total Amount of products applicable for discount.');
                $temp = 0;
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    if($arrOrderItem[$i]['exclude'] == 1)
                    {
                        $arrOrderItem[$i]['price'] = 0;    
                    }
                    else
                    {
                        if($couponcode == '')
                        {
                            $percent = round((($arrOrderItem[$i]['price'] / $total) * 100), 2);
                            $discount = round(($discount_amount * $percent) / 100);    
                        }
                        else
                        {
                            $percent = ($arrOrderItem[$i]['price'] / $total) * 100;
                            $discount = round((($discount_amount * $percent) / 100), 2);
                            Mage::log($arrOrderItem[$i]['product_id']." - ".$percent."% - ".$discount,null,'distribution.log');
                        }
                        $temp += $discount;
                        $arrOrderItem[$i]['price'] = $discount;   
                    }
                    //Mage::log($arrOrderItem[$i]['price']."  ".$arrOrderItem[$i]['product_id'] ,null,'distribution.log');
                    $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'New Discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                }
                Mage::log($temp."   ".$discount_amount,null,'distribution.log');    
                $this->orderLog($order->getIncrementId(), 'discount distribution', '',$temp, 'Sum of all allocated discounts');
                if($temp < $discount_amount)
                {
                    for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
                    {
                        if($arrOrderItem[$i]['exclude'] == 0)
                        {
                            $arrOrderItem[$i]['price'] += ($discount_amount - $temp);
                            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is less than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                            break;
                        }
                        //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
                    }

                }
                if($temp > $discount_amount)
                {
                    for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
                    {
                        if($arrOrderItem[$i]['exclude'] == 0)
                        {
                            $arrOrderItem[$i]['price'] -= ($temp - $discount_amount);
                            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is more than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                            break;
                        }
                        //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
                    }

                }
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    //$readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and product_id=".$arrOrderItem[$i]['product_id']);
                    $readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and item_id=".$arrOrderItem[$i]['item_id']);
                    if($invoiceid !='')
                    $readresult=$write->query("Update sales_flat_invoice_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price']." where parent_id=".$invoiceid." and order_item_id=".$arrOrderItem[$i]['item_id']);
                }
                //Mage::log($temp."   ".$discount_amount,null,'distribution.log');
                
            }
            else
            {
                $this->orderLog($order->getIncrementId(), 'discount distribution', '','Reward Points is not used hence exiting.', 'EXIT');
            }
            */
            $readresult=$write->query("SELECT COUNT(item_id) AS cnt FROM sales_flat_order_item WHERE order_id=".$lastOrderId." AND qty_backordered>0");
            $row = $readresult->fetch();
            
            if($row['cnt'] > 0)
            {
               // $order = Mage::getModel('sales/order')->load($lastOrderId);
                $order->addStatusHistoryComment("This order contains Pre-Ordered items.");
                $order->save();   
            }
            /*
            if($smogiused)
            {

                // $query = "SELECT * FROM rewardpoints_account WHERE order_id = '".$order->getIncrementId()."' and date_start is null order by rewardpoints_account_id desc limit 1";
                // Mage::log($query,null,'distirbution.log');
                $readresult=$write->query("SELECT * FROM rewardpoints_account WHERE order_id = '".$order->getIncrementId()."' and date_start is null order by rewardpoints_account_id desc limit 1");
                $row = $readresult->fetch();
                //  $query = "Update rewardpoints_account set date_start='".date('Y-m-d')."' where rewardpoints_account_id=".$row['rewardpoints_account_id'];
                //  Mage::log($query,null,'distirbution.log');
                $write->query("Update rewardpoints_account set date_start='".date('Y-m-d')."' where rewardpoints_account_id=".$row['rewardpoints_account_id']);
                $this->orderLog($order->getIncrementId(), 'smogi used point date', '',$row['rewardpoints_account_id'], 'Setting date for used smogi points = '.date('Y-m-d'));
            }*/
        }
        catch(Exception $e)
        {
            //Mage::log("Error Occured".$e->getMessage(),null,'distribution.log');
            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$e->getMessage(), 'ERROR');
        }
    }
    public function smogi_setstartdate($incrementid)
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT * FROM rewardpoints_account WHERE order_id = '".$incrementid."' and date_start is null order by rewardpoints_account_id desc limit 1");
        $row = $readresult->fetch();
        $write->query("Update rewardpoints_account set date_start='".date('Y-m-d')."' where rewardpoints_account_id=".$row['rewardpoints_account_id']);
        $this->orderLog($incrementid, 'smogi used point date', '',$row['rewardpoints_account_id'], 'Setting date for used smogi points = '.date('Y-m-d'));
    }
    public function smogi_storeExpiryDate($orderinfo)
    {
        $smogi_balance = $this->getPointsCurrent($orderinfo['customer_id'], $orderinfo['store_id'], null, true, true);
        Mage::log(json_encode($smogi_balance),null,'smogi_balance.log');
        //Mage::getModel('rewardpoints/stats')->orderLog($orderinfo['increment_id'], 'smogi expiry date', '',json_encode($smogi_balance), 'Current SMOGI Balance');
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $arrEarnedPoints = $smogi_balance['history'];
        $temp = $orderinfo['rewardpoints_quantity'];
        $date_end = array();
        foreach($arrEarnedPoints as $key => $value)
        {
            $date_end[$key] = $value['date_end'];
        }
        array_multisort($date_end, SORT_ASC, $arrEarnedPoints);
        foreach($arrEarnedPoints as $key => $value)
        {
            if($arrEarnedPoints[$key]['points_current'] <= 0)
                continue;
            if((strtotime($arrEarnedPoints[$key]['date_end']) > strtotime(date('Y-m-d'))) && ($arrEarnedPoints[$key]['balance'] > 0))
            {
                if($arrEarnedPoints[$key]['balance'] >= $temp)
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$temp.",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp = 0;
                }
                else
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$arrEarnedPoints[$key]['balance'].",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp -= $arrEarnedPoints[$key]['balance'];
                }
                if($temp <= 0)
                    break;
            }
        }
    }

    //Added By Fahim Khan For smogi bugs expiry.

    public function getPointsWithExpiry($customerid, $store_id, $date = null, $arraymode = false, $excludelast = false){
        if($date == null)
            $date = date('Y-m-d');
        $balanceon = strtotime($date);
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query = "SELECT * FROM (SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id, order_id FROM rewardpoints_account WHERE customer_id = ".$customerid." AND order_id IN (-3,-2,-1,-20) UNION SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id, order_id FROM rewardpoints_account, sales_flat_order WHERE rewardpoints_account.customer_id = ".$customerid." AND order_id NOT IN (-3,-2,-1,-20) AND sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending','processing','complete')) AS smogihistory ORDER BY rewardpoints_account_id";
        $smogihistory = $read->fetchAll($query);

        $unsetarray = array();
        for($i = 0; $i < count($smogihistory); $i++)
        {
            $orderid = $smogihistory[$i]['order_id'];
            if(($orderid != -3 || $orderid != -2 || $orderid != -1 || $orderid != -20) && $smogihistory[$i]['points_spent'] > 0)
            {
                $temp = $smogihistory[$i]['points_spent'];
                for($j = $i - 1; $j >= 0; $j--)
                {
                    if(($smogihistory[$j]['order_id'] == $smogihistory[$i]['order_id']) && $smogihistory[$j]['points_current'] > 0)
                    {
                        if($smogihistory[$j]['points_current'] >= $temp)
                        {
                            $smogihistory[$j]['points_current'] -= $temp;
                            $smogihistory[$j]['balance'] -= $temp;
                            array_push($unsetarray,$i);
                            $smogihistory[$i]['points_spent'] = 0;
                        }
                    }
                }
            }
        }

        $lastindex = count($smogihistory);
        if($excludelast)
            $lastindex--;
        for($i = 0; $i < $lastindex; $i++)
        {
            if($smogihistory[$i]['points_spent'] <= 0)
                continue;
            $temp = $smogihistory[$i]['points_spent'];
            $negativebalance = 0;


            $temparray = array();
            for($j = 0; $j < $i; $j++)
            {
                array_push($temparray, array(
                    "index" => $j,
                    "date_end" => $smogihistory[$j]['date_end'],
                    "balance" => $smogihistory[$j]['balance']
                ));
            }
            $date_end = array();
            foreach($temparray as $key => $value)
            {
                $date_end[$key] = $value['date_end'];
            }
            array_multisort($date_end, SORT_ASC, $temparray);
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($temparray[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $temparray[$j]['balance'] > 0)
                {
                    if($temparray[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$temparray[$j]['index']]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $temparray[$j]['balance'];
                        $smogihistory[$temparray[$j]['index']]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }

            /*
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($smogihistory[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $smogihistory[$j]['balance'] > 0)
                {
                    if($smogihistory[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$j]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $smogihistory[$j]['balance'];
                        $smogihistory[$j]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }
            */
        }
        $negativebalance += $temp;
        $balance = 0;
        for($i = 0; $i < count($smogihistory); $i++)
        {
            //if(strtotime($smogihistory[$i]['date_end']) > strtotime($date))
            if(strtotime($smogihistory[$i]['date_end']) > $balanceon)
            {
                $balance += $smogihistory[$i]['balance'];
                $date_exp = $smogihistory[$i]['date_end'];
            }
        }
        if(!$arraymode)
            return $balance;
        else
            return array("history" => $smogihistory,"balance" => $balance,"negativebalance" => $negativebalance,"last_expiry" => $date_exp);
//        echo "<pre>";
//        print_r($smogihistory);
//        echo "<pre>";
        //echo 'Current Balance -> '.$balance;
    }

}
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
class Rewardpoints_Model_Statusfield
{   
    public function toOptionArray()
    {
        return array(
            array('value' => 'state', 'label'=>Mage::helper('rewardpoints')->__('State field')),
            array('value' => 'status', 'label'=>Mage::helper('rewardpoints')->__('Status field')),
        );
    }

}
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
 * Sales Quote Address Total  abstract model
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Sales_Model_Quote_Address_Total_Abstract
{
    /**
     * Total Code name
     *
     * @var string
     */
    protected $_code;
    protected $_address = null;

    /**
     * Various abstract abilities
     * @var bool
     */
    protected $_canAddAmountToAddress = true;
    protected $_canSetAddressAmount   = true;

    /**
     * Key for item row total getting
     *
     * @var string
     */
    protected $_itemRowTotalKey = null;

    /**
     * Set total code code name
     *
     * @param string $code
     * @return Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    public function setCode($code)
    {
        $this->_code = $code;
        return $this;
    }

    /**
     * Retrieve total code name
     *
     * @return unknown
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Label getter
     *
     * @return string
     */
    public function getLabel()
    {
        return '';
    }

    /**
     * Collect totals process.
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        $this->_setAddress($address);
        /**
         * Reset amounts
         */
        $this->_setAmount(0);
        $this->_setBaseAmount(0);
        return $this;
    }

    /**
     * Fetch (Retrieve data as array)
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return array
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $this->_setAddress($address);
        return array();
    }

    /**
     * Set address shich can be used inside totals calculation
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    protected function _setAddress(Mage_Sales_Model_Quote_Address $address)
    {
        $this->_address = $address;
        return $this;
    }

    /**
     * Get quote address object
     *
     * @throw   Mage_Core_Exception if address not declared
     * @return  Mage_Sales_Model_Quote_Address
     */
    protected function _getAddress()
    {
        if ($this->_address === null) {
            Mage::throwException(
                Mage::helper('sales')->__('Address model is not defined.')
            );
        }
        return $this->_address;
    }

    /**
     * Set total model amount value to address
     *
     * @param   float $amount
     * @return  Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    protected function _setAmount($amount)
    {
        if ($this->_canSetAddressAmount) {
            $this->_getAddress()->setTotalAmount($this->getCode(), $amount);
        }
        return $this;
    }

    /**
     * Set total model base amount value to address
     *
     * @param   float $amount
     * @return  Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    protected function _setBaseAmount($baseAmount)
    {
        if ($this->_canSetAddressAmount) {
            $this->_getAddress()->setBaseTotalAmount($this->getCode(), $baseAmount);
        }
        return $this;
    }

    /**
     * Add total model amount value to address
     *
     * @param   float $amount
     * @return  Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    protected function _addAmount($amount)
    {
        if ($this->_canAddAmountToAddress) {
            $this->_getAddress()->addTotalAmount($this->getCode(),$amount);
        }
        return $this;
    }

    /**
     * Add total model base amount value to address
     *
     * @param   float $amount
     * @return  Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    protected function _addBaseAmount($baseAmount)
    {
        if ($this->_canAddAmountToAddress) {
            $this->_getAddress()->addBaseTotalAmount($this->getCode(), $baseAmount);
        }
        return $this;
    }

    /**
     * Get all items except nominals
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return array
     */
    protected function _getAddressItems(Mage_Sales_Model_Quote_Address $address)
    {
        return $address->getAllNonNominalItems();
    }

    /**
     * Getter for row default total
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    public function getItemRowTotal(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        if (!$this->_itemRowTotalKey) {
            return 0;
        }
        return $item->getDataUsingMethod($this->_itemRowTotalKey);
    }

    /**
     * Getter for row default base total
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    public function getItemBaseRowTotal(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        if (!$this->_itemRowTotalKey) {
            return 0;
        }
        return $item->getDataUsingMethod('base_' . $this->_itemRowTotalKey);
    }

    /**
     * Whether the item row total may be compouded with others
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return bool
     */
    public function getIsItemRowTotalCompoundable(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        if ($item->getData("skip_compound_{$this->_itemRowTotalKey}")) {
            return false;
        }
        return true;
    }

    /**
     * Process model configuration array.
     * This method can be used for changing models apply sort order
     *
     * @param   array $config
     * @param   store $store
     * @return  array
     */
    public function processConfigArray($config, $store)
    {
        return $config;
    }
}
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
// >>in case of tax calculation issue, uncomment the appropriate line
//class Rewardpoints_Model_Total_Points extends Mage_Sales_Model_Quote_Address_Total_Discount //magento 1.3.x
//class Rewardpoints_Model_Total_Points extends Mage_SalesRule_Model_Quote_Discount //magento 1.4.x and greater
// ... and comment the following line
class Rewardpoints_Model_Total_Points extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    /*public function __construct()
    {
        //parent::__construct();
        $this->setCode('rewardpoints');
    }*/
    
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        
        if (version_compare(Mage::getVersion(), '1.4.0', '>=') && method_exists($this, '_getAddressItems')){
            $items = $this->_getAddressItems($address);
        } else {
            $items = $address->getAllItems();
        }
        
        if (!count($items)) {
            return $this;
        }

        $totalPPrice = 0;
        $totalPBasePrice = 0;
        
        $this->checkAutoUse($address->getQuote());
		//   $creditPoints = $this->getCreditPoints($address->getQuote());
		
		/*************** for accessories ***********/
		 
		if(! Mage::app()->getStore()->isAdmin() || ! Mage::getDesign()->getArea() == 'adminhtml')
		{
			$creditPoints1 = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote());
			$resource = Mage::getSingleton('core/resource');
			$readConnection = $resource->getConnection('core_read');
			$cartHelper = Mage::helper('checkout/cart');
			$items = $cartHelper->getCart()->getItems();
			$excludecats = Mage::getModel('core/variable')->loadByCode('nosmogicategories')->getValue('plain');
			$excludecats = explode(",", $excludecats);
			$accessories = 0;
            $itemids = array();
            $count = 0;

            foreach ($items as $item) {
                array_push($itemids, $item->getProductId());
            }
			foreach ($items as $item) {
								
									
					
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
									 	$accessories++;
									  $cattotal = $cattotal + $itemstotal;
                                        break;
									}
								}
					
					$tot = $tot + $itemstotal;
                $count++;
								
				}
			Mage::getSingleton('core/session')->setAccessoriesTot($cattotal);
			$grandTotalapplicable = $tot - $cattotal;	
			if($creditPoints1 < $grandTotalapplicable)
			{
			$creditPoints = $creditPoints1;
			}
			else
			{
			$creditPoints = $grandTotalapplicable;
			}
		}
		else
		{
			$creditPoints = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote());
		}
        $subtotalWithDiscount = 0;
        $baseSubtotalWithDiscount = 0;
        
        $totalDiscountAmount = 0;
        $baseTotalDiscountAmount = 0;
        
        if ($userId = Mage::getSingleton('rewardpoints/session')->getReferralUser()){
            $address->getQuote()->setRewardpointsReferrer($userId);
        }
        
        if ($creditPoints > 0 && $this->checkMinUse($address->getQuote())){
            //$pointsAmount = Mage::helper('rewardpoints/data')->convertPointsToMoney($creditPoints, $address->getCustomerId());
            if ($address->getCustomerId()){
                $pointsAmount = Mage::helper('rewardpoints/data')->convertPointsToMoney($creditPoints, $address->getCustomerId());
            } elseif ($address->getQuote()->getCustomerId()) {
                $pointsAmount = Mage::helper('rewardpoints/data')->convertPointsToMoney($creditPoints, $address->getQuote()->getCustomerId());
            } else {
                $pointsAmount = 0;//continue;
            }
            
            foreach ($items as $item) {
                /*if ($item->getProduct()->isVirtual()) {
                    continue;
                }*/
                //echo $item->getProduct()->getData('reward_no_discount');
                //die;
                
                
                if ($product = $item->getProduct()) {
                    if ($product->getData('reward_no_discount')) {
                        continue;
                    }
                }
                if (Mage::getStoreConfig('rewardpoints/default/process_tax', $address->getQuote()->getStoreId()) == 1 && Mage::getStoreConfig('tax/calculation/apply_after_discount', $address->getQuote()->getStoreId()) == 0){
                    $tax = ($item->getTaxBeforeDiscount() ? $item->getTaxBeforeDiscount() : $item->getTaxAmount());
                    $row_base_total = $item->getBaseRowTotal() + $tax;
                } else {
                    $row_base_total = $item->getBaseRowTotal();
                }            
                $baseDiscountAmount = min($row_base_total - $item->getBaseDiscountAmount(), $pointsAmount);
                
                if ($baseDiscountAmount > 0){
                    $points = -$baseDiscountAmount;
                    $totalPBasePrice += $points;
                    $discountAmount = $address->getQuote()->getStore()->convertPrice($points, false);
                    $totalPPrice += $discountAmount;
                    
                    if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                        $item->setDiscountAmount(abs($discountAmount)+$item->getDiscountAmount());
                        $item->setBaseDiscountAmount(abs($baseDiscountAmount)+$item->getBaseDiscountAmount());
                    } else {
                        $item->setDiscountAmount(abs($discountAmount)+$item->getDiscountAmount());
                        $item->setBaseDiscountAmount(abs($baseDiscountAmount)+$item->getBaseDiscountAmount());
                        
                        
                        $item->setRowTotalWithDiscount($item->getRowTotal()-$item->getDiscountAmount());
                        $item->setBaseRowTotalWithDiscount($item->getBaseRowTotal()-$item->getBaseDiscountAmount());

                        $subtotalWithDiscount += $item->getRowTotalWithDiscount();
                        $baseSubtotalWithDiscount += $item->getBaseRowTotalWithDiscount();
                    }
                    
                    //$totalDiscountAmount += $item->getDiscountAmount();
                    //$baseTotalDiscountAmount += $item->getBaseDiscountAmount();
                    
                    $totalDiscountAmount += abs($discountAmount);
                    $baseTotalDiscountAmount += abs($baseDiscountAmount);
                    
                    
                }
                
                $pointsAmount -= $baseDiscountAmount;
            }

            //J2T process shipping address
            $shipping_process = Mage::getStoreConfig('rewardpoints/default/process_shipping', $address->getQuote()->getStoreId());
            if (version_compare(Mage::getVersion(), '1.4.0', '>=') && $shipping_process){
                $shipping_tax = 0;
                if (Mage::getStoreConfig('rewardpoints/default/process_tax', $address->getQuote()->getStoreId()) == 1 && Mage::getStoreConfig('tax/calculation/apply_after_discount', $address->getQuote()->getStoreId()) == 0){
                    $shipping_tax = $address->getBaseShippingTaxAmount();
                }
                
                $baseShippingDiscountAmount = min(($address->getBaseShippingAmount()+$shipping_tax), $pointsAmount);
                $points = -$baseShippingDiscountAmount;
                $totalPBasePrice += $points;
                $totalPPrice += $address->getQuote()->getStore()->convertPrice($points, false);
                $pointsAmount -= $baseShippingDiscountAmount;
            }
            //J2T end process shipping address
            
            
            if ($pts = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote())){
                $address->getQuote()
                        ->setRewardpointsQuantity($pts)
                        ->setBaseRewardpoints(-$totalPBasePrice)
                        ->setRewardpoints(-$totalPPrice);
                        //->save();
            }

            if (abs($totalPBasePrice) > 0){
                $points_used = Mage::helper('rewardpoints/data')->convertMoneyToPoints(abs($totalPBasePrice));
                $points_session = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote());
                if ($points_used < $points_session){
                    Mage::helper('rewardpoints/event')->setCreditPoints($points_used);
                    
                    $address->getQuote()
                            ->setRewardpointsQuantity($points_used)
                            ->setBaseRewardpoints(-$totalPBasePrice)
                            ->setRewardpoints(-$totalPPrice);
                                //->save();
                    
                }
            } else {
                //remove all reward points within this cart
                if ($referrer_id = Mage::getSingleton('rewardpoints/session')->getReferralUser()){
                    Mage::getSingleton('rewardpoints/session')->unsetAll();
                    Mage::getSingleton('rewardpoints/session')->setReferralUser($referrer_id);
                } else {
                    Mage::getSingleton('rewardpoints/session')->unsetAll();
                }
                Mage::helper('rewardpoints/event')->removeCreditPoints($address->getQuote());
            }


            /*$this->_setAmount($totalPPrice)
                ->_setBaseAmount($totalPBasePrice);*/
            
            if ($pts = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote())){
                $title = Mage::helper('rewardpoints')->__('%s smogi bucks used', $pts);
                
                $address->getQuote()->setRewardpointsDescription($title);
                //$title_base = $title;
                
                $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', $address->getQuote()->getStoreId());
                $remove_link = Mage::getStoreConfig('rewardpoints/default/remove_link', $address->getQuote()->getStoreId());
                if (!$auto_use && $remove_link && !Mage::getSingleton('admin/session')->isLoggedIn()){
                    //$title .= ' <a href="javascript:$(\'discountFormPoints2\').submit();" title="'.Mage::helper('rewardpoints')->__('Remove Points').'"><img src="'.Mage::getDesign()->getSkinUrl('images/j2t_delete.gif').'" alt="'.Mage::helper('rewardpoints')->__('Remove Points').'" /></a>';
                    //$title .= '<span id="link_j2t_rewards"></span>';
                }
                
                if ($address->getDiscountDescription() != ''){
                    $desc_array = $address->getDiscountDescriptionArray();
                    $desc_array[] = $title;
                    $address->setDiscountDescriptionArray($desc_array);
                    //$address->setDiscountDescriptionArray($couponCode);
                    $address->setDiscountDescription($address->getDiscountDescription().', '.$title);
                } else {
                    $address->setDiscountDescription($title);
                    $address->setDiscountDescriptionArray(array($title));
                }
                
                //if (version_compare(Mage::getVersion(), '1.6.0', '>=')){
                //if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                if (version_compare(Mage::getVersion(), '1.4.0.1', '>=')){
                    
                    $address->setDiscountAmount($address->getDiscountAmount()+$totalPPrice);                
                    $address->setBaseDiscountAmount($address->getBaseDiscountAmount()+$totalPBasePrice);
                    
                    $this->_addAmount($totalPPrice);
                    $this->_addBaseAmount($totalPBasePrice);
                } else {
                    $address->setDiscountAmount($address->getDiscountAmount()+$totalDiscountAmount);
                    $address->setSubtotalWithDiscount($subtotalWithDiscount);
                    $address->setBaseDiscountAmount($address->getBaseDiscountAmount()+$baseTotalDiscountAmount);
                    $address->setBaseSubtotalWithDiscount($baseSubtotalWithDiscount);
                    if ($coupon = $address->getCouponCode()){
                        $address->setCouponCode($address->getCouponCode().', '.$title);
                    } else {
                        $address->setCouponCode($title);
                    }
                    $address->setGrandTotal($address->getGrandTotal() - $totalDiscountAmount);
                    $address->setBaseGrandTotal($address->getBaseGrandTotal()-$baseTotalDiscountAmount);
                }
                
                //if ($address->getQuote()->getRewardpointsQuantity() != $pts && $pts > 0){
            }
            
        } else {
            //remove all reward points within this cart
            if ($referrer_id = Mage::getSingleton('rewardpoints/session')->getReferralUser()){
                Mage::getSingleton('rewardpoints/session')->unsetAll();
                Mage::getSingleton('rewardpoints/session')->setReferralUser($referrer_id);
            } else {
                Mage::getSingleton('rewardpoints/session')->unsetAll();
            }
            Mage::helper('rewardpoints/event')->removeCreditPoints($address->getQuote());
        }
        
        return $this;
    }

    
    /*public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $pts = $this->getCreditPoints();
        $amount = $address->getRewardpointsAmount();
        
        if ($amount != 0 && $address->getAddressType() == 'shipping') {
            $title = Mage::helper('rewardpoints')->__('%s points used', $pts);
            //skin/frontend/default/default/images/j2t_delete.gif
            $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', Mage::app()->getStore()->getId());
            if (!$auto_use){
                $title .= ' <a href="javascript:$(\'discountFormPoints2\').submit();" title="'.Mage::helper('rewardpoints')->__('Remove Points').'"><img src="'.Mage::getDesign()->getSkinUrl('images/j2t_delete.gif').'" alt="'.Mage::helper('rewardpoints')->__('Remove Points').'" /></a>';
            }
            
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $title,
                'value' => $amount
            ));
        }
        return $this;
    }*/

    
    /*public function getLabel()
    {
        return Mage::helper('rewardpoints')->__('Points');
    }*/
    
    protected function getCreditPoints($quote)
    {	
	    return Mage::helper('rewardpoints/event')->getCreditPoints($quote);
	   //return Mage::getSingleton('core/session')->getCreditPointsApplied();
    }
    
    protected function checkMinUse($quote)
    {
        $store_id = $quote->getStoreId();
        if ($quote->getCustomerId()){
            $customerId = $quote->getCustomerId();
        } else {
            $customerId = Mage::getModel('customer/session')->getCustomerId();
        }
        $min_use = Mage::getStoreConfig('rewardpoints/default/min_use', $store_id);
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_model = Mage::getModel('rewardpoints/flatstats');
            $customer_points = $reward_model->collectPointsCurrent($customerId, $store_id);
        } else {
            $reward_model = Mage::getModel('rewardpoints/stats');
            $customer_points = $reward_model->getPointsCurrent($customerId, $store_id);
        }
        if ($min_use > $customer_points){
            return false;
        }
        return true;
    }
    
    protected function checkAutoUse($quote){
        $customer = Mage::getSingleton('customer/session');
        $store_id = $quote->getStoreId();
        if ($customer->isLoggedIn()){
            
            if ($quote->getCustomerId()){
                $customerId = $quote->getCustomerId();
            } else {
                $customerId = Mage::getModel('customer/session')->getCustomerId();
            }
            
            //$auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', Mage::app()->getStore()->getId());
            $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', $store_id);
            if ($auto_use){
                if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
                    $reward_model = Mage::getModel('rewardpoints/flatstats');
                    $customer_points = $reward_model->collectPointsCurrent($customerId, $store_id);
                } else {
                    $reward_model = Mage::getModel('rewardpoints/stats');
                    $customer_points = $reward_model->getPointsCurrent($customerId, $store_id);
                }

                if ($customer_points && $customer_points > Mage::helper('rewardpoints/event')->getCreditPoints($quote)){
                    $cart_amount = Mage::getModel('rewardpoints/discount')->getCartAmount();
                    $cart_amount = Mage::helper('rewardpoints/data')->processMathValue($cart_amount);
                    $points_value = min(Mage::helper('rewardpoints/data')->convertMoneyToPoints($cart_amount), (int)$customer_points);

                    //echo $points_value;
                    //die;
                    Mage::getSingleton('customer/session')->setProductChecked(0);
                    Mage::helper('rewardpoints/event')->setCreditPoints($points_value);
                    
                    $quote->setRewardpointsQuantity($points_value);
                    //->save();
                }
            }
        }
    }
}
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
 * @package     Mage_SalesRule
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * SalesRule Validator Model
 *
 * Allows dispatching before and after events for each controller action
 *
 * @category   Mage
 * @package    Mage_SalesRule
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_SalesRule_Model_Validator extends Mage_Core_Model_Abstract
{
    /**
     * Rule source collection
     *
     * @var Mage_SalesRule_Model_Mysql4_Rule_Collection
     */
    protected $_rules;

    protected $_roundingDeltas = array();

    protected $_baseRoundingDeltas = array();

    /**
     * Defines if method Mage_SalesRule_Model_Validator::process() was already called
     * Used for clearing applied rule ids in Quote and in Address
     *
     * @deprecated since 1.4.2.0
     * @var bool
     */
    protected $_isFirstTimeProcessRun = false;

    /**
     * Defines if method Mage_SalesRule_Model_Validator::reset() wasn't called
     * Used for clearing applied rule ids in Quote and in Address
     *
     * @var bool
     */
    protected $_isFirstTimeResetRun = true;

    /**
     * Information about item totals for rules.
     * @var array
     */
    protected $_rulesItemTotals = array();

    /**
     * Store information about addresses which cart fixed rule applied for
     *
     * @var array
     */
    protected $_cartFixedRuleUsedForAddress = array();

    /**
     * Init validator
     * Init process load collection of rules for specific website,
     * customer group and coupon code
     *
     * @param   int $websiteId
     * @param   int $customerGroupId
     * @param   string $couponCode
     * @return  Mage_SalesRule_Model_Validator
     */
    public function init($websiteId, $customerGroupId, $couponCode)
    {
        $this->setWebsiteId($websiteId)
            ->setCustomerGroupId($customerGroupId)
            ->setCouponCode($couponCode);

        $key = $websiteId . '_' . $customerGroupId . '_' . $couponCode;
        if (!isset($this->_rules[$key])) {
            $this->_rules[$key] = Mage::getResourceModel('salesrule/rule_collection')
                ->setValidationFilter($websiteId, $customerGroupId, $couponCode)
                ->load();
        }
        return $this;
    }

    /**
     * Get rules collection for current object state
     *
     * @return Mage_SalesRule_Model_Mysql4_Rule_Collection
     */
    protected function _getRules()
    {
        $key = $this->getWebsiteId() . '_' . $this->getCustomerGroupId() . '_' . $this->getCouponCode();
        return $this->_rules[$key];
    }

    /**
     * Get address object which can be used for discount calculation
     *
     * @param   Mage_Sales_Model_Quote_Item_Abstract $item
     * @return  Mage_Sales_Model_Quote_Address
     */
    protected function _getAddress(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        if ($item instanceof Mage_Sales_Model_Quote_Address_Item) {
            $address = $item->getAddress();
        } elseif ($item->getQuote()->getItemVirtualQty() > 0) {
            $address = $item->getQuote()->getBillingAddress();
        } else {
            $address = $item->getQuote()->getShippingAddress();
        }
        return $address;
    }

    /**
     * Check if rule can be applied for specific address/quote/customer
     *
     * @param   Mage_SalesRule_Model_Rule $rule
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  bool
     */
    protected function _canProcessRule($rule, $address)
    {
        if ($rule->hasIsValidForAddress($address) && !$address->isObjectNew()) {
            return $rule->getIsValidForAddress($address);
        }

        /**
         * check per coupon usage limit
         */
        if ($rule->getCouponType() != Mage_SalesRule_Model_Rule::COUPON_TYPE_NO_COUPON) {
            $couponCode = $address->getQuote()->getCouponCode();
            if (strlen($couponCode)) {
                $coupon = Mage::getModel('salesrule/coupon');
                $coupon->load($couponCode, 'code');
                if ($coupon->getId()) {
                    // check entire usage limit
                    if ($coupon->getUsageLimit() && $coupon->getTimesUsed() >= $coupon->getUsageLimit()) {
                        $rule->setIsValidForAddress($address, false);
                        return false;
                    }
                    // check per customer usage limit
                    $customerId = $address->getQuote()->getCustomerId();
                    if ($customerId && $coupon->getUsagePerCustomer()) {
                        $couponUsage = new Varien_Object();
                        Mage::getResourceModel('salesrule/coupon_usage')->loadByCustomerCoupon(
                            $couponUsage, $customerId, $coupon->getId());
                        if ($couponUsage->getCouponId() &&
                            $couponUsage->getTimesUsed() >= $coupon->getUsagePerCustomer()
                        ) {
                            $rule->setIsValidForAddress($address, false);
                            return false;
                        }
                    }
                }
            }
        }

        /**
         * check per rule usage limit
         */
        $ruleId = $rule->getId();
        if ($ruleId && $rule->getUsesPerCustomer()) {
            $customerId     = $address->getQuote()->getCustomerId();
            $ruleCustomer   = Mage::getModel('salesrule/rule_customer');
            $ruleCustomer->loadByCustomerRule($customerId, $ruleId);
            if ($ruleCustomer->getId()) {
                if ($ruleCustomer->getTimesUsed() >= $rule->getUsesPerCustomer()) {
                    $rule->setIsValidForAddress($address, false);
                    return false;
                }
            }
        }
        $rule->afterLoad();
        /**
         * quote does not meet rule's conditions
         */
        if (!$rule->validate($address)) {
            $rule->setIsValidForAddress($address, false);
            return false;
        }
        /**
         * passed all validations, remember to be valid
         */
        $rule->setIsValidForAddress($address, true);
        return true;
    }

    /**
     * Quote item free shipping ability check
     * This process not affect information about applied rules, coupon code etc.
     * This information will be added during discount amounts processing
     *
     * @param   Mage_Sales_Model_Quote_Item_Abstract $item
     * @return  Mage_SalesRule_Model_Validator
     */
    public function processFreeShipping(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        $address = $this->_getAddress($item);
        $item->setFreeShipping(false);

        foreach ($this->_getRules() as $rule) {
            /* @var $rule Mage_SalesRule_Model_Rule */
            if (!$this->_canProcessRule($rule, $address)) {
                continue;
            }

            if (!$rule->getActions()->validate($item)) {
                continue;
            }

            switch ($rule->getSimpleFreeShipping()) {
                case Mage_SalesRule_Model_Rule::FREE_SHIPPING_ITEM:
                    $item->setFreeShipping($rule->getDiscountQty() ? $rule->getDiscountQty() : true);
                    break;

                case Mage_SalesRule_Model_Rule::FREE_SHIPPING_ADDRESS:
                    $address->setFreeShipping(true);
                    break;
            }
            if ($rule->getStopRulesProcessing()) {
                break;
            }
        }
        return $this;
    }

    /**
     * Reset quote and address applied rules
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_SalesRule_Model_Validator
     */
    public function reset(Mage_Sales_Model_Quote_Address $address)
    {
        if ($this->_isFirstTimeResetRun) {
            $address->setAppliedRuleIds('');
            $address->getQuote()->setAppliedRuleIds('');
            $this->_isFirstTimeResetRun = false;
        }

        return $this;
    }

    /**
     * Quote item discount calculation process
     *
     * @param   Mage_Sales_Model_Quote_Item_Abstract $item
     * @return  Mage_SalesRule_Model_Validator
     */
    public function process(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        $item->setDiscountAmount(0);
        $item->setBaseDiscountAmount(0);
        $item->setDiscountPercent(0);
        $quote      = $item->getQuote();
        $address    = $this->_getAddress($item);

        $itemPrice              = $this->_getItemPrice($item);
        $baseItemPrice          = $this->_getItemBasePrice($item);
        $itemOriginalPrice      = $this->_getItemOriginalPrice($item);
        $baseItemOriginalPrice  = $this->_getItemBaseOriginalPrice($item);

        if ($itemPrice < 0) {
            return $this;
        }

        $appliedRuleIds = array();
        foreach ($this->_getRules() as $rule) {
            /* @var $rule Mage_SalesRule_Model_Rule */
            if (!$this->_canProcessRule($rule, $address)) {
                continue;
            }

            if (!$rule->getActions()->validate($item)) {
                continue;
            }

            $qty = $this->_getItemQty($item, $rule);
            $rulePercent = min(100, $rule->getDiscountAmount());

            $discountAmount = 0;
            $baseDiscountAmount = 0;
            //discount for original price
            $originalDiscountAmount = 0;
            $baseOriginalDiscountAmount = 0;

            switch ($rule->getSimpleAction()) {
                case Mage_SalesRule_Model_Rule::TO_PERCENT_ACTION:
                    $rulePercent = max(0, 100-$rule->getDiscountAmount());
                //no break;
                case Mage_SalesRule_Model_Rule::BY_PERCENT_ACTION:
                    $step = $rule->getDiscountStep();
                    if ($step) {
                        $qty = floor($qty/$step)*$step;
                    }
                    $_rulePct = $rulePercent/100;
                    $discountAmount    = ($qty*$itemPrice - $item->getDiscountAmount()) * $_rulePct;
                    $baseDiscountAmount= ($qty*$baseItemPrice - $item->getBaseDiscountAmount()) * $_rulePct;
                    //get discount for original price
                    $originalDiscountAmount    = ($qty*$itemOriginalPrice - $item->getDiscountAmount()) * $_rulePct;
                    $baseOriginalDiscountAmount= ($qty*$baseItemOriginalPrice - $item->getDiscountAmount()) * $_rulePct;

                    if (!$rule->getDiscountQty() || $rule->getDiscountQty()>$qty) {
                        $discountPercent = min(100, $item->getDiscountPercent()+$rulePercent);
                        $item->setDiscountPercent($discountPercent);
                    }
                    break;
                case Mage_SalesRule_Model_Rule::TO_FIXED_ACTION:
                    $quoteAmount = $quote->getStore()->convertPrice($rule->getDiscountAmount());
                    $discountAmount    = $qty*($itemPrice-$quoteAmount);
                    $baseDiscountAmount= $qty*($baseItemPrice-$rule->getDiscountAmount());
                    //get discount for original price
                    $originalDiscountAmount    = $qty*($itemOriginalPrice-$quoteAmount);
                    $baseOriginalDiscountAmount= $qty*($baseItemOriginalPrice-$rule->getDiscountAmount());
                    break;

                case Mage_SalesRule_Model_Rule::BY_FIXED_ACTION:
                    $step = $rule->getDiscountStep();
                    if ($step) {
                        $qty = floor($qty/$step)*$step;
                    }
                    $quoteAmount        = $quote->getStore()->convertPrice($rule->getDiscountAmount());
                    $discountAmount     = $qty*$quoteAmount;
                    $baseDiscountAmount = $qty*$rule->getDiscountAmount();
                    break;

                case Mage_SalesRule_Model_Rule::CART_FIXED_ACTION:
                    if (empty($this->_rulesItemTotals[$rule->getId()])) {
                        Mage::throwException(Mage::helper('salesrule')->__('Item totals are not set for rule.'));
                    }

                    /**
                     * prevent applying whole cart discount for every shipping order, but only for first order
                     */
                    if ($quote->getIsMultiShipping()) {
                        $usedForAddressId = $this->getCartFixedRuleUsedForAddress($rule->getId());
                        if ($usedForAddressId && $usedForAddressId != $address->getId()) {
                            break;
                        } else {
                            $this->setCartFixedRuleUsedForAddress($rule->getId(), $address->getId());
                        }
                    }
                    $cartRules = $address->getCartFixedRules();
                    if (!isset($cartRules[$rule->getId()])) {
                        $cartRules[$rule->getId()] = $rule->getDiscountAmount();
                    }

                    if ($cartRules[$rule->getId()] > 0) {
                        if ($this->_rulesItemTotals[$rule->getId()]['items_count'] <= 1) {
                            $quoteAmount = $quote->getStore()->convertPrice($cartRules[$rule->getId()]);
                            $baseDiscountAmount = min($baseItemPrice * $qty, $cartRules[$rule->getId()]);
                        } else {
                            $discountRate = $baseItemPrice * $qty /
                                            $this->_rulesItemTotals[$rule->getId()]['base_items_price'];
                            $maximumItemDiscount = $rule->getDiscountAmount() * $discountRate;
                            $quoteAmount = $quote->getStore()->convertPrice($maximumItemDiscount);

                            $baseDiscountAmount = min($baseItemPrice * $qty, $maximumItemDiscount);
                            $this->_rulesItemTotals[$rule->getId()]['items_count']--;
                        }

                        $discountAmount = min($itemPrice * $qty, $quoteAmount);
                        $discountAmount = $quote->getStore()->roundPrice($discountAmount);
                        $baseDiscountAmount = $quote->getStore()->roundPrice($baseDiscountAmount);

                        //get discount for original price
                        $originalDiscountAmount = min($itemOriginalPrice * $qty, $quoteAmount);
                        $baseOriginalDiscountAmount = $quote->getStore()->roundPrice($originalDiscountAmount);
                        $baseOriginalDiscountAmount = $quote->getStore()->roundPrice($baseItemOriginalPrice);

                        $cartRules[$rule->getId()] -= $baseDiscountAmount;
                    }
                    $address->setCartFixedRules($cartRules);

                    break;

                case Mage_SalesRule_Model_Rule::BUY_X_GET_Y_ACTION:
                    $x = $rule->getDiscountStep();
                    $y = $rule->getDiscountAmount();
                    if (!$x || $y > $x) {
                        break;
                    }
                    $buyAndDiscountQty = $x + $y;

                    $fullRuleQtyPeriod = floor($qty / $buyAndDiscountQty);
                    $freeQty  = $qty - $fullRuleQtyPeriod * $buyAndDiscountQty;

                    $discountQty = $fullRuleQtyPeriod * $y;
                    if ($freeQty > $x) {
                        $discountQty += $freeQty - $x;
                    }

                    $discountAmount    = $discountQty * $itemPrice;
                    $baseDiscountAmount= $discountQty * $baseItemPrice;
                    //get discount for original price
                    $originalDiscountAmount    = $discountQty * $itemOriginalPrice;
                    $baseOriginalDiscountAmount= $discountQty * $baseItemOriginalPrice;
                    break;
            }

            $result = new Varien_Object(array(
                'discount_amount'      => $discountAmount,
                'base_discount_amount' => $baseDiscountAmount,
            ));
            Mage::dispatchEvent('salesrule_validator_process', array(
                'rule'    => $rule,
                'item'    => $item,
                'address' => $address,
                'quote'   => $quote,
                'qty'     => $qty,
                'result'  => $result,
            ));

            $discountAmount = $result->getDiscountAmount();
            $baseDiscountAmount = $result->getBaseDiscountAmount();

            $percentKey = $item->getDiscountPercent();
            /**
             * Process "delta" rounding
             */
            if ($percentKey) {
                $delta      = isset($this->_roundingDeltas[$percentKey]) ? $this->_roundingDeltas[$percentKey] : 0;
                $baseDelta  = isset($this->_baseRoundingDeltas[$percentKey])
                        ? $this->_baseRoundingDeltas[$percentKey]
                        : 0;
                $discountAmount+= $delta;
                $baseDiscountAmount+=$baseDelta;

                $this->_roundingDeltas[$percentKey]     = $discountAmount -
                                                          $quote->getStore()->roundPrice($discountAmount);
                $this->_baseRoundingDeltas[$percentKey] = $baseDiscountAmount -
                                                          $quote->getStore()->roundPrice($baseDiscountAmount);
                $discountAmount = $quote->getStore()->roundPrice($discountAmount);
                $baseDiscountAmount = $quote->getStore()->roundPrice($baseDiscountAmount);
            } else {
                $discountAmount     = $quote->getStore()->roundPrice($discountAmount);
                $baseDiscountAmount = $quote->getStore()->roundPrice($baseDiscountAmount);
            }

            /**
             * We can't use row total here because row total not include tax
             * Discount can be applied on price included tax
             */

            $itemDiscountAmount = $item->getDiscountAmount();
            $itemBaseDiscountAmount = $item->getBaseDiscountAmount();

            $discountAmount     = min($itemDiscountAmount + $discountAmount, $itemPrice * $qty);
            $baseDiscountAmount = min($itemBaseDiscountAmount + $baseDiscountAmount, $baseItemPrice * $qty);

            $item->setDiscountAmount($discountAmount);
            $item->setBaseDiscountAmount($baseDiscountAmount);

            $item->setOriginalDiscountAmount($originalDiscountAmount);
            $item->setBaseOriginalDiscountAmount($baseOriginalDiscountAmount);

            $appliedRuleIds[$rule->getRuleId()] = $rule->getRuleId();

            $this->_maintainAddressCouponCode($address, $rule);
            $this->_addDiscountDescription($address, $rule);

            if ($rule->getStopRulesProcessing()) {
                break;
            }
        }

        $item->setAppliedRuleIds(join(',',$appliedRuleIds));
        $address->setAppliedRuleIds($this->mergeIds($address->getAppliedRuleIds(), $appliedRuleIds));
        $quote->setAppliedRuleIds($this->mergeIds($quote->getAppliedRuleIds(), $appliedRuleIds));

        return $this;
    }

    /**
     * Apply discounts to shipping amount
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_SalesRule_Model_Validator
     */
    public function processShippingAmount(Mage_Sales_Model_Quote_Address $address)
    {
        $shippingAmount     = $address->getShippingAmountForDiscount();
        if ($shippingAmount!==null) {
            $baseShippingAmount = $address->getBaseShippingAmountForDiscount();
        } else {
            $shippingAmount     = $address->getShippingAmount();
            $baseShippingAmount = $address->getBaseShippingAmount();
        }
        $quote              = $address->getQuote();
        $appliedRuleIds = array();
        foreach ($this->_getRules() as $rule) {
            /* @var $rule Mage_SalesRule_Model_Rule */
            if (!$rule->getApplyToShipping() || !$this->_canProcessRule($rule, $address)) {
                continue;
            }

            $discountAmount = 0;
            $baseDiscountAmount = 0;
            $rulePercent = min(100, $rule->getDiscountAmount());
            switch ($rule->getSimpleAction()) {
                case Mage_SalesRule_Model_Rule::TO_PERCENT_ACTION:
                    $rulePercent = max(0, 100-$rule->getDiscountAmount());
                case Mage_SalesRule_Model_Rule::BY_PERCENT_ACTION:
                    $discountAmount    = ($shippingAmount - $address->getShippingDiscountAmount()) * $rulePercent/100;
                    $baseDiscountAmount= ($baseShippingAmount -
                                          $address->getBaseShippingDiscountAmount()) * $rulePercent/100;
                    $discountPercent = min(100, $address->getShippingDiscountPercent()+$rulePercent);
                    $address->setShippingDiscountPercent($discountPercent);
                    break;
                case Mage_SalesRule_Model_Rule::TO_FIXED_ACTION:
                    $quoteAmount = $quote->getStore()->convertPrice($rule->getDiscountAmount());
                    $discountAmount    = $shippingAmount-$quoteAmount;
                    $baseDiscountAmount= $baseShippingAmount-$rule->getDiscountAmount();
                    break;
                case Mage_SalesRule_Model_Rule::BY_FIXED_ACTION:
                    $quoteAmount        = $quote->getStore()->convertPrice($rule->getDiscountAmount());
                    $discountAmount     = $quoteAmount;
                    $baseDiscountAmount = $rule->getDiscountAmount();
                    break;
                case Mage_SalesRule_Model_Rule::CART_FIXED_ACTION:
                    $cartRules = $address->getCartFixedRules();
                    if (!isset($cartRules[$rule->getId()])) {
                        $cartRules[$rule->getId()] = $rule->getDiscountAmount();
                    }
                    if ($cartRules[$rule->getId()] > 0) {
                        $quoteAmount        = $quote->getStore()->convertPrice($cartRules[$rule->getId()]);
                        $discountAmount     = min(
                            $shippingAmount-$address->getShippingDiscountAmount(),
                            $quoteAmount
                        );
                        $baseDiscountAmount = min(
                            $baseShippingAmount-$address->getBaseShippingDiscountAmount(),
                            $cartRules[$rule->getId()]
                        );
                        $cartRules[$rule->getId()] -= $baseDiscountAmount;
                    }

                    $address->setCartFixedRules($cartRules);
                    break;
            }

            $discountAmount     = min($address->getShippingDiscountAmount()+$discountAmount, $shippingAmount);
            $baseDiscountAmount = min(
                $address->getBaseShippingDiscountAmount()+$baseDiscountAmount,
                $baseShippingAmount
            );
            $address->setShippingDiscountAmount($discountAmount);
            $address->setBaseShippingDiscountAmount($baseDiscountAmount);
            $appliedRuleIds[$rule->getRuleId()] = $rule->getRuleId();

            $this->_maintainAddressCouponCode($address, $rule);
            $this->_addDiscountDescription($address, $rule);
            if ($rule->getStopRulesProcessing()) {
                break;
            }
        }

        $address->setAppliedRuleIds($this->mergeIds($address->getAppliedRuleIds(), $appliedRuleIds));
        $quote->setAppliedRuleIds($this->mergeIds($quote->getAppliedRuleIds(), $appliedRuleIds));

        return $this;
    }

    /**
     * Merge two sets of ids
     *
     * @param array|string $a1
     * @param array|string $a2
     * @param bool $asString
     * @return array
     */
    public function mergeIds($a1, $a2, $asString = true)
    {
        if (!is_array($a1)) {
            $a1 = empty($a1) ? array() : explode(',', $a1);
        }
        if (!is_array($a2)) {
            $a2 = empty($a2) ? array() : explode(',', $a2);
        }
        $a = array_unique(array_merge($a1, $a2));
        if ($asString) {
           $a = implode(',', $a);
        }
        return $a;
    }

    /**
     * Set information about usage cart fixed rule by quote address
     *
     * @param int $ruleId
     * @param int $itemId
     * @return void
     */
    public function setCartFixedRuleUsedForAddress($ruleId, $itemId)
    {
        $this->_cartFixedRuleUsedForAddress[$ruleId] = $itemId;
    }

    /**
     * Retrieve information about usage cart fixed rule by quote address
     *
     * @param int $ruleId
     * @return int|null
     */
    public function getCartFixedRuleUsedForAddress($ruleId)
    {
        if (isset($this->_cartFixedRuleUsedForAddress[$ruleId])) {
            return $this->_cartFixedRuleUsedForAddress[$ruleId];
        }
        return null;
    }

    /**
     * Calculate quote totals for each rule and save results
     *
     * @param mixed $items
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_SalesRule_Model_Validator
     */
    public function initTotals($items, Mage_Sales_Model_Quote_Address $address)
    {
        $address->setCartFixedRules(array());

        if (!$items) {
            return $this;
        }

        foreach ($this->_getRules() as $rule) {
            if (Mage_SalesRule_Model_Rule::CART_FIXED_ACTION == $rule->getSimpleAction()
                && $this->_canProcessRule($rule, $address)) {

                $ruleTotalItemsPrice = 0;
                $ruleTotalBaseItemsPrice = 0;
                $validItemsCount = 0;

                foreach ($items as $item) {
                    //Skipping child items to avoid double calculations
                    if ($item->getParentItemId()) {
                        continue;
                    }
                    if (!$rule->getActions()->validate($item)) {
                        continue;
                    }
                    $qty = $this->_getItemQty($item, $rule);
                    $ruleTotalItemsPrice += $this->_getItemPrice($item) * $qty;
                    $ruleTotalBaseItemsPrice += $this->_getItemBasePrice($item) * $qty;
                    $validItemsCount++;
                }

                $this->_rulesItemTotals[$rule->getId()] = array(
                    'items_price' => $ruleTotalItemsPrice,
                    'base_items_price' => $ruleTotalBaseItemsPrice,
                    'items_count' => $validItemsCount,
                );
            }
        }

        return $this;
    }

    /**
     * Set coupon code to address if $rule contains validated coupon
     *
     * @param  Mage_Sales_Model_Quote_Address $address
     * @param  Mage_SalesRule_Model_Rule $rule
     *
     * @return Mage_SalesRule_Model_Validator
     */
    protected function _maintainAddressCouponCode($address, $rule)
    {
        /*
        Rule is a part of rules collection, which includes only rules with 'No Coupon' type or with validated coupon.
        As a result, if rule uses coupon code(s) ('Specific' or 'Auto' Coupon Type), it always contains validated coupon
        */
        if ($rule->getCouponType() != Mage_SalesRule_Model_Rule::COUPON_TYPE_NO_COUPON) {
            $address->setCouponCode($this->getCouponCode());
        }

        return $this;
    }

    /**
     * Add rule discount description label to address object
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @param   Mage_SalesRule_Model_Rule $rule
     * @return  Mage_SalesRule_Model_Validator
     */
    protected function _addDiscountDescription($address, $rule)
    {
        $description = $address->getDiscountDescriptionArray();
        $ruleLabel = $rule->getStoreLabel($address->getQuote()->getStore());
        $label = '';
        if ($ruleLabel) {
            $label = $ruleLabel;
        } else if (strlen($address->getCouponCode())) {
            $label = $address->getCouponCode();
        }

        if (strlen($label)) {
            $description[$rule->getId()] = $label;
        }

        $address->setDiscountDescriptionArray($description);

        return $this;
    }

    /**
     * Return item price
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    protected function _getItemPrice($item)
    {
        $price = $item->getDiscountCalculationPrice();
        $calcPrice = $item->getCalculationPrice();
        return ($price !== null) ? $price : $calcPrice;
    }

    /**
     * Return item original price
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    protected function _getItemOriginalPrice($item)
    {
        return Mage::helper('tax')->getPrice($item, $item->getOriginalPrice(), true);
    }

    /**
     * Return item base price
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    protected function _getItemBasePrice($item)
    {
        $price = $item->getDiscountCalculationPrice();
        return ($price !== null) ? $item->getBaseDiscountCalculationPrice() : $item->getBaseCalculationPrice();
    }

    /**
     * Return item base original price
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    protected function _getItemBaseOriginalPrice($item)
    {
        return Mage::helper('tax')->getPrice($item, $item->getBaseOriginalPrice(), true);
    }

    /**
     * Return discount item qty
     *
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @param Mage_SalesRule_Model_Rule $rule
     * @return int
     */
    protected function _getItemQty($item, $rule)
    {
        $qty = $item->getTotalQty();
        return $rule->getDiscountQty() ? min($qty, $rule->getDiscountQty()) : $qty;
    }

    /**
     * Convert address discount description array to string
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @param string $separator
     * @return Mage_SalesRule_Model_Validator
     */
    public function prepareDescription($address, $separator=', ')
    {
        $description = $address->getDiscountDescriptionArray();

        if (is_array($description) && !empty($description)) {
            $description = array_unique($description);
            $description = implode($separator, $description);
        } else {
            $description = '';
        }
        $address->setDiscountDescription($description);
        return $this;
    }



}
class Rewardpoints_Model_Validator extends Mage_SalesRule_Model_Validator
{

    public function processShippingAmount(Mage_Sales_Model_Quote_Address $address)
    {
        //parent::process($address);
        parent::processShippingAmount($address);

        $shipping_process = Mage::getStoreConfig('rewardpoints/default/process_shipping', Mage::app()->getStore()->getId());
        if (version_compare(Mage::getVersion(), '1.4.0', '>=') && $shipping_process){
            Mage::getSingleton('rewardpoints/session')->setShippingChecked(0);
            Mage::getModel('rewardpoints/discount')->applyShipping($address);
        }
    }


    public function process(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        parent::process($item);
        
        try {
            $customer = Mage::getSingleton('customer/session');
            if ($customer->isLoggedIn()){

                $customerId = Mage::getModel('customer/session')->getCustomerId();
                

                $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', Mage::app()->getStore()->getId());
                if ($auto_use){
                    if (Mage::getStoreConfig('rewardpoints/default/flatstats', Mage::app()->getStore()->getId())){
                        $reward_model = Mage::getModel('rewardpoints/flatstats');
                        $customer_points = $reward_model->collectPointsCurrent($customerId, Mage::app()->getStore()->getId());
                    } else {
                        $reward_model = Mage::getModel('rewardpoints/stats');
                        $customer_points = $reward_model->getPointsCurrent($customerId, Mage::app()->getStore()->getId());
                    }
                    
                    if ($customer_points && $customer_points > Mage::helper('rewardpoints/event')->getCreditPoints()){
                        $cart_amount = Mage::getModel('rewardpoints/discount')->getCartAmount();
                        $cart_amount = Mage::helper('rewardpoints/data')->processMathValue($cart_amount);
                        

                        $points_value = min(Mage::helper('rewardpoints/data')->convertMoneyToPoints($cart_amount), (int)$customer_points);

                        Mage::getSingleton('customer/session')->setProductChecked(0);
                        Mage::helper('rewardpoints/event')->setCreditPoints($points_value);
                    }
                }
                Mage::getModel('rewardpoints/discount')->apply($item);
            }
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('checkout/session')->addError($e->getMessage());
        } catch (Exception $e) {
           Mage::getSingleton('checkout/session')->addError($e);
        }
        

        return $this;
    }
}