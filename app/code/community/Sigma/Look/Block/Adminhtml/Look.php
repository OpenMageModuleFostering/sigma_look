<?php
class Sigma_Look_Block_Adminhtml_Look extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_look';
    $this->_blockGroup = 'look';
    $this->_headerText = Mage::helper('look')->__('Manage Looks');
    $this->_addButtonLabel = Mage::helper('look')->__('Add New Look');
    parent::__construct();
  }
}