<?php

class Sigma_Look_Model_Resource_Look extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
    {    
    	$this->_init('look/look', 'look_id');
    }	
}