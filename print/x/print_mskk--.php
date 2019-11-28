<?php
ob_start();
session_start();
set_time_limit(0);
	include "../config/koneksi.php";
    include "../tcpdf/fungsi_indotgl.php";
    include "../tcpdf/fungsi_bulan.php";
    include "../config/fungsi_rupiah.php";
    include "../config/encript.php";
    
	$getId		= explode("-",$_GET['id']);
	$getNik		= mysql_real_escape_string(dc($getId[0]));
	$getBulan	= mysql_real_escape_string(dc($getId[1]));
	$getLvl		= mysql_real_escape_string($_GET['lvl']);
	$tahun	= mysql_fetch_array(mysql_query("SELECT tahun FROM tahun WHERE status='1'"));
	$query = mysql_query("SELECT	mskk.*,
									wbs.aktivitas
									FROM
									mskk
									INNER JOIN wbs ON mskk.id_gca = wbs.id 
									WHERE mskk.nik='$getNik' AND mskk.bulan='$getBulan' AND mskk.tahun='$tahun[tahun]'
									ORDER BY id_srko ASC
									");
	$data_user = mysql_fetch_array(mysql_query("SELECT
														m_jabatan.posdesc as jabatan,
														mskko.uraian as unit,
														m_karyawan.regno as nik,
														m_karyawan.`name` as nama
														FROM
														m_karyawan
														INNER JOIN mskko ON mskko.CostCenter = m_karyawan.dept
														INNER JOIN m_jabatan ON m_jabatan.poscode = m_karyawan.poscode
														WHERE m_karyawan.regno='$getNik' "));
	
	$isi ='
		<table width="100%" border="0">
			<tr>
				<td colspan="3"><img src="logo_KIT.png" width="200px" height=""></td>
			</tr>
			<tr>
				<td width="30%"></td>
				<td width="40%" align="center">
					<b>
						<font size="13">MATRIK SASARAN KERJA KARYAWAN</font><br>
						BULAN : '.STRTOUPPER(bulan($getBulan)).'
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
			$isi .='<th width="3%" ><b>No.</b></th>
					<th width="39%"><b>Rencana Kerja</b></th>
					<th width="8%"><b>Bobot Awal</b></th>
					<th width="8%"><b>Bobot Akhir</b></th>
					<th width="8%"><b>Target</b></th>
					<th width="8%"><b>Realisasi</b></th>
					<th width="8%"><b>Pencapaian</b></th>
					<th width="8%"><b>Score</b></th>
					<th width="10%"><b>Bobot X Score</b></th>';
		}else{
			$isi .='<th width="3%" ><b>No.</b></th>
					<th width="39%"><b>Rencana Kerja</b></th>
					<th width="8%"><b>Bobot Awal</b></th>
					<th width="8%"><b>Bobot Akhir</b></th>
					<th width="8%"><b>Target</b></th>
					<th width="8%"><b>Realisasi</b></th>
					<th width="8%"><b>Pencapaian</b></th>
					<th width="8%"><b>Score</b></th>
					<th width="10%"><b>Bobot X Score</b></th>';
		}
	$isi .='</tr>';
	$no=1;
	if($_GET['lvl']==4){
		$totalBA 	= 0;
		$totalB 	= 0;
		$totalBXS 	= 0;
		while($r=mysql_fetch_array($query)){
		$isi .='<tr>
					<td align="center">'.$no.'</td>
					<td>'.$r['aktivitas'].'</td>
					<td align="center">'.desimal($r['bobotA']).'</td>
					<td align="center">'.desimal($r['bobot']).'</td>
					<td align="center">'.desimal($r['target']).'</td>
					<td align="center">'.desimal($r['realisasi']).'</td>
					<td align="center">'.desimal($r['pencapaian']).'</td>
					<td align="center">'.$r['score'].'</td>
					<td align="center">'.desimal($r['bxs']).'</td>';
		$isi .='</tr>';
				$no++;
				$totalBA += $r['bobotA'];
				$totalB += $r['bobot'];
				$totalBXS += $r['bxs'];
			}
		$isi .='
			<tr align="center">
				<td colspan="2"><b>Total</b></td>
				<td>'.desimal($totalBA).'</td>
				<td>'.desimal($totalB).'</td>
				<td colspan="4"></td>
				<td>'.desimal($totalBXS).'</td>
			</tr>
			';
	}else{
		$totalBA 	= 0;
		$totalB 	= 0;
		$totalBXS 	= 0;
		while($r=mysql_fetch_array($query)){
		$isi .='<tr>
				<td align="center">'.$no.'</td>
				<td>'.$r['aktivitas'].'</td>
				<td align="center">'.desimal($r['bobotA']).'</td>
				<td align="center">'.desimal($r['bobot']).'</td>
				<td align="center">'.desimal($r['target']).'</td>
				<td align="center">'.desimal($r['realisasi']).'</td>
				<td align="center">'.desimal($r['pencapaian']).'</td>
				<td align="center">'.$r['score'].'</td>
				<td align="center">'.desimal($r['bxs']).'</td>';
		$isi .='
			</tr>';
			$no++;
			$totalBA += $r['bobotA'];
			$totalB += $r['bobot'];
			$totalBXS += $r['bxs'];
		}
			$isi .='
			<tr align="center">
				<td colspan="2"><b>Total</b></td>
				<td>'.desimal($totalBA).'</td>
				<td>'.desimal($totalB).'</td>
				<td colspan="4"></td>
				<td>'.desimal($totalBXS).'</td>
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