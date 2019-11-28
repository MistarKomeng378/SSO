<?php
function rupiah($angka)
{
 @$jadi = "Rp " . number_format($angka,0,',','.');
return $jadi;
}

function desimal($nilai){
	$desimal= number_format((float)"$nilai",2,",",".");
	return $desimal;
}


function desimal2($nilai){
	$desimal= number_format("$nilai",0,",",".");
	return $desimal;
}

function desimal3($nilai){
	$desimal= number_format("$nilai",2,".",",");
	return $desimal;
}

function desimal4($nilai){
	$desimal= number_format((float)"$nilai",2,".",",");
	return $desimal;
}

function desimal_int($nilai){
	$desimal= number_format((int)"$nilai",2,",",".");
	return $desimal;
}

function desimal_float($nilai){
	$desimal= number_format((float)"$nilai",2,",",".");
	return $desimal;
}
// function rupiah($nilai, $pecahan = 0) {
    // return number_format($nilai, $pecahan, ',', '.');
// }
 
// konversi sederhana
// echo rupiah(500000); // akan tampil 500.000
// echo "<br/>";
 
// konversi dengan nilai pecahan
// 2 menandakan dua digit dibelakang koma
// echo rupiah(500000, 2) // akan tampil 500.000,00
?>