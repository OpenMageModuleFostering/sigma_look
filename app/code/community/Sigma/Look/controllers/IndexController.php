<?php
class Sigma_Look_IndexController extends Mage_Core_Controller_Front_Action
{
	const XML_PATH_ENABLED  = 'two/three/text1';	
	
	public function preDispatch()
	{
		parent::preDispatch();

		if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
			$this->norouteAction();
		}	
	}

     public function indexAction()
    {
		$this->loadLayout();  
		$this->getLayout()->getBlock('head')->setTitle($this->__('Look Detail')); 
		$this->renderLayout();
    }
    
    public function listAction()
    {  
    	$this->loadLayout();  		
		$this->getLayout()->getBlock('head')->setTitle($this->__('Look Lists')); 
	    $this->renderLayout();
	   
    }
    public function ajaxAction()
    {	
    	$this->loadLayout(false);   
	    $this->renderLayout();  			
    }
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
}