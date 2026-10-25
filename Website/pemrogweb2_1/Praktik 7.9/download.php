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
            <a href="upload.php">Upload</a>
            <a href="download.php" class="active">Download</a>
        </div>
        <div id="content">
            <h2>Download</h2>
            <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>

            <table class="table" width="100%" cellpadding="3" cellspacing="0">
                <tr>
                    <th width="30">No.</th>
                    <th width="80">Tgl. Upload</th>
                    <th>Nama File</th>
                    <th width="70">Tipe</th>
                    <th width="70">Ukuran</th>
                </tr>

                <?php
                include ("config.php");
                
                // PERBAIKAN 1: Gunakan mysqli_query dan sertakan variabel $koneksi
                $sql = mysqli_query($koneksi, "SELECT * FROM download ORDER BY id DESC");
                
                // PERBAIKAN 2: Ubah menjadi mysqli_num_rows
                if (mysqli_num_rows($sql) > 0){
                    $no = 1;
                    
                    // PERBAIKAN 3: Ubah menjadi mysqli_fetch_assoc
                    while ($data = mysqli_fetch_assoc($sql)){
                        echo "<tr bgcolor='#f0f0f0'>";
                        
                        // PERBAIKAN 4: Perbaikan string concatenation untuk variabel nomor ($no)
                        echo "<td align='center'>".$no."</td>";
                        
                        echo "<td align='center'>".$data["tanggal_upload"]."</td>";
                        echo "<td><a href='".$data["file"]."'>".$data["nama_file"]."</a></td>";
                        echo "<td align='center'>".$data["tipe_file"]."</td>";
                        echo "<td align='center'>".formatBytes($data["ukuran_file"])."</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr bgcolor='#f0f0f0'>";

                    // PERBAIKAN 5: Ubah colspan menjadi 5 agar pas dengan jumlah th di atas
                    echo "<td colspan='5' align='center'>Tidak ada data</td>";
                    echo '</tr>';
                }
                ?>

            </table>
        </div>
    </div>
</body>
</html>