CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_venue_booking_slots (
  `pk_i_id` bigint(20) unsigned NOT NULL,
  `fk_i_item_id` int(10) unsigned NOT NULL,
  `s_date` date DEFAULT NULL,
  `s_time_slot` varchar(25) DEFAULT NULL,
  `s_price` smallint(6) DEFAULT NULL,
  `s_court` varchar(25) DEFAULT NULL,
  `s_available` tinyint(1) DEFAULT '1',
  `s_booking_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `s_name` varchar(100) DEFAULT NULL,
  `s_email` varchar(100) DEFAULT NULL,
  `s_phone_mobile` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE /*TABLE_PREFIX*/t_venue_booking_slots
  ADD KEY `fk_i_item_id` (`fk_i_item_id`);


ALTER TABLE /*TABLE_PREFIX*/t_venue_booking_slots
ADD CONSTRAINT os_t_venue_booking_slots_ibfk_1 FOREIGN KEY (`fk_i_item_id`) REFERENCES /*TABLE_PREFIX*/t_item (`pk_i_id`);
