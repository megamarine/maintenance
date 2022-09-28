<?php
$DATE           = date("Ym");
$KODE_PART      = createKode("m_sparepart","KODE_PART","PRT/$DATE/",4);
$KODE_BARANG    = "";
$NAMA_PART      = "";
$KETERANGAN     = "";
$JUMLAH_PART    = "";
$HARGA_PART     = "";
$KODE_SATUAN    = "";
$STOK_PART      = "";
$LIFETIME_PART  = "";
$STOKMIN_PART   = "";
$KODE_SATUAN    = "";
$DINO           = date('Y-m-d H:i:s');
$ID_USER1       = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS     = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME        = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_PART"]))
{
    $KODE_PART = $_GET["KODE_PART"];

    $result = GetData1("*","m_sparepart","KODE_PART = '$KODE_PART'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $KODE_BARANG    = $row["KODE_BARANG"];
        $NAMA_PART      = $row["NAMA_PART"];
        $KETERANGAN     = $row["KETERANGAN"];
        $HARGA_PART     = $row["HARGA_PART"];
        $STOK_PART      = $row["STOK_PART"];
        $LIFETIME_PART  = $row["LIFETIME_PART"];
        $STOKMIN_PART   = $row["STOKMIN_PART"];
        $KODE_SATUAN    = $row["KODE_SATUAN"];
    }

    if(isset($_POST["simpan"]))
    {
        $KODE_BARANG    = $_POST["KODE_BARANG"];
        $NAMA_PART      = $_POST["NAMA_PART"];
        $KETERANGAN     = $_POST["KETERANGAN"];
        $STOK_PART      = $_POST["STOK_PART"];
        $LIFETIME_PART  = $_POST["LIFETIME_PART"];
        $STOKMIN_PART   = $_POST["STOKMIN_PART"];
        $KODE_SATUAN    = $_POST["KODE_SATUAN"];
        if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINAKS_MT"] == "Manajer") {
            $HARGA_PART = $_POST["HARGA_PART"];
        }

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Spare Part','Edit Spare Part','User Mengedit Spare Part dengan Kode $KODE_PART'");

        UpdateData(
            "m_sparepart",
            "KODE_BARANG = '$KODE_BARANG',NAMA_PART = '$NAMA_PART', KETERANGAN = '$KETERANGAN', HARGA_PART = '$HARGA_PART', STOK_PART = '$STOK_PART', LIFETIME_PART = '$LIFETIME_PART', STOKMIN_PART = '$STOKMIN_PART', KODE_SATUAN = '$KODE_SATUAN'","KODE_PART = '$KODE_PART'");

        ?><script>document.location.href='sparepart';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $KODE_BARANG    = $_POST["KODE_BARANG"];
    $NAMA_PART      = $_POST["NAMA_PART"];
    $KETERANGAN     = $_POST["KETERANGAN"];
    $STOK_PART      = $_POST["STOK_PART"];
    $LIFETIME_PART  = $_POST["LIFETIME_PART"];
    $STOKMIN_PART   = $_POST["STOKMIN_PART"];
    $KODE_SATUAN    = $_POST["KODE_SATUAN"];
    if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINAKS_MT"] == "Manajer") {
        $HARGA_PART = $_POST["HARGA_PART"];
    }
    
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
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Spare Part','Tambah Spare Part','User Menambah Spare Part dengan Kode $KODE_PART'");

    InsertData(
        "m_sparepart",
        "KODE_BARANG,KODE_PART,NAMA_PART,KETERANGAN,HARGA_PART,KODE_JENIS,STOK_PART,LIFETIME_PART,STOKMIN_PART, KODE_SATUAN",
        "'$KODE_BARANG','$KODE_PART','$NAMA_PART','$KETERANGAN','$HARGA_PART','$KODE_JENIS','$STOK_PART','$LIFETIME_PART','$STOKMIN_PART','$KODE_SATUAN'");

    ?><script>document.location.href='tambah_sparepart';</script><?php
    die(0);
}
?>