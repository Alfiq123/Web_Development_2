<?php
// Mengaktifkan exception mode pada mysqli (standar PHP 8.1+)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Data server MySQL
$db_host = 'localhost'; // --> server mysql
$db_user = 'root';      // --> username
$db_pass = '';          // --> password
$db_name = 'crud';      // --> nama database

try {
    // Fungsi untuk koneksi ke mysqli
    $koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $koneksi->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // Jika gagal, hentikan eksekusi dan tampilkan pesan
    die('Koneksi Gagal : ' . $e->getMessage());
}
?>