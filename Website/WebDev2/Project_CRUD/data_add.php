<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Tambah Data</title>
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
					<a href="index-Copy.php" class="btn btn-danger"><i class="glyphicon glyphicon-file"></i> Lihat Data</a>
				</div>
			</div>
			<div class="panel-body">
				<form method="post" action="data_add_s.php" enctype="multipart/form-data">
					<div class="form-group">
						<label>Angkatan</label>
						<input type="text" class="form-control" name="angkatan" placeholder="ex. 2024" required>
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" name="nama" required>
					</div>
					<div class="form-group">
						<label>NIM</label>
						<input type="text" class="form-control" name="nim" required>
					</div>
					<div class="form-group">
						<label>Jurusan</label>
						<input type="text" class="form-control" name="jurusan" required>
					</div>
					<div class="form-group">
						<label>Photo</label>
						<input type="file" class="form-control" name="photo" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required>
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