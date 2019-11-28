<?php
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/encript.php";
	include "../config/fungsi_name.php";
	include "../config/fungsi_timeline.php";
    
	$getNik	= mysql_real_escape_string(dc($_GET['nik']));
	$query = mysql_query("SELECT	srkk.nik,
									srkk.id_srko,
									srkk.id_gca,
									srkk.bobot,
									srkk.nilai,
									wbs.aktivitas
									FROM
									srkk
									INNER JOIN wbs ON srkk.id_gca = wbs.id 
									 WHERE srkk.nik='$getNik'");
	$data_user = mysql_fetch_array(mysql_query("SELECT
														m_jabatan.posdesc as jabatan,
														mskko.uraian as unit,
														m_karyawan.regno as nik,
														m_karyawan.`name` as nama
														FROM
														m_karyawan
														INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
														LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
														WHERE m_karyawan.regno='$getNik' "));
	$tahun	= mysql_fetch_array(mysql_query("SELECT tahun FROM tahun WHERE status='1'"));
	timeline($_SESSION['nik'],"download","Telah melakukan download SRKK ".name($getNik)." Tahun $tahun[tahun]");
	
	$isi ='
		<table width="100%" border="0">
			<tr>
				<td colspan="3"><img src="logo_KIT.png" width="200px" height=""></td>
			</tr>
			<tr>
				<td width="30%"></td>
				<td width="40%" align="center">
					<b>
						<font size="13">SASARAN /RENCANA KERJA KARYAWAN</font><br>
						PERIODE :  Jan - Desember '.$tahun['tahun'].'
					</b>
				</td>
				<td width="30%"></td>
			</tr>
		</table>
		<br>
		<table width="100%" border="0" cellpadding="3">
			<tr>
				<td width="13%"><b>Nama</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$data_user['nama'].'</td>
				<td width="15%"><b>Unit</b></td>
				<td width="2%">:</td>
				<td width="33%">'.$data_user['unit'].'</td>
			</tr>
			<tr>
				<td width="13%"><b>NIK</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$data_user['nik'].'</td>
				<td width="15%"><b>Jabatan</b></td>
				<td width="2%">:</td>
				<td width="33%">'.$data_user['jabatan'].'</td>
			</tr>
		</table>
		<br>
		<table width="100%" border="1" cellpadding="3">
			<tr align="center">';
		if($_GET['lvl']==4){
			$isi .='<th width="3%" rowspan="2"><b>No.</b></th>
					<th rowspan="2" width="20%"><b>Rencana Kerja</b></th>
					<th rowspan="2" width="6%"><b>Bobot Awal</b></th>
					<th rowspan="2" width="6%"><b>Bobot Konversi</b></th>
					<th rowspan="2" width="6%"><b>Target Tahunan</b></th>
					<th colspan="12" width="60%"><b>Target Bulanan</b></th>';
		}else{
			$isi .='<th width="3%" rowspan="2"><b>No.</b></th>
					<th width="25%"rowspan="2"><b>Rencana Kerja</b></th>
					<th width="6%" rowspan="2"><b>Bobot</b></th>
					<th width="6%" rowspan="2"><b>Target Tahunan</b></th>
					<th width="60%" colspan="12"><b>Target Bulanan</b></th>';
		}
	$isi .='</tr>
		<tr>';
		for($b=1;$b<=12;$b++){
			$isi .='<th width="5%" align="center"><b>'.$b.'</b></th>';
		}
	$isi .='</tr>';
	$no=1;
	if($_GET['lvl']==4){
		while($r=mysql_fetch_array($query)){
			$target = mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE id_srko='$r[id_srko]'"));
			$nilai	= mysql_fetch_array(mysql_query("SELECT * FROM srkk_prioritas WHERE nilai='$r[nilai]'"));
	$isi .='<tr>
				<td align="center">'.$no.'</td>
				<td>'.$r['aktivitas'].'</td>
				<td align="center">'.$target['bobot'].'</td>
				<td align="center">'.desimal($r['bobot']).'</td>
				<td>'.$target['target'].' '.$target['satuan'].'</td>';
				for($b=1;$b<=12;$b++){
					$bulanan	= mysql_fetch_array(mysql_query("SELECT * FROM target_srko WHERE bulan='$b' AND id_srko='$r[id_srko]' "));
					$isi .='<td align="center">'.$bulanan['target'].'</td>';
				}
	$isi .='</tr>';
			$no++;
		}
		$totbot = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as jum FROM srkk WHERE nik='$getNik'"));
		$isi .='
		<tr>
			<td colspan="2" align="center"><b>Total</b></td>
			<td></td>
			<td align="center">'.desimal($totbot['jum']).'</td>
			<td colspan="13"></td>
		</tr>
			';
	}else{
		while($r=mysql_fetch_array($query)){
		$target = mysql_fetch_array(mysql_query("SELECT * FROM srko WHERE id_srko='$r[id_srko]'"));
		$isi .='<tr>
				<td align="center">'.$no.'</td>
				<td>'.$r['aktivitas'].'</td>
				<td align="center">'.desimal($r['bobot']).'</td>
				<td align="center">'.$target['target'].' '.$target['satuan'].'</td>';
				for($b=1;$b<=12;$b++){	
					$bulanan	= mysql_fetch_array(mysql_query("SELECT * FROM srkk_bulanan WHERE bulan='$b' AND nik='$r[nik]' AND id_gca='$r[id_gca]' "));
					$isi .='<td align="center">'.desimal($bulanan['prosen']).'</td>';
				}
		$isi .='
			</tr>';
			$no++;
			// $totalBobot += $r['bobot'];
		}
		$totbot = mysql_fetch_array(mysql_query("SELECT SUM(bobot) as jum FROM srkk WHERE nik='$getNik'"));
			$isi .='
			<tr>
				<td colspan="2" align="center"><b>Total</b></td>
				<td align="center">'.desimal($totbot['jum']).'</td>
				<td colspan="13"></td>
			</tr>
			';
	}
	
	$isi .='
	</table>
	<br>
	<table width="100%" border="0" cellpadding="0">
		<tr>
			<td width="30%"></td>
			<td width="70%">
				<table width="100%" border="1" cellpadding="3">
					<tr align="center">
						<td><b>Menyetujui dan Mengetahui</b></td>
						<td><b>Nama Jelas</b></td>
						<td><b>Tanggal</b></td>
						<td><b>Tanda Tangan</b></td>
					</tr>
					<tr>
						<td><b> Penilai</b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><b> Karyawan yang dinilai</b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</td>
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
$pdf->SetMargins(PDF_MARGIN_RIGHT, 18.8, PDF_MARGIN_RIGHT);
// $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
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