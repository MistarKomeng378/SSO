<?php
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/encript.php";
	include "../config/fungsi_name.php";
	include "../config/fungsi_timeline.php";
	include "../config/fungsi_rupiah.php";
    
	$getNik		= mysql_real_escape_string(dc($_GET['nik']));
	$getCc		= mysql_real_escape_string(dc($_GET['CostCenter']));
	$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));	
	
	// $thn = mysql_fetch_array(mysql_query("SELECT * FROM tahun where tahun='".date('Y')."'"));
	// if($_COOKIE['tahun_srko']==""){
		// $getTahun 		= $thn['tahun'];
		// $idtahun_srko 	= $thn['id_tahun'];
	// }else{
		// $getTahun 		= $_COOKIE['tahun_srko'];
		// $idtahun_srko	= $_COOKIE['idtahun_srko'];
	// }
	
	
	$tahun	= mysql_fetch_array(mysql_query("SELECT tahun FROM tahun WHERE status='1'"));
	timeline($_SESSION['nik'],"download","Telah melakukan download Penilaian Kerja ".name($getNik)." Tahun $getTahun");
														
	
	
		//$dt 	= mysql_fetch_array(mysql_query("SELECT DISTINCT divisi,nik,jabatan,penilai FROM penilaian_kerja where nik = '$getNik'"));
		$query 	= mysql_query("SELECT * FROM penilaian_kerja where nik = '$getNik' AND tahun='$getTahun' ORDER BY tahun,id_penilaian");
			$i=1;
			while($z=mysql_fetch_array($query)){
				
				$pencapaian_2 	= ($z['hasil'] / $z['target'])*100;
				if($pencapaian_2 > 120){
					$pencapaian1 = 120;
				}else{
					$pencapaian1 = $pencapaian_2;
				}
							
				if($z['hasil']<=70){
					$skor = ($pencapaian1/70)*4.5;								
				}elseif($z['hasil']<=90){
					$skor = 4.5+(($pencapaian1-70)/20)*2;
				}elseif($z['hasil']<=100){
					$skor = 6.5+(($pencapaian1-90)/10)*2;
				}elseif($z['hasil']>100){
					$skor = 8.5+(($pencapaian1-100)/20)*1.5;
				}
				
				$sum_bobot_kar_1	= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='$getNik' AND tahun='$getTahun'"));	
				$bot_kar_1			= ($z['bobot'] / $sum_bobot_kar_1['sum_bobot'])*75;							
				$jum_bot1[] 		= $bot_kar_1;	
				
				$nilai				= $bot_kar_1* $skor;
				$jumlah_nilai1[]	= $nilai;
							
			}
			$jumlah_total_nilai1 = array_sum($jumlah_nilai1);
		
		$kar 	= mysql_fetch_array(mysql_query("select * from m_karyawan where regno  = '$getNik'")); 
		$jab 	= mysql_fetch_array(mysql_query("select * from m_jabatan where poscode = '".$kar['poscode']."'"));
		
		// if($_SESSION['level']==4){
			// $divisi = $_SESSION['cc'];
		// }elseif($_SESSION['level']==1){
			// $divisi = $_SESSION['cc'];
		// }else{
			// $divisi = $dt['divisi'];
		// }
		$div 	= mysql_fetch_array(mysql_query("select * from mskko where CostCenter  = '".$getCc."'"));		
					
		
		$isi ='
		<table width="100%" border="0" cellpadding="3">
			<tr>
				<td colspan="3"><img src="logo_KIT.png" width="200px" height=""></td>
			</tr>
			<tr>
				<td width="100%" align="center">
					<b>
						<font size="12"><u>REPORT PENILAIAN SASARAN KERJA KARYAWAN</u></font><br>
						PERIODE :  JANUARI - DESEMBER  &nbsp;TAHUN '.$getTahun.'
					</b>
				</td>
			</tr>
				
		</table>
		<table width="100%" border="0" cellpadding="3">		
			<tr>
				<td width="13%"><b>NIK / NAMA</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$getNik.' / '.name($getNik).'</td>
			</tr>
			<tr>
				<td width="13%"><b>JABATAN</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$jab['posdesc'].'</td>
			</tr>
			<tr>
				<td width="13%"><b>DIVISI</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$div['uraian'].' </td>
			</tr>
			<tr>
				<td width="13%"><b>HASIL KERJA</b></td>
				<td width="2%">:</td>
				<td width="35%"><font size="12"><b>'.desimal_float($jumlah_total_nilai1).'</b></font></td>
			</tr>
		</table>
		<br>
		<table width="100%" border="1" cellpadding="3">
			<tr align="center">
				<td width="3%" height="30"><b>No.</b></td>
				<td width="49%"><b>Sasaran / Rencana Kerja</b></td>
				<td width="8%"><b>Target</b></td>
				<td width="8%"><b>Bobot</b></td>
				<td width="8%"><b>Hasil</b></td>
				<td width="8%"><b>Pencapaian</b></td>
				<td width="8%"><b>Skor</b></td>
				<td width="8%"><b>Nilai</b></td>
			</tr>';
			$query = mysql_query("SELECT * FROM penilaian_kerja where nik = '$getNik' AND tahun='$getTahun' ORDER BY tahun,id_penilaian");
			$i=1;			
			while($r=mysql_fetch_array($query)){
				
				$pencapaian_1 	= ($r['hasil'] / $r['target'])*100;
				if($pencapaian_1 > 120){
					$pencapaian = 120;
				}else{
					$pencapaian = $pencapaian_1;
				}
							
				if($r['hasil']<=70){
					$skor = ($pencapaian/70)*4.5;								
				}elseif($r['hasil']<=90){
					$skor = 4.5+(($pencapaian-70)/20)*2;
				}elseif($r['hasil']<=100){
					$skor = 6.5+(($pencapaian-90)/10)*2;
				}elseif($r['hasil']>100){
					$skor = 8.5+(($pencapaian-100)/20)*1.5;
				}
								
				$sum_bobot_kar		= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot FROM penilaian_kerja where nik='$getNik' AND tahun='$getTahun'"));	
				$bot_kar			= ($r['bobot'] / $sum_bobot_kar['sum_bobot'])*75;							
				$jum_bot2[] 		= $bot_kar;	
				$nilai				= $bot_kar * $skor;
				$jumlah_nilai[]		= $nilai;
							
				$bgcolor = ($i % 2 == 0) ?  "#bfe5eb" : "white";
			$isi.='
			<tr bgcolor="'.$bgcolor.'">
				<td width="3%" align="center" $warna >'.$i.'.</td>
				<td width="49%">'.$r['rencana_kerja'].'</td>
				<td width="8%" align="center">'.$r['target'].'</td>
				<td width="8%" align="center">'.desimal_float($bot_kar).'</td>
				<td width="8%" align="center">'.desimal_float($r['hasil']).'</td>
				<td width="8%" align="center">'.desimal_float($pencapaian).'</td>
				<td width="8%" align="center">'.desimal_float($skor).'</td>
				<td width="8%" align="center">'.desimal_float($nilai).'</td>
			</tr>
				';
				$i++;
			}
			
			// $jmlh_bobot = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as jmlh_bobot FROM penilaian_kerja where nik = '$getNik'"));
			$jumlah_total_nilai = array_sum($jumlah_nilai);
			$jumlah_bobot	 	= array_sum($jum_bot2);	
			$isi.='
			
			<tr>
				<td colspan="2" align="right"><b>Total</b></td>
				<td><font size="10"></font></td>				
				<td align="center"><font size="10"><b>'.desimal_float($jumlah_bobot).'</b></font></td>
				<td colspan="3" ></td>
				<td align="center"><font size="10"><b>'.desimal_float($jumlah_total_nilai).'</b></font></td>
			</tr>
		</table>
		<font size="8"> Keterangan : <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<b>Bobot yang telah diinput dikonversikan secara otomatis menjadi 75</b> </font>
		<br>
		<br>
		<br>
		<br>
		<table width="100%" border="1" cellpadding="3">
			<tr align="center">
				<td width="20%" colspan="2">&nbsp;</td>
				<td width="40%" colspan="3"><b>Penyusun Sasaran Kerja</b></td>
				<td width="40%" colspan="3"><b>Penilaian Hasil Kerja</b></td>
			</tr>
			<tr align="center">
				<td width="3%"><b>No.</b></td>
				<td width="17%" align="center"><b>Menyetujui dan Mengetahui</b></td>
				<td width="5%"><b>NIK</b></td>
				<td width="18%"><b>Nama</b></td>
				<td width="17%"><b>Tanda Tangan dan Tanggal</b></td>
				
				<td width="5%"><b>NIK</b></td>
				<td width="18%"><b>Nama</b></td>
				<td width="17%"><b>Tanda Tangan dan Tanggal</b></td>
			</tr>
			<tr>
				<td align="center">1.</td>
				<td height="25">Penilai</td>
				<td align="center"></td>
				<td></td>
				<td></td>				
				<td align="center"></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td align="center">2.</td>
				<td height="25">Karyawan Yang Dinilai</td>
				<td align="center">'.$getNik.'</td>
				<td> '.name($getNik).'</td>
				<td></td>				
				<td align="center">'.$getNik.'</td>
				<td> '.name($getNik).'</td>
				<td></td>
			</tr>
			<tr>
				<td align="center">3.</td>
				<td height="25">Atasan Penilai</td>
				<td></td>
				<td></td>
				<td></td>				
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td align="center">4.</td>
				<td height="25">Pim. Tim/User (bila ada)</td>
				<td></td>
				<td></td>
				<td></td>				
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table width="100%" border="0">				
			<tr>
				<td align="center"><img src="rumus.jpg" size="100%"/> </td>
			</tr>
			
		</table>
		
		
		
		';
	
