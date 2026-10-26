<?php
include "config.php";

// Pesan notifikasi dari upload.php
$pesan = [
    "sukses"   => ["ok",    "File berhasil diunggah!"],
    "gagal"    => ["error", "Upload gagal, silakan coba lagi."],
    "ekstensi" => ["error", "Ekstensi file tidak diizinkan."],
    "ukuran"   => ["error", "Ukuran file melebihi batas " . formatBytes($ukuran_maks, 0) . "."],
];
$status = $_GET["status"] ?? "";

// Ambil semua file dari database (terbaru dulu)
$hasil = mysqli_query($koneksi, "SELECT * FROM download ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FileFlix - Upload & Download File</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">
    <div class="logo">FILEFLIX</div>
</header>

<main>
    <!-- ===== Area upload ===== -->
    <section class="hero">
        <h1>Unggah file Anda</h1>
        <p>
            Format: <?= strtoupper(implode(", ", $ekstensi_diizinkan)) ?>
            &middot; Maksimal <?= formatBytes($ukuran_maks, 0) ?>
        </p>

        <?php if (isset($pesan[$status])): ?>
            <div class="alert <?= $pesan[$status][0] ?>"><?= $pesan[$status][1] ?></div>
        <?php endif; ?>

        <form action="upload.php" method="post" enctype="multipart/form-data" id="form-upload">
            <label class="dropzone" id="dropzone" for="input-file">
                <span class="dz-icon">&#8679;</span>
                <span id="dz-text">Klik atau seret file ke sini</span>
            </label>
            <input type="file" name="file" id="input-file" required hidden
                   data-max="<?= $ukuran_maks ?>">

            <div class="form-row">
                <input type="text" name="nama" maxlength="100"
                       placeholder="Judul file (opsional)">
                <button type="submit" class="btn btn-red">Upload</button>
            </div>
        </form>
    </section>

    <!-- ===== Grid file ===== -->
    <section class="katalog">
        <h2>Semua File</h2>

        <?php if (mysqli_num_rows($hasil) > 0): ?>
            <div class="grid">
                <?php while ($d = mysqli_fetch_assoc($hasil)): ?>
                    <article class="card">
                        <div class="poster tipe-<?= htmlspecialchars($d["tipe_file"]) ?>">
                            <span><?= strtoupper(htmlspecialchars($d["tipe_file"])) ?></span>
                        </div>
                        <div class="info">
                            <h3 title="<?= htmlspecialchars($d["nama_file"]) ?>">
                                <?= htmlspecialchars($d["nama_file"]) ?>
                            </h3>
                            <p class="meta">
                                <?= formatBytes($d["ukuran_file"]) ?> &middot;
                                <?= date("d M Y", strtotime($d["tanggal_upload"])) ?>
                            </p>
                            <a class="btn btn-light" href="download.php?id=<?= (int) $d["id"] ?>">
                                &#8681; Download
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="kosong">Belum ada file. Yuk upload yang pertama!</p>
        <?php endif; ?>
    </section>
</main>

<script src="script.js"></script>
</body>
</html>
