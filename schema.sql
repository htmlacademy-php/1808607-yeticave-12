CREATE DATABASE yeticave
DEFAULT CHARACTER SET UTF8
DEFAULT COLLATE UTF8_GENERAL_CI;

CREATE TABLE category (
  symbolic_code CHAR(64) NOT NULL PRIMARY KEY,
  name CHAR(64) NOT NULL 
);

CREATE TABLE user (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date_registration DATETIME NOT NULL,
  name VARCHAR(128) NOT NULL,
  email VARCHAR(128) NOT NULL,
  password VARCHAR(15) NOT NULL,
  contact VARCHAR(128) NOT NULL
);

CREATE TABLE lot (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date_create DATETIME NOT NULL,
  name VARCHAR(128) NOT NULL,
  description VARCHAR(255) NOT NULL,
  image VARCHAR(255),
  start_price DECIMAL(5,2) NOT NULL,
  date_end DATE NOT NULL,
  rate_step INT NOT NULL,
  id_author INT NOT NULL,
  id_winner INT,
  id_category CHAR(64) NOT NULL,
  FOREIGN KEY (id_author)  REFERENCES user (id),
  FOREIGN KEY (id_winner)  REFERENCES user (id),
  FOREIGN KEY (id_category)  REFERENCES category (symbolic_code)
);

CREATE TABLE rate (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date_add DATETIME NOT NULL,
  price DECIMAL(5,2) NOT NULL,
  id_user INT NOT NULL,
  id_lot INT NOT NULL,
  FOREIGN KEY (id_user)  REFERENCES user (id),
  FOREIGN KEY (id_lot)  REFERENCES lot (id)
);
