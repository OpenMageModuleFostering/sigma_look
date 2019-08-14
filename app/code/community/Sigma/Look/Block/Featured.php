<?php
 
class Sigma_Look_Block_Featured extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
    }
    
    public function getFeaturedLooks()
    {
    	$collection = Mage::getModel('look/look')->getCollection()
    		->addFieldToFilter('featured', 1);
    	$collection->getSelect()->limit(5); 
    	return $collection;
    }
}