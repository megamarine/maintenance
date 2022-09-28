<?php
	require_once("module/model/koneksi/koneksi.php");
	
	?>
		<option value="">Pilih Barang</option>
	<?php
	if(!empty($_POST["KODE_JENIS"])) 
	{
        $KODE_JENIS  = $_POST["KODE_JENIS"];
		$result 	 = GetQuery("select * from m_barang where KODE_JENIS = '$KODE_JENIS' and STATUS='0' order by NAMA_BARANG");
		while ($rowz = $result->fetch(PDO::FETCH_ASSOC)) 
		{
			?>
				<option value="<?php echo $rowz["KODE_BARANG"]; ?>"><?php echo $rowz["NAMA_BARANG"]; ?></option>
			<?php
		}
	}
?>