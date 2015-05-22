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
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_grid_collection';
    }

    protected function _prepareCollection()
    {
       // $collection = Mage::getResourceModel($this->_getCollectionClass());
/*		$collection = Mage::getResourceModel($this->_getCollectionClass())
			->join(
				'sales/order_item',
				'`sales/order_item`.order_id=`main_table`.entity_id',
				array(
					//'qty_backordered'  => new Zend_Db_Expr( 'SUM(`sales/order_item`.qty_backordered)'),
					'qty_backordered'  => new Zend_Db_Expr('group_concat(`sales/order_item`.qty_backordered SEPARATOR ",")'),
					//'parent_item_id'  => new Zend_Db_Expr('group_concat(`sales/order_item`.parent_item_id SEPARATOR ",")'),

					)
        );

        $collection->getSelect()->group('entity_id');
		$this->setCollection($collection);
        return parent::_prepareCollection();*/

        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        return parent::_prepareCollection();

//        $collection = Mage::getResourceModel($this->_getCollectionClass())
//            ->join(
//                'sales/order_item',
//                '`sales/order_item`.order_id=`main_table`.entity_id',
//                array(
//                    'qty_backordered'  => new Zend_Db_Expr('group_concat(`sales/order_item`.qty_backordered SEPARATOR ",")'),
//                )
//            );
//
//        $collection->getSelect()->group('main_table.entity_id');
//        $this->setCollection($collection);
//        return parent::_prepareCollection();

    }
	

    protected function _prepareColumns()
    {

        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
            'filter_index' => 'increment_id',
			
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                'index'     => 'store_id',
                'filter_index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
            ));
        }

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'filter_index' => 'main_table.created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
            'filter_index' => 'billing_name',
        ));

        $this->addColumn('shipping_name', array(
            'header' => Mage::helper('sales')->__('Ship to Name'),
            'index' => 'shipping_name',
            'filter_index' => 'shipping_name',
        ));

        $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'base_grand_total',
            'filter_index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
            'index' => 'grand_total',
            'filter_index' => 'grand_total',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));
		
		
        $this->addColumn('qty_backordered', array(
            'header' => Mage::helper('sales')->__('PreOrdered'),
            'index' => 'qty_backordered',
            'filter_index' => 'qty_backordered',
            'type' => 'options',
			'options' => array('Yes'=>'Yes','No'=>'No'),
			'width' => '50px',
			'renderer' => 'Mage_Adminhtml_Block_Sales_Order_Renderer_Qtybool',
			
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'filter_index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action',
                array(
                    'header'    => Mage::helper('sales')->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View'),
                            'url'     => array('base'=>'*/sales_order/view'),
                            'field'   => 'order_id'
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
            ));
        }
        $this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('order_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/cancel')) {
            $this->getMassactionBlock()->addItem('cancel_order', array(
                 'label'=> Mage::helper('sales')->__('Cancel'),
                 'url'  => $this->getUrl('*/sales_order/massCancel'),
            ));
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/hold')) {
            $this->getMassactionBlock()->addItem('hold_order', array(
                 'label'=> Mage::helper('sales')->__('Hold'),
                 'url'  => $this->getUrl('*/sales_order/massHold'),
            ));
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/unhold')) {
            $this->getMassactionBlock()->addItem('unhold_order', array(
                 'label'=> Mage::helper('sales')->__('Unhold'),
                 'url'  => $this->getUrl('*/sales_order/massUnhold'),
            ));
        }

        $this->getMassactionBlock()->addItem('pdfinvoices_order', array(
             'label'=> Mage::helper('sales')->__('Print Invoices'),
             'url'  => $this->getUrl('*/sales_order/pdfinvoices'),
        ));

        $this->getMassactionBlock()->addItem('pdfshipments_order', array(
             'label'=> Mage::helper('sales')->__('Print Packingslips'),
             'url'  => $this->getUrl('*/sales_order/pdfshipments'),
        ));

        $this->getMassactionBlock()->addItem('pdfcreditmemos_order', array(
             'label'=> Mage::helper('sales')->__('Print Credit Memos'),
             'url'  => $this->getUrl('*/sales_order/pdfcreditmemos'),
        ));

        $this->getMassactionBlock()->addItem('pdfdocs_order', array(
             'label'=> Mage::helper('sales')->__('Print All'),
             'url'  => $this->getUrl('*/sales_order/pdfdocs'),
        ));

        $this->getMassactionBlock()->addItem('print_shipping_label', array(
             'label'=> Mage::helper('sales')->__('Print Shipping Labels'),
             'url'  => $this->getUrl('*/sales_order_shipment/massPrintShippingLabel'),
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        }
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
	
	protected function _addColumnFilterToCollection($column) 
	{
		if ($column->getId() == 'qty_backordered' && ( strtolower($column->getFilter()->getValue())=='yes'))
		{
			//$this->getCollection()->addFieldToFilter('qty_backordered', array('gteq' => 1 ));
			$this->getCollection()->addFieldToFilter("(SELECT SUM(qty_backordered) FROM sales_flat_order_item WHERE order_id=main_table.entity_id)", array('is' => new Zend_Db_Expr('NOT NULL')));
			//parent::_addColumnFilterToCollection($column);
		} 
		elseif ($column->getId() == 'qty_backordered' && ( strtolower($column->getFilter()->getValue())=='no'))
		{
			//$qry = "select SUM(`sales/order_item`.qty_backordered) from `sales/order_item`, `main_table` where `sales/order_item`.order_id=".'entity_id';
			//echo $column->getFilter()->getValue();
			//$this->getCollection()->addFieldToFilter(count('qty_backordered'), array('=' => '' ));
			//$this->getCollection()->addAttributeToFilter('qty_backordered', array('is' => new Zend_Db_Expr('')));
			//$this->getCollection()->getSelect()->where('`sales/order_item`.qty_backordered', 'null');
			//parent::_addColumnFilterToCollection($column);
			$this->getCollection()->addFieldToFilter("(SELECT SUM(qty_backordered) FROM sales_flat_order_item WHERE order_id=main_table.entity_id)", array('is' => new Zend_Db_Expr('NULL')));
			
		} 
		else
		{
			parent::_addColumnFilterToCollection($column);
		}
		
		return $this;
	}

}
