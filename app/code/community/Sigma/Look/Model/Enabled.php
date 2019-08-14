<?php

class Sigma_Look_Model_Enabled extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;    

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED   => Mage::helper('look')->__('Enabled'),
            self::STATUS_DISABLED  => Mage::helper('look')->__('Disabled')            
        );
    }
}