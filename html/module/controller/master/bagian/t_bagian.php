<?php
$KODE_BAGIAN        = createKode("m_bagian","KODE_BAGIAN","DIV-",4);
$KODE_PERUSAHAAN    = "";
$NAMA_BAGIAN        = "";
$GROUP_MANAGEMENT   = "";
$DINO               = date('Y-m-d H:i:s');
$ID_USER1           = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME            = $_SESSION["PC_NAME_MT"];

//EDIT
if(isset($_GET["KODE_BAGIAN"]))
{
    $KODE_BAGIAN = $_GET["KODE_BAGIAN"];

    $result = GetData1("*","m_bagian","KODE_BAGIAN = '$KODE_BAGIAN'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $KODE_PERUSAHAAN    = $row["KODE_PERUSAHAAN"];
        $NAMA_BAGIAN        = $row["NAMA_BAGIAN"];
        $GROUP_MANAGEMENT   = $row["GROUP_MANAGEMENT"];
    }

    if(isset($_POST["simpan"]))
    {
        $KODE_PERUSAHAAN    = $_POST["KODE_PERUSAHAAN"];
        $NAMA_BAGIAN        = $_POST["NAMA_BAGIAN"];
        $GROUP_MANAGEMENT   = $_POST["GROUP_MANAGEMENT"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Divisi','Edit Divisi','User Mengedit Divisi dengan Kode $KODE_BAGIAN'");

        UpdateData(
            "m_bagian",
            "KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', NAMA_BAGIAN = '$NAMA_BAGIAN', GROUP_MANAGEMENT = '$GROUP_MANAGEMENT'",
            "KODE_BAGIAN = '$KODE_BAGIAN'");

        ?><script>document.location.href='bagian';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $KODE_PERUSAHAAN    = $_POST["KODE_PERUSAHAAN"];
    $NAMA_BAGIAN        = $_POST["NAMA_BAGIAN"];
    $GROUP_MANAGEMENT   = $_POST["GROUP_MANAGEMENT"];

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Divisi','Tambah Divisi','User Menambah Divisi dengan Kode $KODE_BAGIAN'");

    InsertData(
        "m_bagian",
        "KODE_BAGIAN,KODE_PERUSAHAAN,NAMA_BAGIAN,GROUP_MANAGEMENT",
        "'$KODE_BAGIAN','$KODE_PERUSAHAAN','$NAMA_BAGIAN','$GROUP_MANAGEMENT'");

    ?><script>document.location.href='bagian';</script><?php
    die(0);
}
?>