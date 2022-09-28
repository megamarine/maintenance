<?php
	require_once("module/model/koneksi/koneksi.php");
	?>
		<option value="">Pilih Grup Manajemen</option>
	<?php
	if(!empty($_POST["KODE_BAGIAN"])) {
		$KODE_BAGIAN = $_POST["KODE_BAGIAN"];
		if ($KODE_BAGIAN == "DIV-0011") {
			?>
			<label for="GROUP_MANAGEMENT">Direksi</label>
	        <select name="GROUP_MANAGEMENT" id="GROUP_MANAGEMENT" required="" class="form-control">
	            <option value="">Pilih Direksi</option>
	            <?php
	            $query = "select distinct(GROUP_MANAGEMENT) as MANAJEMENT from m_bagian";
	            $result = mysql_query($query, $DB1);
	            while ($row = mysql_fetch_array($result)) {
	                ?>
	                <option value="<?php echo $row["MANAJEMENT"]; ?>"<?php if($MANAJEMENT == $row["MANAJEMENT"]) { echo "selected"; } ?>><?php echo $row["NAMA_PERUSAHAAN"]; ?></option>
	                <?php
	            }
	            ?>
	        </select>
			<?php
		}
	}
?>