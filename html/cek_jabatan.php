<?php
	require_once("module/model/koneksi/koneksi.php");
	?>
		<option value="">Pilih Jabatan</option>
	<?php
	if(!empty($_POST["KODE_DEPARTEMEN"])) {
		$KODE_DEPARTEMEN = $_POST["KODE_DEPARTEMEN"];
		$query ="select * from m_jabatan where KODE_DEPARTEMEN = '$KODE_DEPARTEMEN'";
		$results = mysql_query($query, $DB1);
		while ($rowz = mysql_fetch_array($results)) {
			?>
				<option value="<?php echo $rowz["KODE_JABATAN"]; ?>"><?php echo $rowz["NAMA_JABATAN"]; ?></option>
			<?php
		}
	}
?>