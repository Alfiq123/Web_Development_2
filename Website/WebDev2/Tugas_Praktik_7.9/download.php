<?php
// Mengirim file ke browser sebagai unduhan: download.php?id=1
include "config.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = mysqli_prepare($koneksi, "SELECT nama_file, tipe_file, file FROM download WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$path = $data ? $folder_upload . $data["file"] : "";

if (!$data || !is_file($path)) {
    http_response_code(404);
    die("File tidak ditemukan.");
}

// Bersihkan nama agar aman dipakai sebagai nama unduhan
$nama_unduh = preg_replace("/[^\w\s\-\(\)]/u", "_", $data["nama_file"]) . "." . $data["tipe_file"];

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename='" . $nama_unduh . "'");
header("Content-Length: " . filesize($path));
readfile($path);
exit;
