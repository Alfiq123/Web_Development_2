<?php
// 1. Simpan koneksi ke dalam variabel $koneksi
$koneksi = mysqli_connect("localhost", "root", "root123");

// 2. Oper variabel $koneksi sebagai argumen pertama
mysqli_select_db($koneksi, "upload_download");

// fungsi formatBytes tetap sama...
function formatBytes($bytes, $precision = 2) {
    $units = array("B", "KB", "MB", "GB", "TB");

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . " " . $units[$pow];
}
?>
