-- this setup script can define all relation needed in project
-- also cleanup script will be provided
CREATE DATABASE groupen;
USE groupen;
CREATE TABLE user
(
    uid varchar(10),
    psw varchar(10) NOT NULL,
    email varchar(20) NOT NULL,
    address varchar(50),
    balance float DEFAULT 0,
    admin BIT DEFAULT 0,
    PRIMARY KEY (uid)
);
INSERT INTO `user`(`uid`, `psw`, `email`, `address`, `balance`, `admin`) VALUES ("jian","123","jian.li1@uclagary.ca","address1",0,1);

CREATE TABLE product
(
    pid int NOT NULL AUTO_INCREMENT,
    user_uid varchar(10) NOT NULL,
    name varchar(40) NOT NULL,
    price float NOT NULL,
    description varchar(100) NOT NULL,
    tag varchar(10),
    category varchar(10),
    photo_url varchar(30),
    start_time datetime NOT NULL,
    end_time datetime NOT NULL,
    PRIMARY KEY (pid),
    FOREIGN KEY (user_uid) REFERENCES user (uid)
);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct1',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct2',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct3',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct4',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct5',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct6',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct7',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct8',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct9',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct10',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct11',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO `product`(`user_uid`, `name`, `price`, `description`, `tag`, `category`, `photo_url`, `start_time`, `end_time`)
VALUES ('jian','testproduct12',99.9,'description1','tag1','category1','photo_url1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
CREATE TABLE groups
(
    gid int NOT NULL AUTO_INCREMENT,
    starter_uid varchar(10) NOT NULL,
    product_pid int NOT NULL,
    PRIMARY KEY (gid),
    FOREIGN KEY (starter_uid) REFERENCES user (uid),
    FOREIGN KEY (product_pid) REFERENCES product (pid)
);
CREATE TABLE groupmember
(
    groups_gid int,
    user_uid varchar(10),
    PRIMARY KEY (groups_gid, user_uid),
    FOREIGN KEY (groups_gid) REFERENCES groups (gid),
    FOREIGN KEY (user_uid) REFERENCES user (uid)
);
CREATE TABLE orders
(
    oid int AUTO_INCREMENT,
    user_uid varchar(10) NOT NULL,
    product_pid int NOT NULL,
    status varchar(5) NOT NULL,
    PRIMARY KEY (oid),
    FOREIGN KEY (user_uid) REFERENCES user (uid),
    FOREIGN KEY (product_pid) REFERENCES product (pid)
);
CREATE TABLE circle
(
    cid int AUTO_INCREMENT,
    name varchar(20) NOT NULL,
    tag varchar(10),
    PRIMARY KEY (cid)
);
CREATE TABLE circle_user
(
    user_uid varchar(10),
    circle_cid int,
    PRIMARY KEY (user_uid, circle_cid),
    FOREIGN KEY (user_uid) REFERENCES user (uid),
    FOREIGN KEY (circle_cid) REFERENCES circle (cid)
);
CREATE TABLE user_msg
(
    umid int AUTO_INCREMENT,
    sender_uid varchar(10) NOT NULL,
    receiver_uid varchar(10) NOT NULL,
    context varchar(200) NOT NULL,
    msg_time datetime DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (umid),
    FOREIGN KEY (sender_uid) REFERENCES user (uid),
    FOREIGN KEY (receiver_uid) REFERENCES user (uid)
);
CREATE TABLE circle_msg
(
    cmid int AUTO_INCREMENT,
    sender_uid varchar(10) NOT NULL,
    circle_cid int NOT NULL,
    context varchar(200) NOT NULL,
    msg_time datetime DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (cmid),
    FOREIGN KEY (sender_uid) REFERENCES user (uid),
    FOREIGN KEY (circle_cid) REFERENCES circle (cid)
);
CREATE TABLE friend_with
(
    user_uid varchar(10),
    friend_uid varchar(10),
    PRIMARY KEY (user_uid, friend_uid),
    FOREIGN KEY (user_uid) REFERENCES user (uid),
    FOREIGN KEY (friend_uid) REFERENCES user (uid)
);
