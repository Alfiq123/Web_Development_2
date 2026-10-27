<?php
require "config.php";

$id = (int) ($_GET["id"] ?? 0);

// Proses simpan perubahan
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);

    if ($title !== "") {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ? WHERE id = ?");
        $stmt->execute([$title, $id]);
    }
    header("Location: index.php");
    exit;
}

// Ambil data lama untuk ditampilkan di form
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Tugas tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
</head>
<body>
    <h1>Edit Tugas</h1>
    <form method="post">
        <input type="text" name="title" value="<?= htmlspecialchars($task["title"]) ?>" required>
        <button type="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>