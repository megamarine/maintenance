<?php
	require_once("module/model/koneksi/koneksi.php");
    require('fpdf/fpdf.php');
    
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
                t.BAGIAN,
                t.STATUS_DOWNTIME,
                t.DURASI,
                t.LOKASI,
                e.NAMA_TEKNISI,
                DATE_FORMAT(t.TGL_START, '%d %M %Y') as TGL_START,
                DATE_FORMAT(t.TGL_PERBAIKAN, '%d %M %Y') as TGL_PERBAIKAN,
                DATE_FORMAT(t.TGL_SELESAI, '%d %M %Y') as TGL_SELESAI,
                DATE_FORMAT(t.TGL_END, '%d %M %Y') as TGL_END,
                DATE_FORMAT(t.TGL_START, '%H:%i:%s') as JAM_START,
                DATE_FORMAT(t.TGL_PERBAIKAN, '%H:%i:%s') as JAM_PERBAIKAN,
                DATE_FORMAT(t.TGL_SELESAI, '%H:%i:%s') as JAM_SELESAI,
                DATE_FORMAT(t.TGL_END, '%H:%i:%s') as JAM_END,
                j.NAMA_JENIS, 
                n.NAMA_DEPARTEMEN AS DEPARTEMEN, 
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
        if($STATUS_DOWNTIME == "YA")
        {
            $STATUS_DOWNTIME = "Downtime";
        }
        else
        {
            $STATUS_DOWNTIME = "Minor";
        }
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
			if ($KODE_PERUSAHAAN == 1) 
            {
                $this->SetFont('Arial','B',12);
                $this->Image('../image/images/logommp.png',10,9,30);
                $this->Ln(1);
				$this->Cell(26);
                $this->Cell(114,5,"PT. MEGA MARINE PRIDE",0,0,"C");

                $this->SetFont('Arial','',7);
                $this->Cell(20,5,"Tanggal / Date",0,0,"L");
                $this->Cell(5,5,": " . $TGL_START,0,0,"L");
                $this->Ln(3);
                $this->Cell(140);

                $this->Ln(4);
                $this->Cell(140);
                $this->Cell(20,5,"No Pengajuan /  ",0,0,"L");
                $this->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");
                $this->Ln(4);
                $this->Cell(140);
                $this->SetFont('Arial','I',7);
                $this->Cell(20,5,"Submition Number",0,0,"L");
                $this->Cell(140);
			}
			else
            {
                $this->Image('../image/images/logobb.jpg',16,11,15);
                $this->Ln(1);
				$this->Cell(26);
                $this->Cell(114,5,"PT. BARAMUDA BAHARI",0,0,"C");
                $this->SetFont('Arial','',7);
                $this->Cell(20,5,"Tanggal / Date",0,0,"L");
                $this->Cell(5,5,": " . $TGL_START,0,0,"L");
                $this->Ln(3);
                $this->Cell(140);

                $this->Ln(4);
                $this->Cell(140);
                $this->Cell(20,5,"No Pengajuan /  ",0,0,"L");
                $this->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");
                $this->Ln(4);
                $this->Cell(140);
                $this->SetFont('Arial','I',7);
                $this->Cell(20,5,"Submition Number",0,0,"L");
                $this->Cell(140);
			}

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

//border
$pdf->Line(10, 10,10,140); // V border kiri atas
$pdf->Line(10, 148,10,278); // V border kiri bawah
$pdf->Line(200, 10,200,140); // V border kanan atas
$pdf->Line(200, 148,200,278); // V border kanan bawah

$pdf->Line(10, 10, 210-10, 10); // Horizontal Line 
$pdf->Line(10, 27, 210-10, 27); // Horizontal Line 
$pdf->Line(36, 17, 160-10, 17); // Horizontal Line 
$pdf->Line(200, 17, 200-50, 17); // Horizontal Line 
$pdf->Line(36, 10,36,37-10); // Vetical line Header
$pdf->Line(150, 10,150,37-10); // Vetical line Header

$pdf->Line(10, 36, 210-10, 36); // Horizontal Line
$pdf->Line(105, 36,105,27); // Vetical line Header

$pdf->Line(105, 58,105,66); // Vetical line Header
$pdf->Line(10, 58, 210-10, 58); // Horizontal Line
$pdf->Line(10, 66, 210-10, 66); // Horizontal Line
$pdf->Line(10, 84, 210-10, 84); // Horizontal Line

$pdf->Line(105, 92,105,84); // Vetical line Header

