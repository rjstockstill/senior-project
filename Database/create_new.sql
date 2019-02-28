CREATE TABLE Medicine(
  med_id INTEGER NOT NULL AUTO_INCREMENT,
  med_name VARCHAR(150) unique,
  general_name VARCHAR(500),
  med_purpose VARCHAR(1500),
  med_desc VARCHAR(3000),
  med_dosage VARCHAR(1500),
  med_admin VARCHAR(100),
  med_img VARCHAR(100),
  PRIMARY KEY (med_id)
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

CREATE TABLE UserMeds(
  userAcc_id INTEGER NOT NULL,
  med_id INTEGER NOT NULL,
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (med_id) REFERENCES Medicine(med_id)
);

CREATE TABLE UserMedNotif(
  userAcc_id INTEGER NOT NULL,
  med_id INTEGER NOT NULL,
  userMed_amount INTEGER,
  contact_info VARCHAR(100),
  notif_time DATETIME,
  d_sun INTEGER,
  d_mon INTEGER,
  d_tue INTEGER,
  d_wed INTEGER,
  d_thu INTEGER,
  d_fri INTEGER,
  d_sat INTEGER,
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
  PRIMARY KEY (userReview_id),
  FOREIGN KEY (userAcc_id) REFERENCES UserAccount(userAcc_id),
  FOREIGN KEY (med_id) REFERENCES Medicine(med_id)
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

SHOW TABLES;