<?php 
require_once("module/model/koneksi/koneksi.php");

if(!isset($_SESSION["LOGINIDUS_MT"]))
{
    ?><script>alert('Silahkan login dahulu');</script><?php
    ?><script>document.location.href='index';</script><?php
    die(0);
}

if(isset($_GET["TANGGAL"]))
{
    $DINO        = date('Y-m-d H:i:s');
    $ID_USER1    = $_SESSION["LOGINIDUS_MT"];
    $IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
    $PC_NAME     = $_SESSION["PC_NAME_MT"];
    $TANGGAL     = $_GET["TANGGAL"];

    $stmt2 = $db1->prepare("delete from nonaktif_jamopr where TANGGAL = '$TANGGAL'");
    $stmt2->execute();

    $stmt1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Paramater','Hapus tgl nonaktif','Tanggal $TANGGAL')");
    $stmt1->execute();

    ?><script>document.location.href='parameter';</script><?php
    die(0);
}
?>