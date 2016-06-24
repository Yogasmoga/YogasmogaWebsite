<?php

class Ysindia_Career_Block_Adminhtml_Career_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('careerGrid');
      $this->setDefaultSort('career_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('career/career')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('career_id', array(
          'header'    => Mage::helper('career')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'career_id',
      ));

      $this->addColumn('job_state', array(
          'header'    => Mage::helper('career')->__('State'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'job_state',
          'type'      => 'options',
          'options'   => array(
              1 => 'California',
              2 => 'Connecticut',
              3 => 'Massachusetts',
              4 => 'New Jersey',
              5 => 'New York',
			  6 => 'Hawaii',
          ),
      ));

      $this->addColumn('job_title', array(
          'header'    => Mage::helper('career')->__('Job'),
          'align'     =>'left',
          'index'     => 'job_title',
      ));
      $this->addColumn('available_position', array(
          'header'    => Mage::helper('career')->__('A. Position'),
          'align'     =>'left',
          'index'     => 'available_position',
      ));
      $this->addColumn('reporting_to', array(
          'header'    => Mage::helper('career')->__('Reporting to'),
          'align'     =>'left',
          'index'     => 'reporting_to',
      ));
      $this->addColumn('working_with', array(
          'header'    => Mage::helper('career')->__('Working with'),
          'align'     =>'left',
          'index'     => 'working_with',
      ));
      $this->addColumn('type', array(
          'header'    => Mage::helper('career')->__('type'),
          'align'     =>'left',
          'index'     => 'type',
      ));
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('career')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
      $this->addColumn('job_posted', array(
          'header'    => Mage::helper('career')->__('Date Posted'),
          'align'     =>'left',
          'index'     => 'job_posted',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('career')->__('Status'),
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
                'header'    =>  Mage::helper('career')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('career')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('career')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('career')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('career_id');
        $this->getMassactionBlock()->setFormFieldName('career');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('career')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('career')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('career/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('career')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('career')->__('Status'),
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