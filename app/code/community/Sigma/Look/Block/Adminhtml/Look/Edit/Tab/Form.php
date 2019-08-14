<?php
class Sigma_Look_Block_Adminhtml_Look_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('look_form', array('legend'=>Mage::helper('look')->__('Look Details')));

	  $looks = Mage::getModel('look/category')->getCollection()->addFieldToFilter('enabled',1)->getData();
	 
	  foreach($looks as $look)	
	  $data[$look['category_id']] = $look['category_name'];	  
	  
	  $fieldset->addField('look_name', 'text', array(
          'label'     => Mage::helper('look')->__('Look Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'look_name',
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('look')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('look')->__('In Draft'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('look')->__('Published'),
              ),
          ),
      ));

     
      $fieldset->addField('category', 'select', array(
          'label'     => Mage::helper('look')->__('Category'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'category',
		  'values'    => $data,
      ));
	  $fieldset->addField('desc', 'textarea', array(
          'label'     => Mage::helper('look')->__('Description'),
          'required'  => true,		  
          'name'      => 'desc',		
      ));


      
      $fieldset->addField('featured', 'select', array(
          'label'     => Mage::helper('look')->__('Featured'),
          'name'      => 'featured',
          'values'    => array(
              array(
                  'value'     => 0,
                  'label'     => Mage::helper('look')->__('No'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('look')->__('Yes'),
              ),
          ),
      ));
      $afterElementHtml = '<p class="note"><small>' . 'For better appearance please use 605*469px(W*H) jpg image.Please use jpg image only' . '</small></p>';
      $fieldset->addField('filename', 'file', array(
	  		'name' 		=>'filename',
          	'label' 	=> Mage::helper('look')->__('Look Image'),
          	'title'     => Mage::helper('look')->__('Look Image'),
          	'required'  => false,
			'after_element_html' => $afterElementHtml,
	  )); 

      
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