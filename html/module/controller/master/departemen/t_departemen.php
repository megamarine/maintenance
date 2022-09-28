<?php
$KODE_DEPARTEMEN = createKode("m_departemen","KODE_DEPARTEMEN","DEPT-",4);
$KODE_BAGIAN     = "";
$KODE_PERUSAHAAN = "";
$NAMA_DEPARTEMEN = "";
$DINO            = date('Y-m-d H:i:s');
$ID_USER1        = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS      = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME         = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_DEPARTEMEN"]))
{
    $KODE_DEPARTEMEN = $_GET["KODE_DEPARTEMEN"];

    $result = GetData1("*","m_departemen","KODE_DEPARTEMEN = '$KODE_DEPARTEMEN'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $KODE_BAGIAN     = $row["KODE_BAGIAN"];
        $KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
        $NAMA_DEPARTEMEN = $row["NAMA_DEPARTEMEN"];
    }

    if(isset($_POST["simpan"]))
    {
        $KODE_BAGIAN     = $_POST["KODE_BAGIAN"];
        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $NAMA_DEPARTEMEN = $_POST["NAMA_DEPARTEMEN"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Departemen','Edit Departemen','User Mengedit Departemen dengan Kode $KODE_DEPARTEMEN'");

        UpdateData(
            "m_departemen",
            "NAMA_DEPARTEMEN = '$NAMA_DEPARTEMEN', KODE_BAGIAN = '$KODE_BAGIAN', KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', NAMA_DEPARTEMEN = '$NAMA_DEPARTEMEN'",
            "KODE_DEPARTEMEN = '$KODE_DEPARTEMEN'");

        ?><script>document.location.href='departemen';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $KODE_BAGIAN     = $_POST["KODE_BAGIAN"];
    $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
    $NAMA_DEPARTEMEN = $_POST["NAMA_DEPARTEMEN"];

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Departemen','Tambah Departemen','User Menambah Departemen dengan Kode $KODE_DEPARTEMEN'");

    InsertData(
        "m_departemen",
        "KODE_DEPARTEMEN,KODE_BAGIAN,KODE_PERUSAHAAN,NAMA_DEPARTEMEN",
        "'$KODE_DEPARTEMEN','$KODE_BAGIAN','$KODE_PERUSAHAAN','$NAMA_DEPARTEMEN'");

    ?><script>document.location.href='departemen';</script><?php
    die(0);
}
?>