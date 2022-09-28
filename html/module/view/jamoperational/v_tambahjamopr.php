<?php include "module/controller/jamoperational/t_jamopr.php"; 
$TANGGAL = date('Y-m-d');
?>
<script type="text/javascript">
function getKODE_UNIT(val) {
      $.ajax({
      type: "POST",
      url: "cek_unit.php",
      data:'KODE_BARANG='+val,
      success: function(data){
        $("#KODE_UNIT").html(data);
      }
      });
    }
</script>

<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-plus2 fa-lg"></i> Tambah Jam Operational</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="jamoperational"><i class="fa fa-cogs fa-lg"></i> Jam Operational </a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Jam Operational</li>
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
                        <label for="TANGGAL">Tanggal</label>
                        <input type="text" class="form-control" name="TANGGAL" id="datepicker1" autocomplete="off" value="<?php echo $TANGGAL; ?>" />
                    </div>                       
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="KODE_BARANG">Barang <span class="text-danger">*</span></label>
                        <select name="KODE_BARANG" id="KODE_BARANG" onChange="getKODE_UNIT(this.value);" required="" class="form-control" data-parsley-required>
                            <option value="">Pilih Barang</option>
                            <?php
                            $result = GetQuery("select * from m_barang where KODE_JENIS = '2' and STATUS='0' and ITEM_TYPE='MC' order by NAMA_BARANG asc");
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
                        <label for="KODE_UNIT">Unit Barang <span class="text-danger">*</span></label>
                        <select name="KODE_UNIT" id="KODE_UNIT" required="" class="form-control" data-parsley-required>
                            <option value="">Pilih Unit Barang</option>
                        </select>
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="JAM_OPR">Jam Operasional (*Jam) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="JAM_OPR" autocomplete="off" name="JAM_OPR" value="<?php echo $JAM_OPR; ?>" data-parsley-type="number">
                    </div>                          
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KETERANGAN">Keterangan</label>
                        <textarea class="form-control" name="KETERANGAN" id="KETERANGAN" rows="6"><?php echo $KETERANGAN; ?></textarea>
                    </div>                          
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                    <a href="jamoperational" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>
<script>
    $(function(){
        // Find any date inputs and override their functionality
        $('#datepicker1').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>