<?php
$u                  = date("Ym");
$DATE               = date("Y-m-d H:i:s");
$TIME               = date("H:i:s");
$DINO               = date('Y-m-d H:i:s');
$KODE_PERBAIKAN     = createKode("t_perbaikan","KODE_PERBAIKAN","MT-$u-",4);
$ID_USER1           = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME            = $_SESSION["PC_NAME_MT"];
$KODE_PERUSAHAAN    = "";
$KODE_BAGIAN        = "";
$KODE_DEPARTEMEN    = "";
$KODE_BARANG        = "";
$KODE_UNIT          = "";
$NAMA_UNIT          = "";
$KERUSAKAN          = "";
$KETERANGAN         = "";
$SOLUSI             = "";
$IP_ADD             = "";
$PEMILIK            = "";
$SARAN              = "";
$STATUS             = "";
$USER_MT            = "";
$TUJUAN             = "";
$KODE_JENIS         = "";
$KODE_TEKNISI       = "";
$KODE_PART          = "";
$DURASI             = "";
$BAGIAN             = "";
$JUMLAH_PART        = "";
$HARGA_PART         = "";
$TGL_START          = "";
$JAM_START          = "";
$JUMBAR             = "";
$LOKASI             = "";
$STATUS_DOWNTIME    = "";
$TGL_PERBAIKAN      = "";
$JAM_PERBAIKAN      = "";
$TGL_SELESAI        = "";
$JAM_SELESAI        = "";
$STATUS_PERBAIKAN   = "";

