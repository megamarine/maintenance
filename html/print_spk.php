<?php
    require_once("module/model/koneksi/koneksi.php");
    require('fpdf/fpdf.php');

if($_SESSION["LOGINIDUS_MT"] == "002028" OR //Imam Fatoni
   $_SESSION["LOGINIDUS_MT"] == "419602" OR //Irsyad
   $_SESSION["LOGINIDUS_MT"] == "383655" OR //Moch Sofyan
   $_SESSION["LOGINIDUS_MT"] == "393686" OR //Endang S
   $_SESSION["LOGINIDUS_MT"] == "412412" OR //Fathul Mubin
   $_SESSION["LOGINIDUS_MT"] == "411669" OR //Whina Septi
   $_SESSION["LOGINIDUS_MT"] == "427591" OR //Okky
   $_SESSION["LOGINIDUS_MT"] == "015036" OR //Nyoto Susilo -> Civil Engineering
   $_SESSION["LOGINDEP_MT"] == "DEPT-0033") //dept IT
{
    
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
    
    if (isset($_GET['printed']) && isset($_GET['state']) && $_GET['state'] == 0 ){
        GetQuery("update t_perbaikan set STATUS_READ='2' where KODE_PERBAIKAN = '$KODE_PERBAIKAN'"); 
    }

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
        values ('$ID_USER','$IP_ADDRESS','$PC_NAME','$DINO','Laporan','Cetak Laporan Maintenance','Cetak Laporan Maintenance Kode $KODE_PERBAIKAN')"); 
    $result1->execute();

    $result2 = GetQuery(
        "select d.NAMA_DEPARTEMEN,
                b.NAMA_BARANG,
                c.NAMA_UNIT,
                t.LOKASI,
                t.BAGIAN,
                t.KERUSAKAN,
                t.KETERANGAN,
                t.STATUS_DOWNTIME,
                t.KODE_PERUSAHAAN,
                u.NAMA_USER,
                i.NAMA_BAGIAN,
                DATE_FORMAT(t.TGL_START, '%d %M %Y') as TGL_START,
                DATE_FORMAT(t.TGL_START, '%H:%i:%s') as JAM_START
           FROM t_perbaikan t
           JOIN m_barang b ON b.KODE_BARANG = t.KODE_BARANG
      LEFT JOIN m_unit c ON c.KODE_UNIT = t.KODE_UNIT
           JOIN m_user u ON u.KODE_USER = t.USER_REQ
           JOIN m_bagian i ON i.KODE_BAGIAN = u.KODE_BAGIAN
           JOIN m_departemen d ON d.KODE_DEPARTEMEN = t.KODE_DEPARTEMEN
          where t.KODE_PERBAIKAN = '$KODE_PERBAIKAN' 
       group by KODE_PERBAIKAN");

    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) 
    {
        extract($row2);

        if($STATUS_DOWNTIME == "YA")
        {
            $STATUS_DOWNTIME = "( Downtime )";
        }
        else if($STATUS_DOWNTIME == "TIDAK")
        {
            $STATUS_DOWNTIME = "( Minor )";
        }
        else
        {
            $STATUS_DOWNTIME = "";
        }

        //NOMOR FORM
        if($_SESSION["LOGINDEP_MT"] == "DEPT-0033" or $_SESSION["LOGINDEP_MT"] == "DEPT-0109") //dept IT MMP dan BB
        {
            $frm = "";
        }
        else if($_SESSION["LOGINDEP_MT"] == "DEPT-0040" and $KODE_PERUSAHAAN == 1) //Eng MMP
        {
            $frm = "FRM-ENG-005-Rev.02";
        }
        else if($_SESSION["LOGINDEP_MT"] == "DEPT-0040" and $KODE_PERUSAHAAN == 2) //Eng BB
        {
            $frm = "FRM-OPT/ENG-033 REV. 00";
        }
        else if($_SESSION["LOGINDEP_MT"] == "DEPT-0011" and $KODE_PERUSAHAAN == 1) //CE MMP
        {
            $frm = "FRM-ENG-005-Rev.02";
        }
        else if($_SESSION["LOGINDEP_MT"] == "DEPT-0011" and $KODE_PERUSAHAAN == 2) // CE BB
        {
            $frm = "FRM-OPT/ENG-033 REV. 00";
        }
    }

    $TIME = 0;

    class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            $DATENOW        = date("d F Y");
            $KODE_PERBAIKAN = $_GET["id"];
            $result = GetQuery(
                "select t.KODE_PERBAIKAN,
                        t.KODE_PERUSAHAAN,
                        DATE_FORMAT(t.TGL_START, '%d %M %Y') as TGL_START, 
                        j.NAMA_JENIS
                   FROM t_perbaikan t, 
                        m_barang b, 
                        m_jenisbrg j 
                  WHERE t.KODE_BARANG = b.KODE_BARANG AND 
                        b.KODE_JENIS = j.KODE_JENIS AND 
                        t.KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            while ($row3 = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                extract($row3);
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
    $pdf->Line(10, 10,10,147); // V border kiri atas
    $pdf->Line(200, 10,200,147); // V border kanan atas
    // $pdf->Line(10, 148,10,278); // V border kiri bawah
    // $pdf->Line(200, 148,200,278); // V border kanan bawah

    $pdf->Line(10, 10, 210-10, 10); // Horizontal Line 
    $pdf->Line(10, 27, 210-10, 27); // Horizontal Line 
    $pdf->Line(36, 17, 160-10, 17); // Horizontal Line 
    $pdf->Line(200, 17, 200-50, 17); // Horizontal Line 
    $pdf->Line(36, 10,36,37-10); // Vetical line Header
    $pdf->Line(150, 10,150,37-10); // Vetical line Header

    $pdf->Line(10, 41, 210-10, 41); // Horizontal Line
    $pdf->Line(105, 41,105,27); // Vetical line Header

    $pdf->Line(105, 76,105,84); // Vetical line Header
    $pdf->Line(10, 76, 210-10, 76); // Horizontal Line
    $pdf->Line(10, 84, 210-10, 84); // Horizontal Line
    $pdf->Line(10, 97, 210-10, 97); // Horizontal Line

    $pdf->Line(105, 105,105,97); // Vetical line Header

    ///POMOHON/DITERIMA//DIPERBAIKI//DIVERIFIKASI/DISETUJUI
    $pdf->Line(10, 105, 210-10, 105); // Horizontal Line
    $pdf->Line(10, 114, 210-10, 114); // Horizontal Line
    $pdf->Line(10, 127, 210-10, 127); // Horizontal Line
    $pdf->Line(10, 143, 210-10, 143); // Horizontal Line
    $pdf->Line(45, 143,45,105); // Vetical line Header
    $pdf->Line(83, 143,83,105); // Vetical line Header
    $pdf->Line(121, 143,121,105); // Vetical line Header
    $pdf->Line(159, 143,159,105); // Vetical line Header

    //FRM-ENG
    $pdf->Line(10, 147, 210-10, 147); // Horizontal Line

    // //HEADER FORM BAWAH
    // $pdf->Line(36, 148,36,165); // Vetical line Header
    // $pdf->Line(150, 148,150,165); // Vetical line Header
    // $pdf->Line(10, 148, 200, 148); // Horizontal Line
    // $pdf->Line(36, 155, 200, 155); // Horizontal Line
    // $pdf->Line(10, 165, 200, 165); // Horizontal Line
    // $pdf->Line(10, 174, 210-10, 174); // Horizontal Line
    // $pdf->Line(10, 196, 210-10, 196); // Horizontal Line
    // $pdf->Line(105, 174,105,165); // Vetical line Header

    // $pdf->Line(10, 204, 200, 204); // Horizontal Line
    // $pdf->Line(10, 222, 200, 222); // Horizontal Line
    // $pdf->Line(10, 230, 200, 230); // Horizontal Line
    // $pdf->Line(105, 204,105,196); // Vetical line Header
    // $pdf->Line(105, 230,105,222); // Vetical line Header

    // ///POMOHON/DITERIMA//DIPERBAIKI//DIVERIFIKASI/DISETUJUI
    // $pdf->Line(10, 241, 200, 241); // Horizontal Line
    // $pdf->Line(10, 257, 200, 257); // Horizontal Line
    // $pdf->Line(10, 274, 200, 274); // Horizontal Line
    // $pdf->Line(10, 278, 200, 278); // Horizontal Line
    // $pdf->Line(45, 274,45,230); // Vetical line Header
    // $pdf->Line(83, 274,83,230); // Vetical line Header
    // $pdf->Line(121, 274,121,230); // Vetical line Header
    // $pdf->Line(159, 274,159,230); // Vetical line Header

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,5,"Divisi / ",0,0,"L");
    $pdf->SetFont('Arial','BI',7);
    $pdf->Cell(23,5,"Division ",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(62,5,": " . $NAMA_BAGIAN,0,0,"L");
    // $pdf->Cell(62,5,": ",0,0,"L");

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(15,5,"Nama Alat / ",0,0,"L");
    $pdf->SetFont('Arial','BI',7);
    $pdf->Cell(30,5,"Equipment Name ",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(65,5,": ".$NAMA_BARANG,0,0,"L");
    $pdf->Ln();

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,3,"Bagian / ",0,0,"L");
    $pdf->SetFont('Arial','BI',7);
    $pdf->Cell(23,3,"Section ",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(62,3,": " . $NAMA_DEPARTEMEN,0,0,"L");
    // $pdf->Cell(62,3,": ",0,0,"L");

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(15,3,"Nama Unit / ",0,0,"L");
    $pdf->SetFont('Arial','BI',7);
    $pdf->Cell(30,3,"Unit Name ",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(65,3,": ".$NAMA_UNIT,0,0,"L");
    // $pdf->Cell(65,5,": ",0,0,"L");
    $pdf->Ln(4);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,3," ",0,0,"L");
    $pdf->SetFont('Arial','BI',7);
    $pdf->Cell(23,3," ",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(62,3," ",0,0,"L");
    // $pdf->Cell(62,3,": ",0,0,"L");

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(15,3,"Lokasi Alat / ",0,0,"L");
    $pdf->SetFont('Arial','BI',7);
    $pdf->Cell(30,3,"Location of Equipment ",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(65,3,": " . $LOKASI,0,0,"L");
    // $pdf->Cell(65,3,": ",0,0,"L");
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(15,6,"Pengajuan / ",0,0,"L");
    $pdf->SetFont('Arial','BI',7);
    $pdf->Cell(18,6,"Submition ",0,0,"L");
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(30,6,": " . $BAGIAN." ".$STATUS_DOWNTIME."",0,0,"L");
    // $pdf->Cell(30,6,": ",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Ln(4);
    $pdf->Cell(34.5,6,"",0,0,"L");
    $pdf->Cell(10,6,$KERUSAKAN,0,0,"L");
    $pdf->Ln(8);
    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(33,6,"nb",0,0,"R");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(10,6,": ".$KETERANGAN,0,0,"L");

    $pdf->Ln(23);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(33,5,"Tgl & Jam Rusak /",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(62,5,": " . $TGL_START." / ".$JAM_START,0,0,"L");
    // $pdf->Cell(62,5,": ",0,0,"L");
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(45,5,"Tgl & Jam Mulai Diperbaiki /",0,0,"L");
    $pdf->SetFont('Arial','',7);
    // $pdf->Cell(65,5,": " . $TGL_PERBAIKAN." / ". $JAM_PERBAIKAN,0,0,"L");
    $pdf->Cell(65,5,": ",0,0,"L");

    $pdf->Ln();
    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(95,2,"Date & Time Start Damage",0,0,"L");
    $pdf->Cell(65,2,"Date & Time Start Repair",0,0,"L");
    $pdf->Ln(3);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(33,5,"Tindakan Perbaikan /",0,0,"L");
    $pdf->SetFont('Arial','',7);
    // $pdf->Cell(65,5,": " . $SOLUSI,0,0,"L");
    $pdf->Cell(65,5,": ",0,0,"L");
    $pdf->Ln();
    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(45,1,"Corrective Action",0,0,"L");
    $pdf->Ln(8);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(37,5,"Tgl & Jam Selesai Diperbaiki /",0,0,"L");
    $pdf->SetFont('Arial','',7);
    // $pdf->Cell(58,5,": " . $TGL_SELESAI." / ". $JAM_SELESAI,0,0,"L");
    $pdf->Cell(58,5,": ",0,0,"L");
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(45,5,"Cek Hygiene setelah perbaikan /",0,0,"L");
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(65,5,": ",0,0,"L");
    $pdf->Ln();

    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(95,1,"Date & Time Finish",0,0,"L");
    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(45,1,"Hygiene check after repaired",0,0,"L");
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,1,"",0,0,"L");
    $pdf->Cell(35,1,"Pemohon / ",0,0,"L");
    $pdf->Cell(35,1,"Diterima Oleh / ",0,0,"L");
    $pdf->Cell(39,1,"Diperbaiki Oleh / ",0,0,"L");
    $pdf->Cell(41,1,"Diverifikasi Oleh / ",0,0,"L");
    $pdf->Cell(35,1,"Disetujui Oleh / ",0,0,"L");
    $pdf->Ln(4);

    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(8);
    $pdf->Cell(37.5,1,"Reported by,",0,0,"L");
    $pdf->Cell(38,1,"Accepted by,",0,0,"L");
    $pdf->Cell(40,1,"Repair by,",0,0,"L");
    $pdf->Cell(37,1,"Verified by,",0,0,"L");
    $pdf->Cell(38,1,"Approved by,",0,0,"L");
    $pdf->Ln(18);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(10,1,"Nama/",0,0,"L");
    $pdf->Cell(25,1,": ".$NAMA_USER,0,0,"L");
    // $pdf->Cell(25,1,": ",0,0,"L");
    $pdf->Cell(10,1,"Nama/",0,0,"L");
    $pdf->Cell(28,1,": ",0,0,"L");
    $pdf->Cell(10,1,"Nama/",0,0,"L");
    // $pdf->Cell(28,1,": ".$NAMA_TEKNISI,0,0,"L");
    $pdf->Cell(28,1,": ",0,0,"L");
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
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(188,1,"",0,0,"L");
    $pdf->Cell(1,1,$frm,0,0,"R");

    //////////////////////////////////////////////////////////////////

    // $pdf->Ln(11);

    // if($KODE_PERUSAHAAN == 1)
    // {
    //     $pdf->SetFont('Arial','B',12);
    //     $pdf->Image('../image/images/logommp.png',10,147,30);
    //     $pdf->Ln();
    //     $pdf->Cell(26);
    //     $pdf->Cell(114,5,"PT. MEGA MARINE PRIDE",0,0,"C");

    //     $pdf->SetFont('Arial','',7);
    //     $pdf->Cell(20,5,"Tanggal / Date",0,0,"L");
    //     $pdf->Cell(5,5,": " . $TGL_START,0,0,"L");
    //     $pdf->Ln(1);
    //     $pdf->Cell(140);

    //     $pdf->Ln(5);
    //     $pdf->Cell(140);
    //     $pdf->Cell(20,5,"No Pengajuan /  ",0,0,"L");
    //     $pdf->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");
    //     $pdf->Ln(4);
    //     $pdf->Cell(140);
    //     $pdf->SetFont('Arial','I',7);
    //     $pdf->Cell(20,5,"Submition Number",0,0,"L");
    //     $pdf->Cell(140);

    //     $pdf->Ln(-4);
    //     $pdf->SetFont('Arial','B',10);
    //     $pdf->Cell(26);
    //     $pdf->Cell(114,5,"PERMOHONAN & LAPORAN PERBAIKAN",0,0,"C");
    //     $pdf->Ln();
    //     $pdf->SetFont('Arial','BI',10);
    //     $pdf->Cell(26);
    //     $pdf->Cell(114,5,"APPLICATION & REPARATION REPORT",0,0,"C");
    // }
    // else
    // {
    //     $pdf->SetFont('Arial','B',12);
    //     $pdf->Image('../image/images/logobb.jpg',15,149,15);
    //     $pdf->Ln();
    //     $pdf->Cell(26);
    //     $pdf->Cell(114,5,"PT. BARAMUDA BAHARI",0,0,"C");

    //     $pdf->SetFont('Arial','',7);
    //     $pdf->Cell(20,5,"Tanggal / Date",0,0,"L");
    //     $pdf->Cell(5,5,": " . $TGL_START,0,0,"L");
    //     $pdf->Ln(1);
    //     $pdf->Cell(140);

    //     $pdf->Ln(5);
    //     $pdf->Cell(140);
    //     $pdf->Cell(20,5,"No Pengajuan /  ",0,0,"L");
    //     $pdf->Cell(5,5,": " . $KODE_PERBAIKAN,0,0,"L");
    //     $pdf->Ln(4);
    //     $pdf->Cell(140);
    //     $pdf->SetFont('Arial','I',7);
    //     $pdf->Cell(20,5,"Submition Number",0,0,"L");
    //     $pdf->Cell(140);

    //     $pdf->Ln(-4);
    //     $pdf->SetFont('Arial','B',10);
    //     $pdf->Cell(26);
    //     $pdf->Cell(114,5,"PERMOHONAN & LAPORAN PERBAIKAN",0,0,"C");
    //     $pdf->Ln();
    //     $pdf->SetFont('Arial','BI',10);
    //     $pdf->Cell(26);
    //     $pdf->Cell(114,5,"APPLICATION & REPARATION REPORT",0,0,"C");
    // }

    // $pdf->Ln();
    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(10,5,"Divisi / ",0,0,"L");
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(23,5,"Division ",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(62,5,": " . $NAMA_BAGIAN,0,0,"L");
    // $pdf->Cell(62,5,": ",0,0,"L");

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(15,5,"Nama Alat / ",0,0,"L");
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(30,5,"Equipment Name ",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(65,5,": " . $NAMA_BARANG,0,0,"L");
    // $pdf->Cell(65,5,": ",0,0,"L");
    // $pdf->Ln();

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(10,3,"Bagian / ",0,0,"L");
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(23,3,"Section ",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(62,3,": " . $DEPARTEMEN,0,0,"L");
    // $pdf->Cell(62,3,": ",0,0,"L");

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(15,3,"Lokasi Alat / ",0,0,"L");
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(30,3,"Location of Equipment ",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(65,3,": " . $LOKASI,0,0,"L");
    // $pdf->Cell(65,3,": ",0,0,"L");
    // $pdf->Ln();

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(15,6,"Pengajuan / ",0,0,"L");
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(18,6,"Submition ",0,0,"L");
    // $pdf->SetFont('Arial','B',7);
    // // $pdf->Cell(30,6,": " . $BAGIAN." (".$STATUS_DOWNTIME.")",0,0,"L");
    // $pdf->Cell(30,6,": ",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // $pdf->Ln(4);
    // $pdf->Cell(34,6,"",0,0,"L");
    // // $pdf->Cell(80,6,$KERUSAKAN,0,0,"L");
    // $pdf->Cell(80,6,"",0,0,"L");
    // $pdf->Ln(18.5);

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(33,5,"Tgl & Jam Rusak /",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(62,5,": " . $TGL_START." / ". $JAM_START,0,0,"L");
    // $pdf->Cell(62,5,": ",0,0,"L");
    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(45,5,"Tgl & Jam Mulai Diperbaiki /",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(65,5,": " . $TGL_PERBAIKAN." / ". $JAM_PERBAIKAN,0,0,"L");
    // $pdf->Cell(65,5,": ",0,0,"L");

    // $pdf->Ln();
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(95,2,"Date & Time Start Damage",0,0,"L");
    // $pdf->Cell(65,2,"Date & Time Start Repair",0,0,"L");
    // $pdf->Ln(4);


    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(33,5,"Tindakan Perbaikan /",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(65,5,": " . $SOLUSI,0,0,"L");
    // $pdf->Cell(65,5,": ",0,0,"L");
    // $pdf->Ln();
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(45,1,"Corrective Action",0,0,"L");
    // $pdf->Ln(12.5);

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(37,5,"Tgl & Jam Selesai Diperbaiki /",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // // $pdf->Cell(58,5,": " . $TGL_SELESAI." / ". $JAM_SELESAI,0,0,"L");
    // $pdf->Cell(58,5,": ",0,0,"L");
    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(45,5,"Cek Hygiene setelah perbaikan /",0,0,"L");
    // $pdf->SetFont('Arial','',7);
    // $pdf->Cell(65,5,": ",0,0,"L");
    // $pdf->Ln();

    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(95,1,"Date & Time Finish",0,0,"L");
    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(45,1,"Hygiene check after repaired",0,0,"L");
    // $pdf->Ln(6);

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(10,1,"",0,0,"L");
    // $pdf->Cell(35,1,"Pemohon / ",0,0,"L");
    // $pdf->Cell(35,1,"Diterima Oleh / ",0,0,"L");
    // $pdf->Cell(39,1,"Diperbaiki Oleh / ",0,0,"L");
    // $pdf->Cell(41,1,"Diverifikasi Oleh / ",0,0,"L");
    // $pdf->Cell(35,1,"Disetujui Oleh / ",0,0,"L");
    // $pdf->Ln(4);

    // $pdf->SetFont('Arial','BI',7);
    // $pdf->Cell(8);
    // $pdf->Cell(37.5,1,"Reported by,",0,0,"L");
    // $pdf->Cell(38,1,"Accepted by,",0,0,"L");
    // $pdf->Cell(40,1,"Repair by,",0,0,"L");
    // $pdf->Cell(37,1,"Verified by,",0,0,"L");
    // $pdf->Cell(38,1,"Approved by,",0,0,"L");
    // $pdf->Ln(22);

    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(10,1,"Nama/",0,0,"L");
    // // $pdf->Cell(25,1,": ".$NAMA_USER,0,0,"L");
    // $pdf->Cell(25,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Nama/",0,0,"L");
    // $pdf->Cell(28,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Nama/",0,0,"L");
    // // $pdf->Cell(28,1,": ".$NAMA_TEKNISI,0,0,"L");
    // $pdf->Cell(28,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Nama/",0,0,"L");
    // $pdf->Cell(28,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Nama/",0,0,"L");
    // $pdf->Cell(28,1,": ",0,0,"L");

    // $pdf->Ln(3);
    // $pdf->SetFont('Arial','I',7);
    // $pdf->Cell(35,1,"Name",0,0,"L");
    // $pdf->Cell(38,1,"Name",0,0,"L");
    // $pdf->Cell(38,1,"Name",0,0,"L");
    // $pdf->Cell(38,1,"Name",0,0,"L");
    // $pdf->Cell(38,1,"Name",0,0,"L");

    // $pdf->Ln(5);
    // $pdf->SetFont('Arial','B',7);
    // $pdf->Cell(10,1,"Jabatan/",0,0,"L");
    // $pdf->Cell(25,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Jabatan/",0,0,"L");
    // $pdf->Cell(28,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Jabatan/",0,0,"L");
    // $pdf->Cell(28,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Jabatan/",0,0,"L");
    // $pdf->Cell(28,1,": ",0,0,"L");
    // $pdf->Cell(10,1,"Jabatan/",0,0,"L");
    // $pdf->Cell(25,1,": ",0,0,"L");

    // $pdf->Ln(3);
    // $pdf->SetFont('Arial','I',7);
    // $pdf->Cell(35,1,"Position",0,0,"L");
    // $pdf->Cell(38,1,"Position",0,0,"L");
    // $pdf->Cell(38,1,"Position",0,0,"L");
    // $pdf->Cell(38,1,"Position",0,0,"L");
    // $pdf->Cell(38,1,"Position",0,0,"L");
    // $pdf->Ln(5);
    // $pdf->SetFont('Arial','',7);
    // $pdf->Cell(163);
    // $pdf->Cell(38,1,"FRM-ENG-005-Rev.02",0,0,"L");

    $pdf->Output("SPK - " . $KODE_PERBAIKAN . ".pdf","I");
}   
?><script>alert('ACCESS DENIED !');</script><?php
?><script>window.close()</script><?php
die(0);
?>