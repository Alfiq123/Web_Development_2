<?php
// HAPUS
include 'koneksi.php';

// Validasi parameter id dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
	?>
	<script>
		alert('ID tidak valid');
		document.location.href = 'index.php';
	</script>
	<?php
	exit;
}

try {
	$stmt = $koneksi->prepare('DELETE FROM m_siswa WHERE id = ?');
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$affected = $stmt->affected_rows;
	$stmt->close();

	if ($affected > 0) {
		?>
		<script>
			alert('Berhasil Dihapus');
			document.location.href = 'index.php';
		</script>
		<?php
	} else {
		?>
		<script>
			alert('Data tidak ditemukan');
			document.location.href = 'index.php';
		</script>
		<?php
	}
} catch (mysqli_sql_exception $e) {
	exit('Perintah SQL Salah: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>