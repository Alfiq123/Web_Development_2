<?php
// Meminta jembatan koneksi ke database
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	header("Location: index.php");
	exit;
}

// Menerima inputan
$id        = isset($_POST["id"]) ? (int) $_POST["id"] : 0;
$angkatan  = trim($_POST["angkatan"] ?? "");
$nama      = trim($_POST["nama"] ?? "");
$nim       = trim($_POST["nim"] ?? "");
$jurusan   = trim($_POST["jurusan"] ?? "");
$photo     = $_FILES["photo"]["name"] ?? "";
$fileError = $_FILES["photo"]["error"] ?? UPLOAD_ERR_NO_FILE;
$file_tmp  = $_FILES["photo"]["tmp_name"] ?? "";

if ($id <= 0) {
	?>
	<script>
		alert("ID tidak valid");
		document.location.href = "index.php";
	</script>
	<?php
	exit;
}

// Pemeriksaan jika ada data inputan kosong
if ($angkatan === "" || $nama === "" || $nim === "" || $jurusan === "") {
	?>
	<script>
		alert("Masih ada data yang kosong");
		document.location.href = "data_edit.php?id=<?php echo $id; ?>";
	</script>
	<?php
	exit;
}

// Cek apakah user mengupload gambar baru
if ($fileError !== UPLOAD_ERR_NO_FILE) {
	if ($fileError !== UPLOAD_ERR_OK || $photo === "") {
		?>
		<script>
			alert("Gagal mengupload gambar. Pastikan ukuran file tidak melebihi batas server.");
			window.location = "data_edit.php?id=<?php echo $id; ?>";
		</script>
		<?php
		exit;
	}

	$ekstensi_diperbolehkan = ["png", "jpg", "jpeg"];
	$ekstensi = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

	if (!in_array($ekstensi, $ekstensi_diperbolehkan, true)) {
		?>
		<script>
			alert("Ekstensi gambar yang boleh hanya jpg atau png.");
			window.location = "data_edit.php?id=<?php echo $id; ?>";
		</script>
		<?php
		exit;
	}

	$imageInfo = ($file_tmp !== "" && is_uploaded_file($file_tmp)) ? @getimagesize($file_tmp) : false;
	if ($imageInfo === false || !in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
		?>
		<script>
			alert("File yang diupload bukan gambar JPG atau PNG yang valid.");
			window.location = "data_edit.php?id=<?php echo $id; ?>";
		</script>
		<?php
		exit;
	}

	if (!is_dir("img")) {
		mkdir("img", 0755, true);
	}

	$nama_asli = preg_replace("/[^A-Za-z0-9._-]/", "_", basename($photo));
	$nama_asli = substr($nama_asli, -80);
	$angka_acak = random_int(1, 999);
	$nama_gambar_baru = $angka_acak . "-" . $nama_asli;

	if (!move_uploaded_file($file_tmp, "img/" . $nama_gambar_baru)) {
		?>
		<script>
			alert("Gagal menyimpan file gambar baru ke folder img.");
			window.location = "data_edit.php?id=<?php echo $id; ?>";
		</script>
		<?php
		exit;
	}

	try {
		// Ambil nama foto lama agar bisa dihapus setelah update berhasil
		$stmtOld = $koneksi->prepare("SELECT photo FROM m_siswa WHERE id = ?");
		$stmtOld->bind_param("i", $id);
		$stmtOld->execute();
		$oldRow = $stmtOld->get_result()->fetch_assoc();
		$stmtOld->close();
		$oldPhoto = basename((string) ($oldRow["photo"] ?? ""));

		// Jalankan UPDATE dengan foto baru
		$stmt = $koneksi->prepare("UPDATE m_siswa SET angkatan = ?, nama = ?, nim = ?, jurusan = ?, photo = ? WHERE id = ?");
		$stmt->bind_param("sssssi", $angkatan, $nama, $nim, $jurusan, $nama_gambar_baru, $id);
		$stmt->execute();
		$stmt->close();

		// Hapus foto lama jika ada dan berbeda dengan foto baru
		if ($oldPhoto !== "" && $oldPhoto !== $nama_gambar_baru && !str_contains($oldPhoto, "\0") && is_file("img/" . $oldPhoto)) {
			unlink("img/" . $oldPhoto);
		}
		?>
		<script>
			alert("Data berhasil diubah.");
			window.location = "index.php";
		</script>
		<?php
	} catch (mysqli_sql_exception $e) {
		if (is_file("img/" . $nama_gambar_baru)) {
			unlink("img/" . $nama_gambar_baru);
		}
		exit("Query gagal dijalankan: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8"));
	}
} else {
	// Jalankan UPDATE tanpa mengubah kolom photo
	try {
		$stmt = $koneksi->prepare("UPDATE m_siswa SET angkatan = ?, nama = ?, nim = ?, jurusan = ? WHERE id = ?");
		$stmt->bind_param("ssssi", $angkatan, $nama, $nim, $jurusan, $id);
		$stmt->execute();
		$stmt->close();
		?>
		<script>
			alert("Data berhasil diubah.");
			window.location = "index.php";
		</script>
		<?php
	} catch (mysqli_sql_exception $e) {
		exit("Query gagal dijalankan: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8"));
	}
}
?>