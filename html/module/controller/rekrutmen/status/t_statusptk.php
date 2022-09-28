<?php
$TANGGAL_MASUK = date("Y-m-d");
$JUMLAH        = "";
$DINO          = date('Y-m-d H:i:s');
$ID_USER1      = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS    = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME       = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_PTK"]))
{
    $KODE_PTK        = $_GET["KODE_PTK"];
    $KODE_DEPARTEMEN = $_GET["KODE_DEPARTEMEN"];
    $KODE_PERUSAHAAN = $_GET["KODE_PERUSAHAAN"];

    $query = 
    "select JUMLAH,TERIMA,SISA,p.NAMA_PERUSAHAAN,d.NAMA_DEPARTEMEN 
    from t_ptk t, m_perusahaan p, m_departemen d 
    where t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and KODE_PTK = '$KODE_PTK'";

    $result = mysql_query($query, $DB1);
    while ($row = mysql_fetch_array($result)) {
        $JUMLAH1         = $row["JUMLAH"]; // 25
        $TERIMA          = $row["TERIMA"]; // 0
        $SISA            = $row["SISA"]; // 25
        $NAMA_PERUSAHAAN = $row["NAMA_PERUSAHAAN"];
        $NAMA_DEPARTEMEN = $row["NAMA_DEPARTEMEN"];
    }

    if(isset($_POST["simpan"]))
    {
        $TANGGAL_MASUK = $_POST["TANGGAL_MASUK"];
        $JUMLAH3       = $_POST["JUMLAH"];
        $JUMLAH        = $TERIMA + $JUMLAH3; // 0 + 3 = 3
        $COMBINE       = $JUMLAH1 - $JUMLAH; // 25 - 3

        $querylog = 
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL_MASUK,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Status PTK','Tambah Status','User Menambah Status PTK dengan Kode $KODE_PTK')";
        mysql_query($querylog, $DB1);

        $query2 = "update t_ptk set TERIMA = '$JUMLAH', SISA = '$COMBINE' where KODE_PTK = '$KODE_PTK'";
        mysql_query($query2, $DB1);

        $query3 = 
        "insert into t_masuk (KODE_PTK,KODE_DEPARTEMEN,TANGGAL_MASUK,JUMLAH,KODE_PERUSAHAAN,KEKURANGAN) 
        values ('$KODE_PTK','$KODE_DEPARTEMEN','$TANGGAL_MASUK','$JUMLAH3','$KODE_PERUSAHAAN','$COMBINE')";
        mysql_query($query3, $DB1);

        ?><script>document.location.href='statusptk.php?KODE_PTK=<?php echo $KODE_PTK; ?>&KODE_DEPARTEMEN=<?php echo $KODE_DEPARTEMEN; ?>&KODE_PERUSAHAAN=<?php echo $KODE_PERUSAHAAN; ?>';</script><?php
        die(0);
    }
}
?>