<?php
$host = "localhost";
$user = "root";
$pass = "Apache_123";
$db   = "Buku_Tamu";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>