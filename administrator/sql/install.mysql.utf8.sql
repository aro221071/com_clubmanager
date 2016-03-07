CREATE TABLE IF NOT EXISTS `#__clubmanager_country` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `code2` VARCHAR(2)  NOT NULL ,
  `code3` VARCHAR(3)  NOT NULL ,
  `phonecode` VARCHAR(5)  NOT NULL ,
  `domain` VARCHAR(5)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_county` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `country` INT NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_district` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `country` INT NOT NULL ,
  `county` INT NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_role` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,                    
  `shortname` VARCHAR(10)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_peoplegroup` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_gender` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_salutation` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_union` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `shortname` VARCHAR(10)  NOT NULL ,
  `name` VARCHAR(50)  NOT NULL ,
  `website` VARCHAR(50)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_unioninternational` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `website` VARCHAR(50)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_unioncountry` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `website` VARCHAR(50)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_unioncounty` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `website` VARCHAR(50)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_uniondistrict` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(60)  NOT NULL ,
  `shortname` VARCHAR(10)  NOT NULL ,
  `name` VARCHAR(50)  NOT NULL ,
  `unioncountry` INT NOT NULL ,
  `unioncounty` INT NOT NULL ,
  `website` VARCHAR(50)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_club` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(70)  NOT NULL ,
  `praefix` VARCHAR(10)  NOT NULL ,
  `union` INT NOT NULL ,
  `name` VARCHAR(50)  NOT NULL ,
  `street` VARCHAR(50)  NOT NULL ,
  `postalcode` INT NOT NULL ,
  `city` INT NOT NULL ,
  `country` INT NOT NULL ,
  `county` INT NOT NULL ,
  `district` INT NOT NULL ,
  `ownclub` VARCHAR(255)  NOT NULL ,
  `zvrno` VARCHAR(12)  NOT NULL ,
  `website` VARCHAR(50)  NOT NULL ,
  `phone1` VARCHAR(25)  NOT NULL ,
  `phone2` VARCHAR(25)  NOT NULL ,
  `phone3` VARCHAR(25)  NOT NULL ,
  `email1` VARCHAR(50)  NOT NULL ,
  `email2` VARCHAR(50)  NOT NULL ,
  `email3` VARCHAR(50)  NOT NULL ,
  `location` VARCHAR(50)  NOT NULL ,
  `distance` FLOAT NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `unioncountry` INT NOT NULL ,
  `unioncounty` INT NOT NULL ,
  `uniondistrict` INT NOT NULL ,
  `uniondistrictno` VARCHAR(10)  NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_city` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `postalcode` VARCHAR(10)  NOT NULL ,
  `district` INT NOT NULL ,
  `county` INT NOT NULL ,
  `country` INT NOT NULL ,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_setting` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL ,
  `key` INT(11)  NOT NULL ,
  `datatype` INT(11)  NOT NULL ,
  `value_numeric` REAL NOT NULL ,
  `value_text` VARCHAR(50)  NOT NULL ,
  `value_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_changelog` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tablename` VARCHAR(50)  NOT NULL ,
  `columnname` VARCHAR(50)  NOT NULL ,
  `recordid` INT(11)  NOT NULL ,
  `valueold` VARCHAR(255)  NOT NULL ,
  `valuenew` VARCHAR(255)  NOT NULL ,
  `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__clubmanager_people` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(60)  NOT NULL ,
  `firstname` VARCHAR(255)  NOT NULL ,
  `lastname` VARCHAR(50)  NOT NULL ,
  `salutation` INT NOT NULL ,
  `gender` INT NOT NULL ,
  `nickname` VARCHAR(25)  NOT NULL ,
  `birthdate` DATE NOT NULL DEFAULT '0000-00-00',
  `memberclub` INT NOT NULL ,
  `memberno` VARCHAR(10)  NOT NULL ,
  `phone1` VARCHAR(25)  NOT NULL ,
  `phone2` VARCHAR(25)  NOT NULL ,
  `phone3` VARCHAR(25)  NOT NULL ,
  `email1` VARCHAR(50)  NOT NULL ,
  `email2` VARCHAR(50)  NOT NULL ,
  `email3` VARCHAR(50)  NOT NULL ,
  `street` VARCHAR(50)  NOT NULL ,
  `postalcode` INT NOT NULL ,
  `city` VARCHAR(50)  NOT NULL ,
  `county` INT NOT NULL ,
  `country` INT NOT NULL ,
  `district` INT NOT NULL ,
  `website` VARCHAR(50)  NOT NULL ,
  `function` VARCHAR(50)  NOT NULL ,
  `role` INT NOT NULL ,
  `newsletter` VARCHAR(255)  NOT NULL ,
  `iban` VARCHAR(25)  NOT NULL ,
  `bic` VARCHAR(15)  NOT NULL ,
  `picture` VARCHAR(255)  NOT NULL ,
  `died` DATE NOT NULL DEFAULT '0000-00-00',
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;



ALTER TABLE `#__clubmanager_people` ADD `activeplayer` INT NOT NULL;
ALTER TABLE `#__clubmanager_people` ADD `memberstate` INT NOT NULL;

CREATE TABLE IF NOT EXISTS `#__clubmanager_memberstate` 
(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL,
  `default` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `state` TINYINT(1)  NOT NULL ,
  `comment` VARCHAR(255)  NOT NULL ,
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` INT(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) 
ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__clubmanager_memberstate` (`name`, `default`, `ordering`, `state` )
                                  VALUES ('JOS_CLUBMANAGER_MEMBERSTATE_ACTIVE', 1, 1, 1 );

INSERT INTO `#__clubmanager_memberstate` (`name`, `default`, `ordering`, `state` )
                                  VALUES ('JOS_CLUBMANAGER_MEMBERSTATE_INACTIVE', 0, 2, 1 );
                              
INSERT INTO `#__clubmanager_memberstate` (`name`, `default`, `ordering`, `state` )
                                  VALUES ('JOS_CLUBMANAGER_MEMBERSTATE_CAVED', 0, 3, 1 );
                                  
INSERT INTO `#__clubmanager_memberstate` (`name`, `default`, `ordering`, `state` )
                                  VALUES ('JOS_CLUBMANAGER_MEMBERSTATE_DIED', 0, 4, 1 );
                                  
INSERT INTO `#__clubmanager_memberstate` (`name`, `default`, `ordering`, `state` )
                                  VALUES ('JOS_CLUBMANAGER_MEMBERSTATE_NOMEMBER', 0, 5, 1 );                                                                                                   