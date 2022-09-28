<?php
$DATE               = date("Ym");
$KODE_HADIR         = createKode("t_kehadiran","KODE_HADIR","ABS/$DATE/",3);
$KODE_PERUSAHAAN    = "";
$KODE_TEKNISI       = "";
$TANGGAL            = "";
$ABSENSI            = "";
$KETERANGAN         = "";
$DINO               = date('Y-m-d H:i:s');
$ID_USER1           = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME            = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_HADIR"]))
{
    $KODE_HADIR = $_GET["KODE_HADIR"];

    $result = GetQuery(
       "select k.*,
        t.KODE_PERUSAHAAN 
       from t_kehadiran k, 
        m_teknisi t 
       where k.KODE_TEKNISI = t.KODE_TEKNISI and 
        k.KODE_HADIR = '$KODE_HADIR'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        extract($row);
    }

    if(isset($_POST["simpan"]))
    {
        $KODE_TEKNISI = $_POST["KODE_TEKNISI"];
        $TANGGAL      = $_POST["TANGGAL"];
        $ABSENSI      = $_POST["ABSENSI"];
        $KETERANGAN   = $_POST["KETERANGAN"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Absensi','Edit Absensi','User Mengedit Absensi dengan Kode $KODE_HADIR'");

        UpdateData(
            "t_kehadiran",
            "KODE_TEKNISI = '$KODE_TEKNISI', TANGGAL = '$TANGGAL', ABSENSI = '$ABSENSI', KETERANGAN = '$KETERANGAN'",
            "KODE_HADIR = '$KODE_HADIR'");

        ?><script>document.location.href='kehadiran';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $KODE_TEKNISI   = $_POST["KODE_TEKNISI"];
    $TANGGAL        = $_POST["TANGGAL"];
    $ABSENSI        = $_POST["ABSENSI"];
    $KETERANGAN     = $_POST["KETERANGAN"];

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Absensi','Tambah Absensi','User Menambah Absensi dengan Kode $KODE_HADIR'");

    InsertData(
        "t_kehadiran","KODE_HADIR,KODE_TEKNISI,TANGGAL,ABSENSI,KETERANGAN",
        "'$KODE_HADIR','$KODE_TEKNISI','$TANGGAL','$ABSENSI','$KETERANGAN'");

    ?><script>document.location.href='kehadiran';</script><?php
    die(0);
}
?>