<?php
ob_start();
session_start();
error_reporting(0);
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../tcpdf/fungsi_bulan2.php";
    include "../config/fungsi_rupiah.php";
    include "../config/encript.php";
	include "../config/fungsi_name.php";
	include "../config/fungsi_timeline.php";
		
	error_reporting(0);
	$getCc		= mysql_real_escape_string(dc($_GET['CostCenter']));
	$getTahun	= mysql_real_escape_string(dc($_GET['tahun']));	
	$getBulan	= date('12');	
	$div		= mysql_fetch_array(mysql_query("SELECT * FROM mskko where CostCenter='$getCc'"));	
	
		$isi ='
		<table width="100%" border="0" cellpadding="3">
			<tr>
				<td colspan="3"><img src="logo_KIT.png" width="200px" height=""></td>
			</tr>
			<tr>
				<td width="100%" align="center">
					<b>
						<font size="12"><u>REPORT PENILAIAN SASARAN KERJA UNIT</u></font><br>
						PERIODE :  JANUARI - DESEMBER &nbsp;TAHUN '.$getTahun.'
					</b>
				</td>
			</tr>
		</table>';
		
			$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan,hasil_akhir FROM srko WHERE CostCenter='$getCc' AND tahun='$getTahun' AND parent_srko='' order by id_srko");							
			while($r=mysql_fetch_array($query)){
				
				$target = mysql_fetch_array(mysql_query("SELECT target FROM target_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				
				$prog 	= mysql_fetch_array(mysql_query("SELECT pencapaian,realisasi,jenis_resume,jenis_pencapaian FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				
				$jrbul	= mysql_fetch_array(mysql_query("SELECT COUNT(realisasi) as bln FROM progress_srko_detile WHERE tahun='$getTahun' AND id_srko='$r[id_srko]' AND realisasi!=''"));
				
				if($prog['jenis_resume']==1){  //Bulan Terakhir
					$jr1 		= mysql_fetch_array(mysql_query("SELECT target FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$tot_target = desimal3($jr1['target']);
					$tt 		= $jr1['target'];
					$jr11 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$realisasi 	= desimal3($jr11['realisasi']);
					$rea	 	= $jr11['realisasi'];
					
				}elseif($prog['jenis_resume']==2){  //Komulatif
					$jr2 		= mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$tot_target = desimal3($jr2['sumtarget']);
					$tt 		= $jr2['sumtarget'];
					$jr22 		= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$realisasi 	= desimal3($jr22['sumrealisasi']);
					$rea 		= $jr22['sumrealisasi'];
					
				}elseif($prog['jenis_resume']==3){  //Rata-Rata
					$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$tot_target = desimal3($jr3['avgtarget']);
					$tt 		= $jr3['avgtarget'];
					$jr33 		= mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$realisasi 	= desimal3($jr33['avgrealisasi']);
					$rea 		= $jr33['avgrealisasi'];
					
				}elseif($prog['jenis_resume']==4){  //Prof. Margin
					$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$tot_target = desimal3($jr3['avgtarget']);
					$tt 		= $jr3['avgtarget'];								
					$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
					$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100; 
					$realisasi 	= desimal3($tpm);
					$rea 		= $tpm;
				}
				if($prog['jenis_pencapaian']==1){  //Positif
					if($tt==0 AND $rea>0){
						$hasil = 100;
					}elseif($tt>0 AND $rea<=0){
						$hasil = 0;
					}elseif($tt==0 AND $rea<=0){
						$hasil = 100;
					}else{
						$hasil = ($rea/$tt)*100;
					}	
					
				}elseif($prog['jenis_pencapaian']==2){  //Negatif
					if($tt==0 AND $rea>0){
						$hasil = 100;
					}elseif($tt>0 AND $rea<=0){
						$hasil = 0;
					}elseif($tt==0 AND $rea<=0){
						$hasil = 100;
					}else{
						$hasil = (($tt - ($rea-$tt)) / $tt) * 100;
					}
					
				}elseif($prog['jenis_pencapaian']==3){  //Prof. Margin
					if($tt==0 AND $rea>0){
						$hasil = 100;
					}elseif($tt>0 AND $rea<=0){
						$hasil = 0;
					}elseif($tt==0 AND $rea<=0){
						$hasil = 100;
					}else{
						$hasil = ($rea/$tt)*100;
					}
				}
				if($hasil <= 0){
					$pencapaian=0;
				}elseif($hasil > 0){
					if($hasil>120){
						$pencapaian=120;
					}else{
						$pencapaian=desimal3($hasil);
					}
				}
				if($pencapaian < 100){
					$fc1="red";
				}else{
					$fc1="";
				}
				if($prog['pencapaian'] < 100){
					$fc2="red";
				}else{
					$fc2="";
				}
				
				// $jmlKet = mysql_num_rows(mysql_query("SELECT id_ket FROM ket_progress_srko WHERE id_srko='$r[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCc' "));
				
				// Realisasi
				if($prog['jenis_pencapaian']==3){
					$realisasi_hasil =  desimal3($realisasi);
				}else{
					$realisasi_hasil = $realisasi;
				}
				
				
				///////////////////////////////////////////////////////////////////////////////
				//Bobot Kepala Unit
				$sum_bot_kepala	= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot_kep FROM srko where CostCenter='$getCc' AND tahun='$getTahun' "));
				$bot_kep_unit		= ($r['bobot'] / $sum_bot_kepala['sum_bobot_kep'])*75;
				$jum_bot22[] 		= $bot_kep_unit;
				
				
				$capai = ($realisasi_hasil / $r['target'])*100;							
				if($capai > 120 ){
					$pencapaian = desimal(120);
				}else{
					$pencapaian = desimal3($capai);
				}
				
				
				if($pencapaian<=70){
					$skor = desimal3(($pencapaian/70)*4.5);								
				}elseif($pencapaian<=90){
					$skor = desimal3(4.5+(($pencapaian-70)/20)*2);
				}elseif($pencapaian<=100){
					$skor = desimal3(6.5+(($pencapaian-90)/10)*2);
				}elseif($pencapaian>100){
					$skor = desimal3(8.5+(($pencapaian-100)/20)*1.5);
				}
				
				$nilai				= desimal3($r['bobot'] * $skor);
				$jum_nilai2[]		= $nilai;								
				
			}
			
			$jumlah_bobot	 	= array_sum($jum_bot22);	
			$jumlah_total_nilai = array_sum($jum_nilai2);
		
		$isi.='
		<table width="100%" border="0" cellpadding="3">		
			<tr>
				<td width="13%"><b>Kode Unit</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$getCc.'</td>
			</tr>
			<tr>
				<td width="13%"><b>Nama Divisi</b></td>
				<td width="2%">:</td>
				<td width="35%">'.$div['uraian'].'</td>
			</tr>			
			<tr>
				<td width="13%"><b>Nilai</b></td>
				<td width="2%">:</td>
				<td width="35%"><font size="12"><b>'.desimal3($jumlah_total_nilai).'</b></font></td>
			</tr>
		</table>
		<br>
		
		<table width="100%" border="1" cellpadding="3">
			<tr align="center">
				<td width="3%" height="30"><b>No.</b></td>
				<td width="40%"><b>Sasaran / Rencana Kerja</b></td>
				<td width="8%"><b>Target</b></td>
				<td width="9%"><b>Satuan</b></td>
				<td width="8%"><b>Bobot</b></td>
				<td width="8%"><b>Hasil</b></td>
				<td width="8%"><b>Pencapaian</b></td>
				<td width="8%"><b>Skor</b></td>
				<td width="8%"><b>Nilai</b></td>
			</tr>';
			///====================== Baris Isi =======================///
			$i=1;
			$query = mysql_query("SELECT DISTINCT id_srko,rencana_kerja,bobot,target,satuan,hasil_akhir FROM srko WHERE CostCenter='$getCc' AND tahun='$getTahun' AND parent_srko='' order by id_srko");							
			while($r=mysql_fetch_array($query)){
				
			$target = mysql_fetch_array(mysql_query("SELECT target FROM target_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
			
			$prog 	= mysql_fetch_array(mysql_query("SELECT pencapaian,realisasi,jenis_resume,jenis_pencapaian FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
			
			$jrbul	= mysql_fetch_array(mysql_query("SELECT COUNT(realisasi) as bln FROM progress_srko_detile WHERE tahun='$getTahun' AND id_srko='$r[id_srko]' AND realisasi!=''"));
			
			if($prog['jenis_resume']==1){  //Bulan Terakhir
				$jr1 		= mysql_fetch_array(mysql_query("SELECT target FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$tot_target = desimal3($jr1['target']);
				$tt 		= $jr1['target'];
				$jr11 		= mysql_fetch_array(mysql_query("SELECT realisasi FROM progress_srko_detile WHERE bulan='$getBulan' AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$realisasi 	= desimal3($jr11['realisasi']);
				$rea	 	= $jr11['realisasi'];
				
			}elseif($prog['jenis_resume']==2){  //Komulatif
				$jr2 		= mysql_fetch_array(mysql_query("SELECT SUM(target) as sumtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$tot_target = desimal3($jr2['sumtarget']);
				$tt 		= $jr2['sumtarget'];
				$jr22 		= mysql_fetch_array(mysql_query("SELECT SUM(realisasi) as sumrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$realisasi 	= desimal3($jr22['sumrealisasi']);
				$rea 		= $jr22['sumrealisasi'];
				
			}elseif($prog['jenis_resume']==3){  //Rata-Rata
				$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$tot_target = desimal3($jr3['avgtarget']);
				$tt 		= $jr3['avgtarget'];
				$jr33 		= mysql_fetch_array(mysql_query("SELECT AVG(realisasi) as avgrealisasi FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$realisasi 	= desimal3($jr33['avgrealisasi']);
				$rea 		= $jr33['avgrealisasi'];
				
			}elseif($prog['jenis_resume']==4){  //Prof. Margin
				$jr3 		= mysql_fetch_array(mysql_query("SELECT AVG(target) as avgtarget FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$tot_target = desimal3($jr3['avgtarget']);
				$tt 		= $jr3['avgtarget'];								
				$pm = mysql_fetch_array(mysql_query("SELECT SUM(realisasi_pm) as sumpm FROM progress_srko_detile WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$hpp = mysql_fetch_array(mysql_query("SELECT SUM(hpp) as sumhpp FROM progress_srko WHERE (bulan BETWEEN '1' AND '$getBulan') AND tahun='$getTahun' AND id_srko='$r[id_srko]'"));
				$tpm = (($pm['sumpm']-$hpp['sumhpp'])/$pm['sumpm'])*100; 
				$realisasi 	= desimal3($tpm);
				$rea 		= $tpm;
			}
			if($prog['jenis_pencapaian']==1){  //Positif
				if($tt==0 AND $rea>0){
					$hasil = 100;
				}elseif($tt>0 AND $rea<=0){
					$hasil = 0;
				}elseif($tt==0 AND $rea<=0){
					$hasil = 100;
				}else{
					$hasil = ($rea/$tt)*100;
				}	
				
			}elseif($prog['jenis_pencapaian']==2){  //Negatif
				if($tt==0 AND $rea>0){
					$hasil = 100;
				}elseif($tt>0 AND $rea<=0){
					$hasil = 0;
				}elseif($tt==0 AND $rea<=0){
					$hasil = 100;
				}else{
					$hasil = (($tt - ($rea-$tt)) / $tt) * 100;
				}
				
			}elseif($prog['jenis_pencapaian']==3){  //Prof. Margin
				if($tt==0 AND $rea>0){
					$hasil = 100;
				}elseif($tt>0 AND $rea<=0){
					$hasil = 0;
				}elseif($tt==0 AND $rea<=0){
					$hasil = 100;
				}else{
					$hasil = ($rea/$tt)*100;
				}
			}
			if($hasil <= 0){
				$pencapaian=0;
			}elseif($hasil > 0){
				if($hasil>120){
					$pencapaian=120;
				}else{
					$pencapaian=desimal3($hasil);
				}
			}
			if($pencapaian < 100){
				$fc1="red";
			}else{
				$fc1="";
			}
			if($prog['pencapaian'] < 100){
				$fc2="red";
			}else{
				$fc2="";
			}
			
			// $jmlKet = mysql_num_rows(mysql_query("SELECT id_ket FROM ket_progress_srko WHERE id_srko='$r[id_srko]' AND bulan='$getBulan' AND tahun='$getTahun' AND cc='$getCc' "));
			
			// Realisasi
			if($prog['jenis_pencapaian']==3){
				$realisasi_hasil =  desimal3($realisasi);
			}else{
				$realisasi_hasil = $realisasi;
			}
			
			
			///////////////////////////////////////////////////////////////////////////////
			//Bobot Kepala Unit
			$sum_bot_kepala	= mysql_fetch_array(mysql_query("SELECT SUM(bobot) as sum_bobot_kep FROM srko where CostCenter='$getCc' AND tahun='$getTahun' "));
			$bot_kep_unit		= ($r['bobot'] / $sum_bot_kepala['sum_bobot_kep'])*75;
			$jum_bot2[] 		= $bot_kep_unit;
			
			
			$capai = ($realisasi_hasil / $r['target'])*100;							
			if($capai > 120 ){
				$pencapaian = desimal(120);
			}else{
				$pencapaian = desimal3($capai);
			}
			
			
			if($pencapaian<=70){
				$skor = desimal3(($pencapaian/70)*4.5);								
			}elseif($pencapaian<=90){
				$skor = desimal3(4.5+(($pencapaian-70)/20)*2);
			}elseif($pencapaian<=100){
				$skor = desimal3(6.5+(($pencapaian-90)/10)*2);
			}elseif($pencapaian>100){
				$skor = desimal3(8.5+(($pencapaian-100)/20)*1.5);
			}
			
			$nilai				= desimal3($r['bobot'] * $skor);
			$jum_nilai[]		= $nilai;	
				
			$bgcolor = ($i % 2 == 0) ?  "#bfe5eb" : "white";
			$isi.='		
			<tr bgcolor="'.$bgcolor.'">
				<td width="3%" align="center">'.$i.'</td>
				<td width="40%">'.$r['rencana_kerja'].'</td>
				<td width="8%" align="center">'.$r['target'].'</td>
				<td width="9%" align="center">'.$r['satuan'].'</td>
				<td width="8%" align="center">'.$r['bobot'].'</td>
				<td width="8%" align="center">'.desimal3($realisasi_hasil).'</td>
				<td width="8%" align="center">'.desimal3($pencapaian).'</td>
				<td width="8%" align="center">'.desimal3($skor).'</td>
				<td width="8%" align="center">'.desimal3($nilai).'</td>
			</tr>
			';
			$i++;
		}
			$jumlah_bobot	 	= array_sum($jum_bot2);	
			$jumlah_total_nilai = array_sum($jum_nilai);
		$isi.='	
			<tr>
				<td colspan="3" align="right"><b>TOTAL</b></td>
				<td align="center">&nbsp;</td>
				<td align="center"><b>'.desimal3($sum_bot_kepala['sum_bobot_kep']).'</b></td>
				<td align="center" colspan="3">&nbsp;</td>
				<td align="center"><b>'.desimal3($jumlah_total_nilai).'</b></td>
				
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