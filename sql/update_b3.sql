ALTER TABLE  `chatlog` CHANGE  `msg_type`  `msg_type` ENUM(  'ALL',  'TEAM',  'PM',  'TALKBACK' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
