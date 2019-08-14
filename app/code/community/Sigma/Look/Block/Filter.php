<?php
class Sigma_Look_Block_Filter extends Mage_Catalog_Block_Product_Abstract
{	
	protected $_recipe;
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getLookCategories()
    {
    	$categoryCollection = Mage::getModel('look/category')->getCollection()->addFieldToFilter('enabled',1)->addOrder('sort_order','ASC')->getData();		
        return $categoryCollection;
		
    }    
    
    
    public function getLook()
    {
    	$id = $this->getRequest()->getParam('id');
		return Mage::getModel('look/look')->getCollection()->addFieldToFilter('look_id', $id)->getFirstItem();
    }
    
        
    public function getLooks($filter)
    {
		if($filter)
			$looks = Mage::getModel('look/look')->getCollection()->setOrder('look_id','DESC')
				->addFieldToFilter('status', 2)->addFieldToFilter('title', array('in' => $filter));
		else
			$looks = Mage::getModel('look/look')->getCollection()->setOrder('look_id','DESC')
				->addFieldToFilter('status', 2);
    	return $looks;
    }
    
    
    public function getProducts()
    {
    	$id = $this->getRequest()->getParam('id');
		return Mage::getModel('look/product')->getCollection()->addFieldToFilter('look_id', $id);
    }
        
	public function getRealProductName($_sku) 
	{
		return Mage::getModel('catalog/product')->loadByAttribute('sku', $_sku)->getName();
	}
	
    public function getRealProducts($skus) 
    {
    	$products = array();
    	foreach($skus as $sku) {
		$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
			if($product)
				$products[] = $product;
    	}
    	return $products;
    }
    
    
}