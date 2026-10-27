<?php
require "config.php";

// CREATE: kalau form dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);

    if ($title !== "") {
        $stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (?)");
        $stmt->execute([$title]);
    }
    header("Location: index.php");
    exit;
}

// READ: ambil semua tugas
$tasks = $pdo->query("SELECT * FROM tasks ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
</head>
<body>
    <h1>To-Do List</h1>

    <form method="post">
        <input type="text" name="title" placeholder="Tugas baru..." required>
        <button type="submit">Tambah</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <span style="<?= $task["is_done"] ? "text-decoration: line-through;" : "" ?>">
                    <?= htmlspecialchars($task["title"]) ?>
                </span>
                <a href="toggle.php?id=<?= $task["id"] ?>">
                    <?= $task["is_done"] ? "Batal selesai" : "Selesai" ?>
                </a> |
                <a href="edit.php?id=<?= $task["id"] ?>">Edit</a> |
                <a href="delete.php?id=<?= $task["id"] ?>" onclick="return confirm("Hapus tugas ini?")">Hapus</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>