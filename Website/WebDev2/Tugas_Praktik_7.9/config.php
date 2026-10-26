<?php
// ===== Koneksi database =====
/* $koneksi = mysqli_connect("localhost", "root", "", "upload_download"); */
$koneksi = mysqli_connect("host.docker.internal", "root", "root123");
mysqli_select_db($koneksi, "upload_download");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
mysqli_set_charset($koneksi, "utf8mb4");

// ===== Pengaturan upload (bisa diubah) =====
$ekstensi_diizinkan = ["doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "rar", "zip"];
$ukuran_maks        = 1 * 1024 * 1024;        // 1 MB
$folder_upload      = __DIR__ . "/files/";    // tempat file fisik disimpan

// ===== Fungsi konversi ukuran file (byte -> KB/MB/...) =====
function formatBytes($bytes, $precision = 2) {
    $units = ["B", "KB", "MB", "GB", "TB"];
    $bytes = max($bytes, 0);
    $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow   = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . " " . $units[$pow];
}
