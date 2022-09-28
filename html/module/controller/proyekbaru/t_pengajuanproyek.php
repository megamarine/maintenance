<?php
$DATE               = date("Ym");
$KODE_PROYEK        = createKode("t_proyekbaru","KODE_PROYEK","KP/$DATE/",4);
$KODE_BARANG        = "";
$KODE_PERUSAHAAN    = "";
$LOKASI             = "";
$KETERANGAN         = "";
$PETUGAS            = "";
$TGL_MULAI          = date("Y-m-d");
$STATUS             = 0;
$HAMBATAN           = "";
$TGL_SELESAI        = date("Y-m-d");
$KETERANGAN_SELESAI = "";
$DINO               = date('Y-m-d H:i:s');
$ID_USER1           = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME            = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_PROYEK"]))
{
    $KODE_PROYEK = $_GET["KODE_PROYEK"];

    $result = GetData1(
       "k.*,
        p.NAMA_PERUSAHAAN,
        b.NAMA_BARANG",
       "t_proyekbaru k, 
        m_perusahaan p, 
        m_barang b",
       "k.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        k.KODE_BARANG = b.KODE_BARANG and 
        k.KODE_PROYEK = '$KODE_PROYEK'");

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        $KODE_PERUSAHAAN    = $row["KODE_PERUSAHAAN"];
        $KODE_BARANG        = $row["KODE_BARANG"];
        $LOKASI             = $row["LOKASI"];
        $KETERANGAN         = $row["KETERANGAN"];
        $PETUGAS            = $row["PETUGAS"];
        $TGL_MULAI          = $row["TGL_MULAI"];
        $STATUS             = $row["STATUS"];
        $NAMA_PERUSAHAAN    = $row["NAMA_PERUSAHAAN"];
        $NAMA_BARANG        = $row["NAMA_BARANG"];
        $HAMBATAN           = $row["HAMBATAN"];
        $KETERANGAN_SELESAI = $row["KETERANGAN_SELESAI"];
    }

    if(isset($_POST["simpan"]))
    {
        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $KODE_BARANG     = $_POST["KODE_BARANG"];
        $LOKASI          = $_POST["LOKASI"];
        $PETUGAS         = $_POST["PETUGAS"];
        $KETERANGAN      = $_POST["KETERANGAN"];
        $TGL_MULAI       = $_POST["TGL_MULAI"];
        $HAMBATAN        = $_POST["HAMBATAN"];

        if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
            $KATEGORI = 1;
        }
        elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
            $KATEGORI = 2;
        }
        else{
            $KATEGORI = 3;
        }

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Proyek Baru','Edit Proyek','User Mengedit Proyek dengan Kode $KODE_PROYEK'");

        UpdateData(
            "t_proyekbaru",
            "KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', KODE_BARANG = '$KODE_BARANG', LOKASI = '$LOKASI', PETUGAS = '$PETUGAS', KETERANGAN = '$KETERANGAN', TGL_MULAI = '$TGL_MULAI', HAMBATAN = '$HAMBATAN'",
            "KODE_PROYEK = '$KODE_PROYEK'");

        ?><script>document.location.href='pengajuanproyek';</script><?php
        die(0);
    }

    if(isset($_POST["simpan2"]))
    {
        $TGL_SELESAI        = $_POST["TGL_SELESAI"];
        $KETERANGAN_SELESAI = $_POST["KETERANGAN_SELESAI"];
        $HAMBATAN           = $_POST["HAMBATAN"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Proyek Baru','Proses Proyek','User Memproses Proyek dengan Kode $KODE_PROYEK'");

        UpdateData(
            "t_proyekbaru",
            "TGL_SELESAI = '$TGL_SELESAI', KETERANGAN_SELESAI = '$KETERANGAN_SELESAI', HAMBATAN = '$HAMBATAN', STATUS = '1'",
            "KODE_PROYEK = '$KODE_PROYEK'");

        ?><script>document.location.href='pengajuanproyek';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
    $KODE_BARANG     = $_POST["KODE_BARANG"];
    $LOKASI          = $_POST["LOKASI"];
    $PETUGAS         = $_POST["PETUGAS"];
    $KETERANGAN      = $_POST["KETERANGAN"];
    $TGL_MULAI       = $_POST["TGL_MULAI"];

    if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
        $KATEGORI = 1;
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
        $KATEGORI = 2;
    }
    else{
        $KATEGORI = 3;
    }

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Proyek Baru','Tambah Proyek','User Menambah Proyek dengan Kode $KODE_PROYEK'");

    InsertData(
        "t_proyekbaru",
        "KODE_PROYEK,KODE_BARANG,KODE_PERUSAHAAN,LOKASI,KETERANGAN,TGL_MULAI,KATEGORI,PETUGAS",
        "'$KODE_PROYEK','$KODE_BARANG','$KODE_PERUSAHAAN','$LOKASI','$KETERANGAN','$TGL_MULAI','$KATEGORI','$PETUGAS'");

    ?><script>document.location.href='pengajuanproyek';</script><?php
    die(0);
}
?>