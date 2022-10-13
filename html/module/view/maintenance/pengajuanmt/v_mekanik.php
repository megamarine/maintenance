<?php 
$start_time = microtime(true);
include "module/controller/maintenance/pengajuanmt/t_pengajuanmt.php";

$result = GetQuery("select b.KODE_JENIS 
                      from t_perbaikan p, 
    	                   m_barang b 
                     where p.KODE_BARANG = b.KODE_BARANG and 
    	                   KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
{
    extract($row);
}
//edit
if (!isset($_GET['edit'])){
    GetQuery(
    "update t_perbaikan 
    set STATUS_READ = 1 
    where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
}

	include "proses/proses_mekanik_new.php";	

?>

<?php echo(number_format(microtime(true) - $start_time, 2)); ?> seconds.