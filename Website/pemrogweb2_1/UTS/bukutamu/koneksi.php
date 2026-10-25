<?php
$host = 'db';
$db   = 'bukutamu';
$user = 'root';
$pass = 'rahasia';

try {
    $pdo = new PDO(
        "mysql:host=host.docker.internal;dbname=bukutamu", "root", "apache_123"
    );
    // $pdo = new PDO(
    //     "mysql:host=$host;dbname=$db;charset=utf8mb4",
    //     $user,
    //     $pass,
    //     [
    //         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //     ]
    // );
} catch (PDOException $e) {
    die('Koneksi gagal: ' . $e->getMessage());
}