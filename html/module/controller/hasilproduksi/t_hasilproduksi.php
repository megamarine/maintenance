<?php
$DATE           = date("Ym");
$ID_HPROD       = createKode("t_hprod","ID_HPROD","HPRD/$DATE/",4);
$TANGGAL_HPROD  = date("Y-m-d");
$BAGIAN         = "";
$HASIL          = "";
$TOTAL_PROD     = "";
$DEFECT         = "";
$LISTRIK        = "";
$DINO           = date('Y-m-d H:i:s');
$ID_USER1       = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS     = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME        = $_SESSION["PC_NAME_MT"];

if(isset($_GET["ID_HPROD"]))
{
    $ID_HPROD = $_GET["ID_HPROD"];
    $result   = GetQuery("select * from t_hprod where ID_HPROD = '$ID_HPROD'");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $BAGIAN     = $row["BAGIAN"];
        $HASIL      = $row["HASIL"];
        $TOTAL_PROD = $row["TOTAL_PROD"];
        $DEFECT     = $row["DEFECT"];
        $LISTRIK    = $row["LISTRIK"];
    }

    if(isset($_POST["simpan"]))
    {
        $BAGIAN     = $_POST["BAGIAN"];
        $HASIL      = $_POST["HASIL"];
        $TOTAL_PROD = $_POST["TOTAL_PROD"];
        $DEFECT     = $_POST["DEFECT"];
        $LISTRIK    = $_POST["LISTRIK"];

        InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Hasil Produksi','Edit Hasil Produksi','User Mengedit Hasil Produksi dengan Kode $ID_HPROD'");

        GetQuery(
            "update t_hprod set BAGIAN = '$BAGIAN', HASIL = '$HASIL', TOTAL_PROD = '$TOTAL_PROD', DEFECT = '$DEFECT', LISTRIK = '$LISTRIK' where ID_HPROD = '$ID_HPROD'");

        ?><script>document.location.href='hasilproduksi';</script><?php
        die(0);
    }
}

if(isset($_POST["simpan"]))
{
    $BAGIAN     = $_POST["BAGIAN"];
    $HASIL      = $_POST["HASIL"];
    $TOTAL_PROD = $_POST["TOTAL_PROD"];
    $DEFECT     = $_POST["DEFECT"];
    $LISTRIK    = $_POST["LISTRIK"];

    InsertData(
        "t_userlog",
        "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
        "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Hasil Produksi','Tambah Hasil Produksi','User Menambah Hasil Produksi dengan Kode $ID_HPROD'");

    GetQuery(
        "insert into t_hprod (ID_HPROD,TANGGAL_HPROD,BAGIAN,HASIL,TOTAL_PROD,DEFECT,LISTRIK) 
        values ('$ID_HPROD','$TANGGAL_HPROD','$BAGIAN','$HASIL','$TOTAL_PROD','$DEFECT','$LISTRIK')");

    ?><script>document.location.href='hasilproduksi';</script><?php
    die(0);
}
?>