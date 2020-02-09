CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT,
  mail TEXT NOT NULL,
  master_password TEXT NOT NULL,
  uuid TEXT,
  PRIMARY KEY (id)
);

CREATE TABLE passwords (
  id int NOT NULL AUTO_INCREMENT,
  user_id int,
  label TEXT NOT NULL,
  login TEXT,
  password TEXT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
