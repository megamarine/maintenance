<?php
    require_once("module/model/koneksi/koneksi.php");
    $IP_ADD     = "192.168.";
    $MAC_ADD    = "";
    
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
			<div class="col-md-3">
                <div class="form-group">
                    <label for="IP_ADD">IP Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" required="" id="IP_ADD" name="IP_ADD" value="<?php echo $IP_ADD; ?>" data-parsley-required onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode <= 57">
                </div>                          
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="MAC_ADD">MAC Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" required="" id="MAC_ADD" name="MAC_ADD" value="<?php echo $MAC_ADD; ?>" data-parsley-required>
                </div>                          
            </div>
			<?php
		}
	}
?>