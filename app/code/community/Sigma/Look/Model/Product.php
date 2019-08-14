<?php

class Sigma_Look_Model_Product extends Mage_Core_Model_Abstract
{
	public function _construct()
    {    
        parent::_construct();
    	$this->_init('look/product');
    }    
}