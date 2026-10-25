<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Upload dan Download File</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="container">
        <div id="header">
            <h1>Upload dan Download File</h1>
            <span>Univ Nusantara PGRI Kediri</span>
        </div>
        <div id="menu">
            <a href="index.php">Home</a>
            <a href="upload.php" class="active">Upload</a>
            <a href="download.php">Download</a>
        </div>
        <div id="content">
            <h2>Upload</h2>
            <p>
                Upload file Anda dengan melengkapi form di bawah ini. 
                File yang bisa di Upload hanya file dengan ekstensi 
                <b>.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</b> 
                dan besar file (file size) maksimal hanya 1 MB.
            </p>

            <?php
            include ("config.php");
            if (isset($_POST["upload"])) {
                $allowed_ext = array("doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "rar", "zip");
                $file_name  = $_FILES["file"]["name"];
                
                // PERBAIKAN 1: Pisahkan explode dan end agar tidak memicu warning strict standards
                $tmp_ext    = explode(".", $file_name);
                $file_ext   = strtolower(end($tmp_ext));
                
                $file_size  = $_FILES["file"]["size"];
                $file_tmp   = $_FILES["file"]["tmp_name"];

                $nama    = $_POST["nama"];
                $tanggal = date("Y-m-d");

                if (in_array($file_ext, $allowed_ext) === true){
                    if ($file_size < 1044070){
                        $lokasi = "files/".$nama.".".$file_ext;
                        
                        // Proses memindahkan file fisik ke folder
                        if (move_uploaded_file($file_tmp, $lokasi)) {
                            
                            // PERBAIKAN 2: Tambahkan variabel $koneksi pada mysqli_query
                            $in = mysqli_query($koneksi, "INSERT INTO download VALUES(NULL, '$tanggal', '$nama', '$file_ext', '$file_size', '$lokasi')");
                            
                            if ($in){
                                echo "<div class='ok'>SUCCESS: File berhasil di Upload!</div>";
                            } else {
                                // Membantu melihat error sql jika query gagal
                                echo "<div class='error'>ERROR: Gagal simpan ke database! " . mysqli_error($koneksi) . "</div>";
                            }
                        } else {
                            echo "<div class='error'>ERROR: Gagal memindahkan file ke folder tujuan!</div>";
                        }
                    } else {
                        echo "<div class='error'>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>";
                    }
                } else {
                    echo "<div class='error'>ERROR: Ekstensi file tidak di izinkan!</div>";
                }
            }
            ?>


            <form action="" method="post" enctype="multipart/form-data">
                <table width="100%" align="center" border="0" bgcolor="#eee" cellpadding="2" cellspacing="0">
                    <tr>
                        <td width="40%" align="right"><b>Nama File :</b></td>
                        <td><input type="text" name="nama" size="40" required /></td>
                    </tr>
                    <tr>
                        <td width="40%" align="right"><b>Pilih File :</b></td>
                        <td><input type="file" name="file" required /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="upload" value="Upload" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>