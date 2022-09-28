<?php include "module/controller/hasilproduksi/t_hasilproduksi.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-balance-scale fa-lg"></i> Hasil Produksi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="hasilproduksi"><i class="fas fa-balance-scale fa-lg"></i> Hasil Produksi </a></li>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BAGIAN">Bagian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="BAGIAN" name="BAGIAN" value="<?php echo $BAGIAN; ?>" data-parsley-required>
                    </div>                          
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="HASIL">Hasil Per Bagian</label><br>
                        <input type="text" class="form-control" required="" id="HASIL" name="HASIL" value="<?php echo $HASIL; ?>" data-parsley-required>
                    </div>
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="TOTAL_PROD">Total Produksi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="TOTAL_PROD" name="TOTAL_PROD" value="<?php echo $BAGIAN; ?>" data-parsley-required>
                    </div>                          
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="DEFECT">Defect</label><br>
                        <input type="text" class="form-control" required="" id="DEFECT" name="DEFECT" value="<?php echo $DEFECT; ?>" data-parsley-required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="LISTRIK">Listrik</label><br>
                        <input type="text" class="form-control" required="" id="LISTRIK" name="LISTRIK" value="<?php echo $LISTRIK; ?>" data-parsley-required>
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
        </form>
    </div>
</div>