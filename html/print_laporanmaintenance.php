<?php
	require_once("module/model/koneksi/koneksi.php");
	
    require('fpdf/fpdf.php');
    //truncate a string only at a whitespace (by nogdog)
    function truncate($text, $length) {
        $length = abs((int)$length);
        if(strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return($text);
    }

	$DINO           = date('Y-m-d H:i:s');
	$ID_USER        = $_SESSION["LOGINIDUS_MT"];
	$IP_ADDRESS     = $_SESSION["IP_ADDRESS_MT"];
    $PC_NAME        = $_SESSION["PC_NAME_MT"];
    $KODE_PERBAIKAN = $_GET["id"];
    
	$result1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER','$IP_ADDRESS','$PC_NAME','$DINO','Laporan Maintenance','Print','Kode $KODE_PERBAIKAN')"); 
    $result1->execute();
    
    $result2 = GetQuery(
        "select t.KODE_PERBAIKAN,
                u.NAMA_USER,
                b.NAMA_BARANG,
                t.LAYANAN,
                t.KERUSAKAN,
                t.SOLUSI,
                t.DURASI,
                e.NAMA_TEKNISI,
                DATE_FORMAT(t.TGL_START, '%d %M %Y') as TGL_START,
                DATE_FORMAT(t.TGL_END, '%d %M %Y') as TGL_END,
                DATE_FORMAT(t.TGL_START, '%H:%i:%s') as JAM_START,
                DATE_FORMAT(t.TGL_END, '%H:%i:%s') as JAM_END,
                j.NAMA_JENIS, 
                n.NAMA_DEPARTEMEN AS LOKASI, 
                i.NAMA_BAGIAN, 
                nu.NAMA_DEPARTEMEN AS USR_DEP,
                t.KET_VERIFIKASI 
         FROM t_perbaikan t, 
              m_teknisi e, 
              m_barang b, 
              m_user u, 
              d_perbaikan d, 
              m_jenisbrg j, 
              m_departemen n, 
              m_bagian i, 
              m_departemen nu 
        WHERE t.KODE_BARANG = b.KODE_BARANG AND 
              t.USER_REQ = u.KODE_USER AND 
              t.KODE_PERBAIKAN = d.KODE_PERBAIKAN AND 
              t.KODE_DEPARTEMEN = n.KODE_DEPARTEMEN AND 
              d.KODE_TEKNISI = e.KODE_TEKNISI AND 
              u.KODE_BAGIAN = i.KODE_BAGIAN AND 
              b.KODE_JENIS = j.KODE_JENIS AND 
              u.KODE_DEPARTEMEN = nu.KODE_DEPARTEMEN AND 
              t.KODE_PERBAIKAN = '$KODE_PERBAIKAN' 
        GROUP BY KODE_PERBAIKAN");
    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
        extract($row2);
    }

    $TIME = 0;

	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
            $DATENOW = date("d F Y");

            $KODE_PERBAIKAN = $_GET["id"];

            $result = GetQuery(
                "select t.KODE_PERBAIKAN,
                        j.NAMA_JENIS,
                        t.KODE_PERUSAHAAN,
                        DATE_FORMAT(t.TGL_START, '%d %M %Y') as TGL_START 
                   FROM t_perbaikan t, 
                        m_barang b, 
                        m_jenisbrg j 
                  WHERE t.KODE_BARANG = b.KODE_BARANG AND 
                        b.KODE_JENIS = j.KODE_JENIS AND 
                        t.KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
            }

			$this->SetFont('Arial','B',12);
			// Logo
			if ($KODE_PERUSAHAAN == 1) {
                $this->Image('../image/images/logommp.png',10,9,30);
                $this->Ln(1);
				$this->Cell(26);
                $this->Cell(114,5,"PT. MEGA MARINE PRIDE",0,0,"C");
                $this->SetFont('Arial','B',7);
                $this->Cell(20,5,"Pengajuan ke",0,0,"L");
                $this->Cell(5,5,": " . $NAMA_JENIS,0,0,"L");
                $this->Ln(3);
                $this->Cell(140);
                $this->SetFont('Arial','BI',7);
                $this->Cell(20,5,"Submit to",0,0,"L");
                $this->Ln(4);
                $this->Cell(140);
                $this->SetFont('Arial','',7);
                $this->Cell(20,5,"Tgl / Date",0,0,"L");
                $this->Cell(5,5,": " . $TGL_START,0,0,"L");
                $this->Ln(4);
                $this->Cell(140);
                $this->Cell(20,5,"No : ",0,0,"L");
                $this->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");

			}
			else{
                $this->Image('../image/images/logobb.jpg',16,11,15);
                $this->Ln(1);
				$this->Cell(26);
                $this->Cell(114,5,"PT. BARAMUDA BAHARI",0,0,"C");
                $this->SetFont('Arial','B',7);
                $this->Cell(20,5,"Pengajuan ke",0,0,"L");
                $this->Cell(5,5,": " . $NAMA_JENIS,0,0,"L");
                $this->Ln(3);
                $this->Cell(140);
                $this->SetFont('Arial','BI',7);
                $this->Cell(20,5,"Submit to",0,0,"L");
                $this->Ln(4);
                $this->Cell(140);
                $this->SetFont('Arial','',7);
                $this->Cell(20,5,"Tgl / Date",0,0,"L");
                $this->Cell(5,5,": " . $TGL_START,0,0,"L");
                $this->Ln(4);
                $this->Cell(140);
                $this->Cell(20,5,"No : ",0,0,"L");
                $this->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");
			}
		    // Arial bold 15
		    // Move to the right
		    $this->Ln(-5);
            $this->SetFont('Arial','B',10);
            $this->Cell(26);
            $this->Cell(114,5,"PERMOHONAN & LAPORAN PERBAIKAN",0,0,"C");
            $this->Ln();
            $this->SetFont('Arial','BI',10);
            $this->Cell(26);
            $this->Cell(114,5,"APPLICATION & REPARATION REPORT",0,0,"C");
            $this->Ln();
		}

		// Page footer
		function Footer()
		{	
            
		}
	}

