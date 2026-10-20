<?php
session_start();
require 'koneksi.php';

$errors = [];
$old = ['nama' => '', 'email' => '', 'pesan' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nama']  = trim($_POST['nama'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $old['pesan'] = trim($_POST['pesan'] ?? '');

    // Validasi
    if ($old['nama'] === '')  $errors[] = 'Nama wajib diisi.';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid.';
    if ($old['pesan'] === '') $errors[] = 'Pesan wajib diisi.';

    // Simpan kalau tidak ada error
    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO tamu (nama, email, pesan) VALUES (:nama, :email, :pesan)'
        );
        $stmt->execute($old);

        $_SESSION['sukses'] = 'Terima kasih, pesan kamu sudah tersimpan!';
        header('Location: index.php'); // cegah double submit saat refresh
        exit;
    }
}

// Ambil pesan sukses (sekali tampil)
$sukses = $_SESSION['sukses'] ?? null;
unset($_SESSION['sukses']);

// Ambil daftar tamu, terbaru di atas
$daftarTamu = $pdo->query('SELECT * FROM tamu ORDER BY created_at DESC')->fetchAll();

// Helper biar aman dari XSS
function e($teks) {
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Buku Tamu</h1>

        <?php if ($sukses): ?>
            <div class="alert sukses"><?= e($sukses) ?></div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?= e($old['nama']) ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= e($old['email']) ?>">

            <label for="pesan">Pesan</label>
            <textarea id="pesan" name="pesan" rows="4"><?= e($old['pesan']) ?></textarea>

            <button type="submit">Kirim</button>
        </form>

        <h2>Daftar Tamu (<?= count($daftarTamu) ?>)</h2>

        <?php if (!$daftarTamu): ?>
            <p>Belum ada pesan. Jadilah yang pertama!</p>
        <?php endif; ?>

        <?php foreach ($daftarTamu as $tamu): ?>
            <div class="tamu">
                <strong><?= e($tamu['nama']) ?></strong>
                <small><?= e($tamu['email']) ?> · <?= date('d M Y, H:i', strtotime($tamu['created_at'])) ?></small>
                <p><?= nl2br(e($tamu['pesan'])) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>