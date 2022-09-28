<?php
	require_once("module/model/koneksi/koneksi.php");
	if(!empty($_POST["HASIL"])) 
	{
		$postID = $_POST["postID"];
		$HASIL  = $_POST["HASIL"];

		UpdateData("t_perbaikan","HASIL = '$HASIL'","KODE_PERBAIKAN = '$postID'");
	}
?>