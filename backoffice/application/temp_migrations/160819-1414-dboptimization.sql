ALTER TABLE `55_payout_release_requests` ADD INDEX (`requested_user_id`);

ALTER TABLE `55_user_balance_amount` ADD UNIQUE (`user_id`);

ALTER TABLE `55_leg_amount` ADD INDEX (`amount_type`);

ALTER TABLE `55_amount_type` ADD INDEX (`db_amt_type`);

ALTER TABLE `55_ewallet_payment_details` CHANGE `used_amount` `used_amount` FLOAT NOT NULL;