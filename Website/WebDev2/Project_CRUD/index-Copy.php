<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>PROJECT KU</title>
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
					<a href="data_add.php" class="btn btn-danger"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="table">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Id</th>
								<th>Angkatan</th>
								<th>Nama</th>
								<th>NIM</th>
								<th>Jurusan</th>
								<th>Photo</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include "koneksi.php";
							$no = 0;
							try {
								$result = $koneksi->query("SELECT * FROM m_siswa ORDER BY nama ASC");
								while ($row = $result->fetch_assoc()) {
									$no++;
									$photoFile = basename((string) ($row["photo"] ?? ""));
									?>
									<tr class="">
										<td><?php echo htmlspecialchars((string) ($row["id"] ?? ""), ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars((string) ($row["angkatan"] ?? ""), ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars((string) ($row["nama"] ?? ""), ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars((string) ($row["nim"] ?? ""), ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars((string) ($row["jurusan"] ?? ""), ENT_QUOTES, "UTF-8"); ?></td>
										<td style="text-align: center;">
											<?php if ($photoFile !== "" && !str_contains($photoFile, "\0") && is_file("img/" . $photoFile)): ?>
												<img src="img/<?php echo htmlspecialchars(rawurlencode($photoFile), ENT_QUOTES, "UTF-8"); ?>" style="width: 120px;" alt="Photo">
											<?php else: ?>
												<span class="text-muted">Tidak ada foto</span>
											<?php endif; ?>
										</td>
										<td>
											<a href="data_edit.php?id=<?php echo urlencode((string) ($row["id"] ?? "")); ?>" class="btn btn-info btn-sm">
												<i class="glyphicon glyphicon-check"></i> Edit</a>
											<a href="javascript:;" data-id="<?php echo htmlspecialchars((string) ($row["id"] ?? ""), ENT_QUOTES, "UTF-8"); ?>"
												data-toggle="modal" data-target="#modal-konfirmasi" class="btn btn-warning btn-sm">
												<i class="glyphicon glyphicon-trash"></i> Hapus</a>
										</td>
									</tr>
									<?php
								}
								$result->free();
							} catch (mysqli_sql_exception $e) {
								echo "<tr><td colspan='7' class='text-danger'>Gagal mengambil data: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8") . "</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- modal konfirmasi-->
	<div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Konfirmasi</h4>
				</div>
				<div class="modal-body btn-info">
					Apakah Anda yakin ingin menghapus data ini ?
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-danger" id="hapus-true-data">Hapus</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
				</div>

			</div>
		</div>
	</div>
	<script src="js/jquery-1.10.2.js"></script>
	<!-- Bootstrap Js -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.js"></script>
	<script src="js/hapus.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>
	<script>
		$(document).ready(function () {
			$("#dataTables-example").dataTable();
		});
	</script>

</body>
</html>