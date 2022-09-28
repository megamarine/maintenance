<?php
	require_once("module/model/koneksi/koneksi.php");

	if(!empty($_POST["KODE_JABATAN"])) {
		$KODE_JABATAN = $_POST["KODE_JABATAN"];
		if ($KODE_JABATAN == "JAB-0007" or $KODE_JABATAN == "JAB-0009" or $KODE_JABATAN == "JAB-0005") {
			?>
			<div class="form-group">
                    <label for="PASS_APP">Password Persetujuan</label>
                    <input type="password" class="form-control" id="PASS_APP" name="PASS_APP" value="<?php echo $PASS_APP; ?>">
                </div>    
			<?php
		}
	}
?>