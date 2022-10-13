<?php include "module/controller/maintenance/pengajuanmt/t_pengajuanmt_new.php"; ?>
<script src="/ass/bootstrap-input-spinner.js"></script>
<script>
    $("input[type='number']").inputSpinner()
</script>
<script type="text/javascript">
    function getKODE_PERUSAHAAN(val) {
      $.ajax({
      type: "POST",
      url: "cek_bagian.php",
      data:'KODE_PERUSAHAAN='+val,
      success: function(data){
        $("#KODE_BAGIAN").html(data);
      }
      });
    }
    function getKODE_BAGIAN(val) {
      $.ajax({
      type: "POST",
      url: "cek_departemen.php",
      data:'KODE_BAGIAN='+val,
      success: function(data){
        $("#KODE_DEPARTEMEN").html(data);
      }
      });
    }
    function getKODE_BARANG(val) {
      $.ajax({
      type: "POST",
      url: "cek_barang.php",
      data:'KODE_BARANG='+val,
      success: function(data){
        $("#DATA").html(data);
      }
      });
    }
    function getKODE_JENIS(val) {
      $.ajax({
      type: "POST",
      url: "cek_jenis.php",
      data:'KODE_JENIS=2',
      success: function(data){
        $('#KODE_BARANG').html(data);
      }
      });
    }
    function getKODE_JENIS2(val) {
      $.ajax({
      type: "POST",
      url: "cek_bagian2.php",
      data:'KODE_JENIS=2',
      success: function(data){
        $("#BAGIAN").html(data);
      }
      });
    }
    function getKODE_JENIS3(val) {
      $.ajax({
      type: "POST",
      url: "cek_bagian3.php",
      data:'KODE_JENIS=2',
      success: function(data){
        $("#JUMBAR").html(data);
      }
      });
    }

    function getKODE_UNIT(val) {
      $.ajax({
      type: "POST",
      url: "cek_unit.php",
      data:'KODE_BARANG='+val,
      success: function(data){
        $('#KODE_UNIT').html(data);
      }
      });
    }

    function getSTAT_DOWN(val) {
      $.ajax({
      type: "POST",
      url: "cek_down.php",
      data:'STATUS_DOWNTIME='+val,
      success: function(data){
        $("#STATDOWN").html(data);
      }
      });
    }

    function getLOKASI(val) {
      $.ajax({
      type: "POST",
      url: "cek_lokasi.php",
      data:'KODE_UNIT='+val,
      success: function(data){
        $("#LOKASI").html(data);
      }
      });
    }

    $("input[type='number']").inputSpinner()

