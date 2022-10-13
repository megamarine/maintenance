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
                DATE_FORMAT(p.TGL_START, '%H:%i') as JAM_START,
                DATE_FORMAT(p.TGL_END, '%Y-%m-%d') as TGL_END,
                h.NAMA_PERUSAHAAN,
                d.NAMA_DEPARTEMEN,
                b.KODE_JENIS,
                b.NAMA_BARANG,
                w.NAMA_UNIT,
                j.NAMA_JENIS,
                p.LAYANAN,
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
        $SARAN           = $row["SARAN"];
        $STATUS_PERBAIKAN = $row["STATUS_PERBAIKAN"];
        $JAM_START = $row["JAM_START"];
    }
    
    //PROGRESS EDIT ///////////////////////////////////////////////////////////////////////////////////
    if(isset($_POST["simpan"]))
        {
            
            $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
            $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
            $KODE_BARANG     = $_POST["KODE_BARANG"];
            $KODE_UNIT       = isset($_POST["KODE_UNIT"]) ? $_POST['KODE_UNIT']: $KODE_UNIT;
            $LOKASI          = isset($_POST["LOKASI"]) ? $_POST['LOKASI']: $LOKASI;
            $KERUSAKAN       = $_POST["KERUSAKAN"];
            $KETERANGAN      = $_POST["KETERANGAN"];
            $STATUS_DOWNTIME = isset($_POST["STATUS_DOWNTIME"]) ? $_POST["STATUS_DOWNTIME"]: $STATUS_DOWNTIME;
            $KODE_JENIS      = $_POST["KODE_JENIS"];
            $LAYANAN         = $_POST["LAYANAN"];
            $JUMBAR          = isset($_POST["JUMBAR"]) ? $_POST["JUMBAR"] : $JUMBAR;
            $JAM_START       = isset($_POST["JAM_START"]) ? $_POST["JAM_START"]: $JAM_START;              
            $DATE = $_POST["TGL_START"] . " " .  $JAM_START;
            
            UpdateData(
            "t_perbaikan",
            "KODE_PERUSAHAAN='$KODE_PERUSAHAAN',KODE_DEPARTEMEN='$KODE_DEPARTEMEN',
             KODE_BARANG='$KODE_BARANG',KODE_UNIT='$KODE_UNIT',TGL_START='$DATE',
             KERUSAKAN='$KERUSAKAN',KETERANGAN='$KETERANGAN',USER_REQ='$ID_USER1',
             IP1='$IP_ADDRESS', IP_ADD='$IP_ADD',PEMILIK='$PEMILIK',LAYANAN='$LAYANAN',
             BAGIAN='$BAGIAN',JUMLAH_BARANG='$JUMBAR',LOKASI='$LOKASI',STATUS_DOWNTIME='$STATUS_DOWNTIME'","KODE_PERBAIKAN='$KODE_PERBAIKAN'");

            InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tambah','Kode $KODE_PERBAIKAN'");

        } 
} else if(isset($_POST["simpan"])) //PENGAJUAN BARU
{
    $querylog = 
    "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
    values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tambah Maintenance','User Menambah Maintenance dengan Kode $KODE_PERBAIKAN')";

    $mysqli->query($querylog);

        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
        $KODE_BARANG     = $_POST["KODE_BARANG"];
        $KERUSAKAN       = $_POST["KERUSAKAN"];
        $KETERANGAN      = $_POST["KETERANGAN"];
        $LAYANAN         = $_POST["LAYANAN"];   
        $STATUS_DOWNTIME = $_POST["STATUS_DOWNTIME"];
        $JUMBAR = $_POST['JUMBAR'];
        $LOKASI = $_POST['LOKASI'];
        $KODE_UNIT = $_POST['KODE_UNIT'];


    $query = 
    "insert into t_perbaikan (KODE_PERBAIKAN, KODE_PERUSAHAAN, KODE_DEPARTEMEN,
     KODE_BARANG, TGL_START, KERUSAKAN, KETERANGAN, USER_REQ, IP1,
     IP_ADD, PEMILIK, LAYANAN, STATUS_DOWNTIME,JUMLAH_BARANG, LOKASI, KODE_UNIT) 
    values ('$KODE_PERBAIKAN','$KODE_PERUSAHAAN','$KODE_DEPARTEMEN','$KODE_BARANG',
    '$DATE','$KERUSAKAN','$KETERANGAN','$ID_USER1','$IP_ADDRESS','$IP_ADD',
    '$PEMILIK','$LAYANAN', '$STATUS_DOWNTIME','$JUMBAR','$LOKASI','$KODE_UNIT')";
    $mysqli->query($query);

    // send Email
     require_once("module/model/koneksi/koneksi.php");
     require 'phpmailer/PHPMailerAutoload.php';

        $result = GetQuery(
        "select  p.*,
                    DATE_FORMAT(p.TGL_START, '%Y-%m-%d') as TGL_START,
                    DATE_FORMAT(p.TGL_START, '%H:%i') as JAM_START,
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

        $resultem2 = GetData1("EMAIL","m_user","KODE_BAGIAN = '$KODE_BAGIAN' and AKSES = 'Manajer'");
        while ($rowem2 = $resultem2->fetch(PDO::FETCH_ASSOC)) {
            $EMAILMAN = $rowem2["EMAIL"];
        }
        try {    
            $mail = new PHPMailer;
            $mail->isSendmail();
            $mail->setFrom('no-reply@megamarinepride.com','no-reply maintenance');
            $mail->addAddress('mechanic@megamarinepride.com');
        
            $mail->addCC($EMAILMAN);
            $mail->Subject = "Permintaan Pemeliharaan Barang " . $KODE_PERBAIKAN;
            $mail->msgHTML("<br><br>======================================================================================<br>Perusahaan : " . $NAMA_PERUSAHAAN . " <br>Divisi : " . $NAMA_BAGIAN . " <br>Departemen : " . $NAMA_DEPARTEMEN . " <br>Tanggal Pengajuan: " . $TGL_START . " " . $JAM_START . " <br>Barang : " . $NAMA_BARANG . " <br>Unit : " . $NAMA_UNIT . " <br>IP Address : " . $IP_ADD . " <br>Pemilik : " . $PEMILIK . " <br>Kerusakan : " . $KERUSAKAN . " <br>Keterangan : " . $KETERANGAN . "<br><br>Status : In Progress<br><br>======================================================================================<br>please do not reply to this email <br>for more information, kindly visit <a href='192.168.0.167/maintenance'>maintenance.megamarinepride</a><br><br><br>Regards,<br>Mega Marine Pride");
            $mail->send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }
    echo "<script>document.location.href='v_mekanik';</script>";
}
$mysqli->close();

?>