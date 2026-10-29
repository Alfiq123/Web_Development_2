<?php
// $host = 'db';
// $db   = 'guestbook';
// $user = 'root';
// $pass = 'root123';

try {
    $pdo = new PDO(
        // "mysql:host=$host;dbname=$db;charset=utf8mb4",
        "mysql:host=host.docker.internal;
         dbname=guestbook;
         charset=utf8mb4",
        "root",
        "root123",
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Koneksi database gagal.');
}