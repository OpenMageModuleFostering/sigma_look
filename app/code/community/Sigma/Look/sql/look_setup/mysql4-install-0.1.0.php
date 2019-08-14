<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('look_entity')} (
  `look_id` int(11) NOT NULL AUTO_INCREMENT,  
  `desc` text,
  `filename` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,  
  `category` int(2) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `tagged` tinyint(1) DEFAULT 0,
  `tagged_count` int(5) DEFAULT 0,
  `look_name` varchar(100) NOT NULL,
  PRIMARY KEY (`look_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS {$this->getTable('look_product')} (
  `look_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `look_id` int(11) DEFAULT NULL,
  `icon_location` varchar(255) DEFAULT NULL,
  `desc` varchar(2000) DEFAULT NULL,
  `sku` varchar(2000) DEFAULT NULL,
  `icon` int(11) DEFAULT NULL,
  PRIMARY KEY (`look_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS {$this->getTable('look_category')} (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,  
  `enabled` int(11) DEFAULT NULL,
  `enabled_status` varchar(255) DEFAULT NULL,
  `sort_order` int(2) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

")->endSetup();