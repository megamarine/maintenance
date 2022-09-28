<?php
	require_once("module/model/koneksi/koneksi.php");
	?>
	<?php
	$lokasi = "";
	if(!empty($_POST["KODE_UNIT"])) {
		$KODE_UNIT = $_POST["KODE_UNIT"];
		$result = GetData1("*","m_unit","KODE_UNIT = '$KODE_UNIT'");
		while ($rowz = $result->fetch(PDO::FETCH_ASSOC)) 
		{
			if($rowz["LOKASI"] != '')
			{
				$lokasi = $rowz["LOKASI"];			
			}
		}
		?>
			<div class="col-md-3">
                <div class="form-group">
					<label for="LOKASI">Lokasi Barang <span class="text-danger">*</span></label><br/>
					<input type="text" class="form-control" autocomplete="off" required="" name="LOKASI" id="LOKASI" data-parsley-required value="<?php echo $lokasi; ?>">
				</div>
			</div>
		<?php
	}
?>