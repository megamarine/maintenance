<?php
	require_once("module/model/koneksi/koneksi.php");
	
	require('fpdf/fpdf.php');
	$KODE_PTK = $_GET["KODE_PTK"];
	$DINO 	  = date('Y-m-d H:i:s');
	$ID_USER  = $_SESSION["LOGINIDUS_REKRUT"];
	$querylog = 
			"insert into t_userlog (KODE_USER,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
			values ('$ID_USER','$DINO','Laporan','Cetak Laporan','Cetak Laporan PTK Kode $KODE_PTK')";
	mysql_query($querylog, $DB1);

	$query = 
		"select t.*,
			DATE_FORMAT(t.TANGGAL_PTK, '%d %M %Y') as TANGGAL_PTK,
			DATE_FORMAT(t.TGL_BUTUH, '%d %M %Y') as TGL_BUTUH,
			p.NAMA_PERUSAHAAN,
			b.NAMA_BAGIAN,
			d.NAMA_DEPARTEMEN,
			j.NAMA_JABATAN 
		from t_ptk t, 
			m_perusahaan p, 
			m_bagian b, 
			m_departemen d, 
			m_jabatan j 
		where t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
			t.KODE_BAGIAN = b.KODE_BAGIAN and 
			t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
			t.KODE_JABATAN = j.KODE_JABATAN and 
			KODE_PTK = '$KODE_PTK'";
	$result = mysql_query($query, $DB1);

	class PDF extends FPDF
	{
		// Page header
		function Header()
		{

			$KODE_PTK = $_GET["KODE_PTK"];

			$query = "select p.*,DATE_FORMAT(p.TANGGAL_PTK, '%d %M %Y') as TANGGAL_PTK,b.GROUP_MANAGEMENT from t_ptk p, m_bagian b where p.KODE_BAGIAN = b.KODE_BAGIAN and p.KODE_PTK = '$KODE_PTK'";
			$result = mysql_query($query);
			while ($row = mysql_fetch_array($result)) {
				$TGL_PTK = $row["TANGGAL_PTK"];
				$KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
				$USER_REQ = $row["USER_REQ"];
				$KODE_BAGIAN = $row["KODE_BAGIAN"];
				$GROUP_MANAGEMENT = $row["GROUP_MANAGEMENT"];
			}

			$this->SetFont('Arial','B',12);
			// Logo
			if ($KODE_PERUSAHAAN == 1) {
				$this->Image('../image/images/logommp.png',10,9,30);
				$this->Cell(25);
		    	$this->Write(5,"PT. MEGA MARINE PRIDE");
			}
			else{
				$this->Image('../image/images/logobb.jpg',10,9,21);
				$this->Cell(25);
				$this->Write(5,"PT. Baramuda Bahari");
			}
		    // Arial bold 15
		    // Move to the right
		    $this->Ln(4);
		    $this->Cell(25);
		    $this->SetFont('Arial','',7);
		    $this->Write(5,"Ds. Wonokoyo - Kec. Beji, Pasuruan 67514 Jawa Timur Indonesia");
		    $this->Ln(4);
		    $this->Cell(25);
		    $this->Write(5,"Phone (62-343) 656513 - 656446 Fax. (62-343) 656195");
		    $this->Ln(4);
		    $this->Cell(25);
		    $this->Write(5,"PO Box. 6135/SBSG, Surabaya 60061 - Indonesia");
		    $this->Ln(10);
		    // Arial italic 8
		    $this->SetFont('Arial','I',8);
		    // Page number
		    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');
		    // Line break
		    $this->Ln(10);
		    $this->SetFont('Arial','BU',14);
		    $this->Cell(0,5,"Permintaan Tenaga Kerja",0,0,"C");
		    $this->Ln();
		    $this->SetFont('Arial','B',11);
		    $this->Cell(0,5,$KODE_PTK,0,0,"C");
		    $this->Ln(20);
		}

		// Page footer
		function Footer()
		{	
			$KODE_PTK = $_GET["KODE_PTK"];

			$query = "select p.*,DATE_FORMAT(p.TANGGAL_PTK, '%d %M %Y') as TANGGAL_PTK,b.GROUP_MANAGEMENT,u.NAMA_USER from t_ptk p, m_bagian b, m_user u where p.USER_REQ = u.KODE_USER and p.KODE_BAGIAN = b.KODE_BAGIAN and p.KODE_PTK = '$KODE_PTK'";
			$result = mysql_query($query);
			while ($row = mysql_fetch_array($result)) {
				$TGL_PTK = $row["TANGGAL_PTK"];
				$KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
				$NAMA_USER = $row["NAMA_USER"];
				$KODE_BAGIAN = $row["KODE_BAGIAN"];
				$GROUP_MANAGEMENT = $row["GROUP_MANAGEMENT"];
			}

		    // Position at 1.5 cm from bottom
		    $this->SetY(-70);
		    // Arial italic 8
		    $this->SetFont('Times','B',9);
		    // Page number
		    $this->Cell(10,5,"",0,0,"L");
		    $this->Cell(50,5,"Diajukan oleh,",0,0,"L");
		    $this->Cell(50,5,"Diketahui oleh,",0,0,"L");
		    $this->Cell(50,5,"Diketahui oleh,",0,0,"L");
		    $this->Ln(25);
		    $this->Cell(10,5,"",0,0,"L");
		    $this->Cell(50,5,$NAMA_USER,0,0,"L");
		    $this->Cell(50,5,"T Adji Wijono",0,0,"L");
		    if ($GROUP_MANAGEMENT == "Operational") {
		    	$this->Cell(50,5,"Yohanes Yoelianto",0,0,"L");
		    }
		    elseif ($GROUP_MANAGEMENT == "Finance") {
		    	$this->Cell(50,5,"Welly Kristanto",0,0,"L");
		    }
		    elseif ($GROUP_MANAGEMENT == "Quality") {
		    	$this->Cell(50,5,"Junita Dwi Lia",0,0,"L");
		    }
		}
		// Load data
		function LoadData($file)
		{
		    // Read file lines
		    $lines = file($file);
		    $data = array();
		    foreach($lines as $line)
		        $data[] = explode(';',trim($line));
		    return $data;
		}
		// Colored table
		function FancyTable($header)
		{
		    // Colors, line width and bold font
		    $this->SetFillColor(255,0,0);
		    $this->SetTextColor(255);
		    $this->SetDrawColor(128,0,0);
		    $this->SetLineWidth(.3);
		    $this->SetFont('','B');
		    // Header
		    $w = array(40, 35, 40, 45);
		    for($i=0;$i<count($header);$i++)
		        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $this->Ln();
		    // Color and font restoration
		    $this->SetFillColor(224,235,255);
		    $this->SetTextColor(0);
		    $this->SetFont('');
		    // Data
		    $fill = false;
		    foreach($data as $row)
		    {
		        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
		        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
		        $this->Ln();
		        $fill = !$fill;
		    }
		    // Closing line
		    $this->Cell(array_sum($w),0,'','T');
		}
	}

