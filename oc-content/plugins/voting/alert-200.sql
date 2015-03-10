alter table /*TABLE_PREFIX*/t_voting_item ADD dt_date DATETIME DEFAULT NULL;
alter table /*TABLE_PREFIX*/t_voting_user ADD dt_date DATETIME DEFAULT NULL;

alter table /*TABLE_PREFIX*/t_voting_item ADD s_review_title VARCHAR(80) DEFAULT NULL;
alter table /*TABLE_PREFIX*/t_voting_user ADD s_review_title VARCHAR(80) DEFAULT NULL;

alter table /*TABLE_PREFIX*/t_voting_item ADD s_review_content VARCHAR(600) DEFAULT NULL;
alter table /*TABLE_PREFIX*/t_voting_user ADD s_review_content VARCHAR(600) DEFAULT NULL;