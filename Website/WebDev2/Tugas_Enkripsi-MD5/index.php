<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Form Validasi dengan Javascript - WWW.MALASNGODING.COM</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h2 style="margin-top: 100px; text-align: center;">TEKNIK INFORMATIKA</h2>
    <h2 style="text-align:center">UNIVERSITAS NUSANTARA PGRI KEDIRI</h2>
    <div class="login">
        <form action="login.php" method="post" onSubmit="return validasi()">
            <div>
                <label>Username:</label> <br />
                <input type="text" name="username" id="username" />
            </div>
            <br />
            <div>
                <label>Password:</label> <br />
                <input type="password" name="password" id="password" />
            </div>
            <br />
            <div>
                <input type="submit" value="Login" class="tombol">
            </div>
        </form>
    </div>
</body>

<script type="text/javascript">
    function validasi() {
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;
        if (username != "" && password != "") {
            return true;
        } else {
            alert("Username dan Password harus di isi !");
            return false;
        }
    }
</script>

</html>