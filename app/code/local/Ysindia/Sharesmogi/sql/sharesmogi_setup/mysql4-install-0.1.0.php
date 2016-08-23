<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('sharesmogi')};
CREATE TABLE {$this->getTable('sharesmogi')} (
  `sharesmogi_id` int(11) unsigned NOT NULL auto_increment,
  `parent_id` varchar(255) NOT NULL default '',
  `parent_email` varchar(255) NOT NULL default '',
  `parent_smogi` varchar(255) NOT NULL default '',
  `child_id` varchar(255) NOT NULL default '',
  `child_email` varchar(255) NOT NULL default '',
  `child_smogi` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`sharesmogi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 