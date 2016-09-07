INSERT INTO `55_infinite_mlm_menu` (`id`, `link_ref_id`, `icon`, `status`, `perm_admin`, `perm_dist`, `perm_emp`, `main_order_id`) VALUES ('77', '#', 'clip-puzzle', 'yes', '1', '0', '0', '24'), ('78', '#', 'clip-puzzle', 'yes', '1', '0', '0', '24');

INSERT INTO `55_infinite_urls` (`id`, `link`, `status`, `target`) VALUES ('177', 'configuration/video', 'yes', 'none'), ('178', 'configuration/video_list', 'yes', 'none'), ('179', 'configuration/translation', 'yes', 'none'), ('180', 'configuration/translation_list', 'yes', 'none');

INSERT INTO `55_infinite_mlm_sub_menu` (`sub_id`, `sub_link_ref_id`, `icon`, `sub_status`, `sub_refid`, `perm_admin`, `perm_dist`, `perm_emp`, `sub_order_id`) VALUES ('103', '177', 'clip-plus-circle-2', 'yes', '77', '1', '0', '0', '1'), ('104', '178', 'clip-list-2', 'yes', '77', '1', '1', '0', '2'), ('105', '180', 'clip-list-2', 'yes', '78', '1', '1', '0', '2');

INSERT INTO `55_translation` (`id`, `key`, `lang`, `tag`, `text`) VALUES
(NULL, '78_#', 1, 'common', 'Translations'),
(NULL, '78_#', 4, 'common', 'Translations'),
(NULL, '78_105_180', 1, 'common', 'Translation list'),
(NULL, '78_105_180', 4, 'common', 'Translation list'),
(NULL, '77_103_177', 1, 'common', 'Add new Video'),
(NULL, '77_103_177', 4, 'common', 'Add new Video'),
(NULL, '77_104_178', 1, 'common', 'Video list'),
(NULL, '77_104_178', 4, 'common', 'Video list'),
(NULL, 'translation list', 1, 'configuration', 'Translation List'),
(NULL, 'translation list', 4, 'configuration', NULL),
(NULL, 'translation_key', 1, 'configuration', 'Translation Key'),
(NULL, 'translation_key', 4, 'configuration', NULL),
(NULL, 'translation_text', 1, 'configuration', 'Translation Text'),
(NULL, 'translation_text', 4, 'configuration', NULL),
(NULL, 'invalid csv file, please check format', 1, 'configuration', "Uploaded file isn\'t valid CSV, please check file"),
(NULL, 'invalid csv file, please check format', 4, 'configuration', NULL),
(NULL, 'empty file uploaded', 1, 'configuration', 'Empty file uploaded'),
(NULL, 'empty file uploaded', 4, 'configuration', NULL),
(NULL, 'select_csv', 1, 'configuration', 'Select CSV'),
(NULL, 'select_csv', 4, 'configuration', NULL),
(NULL, 'upload translation', 1, 'configuration', 'Select CSV file to import translation'),
(NULL, 'upload translation', 4, 'configuration', NULL),
(NULL, 'download empty', 1, 'configuration', 'Export empty lines'),
(NULL, 'download empty', 4, 'configuration', NULL),
(NULL, 'only csv files supported', 1, 'configuration', 'Only CSV files supported'),
(NULL, 'only csv files supported', 4, 'configuration', NULL),
(NULL, 'csv import partly', 1, 'configuration', 'CSV file imported, some invalid values encountered'),
(NULL, 'csv import partly', 4, 'configuration', NULL),
(NULL, 'csv import ok', 1, 'configuration', 'CSV file imported successfully'),
(NULL, 'csv import ok', 4, 'configuration', NULL),
(NULL, 'old files import ok', 1, 'configuration', 'Import lines from old files successfully'),
(NULL, 'old files import ok', 4, 'configuration', NULL);