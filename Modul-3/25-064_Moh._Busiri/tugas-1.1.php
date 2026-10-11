<?php

$fruits = array("Avocado","Blueberry","Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo "fruits = (";

$panjang_array = count($fruits);

for ($i = 0; $i < $panjang_array; $i++) {
    echo "\"" . $fruits[$i] . "\"";
    if ($i < $panjang_array - 1) {
        echo ", ";
    }
}
echo ")<br>";

$indeks_tertinggi = $panjang_array - 1;
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeks_tertinggi];
?>