//=======blok untuk nampilin ke PDF======/
require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
		// Logo
        // $image_file = K_PATH_IMAGES.'logo.png';
        // $this->Image($image_file, 20, 20, 45, '', 'png', '', 'T', false, 280, '', false, false, 0, false, false, false);
        // Set font
        // $this->SetFont('helvetica', 'B', 20);
        // Title
       // $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	   
	   global $header1,$header2;
	   $this->SetFont('helvetica','B',9);
	   $this->writeHTML(($this->getPage()==2?$header1:''), true, false, true, false, '');
	   $this->SetFont('helvetica','B',9);
	   $this->writeHTML($header2, true, false, true, false, '');
	}

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-5);
        // Set font
        // $this->SetFont('helvetica', 'I', 5);
        // Page number
        // $this->Cell(0, 10, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
							}
						}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('');
$pdf->SetSubject('TCPDF');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_RIGHT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(10, 10, 10);
//$pdf->SetMargins(PDF_MARGIN_RIGHT, 18.8, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(5, PDF_MARGIN_TOP, 5); // margin kanan kiri
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// $pdf->SetLeftMargin(14);
// $pdf->SetTopMargin(9);
// $pdf->SetFont($fontname, '', '9');
// $pdf->setPrintHeader(false);
// $pdf->SetFooterMargin(0);
// $pdf->setPrintFooter(false)


