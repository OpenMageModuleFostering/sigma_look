<?php
class Sigma_Look_Block_Adminhtml_Renderer_Tagged extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$value =  $row->getData($this->getColumn()->getIndex());
		
		if($value==1)
		
		$status='<img src="'.Mage::getDesign()->getSkinUrl('images',array('_area'=>'adminhtml')).'/look/tagged.png'.'" />';			
		else
			$status='';
			
		return $status;
	}
}
?>