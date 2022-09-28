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

    $KODE_TEKNISI   = $_GET["KODE_TEKNISI"];
    $PERIODE        = $_GET["PERIODE"];
    $PERIODE2       = $_GET["PERIODE2"];
	$DINO           = date('Y-m-d H:i:s');
	$ID_USER        = $_SESSION["LOGINIDUS_MT"];
	$IP_ADDRESS     = $_SESSION["IP_ADDRESS_MT"];
    $PC_NAME        = $_SESSION["PC_NAME_MT"];
    
	$result1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER','$IP_ADDRESS','$PC_NAME','$DINO','Laporan','Cetak Laporan','Cetak Laporan Kinerja Teknisi Kode $KODE_TEKNISI')"); 
	$result1->execute();

    $result2 = GetQuery(
       "select p.KODE_PERBAIKAN,
        b.NAMA_BARANG,
        p.LAYANAN,
        p.KERUSAKAN,
        p.SOLUSI,
        DATE_FORMAT(TGL_START, '%d-%m-%Y') as TGL_START,
        DATE_FORMAT(TGL_SELESAI, '%d-%m-%Y') as TGL_END,
        DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
        DATE_FORMAT(TGL_SELESAI, '%H:%i:%s') as JAM_END,
        p.TGL_START as TGL_STARTS,
        p.TGL_END as TGL_ENDS,
        p.DURASI,
        p.HASIL,
        e.NAMA_DEPARTEMEN,
        t.NAMA_TEKNISI 
       from d_perbaikan d, 
        t_perbaikan p, 
        m_barang b, 
        m_departemen e, 
        m_teknisi t 
       where d.KODE_PERBAIKAN = p.KODE_PERBAIKAN and 
        p.KODE_BARANG = b.KODE_BARANG and 
        p.KODE_DEPARTEMEN = e.KODE_DEPARTEMEN and 
        d.KODE_TEKNISI = t.KODE_TEKNISI and 
        date(p.TGL_SELESAI) between '$PERIODE' and '$PERIODE2' and 
        d.KODE_TEKNISI = '$KODE_TEKNISI' and 
        d.STS_HAPUS = 0 and 
        p.HASIL is not null 
       group by p.KODE_PERBAIKAN");
    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
        extract($row2);
    }

    $result3 = GetQuery(
       "select sum(p.DURASI) as DURASI2, 
        avg(p.HASIL) as HASIL2,
        t.HARI_KERJA,
        t.JAM_KERJA 
        from t_perbaikan p, 
        d_perbaikan d, 
        m_teknisi t 
       where p.KODE_PERBAIKAN = d.KODE_PERBAIKAN and 
        d.KODE_TEKNISI = t.KODE_TEKNISI and 
        d.KODE_TEKNISI = '$KODE_TEKNISI' and 
        date(p.TGL_SELESAI) between '$PERIODE' and '$PERIODE2' and 
        d.STS_HAPUS = 0 and 
        p.HASIL is not null");
    while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
        extract($row3);
        $HASIL2 = round($HASIL2);
    }
    
    // Get Total Weekday
    $resultWork = GetQuery("select 5 * (DATEDIFF('$PERIODE2', '$PERIODE') DIV 7) + MID('0123444401233334012222340111123400012345001234550', 7 * WEEKDAY('$PERIODE') + WEEKDAY('$PERIODE2') + 1, 1) as WORKDAY");
    while ($rowWork = $resultWork->fetch(PDO::FETCH_ASSOC)) {
        extract($rowWork);
    }
    // End Get Total Weekday
    
    $resultLembur = GetQuery(
        "select count(KODE_HADIR) as TOTAL_LEMBUR 
        from t_kehadiran 
        where TANGGAL between '$PERIODE' and '$PERIODE2' and 
        STATUS_ABSENSI = 0 and 
        KODE_TEKNISI = '$KODE_TEKNISI' and 
        ABSENSI = 'Lembur' and 
        weekday(TANGGAL) between 5 and 6");
    while ($rowLembur = $resultLembur->fetch(PDO::FETCH_ASSOC)) {
        extract($rowLembur);
    }
    
    $resultCuti = GetQuery(
        "select count(KODE_HADIR) as TOTAL_CUTI 
        from t_kehadiran 
        where TANGGAL between '$PERIODE' and '$PERIODE2' and 
        STATUS_ABSENSI = 0 and 
        KODE_TEKNISI = '$KODE_TEKNISI' and 
        ABSENSI = 'Cuti'");
    while ($rowCuti = $resultCuti->fetch(PDO::FETCH_ASSOC)) {
        extract($rowCuti);
    }
    
    $TOTAL_KERJA        = ($WORKDAY + $TOTAL_LEMBUR - $TOTAL_CUTI) * $JAM_KERJA;
    $REALISASI_KERJA    = ($DURASI2 / $TOTAL_KERJA) * 100;
    $TOTAL_HASIL_KERJA  = ($DURASI2 / $TOTAL_KERJA) * 50;
    $REALISASI_NILAI    = ($HASIL2 / 5) * 100;
    $TOTAL_HASIL_NILAI  = ($HASIL2 / 5) * 50;
    $TOTAL_KERJA_NILAI  = $TOTAL_HASIL_KERJA + $TOTAL_HASIL_NILAI;
    
    if ($TOTAL_KERJA_NILAI > 100) {
        $TOTAL_KERJA_NILAI = 100;
    }
    
    if ($TOTAL_KERJA_NILAI > 90) {
        $HURUF_NILAI = "A";
    } elseif ($TOTAL_KERJA_NILAI > 80) {
        $HURUF_NILAI = "B";
    } elseif ($TOTAL_KERJA_NILAI > 70) {
        $HURUF_NILAI = "C";
    } else {
        $HURUF_NILAI = "D";
    }

	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
            $DATENOW      = date("d F Y");
            $KODE_TEKNISI = $_GET["KODE_TEKNISI"];
            $PERIODE      = $_GET["PERIODE"];
            $PERIODE2     = $_GET["PERIODE2"];
            $date1        = date("d F Y", strtotime($PERIODE));
            $date2        = date("d F Y", strtotime($PERIODE2));

            $result4 = GetQuery(
               "select t.*,
                j.NAMA_JENIS,
                p.NAMA_PERUSAHAAN 
               from m_teknisi t, 
                m_jenisbrg j, 
                m_perusahaan p 
               where t.KODE_JENIS = j.KODE_JENIS and 
                t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
                t.KODE_TEKNISI = '$KODE_TEKNISI'");
            while ($row4 = $result4->fetch(PDO::FETCH_ASSOC)) 
            {
                extract($row4);
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
            $this->Cell(65,5,"No. Doc : ",0,0,"R");
		    $this->Ln(4);
		    $this->Cell(25);
            $this->Write(5,"Phone (62-343) 656513 - 656446 Fax. (62-343) 656195");
            $this->Cell(76.5,5,"Tanggal / Date : ",0,0,"R");
            $this->Cell(15.5,5,$DATENOW,0,0,"L");
		    $this->Ln(4);
		    $this->Cell(25);
            $this->Write(5,"PO Box. 6135/SBSG, Surabaya 60061 - Indonesia");
            $this->Cell(82,5,"Halaman / Page : ",0,0,"R");
            $this->Cell(15.5,5,$this->PageNo().' / {nb}',0,0,"L");
		    $this->Ln(10);
		    // Arial italic 8
		    $this->SetFont('Arial','I',8);
		    // Page number
		    // $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');
		    // Line break
		    $this->Ln(10);
		    $this->SetFont('Arial','BU',10);
		    $this->Cell(0,5,"INDIKATOR KINERJA UTAMA / KEY PERFORMANCE INDICATOR (KPI)",0,0,"C");
            $this->Ln(20);
            
            // Line break
            $this->SetFont('Arial','',7);
            $this->Cell(25,5,"Name / Nama ",0,0,'L');
            $this->Cell(5,5,":",0,0,'C');
            $this->Cell(25,5,$NAMA_TEKNISI,0,0,'L');
            $this->Cell(25,5,"",0,0,'L');
            $this->Cell(25,5,"Periode / Period",0,0,'L');
            $this->Cell(5,5,":",0,0,'C');
            $this->Cell(25,5,$date1 . " - " . $date2,0,0,'L');
            $this->Ln();
            $this->Cell(25,5,"No. ID / ID. No ",0,0,'L');
            $this->Cell(5,5,":",0,0,'C');
            $this->Cell(25,5,$ID_KARYAWAN,0,0,'L');
            $this->Cell(25,5,"",0,0,'L');
            $this->Cell(25,5,"Batas Akhir / Due Date",0,0,'L');
            $this->Cell(5,5,":",0,0,'C');
            $this->Cell(25,5,"",0,0,'L');
            $this->Ln();
            $this->Cell(25,5,"Bagian / Section ",0,0,'L');
            $this->Cell(5,5,":",0,0,'C');
            $this->Cell(25,5,$NAMA_JENIS,0,0,'L');
            $this->Ln();
            $this->Cell(25,5,"Jabatan / Position ",0,0,'L');
            $this->Cell(5,5,":",0,0,'C');
            $this->Cell(25,5,$JABATAN,0,0,'L');

            $this->Ln(10);
            $this->SetFont('Arial','B',8);
            $this->Cell(10,5,"",0,0,"C");
            $this->Cell(10,5,"No.",1,0,"C");
            $this->Cell(50,5,"Item",1,0,"C");
            $this->Cell(20,5,"Bobot",1,0,"C");
            $this->Cell(20,5,"Target",1,0,"C");
            $this->Cell(20,5,"Realisasi",1,0,"C");
            $this->Cell(25,5,"Skor Realisasi",1,0,"C");
            $this->Cell(20,5,"Skor Akhir",1,0,"C");
            $this->Ln();
		}

		// Page footer
		function Footer()
		{	
            $DATENOW = date("d F Y");

            $KODE_TEKNISI = $_GET["KODE_TEKNISI"];
            $PERIODE = $_GET["PERIODE"];
            $PERIODE2 = $_GET["PERIODE2"];

            $date1 = date("d F Y", strtotime($PERIODE));
            $date2 = date("d F Y", strtotime($PERIODE2));

            $result2 = GetQuery("select NAMA_TEKNISI,KODE_JENIS from m_teknisi where KODE_TEKNISI = '$KODE_TEKNISI'");
            while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                extract($row2);
            }

            $result3 = GetQuery("select NAMA_TEKNISI as MANAGER from m_teknisi where KODE_JENIS = '$KODE_JENIS' and JABATAN = 'Manager'");
            while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
                extract($row3);
            }
            // Go to 1.5 cm from bottom
            $this->SetY(-95);
            // Select Arial italic 8
            $this->SetFont('Arial','B',7);
            $this->Cell(0,5,"DITANDA TANGANI SEBELUM PERIODE / SIGNED BEFORE THE PERIOD : ",1,0,"C");
            $this->Ln();
            $this->SetFont('Arial','',7);
            $this->Cell(25,5,"Tanggal / Date : ",0,0,"L");
            $this->Ln();
            $this->SetFont('Arial','B',7);
            $this->Cell(50,5,"Pemilik KPI / Owner of KPI,",0,0,"C");
            $this->Cell(90,5,"",0,0,"L");
            $this->Cell(50,5,"Atasan Langsung / Direct Supervisor,",0,0,"C");
            $this->Ln(20);
            $this->Cell(50,5,"( " . $NAMA_TEKNISI . " )",0,0,"C");
            $this->Cell(90,5,"",0,0,"L");
            $this->Cell(50,5,"(                                                    )",0,0,"C");
            $this->Ln();
            $this->Cell(0,5,"DITANDA TANGANI SETELAH KPI / SIGNED AFTER THE EVALUATION KPI : ",1,0,"C");
            $this->Ln();
            $this->Cell(1,5,"",0,0,"C");
            $this->Cell(47,5,"Pemilik KPI / Owner of KPI,",0,0,"C");
            $this->Cell(47,5,"Atasan Langsung / Direct Supervisor,",0,0,"C");
            $this->Cell(47,5,"HR Organization Development,",0,0,"C");
            $this->Cell(47,5,"Kabag HRD / Section Head of HRD,",0,0,"C");
            $this->Ln(20);
            $this->Cell(47,5,"( " . $NAMA_TEKNISI . " )",0,0,"C");
            $this->Cell(47,5,"(                                                    )",0,0,"C");
            $this->Cell(47,5,"(                                                    )",0,0,"C");
            $this->Cell(47,5,"(                                                    )",0,0,"C");
            // Print centered page number
            // $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
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
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',7);
$pdf->Cell(10,5,"",0,0,"C");
$pdf->Cell(10,5,"1.",1,0,"C");
$pdf->Cell(50,5,"Pemeliharaan Waktu Kerja",1,0,"C");
$pdf->Cell(20,5,"50%",1,0,"C");
$pdf->Cell(20,5,$TOTAL_KERJA,1,0,"C");
$pdf->Cell(20,5,$DURASI2,1,0,"C");
$pdf->Cell(25,5,round($REALISASI_KERJA) . "%",1,0,"C");
$pdf->Cell(20,5,round($TOTAL_HASIL_KERJA) . "%",1,0,"C");
$pdf->Ln();
$pdf->Cell(10,5,"",0,0,"C");
$pdf->Cell(10,5,"2.",1,0,"C");
$pdf->Cell(50,5,"Kepuasan Pelayanan",1,0,"C");
$pdf->Cell(20,5,"50%",1,0,"C");
$pdf->Cell(20,5,"5",1,0,"C");
$pdf->Cell(20,5,$HASIL2,1,0,"C");
$pdf->Cell(25,5,round($REALISASI_NILAI) . "%",1,0,"C");
$pdf->Cell(20,5,round($TOTAL_HASIL_NILAI) . "%",1,0,"C");
$pdf->Ln();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(10,5,"",0,0,"C");
$pdf->Cell(145,5,"TOTAL KPI",1,0,"C");
$pdf->Cell(20,5,round($TOTAL_KERJA_NILAI) . "%",1,0,"C");
$pdf->Ln();
$pdf->Cell(10,5,"",0,0,"C");
$pdf->Cell(145,5,"GRADE KPI",1,0,"C");
$pdf->Cell(20,5,$HURUF_NILAI,1,0,"C");
$pdf->Ln(20);
$pdf->Cell(10,5,"Klasifikasi Nilai / Clasification Grade",0,0,"L");
$pdf->Ln();
$pdf->Cell(50,5,"Nilai Skor / Numerical Score",1,0,"C");
$pdf->Cell(35,5,"Skala Nilai / Letter Grade",1,0,"C");
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->Cell(50,5,"> 91",1,0,"C");
$pdf->Cell(35,5,"A",1,0,"C");
$pdf->Ln();
$pdf->Cell(50,5,"81 - 90",1,0,"C");
$pdf->Cell(35,5,"B",1,0,"C");
$pdf->Ln();
$pdf->Cell(50,5,"71 - 80",1,0,"C");
$pdf->Cell(35,5,"C",1,0,"C");
$pdf->Ln();
$pdf->Cell(50,5,"61 - 70",1,0,"C");
$pdf->Cell(35,5,"D",1,0,"C");
$pdf->Ln();
$pdf->Cell(50,5,"< 60",1,0,"C");
$pdf->Cell(35,5,"E",1,0,"C");
$pdf->Ln();

// Format Page Portrait/Landscape, Type of Paper, Rotation
$pdf->Output("Laporan KPI Periode " . $PERIODE . " - " . $PERIODE2 . ".pdf","I");
// }
?>