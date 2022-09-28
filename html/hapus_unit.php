<?php 
require_once("module/model/koneksi/koneksi.php");

if(!isset($_SESSION["LOGINIDUS_MT"]))
{
    ?><script>alert('Silahkan login dahulu');</script><?php
    ?><script>document.location.href='index';</script><?php
    die(0);
}

if(isset($_GET["KODE_UNIT"]))
{
    $DINO        = date('Y-m-d H:i:s');
    $ID_USER1    = $_SESSION["LOGINIDUS_MT"];
    $IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
    $PC_NAME     = $_SESSION["PC_NAME_MT"];
    $KODE_UNIT   = $_GET["KODE_UNIT"];

    $stmt2 = $db1->prepare("update m_unit set STATUS = 1 where KODE_UNIT = '$KODE_UNIT'");
    $stmt2->execute();
    
    $stmt1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Unit','Hapus','Kode $KODE_UNIT')");
    $stmt1->execute();


    ?><script>document.location.href='unit';</script><?php
    die(0);
}
?>