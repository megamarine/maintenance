<?php
	require_once("module/model/koneksi/koneksi.php");
	?>
		<option value="">Pilih Teknisi</option>
	<?php
	if(!empty($_POST["KODE_PERUSAHAAN"])) {
		$KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
		$result = GetQuery("select * from m_teknisi where KODE_PERUSAHAAN = '$KODE_PERUSAHAAN' and STS_AKTIF = 0 order by NAMA_TEKNISI");
		while ($rowz = $result->fetch(PDO::FETCH_ASSOC)) {
			?>
				<option value="<?php echo $rowz["KODE_TEKNISI"]; ?>"><?php echo $rowz["NAMA_TEKNISI"] . " - " . $rowz["ID_KARYAWAN"]; ?></option>
			<?php
		}
	}
?>