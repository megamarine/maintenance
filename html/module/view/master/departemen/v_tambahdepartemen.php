<?php include "module/controller/master/departemen/t_departemen.php"; ?>
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
</script>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-cube3"></i> Master Departemen</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="departemen"><i class="ico-cube3"></i> Departemen</a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Departemen</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="KODE_PERUSAHAAN">Perusahaan</label>
                        <select name="KODE_PERUSAHAAN" id="KODE_PERUSAHAAN" required="" class="form-control" onChange="getKODE_PERUSAHAAN(this.value);">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="KODE_BAGIAN">Divisi</label>
                        <select name="KODE_BAGIAN" id="KODE_BAGIAN" required="" class="form-control" onChange="getKODE_BAGIAN(this.value);">
                            <option value="">Pilih Divisi</option>
                        </select>
                    </div>                          
                </div>                                 
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="NAMA_DEPARTEMEN">Departemen</label>
                        <input type="text" class="form-control" required="" id="NAMA_DEPARTEMEN" name="NAMA_DEPARTEMEN" value="<?php echo $NAMA_DEPARTEMEN; ?>">
                    </div>                          
                </div>                             
            </div> 
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp&nbsp&nbsp
                    <a href="departemen" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>