<?php

class Sigma_Look_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('categoryGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('look/category')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      
//	  Other Columns: action, entity_id, etc...
      $this->addColumn('id', array(
          'header'    => Mage::helper('look')->__('Category Id'),
          'align'     =>'left',
      	  'width'     => '200px',
          'index'     => 'category_id',
      ));
  	
      $this->addColumn('category_name', array(
          'header'    => Mage::helper('look')->__('Category Name'),
          'align'     =>'left',
      	  'width'     => '200px',
          'index'     => 'category_name',
      ));	  

	$this->addColumn('enabled_status', array(
		'header'    => Mage::helper('look')->__('Status'),
		'align'     =>'left',
		'width'     => '50px',
		'index'     => 'enabled_status',
		'renderer' => 'Sigma_Look_Block_Adminhtml_Renderer_CategoryStatus'
	));



	  
	  
	    $this->addColumn('action',
            array(
                'header'    => Mage::helper('look')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('look')->__('Edit'),
                        'url'     => array('base'=>'*/*/edit'),
                        'field'   => 'id'
                        )
                    ),
                'filter'    => false,
                'sortable'  => false
            )
        );
      

      
	$this->addExportType('*/*/exportCsv', Mage::helper('look')->__('CSV'));
	$this->addExportType('*/*/exportXml', Mage::helper('look')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('look');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('look')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('look')->__('Are you sure?')
        ));


        $statuses = Mage::getSingleton('look/enabled')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('look')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('look')->__('Status'),
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