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
    $PC_NAME        = $_SESSION["PC_NAME_MT"];

    $stmt1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Hapus','Kode $KODE_PERBAIKAN')");
    $stmt1->execute();

    $stmt2 = $db1->prepare("update t_perbaikan set STATUS_HAPUS = 1 where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
    $stmt2->execute();

    ?><script>document.location.href='pengajuanmt';</script><?php
    die(0);
}
?>