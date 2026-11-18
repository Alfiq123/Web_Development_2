<?php
// Meminta jembatan koneksi ke database
include 'koneksi.php';

// Pastikan file hanya diproses melalui method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: index.php');
	exit;
}

// Menerima inputan
$id       = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$angkatan = trim($_POST['angkatan'] ?? '');
$nama     = trim($_POST['nama'] ?? '');
$nim      = trim($_POST['nim'] ?? '');
$jurusan  = trim($_POST['jurusan'] ?? '');

if ($id <= 0) {
	?>
	<script>
		alert('ID tidak valid');
		document.location.href = 'index.php';
	</script>
	<?php
	exit;
}

// Pemeriksaan jika ada data inputan kosong
if ($angkatan === '' || $nama === '' || $nim === '' || $jurusan === '') {
	?>
	<script>
		alert('Masih ada data yang kosong');
		document.location.href = 'data_edit.php?id=<?php echo $id; ?>';
	</script>
	<?php
	exit;
}

// Update ke tabel db dengan Prepared Statement
try {
	$stmt = $koneksi->prepare('UPDATE m_siswa SET angkatan = ?, nama = ?, nim = ?, jurusan = ? WHERE id = ?');
	$stmt->bind_param('ssssi', $angkatan, $nama, $nim, $jurusan, $id);
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