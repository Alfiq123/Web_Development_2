<?php

$str = "Belajar PHP ternyata Menyenangkan";

//Ubah huruf ke kecil semua
echo strtolower($str);
echo "<br>";

//Ubah huruf ke besar semua
echo strtoupper($str);
echo "<br>";

//Mengganti string
echo str_replace("Menyenangkan","mudah lho !!",$str);

?>
