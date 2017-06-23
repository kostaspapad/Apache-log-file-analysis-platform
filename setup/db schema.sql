CREATE TABLE access_log(
  logid int(5) NOT NULL AUTO_INCREMENT,
  fid int(3) NOT NULL,
  uid VARCHAR(20) NOT NULL,
  country VARCHAR(70),
  HOST VARCHAR(150) NOT NULL,
  user_identifier VARCHAR(40) NOT NULL,
  user_id VARCHAR(40) NOT NULL,
  datetime DATETIME NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  timezone VARCHAR(5) NOT NULL,
  method VARCHAR(10),
  request TEXT,
  resource TEXT,
  protocol_type TEXT,
  status_code INT(3),
  obj_size INT(10) NOT NULL,
  PRIMARY KEY(logid)
);

CREATE TABLE users (
  uid int(11) NOT NULL AUTO_INCREMENT,
  fname varchar(45) NOT NULL,
  lname varchar(45) NOT NULL,
  email varchar(45) NOT NULL,
  timezone varchar(5) NOT NULL,
  uname varchar(30) NOT NULL,
  passwd varchar(100) NOT NULL,
  UNIQUE (uid,email,uname),
  PRIMARY KEY (uid)
);

CREATE TABLE user_files(
  fid INT(3) NOT NULL AUTO_INCREMENT,
  uid VARCHAR(20) NOT NULL,
  file_log_type VARCHAR(11) NOT NULL,
  file_name TEXT(100) NOT NULL,
  file_size int(10) NOT NULL,
  PRIMARY KEY(fid)
);

CREATE TABLE user_graphs(
  chart_ID int(3) NOT NULL AUTO_INCREMENT,
  uid VARCHAR(20) NOT NULL,
  fid INT(3) NOT NULL,
  graphCreationDate DATETIME NOT NULL,
  graphName VARCHAR(20) UNIQUE NOT NULL,
  graphComments TEXT(100),
  termX VARCHAR(20) NOT NULL,
  termY1 VARCHAR(20),
  termY2 VARCHAR(20),
  StartDate DATE,
  EndDate DATE,
  StartTime TIME,
  EndTime TIME,
  DrillDate VARCHAR(15),
  WhereY1 VARCHAR(255),
  WhereY2 VARCHAR(255),
  JSONwhereY1 TEXT,
  JSONwhereY2 TEXT,
  chartypeY1 VARCHAR(20),
  chartypeY2 VARCHAR(20),
  y1LineColor VARCHAR(10) NOT NULL,
  y2LineColor VARCHAR(10) NOT NULL,
  ShowLabels BOOLEAN NOT NULL,
  dashStyleY1 VARCHAR(20),
  dashStyleY2 VARCHAR(20),
  BackColor VARCHAR(10) NOT NULL,
  imageName VARCHAR(50) NOT NULL,
  PRIMARY KEY(chart_ID),
  FOREIGN KEY (uid) REFERENCES users(uid),
  FOREIGN KEY (fid) REFERENCES user_files(fid)
);
