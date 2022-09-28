<?php
$KODE_PERUSAHAAN = kodeAuto("m_perusahaan","KODE_PERUSAHAAN");
$NAMA_PERUSAHAAN = "";
$DINO            = date('Y-m-d H:i:s');
$ID_USER1        = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS      = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME         = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_PERUSAHAAN"]))
{
    $KODE_PERUSAHAAN = $_GET["KODE_PERUSAHAAN"];

    $result = GetData1("*","m_perusahaan","KODE_PERUSAHAAN = '$KODE_PERUSAHAAN'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $NAMA_PERUSAHAAN = $row["NAMA_PERUSAHAAN"];
    }

    if(isset($_POST["simpan"]))
    {
        $NAMA_PERUSAHAAN = $_POST["NAMA_PERUSAHAAN"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Perusahaan','Edit Perusahaan','User Mengedit Perusahaan dengan Kode $KODE_PERUSAHAAN'");

        UpdateData("m_perusahaan","NAMA_PERUSAHAAN = '$NAMA_PERUSAHAAN'","KODE_PERUSAHAAN = '$KODE_PERUSAHAAN'");

        ?><script>document.location.href='perusahaan';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $NAMA_PERUSAHAAN = $_POST["NAMA_PERUSAHAAN"];

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Perusahaan','Tambah Perusahaan','User Menambah Perusahaan dengan Kode $KODE_PERUSAHAAN'");

    InsertData("m_perusahaan","KODE_PERUSAHAAN,NAMA_PERUSAHAAN","'$KODE_PERUSAHAAN','$NAMA_PERUSAHAAN'");

    ?><script>document.location.href='perusahaan';</script><?php
    die(0);
}
?>