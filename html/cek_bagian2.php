<?php
    require_once("module/model/koneksi/koneksi.php");
    
	if(!empty($_POST["KODE_JENIS"])) 
    {
		$KODE_JENIS = $_POST["KODE_JENIS"];
        if ($KODE_JENIS == 2) 
        {
            ?>
            <!-- <div class="col-md-3">
                <div class="form-group">
                    <label for="BAGIAN">Bagian <span class="text-danger">*</span></label>
                    <select name="BAGIAN" id="BAGIAN" required="" class="form-control" data-parsley-required>
                        <option value="">Pilih Bagian</option>
                        <?php
                        $result = GetQuery("select BAGIAN from param where BAGIAN != ''");
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                        {
                        ?>
                            <option value="<?php echo $row["BAGIAN"]; ?>"><?php echo $row["BAGIAN"]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>                          
            </div> -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="vehicle1"> Kerusakan menyebabkan mati total? <span class="text-danger">*</span></label><br>
                    <input type="radio" id="STATUS_DOWNTIME" name="STATUS_DOWNTIME" onChange="getSTAT_DOWN(this.value)" value="YA"> Ya  (Downtime) <br/>
                    <input type="radio" id="STATUS_DOWNTIME" name="STATUS_DOWNTIME" onChange="getSTAT_DOWN(this.value)" value="TIDAK" checked> Tidak (Minor Stop)
                </div>
            </div>
            <?php
        }
	}
?>