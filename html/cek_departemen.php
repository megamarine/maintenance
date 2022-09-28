<?php
	require_once("module/model/koneksi/koneksi.php");
	?>
		<option value="">Pilih Departemen</option>
	<?php
	if(!empty($_POST["KODE_BAGIAN"])) {
		$KODE_BAGIAN = $_POST["KODE_BAGIAN"];
		$results = GetData1("*","m_departemen","KODE_BAGIAN = '$KODE_BAGIAN' and STATUS = '1' order by NAMA_DEPARTEMEN");
		while ($rowz = $results->fetch(PDO::FETCH_ASSOC)) {
			?>
				<option value="<?php echo $rowz["KODE_DEPARTEMEN"]; ?>"><?php echo $rowz["NAMA_DEPARTEMEN"]; ?></option>
			<?php
		}
	}
?>