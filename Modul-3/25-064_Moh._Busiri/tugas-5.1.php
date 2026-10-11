<?php

$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

echo "Data awal:<br>";
echo "students = (<br>";
$jumlah_baris = count($students);
$hitung_baris = 0;

foreach ($students as $baris_data) {
    echo "(\"" . $baris_data[0] . "\", \"" . $baris_data[1] . "\", \"" . $baris_data[2] . "\")";
    
    $hitung_baris++;
    if ($hitung_baris < $jumlah_baris) {
        echo ",";
    }
    echo "<br>";
}
echo ")<br><br>";

$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena", "220405", "0812345622");
$students[] = array("Fiona", "220406", "0812345633");
$students[] = array("Gabe", "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");


echo "Data setelah ditambah 5 data lain:<br>";
echo "students = (<br>";

$jumlah_baris_baru = count($students);
$hitung_baris_baru = 0;

foreach ($students as $baris_data) {
    echo "(\"" . $baris_data[0] . "\", \"" . $baris_data[1] . "\", \"" . $baris_data[2] . "\")";
    
    $hitung_baris_baru++;
    if ($hitung_baris_baru < $jumlah_baris_baru) {
        echo ",";
    }
    echo "<br>";
}
echo ")<br><br>";


echo "<table border='1'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";

foreach ($students as $baris_data) {
    echo "<tr>";
    echo "<td>" . $baris_data[0] . "</td>";
    echo "<td>" . $baris_data[1] . "</td>";
    echo "<td>" . $baris_data[2] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>