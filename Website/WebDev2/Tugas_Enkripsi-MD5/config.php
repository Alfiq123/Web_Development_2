<?php
$koneksi = new PDO(
    "mysql:host=host.docker.internal;
     dbname=loginmd5;
     charset=utf8mb4",
    "root", 
    "root123"
);
$koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $koneksi = mysqli_connect(
//     "host.docker.internal",
//     "root",
//     "root123",
//     "loginmd5"
// );

// // Check connection
// if (mysqli_connect_errno()) {
//     echo "Koneksi database gagal : " . mysqli_connect_error();
// }

?>