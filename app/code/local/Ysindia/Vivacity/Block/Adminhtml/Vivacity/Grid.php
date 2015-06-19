<?php

class Ysindia_Vivacity_Block_Adminhtml_Vivacity_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('vivacityGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('vivacity/vivacity')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('vivacity')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('order_id', array(
          'header'    => Mage::helper('vivacity')->__('Order Id'),
          'align'     =>'left',
          'index'     => 'order_id',
      ));
	  $this->addColumn('selected_size', array(
          'header'    => Mage::helper('vivacity')->__('Selected Size'),
          'align'     =>'left',
          'index'     => 'selected_size',
      ));
	  
	  $this->addColumn('created_time', array(
          'header'    => Mage::helper('vivacity')->__('Created Time'),
          'align'     =>'left',
          'index'     => 'created_time',
      ));

	  $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('vivacity')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('vivacity')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('vivacity')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('vivacity')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('vivacity');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('vivacity')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('vivacity')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('vivacity/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('vivacity')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('vivacity')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}