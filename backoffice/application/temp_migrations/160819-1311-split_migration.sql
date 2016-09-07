ALTER TABLE `swisscoi_veto`.`55_order_history` ADD `assigned_split` SMALLINT NULL DEFAULT '0';

UPDATE  `swisscoi_veto`.`55_package` SET  `mining_status` =  'YES' WHERE  `55_package`.`product_id` =12;

UPDATE  `swisscoi_veto`.`55_package` SET  `mining_status` =  'YES' WHERE  `55_package`.`product_id` =11;

CREATE TABLE IF NOT EXISTS `55_mining_request` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `req_user_id` bigint(20) unsigned NOT NULL,
  `req_pack_id` smallint(5) unsigned NOT NULL,
  `token_amount` bigint(20) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('pending','released','deleted') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

ALTER TABLE  `swisscoi_veto`.`55_order_history` ADD  `is_requested` TINYINT NOT NULL DEFAULT  '0';

INSERT INTO  `swisscoi_veto`.`55_infinite_urls` (`id` ,`link` ,`status` ,`target`) VALUES (NULL ,  'mining_tokens/request_list',  'yes',  'none');

INSERT INTO  `swisscoi_veto`.`55_infinite_mlm_sub_menu` (`sub_id` ,`sub_link_ref_id` ,`icon` ,`sub_status` ,`sub_refid` ,`perm_admin` ,`perm_dist` ,`perm_emp` ,`sub_order_id`)
VALUES ( '101',  '175',  'clip-file',  'yes',  '9',  '1',  '0',  '0',  '5' );

INSERT INTO  `swisscoi_veto`.`55_infinite_urls` (`id` ,`link` ,`status` ,`target`)
VALUES (NULL ,  'payout/payout_release',  'yes',  'none');

INSERT INTO  `swisscoi_veto`.`55_infinite_mlm_sub_menu` (`sub_id` ,`sub_link_ref_id` ,`icon` ,`sub_status` ,`sub_refid` ,`perm_admin` ,`perm_dist` ,`perm_emp`,`sub_order_id`)
VALUES ( '102',  '176',  'clip-file',  'yes',  '9',  '1',  '0',  '0',  '5' );

UPDATE  `swisscoi_veto`.`55_infinite_mlm_menu` SET  `link_ref_id` =  '#' WHERE  `55_infinite_mlm_menu`.`id` =9;

INSERT INTO  `swisscoi_veto`.`55_translation` (`id` ,`lang` ,`tag` ,`key` ,`text`) VALUES (NULL ,  '1',  'common',  '9_#',  'Release');

INSERT INTO  `swisscoi_veto`.`55_translation` (`id` ,`lang` ,`tag` ,`key` ,`text`) VALUES (NULL ,  '1',  'common',  '9_101_175',  'Mining Tokens');

INSERT INTO  `swisscoi_veto`.`55_translation` (`id` ,`lang` ,`tag` ,`key` ,`text`) VALUES (NULL ,  '1',  'common',  '9_102_176',  'Payout Release');

ALTER TABLE `swisscoi_veto`. `55_configuration` ADD  `ac_split_v` INT NOT NULL DEFAULT  '0';

ALTER TABLE  `swisscoi_veto`.`55_configuration` ADD  `ac_skg_v` INT NOT NULL DEFAULT  '1';

CREATE TABLE IF NOT EXISTS `swisscoi_veto`.`55_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=120807;

INSERT INTO  `swisscoi_veto`.`55_options` (`id` ,`option_name` ,`option_value` ,`created`) VALUES (NULL ,  'split',  '0',  '2016-08-18 12:36:12');

