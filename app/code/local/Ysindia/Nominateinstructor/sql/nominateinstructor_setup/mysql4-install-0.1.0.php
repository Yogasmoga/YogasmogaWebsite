<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('nominateinstructor')};
CREATE TABLE {$this->getTable('nominateinstructor')} (
  `nominateinstructor_id` int(11) unsigned NOT NULL auto_increment,
  `your_first_name` varchar(255) NOT NULL default '',
  `your_last_name` varchar(255) NOT NULL default '',
  `your_email` varchar(255) NOT NULL default '',
  `your_gender` varchar(255) NOT NULL default '',
  `instructor_first_name` varchar(255) NOT NULL default '',
  `instructor_last_name` varchar(255) NOT NULL default '',
  `instructor_email` varchar(255) NOT NULL default '',
  `instructor_gender` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`nominateinstructor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 