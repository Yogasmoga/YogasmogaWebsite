<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('career')};
CREATE TABLE {$this->getTable('career')} (
  `career_id` int(11) unsigned NOT NULL auto_increment,
  `job_state` varchar(255) NOT NULL default '',
  `job_title` varchar(255) NOT NULL default '',
  `available_position` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `reporting_to` varchar(255) NOT NULL default '',
  `working_with` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `compensation` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `introduction` text NOT NULL default '',
  `responsibilities` text NOT NULL default '',
  `desired_skill` text NOT NULL default '',
  `how_to_apply` text NOT NULL default '',
  `about_ys` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`career_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 