<?php

class Sigma_Look_Model_Resource_Category extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
    {    
    	$this->_init('look/category', 'category_id');
    }	
}