<?php
include "config.php";

$username = $_POST["username"];
$password = md5($_POST["password"]);

$stmt = $koneksi->prepare(
    "SELECT * FROM user WHERE username = :username AND password = :password"
);

$stmt->execute([
    ":username" => $username,
    ":password" => $password
]);

$user = $stmt->fetch();

if ($user) {
    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["status"] = "login";
    header("location: admin/index.php");
    exit();
} else {
    header("location: index.php?pesan=gagal");
    exit();
}

// $login = mysqli_query(
//     $koneksi, 
//     "SELECT * FROM user WHERE username='$username' AND password='$password'"
// );
// $cek = mysqli_num_rows($login);

// if ($cek > 0) {
//     session_start();
//     $_SESSION['username'] = $username;
//     $_SESSION['status'] = "login";
//     header("location: admin/index.php");
// } else {
//     header("location: index.php?pesan=gagal");
// }

?>