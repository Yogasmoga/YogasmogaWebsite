<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$baseTableName = 'email_journey';

$sql = "
SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `email_journey`
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable($baseTableName)};
CREATE TABLE {$this->getTable($baseTableName)} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `email_number` int(11) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `current_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
";

$installer->run($sql);

$installer->endSetup();