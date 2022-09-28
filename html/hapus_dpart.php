<?php 
require_once("module/model/koneksi/koneksi.php");

if(!isset($_SESSION["LOGINIDUS_MT"]))
{
    ?><script>alert('Silahkan login dahulu');</script><?php
    ?><script>document.location.href='index';</script><?php
    die(0);
}

if(isset($_GET["KODE_PERBAIKAN"]))
{
    $DINO           = date('Y-m-d H:i:s');
    $ID_USER1       = $_SESSION["LOGINIDUS_MT"];
    $IP_ADDRESS     = $_SESSION["IP_ADDRESS_MT"];
    $KODE_PERBAIKAN = $_GET["KODE_PERBAIKAN"];
    $KODE_PART      = $_GET["KODE_PART"];
    $PC_NAME        = $_SESSION["PC_NAME_MT"];

    $stmt1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Detail Spare Part','Hapus Detail Spare Part','User Menghapus Detail Spare Part dengan Kode $KODE_PART')");
    $stmt1->execute();

    $stmt2 = $db1->prepare(
        "update d_maintenance 
        set STS_HAPUS = 1 
        where KODE_PERBAIKAN = '$KODE_PERBAIKAN' and KODE_PART = '$KODE_PART'");
    $stmt2->execute();

    ?><script>document.location.href='proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $KODE_PERBAIKAN; ?>';</script><?php
    die(0);
}
?>