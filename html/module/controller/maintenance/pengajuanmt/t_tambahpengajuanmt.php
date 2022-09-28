<?php
$u               = date("Ym");
$DATE            = date("Y-m-d H:i:s");
$KODE_PERBAIKAN  = createKode("t_perbaikan","KODE_PERBAIKAN","MT-$u-",4);
$KODE_PERUSAHAAN = "";
$KODE_BAGIAN     = "";
$KODE_DEPARTEMEN = "";
$KODE_BARANG     = "";
$KERUSAKAN       = "";
$KETERANGAN      = "";
$SOLUSI          = "";
$IP_ADD          = "";
$PEMILIK         = "";
$DINO            = date('Y-m-d H:i:s');
$ID_USER1        = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS      = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME         = $_SESSION["PC_NAME_MT"];

if(isset($_POST["simpan"]))
{
    $querylog = 
    "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
    values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tambah Maintenance','User Menambah Maintenance dengan Kode $KODE_PERBAIKAN')";
    mysql_query($querylog, $DB1);

    if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033" or $_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
        $KODE_BARANG     = $_POST["KODE_BARANG"];
        $KERUSAKAN       = $_POST["KERUSAKAN"];
        $KETERANGAN      = $_POST["KETERANGAN"];
        if ($KODE_BARANG == "BRG/201803/00106") 
        {
            $IP_ADD  = $_POST["IP_ADD"];
            $PEMILIK = $_POST["PEMILIK"];
        }

        $query = 
        "insert into t_perbaikan (KODE_PERBAIKAN, KODE_PERUSAHAAN, KODE_DEPARTEMEN, KODE_BARANG, TGL_START, KERUSAKAN, KETERANGAN, USER_REQ, IP1, IP_ADD, PEMILIK) 
        values ('$KODE_PERBAIKAN','$KODE_PERUSAHAAN','$KODE_DEPARTEMEN','$KODE_BARANG','$DATE','$KERUSAKAN','$KETERANGAN','$ID_USER1','$IP_ADDRESS','$IP_ADD','$PEMILIK')";
        mysql_query($query, $DB1);
    }
    else
    {
        $KODE_PERUSAHAAN = $_SESSION["LOGINPER_MT"];
        $KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
        $KODE_BARANG     = $_POST["KODE_BARANG"];
        $KERUSAKAN       = $_POST["KERUSAKAN"];
        $KETERANGAN      = $_POST["KETERANGAN"];
        if ($KODE_BARANG == "BRG/201803/00106") 
        {
            $IP_ADD  = $_POST["IP_ADD"];
            $PEMILIK = $_POST["PEMILIK"];
        }

        $query = 
        "insert into t_perbaikan (KODE_PERBAIKAN, KODE_PERUSAHAAN, KODE_DEPARTEMEN, KODE_BARANG, TGL_START, KERUSAKAN, KETERANGAN, USER_REQ, IP1 ,IP_ADD, PEMILIK) 
        values ('$KODE_PERBAIKAN','$KODE_PERUSAHAAN','$KODE_DEPARTEMEN','$KODE_BARANG','$DATE','$KERUSAKAN','$KETERANGAN','$ID_USER1','$IP_ADDRESS','$IP_ADD','$PEMILIK')";
        mysql_query($query, $DB1);
    }

    ?><script>document.location.href='pengajuanmt';</script><?php
    die(0);
}
?>