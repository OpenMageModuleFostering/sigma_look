<?php

class Sigma_Look_Model_Resource_Product extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
    {    
    	$this->_init('look/product', 'look_product_id');
    }	
}