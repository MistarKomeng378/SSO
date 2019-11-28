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
    
	$IdProyek		= mysql_real_escape_string(dc($_GET['idp']));
	$cc		= mysql_real_escape_string(dc($_GET['CostCenter']));
	$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));	
	$getBulan	= mysql_real_escape_string(dc($_GET['bulan']));	
	
	$DetProyek	= mysql_fetch_array(mysql_query("SELECT * FROM proyek where id_proyek='$IdProyek'"));
	$CostCenter = mysql_fetch_array(mysql_query("SELECT CostCenter, uraian FROM mskko where CostCenter = '$cc' "));
	
	
	timeline($_SESSION['nik'],"download","Telah melakukan download Tunjangan Operasional Proyek $DetProyek[nama_proyek] Tahun $getTahun");
			
		
		$isi ='
		<table width="100%" border="0" cellpadding="3">
			<tr>
				<td colspan="3"><img src="logo_KIT.png" width="150px" height=""></td>
			</tr>
			<tr>
				<td width="100%" align="center">
					<b>
						<font size="10">TUNJANGAN OPERASIONAL PROYEK (TOP)</font><br>
					</b>
				</td>
			</tr>
				
		</table>
		<table width="100%" border="0" cellpadding="3">		
			<tr>
				<td width="13%"><b>Nama Proyek</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$DetProyek['nama_proyek'].'</td>
			</tr>
			<tr>
				<td width="13%"><b>Lokasi Proyek</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$DetProyek['lokasi_proyek'].'</td>
			</tr>
			<tr>
				<td width="13%"><b>Cost Center</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$CostCenter['uraian'].' </td>
			</tr>
			<tr>
				<td width="13%"><b>Tahun</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$DetProyek['tahun'].'</td>
			</tr>
			<tr>
				<td width="13%"><b>Bulan</b></td>
				<td width="2%">:</td>
				<td width="35%">'.bulan($DetProyek['bulan']).' </td>
			</tr>
		</table>
		<br>
		<table width="100%" border="1" cellpadding="3">
			<tr align="center">
				<th width="3%">No.</th>
				<th width="4%">NIK</th>
				<th width="11%">Nama Anggota</th>
				<th width="9%">Jabatan Proyek</th>
				<th width="4%">Jumlah hari Kerja</th>
				<th width="4%">Rp. Extra Transport (ltr)</th>
				<th width="4%">Harga Premium/Hari</th>
				<th width="7%">Lumpsum RP/Bulan</th>
				<th width="5%">Rp. tidak nyaman</th>
				<th width="6%">Kompensasi Tranportasi Ekstra ke Lokasi Proyek</th>
				<th width="7%">Kompensasi Kebutuhan Komunikasi yang lebih Intensif</th>
				<th width="7%">Kompensasi Akibat Ketidak-nyamanan diarea kerja</th>
				<th width="4%">Penilaian Tim Proyek</th>
				<th width="7%">Total Tunjangan Operasional Proyek (Rp.)</th>
				<th width="4%">SLA</th>
				<th width="7%">Total Nilai SLA (Rp.)</th>
				<th width="7%">Total Tunjangan Operasional Proyek (Rp.) dan SLA</th>
		</tr>';
			$query = mysql_query("SELECT * FROM anggota INNER JOIN  user ON anggota.nik = user.nik
								WHERE anggota.id_proyek='$IdProyek' 
								AND anggota.tahun='$getTahun' 
								AND anggota.bulan='$getBulan' 
								AND anggota.cc='$cc' 
								ORDER BY anggota.jabatan DESC");
			$i=1;
			$all_top = 0;			
			while($r=mysql_fetch_array($query)){
			
			//Kompensasi Kebutuhan Komunikasi Yang Lebih Intensif
			if($r['jabatan']=="Project Manager"){
				$Ls = 150000;
				
			}elseif($r['jabatan']=="PMO"){
				$Ls = 100000;
				
			}elseif($r['jabatan']=="Lead/Site Manager/CO PM"){
				$Ls = 100000;
				
			}else{
				$Ls = 50000;
			}
			
			//Komunikasi Jika Lebih dari satu proyek
			if($r['aktif']==0){
				$Ls=0;
			}
											
			
			//Kompensasi Akibat Ketidak-nyamanan di Area Kerja
			$proyek = mysql_fetch_array(mysql_query("SELECT * FROM proyek where id_proyek='$IdProyek'"));
			
			$res = mysql_fetch_array(mysql_query("SELECT * FROM tbl_resiko where id='$proyek[resiko_kerja]'"));
			if($proyek['resiko_kerja']==$res['id']){
				$Resiko = $res['harga'];								
			}				

					
		
			
			//Jarak Extra (liter)
			$jarak = mysql_fetch_array(mysql_query("SELECT * FROM tbl_jarak where id='$proyek[jarak_proyek]'"));
			
			//Harga Premium/liter/hari
			//$prem = 7000;
			if($proyek['jarak_proyek']==$jarak['id']){
				$jarlok = $jarak['harga'];
			}
			
			// Jika Kerja Kurang dari 10 HK								
			if($r['hk'] < 10){
				$Resiko 	= 0;
				$Ls			= 0;
				$jarlok		= 0;
				$angka_sla	= 0;
				
			}else{
				$angka_sla	= 200000;
			}
			
			
			// Ketidak-nyamanan
			$Tn = $r['hk'] * $Resiko;
			
			//Total Harga Jarak
			$total_jarak = $r['hk'] * $jarlok;
			
											
			// Penilaian TIM Proyek							
			$sla = $Ls + $Tn + $total_jarak;
			
											
			//Jumlah Total Keseluruhan SLA
			$all_sla = mysql_fetch_array(mysql_query("SELECT SUM(sla) as jum_sla from anggota where id_proyek='$IdProyek' AND tahun='$getTahun' AND bulan ='$getBulan'"));
			
			
			//Total Nilai (Rp.) Keseluruhan Rp. 200.000/orang
			$all_nominal = mysql_fetch_array(mysql_query("SELECT COUNT(nik) as jum_nik from anggota where id_proyek='$IdProyek' AND tahun='$getTahun' AND bulan ='$getBulan'"));
			
			$nilai_rupiah = $all_nominal['jum_nik'] *$angka_sla;
			
			
			//Total Nilai SLA 
			$nilai_sla = @($r['sla'] / $all_sla['jum_sla'] * $nilai_rupiah) ;
			
			
			//Total TOP /orang								
			$total_top = $sla + $nilai_sla ;
			
			$all_top	+= $total_top;
			//$all_top[]	= $total_top;
			
			$isi.='
			<tr>
				<td align="center">'.$i.'</td>
					<td align="center">'.$r['nik'].'</td>
					<td>'.$r['name'].'</td>
					<td>'.$r['jabatan'].' ('.$r['ket_jabatan'].')</td>
					<td>'.$r['hk'].'</td>
					<td>'.desimal($jarak['liter']).'</td>
					<td>'.desimal($jarlok).'</td>
					<td>'.desimal($Ls).'</td>
					<td>'.desimal($Resiko).'</td>
					<td>'.desimal($total_jarak).'</td>
					<td>'.desimal($Ls).'</td>
					<td>'.desimal($Tn).'</td>
					<td>'.$r['sla'].'</td>
					<td>'.desimal($sla).'</td>
					<td>'.$r['sla'].'</td>
					<td>'.desimal($nilai_sla).'</td>
					<td>'.desimal($total_top).'</td>
			</tr>
				';
				$i++;
				
				// $sum_top = array_sum($all_top);
				$sum_top = $all_top;
			}
			
						
		$isi.='
			
			<tr> 
				<td colspan="17">&nbsp;</td>
			</tr> 
			<tr> 
				<td align="right" colspan="14">Jumlah Tunjangan Operasional Proyek</td>
				<td>&nbsp;</td>
				<td colspan="2" align="right">'.rupiah($sum_top).'</td>
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