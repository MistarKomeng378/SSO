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
	$nik	= mysql_real_escape_string(dc($ex[2]));
	$unit		= mysql_real_escape_string(dc($_GET['cc']));
	// $nik	= mysql_real_escape_string(dc($_GET['nik']));
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
						<font size="13">Data Kinerja Bulanan</font><br>
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
						<td width="7%"><b>Tanggal</b></td>
						<td width="7%"><b>Jam Mulai</b></td>
						<td width="8%"><b>Jam Selesai</b></td>
						<td width="6%"><b>Total Jam</b></td>
						<td width="6%"><b>CC</b></td>
						<td width="23%"><b>Aktifitas</b></td>
						<td width="25%"><b>Hasil Aktifitas</b></td>
						<td width="3%"><b>FK</b></td>
						<td width="6%"><b>Status</b></td>
						<td width="6%"><b>Progress</b></td>
					</tr>
				</thead>
				<tbody>';
				$query = mysql_query("SELECT DISTINCT	m_karyawan.`name` as nama,
														pencapaian.nik
														FROM
														pencapaian
														INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
														WHERE pencapaian.nik='$nik'
														ORDER BY pencapaian.id_pencapaian DESC");

				while($r=mysql_fetch_array($query)){
				$isi .='<tr>
						<td colspan="2" width="10%">';
						if(foto($nik)==""){
							$isi .='<img src="../assets/img/no_foto.png" alt="" width="80px" />';
						}else{
							$isi .='<img src="../upload/foto/'.foto($nik).'" alt="" width="80px"/>';
						}
						if($unit!=""){
							$notif = "Pekerjaan bulan ".bulan($bulan)." pada Cost Center $unit ";
						}else{
							// $notif = "Pekerjaan bulan ".bulan($bulan)." pada semua Cost Center";
							$notif = "";
						}
					$isi .='</td>
						<td colspan="9" width="90%">
							<br>
							<h4>'.$r['nik'].' /'.$r['nama'].'</h4>'.$notif.'
						</td>
					</tr>';
					if(!empty($unit)){
						$cc="AND pencapaian.cc='$unit' ";
						$query2 = mysql_query("SELECT 	m_karyawan.`name`as nama,
												pencapaian.id_pencapaian,
												pencapaian.nik,
												pencapaian.jo_gca,
												pencapaian.tgl_aktifitas,
												pencapaian.jam_mulai,
												pencapaian.jam_akhir,
												pencapaian.total_jam,
												pencapaian.total_menit,
												pencapaian.aktifitas,
												pencapaian.hasil_akhir,
												pencapaian.laporan,
												pencapaian.cc,
												pencapaian.faktor_k,
												pencapaian.progress,
												pencapaian.progress_lama,
												pencapaian.file,
												pencapaian.status,
												pencapaian.aprove,
												pencapaian.ket
												FROM
												pencapaian
												INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
												WHERE pencapaian.nik='$r[nik]' 
												AND  date_format( pencapaian.tgl_aktifitas, '%c %Y' ) = '$bulan $tahun' $cc
												AND pencapaian.status='1'
												ORDER BY pencapaian.tgl_aktifitas DESC");
					}else{
						$query2 = mysql_query("SELECT 	m_karyawan.`name`as nama,
												pencapaian.id_pencapaian,
												pencapaian.nik,
												pencapaian.jo_gca,
												pencapaian.tgl_aktifitas,
												pencapaian.jam_mulai,
												pencapaian.jam_akhir,
												pencapaian.total_jam,
												pencapaian.total_menit,
												pencapaian.aktifitas,
												pencapaian.hasil_akhir,
												pencapaian.laporan,
												pencapaian.cc,
												pencapaian.faktor_k,
												pencapaian.progress,
												pencapaian.progress_lama,
												pencapaian.file,
												pencapaian.status,
												pencapaian.aprove,
												pencapaian.ket
												FROM
												pencapaian
												INNER JOIN m_karyawan ON m_karyawan.regno = pencapaian.nik
												WHERE pencapaian.nik='$r[nik]' 
												AND  date_format( pencapaian.tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'
												AND pencapaian.status='1'
												ORDER BY pencapaian.tgl_aktifitas DESC");
					}
					
					$no=1;
					while($r2=mysql_fetch_array($query2)){
						if($r2['aprove']==0){
							$aprove="Proses";
						}elseif($r2['aprove']==1){
							$aprove="Open";
						}elseif($r2['aprove']==2){
							$aprove="Aproveed";
						}elseif($r2['aprove']==3){
							$aprove="Not Reported";
						}elseif($r2['aprove']==4){
							$aprove="Return";
						}
						$jam_mulai	= date('H:i', strtotime($r2['jam_mulai']));
						$jam_akhir	= date('H:i', strtotime($r2['jam_akhir']));
						$tgl_kerja	= date('d-m-Y', strtotime($r2['tgl_aktifitas']));
						if($r2['total_menit']>=30){
							$sisa_jam = 1;
						}else{
							$sisa_jam = 0;
						}
						$jumlah_jam	= $r2['total_jam']+$sisa_jam;
						
						
					$isi .='<tr >
							<td align="center" width="3%">'.$no.'</td>
							<td width="7%"><font color="blue">'.$tgl_kerja.'</font></td>
							<td width="7%"align="center">'.$jam_mulai.'</td>
							<td width="8%"align="center">'.$jam_akhir.'</td>
							<td width="6%" align="center">'.$r2['total_jam'].', '.$r2['total_menit'].'</td>
							<td  width="6%"><font color="blue">'.$r2['cc'].'</font></td>
							<td width="23%">'.$r2['aktifitas'].'</td>
							<td width="25%">'.$r2['hasil_akhir'].'</td>
							<td width="3%" align="center">'.$r2['faktor_k'].'</td>
							<td width="6%" align="center">'.$aprove.'</td>
							<td width="6%" align="center">'.$r2['progress'].' %</td>
							
						</tr>';
					$no++;
					// @$jum_jam +=$jumlah_jam;
					@$jum_jam +=$r2['total_jam'];
					@$jum_men +=$r2['total_menit'];
					}
					$totmen	= $jum_men/ 60;
					$totjam	= $jum_jam+$totmen;
					$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
					$isi .='<tr align="center">
							<td></td>
							<td><b>'.$jml_hari['jum_hari'].' Hari</b></td>
							<td colspan="2"></td>
							<td colspan="2"><b>'.desimal($totjam).' Jam</b></td>
							<td colspan="5"></td>
						</tr>';
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
$pdf->Output('Kinerja bulanan '.bulan($bulan).'.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
?>