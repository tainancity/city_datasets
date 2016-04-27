SET NAMES utf8;

DROP TABLE IF EXISTS `acos`;
CREATE TABLE IF NOT EXISTS `acos`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`parent_id` int(11), 
	`model` varchar(64), 
	`foreign_key` int(11), 
	`alias` varchar(128), 
	`lft` int(11), 
	`rght` int(11), 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `aros`;
CREATE TABLE IF NOT EXISTS `aros`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`parent_id` int(11), 
	`model` varchar(64), 
	`foreign_key` int(11), 
	`alias` varchar(128), 
	`lft` int(11), 
	`rght` int(11), 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `aros_acos`;
CREATE TABLE IF NOT EXISTS `aros_acos`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`aro_id` int(11), 
	`aco_id` int(11), 
	`_create` int(2) DEFAULT NULL, 
	`_read` int(2) DEFAULT NULL, 
	`_update` int(2) DEFAULT NULL, 
	`_delete` int(2) DEFAULT NULL, 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`group_id` int(11), 
	`username` varchar(64), 
	`password` varchar(48), 
	`user_status` varchar(1) DEFAULT 'N', 
	`created` datetime, 
	`modified` datetime, 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`parent_id` int(11), 
	`name` varchar(64), 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `group_permissions`;
CREATE TABLE IF NOT EXISTS `group_permissions`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`parent_id` int(11), 
	`order` int(11), 
	`name` varchar(64), 
	`description` varchar(255) DEFAULT NULL, 
	`acos` varchar(255), 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `datasets_tags`;
CREATE TABLE IF NOT EXISTS `datasets_tags`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`Dataset_id` int(11), 
	`Tag_id` int(11), 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `datasets`;
CREATE TABLE IF NOT EXISTS `datasets`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`Organization_id` int(11), 
	`parent_id` varchar(255) DEFAULT NULL, 
	`name` varchar(255) DEFAULT NULL, 
	`foreign_id` varchar(255) DEFAULT NULL, 
	`foreign_uri` varchar(255) DEFAULT NULL, 
	`lft` varchar(255) DEFAULT NULL, 
	`rght` varchar(255) DEFAULT NULL, 
	`created` varchar(255) DEFAULT NULL, 
	`modified` varchar(255) DEFAULT NULL, 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `organizations_tags`;
CREATE TABLE IF NOT EXISTS `organizations_tags`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`Organization_id` int(11), 
	`Tag_id` int(11), 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE IF NOT EXISTS `organizations`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`parent_id` varchar(255) DEFAULT NULL, 
	`name` varchar(255) DEFAULT NULL, 
	`foreign_id` varchar(255) DEFAULT NULL, 
	`foreign_uri` varchar(255) DEFAULT NULL, 
	`lft` varchar(255) DEFAULT NULL, 
	`rght` varchar(255) DEFAULT NULL, 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`parent_id` varchar(255) DEFAULT NULL, 
	`name` varchar(255) DEFAULT NULL, 
	`model` varchar(255) DEFAULT NULL, 
	`lft` varchar(255) DEFAULT NULL, 
	`rght` varchar(255) DEFAULT NULL, 
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

