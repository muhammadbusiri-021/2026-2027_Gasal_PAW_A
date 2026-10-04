<?php
// tugas 1

$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];
$praktikum = ["JARKOM", "PAW"];

for ($i = 0; $i < count($matkul); $i++) {
    if ($matkul[$i] == "JARKOM" || $matkul[$i] == "PAW") {
        echo "Saya sedang mengambil matkul $matkul[$i] termasuk praktikumnya<br>";
    } elseif ($i == 6 || $i == 7) {
        echo "Saya belum mengambil matkul $matkul[$i] <br>";
    } else {
        echo "Saya sudah mengambil matkul $matkul[$i] semester lalu<br>";
    }
}
?>
