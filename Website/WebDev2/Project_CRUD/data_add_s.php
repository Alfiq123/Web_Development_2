<?php
// Meminta jembatan koneksi ke database
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	header("Location: data_add.php");
	exit;
}

// Menerima inputan
$angkatan  = trim($_POST["angkatan"] ?? "");
$nama      = trim($_POST["nama"] ?? "");
$nim       = trim($_POST["nim"] ?? "");
$jurusan   = trim($_POST["jurusan"] ?? "");
$photo     = $_FILES["photo"]["name"] ?? "";
$fileError = $_FILES["photo"]["error"] ?? UPLOAD_ERR_NO_FILE;
$file_tmp  = $_FILES["photo"]["tmp_name"] ?? "";

// Pemeriksaan jika ada data inputan kosong
if ($angkatan === "" || $nama === "" || $nim === "" || $jurusan === "" || $photo === "") {
	?>
	<script>
		alert("Masih ada data yang kosong");
		document.location.href = "data_add.php";
	</script>
	<?php
	exit;
}

if ($fileError !== UPLOAD_ERR_OK) {
	?>
	<script>
		alert("Gagal mengupload gambar. Pastikan ukuran file tidak melebihi batas server.");
		document.location.href = "data_add.php";
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
		window.location = "data_add.php";
	</script>
	<?php
	exit;
}

$imageInfo = ($file_tmp !== "" && is_uploaded_file($file_tmp)) ? @getimagesize($file_tmp) : false;
if ($imageInfo === false || !in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
	?>
	<script>
		alert("File yang diupload bukan gambar JPG atau PNG yang valid.");
		window.location = "data_add.php";
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
		alert("Gagal menyimpan file gambar ke folder img.");
		window.location = "data_add.php";
	</script>
	<?php
	exit;
}

try {
	$stmt = $koneksi->prepare("INSERT INTO m_siswa (angkatan, nama, nim, jurusan, photo) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("sssss", $angkatan, $nama, $nim, $jurusan, $nama_gambar_baru);
	$stmt->execute();
	$stmt->close();
	?>
	<script>
		alert("Data berhasil ditambah.");
		window.location = "index-Copy.php";
	</script>
	<?php
} catch (mysqli_sql_exception $e) {
	if (is_file("img/" . $nama_gambar_baru)) {
		unlink("img/" . $nama_gambar_baru);
	}
	exit("Query gagal dijalankan: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8"));
}
?>