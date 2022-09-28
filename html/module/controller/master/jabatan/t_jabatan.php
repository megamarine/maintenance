<?php
$KODE_JABATAN = createKode("m_jabatan","KODE_JABATAN","JAB-",4);
$NAMA_JABATAN = "";
$DINO         = date('Y-m-d H:i:s');
$ID_USER1     = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS   = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME      = $_SESSION["PC_NAME_MT"];

if(isset($_GET["KODE_JABATAN"]))
{
    $KODE_JABATAN = $_GET["KODE_JABATAN"];

    $query  = "select * from m_jabatan where KODE_JABATAN = '$KODE_JABATAN'";
    $result = mysql_query($query, $DB1);
    while ($row = mysql_fetch_array($result)) {
        $NAMA_JABATAN = $row["NAMA_JABATAN"];
    }

    if(isset($_POST["simpan"]))
    {
        $NAMA_JABATAN = $_POST["NAMA_JABATAN"];

        $querylog = 
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Jabatan','Edit Jabatan','User Mengedit Jabatan dengan Kode $KODE_JABATAN')";
        mysql_query($querylog, $DB1);

        $query2 = "update m_jabatan set NAMA_JABATAN = '$NAMA_JABATAN' where KODE_JABATAN = '$KODE_JABATAN'";
        mysql_query($query2, $DB1);

        ?><script>document.location.href='jabatan.php';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $NAMA_JABATAN = $_POST["NAMA_JABATAN"];

    $querylog = 
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Jabatan','Tambah Jabatan','User Menambah Jabatan dengan Kode $KODE_JABATAN')";
    mysql_query($querylog, $DB1);

    $query = "insert into m_jabatan (KODE_JABATAN,NAMA_JABATAN,STATUS_JAB) values ('$KODE_JABATAN','$NAMA_JABATAN','Close')";
    mysql_query($query, $DB1);

    ?><script>document.location.href='jabatan.php';</script><?php
    die(0);
}
?>