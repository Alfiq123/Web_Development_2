<?php
// Meminta jembatan koneksi ke database
include 'koneksi.php';

// Pastikan file hanya diproses melalui method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: data_add.php');
	exit;
}

// Menerima inputan secara aman (mencegah Undefined array key)
$angkatan = trim($_POST['angkatan'] ?? '');
$nama     = trim($_POST['nama'] ?? '');
$nim      = trim($_POST['nim'] ?? '');
$jurusan  = trim($_POST['jurusan'] ?? '');

// Pemeriksaan jika ada data inputan kosong
if ($angkatan === '' || $nama === '' || $nim === '' || $jurusan === '') {
	?>
	<script>
		alert('Masih ada data yang kosong');
		document.location.href = 'data_add.php';
	</script>
	<?php
	exit;
}

// Input ke tabel db dengan Prepared Statement
try {
	$stmt = $koneksi->prepare('INSERT INTO m_siswa (angkatan, nama, nim, jurusan) VALUES (?, ?, ?, ?)');
	$stmt->bind_param('ssss', $angkatan, $nama, $nim, $jurusan);
	$stmt->execute();
	$stmt->close();
	?>
	<script>
		alert('Berhasil Disimpan');
		document.location.href = 'index.php';
	</script>
	<?php
} catch (mysqli_sql_exception $e) {
	exit('Perintah SQL Salah: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>