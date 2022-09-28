<?php
    require_once("module/model/koneksi/koneksi.php");
    
	if(!empty($_POST["KODE_TEKNISI"])) {
        $KODE_TEKNISI = $_POST["KODE_TEKNISI"];
        
		if ($KODE_TEKNISI != "") {
            GetQuery("insert into d_perbaikan (KODE_PERBAIKAN,KODE_TEKNISI) values ('$KODE_PERBAIKAN','$KODE_TEKNISI')");
        }
	}
?>