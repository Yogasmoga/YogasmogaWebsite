<?php
/**
 * Created by PhpStorm.
 * User: BlankO
 * Date: 25-07-2016
 * Time: 03:11 PM
 */


class Mage_Adminhtml_Block_Report_Customer_Renderer_Smogi extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row) {
        $customerId =  $row['customer_id'];

        $store_id = Mage::app()->getStore()->getId();
        $reward_model = Mage::getModel('rewardpoints/stats');
        $smogirecord = $reward_model->getPointsCurrent($customerId, $store_id);
        return $smogirecord;
    }
}