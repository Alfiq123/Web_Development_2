<?php

// Contoh 1
$buah[0] = "Nanas";
$buah[1] = "Mangga";
$buah[2] = "Jambu";

// Contoh 2
$buah[] = "Nanas";
$buah[] = "Mangga";
$buah[] = "Jambu";

// Contoh 3
$buah[] = array("Nanas", "Mangga", "Jambu");

for ($i=0; $i<count($buah); $i++ ) {
    echo "Indeks ke $i: $buah[0] <br>";
}

?>