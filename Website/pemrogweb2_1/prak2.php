<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // Komentar
        # Komentar
        /* Komentar */

        echo "<p>Hello World></p>";
        echo "<p>Belajar PHP</p>";
        print "<p>Pemrograman Web 2</p>";

        $varKue = "Garlic Bread<br>";
        $varCoklat = "Dark Chocolate<br>";

        echo $varKue, $varCoklat;
        print $varCoklat;

        $varKue ? print "Ada" : print "Tidak Ada";
        echo $varKue ? "Ada" : "Tidak Ada";

        $hari = array("Senin", "Selasa");
        ?>
        <pre>
        <?php print_r ($hari); ?>
        </pre>
    ?>
</body>
</html>