// Instanciation of inherited class
$pdf = new PDF('P','mm','A4');

$pdf->AliasNbPages();
$pdf->AddPage();



// Start Draw Line
// Header
$pdf->Line(10, 10, 210-10, 10); // Horizontal Line Header
$pdf->Line(10, 27, 210-10, 27); // Horizontal Line Header
$pdf->Line(36, 17, 160-10, 17); // Horizontal Line Header
$pdf->Line(36, 10,36,37-10); // Vetical line Header
$pdf->Line(150, 10,150,37-10); // Vetical line Header
// End Header

// Footer & Edge
$pdf->Line(10, 285, 210-10, 285); // Horizontal Line
$pdf->Line(10, 10,10,295-10); // Vetical line
$pdf->Line(200, 10,200,295-10); // Vetical line
// End Footer & Edge

// 1 Content
$pdf->Line(10, 32, 210-10, 32); // Horizontal Line
$pdf->Line(105, 52,105,27); // Vetical line Header
$pdf->Line(10, 52, 210-10, 52); // Horizontal Line
// End 1 Content

// 2 Content
$pdf->Line(10, 57, 210-10, 57); // Horizontal Line
$pdf->Line(10, 72, 210-10, 72); // Horizontal Line
// End 2 Contenct

// 3 Content
$pdf->Line(10, 77, 210-10, 77); // Horizontal Line
$pdf->Line(10, 130, 210-10, 130); // Horizontal Line
$pdf->Line(10, 140, 210-10, 140); // Horizontal Line
$pdf->Line(105, 107, 210-10, 107); // Horizontal Line
$pdf->Line(105, 115, 210-10, 115); // Horizontal Line
$pdf->Line(105, 140,105,107); // Vetical line Header
$pdf->Line(152, 140,152,107); // Vetical line Header

// $pdf->Image('images/approved.png',113,110,30);
// $pdf->Image('images/approved.png',160,110,30);
// End 3 Contenct

// 4 Content
$pdf->Line(10, 145, 210-10, 145); // Horizontal Line
$pdf->Line(10, 175, 210-10, 175); // Horizontal Line
$pdf->Line(10, 185, 210-10, 185); // Horizontal Line
$pdf->Line(105, 185,105,175); // Vetical line Header
// End 4 Content

