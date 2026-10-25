<?php
// Memproses upload, lalu kembali ke index.php membawa status
include "config.php";

function kembali($status) {
    header("Location: index.php?status=" . $status);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_FILES["file"])) {
    kembali("gagal");
}

$file = $_FILES["file"];

// Cek error bawaan PHP (mis. melebihi batas upload_max_filesize di php.ini)
if ($file["error"] === UPLOAD_ERR_INI_SIZE || $file["error"] === UPLOAD_ERR_FORM_SIZE) {
    kembali("ukuran");
}
if ($file["error"] !== UPLOAD_ERR_OK) {
    kembali("gagal");
}

// Ambil data file
$nama_asli = $file["name"];
$ekstensi  = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
$ukuran    = $file["size"];
$tmp       = $file["tmp_name"];

// Judul: pakai isian user, kalau kosong pakai nama file asli
$judul = trim($_POST["nama"] ?? "");
if ($judul === "") {
    $judul = pathinfo($nama_asli, PATHINFO_FILENAME);
}
$judul = mb_substr($judul, 0, 100);

// Validasi ekstensi & ukuran
if (!in_array($ekstensi, $ekstensi_diizinkan, true)) {
    kembali("ekstensi");
}
if ($ukuran > $ukuran_maks) {
    kembali("ukuran");
}

// Nama file fisik dibuat acak supaya tidak bentrok / ditimpa
$nama_fisik = bin2hex(random_bytes(8)) . "." . $ekstensi;
$tujuan     = $folder_upload . $nama_fisik;

if (!move_uploaded_file($tmp, $tujuan)) {
    kembali("gagal");
}

// Simpan metadata ke database
$tanggal = date("Y-m-d");
$stmt = mysqli_prepare($koneksi,
    "INSERT INTO download (tanggal_upload, nama_file, tipe_file, ukuran_file, file) 
    VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssis", $tanggal, $judul, $ekstensi, $ukuran, $nama_fisik);

if (mysqli_stmt_execute($stmt)) {
    kembali("sukses");
} else {
    unlink($tujuan); // batalkan file fisik kalau database gagal
    kembali("gagal");
}