</script>
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
                <li class="active"><i class="ico-plus2"></i> Tambah Permintaan</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form"  method="POST" data-parsley-validate>
            <h3>Info</h3>
            <hr>
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
                <?php
                if (isset($_GET["KODE_PERBAIKAN"])) 
                {
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="KODE_BAGIAN">Divisi <span class="text-danger">*</span></label>
                            <select name="KODE_BAGIAN" id="KODE_BAGIAN" required="" class="form-control" onChange="getKODE_BAGIAN(this.value);" data-parsley-required>
                                <option value="">Pilih Divisi</option>
                                <?php
                                $result = GetQuery("select * from m_bagian where KODE_PERUSAHAAN = '$KODE_PERUSAHAAN'  and STATUS = '1' order by NAMA_BAGIAN");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_BAGIAN"]; ?>"<?php if($KODE_BAGIAN == $row["KODE_BAGIAN"]) { echo "selected"; } ?>><?php echo $row["NAMA_BAGIAN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>   
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                            <select name="KODE_DEPARTEMEN" id="KODE_DEPARTEMEN" required="" class="form-control" onChange="getKODE_DEPARTEMEN(this.value);" data-parsley-required>
                                <option value="">Pilih Departemen</option>
                                <?php
                                $result = GetQuery("select * from m_departemen where KODE_BAGIAN = '$KODE_BAGIAN' and STATUS = '1' order by NAMA_DEPARTEMEN");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_DEPARTEMEN"]; ?>"<?php if($KODE_DEPARTEMEN == $row["KODE_DEPARTEMEN"]) { echo "selected"; } ?>><?php echo $row["NAMA_DEPARTEMEN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>  
                    <?php
                } 
                else 
                {
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="KODE_BAGIAN">Divisi <span class="text-danger">*</span></label>
                            <select name="KODE_BAGIAN" id="KODE_BAGIAN" required="" class="form-control" onChange="getKODE_BAGIAN(this.value);" data-parsley-required>
                                <option value="">Pilih Divisi</option>
                            </select>
                        </div>                          
                    </div>   
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                            <select name="KODE_DEPARTEMEN" id="KODE_DEPARTEMEN" required="" class="form-control" onChange="getKODE_DEPARTEMEN(this.value);" data-parsley-required>
                                <option value="">Pilih Departemen</option>
                            </select>
                        </div>                          
                    </div>  
                    <?php
                }
                ?>                            
            </div>
            <h3>Spefisikasi Kerusakan</h3>
            <hr>
            <?php
/////////////////////////////////////////////////EDIT PENGAJUAN
            if (isset($_GET["KODE_PERBAIKAN"])) 
            {
                if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0011") ///////////DEPT = MEKANIK / CIVIL ENG
                {
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tanggal Pengajuan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" readonly id="datepicker" name="TGL_START" placeholder="Select a date" value="<?php echo $TGL_START; ?>" data-parsley-required/>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_JENIS">Tujuan Perbaikan <span class="text-danger">*</span></label>
                            <select name="KODE_JENIS" id="KODE_JENIS" required="" class="form-control" onChange="getKODE_JENIS(this.value);getKODE_JENIS2(this.value);getKODE_JENIS3(this.value);" data-parsley-required>
                                <option value="">Pilih Tujuan</option>
                                 <?php
                                $result = GetQuery("select * from m_jenisbrg where KODE_JENIS = 2 order by NAMA_JENIS");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_JENIS"]; ?>"<?php if($KODE_JENIS == $row["KODE_JENIS"]) { echo "selected"; } ?>><?php echo $row["NAMA_JENIS"]; ?></option>
                                    <?php
                                }
                                ?> 
                            </select>
                        </div>                          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="LAYANAN">Jenis Layanan <span class="text-danger">*</span></label>
                            <select name="LAYANAN" id="LAYANAN" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Layanan</option>
                                <?php
                                $result = GetQuery("select LAYANAN from param where LAYANAN != ''");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?php echo $row["LAYANAN"]; ?>"<?php if($LAYANAN == $row["LAYANAN"]) { echo "selected"; } ?>><?php echo $row["LAYANAN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>
                    <!-- <div id="DATA"></div> -->
                    <?php
                    if ($KODE_BARANG == "BRG/201803/00106") 
                    {
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="IP_ADD">IP Address <span class="text-danger">*</span> <span><i style="color: red;font-size: 10px;"><strong>NOTE: JIKA TIDAK TAHU, HUBUNGI IT</strong></i></span></label>
                                <input type="text" class="form-control" required="" id="IP_ADD" name="IP_ADD" value="<?php echo $IP_ADD; ?>" data-parsley-required onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode <= 57">
                            </div>                          
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="PEMILIK">Pemilik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" id="PEMILIK" name="PEMILIK" value="<?php echo $PEMILIK; ?>" data-parsley-required>
                            </div>                          
                        </div>
                        <?php
                    }
                    ?>
                    <div id="BAGIAN">
                        <?php
                        if ($KODE_JENIS == 2) {
                            ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle1"> Kerusakan menyebabkan mati total? <span class="text-danger">*</span></label><br>
                                    <input type="radio" id="STATUS_DOWNTIME" name="STATUS_DOWNTIME" onChange="getSTAT_DOWN(this.value)" value="YA" <?php if($STATUS_DOWNTIME == 'YA'){ echo "checked"; } ?> > Ya  (Downtime) <br/>
                                    <input type="radio" id="STATUS_DOWNTIME" name="STATUS_DOWNTIME" onChange="getSTAT_DOWN(this.value)" value="TIDAK" <?php if($STATUS_DOWNTIME == 'TIDAK'){ echo "checked"; } ?> > Tidak (Minor Stop)
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="JUMBAR">Jumlah Barang <span class="text-danger">*</span></label><br/>
                                    <input type="number" class="form-control" autocomplete="off" value="<?php if(isset($JUMBAR)){ echo $JUMBAR; } else{ echo 1; } ?>" min="1" required="" name="JUMBAR" id="JUMBAR" data-parsley-required>
                                </div>                          
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            } 
/////////////////////////////////////////////////////////////////////////////////////PENGAJUAN BARU
            else
            { 
                if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0011") ///////////DEPT = MEKANIK / CIVIL ENG
                {
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tanggal Kerusakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" required id="datepicker3" name="TGL_START" placeholder="Select a date" value="<?php echo $TGL_START; ?>" data-parsley-required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jam Kerusakan <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" id="time-picker" name="JAM_START"  placeholder="Select a time" />
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_JENIS">Tujuan Perbaikan <span class="text-danger">*</span></label>
                            <select name="KODE_JENIS" id="KODE_JENIS" required="" class="form-control" onChange="getKODE_JENIS(this.value);getKODE_JENIS2(this.value);getKODE_JENIS3(this.value);" data-parsley-required>
                                <option value="">Pilih Tujuan</option>
                                <?php
                                $result = GetQuery("select * from m_jenisbrg where KODE_JENIS = 2 order by NAMA_JENIS");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_JENIS"]; ?>"<?php if($KODE_JENIS == $row["KODE_JENIS"]) { echo "selected"; } ?>><?php echo $row["NAMA_JENIS"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="LAYANAN">Jenis Layanan <span class="text-danger">*</span></label>
                            <select name="LAYANAN" id="LAYANAN" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Layanan</option>
                                <?php
                                $result = GetQuery("select LAYANAN from param where LAYANAN != ''");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?php echo $row["LAYANAN"]; ?>"><?php echo $row["LAYANAN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>
                    <div id="BAGIAN"></div>
                    <div id="STATDOWN"></div>
                    
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="KODE_BARANG">Barang <span class="text-danger">*</span></label>
                        <select name="KODE_BARANG" id="KODE_BARANG" required="" class="form-control" onChange="getKODE_BARANG(this.value);getKODE_UNIT(this.value);" data-parsley-required>
                            <option value="">Pilih Barang</option>
                            <?php
                            $result = GetQuery("select * from m_barang where KODE_JENIS = '$KODE_JENIS' and STATUS = '0'");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <option value="<?php echo $row["KODE_BARANG"]; ?>"<?php if($KODE_BARANG == $row["KODE_BARANG"]) { echo "selected"; } ?>><?php echo $row["NAMA_BARANG"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                          
                </div>
                <?php 
                if (!isset($_GET['edit'])) { 
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_UNIT">Unit Barang <span class="text-danger">* </span><span><i style="color: red;font-size: 0.7em;"><strong>Pilih 'None' jika tdk ada pilihan</strong></i></label>
                            <select name="KODE_UNIT" id="KODE_UNIT" required="" class="form-control" onChange="getLOKASI(this.value);" data-parsley-required>
                                <option value="">Pilih Unit Barang</option>
                            </select>
                        </div>                          
                    </div>
                    <div id="JUMBAR"></div>                       
                    <div id="LOKASI"></div>
            <?php } ?>
            </div>
            <div id="DATA"></div> <!-- JIKA BARANG = KOMPUTER, MUNCULKAN FIELD IP ADDRESS !-->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KERUSAKAN">Kerusakan</label>
                        <textarea class="form-control" required="" name="KERUSAKAN" id="KERUSAKAN" rows="6" placeholder="Detail Kerusakan" data-parsley-required><?php echo $KERUSAKAN; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KETERANGAN">Keterangan</label>
                        <textarea class="form-control" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan Lain"><?php echo $KETERANGAN; ?></textarea>
                    </div>                          
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>&nbsp&nbsp&nbsp
                    <a href="pengajuanmt" type="button" class="btn btn-danger"><i class="fa fa-times fa-lg"></i> Batal</a>
                </div>                    
            </div>
        </form>
    </div>
</div>
