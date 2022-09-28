<?php
$KODE_USER          = "";
$KODE_DEPARTEMEN    = "";
$KODE_BAGIAN        = "";
$KODE_PERUSAHAAN    = "";
$NAMA_USER          = "";
$PASSWORD           = "";
$EMAIL              = "";

$options = [
    'cost' => 12,
];

$DINO       = date('Y-m-d H:i:s');
$ID_USER1   = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME    = $_SESSION["PC_NAME_MT"];

//EDIT
if(isset($_GET["KODE_USER"]))
{
    $KODE_USER = $_GET["KODE_USER"];

    // $query = "select * from m_user where KODE_USER = '$KODE_USER'";
    $result = GetData1("*","m_user","KODE_USER = '$KODE_USER'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $KODE_DEPARTEMEN = $row["KODE_DEPARTEMEN"];
        $KODE_BAGIAN     = $row["KODE_BAGIAN"];
        $KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
        $NAMA_USER       = $row["NAMA_USER"];
        $STATUS          = $row["STATUS"];
        $AKSES           = $row["AKSES"];
        $EMAIL           = $row["EMAIL"];
    }

    if(isset($_POST["simpan"]))
    {
        if ($_SESSION["LOGINAKS_MT"] == "Manajer") 
        {
            $NAMA_USER       = $_POST["NAMA_USER"];
            $PASSWORD        = password_hash($_POST['PASSWORD'], PASSWORD_BCRYPT, $options);
            $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
            $KODE_BAGIAN     = $_SESSION["LOGINBAG_MT"];
            $KODE_PERUSAHAAN = $_SESSION["LOGINPER_MT"];
            $STATUS          = $_POST["STATUS"];

            InsertData(
                "t_userlog",
                "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Pengguna','Edit Pengguna','User Mengedit Pengguna dengan Kode $KODE_USER'");

            UpdateData(
                "m_user",
                "NAMA_USER = '$NAMA_USER', PASSWORD = '$PASSWORD', KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', KODE_BAGIAN = '$KODE_BAGIAN', KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', STATUS = '$STATUS'",
                "KODE_USER = '$KODE_USER'");
        }
        else
        {
            $NAMA_USER       = $_POST["NAMA_USER"];
            $PASSWORD        = password_hash($_POST['PASSWORD'], PASSWORD_BCRYPT, $options);
            $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
            $KODE_BAGIAN     = $_POST["KODE_BAGIAN"];
            $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
            $STATUS          = $_POST["STATUS"];
            $AKSES           = $_POST["AKSES"];
            $EMAIL           = $_POST["EMAIL"];

            InsertData(
                "t_userlog",
                "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Pengguna','Edit Pengguna','User Mengedit Pengguna dengan Kode $KODE_USER'");

            UpdateData(
                "m_user",
                "NAMA_USER = '$NAMA_USER', PASSWORD = '$PASSWORD', KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', KODE_BAGIAN = '$KODE_BAGIAN', KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', STATUS = '$STATUS', AKSES = '$AKSES', EMAIL = '$EMAIL'","KODE_USER = '$KODE_USER'");
        }
        ?><script>document.location.href='user';</script><?php
        die(0);
    }
}

//TAMBAH
if(isset($_POST["simpan"]))
{
    if ($_SESSION["LOGINAKS_MT"] == "Manajer") 
    {
        $KODE_USER       = $_POST["KODE_USER"];
        $NAMA_USER       = $_POST["NAMA_USER"];
        $PASSWORD        = password_hash($_POST['PASSWORD'], PASSWORD_BCRYPT, $options);
        $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
        $KODE_BAGIAN     = $_SESSION["LOGINBAG_MT"];
        $KODE_PERUSAHAAN = $_SESSION["LOGINPER_MT"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Pengguna','Tambah Pengguna','User Menambah Pengguna dengan Kode $KODE_USER'");

        InsertData(
            "m_user",
            "KODE_USER,KODE_DEPARTEMEN,KODE_BAGIAN,KODE_PERUSAHAAN,NAMA_USER,PASSWORD,STATUS,AKSES",
            "'$KODE_USER','$KODE_DEPARTEMEN','$KODE_BAGIAN','$KODE_PERUSAHAAN','$NAMA_USER','$PASSWORD','Aktif','Admin'");
    }
    else
    {
        $KODE_USER       = $_POST["KODE_USER"];
        $NAMA_USER       = $_POST["NAMA_USER"];
        $PASSWORD        = password_hash($_POST['PASSWORD'], PASSWORD_BCRYPT, $options);
        $KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
        $KODE_BAGIAN     = $_POST["KODE_BAGIAN"];
        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $AKSES           = $_POST["AKSES"];
        $EMAIL           = $_POST["EMAIL"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Pengguna','Tambah Pengguna','User Menambah Pengguna dengan Kode $KODE_USER'");

        InsertData(
            "m_user",
            "KODE_USER,KODE_DEPARTEMEN,KODE_BAGIAN,KODE_PERUSAHAAN,NAMA_USER,PASSWORD,STATUS,AKSES,EMAIL",
            "'$KODE_USER','$KODE_DEPARTEMEN','$KODE_BAGIAN','$KODE_PERUSAHAAN','$NAMA_USER','$PASSWORD','Aktif','$AKSES','$EMAIL'");
    }

    ?><script>document.location.href='user';</script><?php
    die(0);
}
?>