// Instanciation of inherited class
$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
while ($row = mysql_fetch_array($result)) {
	$pdf->Cell(10,5,"Bersama ini kami mengajukan permintaan tenaga kerja di Bagian / Departemen untuk mengisi lowongan yang kami butuhkan saat ini.",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(10,5,"Adapun tenaga tersebut untuk:",0,0,"L");
    $pdf->Ln(7);
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Divisi",0,0,"L");
    $pdf->Cell(20,5,": " . $row["NAMA_BAGIAN"],0,0,"L");
    $pdf->Ln();
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Departemen",0,0,"L");
    $pdf->Cell(20,5,": " . $row["NAMA_DEPARTEMEN"],0,0,"L");
    $pdf->Ln();
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Jabatan",0,0,"L");
    $pdf->Cell(20,5,": " . $row["NAMA_JABATAN"] . " " . $row["BAGIAN"],0,0,"L");
    $pdf->Ln();
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Jumlah yang diminta",0,0,"L");
    $pdf->Cell(100,5,": " . $row["JUMLAH"] . " Orang",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Tanggal dibutuhkan",0,0,"L");
    $pdf->Cell(20,5,": " . $row["TGL_BUTUH"],0,0,"L");
    $pdf->Ln(7);
    $pdf->Cell(10,5,"Alasan permintaan kami:",0,0,"L");
    $pdf->Ln(7);
    $pdf->Cell(15,5,"",0,0,"R");
    $pdf->Cell(45,5,$row["ALASAN"],0,0,"R");
    $pdf->Ln(7);
    $pdf->Cell(10,5,"Syarat-syarat umum tenaga yang diinginkan:",0,0,"L");
    $pdf->Ln(7);
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Pendidikan Minimal",0,0,"L");
    $pdf->Cell(20,5,": " . $row["PENDIDIKAN"],0,0,"L");
    $pdf->Ln();
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Pengalaman Kerja",0,0,"L");
    $pdf->Cell(20,5,": " . $row["PENGALAMAN_KERJA"] . " Tahun",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(10,5,"",0,0,"R");
    $start_awal=$pdf->GetX(); 
	$get_xxx = $pdf->GetX();
	$get_yyy = $pdf->GetY();

	$width_cell = 0;  
	$height_cell = 4;
    $pdf->Cell(30,5,"Kriteria",0,0,"L");
    $pdf->MultiCell($width_cell,$height_cell,": " . $row["KETERANGAN"],0,"L"); 
	$get_xxx+=$width_cell;                           
	$pdf->SetXY($get_xxx, $get_yyy);
    $pdf->Ln(35);
    $pdf->Cell(10,5,"",0,0,"R");
    $pdf->Cell(30,5,"Tugas Pokok",0,0,"L");
    $pdf->MultiCell($width_cell,$height_cell,": " . $row["TUGAS_POKOK"],0,"L"); 
	$get_xxx+=$width_cell;                           
	$pdf->SetXY($get_xxx, $get_yyy);
}
// Format Page Portrait/Landscape, Type of Paper, Rotation
$pdf->Output("pdf/Laporan ".$KODE_PTK.".pdf","F");
// }

	$query6 = "select t.*,DATE_FORMAT(t.TANGGAL_PTK, '%d %M %Y') as TANGGAL_PTK,DATE_FORMAT(t.TGL_BUTUH, '%d %M %Y') as TGL_BUTUH,b.NAMA_BAGIAN,d.NAMA_DEPARTEMEN,j.NAMA_JABATAN from t_ptk t, m_bagian b, m_departemen d, m_jabatan j where t.KODE_BAGIAN = b.KODE_BAGIAN and t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and t.KODE_JABATAN = j.KODE_JABATAN and t.KODE_PTK = '$KODE_PTK'";
    $result6 = mysql_query($query6, $DB1);
    while ($row6 = mysql_fetch_array($result6)) {
        $NAMA_BAGIAN = $row6["NAMA_BAGIAN"];
        $NAMA_DEPARTEMEN = $row6["NAMA_DEPARTEMEN"];
        $NAMA_JABATAN = $row6["NAMA_JABATAN"];
        $JUMLAH = $row6["JUMLAH"];
        $STATUS_KERJA = $row6["STATUS_KERJA"];
        $TGL_BUTUH = $row6["TGL_BUTUH"];
        $ALASAN = $row6["ALASAN"];
        $KETERANGAN = $row6["KETERANGAN"];
        $TUGAS_POKOK = $row6["TUGAS_POKOK"];
        $BAGIAN = $row6["BAGIAN"];
    }

	// START EMAIL
    /**
	 * This example shows sending a message using a local sendmail binary.
	 */
	//Import the PHPMailer class into the global namespace
	// use phpmailer;
	require_once("module/model/koneksi/koneksi.php");
	require 'phpmailer/PHPMailerAutoload.php';
	//Create a new PHPMailer instance

	$GROUP_MANAGEMENT = $_SESSION["LOGINGRP_REKRUT"];
	$queryem = "select EMAIL from m_user where GROUP_MANAGEMENT = '$GROUP_MANAGEMENT'";
	$resultem = mysql_query($queryem, $DB1);
	while ($rowem = mysql_fetch_array($resultem)) {
	    $EMAILDIR = $rowem["EMAIL"];
	}
	$KODE_BAGIAN = $_SESSION["LOGINBAG_REKRUT"];
	if ($KODE_BAGIAN == "DIV-0030") {
		$EMAILMAN = "quality@megamarinepride.com";
	}
	else{
		$queryem2 = "select EMAIL from m_user where KODE_BAGIAN = '$KODE_BAGIAN' and AKSES = 'Manajer'";
		$resultem2 = mysql_query($queryem2, $DB1);
		while ($rowem2 = mysql_fetch_array($resultem2)) {
		    $EMAILMAN = $rowem2["EMAIL"];
		}
	}

	$mail = new PHPMailer;
	// Set PHPMailer to use the sendmail transport
	$mail->isSendmail();
	//Set who the message is to be sent from
	$mail->setFrom('no-reply@megamarinepride.com','no-reply');
	//Set an alternative reply-to address
	// $mail->addReplyTo('replyto@example.com', 'First Last');
	//Set who the message is to be sent to
	$mail->addAddress($EMAILMAN);
	$mail->addCC('recruitment@megamarinepride.com','recruitment');
	$mail->addCC('adityahusni90@gmail.com','husniaditya');
	//Set the subject line
	$mail->Subject = "Permintaan Tenaga Kerja Karyawan " . $KODE_PTK;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML("<br><br>======================================================================================<br>Divisi : " . $NAMA_BAGIAN . " <br>Departemen : " . $NAMA_DEPARTEMEN . " <br>Jabatan : " . $NAMA_JABATAN . " " . $BAGIAN . " <br>Jumlah : " . $JUMLAH . " <br>Status Kerja : " . $STATUS_KERJA . " <br>Tanggal : " . $TGL_BUTUH . " <br>Alasan : " . $ALASAN . " <br>Kriteria : " . $KETERANGAN . " <br>Tugas Pokok : " . $TUGAS_POKOK . " <br><br>Status Persetujuan :<br>Manager : Pending<br>Manager HRD : Pending<br>Direktur : Pending<br><br>======================================================================================<br>please do not reply to this email <br>for more information, kindly visit <a href='192.168.0.167/rekrutmen'>recruitment.megamarinepride</a><br><br><br>Regards,<br>Recruitment Team");
	//Replace the plain text body with one created manually
	// $mail->AltBody = 'This is a plain-text message body';
	//Attach an image file
	$mail->addAttachment("pdf/Laporan " . $KODE_PTK . ".pdf");
	$mail->send();
    // END EMAIL

	?><script>document.location.href='pengajuanptk.php';</script><?php
	die(0);
?>