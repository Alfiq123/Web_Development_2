<?php
require 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || mb_strlen($name) > 50) {
        $errors[] = 'Nama wajib diisi (maksimal 50 karakter).';
    }
    if ($message === '') {
        $errors[] = 'Pesan wajib diisi.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO messages (name, message) VALUES (?, ?)');
        $stmt->execute([$name, $message]);

        // Redirect supaya refresh halaman tidak mengirim ulang form
        header('Location: index.php');
        exit;
    }
}

$messages = $pdo->query('SELECT * FROM messages ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu</title>
    <style>
        body   { font-family: sans-serif; max-width: 600px; margin: 40px auto; padding: 0 16px; }
        input, textarea { width: 100%; padding: 8px; margin-bottom: 12px; box-sizing: border-box; }
        button { padding: 8px 16px; cursor: pointer; }
        .error { color: #b00020; }
        .entry { border-bottom: 1px solid #ddd; padding: 12px 0; }
        .entry small { color: #777; }
    </style>
</head>
<body>
    <h1>Buku Tamu</h1>

    <?php foreach ($errors as $error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form method="post">
        <input type="text" name="name" placeholder="Nama"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        <textarea name="message" rows="4" placeholder="Pesan"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        <button type="submit">Kirim</button>
    </form>

    <h2>Pesan Pengunjung</h2>

    <?php if (!$messages): ?>
        <p>Belum ada pesan.</p>
    <?php endif; ?>

    <?php foreach ($messages as $row): ?>
        <div class="entry">
            <strong><?= htmlspecialchars($row['name']) ?></strong>
            <small><?= htmlspecialchars($row['created_at']) ?></small>
            <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>