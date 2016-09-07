CREATE TABLE `55_team_bonuses` (
 `id` bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `user_id_source` int(11) NOT NULL,
 `user_id_recipient` int(11) NOT NULL,
 `order_id` int(11) NOT NULL,
 `bv_amount` double NOT NULL,
 `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `is_qualified` tinyint(1) NULL,
 `bonus_percent` double NULL,
 `added_amount` double NULL,
 `leg_amount_id` int(11) NULL,
 `cron_id` int(11) NULL
) ENGINE=InnoDB CHARSET=utf8;


INSERT INTO `55_team_bonuses` (`user_id_source`, `user_id_recipient`, `order_id`, `bv_amount`, `added_amount`, `cron_id`)
SELECT user_id_source, user_id_recipient, order_id, amount, amount_spent, cron_id
FROM `55_income_bv_history`
WHERE type = 'second_line';

CREATE TABLE `55_direct_bonuses` (
 `id` bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `user_id_source` int(11) NOT NULL,
 `user_id_recipient` int(11) NOT NULL,
 `order_id` int(11) NOT NULL,
 `bv_amount` double NOT NULL,
 `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `added_amount` double NULL,
 `leg_amount_id` int(11) NULL,
 `cron_id` int(11) NULL
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO `55_direct_bonuses` (`user_id_source`, `user_id_recipient`, `order_id`, `bv_amount`, `cron_id`)
SELECT user_id_source, user_id_recipient, order_id, amount, cron_id
FROM `55_income_bv_history`
WHERE type = 'first_line';