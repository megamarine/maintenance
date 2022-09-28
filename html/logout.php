<?php
require_once ("module/model/koneksi/koneksi.php");
$DINO 		= date('Y-m-d H:i:s');
$ID_USER 	= $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME 	= $_SESSION["PC_NAME_MT"];

InsertData(
	"t_userlog",
	"KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
	"'$ID_USER','$IP_ADDRESS','$PC_NAME','$DINO','Logout','Keluar','Akses " . $_SESSION["LOGINAKS_MT"] . "'");

UpdateData("m_user","STS_LGN = '0'","KODE_USER = '$ID_USER'");

unset($_SESSION["LOGINIDUS_MT"]);
unset($_SESSION["PC_NAME_MT"]);
unset($_SESSION["IP_ADDRESS_MT"]);
unset($_SESSION["LOGINIDUS_MT"]);
unset($_SESSION["LOGINNAMAUS_MT"]);
unset($_SESSION["LOGINDEP_MT"]);
unset($_SESSION["LOGINAKS_MT"]);
unset($_SESSION["LOGINBAG_MT"]);
unset($_SESSION["LOGINPER_MT"]);
unset($_SESSION["LOGINGRP_MT"]);
unset($_SESSION["LOGINMAIL_MT"]);
unset($_SESSION["LOGINNMBAG_MT"]);
?><script>alert('Anda telah logout');</script><?php
?><script>document.location.href='index';</script><?php
?>