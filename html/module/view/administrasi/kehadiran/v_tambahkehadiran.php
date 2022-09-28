<?php include "module/controller/administrasi/kehadiran/t_kehadiran.php"; ?>
<script>
    function getKODE_PERUSAHAAN(val) {
      $.ajax({
      type: "POST",
      url: "cek_teknisi.php",
      data:'KODE_PERUSAHAAN='+val,
      success: function(data){
        $("#KODE_TEKNISI").html(data);
      }
      });
    }
</script>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas  fa-user-circle fa-lg"></i> Kehadiran Teknisi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="kehadiran"><i class="fas  fa-user-circle fa-lg"></i> Kehadiran Teknisi </a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Kehadiran</li>
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
                <?php
                if (isset($_GET["KODE_HADIR"])) {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_TEKNISI">Teknisi <span class="text-danger">*</span></label>
                            <select name="KODE_TEKNISI" id="KODE_TEKNISI" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Teknisi</option>
                                <?php
                                $result = GetQuery("select * from m_teknisi where KODE_PERUSAHAAN = '$KODE_PERUSAHAAN'");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_TEKNISI"]; ?>"<?php if($KODE_TEKNISI == $row["KODE_TEKNISI"]) { echo "selected"; } ?>><?php echo $row["NAMA_TEKNISI"] . " - " . $row["ID_KARYAWAN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                         
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_TEKNISI">Teknisi <span class="text-danger">*</span></label>
                            <select name="KODE_TEKNISI" id="KODE_TEKNISI" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Teknisi</option>
                            </select>
                        </div>                          
                    </div> 
                    <?php
                }
                ?>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="TANGGAL">Tanggal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required id="datepicker1" name="TANGGAL" placeholder="Select a date" value="<?php echo $TANGGAL; ?>" data-parsley-required/>
                    </div>                          
                </div> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ABSENSI">Absensi <span class="text-danger">*</span></label>
                        <select name="ABSENSI" id="ABSENSI" required="" class="form-control" data-parsley-required>
                            <option value="">Pilih Absensi</option>
                            <?php
                            $result = GetQuery("select KEHADIRAN from param where KEHADIRAN != '' order by KEHADIRAN");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KEHADIRAN"]; ?>"<?php if($ABSENSI == $row["KEHADIRAN"]) { echo "selected"; } ?>><?php echo $row["KEHADIRAN"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                         
                </div>
                <div class="col-md-3">
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
                    <a href="teknisi" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>