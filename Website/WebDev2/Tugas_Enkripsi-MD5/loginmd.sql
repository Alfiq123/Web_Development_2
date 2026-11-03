CREATE DATABASE loginmd5;

USE loginmd5;

CREATE TABLE user (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(225),
    username VARCHAR(225),
    password VARCHAR(225)
);

-- password untuk user "coba" adalah: 123456 (MD5)
INSERT INTO user (id, nama, username, password) 
    VALUES (1, "Made Ayu", "coba", MD5("123456"));