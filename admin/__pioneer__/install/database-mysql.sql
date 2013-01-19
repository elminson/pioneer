
SET FOREIGN_KEY_CHECKS=0;

#
# Structure for the `sys_blobs` table : 
#

DROP TABLE IF EXISTS `sys_blobs`;

CREATE TABLE `sys_blobs` (
  `blobs_id` bigint(20) NOT NULL auto_increment,
  `blobs_alt` varchar(255) collate utf8_unicode_ci default NULL,
  `blobs_category` varchar(255) collate utf8_unicode_ci default NULL,
  `blobs_filename` varchar(255) collate utf8_unicode_ci default NULL,
  `blobs_type` varchar(10) collate utf8_unicode_ci default NULL,
  `blobs_parent` bigint(11) NOT NULL default '-1',
  `blobs_isfolder` tinyint(1) NOT NULL default '0',
  `blobs_bsize` bigint(20) default '0',
  `blobs_securitycache` longtext collate utf8_unicode_ci,
  `blobs_width` bigint(20) default NULL,
  `blobs_height` bigint(20) default NULL,
  `blobs_modified` datetime default NULL,
  `blobs_lastaccessed` datetime default NULL,
  PRIMARY KEY  (`blobs_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_blobs_cache` table : 
#

DROP TABLE IF EXISTS `sys_blobs_cache`;

CREATE TABLE `sys_blobs_cache` (
  `blobs_cache_id` bigint(20) NOT NULL auto_increment,
  `blobs_cache_blobs_id` bigint(20) NOT NULL default '0',
  `blobs_cache_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `blobs_cache_width` int(11) NOT NULL default '0',
  `blobs_cache_height` int(11) NOT NULL default '0',
  `blobs_cache_data` longblob,
  PRIMARY KEY  (`blobs_cache_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_blobs_categories` table : 
#

DROP TABLE IF EXISTS `sys_blobs_categories`;

CREATE TABLE `sys_blobs_categories` (
  `category_id` bigint(20) NOT NULL auto_increment,
  `category_parent` bigint(20) NOT NULL default '-1',
  `category_description` varchar(255) collate utf8_unicode_ci default 'New Category',
  `category_securitycache` longtext collate utf8_unicode_ci,
  PRIMARY KEY  (`category_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_blobs_data` table : 
#

DROP TABLE IF EXISTS `sys_blobs_data`;

CREATE TABLE `sys_blobs_data` (
  `blobs_id` bigint(20) NOT NULL default '0',
  `blobs_data` longblob,
  UNIQUE KEY `blobs_id` (`blobs_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_index` table : 
#

DROP TABLE IF EXISTS `sys_index`;

CREATE TABLE `sys_index` (
  `index_folder` bigint(20) NOT NULL default '0',
  `index_publication` bigint(20) NOT NULL default '0',
  `index_word` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `index_language` varchar(2) collate utf8_unicode_ci NOT NULL default '',
  `index_site` bigint(20) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_index_words` table : 
#

DROP TABLE IF EXISTS `sys_index_words`;

CREATE TABLE `sys_index_words` (
  `index_word_id` bigint(20) NOT NULL auto_increment,
  `index_word` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`index_word_id`),
  UNIQUE KEY `index_word` (`index_word`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_languages` table : 
#

DROP TABLE IF EXISTS `sys_languages`;

CREATE TABLE `sys_languages` (
  `language_id` varchar(2) collate utf8_unicode_ci NOT NULL default '',
  `language_view` varchar(100) collate utf8_unicode_ci NOT NULL default '<some title>',
  PRIMARY KEY  (`language_id`),
  UNIQUE KEY `language_id` (`language_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_links` table : 
#

DROP TABLE IF EXISTS `sys_links`;

CREATE TABLE `sys_links` (
  `link_id` bigint(20) NOT NULL auto_increment,
  `link_parent_storage_id` bigint(20) NOT NULL default '0',
  `link_parent_id` bigint(20) NOT NULL default '0',
  `link_child_storage_id` bigint(20) NOT NULL default '0',
  `link_child_id` bigint(20) NOT NULL default '0',
  `link_creationdate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `link_order` bigint(20) NOT NULL default '0',
  `link_template` varchar(255) collate utf8_unicode_ci NOT NULL default '''''',
  `link_object_type` bigint(20) NOT NULL default '0',
  `link_propertiesvalues` longtext collate utf8_unicode_ci,
  `link_modifieddate` datetime NOT NULL,
  PRIMARY KEY  (`link_id`),
  KEY `link_parent_storage_id` (`link_parent_storage_id`,`link_parent_id`,`link_child_storage_id`,`link_child_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_module_templates` table : 
#

DROP TABLE IF EXISTS `sys_module_templates`;

CREATE TABLE `sys_module_templates` (
  `module_templates_id` bigint(20) NOT NULL auto_increment,
  `module_templates_name` varchar(20) collate utf8_unicode_ci NOT NULL default 'new template',
  `module_templates_module_id` bigint(20) NOT NULL default '0',
  `module_templates_list` longtext collate utf8_unicode_ci,
  `module_templates_properties` longtext collate utf8_unicode_ci,
  `module_templates_composite` tinyint(1) NOT NULL default '0',
  `module_templates_styles` longtext collate utf8_unicode_ci,
  `module_templates_description` varchar(255) collate utf8_unicode_ci default NULL,
  `module_templates_cache` tinyint(1) NOT NULL default '0',
  `module_templates_cachecheck` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`module_templates_id`),
  UNIQUE KEY `pindex` (`module_templates_name`,`module_templates_module_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_modules` table : 
#

DROP TABLE IF EXISTS `sys_modules`;

CREATE TABLE `sys_modules` (
  `module_id` bigint(20) NOT NULL auto_increment,
  `module_order` bigint(20) NOT NULL default '1',
  `module_state` int(11) unsigned NOT NULL default '0',
  `module_entry` varchar(255) collate utf8_unicode_ci NOT NULL,
  `module_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `module_description` text collate utf8_unicode_ci,
  `module_version` varchar(20) collate utf8_unicode_ci NOT NULL default '1.0',
  `module_admincompat` text collate utf8_unicode_ci NOT NULL,
  `module_compat` text collate utf8_unicode_ci NOT NULL,
  `module_code` longtext collate utf8_unicode_ci,
  `module_storages` text collate utf8_unicode_ci,
  `module_libraries` text collate utf8_unicode_ci,
  `module_type` int(11) NOT NULL default '0',
  `module_haseditor` tinyint(1) NOT NULL default '0',
  `module_publicated` tinyint(1) NOT NULL default '0',
  `module_iconpack` varchar(255) collate utf8_unicode_ci default NULL,
  `module_favorite` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`module_id`),
  UNIQUE KEY `pindex` (`module_entry`,`module_version`),
  KEY `module_entry` (`module_entry`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_notices` table : 
#

DROP TABLE IF EXISTS `sys_notices`;

CREATE TABLE `sys_notices` (
  `notice_id` bigint(20) NOT NULL auto_increment,
  `notice_keyword` varchar(255) collate utf8_unicode_ci NOT NULL default 'NEW_NOTICE',
  `notice_subject` tinytext collate utf8_unicode_ci NOT NULL,
  `notice_encoding` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `notice_body` longtext collate utf8_unicode_ci NOT NULL,
  `notice_securitycache` longtext collate utf8_unicode_ci,
  PRIMARY KEY  (`notice_id`),
  UNIQUE KEY `notice_keyword` (`notice_keyword`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_repository` table : 
#

DROP TABLE IF EXISTS `sys_repository`;

CREATE TABLE `sys_repository` (
  `repository_id` bigint(20) NOT NULL auto_increment,
  `repository_name` varchar(255) default NULL,
  `repository_type` varchar(20) NOT NULL default 'PHP_CODE',
  `repository_code` longtext,
  `repository_datemodified` datetime default NULL,
  PRIMARY KEY  (`repository_id`),
  UNIQUE KEY `repository_name` (`repository_name`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#
# Structure for the `sys_resources` table : 
#

DROP TABLE IF EXISTS `sys_resources`;

CREATE TABLE `sys_resources` (
  `resource_id` bigint(20) NOT NULL auto_increment,
  `resource_name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `resource_language` varchar(2) collate utf8_unicode_ci NOT NULL default 'en',
  `resource_value` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`resource_id`),
  UNIQUE KEY `resource_name` (`resource_name`,`resource_language`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_settings` table : 
#

DROP TABLE IF EXISTS `sys_settings`;

CREATE TABLE `sys_settings` (
  `setting_id` int(11) NOT NULL auto_increment,
  `setting_name` varchar(100) collate utf8_unicode_ci default 'SETTING_',
  `setting_value` text collate utf8_unicode_ci,
  `setting_type` varchar(100) collate utf8_unicode_ci NOT NULL default 'memo',
  `setting_securitycache` longtext collate utf8_unicode_ci,
  `setting_issystem` tinyint(1) default '0',
  `setting_category` varchar(100) collate utf8_unicode_ci default 'User settings',
  PRIMARY KEY  (`setting_id`)
) AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_statistics` table : 
#

DROP TABLE IF EXISTS `sys_statistics`;

CREATE TABLE `sys_statistics` (
  `stats_date` bigint(20) NOT NULL default '0',
  `stats_site` bigint(20) NOT NULL,
  `stats_folder` bigint(20) NOT NULL default '0',
  `stats_publication` bigint(20) NOT NULL default '0',
  `stats_country_code` varchar(2) collate utf8_unicode_ci NOT NULL default '',
  `stats_country_code3` varchar(3) collate utf8_unicode_ci default NULL,
  `stats_country_name` varchar(100) collate utf8_unicode_ci default NULL,
  `stats_region` varchar(20) collate utf8_unicode_ci default NULL,
  `stats_city` varchar(100) collate utf8_unicode_ci default NULL,
  `stats_remoteaddress` bigint(20) NOT NULL default '0',
  `stats_localaddress` bigint(20) default NULL,
  `stats_session` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `stats_browser` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `stats_os` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `stats_referer_domain` varchar(100) collate utf8_unicode_ci default NULL,
  `stats_referer_query` tinytext collate utf8_unicode_ci NOT NULL,
  `stats_querystring` tinytext collate utf8_unicode_ci NOT NULL,
  `stats_cookie` tinytext collate utf8_unicode_ci NOT NULL,
  `stats_browser_type` varchar(10) collate utf8_unicode_ci default NULL,
  `stats_browser_version` varchar(50) collate utf8_unicode_ci default NULL,
  `stats_os_version` varchar(50) collate utf8_unicode_ci default NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_statsarchive` table : 
#

DROP TABLE IF EXISTS `sys_statsarchive`;

CREATE TABLE `sys_statsarchive` (
  `stats_date` bigint(20) NOT NULL default '0',
  `stats_archive` longtext collate utf8_unicode_ci NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_storage_fields` table : 
#

DROP TABLE IF EXISTS `sys_storage_fields`;

CREATE TABLE `sys_storage_fields` (
  `storage_field_id` bigint(20) NOT NULL auto_increment,
  `storage_field_storage_id` int(11) NOT NULL default '0',
  `storage_field_name` varchar(200) collate utf8_unicode_ci NOT NULL default '',
  `storage_field_field` varchar(200) collate utf8_unicode_ci NOT NULL default '',
  `storage_field_type` varchar(100) collate utf8_unicode_ci NOT NULL default 'text',
  `storage_field_default` varchar(255) collate utf8_unicode_ci default NULL,
  `storage_field_required` int(1) NOT NULL default '0',
  `storage_field_showintemplate` tinyint(1) NOT NULL default '1',
  `storage_field_lookup` tinytext collate utf8_unicode_ci,
  `storage_field_onetomany` varchar(255) collate utf8_unicode_ci default '',
  `storage_field_order` bigint(20) NOT NULL default '0',
  `storage_field_values` longtext collate utf8_unicode_ci,
  `storage_field_group` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`storage_field_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_storage_templates` table : 
#

DROP TABLE IF EXISTS `sys_storage_templates`;

CREATE TABLE `sys_storage_templates` (
  `storage_templates_id` bigint(20) NOT NULL auto_increment,
  `storage_templates_name` varchar(255) collate utf8_unicode_ci default 'new template',
  `storage_templates_storage_id` bigint(20) NOT NULL default '0',
  `storage_templates_list` longtext collate utf8_unicode_ci,
  `storage_templates_properties` longtext collate utf8_unicode_ci,
  `storage_templates_composite` tinyint(1) NOT NULL default '0',
  `storage_templates_styles` longtext collate utf8_unicode_ci,
  `storage_templates_description` varchar(255) collate utf8_unicode_ci default NULL,
  `storage_templates_cache` tinyint(1) NOT NULL default '0',
  `storage_templates_cachecheck` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`storage_templates_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_storages` table : 
#

DROP TABLE IF EXISTS `sys_storages`;

CREATE TABLE `sys_storages` (
  `storage_id` int(11) NOT NULL auto_increment,
  `storage_name` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `storage_table` varchar(200) collate utf8_unicode_ci NOT NULL default '',
  `storage_securitycache` longtext collate utf8_unicode_ci,
  `storage_color` varchar(20) collate utf8_unicode_ci default NULL,
  `storage_group` varchar(255) collate utf8_unicode_ci default NULL,
  `storage_parent` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`storage_id`),
  UNIQUE KEY `storage_name` (`storage_table`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_templates` table : 
#

DROP TABLE IF EXISTS `sys_templates`;

CREATE TABLE `sys_templates` (
  `templates_id` bigint(20) NOT NULL auto_increment,
  `templates_name` varchar(255) collate utf8_unicode_ci NOT NULL default 'newtemplate',
  `templates_head` longtext collate utf8_unicode_ci,
  `templates_body` longtext collate utf8_unicode_ci,
  `templates_head_title` tinytext collate utf8_unicode_ci,
  `templates_head_metakeywords` tinytext collate utf8_unicode_ci,
  `templates_head_metadescription` tinytext collate utf8_unicode_ci,
  `templates_head_shortcuticon` varchar(255) collate utf8_unicode_ci default NULL,
  `templates_head_baseurl` varchar(255) collate utf8_unicode_ci default NULL,
  `templates_head_styles` text collate utf8_unicode_ci,
  `templates_head_scripts` text collate utf8_unicode_ci,
  `templates_head_aditionaltags` text collate utf8_unicode_ci,
  `templates_html_doctype` tinytext collate utf8_unicode_ci,
  `templates_repositories` tinytext collate utf8_unicode_ci,
  PRIMARY KEY  (`templates_id`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_tree` table : 
#

DROP TABLE IF EXISTS `sys_tree`;

CREATE TABLE `sys_tree` (
  `tree_id` bigint(20) NOT NULL auto_increment,
  `tree_left_key` bigint(20) NOT NULL default '0',
  `tree_right_key` bigint(20) NOT NULL default '0',
  `tree_level` bigint(20) NOT NULL default '0',
  `tree_sid` float(100,3) NOT NULL default '0.000',
  `tree_published` tinyint(1) NOT NULL default '0',
  `tree_name` varchar(255) collate utf8_unicode_ci NOT NULL default 'new tree item',
  `tree_keyword` varchar(50) collate utf8_unicode_ci NOT NULL default 'newitem',
  `tree_template` int(11) NOT NULL default '0',
  `tree_notes` text collate utf8_unicode_ci NOT NULL,
  `tree_datecreated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `tree_datemodified` timestamp NOT NULL default '0000-00-00 00:00:00',
  `tree_description` varchar(255) collate utf8_unicode_ci default NULL,
  `tree_language` varchar(2) collate utf8_unicode_ci NOT NULL default '',
  `tree_domain` varchar(255) collate utf8_unicode_ci default NULL,
  `tree_header_description` longtext collate utf8_unicode_ci,
  `tree_header_keywords` longtext collate utf8_unicode_ci,
  `tree_header_shortcuticon` tinytext collate utf8_unicode_ci,
  `tree_header_basehref` varchar(255) collate utf8_unicode_ci default NULL,
  `tree_header_inlinestyles` longtext collate utf8_unicode_ci,
  `tree_header_inlinescripts` longtext collate utf8_unicode_ci,
  `tree_header_aditionaltags` longtext collate utf8_unicode_ci,
  `tree_header_statictitle` tinytext collate utf8_unicode_ci,
  `tree_properties` longtext collate utf8_unicode_ci,
  `tree_propertiesvalues` longtext collate utf8_unicode_ci,
  `tree_securitycache` longtext collate utf8_unicode_ci,
  PRIMARY KEY  (`tree_id`),
  UNIQUE KEY `tree_name` (`tree_name`),
  KEY `tree_left_key` (`tree_left_key`,`tree_right_key`,`tree_level`)
) AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_umgroups` table : 
#

DROP TABLE IF EXISTS `sys_umgroups`;

CREATE TABLE `sys_umgroups` (
  `groups_name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `groups_description` tinytext collate utf8_unicode_ci,
  PRIMARY KEY  (`groups_name`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_umusers` table : 
#

DROP TABLE IF EXISTS `sys_umusers`;

CREATE TABLE `sys_umusers` (
  `users_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `users_created` bigint(20) default NULL,
  `users_modified` bigint(20) default NULL,
  `users_password` longtext character set utf8 collate utf8_unicode_ci NOT NULL,
  `users_lastlogindate` bigint(20) default NULL,
  `users_lastloginfrom` varchar(15) character set utf8 collate utf8_unicode_ci default NULL,
  `users_roles` longtext character set latin1,
  `users_profile` longtext character set latin1,
  PRIMARY KEY  (`users_name`)
) DEFAULT CHARSET=utf8;

#
# Structure for the `sys_umusersgroups` table : 
#

DROP TABLE IF EXISTS `sys_umusersgroups`;

CREATE TABLE `sys_umusersgroups` (
  `user` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `group` varchar(255) collate utf8_unicode_ci NOT NULL default ''
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_uscache` table : 
#

DROP TABLE IF EXISTS `sys_uscache`;

CREATE TABLE `sys_uscache` (
  `uscache_key` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `uscache_created` bigint(20) NOT NULL default '0',
  `uscache_modified` bigint(20) NOT NULL default '0',
  `uscache_cache` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`uscache_key`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `sys_usgroup` table : 
#

DROP TABLE IF EXISTS `sys_usgroup`;

CREATE TABLE `sys_usgroup` (
  `usgroup_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `usgroup_description` varchar(20) default NULL,
  `usgroup_defaultrole` varchar(255) NOT NULL default '',
  `usgroup_users` longtext,
  PRIMARY KEY  (`usgroup_name`)
) DEFAULT CHARSET=latin1;

#
# Data for the `sys_languages` table  (LIMIT 0,500)
#

INSERT INTO `sys_languages` (`language_id`, `language_view`) VALUES 
  ('en','English'),
  ('ru','Russian');

#
# Data for the `sys_settings` table  (LIMIT 0,500)
#

INSERT INTO `sys_settings` (`setting_id`, `setting_name`, `setting_value`, `setting_type`, `setting_securitycache`, `setting_issystem`, `setting_category`) VALUES 
  (1,'SETTING_COMPANY_TITLE','Logo-S-Trade','memo',NULL,0,'User settings'),
  (2,'SETTING_COMPENY_EMAIL','office@logo-s-trade.ru','memo',NULL,0,'User settings'),
  (3,'BLOB_CACHE_FOLDER','/images/blob_cache','memo',NULL,0,'User settings'),
  (7,'MAIL_SMTP','island.grc.ru','memo',NULL,0,'User settings'),
  (8,'DEVELOPER_EMAIL','mk@e-time.ru','memo',NULL,0,'User settings'),
  (9,'COMPANY_PHONE','6427923','memo',NULL,0,'User settings'),
  (10,'COPYRIGHT','Copyright © 2006, ООО «ЛогоЭсТрейд»<br />\r\nВсе права защищены и охраняются законом\r\n<br /><br />\r\nE-mail: <a href=\"mailto: office@logo-s-trade.ru\">office@logo-s-trade.ru</a>','memo',NULL,0,'User settings'),
  (11,'META_AUTHOR','Logo-S-Trade','memo',NULL,0,'User settings'),
  (12,'META_COPYRIGHT','Logo-S-Trade','memo',NULL,0,'User settings'),
  (13,'SETTING_PAGESIZE','10','memo',NULL,0,'User settings'),
  (14,'USE_MOD_REWRITE','default','memo',NULL,0,'User settings'),
  (15,'PAGE_SIZE','15','memo',NULL,0,'User settings'),
  (16,'PAGER_SIZE','15','memo',NULL,0,'User settings'),
  (17,'SYSTEM_RESTORE_CRON_MAX','5','memo',NULL,0,'User settings'),
  (18,'MUI_SELECTEDLANGUAGE','en','text','O:9:\"Hashtable\":2:{s:8:\"',0,'MUI Settings'),
  (19,'IO_PATH','/_system/\r\ntemplates/\r\ndesignes/\r\nrepository/\r\nmodules/\r\ndata/','memo','O:9:\"Hashtable\":2:{s:8:\"\0*\0_data\";O:8:\"stdClass\":0:{}s:8:\"\0*\0_keys\";a:0:{}}',0,'User settings');

#
# Data for the `sys_templates` table  (LIMIT 0,500)
#

INSERT INTO `sys_templates` (`templates_id`, `templates_name`, `templates_head`, `templates_body`, `templates_head_title`, `templates_head_metakeywords`, `templates_head_metadescription`, `templates_head_shortcuticon`, `templates_head_baseurl`, `templates_head_styles`, `templates_head_scripts`, `templates_head_aditionaltags`, `templates_html_doctype`, `templates_repositories`) VALUES 
  (1,'default','<?= Meta($args, $template); ?>\r\n<?= Scripts($args); ?>','﻿<?\r\n\t\r\n\t//$datarow = new DataRow(Storages::get(\"test\"), 1);\r\n\r\n\r\n\t$page = new Page($args);\r\n\tRedefine($page);\r\n?>\r\n\t<div id=\"root\">\r\n\t<ul class=\"centered width main\">\r\n\t\t<li id=\"header\">\r\n\t\t<?= RenderHeader($page); ?>\r\n\t\t</li>\r\n\t\t<li id=\"content\">\r\n\t\t<?= RenderContent($page); ?>\r\n\t\t</li>\r\n\t\t<li id=\"footer\">\r\n\t\t<?= RenderFooter($page); ?>\r\n\t\t\r\n\t\t</li>\r\n\t</ul>\r\n\t</div>','Logo-S-Trade','','','','','','','<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<link href=\"/styles/styles.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n<link href=\"/styles/layout.css\" rel=\"stylesheet\" type=\"text/css\" />','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">','Page, Lib, Main, Pager, Scripts, Header, Content, Footer');

#
# Data for the `sys_tree` table  (LIMIT 0,500)
#

INSERT INTO `sys_tree` (`tree_id`, `tree_left_key`, `tree_right_key`, `tree_level`, `tree_sid`, `tree_published`, `tree_name`, `tree_keyword`, `tree_template`, `tree_notes`, `tree_datecreated`, `tree_datemodified`, `tree_description`, `tree_language`, `tree_domain`, `tree_header_description`, `tree_header_keywords`, `tree_header_shortcuticon`, `tree_header_basehref`, `tree_header_inlinestyles`, `tree_header_inlinescripts`, `tree_header_aditionaltags`, `tree_header_statictitle`, `tree_properties`, `tree_propertiesvalues`, `tree_securitycache`) VALUES 
  (1,1,190,0,437359149056,1,'root','root',2,'','2006-10-30 17:09:55','2006-10-30 17:09:55','root','ru','root','','','','','','','','root',NULL,NULL,NULL),
  (2,7,189,1,486470189056,1,'lgs','lgs',1,'','2006-10-30 17:09:55','2006-10-30 17:09:55','Logo-S-Trade','ru','','','','','','','','','Logo-S-Trade',NULL,NULL,NULL);
#
# Data for the `sys_umgroups` table  (LIMIT 0,500)
#

INSERT INTO `sys_umgroups` (`groups_name`, `groups_description`) VALUES 
  ('Administrators','System administrators');

#
# Data for the `sys_umusers` table  (LIMIT 0,500)
#

INSERT INTO `sys_umusers` (`users_name`, `users_created`, `users_modified`, `users_password`, `users_lastlogindate`, `users_lastloginfrom`, `users_roles`, `users_profile`) VALUES 
  ('admin',NULL,NULL,'4b6dP/8=',1212399465,'10.0.0.2','system_administrator','O:8:\"stdClass\":1:{s:5:\"admin\";O:8:\"Profiler\":4:{s:4:\"user\";O:4:\"User\":2:{s:11:\"\0User\0_data\";O:8:\"stdClass\":11:{s:10:\"users_name\";s:5:\"admin\";s:13:\"users_created\";N;s:14:\"users_modified\";N;s:14:\"users_password\";s:5:\"admin\";s:19:\"users_lastlogindate\";s:10:\"1172131044\";s:19:\"users_lastloginfrom\";s:8:\"10.0.0.2\";s:11:\"users_roles\";O:9:\"ArrayList\":3:{s:12:\"\0*\0m_Storage\";a:1:{i:0;s:20:\"system_administrator\";}s:11:\"\0*\0_keyPair\";b:0;s:10:\"\0*\0_locked\";b:0;}s:13:\"users_profile\";O:9:\"Hashtable\":2:{s:8:\"\0*\0_data\";r:1;s:8:\"\0*\0_keys\";a:1:{i:0;s:5:\"admin\";}}s:12:\"users_groups\";O:9:\"GroupList\":4:{s:4:\"user\";r:3;s:12:\"\0*\0m_Storage\";a:1:{i:0;s:14:\"Administrators\";}s:11:\"\0*\0_keyPair\";b:0;s:10:\"\0*\0_locked\";b:0;}s:19:\"users_LastLoginDate\";i:1212399465;s:19:\"users_LastLoginFrom\";s:8:\"10.0.0.2\";}s:16:\"\0User\0_callbacks\";O:9:\"Hashtable\":2:{s:8:\"\0*\0_data\";O:8:\"stdClass\":0:{}s:8:\"\0*\0_keys\";a:0:{}}}s:12:\"\0*\0m_Storage\";a:0:{}s:11:\"\0*\0_keyPair\";b:1;s:10:\"\0*\0_locked\";b:0;}}');

#
# Data for the `sys_umusersgroups` table  (LIMIT 0,500)
#

INSERT INTO `sys_umusersgroups` (`user`, `group`) VALUES 
  ('admin','Administrators');

#
# Data for the `sys_uscache` table  (LIMIT 0,500)
#

INSERT INTO `sys_uscache` (`uscache_key`, `uscache_created`, `uscache_modified`, `uscache_cache`) VALUES 
  ('supervisor',1161793129,1161793129,'avUcpU3EBwMXXCZsCCJPd/rFkDQTXRk+o/JWNHG7wbtT6apbe5WLUCURgU66OeDt5sGr78Ou1qXdrNdABsu4ItJf2iS0XMSFvP3klpwClIbZzToriz42qNA5PE4k+K9pTKxdeGYlckzpkVZMgVFkR7nPfFZq1/pm7hZf0C7yMWidp8fE+kD/K3A79R/0JGtO7VWT2gLtygE3rDfVkSELfpJvzf9RLuCc3Gv74mPfUQPRTMhbjjTzlzudPrYf8hWwKuPxlKTeRUoe/LVHLb8JbVYekWmYEQRQ2gZ4RlWeVYaKK0Ubu5yahxs86KEuX765Q6XSG0OyrH8I184daN1rJIrwoTJ9oyTKWWJ73YWnh8XAj436beC6PYFXtkRkcGyCV0EWL6iABVayD/a9AP2AES/36fp/ZfpocWSr10FsCC+wXStPGrKCFncLjN/eGEEswKLwyOJl7KjC4dIjCBzedcNtm47QJpgy4fsUOWcEc8M/Ixox5VmMgWvUilkId7wNSrPbDz4TPLQs4luQWfiU7TGM3hPjvVz2ZxX5L24YcUA4+wBz62Ez8exQ8uyHk+VtcjsPnafLEbUzyh29KQ8TaWTLfdsNVloiywUmGIz0S6OhESyPSDXp+CvVMt4dgyVzUVsAYw=='),
  ('administrator',1161793129,1161793129,'pP9LKSpVObaCJhO/V+ZdZ1uSIpCd9J7cs+Rg8kFaI+WB+8F//5i80W3AIkK96zyVq/viAdbqE4r4VkP/8oFhiF0RWocxH4IsxcVkwOZgKg8Zek0LdiQ9dOv1j85aQSK/D4+x2YmIP+El+H2/bkcbaoF2S2O1pY2yQw4AjndDsj2TMPS8EHgBu/pFISJjNjQ4TjpEYJjxJ4YdSHt8LYfxa/ILkBeT2E7teMHiU7M7/AB2d2A33HH0/oLd+GoqdxB1TiCg/7pa1dnOIo07daH86nIIpmlUGo7jV61tDhIT0KBFZN4UHkDJrsjuKMC09Av+9LNEsHopdoG+5iU4ZzSkBhY8Lnq2x0GtXH4H2Ckvb2Kapi/4niQJXuwnJ8HMcZvc/pbiWynPJlEU16KEhVcJrZ4ijpTqZIzfU6piLAvUMy3b3XQ7kHcVbYMgir/f6OZSbbYkWf29yeLxAFZlCt2DjD2hkP0NaoOrSaOPHAqMZ0QhY0/05Fev972/exu06gJGfOyr0IGRU0EUwWJMSSxRzl8ekj3eYv9GgDoep7jhBdAZOn8g9hYUbaTFMAvZ+WVHF8VfJ3AZ44hFSyDUkk+AMKk+XaCSHcv7Bv3G7ZVmtE/U3EF2aKZiPXc=');

#
# Data for the `sys_usgroup` table  (LIMIT 0,500)
#

INSERT INTO `sys_usgroup` (`usgroup_name`, `usgroup_description`, `usgroup_defaultrole`, `usgroup_users`) VALUES 
  ('Administrators','System administrator','system_administrator','O:8:\"UserList\":3:{s:15:\"');

