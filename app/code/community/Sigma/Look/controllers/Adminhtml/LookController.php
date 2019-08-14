<?php
class Sigma_Look_Adminhtml_LookController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('look/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Look Manager'), Mage::helper('adminhtml')->__('Look Manager'));
		
		return $this;
	}   
 
 	public function savecordsAction()
 	{
 		try {
	 		$data = $this->getRequest()->getParams();
	 		$icon = substr($data['element'], -1);
	 		$product = Mage::getModel('look/product')->getCollection()
	 			->addFieldToFilter('look_id', $data['id'])
	 			->addFieldToFilter('icon', $icon)
	 			->getFirstItem();
	 		if($product->getId()) {
	 			$product->setIconLocation($data['x'] . "," . $data['y']);
	 			$product->save();
	 		}
 		} catch(Exception $e) {
 			echo "An error occured: " . $e->getMessage();
 		}
 	}
	public function removeTagAction()
 	{
 		try {
	 		$data = $this->getRequest()->getParams();
	 		$icon = substr($data['element'], -1);
	 		$product = Mage::getModel('look/product')->getCollection()
	 			->addFieldToFilter('look_id', $data['id'])
	 			->addFieldToFilter('icon', $icon)
	 			->getFirstItem();
	 		if($product->getId()) {
	 			$product->delete();
				
				// To set the Tagged value to true or false
				$this->setLookTagged($data['id']);
	 		}
 		} catch(Exception $e) {
 			echo "An error occured: " . $e->getMessage();
 		}
 	}
 	
 	public function saveproductAction()
 	{
 		try {
	 		
			
			$data = $this->getRequest()->getParams();
			
			if($data['sku']) {
	 			$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $data['sku']);		
				
				
			    if(is_object($product))
				{
						if( count($product->getData()) )
						{
								$image= Mage::getModel('catalog/product')->load($product->getId())->getMediaGalleryImages();
								$_images = $image->getItemByColumnValue('label','#');									
								
								if(is_object($_images))
								{
									if($_images->getData('label')=='#')										
									{
										$lookImagePath = $_images->getData('url');
									}
								}else{
								
									echo "error_1"; 
									exit;
								}	
							
						}else{
							echo "error";
							exit;
						}
				}
				else{
					echo "error";
					exit;
				}
			} 				
			
			if($product) {
				$productName=$product->getName();
			} else {
				echo "error";
				exit;
			}
			
			if($data['sku']) {
			Mage::getModel('look/product')
	 			->setId(null)
	 			->setLookId($data['id'])
	 			->setIconLocation($data['x'] . "," . $data['y'])
	 			->setDesc($data['desc'])
	 			->setSku($data['sku'])
	 			->setIcon($data['icon'])
	 			->save();
				
			// To set the Tagged value to true or false
			$this->setLookTagged($data['id']);

			}
	 		if($productName) {
				$response = array();

				$response['imgurl'] = addslashes($lookImagePath);
				$response['iconid'] = $data['icon'];
				echo json_encode($response);
				/* echo json_encode("<div class='list-icon'><img src='" . Mage::getBaseUrl('skin') . 'frontend/base/default/images/look/' . $data['icon'] . ".png' /></div><div class='list-details'><h5>" . $productName . "</h5><span>" . $data['desc'] . "</span>".$baseImagePath."</div>"); */
			} else {
				echo "error";
			}
 		} catch(Exception $e) {
 			echo "An error occured: " . $e->getMessage();
 		}
 	}
 	
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('look/look')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('look_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('look/entry');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Looks Manager'), Mage::helper('adminhtml')->__('Looks Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('look/adminhtml_look_edit'))
				->_addLeft($this->getLayout()->createBlock('look/adminhtml_look_edit_tabs'));
				
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('look')->__('look entry does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_redirect('*/*/edit');
	}
	public function setLookTagged($look_id)
	{
			if($look_id) {
				$look_product_count=Mage::getModel('look/product')->getCollection()->addFieldToFilter('look_id',$look_id)->count();
				$model = Mage::getModel('look/look')->load($look_id);
				if($look_product_count)
				{
					$model->setTagged(true);
					$model->setTaggedCount($look_product_count);
				}
				else
				{
					$model->setTagged(false);
					$model->setTaggedCount(0);
				}
				$model->save();
			}
	}
	public function saveAction()
	{
		if ($data =$this->getRequest()->getPost()) {                   
				   $category_id =  $this->getRequest()->getPost('category');
				   $categoryInfo = Mage::getModel('look/category')->load($category_id);                   
				   $data['category_name'] = $categoryInfo->getData('category_name');				   
				 
				if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
						/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// extensions that would work
					$uploader->setAllowedExtensions(array('jpg','jpeg'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(false);
					
					
					// We set media as the upload dir
					//check what site the image if for and set folder
					$path = "media/look/";
					if(!is_dir($path)) {
						mkdir("media/look");
						mkdir("media/look/tn");
					}

					$filename = $_FILES['filename']['name'];
					
					//make sure to rename if file exists with same name
					if (file_exists($path . $filename)) {
						$tmpVar = 1;
						while(file_exists($path . $tmpVar . '_' . $filename)) {
							$tmpVar++;
						}
						$filename = $tmpVar . '_' . $filename;
					}
					//replace whitespace in filename
					$filename = str_replace(" ", "_", $filename);			

						$uploader->save($path, $filename);

							// resizing uploaded image
						$base = new Varien_Image($path . $filename);
						$base->constrainOnly(TRUE);
						$base->keepAspectRatio(False);
						$base->quality(95);
						$base->save($path . $filename);
						$base->resize(605,469);
						$base->save($path,$filename);
					
					//resize image
					$thumb = new Varien_Image($path . $filename);
					$thumb->constrainOnly(TRUE);
										$thumb->keepAspectRatio(TRUE);
										$thumb->quality(95);
					
					$thumb->save($path . $filename);
					$thumb->resize(306,357);
					$thumb->save($path . "tn/" . $filename);
					
				} 
				catch (Exception $e) {					                                
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('look')->__($e->getMessage()));										
					$this->_redirectReferer($defaultUrl=null);
					return;					
				}
			
				//this way the name is saved in DB
				$data['filename'] = $filename;
			}		
				
			$look_id=$this->getRequest()->getParam('id');
			$model = Mage::getModel('look/look');	
			$model->setData($data)
				  ->setId($look_id);
			
			$model->save();
			
			// To set the Tagged value to true or false
			$this->setLookTagged($look_id);
				
			try {
			
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('look')->__('Look Entry was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('look')->__('Unable to find look entry to save'));
        $this->_redirect('*/*/');
	}
 
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('look/look');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('look entry was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $looksIds = $this->getRequest()->getParam('look');
        if(!is_array($looksIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select look entry(s)'));
        } else {
            try {
                foreach ($looksIds as $looksId) {
                    $looks = Mage::getModel('look/look')->load($looksId);
                    $looks->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($looksIds)
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
        $looksIds = $this->getRequest()->getParam('look');
        if(!is_array($looksIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select look entry(s)'));
        } else {
            try {
                foreach ($looksIds as $looksId) {
                    $looks = Mage::getSingleton('look/look')
                        ->load($looksId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($looksIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'look.csv';
        $content    = $this->getLayout()->createBlock('look/adminhtml_look_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'look.xml';
        $content    = $this->getLayout()->createBlock('look/adminhtml_look_grid')
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