<?php
class Sigma_Look_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('category_form', array('legend'=>Mage::helper('look')->__('Category Details')));

		$fieldset->addField('category_name', 'text', array(
		  'label'     => Mage::helper('look')->__('Category Name'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'category_name'));
     
	    $fieldset->addField('enabled', 'select', array(
          'label'     => Mage::helper('look')->__('Enabled'),
          'name'      => 'enabled',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('look')->__('Yes'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('look')->__('No'),
              ),
          ),
        ));
		
		$fieldset->addField('sort_order', 'text', array(
		  'label'     => Mage::helper('look')->__('Sort Order'),
		  'class'     => 'required-entry validate-digits',
		  'required'  => true,		
		  'name'      => 'sort_order'));		  
		  
      
      if ( Mage::getSingleton('adminhtml/session')->getLooksData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getLooksData());
          Mage::getSingleton('adminhtml/session')->setLooksData(null);
      } elseif ( Mage::registry('look_data') ) {
          $form->setValues(Mage::registry('look_data')->getData());
      }
      return parent::_prepareForm();
  }
}