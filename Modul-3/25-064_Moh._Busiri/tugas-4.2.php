<?php

$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

$kunci_nama = array_keys($weight); 
$panjang_array = count($kunci_nama);

echo "weight = (";
for ($i = 0; $i < $panjang_array; $i++) {
    $nama = $kunci_nama[$i]; 
    $berat = $weight[$nama]; 

    echo "\"" . $nama . "\"=>\"" . $berat . "\"";
    
    if ($i < $panjang_array - 1) {
        echo ", ";
    }
}
echo ")<br><br>";

for ($i = 0; $i < $panjang_array; $i++) {
    $nama = $kunci_nama[$i];
    $berat = $weight[$nama];
    
    echo $nama . " is " . $berat . " kg.<br>";
}

?>