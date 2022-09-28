<?php
$u          = date("Ym");
$DINO       = date('Y-m-d H:i:s');
$ID_USER1   = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME    = gethostbyaddr($IP_ADDRESS);

if(isset($_POST["simpan"]))
{
    $PERIODE   = $_POST["PERIODE"];
    $PERIODE2  = $_POST["PERIODE2"];

    $startdate = strtotime($_POST["PERIODE"]);
    $enddate   = strtotime($_POST["PERIODE2"]);
    
    $datediff  = $enddate - $startdate;
    $countdays = floor($datediff/(60*60*24)+1);

    if($PERIODE2 < $PERIODE)
    {
      ?>
      <script>alert("Format Tanggal Salah!");</script>
      <script>document.location.href='parameter';</script>
      <?php
      die(0);
    }

    $TGL = $PERIODE;
    for($i = 0; $i < $countdays; $i++)
    {
        $result1 = $db1->prepare(
        "insert into nonaktif_jamopr (tanggal, status) values ('$TGL','Tidak Aktif')");
        $result1->execute();

        $date    = new DateTime($TGL);
        $date->add(new DateInterval('P1D')); // P1D means a period of 1 day
        $TGL = $date->format('Y-m-d');
    }
    
    $result1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
                        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Parameter','Non Aktif','Start : $PERIODE, End : $PERIODE2')"); 
	$result1->execute();

    ?>
    <script>alert("Berhasil Disimpan!");</script>
    <script>document.location.href='parameter';</script>
    <?php  
    die(0);
}
?>