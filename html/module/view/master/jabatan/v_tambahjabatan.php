<?php include "module/controller/master/jabatan/t_jabatan.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-tree5"></i> Master Jabatan</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="jabatan.php"><i class="ico-tree5"></i> Jabatan</a></li>
            <li class="active"><i class="ico-plus2"></i> Tambah Jabatan</li>
        </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="NAMA_JABATAN">Nama Jabatan</label>
                        <input type="text" class="form-control" required="" id="NAMA_JABATAN" name="NAMA_JABATAN" value="<?php echo $NAMA_JABATAN; ?>">
                    </div>                          
                </div>                                 
            </div>   
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp&nbsp&nbsp
                    <a href="jabatan.php" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>