//PROSES
if(isset($_GET["KODE_PERBAIKAN"]))
{
    $KODE_PERBAIKAN = $_GET["KODE_PERBAIKAN"];

    $result = GetQuery(
        "select p.*,
                DATE_FORMAT(p.TGL_START, '%Y-%m-%d') as TGL_START,
                DATE_FORMAT(p.TGL_END, '%Y-%m-%d') as TGL_END,
                h.NAMA_PERUSAHAAN,
                d.NAMA_DEPARTEMEN,
                b.KODE_JENIS,
                b.NAMA_BARANG,
                w.NAMA_UNIT,
                j.NAMA_JENIS,
                d.KODE_BAGIAN,
                g.NAMA_BAGIAN,
                DATE_FORMAT(p.TGL_PERBAIKAN, '%Y-%m-%d') as TGL_PERBAIKAN,
                DATE_FORMAT(TGL_PERBAIKAN, '%H:%i') as JAM_PERBAIKAN,
                DATE_FORMAT(p.TGL_SELESAI, '%Y-%m-%d') as TGL_SELESAI,
                DATE_FORMAT(TGL_SELESAI, '%H:%i') as JAM_SELESAI
           from t_perbaikan p
      LEFT JOIN m_barang b ON p.KODE_BARANG = b.KODE_BARANG
      LEFT JOIN m_perusahaan h ON p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN
      LEFT JOIN m_departemen d ON p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN
      LEFT JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
      LEFT JOIN m_bagian g ON d.KODE_BAGIAN = g.KODE_BAGIAN
      LEFT JOIN m_unit w ON p.KODE_UNIT = w.KODE_UNIT 
          WHERE p.KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        $KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
        $NAMA_PERUSAHAAN = $row["NAMA_PERUSAHAAN"];
        $KODE_BAGIAN     = $row["KODE_BAGIAN"];
        $NAMA_BAGIAN     = $row["NAMA_BAGIAN"];
        $KODE_DEPARTEMEN = $row["KODE_DEPARTEMEN"];
        $NAMA_DEPARTEMEN = $row["NAMA_DEPARTEMEN"];
        $KODE_BARANG     = $row["KODE_BARANG"];
        $KODE_UNIT       = $row["KODE_UNIT"];
        $NAMA_UNIT       = $row["NAMA_UNIT"];
        $NAMA_BARANG     = $row["NAMA_BARANG"];
        $JUMBAR          = $row["JUMLAH_BARANG"];
        $LOKASI          = $row["LOKASI"];
        $STATUS_DOWNTIME = $row["STATUS_DOWNTIME"];
        $KERUSAKAN       = $row["KERUSAKAN"];
        $KETERANGAN      = $row["KETERANGAN"];
        $SOLUSI          = $row["SOLUSI"];
        $IP_ADD          = $row["IP_ADD"];
        $PEMILIK         = $row["PEMILIK"];
        $KODE_JENIS      = $row["KODE_JENIS"];
        $STATUS          = $row["STATUS"];
        $USER_MT         = $row["USER_MT"];
        $LAYANAN         = $row["LAYANAN"];
        $BAGIAN          = $row["BAGIAN"];
        $DURASI          = $row["DURASI"];
        $TGL_END         = $row["TGL_END"];
        $TGL_PERBAIKAN   = $row["TGL_PERBAIKAN"];
        $JAM_PERBAIKAN   = $row["JAM_PERBAIKAN"];
        $TGL_SELESAI     = $row["TGL_SELESAI"];
        $JAM_SELESAI     = $row["JAM_SELESAI"];
        $TGL_START       = $row["TGL_START"];
    }

    //tambah teknisi
    if (isset($_POST["simpan3"])) {
        $KODE_TEKNISI = $_POST["KODE_TEKNISI"];

        if ($KODE_TEKNISI != "") {
            GetQuery(
                "insert into d_perbaikan (KODE_PERBAIKAN,KODE_TEKNISI) 
                values ('$KODE_PERBAIKAN','$KODE_TEKNISI')");
        }

        ?><script>document.location.href='proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $KODE_PERBAIKAN; ?>';</script><?php
        die(0);
    }

    //tambah sparepart
    if (isset($_POST["simpan4"])) {
        $KODE_PART   = $_POST["KODE_PART"];
        $JUMLAH_PART = $_POST["JUMLAH_PART"];

        if ($KODE_PART != "") 
        {
            $stmt = GetQuery(
                "select HARGA_PART from m_sparepart where KODE_PART = '$KODE_PART'");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
            {
                $HARGA_PART = $row["HARGA_PART"];
            }

            GetQuery(
                "insert into d_maintenance (KODE_PERBAIKAN,KODE_PART,JUMLAH_PART,HARGA_PART) 
                values ('$KODE_PERBAIKAN','$KODE_PART','$JUMLAH_PART','$HARGA_PART')");
        }

        ?><script>document.location.href='proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $KODE_PERBAIKAN; ?>';</script><?php
        die(0);
    }

    if (isset($_POST["simpanDetail"])) {
        $KODE_DETAIL = createKode("d_progress","KODE_DETAIL","DET-$u-",4);
        $SOLUSI      = $_POST["SOLUSI"];
        $SARAN       = $_POST["SARAN"];
        $DURASI      = $_POST["DURASI"];
        $BAGIAN      = $_POST["BAGIAN"];
        $TGL_END     = $_POST["TGL_END"] . " " . $TIME;

        GetQuery(
            "insert into d_progress (KODE_DETAIL,KODE_PERBAIKAN,TGL_PERBAIKAN,DURASI) 
            values ('$KODE_DETAIL','$KODE_PERBAIKAN','$TGL_END','$DURASI')");

        InsertData(
                "t_userlog",
                "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Progress Berjalan','Kode $KODE_PERBAIKAN'");
    }

    if (isset($_POST["simpan2"])) 
    {
        if ($KODE_JENIS != 1) //jika bukan IT
        {
            $SOLUSI = $_POST["SOLUSI"];
            $SARAN  = $_POST["SARAN"];
            $BAGIAN = isset($_POST["BAGIAN"]) ? $_POST["BAGIAN"] : "";
            $DURASI = $_POST["DURASI"];

            if ($KODE_JENIS == 2 or $KODE_JENIS == 4) //jika engineering / civil engineering
            {
                $TGL_PERBAIKAN    = $_POST["TGL_PERBAIKAN"] . " " . $_POST["JAM_PERBAIKAN"];
                $TGL_SELESAI      = $_POST["TGL_SELESAI"] . " " . $_POST["JAM_SELESAI"];
                $STATUS_PERBAIKAN = $_POST["STATUS_PERBAIKAN"];
            }  

            if ($STATUS_PERBAIKAN == "Belum") 
            {
                $KODE_DETAIL = createKode("d_progress","KODE_DETAIL","DET-$u-",4);
                GetQuery(
                    "insert into d_progress (KODE_DETAIL,KODE_PERBAIKAN,TGL_MULAI,TGL_SELESAI,DURASI,HASIL_PERBAIKAN) 
                    values ('$KODE_DETAIL','$KODE_PERBAIKAN','$TGL_PERBAIKAN','$TGL_SELESAI','$DURASI','$SOLUSI')");

                InsertData(
                "t_userlog",
                "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Progress Berjalan','Kode $KODE_PERBAIKAN'");
            } 
            else 
            {
                $resultHitung = GetQuery(
                   "select sum(DURASI) as DURASI2, 
                           COUNT(DURASI) AS COUNTS 
                      from d_progress 
                     where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
                while ($rowHitung = $resultHitung->fetch(PDO::FETCH_ASSOC)) 
                {
                    extract($rowHitung);
                }

                if ($COUNTS == 0) 
                {
                    UpdateData(
                        "t_perbaikan",
                        "SOLUSI = '$SOLUSI', TGL_END = '$DATE', TGL_PERBAIKAN = '$TGL_PERBAIKAN', TGL_SELESAI = '$TGL_SELESAI', USER_MT = '$ID_USER1', STATUS = 1, SARAN = '$SARAN', DURASI = '$DURASI', BAGIAN = '$BAGIAN', PROGRESS = 100",
                        "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
                } 
                else 
                {
                    UpdateData(
                        "t_perbaikan",
                        "SOLUSI = '$SOLUSI', TGL_END = '$DATE', TGL_PERBAIKAN = '$TGL_PERBAIKAN', TGL_SELESAI = '$TGL_SELESAI', USER_MT = '$ID_USER1', STATUS = 1, SARAN = '$SARAN', DURASI = '$DURASI2', BAGIAN = '$BAGIAN', PROGRESS = 100",
                        "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
                }

                InsertData(
                "t_userlog",
                "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Selesai Maintenance','Kode $KODE_PERBAIKAN'");
            }

            //set durasi kerja dan downtime
            if ($KODE_JENIS == 2) 
            {
               GetQuery(
                "update t_perbaikan 
                set LAMA_KERJA = (select time_format(TIMEDIFF(TGL_SELESAI,TGL_PERBAIKAN),'%H.%i')), 
                    DOWNTIME = (select time_format(TIMEDIFF(TGL_SELESAI,TGL_START),'%H.%i')) 
                where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            }
            
        } 
        else 
        {
            $SOLUSI  = $_POST["SOLUSI"];
            $USER_MT = isset($_POST["USER_MT"]) ? $_POST["USER_MT"] : "";
            $SARAN   = $_POST["SARAN"];

            InsertData(
                "t_userlog",
                "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Selesai Maintenance','Kode $KODE_PERBAIKAN'");

            UpdateData(
                "t_perbaikan",
                "SOLUSI = '$SOLUSI', TGL_END = '$DATE', TGL_PERBAIKAN = '$DATE', TGL_SELESAI = '$DATE', STATUS = 1, USER_MT = '$ID_USER1', SARAN = '$SARAN', DURASI = '$DURASI'",
                "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
        }

        require_once("module/model/koneksi/koneksi.php");
        require 'phpmailer/PHPMailerAutoload.php';
        set_time_limit(120); // set the time limit to 120 seconds

        $result = GetQuery(
           "select  p.*,
                    DATE_FORMAT(p.TGL_START, '%Y-%m-%d') as TGL_START,
                    DATE_FORMAT(p.TGL_END, '%Y-%m-%d') as TGL_END,
                    h.NAMA_PERUSAHAAN,
                    d.NAMA_DEPARTEMEN,
                    b.KODE_JENIS,
                    b.NAMA_BARANG,
                    w.NAMA_UNIT,
                    j.NAMA_JENIS,
                    d.KODE_BAGIAN,
                    g.NAMA_BAGIAN,
                    DATE_FORMAT(p.TGL_PERBAIKAN, '%Y-%m-%d') as TGL_PERBAIKAN,
                    DATE_FORMAT(TGL_PERBAIKAN, '%H:%i') as JAM_PERBAIKAN,
                    DATE_FORMAT(p.TGL_SELESAI, '%Y-%m-%d') as TGL_SELESAI,
                    DATE_FORMAT(TGL_SELESAI, '%H:%i') as JAM_SELESAI
               from t_perbaikan p
          LEFT JOIN m_barang b ON p.KODE_BARANG = b.KODE_BARANG
          LEFT JOIN m_perusahaan h ON p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN
          LEFT JOIN m_departemen d ON p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN
          LEFT JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
          LEFT JOIN m_bagian g ON d.KODE_BAGIAN = g.KODE_BAGIAN
          LEFT JOIN m_unit w ON p.KODE_UNIT = w.KODE_UNIT 
              WHERE p.KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
        {
            $KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
            $NAMA_PERUSAHAAN = $row["NAMA_PERUSAHAAN"];
            $KODE_BAGIAN     = $row["KODE_BAGIAN"];
            $NAMA_BAGIAN     = $row["NAMA_BAGIAN"];
            $KODE_DEPARTEMEN = $row["KODE_DEPARTEMEN"];
            $NAMA_DEPARTEMEN = $row["NAMA_DEPARTEMEN"];
            $KODE_BARANG     = $row["KODE_BARANG"];
            $NAMA_BARANG     = $row["NAMA_BARANG"];
            $NAMA_UNIT       = $row["NAMA_UNIT"];
            $JUMBAR          = $row["JUMLAH_BARANG"];
            $LOKASI          = $row["LOKASI"];
            $STATUS_DOWNTIME = $row["STATUS_DOWNTIME"];
            $KERUSAKAN       = $row["KERUSAKAN"];
            $KETERANGAN      = $row["KETERANGAN"];
            $SOLUSI          = $row["SOLUSI"];
            $TGL_START       = $row["TGL_START"];
            $JAM_START       = $row["JAM_START"];
            $IP_ADD          = $row["IP_ADD"];
            $PEMILIK         = $row["PEMILIK"];
            $USER_MT         = $row["USER_MT"];
            $SARAN           = $row["SARAN"];
        }

        if ($KODE_BAGIAN == "DIV-0030") {
            $EMAILMAN = "junitalia@baramudabahari.com";
        }
        else{
            $resultem2 = GetData1("EMAIL","m_user","KODE_BAGIAN = '$KODE_BAGIAN' and AKSES = 'Manajer'");
            while ($rowem2 = $resultem2->fetch(PDO::FETCH_ASSOC)) {
                $EMAILMAN  = $rowem2["EMAIL"];
            }
        }

        $resultem3 = GetData1("EMAIL","m_user","KODE_DEPARTEMEN = '$KODE_DEPARTEMEN' and AKSES = 'Admin'");
        while ($rowem3 = $resultem3->fetch(PDO::FETCH_ASSOC)) {
            $EMAILADM  = $rowem3["EMAIL"];
        }

        $resultjns = GetData1("KODE_JENIS","m_barang","KODE_BARANG = '$KODE_BARANG'");
        while ($rowJns  = $resultjns->fetch(PDO::FETCH_ASSOC)) {
            $KODE_JENIS = $rowJns["KODE_JENIS"];
        }

        $mail = new PHPMailer;
        $mail->isSendmail();
        $mail->setFrom('no-reply@megamarinepride.com','no-reply maintenance');
        
        $mail->addAddress($EMAILADM);
        $mail->addCC($EMAILMAN);
        if ($KODE_JENIS == 1) {
            $mail->addAddress('itsupport@megamarinepride.com');
        }
        elseif ($KODE_JENIS == 2) {
            $mail->addAddress('mechanic@megamarinepride.com');
        }
        elseif ($KODE_JENIS == 4) {
            $mail->addAddress('civil@megamarinepride.com;mechanic@megamarinepride.com');
        }
        else{
            $mail->addAddress('ga@megamarinepride.com');
            $mail->addAddress('ga1@megamarinepride.com');
        }
        $mail->Subject = "Permintaan Pemeliharaan Barang " . $KODE_PERBAIKAN;
        $mail->msgHTML("<br><br>======================================================================================<br>Perusahaan : " . $NAMA_PERUSAHAAN . " <br>Divisi : " . $NAMA_BAGIAN . " <br>Departemen : " . $NAMA_DEPARTEMEN . " <br>Tanggal Pengajuan: " . $TGL_START . " " . $JAM_START . " <br>Barang : " . $NAMA_BARANG . " <br>Unit : " . $NAMA_UNIT . " <br>IP Address : " . $IP_ADD . " <br>Pemilik : " . $PEMILIK . " <br>Kerusakan : " . $KERUSAKAN . " <br>Keterangan : " . $KETERANGAN . " <br><br>Hasil Pemeliharaan : " . $SOLUSI . " <br>User Pemeliharaan : " . $USER_MT . " <br>Saran : " . $SARAN . "<br><br>Status : Done<br><br>======================================================================================<br>please do not reply to this email <br>for more information, kindly visit <a href='192.168.0.167/maintenance'>maintenance.megamarinepride</a><br><br><br>Regards,<br>Mega Marine Pride");

        $mail->send()
        ?>
        <script>document.location.href='pengajuanmt';</script><?php
        die(0);
    }
    
    if(isset($_POST["simpan"]))
    {
        InsertData("t_userlog","KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                   "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Edit','Kode $KODE_PERBAIKAN'");

        if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
        {
            $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
            $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
            $KODE_BARANG     = $_POST["KODE_BARANG"];
            $KODE_UNIT       = $_POST["KODE_UNIT"];
            $KERUSAKAN       = $_POST["KERUSAKAN"];
            $KETERANGAN      = $_POST["KETERANGAN"];
            $LAYANAN         = $_POST["LAYANAN"];
            $KODE_JENIS      = $_POST["KODE_JENIS"];
            $STATUS_DOWNTIME = $_POST["STATUS_DOWNTIME"];

            if ($KODE_JENIS == 2 or $KODE_JENIS == 3) 
            {
                $BAGIAN = $_POST["BAGIAN"];
            }
            if ($KODE_BARANG == "BRG/201803/00106") 
            {
                $IP_ADD  = $_POST["IP_ADD"];
                $PEMILIK = $_POST["PEMILIK"];
            }

            UpdateData(
                "t_perbaikan",
                "KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', KODE_BARANG = '$KODE_BARANG', KODE_UNIT = '$KODE_UNIT', KERUSAKAN = '$KERUSAKAN', KETERANGAN = '$KETERANGAN', IP_ADD = '$IP_ADD', PEMILIK = '$PEMILIK', LAYANAN = '$LAYANAN', BAGIAN = '$BAGIAN', STATUS_DOWNTIME = '$STATUS_DOWNTIME'",
                "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
        }
        elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033" or  // IT MMP
                $_SESSION["LOGINDEP_MT"] == "DEPT-0040" or  // MEKANIK MMP
                $_SESSION["LOGINDEP_MT"] == "DEPT-0094" or  // SANITASI LUAR MMP
                $_SESSION["LOGINDEP_MT"] == "DEPT-0011" or  // CIVIL ENGINEERING
                $_SESSION["LOGINDEP_MT"] == "DEPT-0056")    // QSD 1 MMP

        {
            $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
            $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
            $KODE_BARANG     = $_POST["KODE_BARANG"];
            $KODE_UNIT       = $_POST["KODE_UNIT"];
            $KERUSAKAN       = $_POST["KERUSAKAN"];
            $KETERANGAN      = $_POST["KETERANGAN"];
            $LAYANAN         = $_POST["LAYANAN"];
            $KODE_JENIS      = $_POST["KODE_JENIS"];
            $STATUS_DOWNTIME = $_POST["STATUS_DOWNTIME"];

            if ($KODE_JENIS == 2 or $KODE_JENIS == 3) {
                $BAGIAN = $_POST["BAGIAN"];
            }
            if ($KODE_BARANG == "BRG/201803/00106") {
                $IP_ADD  = $_POST["IP_ADD"];
                $PEMILIK = $_POST["PEMILIK"];
            }
            if ($KODE_JENIS == 2) {
                $TGL_START = $_POST["TGL_START"];
            }

            UpdateData(
                "t_perbaikan",
                "KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', KODE_BARANG = '$KODE_BARANG', KODE_UNIT = '$KODE_UNIT', KERUSAKAN = '$KERUSAKAN', KETERANGAN = '$KETERANGAN', IP_ADD = '$IP_ADD', PEMILIK = '$PEMILIK', LAYANAN = '$LAYANAN', BAGIAN = '$BAGIAN', STATUS_DOWNTIME = '$STATUS_DOWNTIME'",
                "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
        }
        else
        {
            $KODE_PERUSAHAAN = $_SESSION["LOGINPER_MT"];
            if ($_SESSION["LOGINBAG_MT"] == "DIV-0026") {
                $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
            }
            else {
                $KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
            }
            $KODE_BARANG     = $_POST["KODE_BARANG"];
            $KODE_UNIT       = $_POST["KODE_UNIT"];
            $KERUSAKAN       = $_POST["KERUSAKAN"];
            $KETERANGAN      = $_POST["KETERANGAN"];
            $LAYANAN         = $_POST["LAYANAN"];
            $KODE_JENIS      = $_POST["KODE_JENIS"];
            $STATUS_DOWNTIME = $_POST["STATUS_DOWNTIME"];

            if ($KODE_JENIS == 2 or $KODE_JENIS == 3) {
                $BAGIAN = $_POST["BAGIAN"];
            }
            if ($KODE_BARANG == "BRG/201803/00106") {
                $IP_ADD  = $_POST["IP_ADD"];
                $PEMILIK = $_POST["PEMILIK"];
            }

            UpdateData(
                "t_perbaikan",
                "KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', KODE_BARANG = '$KODE_BARANG', KODE_UNIT ='$KODE_UNIT', KERUSAKAN = '$KERUSAKAN', KETERANGAN = '$KETERANGAN', IP_ADD = '$IP_ADD', PEMILIK = '$PEMILIK', LAYANAN = '$LAYANAN', BAGIAN = '$BAGIAN', STATUS_DOWNTIME = '$STATUS_DOWNTIME'",
                "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
        }

        ?><script>document.location.href='pengajuanmt';</script><?php
        die(0);
    }
}

//PENGAJUAN PERBAIKAN BARU///////////////////////////////////////////////////////////////////////////////////
if(isset($_POST["simpan"]))
{
    if ($_SESSION["LOGINAKS_MT"] == "Administrator" or 
        $_SESSION["LOGINDEP_MT"] == "DEPT-0033" or // IT MMP
        $_SESSION["LOGINDEP_MT"] == "DEPT-0040" or // MEKANIK MMP
        $_SESSION["LOGINDEP_MT"] == "DEPT-0011" or // CIVIL ENGINEERING MMP
        $_SESSION["LOGINDEP_MT"] == "DEPT-0056")   // QSD 1 MMP
    {
        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
        $KODE_BARANG     = $_POST["KODE_BARANG"];
        $KODE_UNIT       = $_POST["KODE_UNIT"];
        $LOKASI          = $_POST["LOKASI"];
        $KERUSAKAN       = $_POST["KERUSAKAN"];
        $KETERANGAN      = $_POST["KETERANGAN"];
        $KODE_JENIS      = $_POST["KODE_JENIS"];
        $LAYANAN         = $_POST["LAYANAN"];
        $JUMBAR          = 1;

        if ($KODE_JENIS == 2 OR $KODE_JENIS == 4) 
        {
            $JUMBAR          = $_POST["JUMBAR"];            
            $STATUS_DOWNTIME = $_POST["STATUS_DOWNTIME"];
            // $BAGIAN          = $_POST["BAGIAN"];
        }
        if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0011") // MEKANIK MMP / CIVIL ENG
        {
            $DATE = $_POST["TGL_START"] . " " . $_POST["JAM_START"];
        }

        if ($KODE_BARANG == "BRG/201803/00106") // KOMPUTER
        {
            $IP_ADD  = $_POST["IP_ADD"];
            $PEMILIK = $_POST["PEMILIK"];
        }

        InsertData(
           "t_perbaikan",
           "KODE_PERBAIKAN,KODE_PERUSAHAAN,KODE_DEPARTEMEN,KODE_BARANG,KODE_UNIT,TGL_START,KERUSAKAN,KETERANGAN,USER_REQ,IP1, IP_ADD,PEMILIK,LAYANAN,BAGIAN,JUMLAH_BARANG,LOKASI,STATUS_DOWNTIME",
           "'$KODE_PERBAIKAN','$KODE_PERUSAHAAN','$KODE_DEPARTEMEN','$KODE_BARANG','$KODE_UNIT','$DATE','$KERUSAKAN','$KETERANGAN','$ID_USER1','$IP_ADDRESS','$IP_ADD','$PEMILIK','$LAYANAN','$BAGIAN','$JUMBAR', '$LOKASI', '$STATUS_DOWNTIME'");

        InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tambah','Kode $KODE_PERBAIKAN'");
    }

    else
    {
        $KODE_PERUSAHAAN = $_SESSION["LOGINPER_MT"];
        if ($_SESSION["LOGINBAG_MT"] == "DIV-0026") 
        {
            $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
        }
        else 
        {
            $KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
        }
        
        $KODE_BARANG     = $_POST["KODE_BARANG"];
        $KODE_UNIT       = $_POST["KODE_UNIT"];
        $LOKASI          = $_POST["LOKASI"];
        $KERUSAKAN       = $_POST["KERUSAKAN"];
        $KETERANGAN      = $_POST["KETERANGAN"];
        $KODE_JENIS      = $_POST["KODE_JENIS"];
        $LAYANAN         = $_POST["LAYANAN"];
        $JUMBAR          = 1;

        if ($KODE_JENIS == 2) 
        {
            $JUMBAR          = $_POST["JUMBAR"];
            $STATUS_DOWNTIME = $_POST["STATUS_DOWNTIME"];
            // $BAGIAN          = $_POST["BAGIAN"];
        }

        if ($KODE_BARANG == "BRG/201803/00106") {
            $IP_ADD  = $_POST["IP_ADD"];
            $PEMILIK = $_POST["PEMILIK"];
        }
        
        InsertData(
            "t_perbaikan",
            "KODE_PERBAIKAN,KODE_PERUSAHAAN,KODE_DEPARTEMEN,KODE_BARANG,KODE_UNIT,TGL_START,KERUSAKAN,KETERANGAN,USER_REQ,IP1,IP_ADD,PEMILIK,LAYANAN,BAGIAN,JUMLAH_BARANG,LOKASI,STATUS_DOWNTIME",
            "'$KODE_PERBAIKAN','$KODE_PERUSAHAAN','$KODE_DEPARTEMEN','$KODE_BARANG','$KODE_UNIT','$DATE','$KERUSAKAN','$KETERANGAN','$ID_USER1','$IP_ADDRESS','$IP_ADD','$PEMILIK','$LAYANAN','$BAGIAN','$JUMBAR', '$LOKASI','$STATUS_DOWNTIME'");
    }

    require_once("module/model/koneksi/koneksi.php");
    require 'phpmailer/PHPMailerAutoload.php';

    $result = GetQuery(
       "select  p.*,
                DATE_FORMAT(p.TGL_START, '%Y-%m-%d') as TGL_START,
                DATE_FORMAT(p.TGL_END, '%Y-%m-%d') as TGL_END,
                h.NAMA_PERUSAHAAN,
                d.NAMA_DEPARTEMEN,
                b.KODE_JENIS,
                b.NAMA_BARANG,
                w.NAMA_UNIT,
                j.NAMA_JENIS,
                d.KODE_BAGIAN,
                g.NAMA_BAGIAN,
                DATE_FORMAT(p.TGL_PERBAIKAN, '%Y-%m-%d') as TGL_PERBAIKAN,
                DATE_FORMAT(TGL_PERBAIKAN, '%H:%i') as JAM_PERBAIKAN,
                DATE_FORMAT(p.TGL_SELESAI, '%Y-%m-%d') as TGL_SELESAI,
                DATE_FORMAT(TGL_SELESAI, '%H:%i') as JAM_SELESAI
           from t_perbaikan p
      LEFT JOIN m_barang b ON p.KODE_BARANG = b.KODE_BARANG
      LEFT JOIN m_perusahaan h ON p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN
      LEFT JOIN m_departemen d ON p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN
      LEFT JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
      LEFT JOIN m_bagian g ON d.KODE_BAGIAN = g.KODE_BAGIAN
      LEFT JOIN m_unit w ON p.KODE_UNIT = w.KODE_UNIT 
          WHERE p.KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        $KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
        $NAMA_PERUSAHAAN = $row["NAMA_PERUSAHAAN"];
        $KODE_BAGIAN     = $row["KODE_BAGIAN"];
        $NAMA_BAGIAN     = $row["NAMA_BAGIAN"];
        $KODE_DEPARTEMEN = $row["KODE_DEPARTEMEN"];
        $NAMA_DEPARTEMEN = $row["NAMA_DEPARTEMEN"];
        $KODE_BARANG     = $row["KODE_BARANG"];
        $NAMA_BARANG     = $row["NAMA_BARANG"];
        $NAMA_UNIT       = $row["NAMA_UNIT"];
        $KERUSAKAN       = $row["KERUSAKAN"];
        $KETERANGAN      = $row["KETERANGAN"];
        $SOLUSI          = $row["SOLUSI"];
        $TGL_START       = $row["TGL_START"];
        $JAM_START       = $row["JAM_START"];
        $IP_ADD          = $row["IP_ADD"];
        $PEMILIK         = $row["PEMILIK"];
    }

    $resultjns = GetData1("KODE_JENIS","m_barang","KODE_BARANG = '$KODE_BARANG'");
    while ($rowJns = $resultjns->fetch(PDO::FETCH_ASSOC)) {
        $KODE_JENIS = $rowJns["KODE_JENIS"];
    }

    if ($KODE_BAGIAN == "DIV-0030") {
        $EMAILMAN = "junitalia@baramudabahari.com";
    }
    else{
        $resultem2 = GetData1("EMAIL","m_user","KODE_BAGIAN = '$KODE_BAGIAN' and AKSES = 'Manajer'");
        while ($rowem2 = $resultem2->fetch(PDO::FETCH_ASSOC)) {
            $EMAILMAN = $rowem2["EMAIL"];
        }
    }

    $mail = new PHPMailer;
    $mail->isSendmail();
    $mail->setFrom('no-reply@megamarinepride.com','no-reply maintenance');
    
    if ($KODE_JENIS == 1) {
        $mail->addAddress('itsupport@megamarinepride.com');
    }
    elseif ($KODE_JENIS == 2 or $KODE_JENIS == 4) {
        $mail->addAddress('mechanic@megamarinepride.com');
    }
    else{
        $mail->addAddress('ga@megamarinepride.com');
        $mail->addAddress('ga1@megamarinepride.com');
    }
    $mail->addCC($EMAILMAN);
    $mail->Subject = "Permintaan Pemeliharaan Barang " . $KODE_PERBAIKAN;
    $mail->msgHTML("<br><br>======================================================================================<br>Perusahaan : " . $NAMA_PERUSAHAAN . " <br>Divisi : " . $NAMA_BAGIAN . " <br>Departemen : " . $NAMA_DEPARTEMEN . " <br>Tanggal Pengajuan: " . $TGL_START . " " . $JAM_START . " <br>Barang : " . $NAMA_BARANG . " <br>Unit : " . $NAMA_UNIT . " <br>IP Address : " . $IP_ADD . " <br>Pemilik : " . $PEMILIK . " <br>Kerusakan : " . $KERUSAKAN . " <br>Keterangan : " . $KETERANGAN . "<br><br>Status : In Progress<br><br>======================================================================================<br>please do not reply to this email <br>for more information, kindly visit <a href='192.168.0.167/maintenance'>maintenance.megamarinepride</a><br><br><br>Regards,<br>Mega Marine Pride");
    $mail->send()
    
    ?>
    <script>document.location.href='pengajuanmt';</script>
    <?php
    die(0);
}
?>