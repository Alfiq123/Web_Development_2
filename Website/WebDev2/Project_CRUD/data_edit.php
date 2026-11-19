<?php
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
	$stmt = $koneksi->prepare("SELECT * FROM m_siswa WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$stmt->close();
} catch (mysqli_sql_exception $e) {
	exit("Perintah SQL Salah: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8"));
}

if (!$row) {
	?>
	<script>
		alert("Data tidak ditemukan");
		document.location.href = "index.php";
	</script>
	<?php
	exit;
}

$photoFile = basename((string) ($row["photo"] ?? ""));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit Data</title>
	<!-- TABLE STYLES-->
	<link href="css/dataTables.bootstrap.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet" />
</head>
<body>
	<div class="col-md-8 col-md-offset-2">
		<br><br>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="alert alert-warning">
					<a href="index.php" class="btn btn-danger"><i class="glyphicon glyphicon-file"></i> Lihat Data</a>
				</div>
			</div>
			<div class="panel-body">
				<form method="post" action="data_edit_s.php" enctype="multipart/form-data">
					<div class="form-group">
						<label>Id</label>
						<input type="text" class="form-control" name="id" value="<?php echo htmlspecialchars((string) ($row["id"] ?? ""), ENT_QUOTES, "UTF-8"); ?>" readonly>
					</div>
					<div class="form-group">
						<label>Angkatan</label>
						<input type="text" class="form-control" name="angkatan" value="<?php echo htmlspecialchars((string) ($row["angkatan"] ?? ""), ENT_QUOTES, "UTF-8"); ?>" required>
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars((string) ($row["nama"] ?? ""), ENT_QUOTES, "UTF-8"); ?>" required>
					</div>
					<div class="form-group">
						<label>NIM</label>
						<input type="text" class="form-control" name="nim" value="<?php echo htmlspecialchars((string) ($row["nim"] ?? ""), ENT_QUOTES, "UTF-8"); ?>" required>
					</div>
					<div class="form-group">
						<label>Jurusan</label>
						<input type="text" class="form-control" name="jurusan" value="<?php echo htmlspecialchars((string) ($row["jurusan"] ?? ""), ENT_QUOTES, "UTF-8"); ?>" required>
					</div>
					<div class="form-group">
						<label>Photo</label><br>
						<?php if ($photoFile !== "" && !str_contains($photoFile, "\0") && is_file("img/" . $photoFile)): ?>
							<img src="img/<?php echo htmlspecialchars(rawurlencode($photoFile), ENT_QUOTES, "UTF-8"); ?>" style="width: 120px; margin-bottom: 8px;" alt="Photo"><br>
						<?php endif; ?>
						<input type="file" class="form-control" name="photo" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
						<i style="display: block; font-size: 11px; color: red; margin-top: 4px;">Abaikan jika tidak merubah gambar</i>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
					<button type="reset" class="btn btn-default"><i class="fa fa-file-text"></i> Bersih</button>
				</form>
			</div>
		</div>
	</div>
	<script src="js/jquery-1.10.2.js"></script>
	<!-- Bootstrap Js -->
	<script src="js/bootstrap.min.js"></script>

</body>
</html>