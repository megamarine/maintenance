<?php

$DINO        = date('Y-m-d H:i:s');
$DATE        = date('Ym');
$KODE_TRANS  = createKode("t_jamopr","KODE_TRANS","OPR/$DATE/",4);
$KODE_BARANG = "";
$KODE_UNIT   = "";
$JAM_OPR     = "";
$TANGGAL     = "";
$KETERANGAN  = "";
$ID_USER1    = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME     = $_SESSION["PC_NAME_MT"];

//EDIT
if(isset($_GET["KODE_TRANS"]))
{
    $KODE_TRANS = $_GET["KODE_TRANS"];

    $result = GetData1("*","t_jamopr","KODE_TRANS = '$KODE_TRANS'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        $TANGGAL     = $row["TANGGAL"];
        $KODE_BARANG = $row["KODE_BARANG"];
        $KODE_UNIT   = $row["KODE_UNIT"];
        $JAM_OPR     = $row["JAM_OPR"];
        $KETERANGAN  = $row["KETERANGAN"];
    }

    if(isset($_POST["simpan"]))
    {
        $TANGGAL     = $_POST["TANGGAL"];
        $KODE_BARANG = $_POST["KODE_BARANG"];
        $KODE_BARANG = $_POST["KODE_UNIT"];
        $JAM_OPR     = $_POST["JAM_OPR"];
        $KETERANGAN  = $_POST["KETERANGAN"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Jam Operational','Edit','Kode Trans $KODE_TRANS'");

        UpdateData(
            "t_jamopr",
            "KODE_BARANG = '$KODE_BARANG', KODE_UNIT = '$KODE_UNIT', JAM_OPR = '$JAM_OPR', TANGGAL ='$TANGGAL', KETERANGAN='$KETERANGAN', MODIFIED_DATE='$DINO', MODIFIED_BY='$ID_USER1' ",
            "KODE_TRANS = '$KODE_TRANS'");

        ?><script>document.location.href='jamoperational';</script><?php
        die(0);
    }
}

//SIMPAN BARU
if(isset($_POST["simpan"]))
{
    $TANGGAL     = $_POST["TANGGAL"];
    $KODE_BARANG = $_POST["KODE_BARANG"];
    $KODE_UNIT   = $_POST["KODE_UNIT"];
    $JAM_OPR     = $_POST["JAM_OPR"];
    $KETERANGAN  = $_POST["KETERANGAN"];

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Jam Operational','Tambah','Kode Trans $KODE_TRANS'");

    InsertData(
        "t_jamopr",
        "KODE_TRANS, KODE_BARANG, KODE_UNIT,JAM_OPR,TANGGAL,KETERANGAN,STATUS,CREATED_DATE,CREATED_BY",
        "'$KODE_TRANS','$KODE_BARANG','$KODE_UNIT','$JAM_OPR','$TANGGAL','$KETERANGAN','0','$DINO','$ID_USER1'");

    ?><script>document.location.href='jamoperational';</script><?php
    die(0);
}
?>