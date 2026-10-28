<?php
require "config.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $pdo->prepare("UPDATE tasks SET is_done = 1 - is_done WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");