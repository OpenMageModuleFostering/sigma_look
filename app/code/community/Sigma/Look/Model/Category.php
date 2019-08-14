<?php

class Sigma_Look_Model_Category extends Mage_Core_Model_Abstract
{
	protected $_products;
	
	public function _construct()
    {    
        parent::_construct();
    	$this->_init('look/category');
    }
    
    public function getUrl() 
    {
    	$link = Mage::getBaseUrl('web') . 'look/index/detail/id/' . $this->getId();
    	return $link;
    }
    
    
    protected function _beforeSave()
    {
    	if(!$this->getCreatedAt()){
    		$this->setCreatedAt(now());
    	}
    	return parent::_beforeSave();
    }
    
}