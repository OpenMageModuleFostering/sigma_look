<?php
class Sigma_Look_Block_Adminhtml_Renderer_CategoryStatus extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		echo $value =  $row->getData($this->getColumn()->getIndex());
		
		if($value==1)
		
			$status = 'Enabled';
		elseif($value==2)
			$status = 'Disabled';
			
		return $status;
	}
}
?>