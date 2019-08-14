<?php
class Sigma_Look_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_category';
    $this->_blockGroup = 'look'; //module name
    $this->_headerText = Mage::helper('look')->__('Manage Category');
    $this->_addButtonLabel = Mage::helper('look')->__('Add New Category');
    parent::__construct();
  }
}