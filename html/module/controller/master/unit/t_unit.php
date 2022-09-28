<?php
$DATE        = date("Y");
$KODE_UNIT   = createKode("m_unit","KODE_UNIT","UNIT/$DATE/",4);
$KODE_BARANG = "";
$NAMA_UNIT   = "";
$IP_ADD      = "";
$MAC_ADD     = "";
$LOKASI      = "";
$MERK        = "";
$TYPE        = "";
$SPEC        = "";
$KETERANGAN  = "";

$DINO        = date('Y-m-d H:i:s');
$ID_USER1    = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME     = $_SESSION["PC_NAME_MT"];

//EDIT UNIT
if(isset($_GET["KODE_UNIT"]))
{
    $KODE_UNIT = $_GET["KODE_UNIT"];

    $result = GetQuery("select * from m_unit where KODE_UNIT = '$KODE_UNIT'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        $KODE_BARANG = $row["KODE_BARANG"];
        $NAMA_UNIT   = $row["NAMA_UNIT"];
        $LOKASI      = $row["LOKASI"];
        $MERK        = $row["MERK"];
        $TYPE        = $row["TYPE"];
        $SPEC        = $row["SPEC"];
        $KETERANGAN  = $row["KETERANGAN"];

        if ($KODE_BARANG == "BRG/201803/00106") //komputer
        {
            $IP_ADD  = $row["IP_ADD"];
            $MAC_ADD = $row["MAC_ADD"];
        }
    }

    if(isset($_POST["simpan"]))
    {
        $KODE_BARANG = $_POST["KODE_BARANG"];
        $NAMA_UNIT   = $_POST["NAMA_UNIT"];
        $LOKASI      = $_POST["LOKASI"];
        $MERK        = $_POST["MERK"];
        $TYPE        = $_POST["TYPE"];
        $SPEC        = $_POST["SPEC"];
        $KETERANGAN  = $_POST["KETERANGAN"];

        if ($KODE_BARANG == "BRG/201803/00106") //komputer
        {
            $IP_ADD  = $_POST["IP_ADD"];
            $MAC_ADD = $_POST["MAC_ADD"];
        }

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Unit Barang','Edit','Kode $KODE_UNIT'");

        UpdateData(
            "m_unit",
            "KODE_BARANG = '$KODE_BARANG', NAMA_UNIT = '$NAMA_UNIT', LOKASI = '$LOKASI', MERK = '$MERK', TYPE = '$TYPE', SPEC = '$SPEC', KETERANGAN = '$KETERANGAN', MODIFIED_DATE = '$DINO', MODIFIED_BY = '$ID_USER1' ",
            "KODE_UNIT= '$KODE_UNIT'");

        ?><script>document.location.href='unit';</script><?php
        die(0);
    }
}

//TAMBAH UNIT
if(isset($_POST["simpan"]))
{
    $KODE_BARANG = $_POST["KODE_BARANG"];
    $NAMA_UNIT   = $_POST["NAMA_UNIT"];
    $LOKASI      = $_POST["LOKASI"];
    $MERK        = $_POST["MERK"];
    $TYPE        = $_POST["TYPE"];
    $SPEC        = $_POST["SPEC"];
    $KETERANGAN  = $_POST["KETERANGAN"];
    // $IP_ADD  = $_POST["IP_ADD"];
    // $MAC_ADD = $_POST["MAC_ADD"];
    

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Unit Barang','Tambah','Kode $KODE_UNIT'");

    InsertData(
        "m_unit",
          "KODE_UNIT,   KODE_BARANG,   NAMA_UNIT,   LOKASI,   MERK,   TYPE,   SPEC,  KETERANGAN,  CREATED_DATE, CREATED_BY",
        "'$KODE_UNIT','$KODE_BARANG','$NAMA_UNIT','$LOKASI','$MERK','$TYPE','$SPEC','$KETERANGAN','$DINO', '$ID_USER1'");

    // echo $KODE_UNIT."-".$KODE_BARANG."-".$NAMA_UNIT."-".$LOKASI."-".$MERK."-".$TYPE."-".$SPEC."-".$KETERANGAN."-".$DINO."-".$ID_USER1;

    ?><script>document.location.href='unit';</script><?php
    die(0);
}
?>

