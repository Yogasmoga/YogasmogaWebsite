<?php

class Ysindia_Nominateinstructor_Block_Adminhtml_Nominateinstructor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('nominateinstructorGrid');
      $this->setDefaultSort('nominateinstructor_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('nominateinstructor/nominateinstructor')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('nominateinstructor_id', array(
          'header'    => Mage::helper('nominateinstructor')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'nominateinstructor_id',
      ));

      $this->addColumn('your_last_name', array(
          'header'    => Mage::helper('nominateinstructor')->__('Surname'),
          'align'     =>'left',
          'index'     => 'your_last_name',
      ));
	  $this->addColumn('your_email', array(
          'header'    => Mage::helper('nominateinstructor')->__('Email'),
          'align'     =>'left',
          'index'     => 'your_email',
      ));
	  
	  $this->addColumn('instructor_last_name', array(
          'header'    => Mage::helper('nominateinstructor')->__('Instructor Surname'),
          'align'     =>'left',
          'index'     => 'instructor_last_name',
      ));
	  
		$this->addColumn('instructor_email', array(
          'header'    => Mage::helper('nominateinstructor')->__('Instructor Email'),
          'align'     =>'left',
          'index'     => 'instructor_email',
      ));
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('nominateinstructor')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('nominateinstructor')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('nominateinstructor')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('nominateinstructor')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('nominateinstructor')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('nominateinstructor')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('nominateinstructor_id');
        $this->getMassactionBlock()->setFormFieldName('nominateinstructor');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('nominateinstructor')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('nominateinstructor')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('nominateinstructor/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('nominateinstructor')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('nominateinstructor')->__('Status'),
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