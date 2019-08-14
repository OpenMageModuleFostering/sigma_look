<?php
class Sigma_Look_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('category_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('look')->__('Category'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('look')->__('Details'),
          'title'     => Mage::helper('look')->__('Details'),
          'content'   => $this->getLayout()->createBlock('look/adminhtml_category_edit_tab_form')->toHtml(),
      ));


      return parent::_beforeToHtml();
  }
}