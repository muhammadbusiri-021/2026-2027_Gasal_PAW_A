<?php

$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

echo "weight = (";
$jumlah_data = count($weight);
$hitung_putaran = 0;

$data_kedua = ""; 

foreach ($weight as $nama => $berat) {
    $hitung_putaran++; 

    if ($hitung_putaran == 2) {
        $data_kedua = $berat; 
    }

    echo "\"" . $nama . "\"=>\"" . $berat . "\"";
    if ($hitung_putaran < $jumlah_data) {
        echo ", ";
    }
}
echo ")<br>";
echo "Data kedua: " . $data_kedua . "<br>";


?>