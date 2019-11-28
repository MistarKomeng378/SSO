<?php
function rupiah($nilai, $pecahan = 0) {
    return number_format($nilai, $pecahan, ',', '.');
}
 
// konversi sederhana
// echo rupiah(500000); // akan tampil 500.000
// echo "<br/>";
 
// konversi dengan nilai pecahan
// 2 menandakan dua digit dibelakang koma
// echo rupiah(500000, 2) // akan tampil 500.000,00
?>