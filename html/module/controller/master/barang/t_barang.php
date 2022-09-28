<?php
$DATE        = date("Ym");
$KODE_BARANG = createKode("m_barang","KODE_BARANG","BRG/$DATE/",4);
$NAMA_BARANG = "";
$KODE_JENIS  = "";
$ITEM_TYPE   = "";
$KETERANGAN  = "";

$DINO        = date('Y-m-d H:i:s');
$ID_USER1    = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME     = $_SESSION["PC_NAME_MT"];

//EDIT BARANG
if(isset($_GET["KODE_BARANG"]))
{
    $KODE_BARANG = $_GET["KODE_BARANG"];

    $result = GetData1("*","m_barang","KODE_BARANG = '$KODE_BARANG'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        $NAMA_BARANG = $row["NAMA_BARANG"];
        $KODE_JENIS  = $row["KODE_JENIS"];
        $KETERANGAN  = $row["KETERANGAN"];
        $ITEM_TYPE   = $row["ITEM_TYPE"];
    }

    if(isset($_POST["simpan"]))
    {
        $NAMA_BARANG = $_POST["NAMA_BARANG"];
        $ITEM_TYPE   = $_POST["ITEM_TYPE"];
        $KETERANGAN  = $_POST["KETERANGAN"];

        // IT
        if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
        {
            $KODE_JENIS = $_POST["KODE_JENIS"];
        }
        // MEKANIK
        elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
        {
            $KODE_JENIS = 2;
        }
        // CIVIL
        elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") 
        {
            $KODE_JENIS = 4;
        }
        // GA
        else
        {
            $KODE_JENIS = 3;
        }

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Barang','Edit','Kode $KODE_BARANG'");

        UpdateData(
            "m_barang",
            "NAMA_BARANG = '$NAMA_BARANG', KODE_JENIS = '$KODE_JENIS', KETERANGAN = '$KETERANGAN', ITEM_TYPE = '$ITEM_TYPE', MODIFIED_DATE = '$DINO', MODIFIED_BY = '$ID_USER1' ",
            "KODE_BARANG = '$KODE_BARANG'");

        ?><script>document.location.href='barang';</script><?php
        die(0);
    }
}

//TAMBAH BARANG
if(isset($_POST["simpan"]))
{
    $NAMA_BARANG = $_POST["NAMA_BARANG"];
    $KETERANGAN  = $_POST["KETERANGAN"];
    $ITEM_TYPE   = $_POST["ITEM_TYPE"];

    // IT
    if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
    {
        $KODE_JENIS = $_POST["KODE_JENIS"];
    }
    // MEKANIK
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
    {
        $KODE_JENIS = 2;
    }
    // CIVIL
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") 
    {
        $KODE_JENIS = 4;
    }
    // GA
    else
    {
        $KODE_JENIS = 3;
    }

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Barang','Tambah','Kode $KODE_BARANG'");

    InsertData(
        "m_barang",
        "KODE_BARANG,KODE_JENIS,NAMA_BARANG,KETERANGAN,ITEM_TYPE,CREATED_DATE,CREATED_BY",
        "'$KODE_BARANG','$KODE_JENIS','$NAMA_BARANG','$KETERANGAN','$ITEM_TYPE','$DINO','$ID_USER1'");

    ?><script>document.location.href='barang';</script><?php
    die(0);
}
?>