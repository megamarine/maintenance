<?php include "module/controller/master/sparepart/t_sparepart.php";
if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
{
    $KODE_JENIS = 1;
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
{
    $KODE_JENIS = 2;
}
else
{
    $KODE_JENIS = 3;
}
?>
<script>
    function getKODE_BARANG(val) {
      $.ajax({
      type: "POST",
      url: "cek_table.php",
      data:'KODE_BARANG='+val,
      success: function(data){
        $("#TABLE").html(data);
      }
      });
    }
</script>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-cogs fa-lg"></i> Master Spare Part</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="sparepart"><i class="fas fa-cogs fa-lg"></i> Spare Part </a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Spare Part</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post" data-parsley-validate>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="KODE_BARANG">Barang </label>
                        <select name="KODE_BARANG" id="selectize-customselect" class="form-control" onChange="getKODE_BARANG(this.value);">
                            <option value="">Pilih Barang</option>
                            <?php
                            $result = GetQuery("select * from m_barang where KODE_JENIS = '$KODE_JENIS' order by NAMA_BARANG");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KODE_BARANG"]; ?>"<?php if($KODE_BARANG == $row["KODE_BARANG"]) { echo "selected"; } ?>><?php echo $row["NAMA_BARANG"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                          
                </div>  
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="NAMA_PART">Spare Part <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="NAMA_PART" name="NAMA_PART" value="<?php echo $NAMA_PART; ?>" data-parsley-required>
                    </div>                          
                </div>
                <?php
                if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINAKS_MT"] == "Manajer") {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="HARGA_PART">Harga Satuan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" required="" id="HARGA_PART" name="HARGA_PART" value="<?php echo $HARGA_PART; ?>" data-parsley-required>
                        </div>                          
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="STOK_PART">Stok Part <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" required="" id="STOK_PART" name="STOK_PART" value="<?php echo $STOK_PART; ?>" data-parsley-required>
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="STOKMIN_PART">Min. Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" required="" id="STOKMIN_PART" name="STOKMIN_PART" value="<?php echo $STOKMIN_PART; ?>" data-parsley-required>
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="LIFETIME_PART">Umur Spare Part (*Hari) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="LIFETIME_PART" name="LIFETIME_PART" value="<?php echo $LIFETIME_PART; ?>">
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="KODE_SATUAN">Satuan <span class="text-danger">*</span></label>
                        <select name="KODE_SATUAN" id="KODE_SATUAN" class="form-control" required="" data-parsley-required>
                            <option value="">Pilih Satuan</option>
                            <?php
                            $result = GetQuery("select * from m_satuan where STATUS = 0 order by NAMA_SATUAN");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KODE_SATUAN"]; ?>"<?php if($KODE_SATUAN == $row["KODE_SATUAN"]) { echo "selected"; } ?>><?php echo $row["NAMA_SATUAN"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                          
                </div>  
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="KETERANGAN">Keterangan</label><br>
                        <textarea class="form-control" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan"><?php echo $KETERANGAN; ?></textarea>
                    </div>
                </div>                     
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                    <a href="sparepart" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
            <div id="TABLE"></div>
        </form>
    </div>
</div>