<?php include "module/controller/proyekbaru/t_pengajuanproyek.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-pallet fa-lg"></i> Proyek Baru </h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="pengajuanproyek"><i class="fas fa-pallet fa-lg"></i> Proyek Baru</a></li>
                <li class="active"><i class="ico-plus2"></i> Proses Proyek</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" id="form" action="" method="post" data-parsley-validate>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KODE_PERUSAHAAN">Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" readonly="" id="KODE_PERUSAHAAN" name="KODE_PERUSAHAAN" value="<?php echo $NAMA_PERUSAHAAN; ?>">
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="LOKASI">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" readonly="" id="LOKASI" name="LOKASI" value="<?php echo $LOKASI; ?>" data-parsley-required>
                    </div>                          
                </div>   
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KODE_BARANG">Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" readonly="" id="KODE_BARANG" name="KODE_BARANG" value="<?php echo $NAMA_BARANG; ?>">
                    </div>                          
                </div>                       
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="PETUGAS">Petugas <span class="text-danger">*</span></label>
                        <textarea class="form-control" readonly="" name="PETUGAS" id="PETUGAS" rows="6" placeholder="Petugas yang melaksanakan" data-parsley-required><?php echo $PETUGAS; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KETERANGAN">Perihal</label>
                        <textarea class="form-control" readonly="" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan Lain"><?php echo $KETERANGAN; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="TGL_MULAI">Tanggal Mulai Proyek<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" readonly="" id="TGL_MULAI" name="TGL_MULAI" value="<?php echo $TGL_MULAI; ?>" data-parsley-required>
                    </div>                          
                </div>
            </div>
            <?php
            if (isset($_GET["KODE_PROYEK"])) {
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="TGL_SELESAI">Tanggal Selesai Proyek<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" required="" id="TGL_SELESAI" name="TGL_SELESAI" value="<?php echo $TGL_SELESAI; ?>" data-parsley-required>
                        </div>                          
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="KETERANGAN_SELESAI">Keterangan Penyelesaian Proyek</label>
                            <textarea class="form-control" name="KETERANGAN_SELESAI" id="KETERANGAN_SELESAI" rows="6" placeholder="Hambatan / masalah selama pengerjaan proyek"><?php echo $KETERANGAN_SELESAI; ?></textarea>
                        </div>   
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="HAMBATAN">Hambatan</label>
                            <textarea class="form-control" name="HAMBATAN" id="HAMBATAN" rows="6" placeholder="Hambatan / masalah selama pengerjaan proyek"><?php echo $HAMBATAN; ?></textarea>
                        </div>   
                    </div>
                </div>
                <?php
            }
            ?>
            <br><br>
            <?php
            if ($STATUS == 0) {
                ?>
                <div class="row">
                    <div class="col-lg-12" align="center">
                        <button type="submit" name="simpan2" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>&nbsp&nbsp&nbsp
                        <a href="pengajuanmt" type="button" class="btn btn-danger"><i class="fa fa-times fa-lg"></i> Batal</a>
                    </div>                    
                </div>
                <?php
            }
            ?>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('form').preventDoubleSubmission();
</script>