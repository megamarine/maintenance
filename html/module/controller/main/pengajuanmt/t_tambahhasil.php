<?php
if(isset($_POST["HASIL"]))
{
    $HASIL = $_POST["HASIL"];

    UpdateData("t_perbaikan","HASIL = '$HASIL'","KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

    ?><script>document.location.href='pengajuanmt';</script><?php
    die(0);
}
?>