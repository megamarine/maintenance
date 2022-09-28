<?php include "module/controller/proyekbaru/t_pengajuanproyek.php";
if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
    $KODE_JENIS = 2;
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
    $KODE_JENIS = 1;
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0094") {
    $KODE_JENIS = 3;
}
?>
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
                <li class="active"><i class="ico-plus2"></i> Tambah Proyek</li>
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
                        <select name="KODE_PERUSAHAAN" id="KODE_PERUSAHAAN" required="" class="form-control" onChange="getKODE_PERUSAHAAN(this.value);" data-parsley-required>
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
                        <label for="LOKASI">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="LOKASI" name="LOKASI" value="<?php echo $LOKASI; ?>" data-parsley-required>
                    </div>                          
                </div>   
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KODE_BARANG">Barang <span class="text-danger">*</span></label>
                        <select name="KODE_BARANG" id="selectize-customselect" autofocus="" required="" class="form-control" data-parsley-required>
                            <option value="">Pilih Barang</option>
                            <?php
                            $result = GetData1("b.*,j.NAMA_JENIS","m_barang b, m_jenisbrg j","b.KODE_JENIS = j.KODE_JENIS and b.STATUS = 0 and b.KODE_JENIS = '$KODE_JENIS' order by b.NAMA_BARANG");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <option value="<?php echo $row["KODE_BARANG"]; ?>" <?php if($KODE_BARANG == $row["KODE_BARANG"]) { echo "selected"; } ?>><?php echo $row["NAMA_BARANG"]; ?></option>
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
                        <label for="PETUGAS">Petugas <span class="text-danger">*</span></label>
                        <textarea class="form-control" required="" name="PETUGAS" id="PETUGAS" rows="6" placeholder="Petugas yang melaksanakan" data-parsley-required><?php echo $PETUGAS; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KETERANGAN">Perihal</label>
                        <textarea class="form-control" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan Lain"><?php echo $KETERANGAN; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="TGL_MULAI">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="TGL_MULAI" name="TGL_MULAI" value="<?php echo $TGL_MULAI; ?>" data-parsley-required>
                    </div>                          
                </div>
            </div>
            <?php
            if (isset($_GET["KODE_PROYEK"])) {
                ?>
                <div class="row">
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
                        <button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>&nbsp&nbsp&nbsp
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