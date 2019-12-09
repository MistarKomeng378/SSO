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
	timeline($_SESSION['nik'],"download","Telah melakukan download Penilaian Prilaku ".name($getNik)." Tahun $getTahun");
														
	
	
		//$dt 	= mysql_fetch_array(mysql_query("SELECT DISTINCT divisi,nik,jabatan,penilai FROM penilaian_kerja where nik = '$getNik'"));
		$query = mysql_query("SELECT * FROM nilai_budaya WHERE nik='$getNik' AND tahun='$getTahun'");						
			$tnbud2		= 0;
			while($r2=mysql_fetch_array($query)){
				$dbud2 			= mysql_fetch_array(mysql_query("SELECT * FROM budaya WHERE id='$r2[id_budaya]'"));
				$jnbud2 		= $dbud2['bobot'] * $r2['nilai'];
				$tnbud2 		+= $jnbud2;						
			}						
			$total2	 			=$tnbud2;
		
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
						<font size="12"><u>REPORT PENILAIAN PRILAKU (BUDAYA KERJA) KARYAWAN</u></font><br>
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
				<td width="35%"><font size="12"><b>'.desimal_float($total2).'</b></font></td>
			</tr>
		</table>
		<br>
		<table width="100%" border="1" cellpadding="3">
			<tr align="center">
				<th height="30" width="10%" ><b>No.</b></th>
				<th colspan="2"  width="60%"><b>Prilaku</b></th>
				<th width="10%"><b>Bobot</b></th>
				<th width="10%"><b>Nilai</b></th>
				<th width="10%"><b>Jumlah</b></th>
			</tr>';
				$query = mysql_query("SELECT * FROM nilai_budaya WHERE nik='$getNik' AND tahun='$getTahun'");						
				$i=1;
				$tnbud		= 0;
				while($r=mysql_fetch_array($query)){
					$dbud 		= mysql_fetch_array(mysql_query("SELECT * FROM budaya WHERE id='$r[id_budaya]'"));
					$jnbud 		= $dbud['bobot'] * $r['nilai'];
					$tnbud 		+= $jnbud;
							
				$bgcolor = ($i % 2 == 0) ?  "#bfe5eb" : "white";
			$isi.='
			<tr bgcolor="'.$bgcolor.'">
				<td align="center">'.$i.'</td>
				<td><i>'.$dbud['prilaku'].'</i></td>
				<td>'.$dbud['ket'].'</td>
				<td align="center">'.$dbud['bobot'].'</td>
				<td align="center">'.$r['nilai'].'</td>
				<td align="center">'.$jnbud.'</td>
			</tr>
				';
				$i++;
			}
			
			// $jmlh_bobot = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as jmlh_bobot FROM penilaian_kerja where nik = '$getNik'"));
			$total	 	= $tnbud;	
			$isi.='
			
			<tr>
				<td colspan="2" align="right"><b>TOTAL</b></td>
				<td align="center">&nbsp;</td>
				<td align="center" colspan="2"><b></b></td>
				<td align="center"><b>'.desimal_float($total).'</b></td>
			</tr>	
		</table>
		
		<br>
		<br>
		<br>
		<table width="100%" border="1" cellpadding="3">			
			<tr align="center">
				<td width="3%"><b>No.</b></td>
				<td width="20%" align="center"><b>Menyetujui dan Mengetahui</b></td>
				<td width="10%"><b>NIK</b></td>
				<td width="27%"><b>Nama</b></td>
				<td width="20%"><b>Tanda Tangan</b></td>
				<td width="20%"><b>Tanggal</b></td>
			</tr>
			<tr>
				<td align="center">1.</td>
				<td height="25">Penilai</td>
				<td align="center"></td>
				<td></td>
				<td></td>				
				<td align="center"></td>
			</tr>
			<tr>
				<td align="center">2.</td>
				<td height="25">Karyawan Yang Dinilai</td>
				<td align="center">'.$getNik.'</td>
				<td> '.name($getNik).'</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td align="center">3.</td>
				<td height="25">Atasan Penilai</td>
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