///POMOHON/DITERIMA//DIPERBAIKI//DIVERIFIKASI/DISETUJUI
$pdf->Line(10, 92, 210-10, 92); // Horizontal Line
$pdf->Line(10, 104, 210-10, 104); // Horizontal Line
$pdf->Line(10, 120, 210-10, 120); // Horizontal Line
$pdf->Line(10, 140, 210-10, 140); // Horizontal Line
$pdf->Line(45, 136,45,92); // Vetical line Header
$pdf->Line(83, 136,83,92); // Vetical line Header
$pdf->Line(121, 136,121,92); // Vetical line Header
$pdf->Line(159, 136,159,92); // Vetical line Header

//FRM-ENG
$pdf->Line(10, 136, 210-10, 136); // Horizontal Line

//HEADER FORM BAWAH
$pdf->Line(36, 148,36,165); // Vetical line Header
$pdf->Line(150, 148,150,165); // Vetical line Header
$pdf->Line(10, 148, 200, 148); // Horizontal Line
$pdf->Line(36, 155, 200, 155); // Horizontal Line
$pdf->Line(10, 165, 200, 165); // Horizontal Line
$pdf->Line(10, 174, 210-10, 174); // Horizontal Line
$pdf->Line(10, 196, 210-10, 196); // Horizontal Line
$pdf->Line(105, 174,105,165); // Vetical line Header

$pdf->Line(10, 204, 200, 204); // Horizontal Line
$pdf->Line(10, 222, 200, 222); // Horizontal Line
$pdf->Line(10, 230, 200, 230); // Horizontal Line
$pdf->Line(105, 204,105,196); // Vetical line Header
$pdf->Line(105, 230,105,222); // Vetical line Header

///POMOHON/DITERIMA//DIPERBAIKI//DIVERIFIKASI/DISETUJUI
$pdf->Line(10, 241, 200, 241); // Horizontal Line
$pdf->Line(10, 257, 200, 257); // Horizontal Line
$pdf->Line(10, 274, 200, 274); // Horizontal Line
$pdf->Line(10, 278, 200, 278); // Horizontal Line
$pdf->Line(45, 274,45,230); // Vetical line Header
$pdf->Line(83, 274,83,230); // Vetical line Header
$pdf->Line(121, 274,121,230); // Vetical line Header
$pdf->Line(159, 274,159,230); // Vetical line Header

$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,5,"Divisi / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(23,5,"Division ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(62,5,": " . $NAMA_BAGIAN,0,0,"L");

$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,5,"Nama Alat / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(30,5,"Equipment Name ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": " . $NAMA_BARANG,0,0,"L");
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,3,"Bagian / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(23,3,"Section ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(62,3,": " . $DEPARTEMEN,0,0,"L");

