<?php
	require_once("module/model/koneksi/koneksi.php");
	?>
		<option value="">Pilih Divisi</option>
	<?php
	if(!empty($_POST["KODE_PERUSAHAAN"])) {
		$KODE_PERUSAHAAN = $_POST["KODE_PERUSAHAAN"];
		$result = GetData1("*","m_bagian","KODE_PERUSAHAAN = '$KODE_PERUSAHAAN' and STATUS = '1' order by NAMA_BAGIAN");
		while ($rowz = $result->fetch(PDO::FETCH_ASSOC)) {
			?>
				<option value="<?php echo $rowz["KODE_BAGIAN"]; ?>"><?php echo $rowz["NAMA_BAGIAN"]; ?></option>
			<?php
		}
	}
?>