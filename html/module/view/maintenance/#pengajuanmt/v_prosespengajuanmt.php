<?php include "module/controller/maintenance/pengajuanmt/t_pengajuanmt.php";

$result = GetQuery("
	select b.KODE_JENIS,
		   p.KODE_BARANG 
      from t_perbaikan p, 
    	   m_barang b 
     where p.KODE_BARANG = b.KODE_BARANG and 
    	   KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
}

GetQuery(
    "update t_perbaikan 
    set STATUS_READ = 1 
    where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

if ($KODE_JENIS == 1) 
{
    include "proses/proses_it.php";
}
else if ($KODE_JENIS == 2)
{
	include "proses/proses_mekanik.php";	
} 
else 
{
    include "proses/proses_lain.php";
}
?>