<?php
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../config/fungsi_rupiah.php";
    include "../config/fungsi_bulan.php";
    include "../config/encript.php";
	include "../config/fungsi_name.php";
    include "../config/fungsi_timeline.php";
	
	$ex		= explode("-",$_GET['id']);
	$bulan	= mysql_real_escape_string(dc($ex[0]));
	$tahun	= mysql_real_escape_string(dc($ex[1]));
	$unit	= mysql_real_escape_string(dc($_GET['unit']));
	@$nik	= mysql_real_escape_string(dc($_GET['nik']));
	@$lastDay 	= cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	@$w = 63/$lastDay;
	timeline($_SESSION['nik'],"download","Telah melakukan download Summary KKWK $unit Bulan ".bulan($bulan)." Tahun $tahun");
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
						<font size="13">SUMMARY KKWK</font><br>
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
						<td width="3%"><b>No</b></td>
						<th width="5%"><b>NIK</b></th>
						<th width="17%"><b>Nama</b></th>';
							$day	= date("d");
							$no=1;
							$endDate=date("t",mktime(0,0,0,$bulan,$day,$tahun));
								for ($d=1;$d<=$endDate;$d++) { 
								$fontColor="#000000"; 
								if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sun") {
									$fontColor="red"; 
								}
								if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sat") {
									$fontColor="red"; 
									$bgcolor="red"; 
								}
									$liburaNas 		= mysql_fetch_array(mysql_query("SELECT * FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $bulan $tahun'"));
									$tgl_kerja	 	= date('Y-m-d', strtotime($tahun."-".$bulan."-".$d));
									$tglLibur		= $liburaNas['tanggal'];
									if($tgl_kerja == $tglLibur){
										$fontColor="red";
									}
									if($fontColor=="red"){
										$bgcolor="ffad99";
									}else{
										$bgcolor="";
									}
									$isi.='<td width="'.$w.'%" bgcolor="'.$bgcolor.'" align="center"><font color="'.$fontColor.'">'.$d.'</font></td>'; 
							}
				$isi .='
						<td width="3%"><b>Tot</b></td>
						<td width="3%"><b>Isi</b></td>
						<td width="3%"><b>Rt</b></td>
						<td width="3%"><b>RK</b></td>
					</tr>
				</thead>
				<tbody>';
						if(!empty($_GET['unit'])){
							$nik_manager = mysql_fetch_array(mysql_query("SELECT nik FROM v_manager WHERE CostCenter='$unit' "));
							$andunit="AND mskko.CostCenter='$unit' AND m_karyawan.regno!='$nik_manager[nik]'";
						}else{
							$andunit="";
						}
						if(!empty($_GET['nik'])){
							$andnik="AND m_karyawan.regno='$nik'";
						}else{
							$andnik="";
						}
						$query = mysql_query("SELECT m_karyawan.regno as nik,
													m_karyawan.`name`,
													m_karyawan.`status`,
													mskko.CostCenter AS cc,
													`user`.`level`
											FROM
													m_karyawan
											INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
											LEFT JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
											INNER JOIN `user` ON `user`.nik = m_karyawan.regno
											WHERE `user`.`level`!='2' 
											AND `user`.`level`!='3' 
											AND mskko.id !='1.6' 
											AND m_karyawan.regno NOT LIKE '%DM%' 
											AND m_karyawan.status='0' $andunit $andnik
											ORDER BY regno");
						$no =1;
						while($r=mysql_fetch_array($query)){
							
							$isi .='
								<tr>
									<td width="3%" align="center">'.$no.'</td>
									<td width="5%">'.$r['nik'].'</td>
									<td width="17%">'.$r['name'].'</td>';
									for ($d=1;$d<=$lastDay;$d++) { 
											$fontColor="#000000"; 
											if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sun") {
													$fontColor="#FF6347";
													$bgcolor="#ffad99";
													
												}else{
													$bgcolor="#b3ffb3";
												}
											if (date("D",mktime (0,0,0,$bulan,$d,$tahun)) == "Sat") {
													$fontColor="#FF6347";
													$bgcolor="#ffad99"; 
												}
											$liburaNas 		= mysql_fetch_array(mysql_query("SELECT * FROM libur_nasional WHERE date_format( tanggal, '%e %c %Y' ) = '$d $bulan $tahun'"));
											$tgl_kerja	 	= date('Y-m-d', strtotime($tahun."-".$bulan."-".$d));
											$tglLibur		= $liburaNas['tanggal'];
											if($tgl_kerja == $tglLibur){
												$fontColor="red";
												$bgcolor="#ffad99";
											}
											
											$wk = mysql_fetch_array(mysql_query("SELECT SUM(total_jam) as total_jam, SUM(total_menit) as total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%e %c %Y' ) = '$d $bulan $tahun'"));
											if($wk['total_menit']>=30){
												$sisa_jam = 1;
											}else{
												$sisa_jam = 0;
											}
											$jum_jam	= $wk['total_jam']+$sisa_jam;
											if($jum_jam>0){
												$jumlah_jam = $jum_jam;
											}else{
												$jumlah_jam = "";
											}
											$isi .='<td width="'.$w.'%" bgcolor="'.$bgcolor.'" align="center"><font color="'.$fontColor.'">'.$jumlah_jam.'</font></td>'; 
										
										}
											$jml_jam 	= mysql_query("SELECT total_jam,total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'");
											$jml_menit 	= mysql_fetch_array(mysql_query("SELECT sum(total_menit) as total_menit FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
											$jml_hari 	= mysql_fetch_array(mysql_query("SELECT count(DISTINCT tgl_aktifitas) as jum_hari FROM pencapaian WHERE nik='$r[nik]' AND date_format( tgl_aktifitas, '%c %Y' ) = '$bulan $tahun'"));
											while($jj=mysql_fetch_array($jml_jam)){
												if($jj['total_menit']>=30){
													$sisa_jam = 1;
												}else{
													$sisa_jam = 0;
												}
												$jum_jam	+= $jj['total_jam']+$sisa_jam;
											}
											if($jml_hari['jum_hari']==0){
												$rata		= 0;
											}else{
												$rata		= $jum_jam / $jml_hari['jum_hari'];
											}
											$hari_kerja	= mysql_fetch_array(mysql_query("SELECT hari_kerja as hari FROM jam_bulanan WHERE bulan='$bulan' AND tahun='$tahun'"));
											$rk			= $jum_jam / $hari_kerja['hari'];
							$isi .='
									<td width="3%" align="center"><b>'.$jum_jam.'</b></td>
									<td width="3%" align="center"><b>'.$jml_hari['jum_hari'].'</b></td>
									<td width="3%" align="center"><b>'.desimal($rata).'</b></td>
									<td width="3%" align="center" ><b>'.desimal($rk).'</b></td>	
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
$pdf->Output('Summary KKWK per Cost Center bulan '.bulan($bulan).'.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
?>