<?php

$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height = (";
$jumlah_data = count($height);
$hitung_putaran = 0;

foreach ($height as $nama => $tinggi) {
    echo "\"" . $nama . "\"=>\"" . $tinggi . "\"";
    $hitung_putaran++; 
    if ($hitung_putaran < $jumlah_data) {
        echo ", ";
    }
}

echo ")<br>";
echo "nilai dengan indeks terakhir: " . $tinggi . "<br><br>";

unset($height["Barry"]);

echo "height = (";
$jumlah_data_baru = count($height); 

$hitung_putaran_baru = 0; 

foreach ($height as $nama => $tinggi) {
    echo "\"" . $nama . "\"=>\"" . $tinggi . "\"";
    $hitung_putaran_baru++; 
    if ($hitung_putaran_baru < $jumlah_data_baru) {
        echo ", ";
    }
}
echo ")<br>";

echo "nilai dengan indeks terakhir setelah dihapus: " . $tinggi . "<br>";
?>