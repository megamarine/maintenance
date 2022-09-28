<?php
$u                  = date("Ym");
$DATE               = date("Y-m-d");
$KODE_PTK           = createKode("t_ptk","KODE_PTK","PTK-$u-",4);
$KODE_PERUSAHAAN    = "";
$KODE_BAGIAN        = "";
$KODE_DEPARTEMEN    = "";
$KODE_JABATAN       = "";
$JUMLAH             = "";
$PENDIDIKAN         = "";
$KUALIFIKASI        = "";
$PENGALAMAN_KERJA   = "";
$STATUS_KERJA       = "";
$TGL_BUTUH          = "";
$ALASAN             = "";
$TUGAS_POKOK        = "";
$KETERANGAN         = "";
$DIMINTA            = "";
$JABATAN_MINTA      = "";
$BAGIAN             = "";
$DINO               = date('Y-m-d H:i:s');
$ID_USER1           = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME            = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_PTK"]))
{
    $KODE_PTK = $_GET["KODE_PTK"];
    $query = "select p.*,b.GROUP_MANAGEMENT from t_ptk p, m_bagian b where p.KODE_BAGIAN = b.KODE_BAGIAN and p.KODE_PTK = '$KODE_PTK'";
    $result = mysql_query($query, $DB1);
    while ($row = mysql_fetch_array($result)) {
        $KODE_PERUSAHAAN  = $row["KODE_PERUSAHAAN"];
        $KODE_BAGIAN      = $row["KODE_BAGIAN"];
        $KODE_DEPARTEMEN  = $row["KODE_DEPARTEMEN"];
        $KODE_JABATAN     = $row["KODE_JABATAN"];
        $JUMLAH           = $row["JUMLAH"];
        $PENDIDIKAN       = $row["PENDIDIKAN"];
        $KUALIFIKASI      = $row["KUALIFIKASI"];
        $PENGALAMAN_KERJA = $row["PENGALAMAN_KERJA"];
        $STATUS_KERJA     = $row["STATUS_KERJA"];
        $TGL_BUTUH        = $row["TGL_BUTUH"];
        $ALASAN           = $row["ALASAN"];
        $TUGAS_POKOK      = $row["TUGAS_POKOK"];
        $KETERANGAN       = $row["KETERANGAN"];
        $APP_HRD          = $row["APP_HRD"];
        $USER_REQ         = $row["USER_REQ"];
        $DIMINTA          = $row["DIMINTA"];
        $JABATAN_MINTA    = $row["JABATAN_MINTA"];
        $APP_MANAJER      = $row["APP_MANAJER"];
        $GROUP_MANAGEMENT = $row["GROUP_MANAGEMENT"];
        $BAGIAN           = $row["BAGIAN"];
    }

    $GRP = $_SESSION["LOGINGRP_MT"];
    $DEP = $_SESSION["LOGINDEP_MT"];
    $BAG = $_SESSION["LOGINBAG_MT"];
    if ($_SESSION["LOGINAKS_MT"] == "Admin") {
        if ($DEP != $KODE_DEPARTEMEN) {
            http_response_code(404);
            die(0);
        }
    }
    elseif ($_SESSION["LOGINAKS_MT"] == "Manajer") {
        if ($BAG != $KODE_BAGIAN) {
            http_response_code(404);
            die(0);
        }
    }
    elseif ($_SESSION["LOGINAKS_MT"] == "Direktur") {
        if ($GRP != $GROUP_MANAGEMENT) {
            http_response_code(404);
            die(0);
        }
    }

    if(isset($_POST["simpan"]))
    {
        if ($_SESSION["LOGINAKS_MT"] == "Administrator") {
        $KODE_PERUSAHAAN  = $_POST["KODE_PERUSAHAAN"];
        $KODE_BAGIAN      = $_POST["KODE_BAGIAN"];
        $KODE_DEPARTEMEN  = $_POST["KODE_DEPARTEMEN"];
        $KODE_JABATAN     = $_POST["KODE_JABATAN"];
        $JUMLAH           = $_POST["JUMLAH"];
        $PENDIDIKAN       = $_POST["PENDIDIKAN"];
        $KUALIFIKASI      = $_POST["KUALIFIKASI"];
        $PENGALAMAN_KERJA = $_POST["PENGALAMAN_KERJA"];
        $STATUS_KERJA     = $_POST["STATUS_KERJA"];
        $TGL_BUTUH        = $_POST["TGL_BUTUH"];
        $ALASAN           = $_POST["ALASAN"];
        $TUGAS_POKOK      = $_POST["TUGAS_POKOK"];
        $KETERANGAN       = $_POST["KETERANGAN"];
        $DIMINTA          = $_POST["DIMINTA"];
        $JABATAN_MINTA    = $_POST["JABATAN_MINTA"];
        $BAGIAN           = $_POST["BAGIAN"];
    }
    else
    {
        $KODE_PERUSAHAAN  = $_SESSION["LOGINPER_MT"];
        $KODE_BAGIAN      = $_SESSION["LOGINBAG_MT"];
        $KODE_DEPARTEMEN  = $_SESSION["LOGINDEP_MT"];
        $KODE_JABATAN     = $_POST["KODE_JABATAN"];
        $JUMLAH           = $_POST["JUMLAH"];
        $PENDIDIKAN       = $_POST["PENDIDIKAN"];
        $KUALIFIKASI      = $_POST["KUALIFIKASI"];
        $PENGALAMAN_KERJA = $_POST["PENGALAMAN_KERJA"];
        $STATUS_KERJA     = $_POST["STATUS_KERJA"];
        $TGL_BUTUH        = $_POST["TGL_BUTUH"];
        $ALASAN           = $_POST["ALASAN"];
        $TUGAS_POKOK      = $_POST["TUGAS_POKOK"];
        $KETERANGAN       = $_POST["KETERANGAN"];
        $DIMINTA          = $_POST["DIMINTA"];
        $JABATAN_MINTA    = $_POST["JABATAN_MINTA"];
        $BAGIAN           = $_POST["BAGIAN"];
    }

        $querylog = 
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','PTK','Edit PTK','User Mengedit PTK dengan Kode $KODE_PTK')";
        mysql_query($querylog, $DB1);

        $query2 = 
        "update t_ptk 
        set KODE_PERUSAHAAN = '$KODE_PERUSAHAAN', 
        KODE_BAGIAN = '$KODE_BAGIAN', KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', KODE_JABATAN = '$KODE_JABATAN', JUMLAH = '$JUMLAH', PENDIDIKAN = '$PENDIDIKAN', KUALIFIKASI = '$KUALIFIKASI', PENGALAMAN_KERJA = '$PENGALAMAN_KERJA', STATUS_KERJA = '$STATUS_KERJA', TGL_BUTUH = '$TGL_BUTUH', ALASAN = '$ALASAN', TUGAS_POKOK = '$TUGAS_POKOK', KETERANGAN = '$KETERANGAN', USER_REQ = '$ID_USER1', DIMINTA = '$DIMINTA', JABATAN_MINTA = '$JABATAN_MINTA', IP_ADDRESS = '$IP_ADDRESS', PC_NAME = '$PC_NAME', BAGIAN = '$BAGIAN' 
        where KODE_PTK = '$KODE_PTK'";
        mysql_query($query2, $DB1);

        ?><script>document.location.href='pengajuanptk.php';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    if ($_SESSION["LOGINAKS_MT"] == "Administrator") {
        $KODE_PERUSAHAAN  = $_POST["KODE_PERUSAHAAN"];
        $KODE_BAGIAN      = $_POST["KODE_BAGIAN"];
        $KODE_DEPARTEMEN  = $_POST["KODE_DEPARTEMEN"];
        $KODE_JABATAN     = $_POST["KODE_JABATAN"];
        $JUMLAH           = $_POST["JUMLAH"];
        $PENDIDIKAN       = $_POST["PENDIDIKAN"];
        $KUALIFIKASI      = $_POST["KUALIFIKASI"];
        $PENGALAMAN_KERJA = $_POST["PENGALAMAN_KERJA"];
        $STATUS_KERJA     = $_POST["STATUS_KERJA"];
        $TGL_BUTUH        = $_POST["TGL_BUTUH"];
        $ALASAN           = $_POST["ALASAN"];
        $TUGAS_POKOK      = $_POST["TUGAS_POKOK"];
        $KETERANGAN       = $_POST["KETERANGAN"];
        $DIMINTA          = $_POST["DIMINTA"];
        $JABATAN_MINTA    = $_POST["JABATAN_MINTA"];
        $BAGIAN           = $_POST["BAGIAN"];
    }
    else
    {
        $KODE_PERUSAHAAN  = $_SESSION["LOGINPER_MT"];
        $KODE_BAGIAN      = $_SESSION["LOGINBAG_MT"];
        $KODE_DEPARTEMEN  = $_SESSION["LOGINDEP_MT"];
        $KODE_JABATAN     = $_POST["KODE_JABATAN"];
        $JUMLAH           = $_POST["JUMLAH"];
        $PENDIDIKAN       = $_POST["PENDIDIKAN"];
        $KUALIFIKASI      = $_POST["KUALIFIKASI"];
        $PENGALAMAN_KERJA = $_POST["PENGALAMAN_KERJA"];
        $STATUS_KERJA     = $_POST["STATUS_KERJA"];
        $TGL_BUTUH        = $_POST["TGL_BUTUH"];
        $ALASAN           = $_POST["ALASAN"];
        $TUGAS_POKOK      = $_POST["TUGAS_POKOK"];
        $KETERANGAN       = $_POST["KETERANGAN"];
        $DIMINTA          = $_POST["DIMINTA"];
        $JABATAN_MINTA    = $_POST["JABATAN_MINTA"];
        $BAGIAN           = $_POST["BAGIAN"];
    }

    $querylog = 
    "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
    values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','PTK','Tambah PTK','User Menambah PTK dengan Kode $KODE_PTK')";
    mysql_query($querylog, $DB1);

    $query = 
    "insert into t_ptk (KODE_PTK,KODE_PERUSAHAAN,KODE_BAGIAN,KODE_DEPARTEMEN,KODE_JABATAN,TANGGAL_PTK,TGL_BUTUH, JUMLAH, TERIMA,SISA,ALASAN,PENDIDIKAN,KUALIFIKASI,PENGALAMAN_KERJA,STATUS_KERJA,KETERANGAN,TUGAS_POKOK, USER_REQ,DIMINTA, JABATAN_MINTA,LOKASI,IP_ADDRESS,PC_NAME,BAGIAN) 
    values ('$KODE_PTK','$KODE_PERUSAHAAN','$KODE_BAGIAN','$KODE_DEPARTEMEN','$KODE_JABATAN','$DATE','$TGL_BUTUH','$JUMLAH','0','$JUMLAH','$ALASAN','$PENDIDIKAN','$KUALIFIKASI','$PENGALAMAN_KERJA','$STATUS_KERJA','$KETERANGAN','$TUGAS_POKOK','$ID_USER1','$DIMINTA','$JABATAN_MINTA','pdf/$KODE_PTK','$IP_ADDRESS','$PC_NAME','$BAGIAN')";
    mysql_query($query, $DB1);

    ?><script>document.location.href='save_laporanpk.php?KODE_PTK=<?php echo $KODE_PTK; ?>';</script><?php
    die(0);
}
?>