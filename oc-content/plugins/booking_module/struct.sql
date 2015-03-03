CREATE TABLE /*TABLE_PREFIX*/t_venue_booking_slots (
	pk_i_id BIGINT UNSIGNED NOT NULL,
    fk_i_item_id INT UNSIGNED NOT NULL,
    s_date DATE,
    s_time_slot VARCHAR(25),
	s_price SMALLINT,
	s_quantity TINYINT,
	s_available BOOLEAN DEFAULT 1,

        PRIMARY KEY (pk_i_id,fk_i_item_id),
        FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';


CREATE TABLE /*TABLE_PREFIX*/t_venue_booking_details (
    fk_i_booking_slot_id INT UNSIGNED NOT NULL,
	fk_i_user_id INT UNSIGNED,
	s_booking_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    s_name VARCHAR(100),
	s_email VARCHAR(100),
	s_phone_mobile VARCHAR(45),

        PRIMARY KEY (fk_i_booking_slot_id),
        FOREIGN KEY (fk_i_booking_slot_id) REFERENCES /*TABLE_PREFIX*/t_venue_booking_slots (pk_i_id)
		FOREIGN KEY (fk_i_user_id) REFERENCES /*TABLE_PREFIX*/t_user (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';