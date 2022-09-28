<?php
    require_once("module/model/koneksi/koneksi.php");
    $IP_ADD     = "192.168.";
    $PEMILIK    = "";
    
	if(!empty($_POST["KODE_BARANG"])) 
    {
		$KODE_BARANG = $_POST["KODE_BARANG"];
        $result = GetData1("b.*,j.NAMA_JENIS",
                           "m_barang b, m_jenisbrg j",
                           "b.KODE_JENIS = j.KODE_JENIS and b.STATUS = 0 and b.KODE_BARANG = '$KODE_BARANG'");
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
        {
            $NAMA_JENIS = $row["NAMA_JENIS"];
        }
		if ($KODE_BARANG == "BRG/201803/00106") 
        {
			?>
            <div class="row">
    			<div class="col-md-3">
                    <div class="form-group">
                        <label for="IP_ADD">IP Address <span class="text-danger">*</span> <span><i style="color: red;font-size: 8px;"><strong>NOTE: JIKA TIDAK TAHU, HUBUNGI IT</strong></i></span></label>
                        <input type="text" class="form-control" required="" id="IP_ADD" name="IP_ADD" value="<?php echo $IP_ADD; ?>" data-parsley-required onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode <= 57">
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="PEMILIK">Pemilik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="PEMILIK" name="PEMILIK" value="<?php echo $PEMILIK; ?>" data-parsley-required>
                    </div>                          
                </div>
            </div>
			<?php
		}
	}
?>