$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,3,"Lokasi Alat / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(30,3,"Location of Equipment ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,3,": " . $LOKASI,0,0,"L");
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,6,"Pengajuan / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(18,6,"Submition ",0,0,"L");
$pdf->SetFont('Arial','B',7);
$pdf->Cell(30,6,": " . $BAGIAN." (".$STATUS_DOWNTIME.")",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Ln(4);
$pdf->Cell(34,6,"",0,0,"L");
$pdf->Cell(10,6,$KERUSAKAN,0,0,"L");

$pdf->Ln(19);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(33,5,"Tgl & Jam Rusak /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(62,5,": " . $TGL_START." / ". $JAM_START,0,0,"L");
$pdf->SetFont('Arial','B',7);
$pdf->Cell(45,5,"Tgl & Jam Mulai Diperbaiki /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": " . $TGL_PERBAIKAN." / ". $JAM_PERBAIKAN,0,0,"L");

$pdf->Ln();
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(95,2,"Date & Time Start Damage",0,0,"L");
$pdf->Cell(65,2,"Date & Time Start Repair",0,0,"L");
$pdf->Ln(3);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(33,5,"Tindakan Perbaikan /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": " . $SOLUSI,0,0,"L");
$pdf->Ln();
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(45,1,"Corrective Action",0,0,"L");
$pdf->Ln(13);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(37,5,"Tgl & Jam Selesai Diperbaiki /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(58,5,": " . $TGL_SELESAI." / ". $JAM_SELESAI,0,0,"L");
$pdf->SetFont('Arial','B',7);
$pdf->Cell(45,5,"Cek Hygiene setelah perbaikan /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": ",0,0,"L");
$pdf->Ln();

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(95,1,"Date & Time Finish",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(45,1,"Hygiene check after repaired",0,0,"L");
$pdf->Ln(7);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,1,"",0,0,"L");
$pdf->Cell(35,1,"Pemohon / ",0,0,"L");
$pdf->Cell(35,1,"Diterima Oleh / ",0,0,"L");
$pdf->Cell(39,1,"Diperbaiki Oleh / ",0,0,"L");
$pdf->Cell(41,1,"Diverifikasi Oleh / ",0,0,"L");
$pdf->Cell(35,1,"Disetujui Oleh / ",0,0,"L");
$pdf->Ln(4);

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(8);
$pdf->Cell(37.5,1,"Reported by,",0,0,"L");
$pdf->Cell(38,1,"Accepted by,",0,0,"L");
$pdf->Cell(40,1,"Repair by,",0,0,"L");
$pdf->Cell(37,1,"Verified by,",0,0,"L");
$pdf->Cell(38,1,"Approved by,",0,0,"L");
$pdf->Ln(22);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(25,1,": ".$NAMA_USER,0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ".$NAMA_TEKNISI,0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");

$pdf->Ln(3);
$pdf->SetFont('Arial','I',7);
$pdf->Cell(35,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");

$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(25,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(25,1,": ",0,0,"L");

$pdf->Ln(3);
$pdf->SetFont('Arial','I',7);
$pdf->Cell(35,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Ln(4.5);
$pdf->SetFont('Arial','',7);
$pdf->Cell(163);
$pdf->Cell(38,1,"FRM-ENG-005-Rev.02",0,0,"L");

//////////////////////////////////////////////////////////////////

$pdf->Ln(11);

if($KODE_PERUSAHAAN == 1)
{
    $pdf->SetFont('Arial','B',12);
    $pdf->Image('../image/images/logommp.png',10,147,30);
    $pdf->Ln();
    $pdf->Cell(26);
    $pdf->Cell(114,5,"PT. MEGA MARINE PRIDE",0,0,"C");

    $pdf->SetFont('Arial','',7);
    $pdf->Cell(20,5,"Tanggal / Date",0,0,"L");
    $pdf->Cell(5,5,": " . $TGL_START,0,0,"L");
    $pdf->Ln(1);
    $pdf->Cell(140);

    $pdf->Ln(5);
    $pdf->Cell(140);
    $pdf->Cell(20,5,"No Pengajuan /  ",0,0,"L");
    $pdf->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");
    $pdf->Ln(4);
    $pdf->Cell(140);
    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(20,5,"Submition Number",0,0,"L");
    $pdf->Cell(140);

    $pdf->Ln(-4);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(26);
    $pdf->Cell(114,5,"PERMOHONAN & LAPORAN PERBAIKAN",0,0,"C");
    $pdf->Ln();
    $pdf->SetFont('Arial','BI',10);
    $pdf->Cell(26);
    $pdf->Cell(114,5,"APPLICATION & REPARATION REPORT",0,0,"C");
}
else
{
    $pdf->SetFont('Arial','B',12);
    $pdf->Image('../image/images/logobb.jpg',15,149,15);
    $pdf->Ln();
    $pdf->Cell(26);
    $pdf->Cell(114,5,"PT. BARAMUDA BAHARI",0,0,"C");

    $pdf->SetFont('Arial','',7);
    $pdf->Cell(20,5,"Tanggal / Date",0,0,"L");
    $pdf->Cell(5,5,": " . $TGL_START,0,0,"L");
    $pdf->Ln(1);
    $pdf->Cell(140);

    $pdf->Ln(5);
    $pdf->Cell(140);
    $pdf->Cell(20,5,"No Pengajuan /  ",0,0,"L");
    $pdf->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");
    $pdf->Ln(4);
    $pdf->Cell(140);
    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(20,5,"Submition Number",0,0,"L");
    $pdf->Cell(140);

    $pdf->Ln(-4);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(26);
    $pdf->Cell(114,5,"PERMOHONAN & LAPORAN PERBAIKAN",0,0,"C");
    $pdf->Ln();
    $pdf->SetFont('Arial','BI',10);
    $pdf->Cell(26);
    $pdf->Cell(114,5,"APPLICATION & REPARATION REPORT",0,0,"C");
}

$pdf->Ln();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,5,"Divisi / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(23,5,"Division ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(62,5,": " . $NAMA_BAGIAN,0,0,"L");

$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,5,"Nama Alat / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(30,5,"Equipment Name ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": " . $NAMA_BARANG,0,0,"L");
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,3,"Bagian / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(23,3,"Section ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(62,3,": " . $DEPARTEMEN,0,0,"L");

$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,3,"Lokasi Alat / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(30,3,"Location of Equipment ",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,3,": " . $LOKASI,0,0,"L");
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,6,"Pengajuan / ",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(18,6,"Submition ",0,0,"L");
$pdf->SetFont('Arial','B',7);
$pdf->Cell(30,6,": " . $BAGIAN." (".$STATUS_DOWNTIME.")",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Ln(4);
$pdf->Cell(34,6,"",0,0,"L");
$pdf->Cell(80,6,$KERUSAKAN,0,0,"L");
$pdf->Ln(18.5);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(33,5,"Tgl & Jam Rusak /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(62,5,": " . $TGL_START." / ". $JAM_START,0,0,"L");
$pdf->SetFont('Arial','B',7);
$pdf->Cell(45,5,"Tgl & Jam Mulai Diperbaiki /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": " . $TGL_PERBAIKAN." / ". $JAM_PERBAIKAN,0,0,"L");

$pdf->Ln();
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(95,2,"Date & Time Start Damage",0,0,"L");
$pdf->Cell(65,2,"Date & Time Start Repair",0,0,"L");
$pdf->Ln(4);


$pdf->SetFont('Arial','B',7);
$pdf->Cell(33,5,"Tindakan Perbaikan /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": " . $SOLUSI,0,0,"L");
$pdf->Ln();
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(45,1,"Corrective Action",0,0,"L");
$pdf->Ln(12.5);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(37,5,"Tgl & Jam Selesai Diperbaiki /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(58,5,": " . $TGL_SELESAI." / ". $JAM_SELESAI,0,0,"L");
$pdf->SetFont('Arial','B',7);
$pdf->Cell(45,5,"Cek Hygiene setelah perbaikan /",0,0,"L");
$pdf->SetFont('Arial','',7);
$pdf->Cell(65,5,": ",0,0,"L");
$pdf->Ln();

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(95,1,"Date & Time Finish",0,0,"L");
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(45,1,"Hygiene check after repaired",0,0,"L");
$pdf->Ln(6);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,1,"",0,0,"L");
$pdf->Cell(35,1,"Pemohon / ",0,0,"L");
$pdf->Cell(35,1,"Diterima Oleh / ",0,0,"L");
$pdf->Cell(39,1,"Diperbaiki Oleh / ",0,0,"L");
$pdf->Cell(41,1,"Diverifikasi Oleh / ",0,0,"L");
$pdf->Cell(35,1,"Disetujui Oleh / ",0,0,"L");
$pdf->Ln(4);

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(8);
$pdf->Cell(37.5,1,"Reported by,",0,0,"L");
$pdf->Cell(38,1,"Accepted by,",0,0,"L");
$pdf->Cell(40,1,"Repair by,",0,0,"L");
$pdf->Cell(37,1,"Verified by,",0,0,"L");
$pdf->Cell(38,1,"Approved by,",0,0,"L");
$pdf->Ln(22);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(25,1,": ".$NAMA_USER,0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ".$NAMA_TEKNISI,0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Nama/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");

$pdf->Ln(3);
$pdf->SetFont('Arial','I',7);
$pdf->Cell(35,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");
$pdf->Cell(38,1,"Name",0,0,"L");

$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(25,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(28,1,": ",0,0,"L");
$pdf->Cell(10,1,"Jabatan/",0,0,"L");
$pdf->Cell(25,1,": ",0,0,"L");

$pdf->Ln(3);
$pdf->SetFont('Arial','I',7);
$pdf->Cell(35,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Cell(38,1,"Position",0,0,"L");
$pdf->Ln(5);
$pdf->SetFont('Arial','',7);
$pdf->Cell(163);
$pdf->Cell(38,1,"FRM-ENG-005-Rev.02",0,0,"L");

// $pdf->Ln(-5);
// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(26);
// $pdf->Cell(114,5,"PERMOHONAN & LAPORAN PERBAIKAN",0,0,"C");
// $pdf->Ln();
// $pdf->SetFont('Arial','BI',10);
// $pdf->Cell(26);
// $pdf->Cell(114,5,"APPLICATION & REPARATION REPORT",0,0,"C");
// $pdf->Ln();
// Format Page Portrait/Landscape, Type of Paper, Rotation
$pdf->Output("Laporan Permohonan dan Laporan Perbaikan " . $KODE_PERBAIKAN . ".pdf","I");
// }
?>