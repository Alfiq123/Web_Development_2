<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi 4.2</title>
</head>
<body>
    <?php
    /*
        ## OPERATOR LOGIKA

        $benar = "Benar";
        $salah = "Salah";

        echo !$benar xor !$benar;
        echo var_dump(!$benar xor !$benar);
        echo (!$benar xor !$benar) ? "Benar" : "Salah";

        echo "<br>";

        echo !$salah xor !$salah;
        echo var_dump(!$salah xor !$salah);
        echo (!$salah xor !$salah) ? "Benar" : "Salah";

        echo "<br>";

        echo !$benar xor !$salah;
        echo var_dump(!$benar xor !$salah);
        echo (!$benar xor !$salah) ? "Benar" : "Salah";

        echo "<br>";

        echo !$salah xor !$salah;
        echo var_dump(!$salah xor !$salah);
        echo (!$salah xor !$salah) ? "Benar" : "Salah";
    */

    /*
        ## CONTOH 1 OPERATOR LOGIKA

        $cobaA = (true and false);
        echo var_dump($cobaA)."<br>";

        $cobaB = true and false;
        echo var_dump($cobaB)."<br>";
    */

    /*
        ## CONTOH 2 OPERATOR LOGIKA

        $cobaC = (true or true && false);
        echo var_dump($cobaC)."<br>";

        $cobaD = (true and true) && false;
        echo var_dump($cobaD)."<br>";
    */

    /*
        ## OPERATOR ARITMATIKA

        $x = 10;
        $y = 5;

        echo $x + $y ."<br>";
        echo $x - $y ."<br>";
        echo $x * $y ."<br>";
        echo $x / $y ."<br>";
        echo $x % $y ."<br>";
        echo $x ** $y ."<br>";

        echo $z = 10 - 5 * 4 ."<br>";
    */

        ## INCREMENT DECREMENT

        echo "<h3>Postincrement</h3>";
        $a = 5;
        echo "\$a = $a <br />";
        echo "\$a akan bernilai 5: " . $a++ . " (\$a++)<br />";
        echo "\$a akan bernilai 6: " . $a . "<br />";

        echo "<h3>Preincrement</h3>";
        $a = 5;
        echo "\$a = $a <br />";
        echo "\$a akan bernilai 6: " . ++$a . " (++\$a)<br />";
        echo "\$a akan bernilai 6: " . $a . "<br />";

        echo "<h3>Postdecrement</h3>";
        $a = 5;
        echo "\$a = $a <br />";
        echo "\$a akan bernilai 5: " . $a-- . " (\$a--)<br />";
        echo "\$a akan bernilai 4: " . $a . "<br />";

        echo "<h3>Predecrement</h3>";
        $a = 5;
        echo "\$a = $a <br />";
        echo "\$a akan bernilai 4: " . --$a . " (--\$a)<br />";
        echo "\$a akan bernilai 4: " . $a . "<br />";
    ?>
</body>
</html>