// 5 Content
$pdf->Line(10, 190, 210-10, 190); // Horizontal Line
$pdf->Line(57, 263, 210-10, 263); // Horizontal Line
$pdf->Line(10, 273, 210-10, 273); // Horizontal Line
$pdf->Line(57, 240, 210-10, 240); // Horizontal Line
$pdf->Line(57, 248, 210-10, 248); // Horizontal Line
$pdf->Line(57, 273,57,240); // Vetical line Header
$pdf->Line(105, 273,105,240); // Vetical line Header
$pdf->Line(152, 273,152,240); // Vetical line Header

// $pdf->Image('images/approved.png',65,243,30);
// $pdf->Image('images/approved.png',160,243,30);

// End 5 Content

// End Draw Line

// 1 Content
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95,5,"Detail Pemohon / Applicant Details :",0,0,"L");
$pdf->Cell(95,5,"Detail Item / Item Details :",0,0,"L");
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->Cell(30,5,"Nama / Name",0,0,"L");
$pdf->Cell(65,5,": " . $NAMA_USER,0,0,"L");
$pdf->Cell(30,5,"Bangunan / Peralatan",0,0,"L");
$pdf->Cell(65,5,": " . $NAMA_BARANG,0,0,"L");
$pdf->Ln();
$pdf->Cell(30,5,"Jabatan / Position",0,0,"L");
$pdf->Cell(65,5,": ",0,0,"L");
$pdf->SetFont('Arial','I',7);
$pdf->Cell(30,5,"Building / Equipment",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Ln();
$pdf->Cell(30,5,"Bagian / Section",0,0,"L");
$pdf->Cell(65,5,": " . $NAMA_BAGIAN,0,0,"L");
$pdf->Cell(30,5,"Jenis / Type",0,0,"L");
$pdf->Cell(65,5,": ",0,0,"L");
$pdf->Ln();
$pdf->Cell(30,5,"Departemen / Department",0,0,"L");
$pdf->Cell(65,5,": " . $USR_DEP,0,0,"L");
$pdf->Cell(30,5,"Lokasi / Location",0,0,"L");
$pdf->Cell(65,5,": " . $LOKASI,0,0,"L");
$pdf->Ln();
// End 1 Content

// 2 Content
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95,5,"Tipe Perbaikan / Type of Repaired :",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(95,5,"*) Diisi oleh Pemohon / Filled by Applicant",0,0,"R");
$pdf->Ln();
if ($LAYANAN == "Perawatan") {
    $pdf->Cell(5,4,"X",1,0,"C");
    $pdf->Cell(0,5,"Perawatan / Minor Repairs",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(5,4,"",1,0,"C");
    $pdf->Cell(0,5,"Perbaikan / Mayor Repairs",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(5,4,"",1,0,"C");
    $pdf->Cell(0,5,"Pembuatan / Construction",0,0,"L");
    $pdf->Ln();
} elseif ($LAYANAN == "Perbaikan") {
    $pdf->Cell(5,4,"",1,0,"C");
    $pdf->Cell(0,5,"Perawatan / Minor Repair",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(5,4,"X",1,0,"C");
    $pdf->Cell(0,5,"Perbaikan / Mayor Repair",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(5,4,"",1,0,"C");
    $pdf->Cell(0,5,"Pembuatan / Construction",0,0,"L");
    $pdf->Ln();
} else {
    $pdf->Cell(5,4,"",1,0,"C");
    $pdf->Cell(0,5,"Perawatan / Minor Repairs",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(5,4,"",1,0,"C");
    $pdf->Cell(0,5,"Perbaikan / Mayor Repairs",0,0,"L");
    $pdf->Ln();
    $pdf->Cell(5,4,"X",1,0,"C");
    $pdf->Cell(0,5,"Pembuatan / Construction",0,0,"L");
    $pdf->Ln();
}
// End 2 Content

// 3 Content
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95,5,"Uraian Perbaikan / Description of Damage :",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(95,5,"*) Diisi oleh Pemohon / Filled by Applicant",0,0,"R");
$pdf->Ln();
$pdf->Cell(190,5,$KERUSAKAN,0,0,"L");
$pdf->Ln(30);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95);
$pdf->Cell(47.5,5,"Dilaporkan oleh,",0,0,"L");
$pdf->Cell(47.5,5,"Diterima oleh,",0,0,"L");
$pdf->Ln(3);
$pdf->SetFont('Arial','I',7);
$pdf->Cell(95);
$pdf->Cell(47.5,5,"Reported by,",0,0,"L");
$pdf->Cell(47.5,5,"Accepted by,",0,0,"L");
$pdf->Ln(20);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95,5,"* Tanggal & Jam Mulai Rusak : " . $TGL_START . " / " . $JAM_START,0,0,"L");
$pdf->Cell(47.5,5,"Name : " . $NAMA_USER,0,0,"L");
$pdf->Cell(47.5,5,"Name : ",0,0,"L");
$pdf->Ln();
$pdf->SetFont('Arial','I',7);
$pdf->Cell(95,5,"* Date & Time of Damage",0,0,"L");
$pdf->SetFont('Arial','B',7);
$pdf->Cell(47.5,5,"Jabatan / Position : ",0,0,"L");
$pdf->Cell(47.5,5,"Jabatan / Position : ",0,0,"L");
$pdf->Ln();
// End 3 Content

// 4 Content
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95,5,"Tindakan Perbaikan / Corrective Action :",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(95,5,"*) Diisi oleh Teknisi / Filled by Technician",0,0,"R");
$pdf->Ln();
$pdf->Cell(190,5,$SOLUSI,0,0,"L");
$pdf->Ln(30);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95,5,"* Tanggal & Jam Perbaikan : " . $TGL_START . " / " . $JAM_START,0,0,"L");
$pdf->Cell(95,5,"* Tanggal & Jam Selesai : " . $TGL_END . " / " . $JAM_END,0,0,"L");
$pdf->Ln();
$pdf->SetFont('Arial','I',7);
$pdf->Cell(95,5,"* Date & Time of Repaired",0,0,"L");
$pdf->Cell(95,5,"* Date & Time of Completed",0,0,"L");
$pdf->Ln();
// End 4 Content

// 5 Content
$pdf->SetFont('Arial','B',7);
$pdf->Cell(95,5,"Cek Higenis dan Verifikasi / Hygiene Check and Verification :",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(95,5,"*) Diisi oleh Pemohon / Filled by Applicant",0,0,"R");
$pdf->Ln();
$pdf->Cell(190,5,$KET_VERIFIKASI,0,0,"L");
$pdf->Ln(50);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(47.5);
$pdf->Cell(47.5,5,"Diperbaiki oleh,",0,0,"L");
$pdf->Cell(47.5,5,"Diverifikasi oleh,",0,0,"L");
$pdf->Cell(47.5,5,"Disetujui oleh,",0,0,"L");
$pdf->Ln(3);
$pdf->SetFont('Arial','I',7);
$pdf->Cell(47.5);
$pdf->Cell(47.5,5,"Repaired by,",0,0,"L");
$pdf->Cell(47.5,5,"Verified by,",0,0,"L");
$pdf->Cell(47.5,5,"Approved by,",0,0,"L");
$pdf->Ln(20);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(47.5);
$pdf->Cell(47.5,5,"Name : " . $NAMA_TEKNISI,0,0,"L");
$pdf->Cell(47.5,5,"Name : ",0,0,"L");
$pdf->Cell(47.5,5,"Pemohon / Applicant : " . $NAMA_USER,0,0,"L");
$pdf->Ln();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(47.5);
$pdf->Cell(47.5,5,"Dept. " . $NAMA_JENIS,0,0,"L");
$pdf->Cell(47.5,5,"QC Responsible / Applicant",0,0,"L");
$pdf->Cell(47.5,5,"Jabatan / Position : ",0,0,"L");
// End 5 Content

// Format Page Portrait/Landscape, Type of Paper, Rotation
$pdf->Output("Laporan Permohonan dan Laporan Perbaikan " . $KODE_PERBAIKAN . ".pdf","I");
// }
?>