//set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//margin TI FT
// $pdf->SetAutoPageBreak(TRUE, 13.6);

//margin FKIP PA-PBI-
// $pdf->SetAutoPageBreak(TRUE, 13.8);

//margin FKIP PKN
$pdf->SetAutoPageBreak(TRUE, 18.5);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// --------------------Blok Text-------------------------------//
// set font
$pdf->SetFont('helvetica', '', 9);


    // courier : Courier
    // courierb : Courier Bold
    // courierbi : Courier Bold Italic
    // courieri : Courier Italic
    // helvetica : Helvetica
    // helveticab : Helvetica Bold
    // helveticabi : Helvetica Bold Italic
    // helveticai : Helvetica Italic
    // symbol : Symbol
    // times : Times New Roman
    // timesb : Times New Roman Bold
    // timesbi : Times New Roman Bold Italic
    // timesi : Times New Roman Italic
    // zapfdingbats : Zapf Dingbats

//============================block kode meminta scrip php hasil===========================================/
// add a page 1
$pdf->AddPage();
$pdf->writeHTML($isi, true, false, true, false, '');
// add a page 1
// $pdf->AddPage();
// $pdf->writeHTML($isi2, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
// $pdf->Output('SRKK_'.$data_user['nama'].'_'.$tahun['tahun'].'.pdf', 'I');
$pdf->Output('SRKK.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
?>