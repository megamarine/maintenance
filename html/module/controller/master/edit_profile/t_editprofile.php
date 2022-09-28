<?php
$NAMA_USER  = $_SESSION["LOGINNAMAUS_MT"];
$PASSWORD   = "";
$DINO 	    = date('Y-m-d H:i:s');
$ID_USER1   = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME 	= $_SESSION["PC_NAME_MT"];

$options = [
    'cost' => 12,
];

if(isset($_POST["simpan"]))
{
    $NAMA_USER = $_POST["NAMA_USER"];
    $PASSWORD  = password_hash($_POST['PASSWORD'], PASSWORD_BCRYPT, $options);
    $PASS 	   = $_POST["PASSWORD"];

    InsertData(
    	"t_userlog",
    	"KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
    	"'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Profile','Edit Profile','User Mengedit Profile $PASS'");

    UpdateData("m_user","NAMA_USER = '$NAMA_USER', PASSWORD = '$PASSWORD'","KODE_USER = '$ID_USER1'");

    ?><script>document.location.href='menuutama';</script><?php
    die(0);
}
?>