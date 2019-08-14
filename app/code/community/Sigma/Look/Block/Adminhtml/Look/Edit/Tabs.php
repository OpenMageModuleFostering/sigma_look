<?php
class Sigma_Look_Block_Adminhtml_Look_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('look_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('look')->__('Look'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('look')->__('Details'),
          'title'     => Mage::helper('look')->__('Details'),
          'content'   => $this->getLayout()->createBlock('look/adminhtml_look_edit_tab_form')->toHtml(),
      ));
      $this->addTab('look_section', array(
          'label'     => Mage::helper('look')->__('Products'),
          'title'     => Mage::helper('look')->__('Products'),
          'content'   => $this->getLayout()->createBlock('look/adminhtml_look_edit_tab_look')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}