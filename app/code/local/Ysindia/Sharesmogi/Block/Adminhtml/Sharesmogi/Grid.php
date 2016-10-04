<?php

class Ysindia_Sharesmogi_Block_Adminhtml_Sharesmogi_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('sharesmogiGrid');
      $this->setDefaultSort('sharesmogi_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sharesmogi/sharesmogi')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('sharesmogi_id', array(
          'header'    => Mage::helper('sharesmogi')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'sharesmogi_id',
      ));

      $this->addColumn('parent_email', array(
          'header'    => Mage::helper('sharesmogi')->__('Parent Email'),
          'align'     =>'left',
          'index'     => 'parent_email',
      ));
     /* $this->addColumn('parent_smogi', array(
          'header'    => Mage::helper('sharesmogi')->__('Parent Smogi Bucks'),
          'align'     =>'left',
          'index'     => 'parent_smogi',
      ));*/
      $this->addColumn('child_email', array(
          'header'    => Mage::helper('sharesmogi')->__('Child Email'),
          'align'     =>'left',
          'index'     => 'child_email',
      ));
     /* $this->addColumn('child_smogi', array(
          'header'    => Mage::helper('sharesmogi')->__('Child Smogi Bucks'),
          'align'     =>'left',
          'index'     => 'child_smogi',
      ));


      $this->addColumn('content', array(
			'header'    => Mage::helper('sharesmogi')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));


      $this->addColumn('status', array(
          'header'    => Mage::helper('sharesmogi')->__('Status'),
          'align'     => 'left',
          'width'     => '120px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Registered',
              2 => 'Not Registered',
          ),
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('sharesmogi')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('sharesmogi')->__('Edit'),*/
                        //'url'       => array('base'=> '*/*/edit'),
                      /*  'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));*/
		
		$this->addExportType('*/*/exportCsv', Mage::helper('sharesmogi')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('sharesmogi')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sharesmogi_id');
        $this->getMassactionBlock()->setFormFieldName('sharesmogi');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('sharesmogi')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('sharesmogi')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('sharesmogi/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('sharesmogi')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('sharesmogi')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      //return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}