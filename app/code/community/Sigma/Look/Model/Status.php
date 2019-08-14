<?php

class Sigma_Look_Model_Status extends Varien_Object
{
    const STATUS_INDRAFT	= 1;
    const STATUS_PUBLISHED	= 2;   

    static public function getOptionArray()
    {
        return array(
            self::STATUS_INDRAFT    => Mage::helper('look')->__('In Draft'),
            self::STATUS_PUBLISHED  => Mage::helper('look')->__('Published'),            
        );
    }
}