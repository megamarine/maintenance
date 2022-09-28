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
    $result1        = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER','$IP_ADDRESS','$PC_NAME','$DINO','Laporan','Cetak Laporan','Cetak Laporan Kinerja Teknisi Kode $KODE_TEKNISI')"); 
    $result1->execute();

    $result2 = GetQuery(
    "select p.KODE_PERBAIKAN,
        b.NAMA_BARANG,
        p.IP_ADD,
        p.LAYANAN,
        p.KERUSAKAN,
        p.SOLUSI,
        DATE_FORMAT(TGL_START, '%d-%m-%Y') as TGL_START,
        DATE_FORMAT(TGL_END, '%d-%m-%Y') as TGL_END,
        DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
        DATE_FORMAT(TGL_END, '%H:%i:%s') as JAM_END,
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

    class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            $KODE_TEKNISI   = $_GET["KODE_TEKNISI"];
            $PERIODE        = $_GET["PERIODE"];
            $PERIODE2       = $_GET["PERIODE2"];

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
            while ($row4 = $result4->fetch(PDO::FETCH_ASSOC)) {
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
            $this->Cell(0,5,"Laporan Hasil Kinerja",0,0,"C");
            $this->Ln(10);
            
            // Line break
            $this->SetFont('Arial','B',9);
            $this->Cell(0,0,$ID_KARYAWAN . " - " . $NAMA_TEKNISI . "",0,0,'C');
            $this->Ln(10);
            $this->SetFont('Arial','B',8);
            $this->Cell(25,5,"Kode Perbaikan",1,0,"C");
            $this->Cell(35,5,"Departemen",1,0,"C");
            $this->Cell(20,5,"Tgl Pengajuan",1,0,"C");
            $this->Cell(16,5,"Tgl Selesai",1,0,"C");
            $this->Cell(30,5,"Barang",1,0,"C");
            $this->Cell(19,5,"Layanan",1,0,"C");
            $this->Cell(70,5,"Kerusakan",1,0,"C");
            $this->Cell(65,5,"Hasil Perbaikan",1,0,"C");
            // $this->Cell(15,5,"Durasi",1,0,"C");
            // $this->Cell(15,5,"Hasil",1,0,"C");
            $this->Ln();
        }

        // Page footer
        function Footer()
        {   
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered page number
            $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
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
$pdf = new PDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',7);
while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
    extract($row2);
    $pdf->Cell(25,10,$KODE_PERBAIKAN,1,0,"C");
    $pdf->Cell(35,10,$NAMA_DEPARTEMEN,1,0,"C");
    $pdf->Cell(20,10,$TGL_START,1,0,"C"); 
    $pdf->Cell(16,10,$TGL_END,1,0,"C"); 
    $pdf->Cell(30,10,truncate(strtolower($NAMA_BARANG),20)." ".$IP_ADD,1,0,"L");
    $pdf->Cell(19,10,$LAYANAN,1,0,"C");
    $pdf->Cell(70,10,truncate(strtolower($KERUSAKAN),60),1,0,"L");
    $pdf->Cell(65,10,truncate($SOLUSI,45),1,0,"L");
    // $pdf->Cell(15,10,$DURASI,1,0,"C");
    // $pdf->Cell(15,10,$HASIL,1,0,"C");
    $pdf->Ln();
}
// $pdf->SetFont('Arial','BU',8);
// $pdf->Cell(250,7,"Total Durasi dan Rata-rata Nilai",1,0,"C");
// $pdf->Cell(15,7,$DURASI2,1,0,"C");
// $pdf->Cell(15,7,$HASIL2,1,0,"C");
// Format Page Portrait/Landscape, Type of Paper, Rotation
$pdf->Output("Laporan Detail Hasil Kinerja ".$NAMA_TEKNISI." Periode " . $PERIODE . " - " . $PERIODE2 . ".pdf","I");
// }
?>