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
	include "../config/fungsi_bulan.php";
    
	
	$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));	
	$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));	
	
	
	
	//timeline($_SESSION['nik'],"download","Telah melakukan download Tunjangan Operasional Proyek Tahun $getTahun Bulan '".bulan($getBulan)."'");
			
		
		$isi ='
		<table width="100%" border="0" cellpadding="3">
			<tr>
				<td colspan="3"><img src="logo_KIT.png" width="150px" height=""></td>
			</tr>
			<tr>
				<td width="100%" align="center">
					<h3 align="center"> Perhitungan Tunjangan Operasional Proyek </h3> 
					<h3 align="center">	Bulan '.bulan($getBulan).' Tahun '.$getTahun.' </h3>
				</td>
			</tr>
				
		</table>	
		<br>
		<table width="100%" border="1" border="1" cellpadding="3">
			<tr align="center">
				<th width="10%">No.</th>
				<th width="20%">Kode Proyek</th>
				<th width="50%">Nama Proyek - Anggota</th>
				<th width="20%">Total TOP</th>
			</tr>';
			$query = mysql_query("SELECT * FROM proyek where tahun='$getTahun' AND bulan='$getBulan' order by nama_proyek ASC");	
			$i=1;			
			while($pro=mysql_fetch_array($query)){
			
			$isi.='
			<tr>
				<td align="center" >'.$i.'</td>
				<td align="center">'.$pro['kode_proyek'].'</td>
				<td ><b><u>'.$pro['nama_proyek'].'</u></b>';
					$all_top = 0;
					$h = mysql_query("SELECT * FROM anggota  INNER JOIN user ON anggota.nik = user.nik  
					WHERE id_proyek='$pro[id_proyek]' order by jabatan DESC");
					$xz = 1;
					while($P=mysql_fetch_array($h)){
						//Kompensasi Kebutuhan Komunikasi Yang Lebih Intensif
						if($P['jabatan']=="Project Manager"){
							$Ls = 150000;
							
						}elseif($P['jabatan']=="PMO"){
							$Ls = 100000;
							
						}elseif($P['jabatan']=="Lead/Site Manager/CO PM"){
							$Ls = 100000;
							
						}else{
							$Ls = 50000;
						}
						
						//Komunikasi Jika Lebih dari satu proyek
						if($P['aktif']==0){
							$Ls=0;
						}
						
						//Resiko Kerja
						$res = mysql_fetch_array(mysql_query("SELECT * FROM tbl_resiko where id='$pro[resiko_kerja]'"));
						if($pro['resiko_kerja']==$res['id']){
							$Resiko = $res['harga'];								
						}	
																		
						//Jarak Extra (liter)
						$jarak = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jarak where id='$pro[jarak_proyek]'"));
						
						//Harga Premium/liter/hari
						//$prem = 7000;
						if($pro['jarak_proyek']==$jarak['id']){
							$jarlok = $jarak['harga'];
						}
						
						// Jika Kerja Kurang dari 10 HK								
						if($P['hk'] < 10){
							$Resiko 	= 0;
							$Ls			= 0;
							$jarlok		= 0;
							$angka_sla	= 0;
							
						}else{
							
							$angka_sla	= 200000;
						}
						
						// Ketidak-nyamanan
						$Tn = $P['hk'] * $Resiko;
						
						//Total Harga Jarak
						$total_jarak = $P['hk'] * $jarlok;
														
						// Penilaian TIM Proyek							
						$sla = $Ls + $Tn + $total_jarak;
														
						//Jumlah Total Keseluruhan SLA
						$all_sla = mysql_fetch_array(mysql_query("SELECT SUM(sla) as jum_sla from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
						
						//Total Nilai (Rp.) Keseluruhan Rp. 200.000/orang
						$all_nominal = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_nik from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
						
						$nilai_rupiah = $all_nominal['jum_nik'] * 200000;
						
						//Total Nilai SLA 
						$nilai_sla = @($P['sla'] / $all_sla['jum_sla'] * $nilai_rupiah) ;
						
						//Total TOP /orang								
						$total_top = $sla + $nilai_sla ;
						
						// $all_top[]	= $total_top;
						$all_top		+= $total_top;
												
						$isi.='
							<br>&nbsp;
								'.$xz.'. '.$P['nik'].' - '.$P['name'].'
						';
						$xz++;
						
					}
					$sum_top = $all_top;
				
				
				$isi.='
				</td>
				<td><b><u>'.rupiah($sum_top).'</u></b>';
					$d = mysql_query("SELECT * FROM anggota  WHERE id_proyek='$pro[id_proyek]' order by jabatan DESC");
					$xy = 1;
					while($rin=mysql_fetch_array($d)){
						//Kompensasi Kebutuhan Komunikasi Yang Lebih Intensif
						if($rin['jabatan']=="Project Manager"){
							$Ls = 150000;
							
						}elseif($rin['jabatan']=="PMO"){
							$Ls = 100000;
							
						}else{
							$Ls = 50000;
						}
						
						//Komunikasi Jika Lebih dari satu proyek
						if($rin['aktif']==0){
							$Ls=0;
						}
						
						//Resiko Kerja
						$res = mysql_fetch_array(mysql_query("SELECT * FROM tbl_resiko where id='$pro[resiko_kerja]'"));
						if($pro['resiko_kerja']==$res['id']){
							$Resiko = $res['harga'];								
						}	
																		
						//Jarak Extra (liter)
						$jarak = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jarak where id='$pro[jarak_proyek]'"));
						
						//Harga Premium/liter/hari
						//$prem = 7000;
						if($pro['jarak_proyek']==$jarak['id']){
							$jarlok = $jarak['harga'];
						}
						
						// Jika Kerja Kurang dari 10 HK								
						if($rin['hk'] < 10){
							$Resiko 	= 0;
							$Ls			= 0;
							$jarlok		= 0;
							$angka_sla	= 0;
							
						}else{
							
							$angka_sla	= 200000;
						}
						
						// Ketidak-nyamanan
						$Tn = $rin['hk'] * $Resiko;
						
						//Total Harga Jarak
						$total_jarak = $rin['hk'] * $jarlok;
														
						// Penilaian TIM Proyek							
						$sla = $Ls + $Tn + $total_jarak;
														
						//Jumlah Total Keseluruhan SLA
						$all_sla = mysql_fetch_array(mysql_query("SELECT SUM(sla) as jum_sla from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
						
						//Total Nilai (Rp.) Keseluruhan Rp. 200.000/orang
						$all_nominal = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_nik from anggota where id_proyek='$pro[id_proyek]' AND tahun='$getTahun' AND bulan ='$getBulan'"));
						
						$nilai_rupiah = $all_nominal['jum_nik'] * 200000;
						
						//Total Nilai SLA 
						$nilai_sla = @($rin['sla'] / $all_sla['jum_sla'] * $nilai_rupiah) ;
						
						//Total TOP /orang								
						$total_top = $sla + $nilai_sla ;						
						
						$isi.='
							<br>&nbsp;
								'.$xy.'. '.rupiah($total_top).'
						';
						$xy++;
					}

				$isi.='
				</td>
			</tr>
				';
				$i++;
				
			}
			
						
		$isi.='
			
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
$pdf->SetMargins(5, 5, 5);
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