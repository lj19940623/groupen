-- this setup script can define all relation needed in project
-- also cleanup script will be provided
CREATE DATABASE groupen;
USE groupen;
CREATE TABLE user
(
uid varchar(10),
psw varchar(10) NOT NULL,
email varchar(20),
address varchar(50),
balance varchar(10),
PRIMARY KEY (uid)
);
CREATE TABLE product
(
pid int,
user_uid varchar(10) NOT NULL,
price float NOT NULL,
description varchar(100) NOT NULL,
tag varchar(10),
category varchar(10) NOT NULL,
photo_url varchar(30),
start_time datetime NOT NULL,
end_time datetime NOT NULL,
PRIMARY KEY (pid),
FOREIGN KEY (user_uid) REFERENCES user (uid)
);
CREATE TABLE group
(
gid int,
starter_uid varchar(10) NOT NULL,
product_pid int NOT NULL,
PRIMARY KEY (gid),
FOREIGN KEY (starter_uid) REFERENCES user (uid),
FOREIGN KEY (product_pid) REFERENCES product (pid)
);
