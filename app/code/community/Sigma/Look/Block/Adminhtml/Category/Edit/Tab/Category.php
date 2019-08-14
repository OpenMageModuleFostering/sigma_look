<?php
class Sigma_Look_Block_Adminhtml_Category_Edit_Tab_Look extends Mage_Adminhtml_Block_Abstract
{
	public function _construct() 
	{
		$this->setTemplate('look/look.phtml');
	}
	
	public function getLook($_id)
	{
		return Mage::getModel('look/category')->load($_id);
	}
	
	public function getProducts()
    {
    	$id = $this->getRequest()->getParam('id');
    	$details = Mage::getModel('look/product')->getCollection()->addFieldToFilter('look_id', $id);
    	return $details;
    }
    
    public function getProductName($sku = null)
    {
    	$product=Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
		if($product)
			$name=$product->getName();
		else
			$name='error';
		return $name;
    }
}
