<?php
class Sigma_Look_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('look/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Category Manager'), Mage::helper('adminhtml')->__('Category Manager'));
		
		return $this;
	}   	

 	
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('look/category')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('look_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('look/entry');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Category Manager'), Mage::helper('adminhtml')->__('Category Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('look/adminhtml_category_edit'))
				->_addLeft($this->getLayout()->createBlock('look/adminhtml_category_edit_tabs'));
				
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('look')->__('Category entry does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_redirect('*/*/edit');
	}
	
	public function saveAction() { 

	  		$data['category_id'] = $this->getRequest()->getParam('id');
			$data['category_name']=$this->getRequest()->getParam('category_name');                                         
            $data['enabled'] = $this->getRequest()->getParam('enabled'); 
			$data['sort_order']=$this->getRequest()->getParam('sort_order');			
			
			if($this->getRequest()->getParam('enabled')==1)		
			{
					$data['enabled_status']   = "Enabled"; 
 			}else{
					$data['enabled_status']   = "Disabled";
			}			
			
				
			//print_r($this->getRequest()->getParams())	; exit;
			$model = Mage::getModel('look/category');	
			$model->setData($data);	
			$model->save();

				
			try {
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('look')->__('Category Entry was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }


	}
 
 
	public function deleteAction() {          
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('look/category');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Category entry was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
      
        $categoryIds = $this->getRequest()->getParam('look');        
        if(!is_array($categoryIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select category entry(s)'));
        } else {
            try {
                foreach ($categoryIds as $categoryId) {
                    $category = Mage::getModel('look/category')->load($categoryId);
                    $category->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($categoryIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    { 
        $categoryIds = $this->getRequest()->getParam('look');       
        if(!is_array($categoryIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select category entry(s)'));
        } else {
            try {
                foreach ($categoryIds as $categoryId) {
                    Mage::getSingleton('look/category')
                        ->load($categoryId)
                        ->setEnabled($this->getRequest()->getParam('status'))
						 ->setEnabledStatus( ($this->getRequest()->getParam('status')==1)  ?  'Enabled'  :  'Disabled') 
                        ->setIsMassupdate(true)
                        ->save();                    
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($categoryIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'category.csv';
        $content    = $this->getLayout()->createBlock('look/adminhtml_category_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'category.xml';
        $content    = $this->getLayout()->createBlock('look/adminhtml_category_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }	

}