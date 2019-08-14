<?php
class Sigma_Look_Block_Look extends Mage_Catalog_Block_Product_Abstract
{	
	protected $_recipe;
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getLook()
    {
    	$id = $this->getRequest()->getParam('id');
		return Mage::getModel('look/look')->getCollection()->addFieldToFilter('look_id', $id)->getFirstItem();
    }
    
        
    public function getLooks()
    {		
		$cat = $this->getRequest()->getParam('cat');		
		$page = $this->getRequest()->getParam('page');
            
		$defaultCurrentPageSize =  Mage::getStoreConfig('two/three/text2') ? Mage::getStoreConfig('two/three/text2') : 4; //Getting number of looks to be displayed	
		$defaultCurrentPage = $page*$defaultCurrentPageSize;	 	

			$looks = Mage::getModel('look/look')->getCollection()->addFieldToFilter('status', 2); //If no filter is applied			
                        
                        if($cat)
                        {
                                $catefilter = explode(',',$cat);
                                $looks->addFieldToFilter('category', array('in' => $catefilter));
                        }
                        
                        $dummylooks = clone $looks;             
                                                
                        $total_pages = ceil(count($dummylooks)/$defaultCurrentPageSize);
                                                
                        if($total_pages <= $page-1)
                        {
							echo 0;
							exit;
                        }
                        $looks ->getSelect()->limit($defaultCurrentPageSize,$defaultCurrentPage);                

                        //$looks->setPageSize($defaultCurrentPageSize)->setCurPage($defaultCurrentPage);						                        
				
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
        $prodcollection = Mage::getModel('catalog/product')->getCollection()->addFieldToFilter('sku',array('in'=>$skus));
        
    	return $prodcollection;
    }
	
      public function getLookName($lookId) 
    {
    	return Mage::getModel('look/look')->load($lookId)->getData('look_name');
    }
    
}