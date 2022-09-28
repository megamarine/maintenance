<?php
    require_once("module/model/koneksi/koneksi.php");
    
	if(!empty($_POST["KODE_JENIS"])) {
		$KODE_JENIS = $_POST["KODE_JENIS"];
        if ($KODE_JENIS == 2) {
            ?>
            <div class="col-md-3">
                    <div class="form-group">
                        <label for="JUMBAR">Jumlah Barang <span class="text-danger">*</span></label><br/>
                        <input type="number" class="form-control" min="1" required="" name="JUMBAR" id="JUMBAR" data-parsley-required>
                    </div>                          
            </div>
            <div class="col-md-3">
                    <div class="form-group">
                        <label for="LOKASI">Lokasi Alat / Mesin <span class="text-danger">*</span></label><br/>
                        <input type="text" class="form-control" min="1" required="" name="LOKASI" id="LOKASI" data-parsley-required>
                    </div>                          
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="vehicle1"> Kerusakan menyebabkan mati total? <span class="text-danger">*</span></label><br>
                    <input type="radio" id="STATUS_DOWNTIME" name="STATUS_DOWNTIME" value="1"> Ya  (Downtime) <br/>
                    <input type="radio" id="STATUS_DOWNTIME" name="STATUS_DOWNTIME" value="0"> Tidak (Minor Stop)
                </div>
            </div>
            <?php
        }
	}
?>