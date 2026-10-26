-- Jalankan di phpMyAdmin (tab SQL) atau import file ini
CREATE DATABASE IF NOT EXISTS `upload_download`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `upload_download`;

DROP TABLE IF EXISTS `download`;
CREATE TABLE `download` (
    `id`             INT(11)      NOT NULL AUTO_INCREMENT,
    `tanggal_upload` DATE         NOT NULL,
    `nama_file`      VARCHAR(100) NOT NULL,  -- judul yang ditampilkan
    `tipe_file`      VARCHAR(10)  NOT NULL,  -- ekstensi, mis. pdf
    `ukuran_file`    INT UNSIGNED NOT NULL,  -- dalam byte
    `file`           VARCHAR(255) NOT NULL,  -- nama file fisik di folder files/
    PRIMARY KEY (`id`)
);
