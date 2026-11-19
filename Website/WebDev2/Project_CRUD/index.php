<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>PROJECT KU</title>
	<!-- TABLE STYLES-->
	<link href="css/dataTables.bootstrap.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet" />
	<link href="css/style.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="col-md-8 col-md-offset-2">
		<br><br>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="alert alert-warning">
					<a href="index-Copy.php" class="btn btn-danger"><i class="glyphicon glyphicon-plus"></i> LOGIN</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="container-fluid">
					<h2 class="text-center mb-4">Card Dinamis dari Database PHP</h2>
					<div class="row" id="load_data">
						<?php
						include "koneksi.php";
						try {
							$query = "SELECT * FROM m_siswa ORDER BY id ASC";
							$dewan1 = $koneksi->prepare($query);
							$dewan1->execute();
							$res1 = $dewan1->get_result();

							while ($row = $res1->fetch_assoc()) {
								$id        = (string) ($row["id"] ?? "");
								$photoFile = basename((string) ($row["photo"] ?? ""));
								$nim       = (string) ($row["nim"] ?? "");
								$nama      = (string) ($row["nama"] ?? "");
								$jurusan   = (string) ($row["jurusan"] ?? "");
								$angkatan  = (string) ($row["angkatan"] ?? "");
								?>
								<div class="card-deck mb-3">
									<div class="card" style="width: 250px;">
										<?php if ($photoFile !== "" && !str_contains($photoFile, "\0") && is_file("img/" . $photoFile)): ?>
											<img src="img/<?php echo htmlspecialchars(rawurlencode($photoFile), ENT_QUOTES, "UTF-8"); ?>" class="card-img-top card-img-fixed" alt="gambar">
										<?php else: ?>
											<div class="card-img-top bg-light text-muted d-flex align-items-center justify-content-center" style="height: 180px;">
												Tidak ada foto
											</div>
										<?php endif; ?>
										<div class="card-body">
											<h5 class="card-title"><?php echo htmlspecialchars($nama, ENT_QUOTES, "UTF-8"); ?></h5>
											<p class="card-text"><?php echo htmlspecialchars($nim, ENT_QUOTES, "UTF-8"); ?></p>
											<p class="card-text"><?php echo htmlspecialchars($jurusan, ENT_QUOTES, "UTF-8"); ?></p>
											<a href="#" class="btn btn-primary">Selanjutnya</a>
										</div>
										<div class="card-footer">
											<small class="text-muted">Angkatan <?php echo htmlspecialchars($angkatan, ENT_QUOTES, "UTF-8"); ?></small>
										</div>
									</div>
								</div>
								<?php
							}
							$res1->free();
							$dewan1->close();
						} catch (mysqli_sql_exception $e) {
							echo "<div class='col-12'><div class='alert alert-danger'>Gagal mengambil data: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8") . "</div></div>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="js/jquery-1.10.2.js"></script>
	<!-- Bootstrap Js -->
	<script src="js/bootstrap.min.js"></script>

</body>
</html>