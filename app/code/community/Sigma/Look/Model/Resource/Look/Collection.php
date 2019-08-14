<?php
class Sigma_Look_Model_Resource_Look_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('look/look');
    }
}

?>