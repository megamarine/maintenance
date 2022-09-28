<?php include "module/controller/master/bagian/t_bagian.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-cube4"></i> Master Divisi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="bagian"><i class="ico-cube4"></i> Divisi</a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Divisi</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KODE_PERUSAHAAN">Perusahaan</label>
                        <select name="KODE_PERUSAHAAN" id="KODE_PERUSAHAAN" required="" class="form-control">
                            <option value="">Pilih Perusahaan</option>
                            <?php
                            $result = GetData("*","m_perusahaan");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KODE_PERUSAHAAN"]; ?>"<?php if($KODE_PERUSAHAAN == $row["KODE_PERUSAHAAN"]) { echo "selected"; } ?>><?php echo $row["NAMA_PERUSAHAAN"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="NAMA_BAGIAN">Nama Divisi</label>
                        <input type="text" class="form-control" required="" id="NAMA_BAGIAN" name="NAMA_BAGIAN" value="<?php echo $NAMA_BAGIAN; ?>">
                    </div>                          
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="GROUP_MANAGEMENT">Grup Manajemen</label>
                        <input type="text" class="form-control" required="" id="GROUP_MANAGEMENT" name="GROUP_MANAGEMENT" value="<?php echo $GROUP_MANAGEMENT; ?>">
                    </div>                          
                </div>                              
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp&nbsp&nbsp
                    <a href="bagian" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>