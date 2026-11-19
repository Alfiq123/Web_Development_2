<?php
// HAPUS DATA + FILE PHOTO
include "koneksi.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
if ($id <= 0) {
	?>
	<script>
		alert("ID tidak valid");
		document.location.href = "index.php";
	</script>
	<?php
	exit;
}

try {
	// Ambil nama file photo sebelum baris dihapus
	$stmtSelect = $koneksi->prepare("SELECT photo FROM m_siswa WHERE id = ?");
	$stmtSelect->bind_param("i", $id);
	$stmtSelect->execute();
	$row = $stmtSelect->get_result()->fetch_assoc();
	$stmtSelect->close();

	$stmt = $koneksi->prepare("DELETE FROM m_siswa WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$affected = $stmt->affected_rows;
	$stmt->close();

	if ($affected > 0) {
		$photoFile = basename((string) ($row["photo"] ?? ""));
		if ($photoFile !== "" && !str_contains($photoFile, "\0") && is_file("img/" . $photoFile)) {
			unlink("img/" . $photoFile);
		}
		?>
		<script>
			alert("Berhasil Dihapus");
			document.location.href = "index.php";
		</script>
		<?php
	} else {
		?>
		<script>
			alert("Data tidak ditemukan");
			document.location.href = "index.php";
		</script>
		<?php
	}
} catch (mysqli_sql_exception $e) {
	exit("Perintah SQL Salah: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8"));
}
?>