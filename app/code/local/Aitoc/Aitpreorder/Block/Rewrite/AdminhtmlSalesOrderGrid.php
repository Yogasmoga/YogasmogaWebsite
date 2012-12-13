<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/AdminhtmlSalesOrderGrid.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ hNNSrZaWVPeqAfBM('a056d3cfd5a2d7701a791744b91b42b2'); ?><?php
/**
 * @copyright  Copyright (c) 2011 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Block_Rewrite_AdminhtmlSalesOrderGrid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    protected function _prepareColumns()
    {
        $res = parent::_prepareColumns();
        $action = $this->_columns['action'];
        unset($this->_columns['action']);
        unset($this->_columns['status']);
        $this->addColumn('status_preorder', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status_preorder',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
        
        $this->_columns['action'] = $action;
        $this->_columns['action']->setId('action');
        $this->_lastColumnId = 'action';
        
        
        return $res;
    }
  
} } 