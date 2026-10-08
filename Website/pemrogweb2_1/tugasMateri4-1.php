<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi 4.1</title>
</head>
<body>
    <?php
    /*
        ## STRING ESCAPE SEQUENCE

        $a = "Groot: \"I Am Groot\"";       // Petik Dua
        $b = "Karakter \n NewLine";         // Newline
        $c = "Karakter \r Carriage Return"; // Carriage return
        $d = "Karakter \t Tab";             // Tab
        $e = "Karakter \\ Backslash";       // Backslash
        $f = "Karakter \$ Dollar Sign";     // Dollar Sign

        echo $a. "<br>";
        echo $b. "<br>";
        echo $c. "<br>";
        echo $d. "<br>";
        echo $e. "<br>";
        echo $f. "<br>";
    */

    /*
        ## HEREDOC

        $namaDepan = "Setia";
        $namaBelakang = "Abadi";

        $stringHeredoc = <<< end
            Saya adalah $namaDepan $namaBelakang
        end;

        echo $stringHeredoc;
    */

    /*
        ## NOWDOC

        $namaDepan = "Heru";
        $namaBelakang = "Santoso";

        $stringNowdoc = <<< 'end'
            Saya adalah $namaDepan $namaBelakang
            \n \r \t \\ \$ 'Petik Satu' "Petik DUa"
        end;

        echo $stringNowdoc;
    */

    /*
        ## GETTYPE()

        // $namaLengkap = "Fauzi Taufiq";
        $namaLengkap = "0";

        echo "Tipe data dan nilainya: ";
        var_dump($namaLengkap);

        echo "<br>";
        echo "Tipe Data: " .gettype($namaLengkap);
        echo "<br> Apakah di set?: " .(isset($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah empty?: " .(empty($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah null?: " .(is_null($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah string?: " .(is_string($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah array?: " .(is_array($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah numerik?: " .(is_numeric($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah integer?: " .(is_int($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah float?: " .(is_float($namaLengkap) ? "Ya" : "Tidak");
        echo "<br> Apakah boolean?: " .(is_bool($namaLengkap) ? "Ya" : "Tidak");


        $namaLengkap = "4nakin";
        $nilai = 5;
        $baru = $namaLengkap + $nilai;

        echo $baru ."<br>";

        echo "Tipe data dan nilainya: ";
        var_dump($baru);

        echo "<br>";
        echo "Tipe Data: " .gettype($baru);
        echo "<br> Apakah di set?: " .(isset($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah empty?: " .(empty($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah null?: " .(is_null($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah string?: " .(is_string($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah array?: " .(is_array($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah numerik?: " .(is_numeric($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah integer?: " .(is_int($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah float?: " .(is_float($baru) ? "Ya" : "Tidak");
        echo "<br> Apakah boolean?: " .(is_bool($baru) ? "Ya" : "Tidak");
    */

    /*
        ## SETTYPE()

        $namaLengkap = "Fauzi Taufiq";

        echo "Tipe data dan nilainya: ";
        var_dump($namaLengkap);

        echo "<br>";
        echo "Tipe Data: " .settype($namaLengkap, "int");
        echo "<br> Tipe Data: " .settype($namaLengkap, "bool");
        echo "<br> Tipe Data: " .settype($namaLengkap, "double");
        echo "<br> Tipe Data: " .settype($namaLengkap, "string");
        echo "<br> Tipe Data: " .settype($namaLengkap, "array");
        echo "<br> Tipe Data: " .settype($namaLengkap, "object");
        echo "<br> Tipe Data: " .settype($namaLengkap, "null");
    */

    /*
        ## CARA LAIN

        $namaLengkap = "Fauzi Taufiq";
        $namaLengkap = (float) $namaLengkap;

        echo $namaLengkap;
    */
    ?>
</body>
</html>