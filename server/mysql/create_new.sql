CREATE TABLE Medicine(
  med_id INTEGER NOT NULL AUTO_INCREMENT,
  med_name VARCHAR(196),
  general_name VARCHAR(512),
  med_manufacturer VARCHAR(121),
  med_purpose VARCHAR(23000),
  med_dosage VARCHAR(50),
  med_admin VARCHAR(100),
  med_reactions MEDIUMTEXT,
  med_warnings VARCHAR(35000),
  med_rxcui VARCHAR(500),
  med_ndc VARCHAR(500),
  med_img VARCHAR(200),
  PRIMARY KEY (med_id, med_name, general_name, med_manufacturer)
);

CREATE TABLE SideEffects(
  effect_id INTEGER NOT NULL AUTO_INCREMENT,
  effect VARCHAR(150),
  PRIMARY KEY (effect_id)
);

CREATE TABLE MedSideEffects(
  med_id INTEGER NOT NULL,
  effect_id INTEGER NOT NULL,
  FOREIGN KEY (med_id) REFERENCES Medicine(med_id),
  FOREIGN KEY (effect_id) REFERENCES SideEffects(effect_id)
);

CREATE TABLE AdminAccount(
  adminAcc_id INTEGER NOT NULL AUTO_INCREMENT,
  adminName VARCHAR(50),
  adminPass VARCHAR(256),
  PRIMARY KEY (adminAcc_id),
  UNIQUE (adminName)
);

CREATE TABLE UserAccount(
  userAcc_id INTEGER NOT NULL AUTO_INCREMENT,
  userName VARCHAR(50),
  userPass CHAR(128),
  isDoctor INTEGER,
  longitude DOUBLE,
  latitude DOUBLE,
  userAdmin INTEGER NOT NULL,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userAcc_id),
  FOREIGN KEY (userAdmin) REFERENCES AdminAccount(adminAcc_id),
  UNIQUE (userName)
);

CREATE TABLE Friends(
  sender INTEGER NOT NULL,
  receiver INTEGER NOT NULL,
  accepted INTEGER,
  PRIMARY KEY (sender, receiver),
  FOREIGN KEY (sender) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (receiver) REFERENCES UserAccount(userAcc_id)
);

CREATE TABLE UserMeds(
  userAcc_id INTEGER NOT NULL,
  med_id INTEGER NOT NULL,
  notif_set INTEGER NOT NULL,
  PRIMARY KEY(userAcc_id, med_id),
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (med_id) REFERENCES Medicine(med_id)
);

CREATE TABLE UserMedNotif(
  notif_id INTEGER NOT NULL AUTO_INCREMENT,
  userAcc_id INTEGER NOT NULL,
  med_id INTEGER NOT NULL,
  userMed_amount INTEGER,
  notif_time1 TIME,
  notif_time2 TIME,
  notif_time3 TIME,
  notif_time4 TIME,
  notif_time5 TIME,
  day_flag CHAR(7),
  PRIMARY KEY (notif_id),
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (med_id) REFERENCES Medicine(med_id)
);

CREATE TABLE GroupMedNotif(
  notif_id INTEGER NOT NULL AUTO_INCREMENT,
  userAcc_id INTEGER NOT NULL,
  med_id INTEGER NOT NULL,
  userMed_amount INTEGER,
  notif_time1 TIME,
  notif_time2 TIME,
  notif_time3 TIME,
  notif_time4 TIME,
  notif_time5 TIME,
  day_flag CHAR(7),
  notif_enabled INTEGER,
  PRIMARY KEY (notif_id),
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (med_id) REFERENCES Medicine(med_id)
);

CREATE TABLE UserReview(
  userReview_id INTEGER NOT NULL AUTO_INCREMENT,
  userAcc_id INTEGER NOT NULL,
  med_id INTEGER NOT NULL,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  rating INTEGER NOT NULL,
  birthdate DATE,
  side_1 VARCHAR(50),
  side_2 VARCHAR(50),
  side_3 VARCHAR(50),
  side_4 VARCHAR(50),
  side_5 VARCHAR(50),
  comments VARCHAR(1500),
  upvotes INTEGER,
  downvotes INTEGER,
  reports INTEGER,
  PRIMARY KEY (userReview_id),
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (med_id) REFERENCES Medicine(med_id)
);

CREATE TABLE ReviewReply(
  reviewReply_id INTEGER NOT NULL AUTO_INCREMENT,
  userAcc_id INTEGER NOT NULL,
  userReview_id INTEGER NOT NULL,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  comments VARCHAR(1500),
  upvotes INTEGER,
  downvotes INTEGER,
  reports INTEGER,
  PRIMARY KEY (reviewReply_id),
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (userReview_id) REFERENCES UserReview(userReview_id)
);

CREATE TABLE ChatMessage(
  chat_id INTEGER NOT NULL AUTO_INCREMENT,
  sender INTEGER NOT NULL,
  receiver INTEGER NOT NULL,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  content VARCHAR(1500),
  PRIMARY KEY (chat_id),
  FOREIGN KEY (sender) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (receiver) REFERENCES UserAccount(userAcc_id)
);

CREATE TABLE Pharmacies(
  pharm_id INTEGER NOT NULL AUTO_INCREMENT,
  pharm_name VARCHAR(150),
  pharm_address VARCHAR(100),
  pharm_city VARCHAR(50),
  pharm_state VARCHAR(50),
  pharm_zip CHAR(5),
  PRIMARY KEY (pharm_id)
);

CREATE TABLE BlockedUsers(
  userAcc_id INTEGER NOT NULL,
  reason VARCHAR(250),
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id)
);