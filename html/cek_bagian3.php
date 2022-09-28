<?php
    require_once("module/model/koneksi/koneksi.php");
    
	if(!empty($_POST["KODE_JENIS"])) 
    {
		$KODE_JENIS = $_POST["KODE_JENIS"];
        if ($KODE_JENIS == 2 or $KODE_JENIS == 4) 
        {
            ?>
            <div class="col-md-3">
                    <div class="form-group">
                        <label for="JUMBAR">Jumlah Barang <span class="text-danger">*</span></label><br/>
                        <input type="number" class="form-control" autocomplete="off" value="1" min="1" required="" name="JUMBAR" id="JUMBAR" data-parsley-required>
                    </div>                          
            </div>
            
            <?php
        }
	}
?>