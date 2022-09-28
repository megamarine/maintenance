<?php include "module/controller/master/teknisi/t_teknisi.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-address-card fa-lg"></i> Master Teknisi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="teknisi"><i class="fas fa-address-card fa-lg"></i> Teknisi </a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Teknisi</li>
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
                        <label for="ID_KARYAWAN">ID Karyawan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="ID_KARYAWAN" name="ID_KARYAWAN" value="<?php echo $ID_KARYAWAN; ?>" data-parsley-required>
                    </div>                          
                </div>   
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="KODE_PERUSAHAAN">Perusahaan <span class="text-danger">*</span></label>
                        <select name="KODE_PERUSAHAAN" id="KODE_PERUSAHAAN" required="" class="form-control" data-parsley-required>
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
                <?php
                if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_JENIS">Departemen <span class="text-danger">*</span></label>
                            <select name="KODE_JENIS" id="KODE_JENIS" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Departemen</option>
                                <?php
                                $result = GetData("*","m_jenisbrg");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_JENIS"]; ?>"<?php if($KODE_JENIS == $row["KODE_JENIS"]) { echo "selected"; } ?>><?php echo $row["NAMA_JENIS"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>  
                    <?php
                }
                ?>  
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="NAMA_TEKNISI">Nama Teknisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="NAMA_TEKNISI" name="NAMA_TEKNISI" value="<?php echo $NAMA_TEKNISI; ?>" data-parsley-required>
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="JABATAN">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="JABATAN" name="JABATAN" value="<?php echo $JABATAN; ?>">
                    </div>                          
                </div> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="HARI_KERJA">Hari Kerja</label>
                        <input type="number" class="form-control" required="" id="HARI_KERJA" name="HARI_KERJA" value="<?php echo $HARI_KERJA; ?>" data-parsley-type="number">
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="JAM_KERJA">Jam Kerja</label>
                        <input type="number" class="form-control" required="" id="JAM_KERJA" name="JAM_KERJA" value="<?php echo $JAM_KERJA; ?>" data-parsley-type="number">
                    </div>                          
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                    <a href="teknisi" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>