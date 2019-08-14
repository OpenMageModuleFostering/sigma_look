<?php

class Sigma_Look_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
     public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'look'; //module name
        $this->_controller = 'adminhtml_category';
        
        $this->_updateButton('save', 'label', Mage::helper('look')->__('Save Entry'));
        $this->_updateButton('delete', 'label', Mage::helper('look')->__('Delete Entry'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('looks_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'looks_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'looks_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('look_data') && Mage::registry('look_data')->getId() ) {		
            return Mage::helper('look')->__("Edit Entry '%s'", $this->htmlEscape(Mage::registry('look_data')->getCategoryName()));
        } else {
            return Mage::helper('look')->__('Add Entry');
        }
    }
}