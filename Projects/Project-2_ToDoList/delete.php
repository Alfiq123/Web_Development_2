<?php
require "config.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");