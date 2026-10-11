<?php

echo 'Array awal: ("A")<br>';
$ar1 = array("A");
array_push($ar1, "B");
echo 'Hasil array_push: ' . implode(" ", $ar1) . '<br><br>';


echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$ar2a = array("A", "B");
$ar2b = array("C");
$hasil_ar2 = array_merge($ar2a, $ar2b);
echo 'Hasil array_merge: ' . implode(" ", $hasil_ar2) . '<br><br>';

echo 'Array awal: ("x" => 1, "y" => 2)<br>';
$ar3 = array("x" => 1, "y" => 2);
$ar3_nilai = array_values($ar3);
echo 'Hasil array_values: ' . implode(" ", $ar3_nilai) . '<br><br>';


echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
$ar4 = array("A", "B", "C");
$ar_posisi = array_search("B", $ar4);
echo 'Hasil array_search: ' . $ar_posisi . '<br><br>';

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$ar5 = array(0, 1, false, 2, "", 3, "array");


$ar5_bersih = array_filter($ar5);
echo 'Hasil array_filter: ' . implode(" ", $ar5_bersih) . '<br><br>';



echo 'Array awal: (3, 1, 2)<br>';
$ar6 = array(3, 1, 2);

sort($ar6); 
echo 'Hasil sort: ' . implode(" ", $ar6) . '<br>';

rsort($ar6); 
echo 'Hasil rsort: ' . implode(" ", $ar6) . '<br><br>';


echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';
$ar7_asli = array("Peter"=>35, "Ben"=>37, "Joe"=>43);


function cetakAsosiatifKasar($array) {
    $teks = "";
    foreach($array as $nama => $umur) {
        $teks .= $nama . "=> " . $umur . ", ";
    }
    return $teks;
}

$ar7 = $ar7_asli;
asort($ar7); 
echo 'Hasil asort: ' . cetakAsosiatifKasar($ar7) . '<br>';

$ar7 = $ar7_asli;
ksort($ar7); 
echo 'Hasil ksort: ' . cetakAsosiatifKasar($ar7) . '<br>';

$ar7 = $ar7_asli;
arsort($ar7); 
echo 'Hasil arsort: ' . cetakAsosiatifKasar($ar7) . '<br>';

$ar7 = $ar7_asli;
krsort($ar7); 
echo 'Hasil krsort: ' . cetakAsosiatifKasar($ar7) . '<br>';



?>