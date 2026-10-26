<?php

// Deklarasi nama fungsi dengan 2 parameter
function psgpjg($pjg, $lbr){
    $luas = $pjg * $lbr;
    return $luas;
}

// Deklarasi var dengan value
$bil_1=5;
$bil_2=3;

// Penampilan pesan
echo "Luas persegi panjang dengan panjang $bil_1 dan lebar $bil_2 = ".psgpjg($bil_1,$bil_2);

?>