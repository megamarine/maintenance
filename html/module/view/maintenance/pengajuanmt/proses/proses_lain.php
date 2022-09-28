<?php include "module/controller/maintenance/pengajuanmt/t_pengajuanmt.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-wrench fa-lg"></i> Permintaan Perbaikan Barang</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="pengajuanmt"><i class="fa fa-wrench fa-lg"></i> Permintaan Perbaikan Barang</a></li>
                <li class="active"><i class="ico-plus2"></i> Proses Permintaan</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" id="form" action="" method="post" data-parsley-validate>
            <h3>Info</h3>
            <hr>
            <div class="row">
                <div class="col-md-4">
                <div class="form-group">
                    <label for="KODE_PERUSAHAAN">Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" readonly="" id="NAMA_PERUSAHAAN" name="NAMA_PERUSAHAAN" value="<?php echo $NAMA_PERUSAHAAN; ?>">
                </div>                          
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="KODE_BAGIAN">Divisi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" readonly="" id="NAMA_BAGIAN" name="NAMA_BAGIAN" value="<?php echo $NAMA_BAGIAN; ?>">
                </div>                          
            </div>   
            <div class="col-md-4">
                <div class="form-group">
                    <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" readonly="" id="NAMA_DEPARTEMEN" name="NAMA_DEPARTEMEN" value="<?php echo $NAMA_DEPARTEMEN; ?>">
                </div>                          
            </div>                           
            </div>
            <h3>Spefisikasi Kerusakan</h3>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="NAMA_BARANG">Barang </label>
                        <input type="text" class="form-control" readonly="" id="NAMA_BARANG" name="NAMA_BARANG" value="<?php echo $NAMA_BARANG; ?>">
                    </div> 
                </div>
                <?php
                if ($KODE_BARANG == "BRG/201803/00106") {
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="IP_ADD">IP Address </label>
                            <input type="text" class="form-control" readonly="" id="IP_ADD" name="IP_ADD" value="<?php echo $IP_ADD; ?>">
                        </div>   
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PEMILIK">Pemilik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" readonly="" id="PEMILIK" name="PEMILIK" value="<?php echo $PEMILIK; ?>">
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div id="DATA"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KERUSAKAN">Kerusakan</label>
                        <textarea class="form-control" readonly="" name="KERUSAKAN" id="KERUSAKAN" rows="6" placeholder="Detail Kerusakan"><?php echo $KERUSAKAN; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KETERANGAN">Keterangan</label>
                        <textarea class="form-control" readonly="" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan Lain"><?php echo $KETERANGAN; ?></textarea>
                    </div>                          
                </div>
            </div>
            <h3>Hasil Perbaikan</h3>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="USER_MT">User yang memperbaiki / Teknisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="USER_MT" name="USER_MT" value="<?php echo $USER_MT; ?>" data-parsley-required>
                    </div>                         
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="BAGIAN">Bagian <span class="text-danger">*</span></label>
                        <select name="BAGIAN" id="BAGIAN" class="form-control" required="" data-parsley-required>
                            <option value="">Pilih Bagian</option>
                            <?php
                            $result = GetQuery("select BAGIAN_GA from param where BAGIAN_GA != '' order by BAGIAN_GA");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["BAGIAN_GA"]; ?>"<?php if($BAGIAN == $row["BAGIAN_GA"]) { echo "selected"; } ?>><?php echo $row["BAGIAN_GA"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="SOLUSI">Hasil Perbaikan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="SOLUSI" id="SOLUSI" rows="6" required placeholder="Detail Hasil" data-parsley-required><?php echo $SOLUSI; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="SARAN">Saran</label>
                        <textarea class="form-control" name="SARAN" id="SARAN" rows="6" placeholder="Input Saran"><?php echo $SARAN; ?></textarea>
                    </div>                          
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan2" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                    <a href="pengajuanmt" type="button" class="btn btn-danger"><i class="fa fa-times fa-lg"></i> Batal</a>
                </div>                    
            </div>        
        </form>
    </div>
</div>
<script type="text/javascript">
    $('form').preventDoubleSubmission();
</script>