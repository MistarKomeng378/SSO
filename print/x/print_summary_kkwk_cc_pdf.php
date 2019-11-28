<?php
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/fungsi_name.php";
    include "../config/encript.php";
    
	$ex		= explode("-",$_GET['id']);
	$bulan	= mysql_real_escape_string(dc($ex[0]));
	$tahun	= mysql_real_escape_string(dc($ex[1]));
	$cc	= mysql_real_escape_string(dc($_GET['cc']));
	// @$nik	= mysql_real_escape_string(dc($_GET['nik']));
	// @$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	// @$w = 63/$lastDay;
	
	if(empty($bulan)){
		$isi ='<h2>Tidak dapat menampilkan data';
	}else{
	
	$isi	='
	<table width="100%" border="0">
			<tr>
				<td colspan="3"><img src="logo_KIT.png" width="200px" height=""></td>
			</tr>
			<tr>
				<td width="30%"></td>
				<td width="40%" align="center">
					<b>
						<font size="13">SUMMARY KKWK Per COST CENTER</font><br>
						PERIODE :  '.bulan($bulan).' '.$tahun.'
					</b>
				</td>
				<td width="30%"></td>
			</tr>
		</table>
		<br>
		<table width="100%" border="1" cellpadding="2">
				<thead>
					<tr align="center">
						<th width="3%">No</th>
						<th width="7%">NIK</th>
						<th width="20%">Nama</th>
						<th width="11%">Cost Center</th>
						<th width="37%"></th>
						<th  width="12%">Total Waktu (Jam)</th>
						<th  width="10%">Presentase (%)</th>
					</tr>
				</thead>
				<tbody>';
						if(!empty($_GET['cc'])){
							$cc="AND (m_karyawan.dept='$cc' OR pencapaian.cc='$cc') ";
						}
						$query = mysql_query("SELECT DISTINCT	pencapaian.cc,
																pencapaian.nik,
																m_karyawan.dept
																FROM
																pencapaian
																LEFT JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
																WHERE pencapaian.nik!='' AND pencapaian.cc!='' $cc
																ORDER BY pencapaian.nik");
						$no =1;
						while($r=mysql_fetch_array($query)){
							$jml_cc 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as jam FROM pencapaian WHERE cc='$r[cc]' AND nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
							$jmlm_cc 	= mysql_fetch_array(mysql_query("SELECT SUM(total_menit) as menit FROM pencapaian WHERE cc='$r[cc]' AND nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
							
							$jml_bln 	= mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
							$jmlm_bln 	= mysql_fetch_array(mysql_query("SELECT SUM(total_menit) as menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
							
							$sisa_jam		= $jmlm_cc['menit']/60;
							$sisa_jam_bln	= $jmlm_bln['menit']/60;
							
							$total_jam		= $jml_cc['jam']+desimal2($sisa_jam);
							$total_jam_bln	= $jml_bln['total']+desimal2($sisa_jam_bln);
							
							if($total_jam_bln==0){
								$prosen		= 0;
							}else{
								$prosen			= ($total_jam/$total_jam_bln)*100;
							}
							$isi .='
								<tr>
									<td width="3%" align="center">'.$no.'</td>
									<td width="7%">'.$r['nik'].'</td>
									<td width="20%">'.name($r['nik']).'</td>
									<td width="11%">'.$r['cc'].'</td>
									<td width="37%"></td>
									<td width="12%" align="center">'.$total_jam.'</td>
									<td width="10%" align="center">'.desimal2($prosen).'</td>
								</tr>
							';
						$no++;
						}
		$isi .='</tbody>
					</table>';
	}
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
$pdf->SetMargins(PDF_MARGIN_RIGHT, 12, PDF_MARGIN_RIGHT);
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

$pdf->SetAutoPageBreak(TRUE, 12);

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
$pdf->Output('Summary KKWK bulan '.bulan($bulan).'.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
?>