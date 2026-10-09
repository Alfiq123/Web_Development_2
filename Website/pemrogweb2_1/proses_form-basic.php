<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Form Basic</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #222;
        }
        .card {
            background: #fff;
            width: 100%;
            max-width: 380px;
            padding: 32px 28px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
        }
        h1 { font-size: 20px; font-weight: 600; margin-bottom: 20px; }
        .row { font-size: 14px; padding: 10px 0; border-top: 1px solid #eee; }
        .row span { display: block; color: #666; font-size: 12px; margin-bottom: 2px; }
        a { display: inline-block; margin-top: 20px; font-size: 14px; color: #111; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Hasil Form</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "<p>Silakan isi form terlebih dahulu.</p>";
        } else {
            $nama = isset($_POST["nama"]) ? trim($_POST["nama"]) : "";
            $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
            $password = isset($_POST["password"]) ? $_POST["password"] : "";

            $nama = htmlspecialchars($nama, ENT_QUOTES, "UTF-8");
            $email = htmlspecialchars($email, ENT_QUOTES, "UTF-8");

            if ($nama === "" || $email === "" || $password === "") {
                echo "<p>Semua field wajib diisi.</p>";
            } else {
                echo '<div class="row"><span>Nama</span>' . $nama . '</div>';
                echo '<div class="row"><span>Email</span>' . $email . '</div>';
                echo '<div class="row"><span>Password</span>•••••••• (' . strlen($password) . ' karakter)</div>';
            }
        }
        ?>
        <a href="form-basic.html">&larr; Kembali ke form</a>
    </main>
</body>
</html>
