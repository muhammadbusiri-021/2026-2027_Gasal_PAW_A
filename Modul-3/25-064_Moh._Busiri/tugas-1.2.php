<?php 

$fruits = array("Avocado","Blueberry","Cherry");
$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

$buah_yang_dihapus = $fruits[1];

unset($fruits[1]);
echo "Data $buah_yang_dihapus dihapus.<br>";


echo "fruits = (";
$jumlah_data = count($fruits);

$hitung_putaran = 0;

foreach ($fruits as $buah) {
    echo "\"" . $buah . "\"";
    $hitung_putaran++; 

    if ($hitung_putaran < $jumlah_data) {
        echo ", ";
    }
}
echo ")<br>";

$buah_terakhir = $fruits[$jumlah_data];

echo "nilai dengan indeks tertinggi: " . $buah_terakhir . "<br>";
 ?>