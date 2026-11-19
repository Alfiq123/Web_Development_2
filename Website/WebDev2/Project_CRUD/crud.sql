CREATE DATABASE IF NOT EXISTS crud;
USE crud;

CREATE TABLE m_siswa (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    angkatan VARCHAR(10) NOT NULL,
    nama     VARCHAR(50) NOT NULL,
    nim      VARCHAR(13) NOT NULL,
    jurusan  VARCHAR(20) NOT NULL
);

ALTER TABLE m_siswa ADD COLUMN photo VARCHAR(100) NULL AFTER jurusan;