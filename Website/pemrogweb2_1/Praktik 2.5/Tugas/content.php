<div class="container">
    <h2>Selamat Datang di Halaman Utama</h2>
    <br>
    <p>Ini adalah bagian <b>Content</b> yang dipanggil secara modular menggunakan fungsi include pada PHP.</p>
    
    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">

    <h3>Topik Praktikum Hari Ini:</h3>
    <ul style="margin-left: 20px; margin-top: 10px; line-height: 1.8;">
        <?php
        // Menggunakan array sederhana (sesuai materi di PDF)
        $materi = ["Konsep Dasar Array", "Fungsi Built-in & UDF", "Modularisasi Halaman (Require & Include)"];
        foreach ($materi as $item) {
            echo "<li>$item</li>";
        }
        ?>
    </ul>

    <br>
    <div style="background-color: #e8f4fd; padding: 15px; border-left: 4px solid #3498db; border-radius: 4px;">
        <b>Keuntungan Modularisasi:</b> Tampilan header dan footer dibuat terpisah sehingga jika ada perubahan menu, kita cukup mengedit satu file saja.
    </div>
</div>