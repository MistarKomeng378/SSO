<?php
function bulan($bulan)
{
Switch ($bulan){
    case 01 : $bulan="JANUARI";
        Break;
    case 02 : $bulan="FEBRUARI";
        Break;
    case 03 : $bulan="MARET";
        Break;
    case 04 : $bulan="APRIL";
        Break;
    case 05 : $bulan="MEI";
        Break;
    case 06 : $bulan="JUNI";
        Break;
    case 07 : $bulan="JULI";
        Break;
    case 08 : $bulan="AGUSTUS";
        Break;
    case 09 : $bulan="SEPTEMBER";
        Break;
    case 10 : $bulan="OKTOBER";
        Break;
    case 11 : $bulan="NOVEMBER";
        Break;
    case 12 : $bulan="DESEMBER";
        Break;
    }
return $bulan;
}
?>