<?php
$DATE               = date("Ym");
$KODE_TEKNISI       = createKode("m_teknisi","KODE_TEKNISI","TKS/$DATE/",3);
$ID_KARYAWAN        = "";
$KODE_PERUSAHAAN    = "";
$KODE_JENIS         = "";
$NAMA_TEKNISI       = "";
$JABATAN            = "";
$JAM_KERJA          = "";
$HARI_KERJA         = "";
$DINO               = date('Y-m-d H:i:s');
$ID_USER1           = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME            = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_TEKNISI"]))
{
    $KODE_TEKNISI = $_GET["KODE_TEKNISI"];

    $result = GetData1("*","m_teknisi","KODE_TEKNISI = '$KODE_TEKNISI'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $ID_KARYAWAN     = $row["ID_KARYAWAN"];
        $KODE_JENIS      = $row["KODE_JENIS"];
        $NAMA_TEKNISI    = $row["NAMA_TEKNISI"];
        $JABATAN         = $row["JABATAN"];
        $JAM_KERJA       = $row["JAM_KERJA"];
        $KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
        $HARI_KERJA      = $row["HARI_KERJA"];
    }

    if(isset($_POST["simpan"]))
    {
        if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
            $ID_KARYAWAN     = $_POST["ID_KARYAWAN"];
            $KODE_JENIS      = $_POST["KODE_JENIS"];
            $NAMA_TEKNISI    = $_POST["NAMA_TEKNISI"];
            $JABATAN         = $_POST["JABATAN"];
            $JAM_KERJA       = $_POST["JAM_KERJA"];
            $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
            $HARI_KERJA      = $_POST["HARI_KERJA"];
        } else {
            $ID_KARYAWAN = $_POST["ID_KARYAWAN"];
            // ADMINISTRATOR / IT
            if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
                $KODE_JENIS = $_POST["KODE_JENIS"];
            }
            // MEKANIK
            elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0101" ) {
                $KODE_JENIS = 2;
            }
            // CIVIL ENGINEERING
            elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") {
                $KODE_JENIS = 4;
            }
            else{
                $KODE_JENIS = 3;
            }
            $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
            $NAMA_TEKNISI    = $_POST["NAMA_TEKNISI"];
            $JABATAN         = $_POST["JABATAN"];
            $JAM_KERJA       = $_POST["JAM_KERJA"];
            $HARI_KERJA      = $_POST["HARI_KERJA"];
        }

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Teknisi','Edit Teknisi','User Mengedit Teknisi dengan Kode $KODE_TEKNISI'");

        UpdateData(
            "m_teknisi",
            "ID_KARYAWAN = '$ID_KARYAWAN', KODE_JENIS = '$KODE_JENIS', NAMA_TEKNISI = '$NAMA_TEKNISI', JAM_KERJA = '$JAM_KERJA', JABATAN = '$JABATAN', KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', HARI_KERJA = '$HARI_KERJA'",
            "KODE_TEKNISI = '$KODE_TEKNISI'");

        ?><script>document.location.href='teknisi';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
    {
        $ID_KARYAWAN     = $_POST["ID_KARYAWAN"];
        $KODE_JENIS      = $_POST["KODE_JENIS"];
        $NAMA_TEKNISI    = $_POST["NAMA_TEKNISI"];
        $JABATAN         = $_POST["JABATAN"];
        $JAM_KERJA       = $_POST["JAM_KERJA"];
        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $HARI_KERJA      = $_POST["HARI_KERJA"];
    } 
    else 
    {
        $ID_KARYAWAN = $_POST["ID_KARYAWAN"];
        // ADMINISTRATOR / IT
        if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
            $KODE_JENIS = $_POST["KODE_JENIS"];
        }
        // MEKANIK
        elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0101" ) {
            $KODE_JENIS = 2;
        }
        // CIVIL ENGINEERING
        elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") {
            $KODE_JENIS = 4;
        }
        else{
            $KODE_JENIS = 3;
        }
        $NAMA_TEKNISI    = $_POST["NAMA_TEKNISI"];
        $JABATAN         = $_POST["JABATAN"];
        $JAM_KERJA       = $_POST["JAM_KERJA"];
        $KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
        $HARI_KERJA      = $_POST["HARI_KERJA"];
    }

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Teknisi','Tambah Teknisi','User Menambah Teknisi dengan Kode $KODE_TEKNISI'");

    InsertData(
        "m_teknisi",
        "KODE_TEKNISI,KODE_JENIS,ID_KARYAWAN,NAMA_TEKNISI,JAM_KERJA,JABATAN,KODE_PERUSAHAAN,HARI_KERJA",
        "'$KODE_TEKNISI','$KODE_JENIS','$ID_KARYAWAN','$NAMA_TEKNISI','$JAM_KERJA','$JABATAN','$KODE_PERUSAHAAN','$HARI_KERJA'");

    ?><script>document.location.href='teknisi';</script><?php
    die(0);
}
?>