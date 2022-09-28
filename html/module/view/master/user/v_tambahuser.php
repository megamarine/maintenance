<?php
include "module/controller/master/user/t_tambahuser.php"; 
$KODE_BAGIAN = $_SESSION["LOGINBAG_MT"];
?>
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
    function getDIREKSI(val) {
      $.ajax({
      type: "POST",
      url: "cek_direksi.php",
      data:'KODE_BAGIAN='+val,
      success: function(data){
        $("#DIREKSI").html(data);
      }
      });
    }
</script>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-plus2"></i> Tambah User</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="user"><i class="ico-group"></i> Master User</a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah User</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post" data-parsley-validate>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="KODE_USER">Kode User <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" placeholder="Input Kode User" id="KODE_USER" name="KODE_USER" value="<?php echo $KODE_USER; ?>" data-parsley-required>
                    </div>                           
                </div>
            </div>
            <hr>
            <?php
            if ($_SESSION["LOGINAKS_MT"] == "Manajer") 
            {
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                            <select name="KODE_DEPARTEMEN" id="KODE_DEPARTEMEN" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Departemen</option>
                                <?php
                                $result = GetData1("*","m_departemen","KODE_BAGIAN = '$KODE_BAGIAN'");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_DEPARTEMEN"]; ?>"<?php if($KODE_DEPARTEMEN == $row["KODE_DEPARTEMEN"]) { echo "selected"; } ?>><?php echo $row["NAMA_DEPARTEMEN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>                                
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="NAMA_USER">Nama User <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required="" id="NAMA_USER" name="NAMA_USER" value="<?php echo $NAMA_USER; ?>" data-parsley-required>
                        </div>                          
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="PASSWORD">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" value="<?php echo $PASSWORD; ?>" data-parsley-required>
                        </div>                          
                    </div>                                 
                </div>
                <?php
                    if (isset($_GET["KODE_USER"])) {
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="STATUS">Status</label>
                                    <select name="STATUS" id="STATUS" required="" class="form-control">
                                        <option value="">Pilih Status</option>
                                        <?php
                                        $result = GetData("STATUS","param");
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $row["STATUS"]; ?>"<?php if($STATUS == $row["STATUS"]) { echo "selected"; } ?>><?php echo $row["STATUS"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>                          
                            </div>
                        </div>
                        <?php
                    }
                    ?>    
                <?php
            }
            else
            {
                ?>
                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="KODE_BAGIAN">Divisi <span class="text-danger">*</span></label>
                            <!-- <select name="KODE_BAGIAN" id="KODE_BAGIAN" required="" class="form-control" onChange="getKODE_BAGIAN(this.value);" data-parsley-required>
                                <option value="">Pilih Divisi</option>
                            </select> -->

                            <select name="KODE_BAGIAN" id="KODE_BAGIAN" required="" class="form-control" onChange="getKODE_BAGIAN(this.value);" data-parsley-required>
                                <option value="">Pilih Divisi</option>
                                <?php
                                $result = GetData("*","m_bagian","KODE_PERUSAHAAN = '$KODE_PERUSAHAAN' and STATUS = '1' order by NAMA_BAGIAN");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_BAGIAN"]; ?>"<?php if($KODE_BAGIAN == $row["KODE_BAGIAN"]) { echo "selected"; } ?>><?php echo $row["NAMA_BAGIAN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>                                
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                            <select name="KODE_DEPARTEMEN" id="KODE_DEPARTEMEN" required="" class="form-control" onChange="getKODE_DEPARTEMEN(this.value);" data-parsley-required>
                                <option value="">Pilih Departemen</option>
                            </select>
                        </div>                          
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="NAMA_USER">Nama User <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required="" id="NAMA_USER" name="NAMA_USER" value="<?php echo $NAMA_USER; ?>" data-parsley-required>
                        </div>                          
                    </div>                             
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="PASSWORD">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" value="<?php echo $PASSWORD; ?>" data-parsley-required>
                        </div>                          
                    </div>   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input name="EMAIL" id="EMAIL" type="text" class="form-control" data-parsley-trigger="change" data-parsley-type="email" value="<?php echo $EMAIL; ?>">
                        </div>                          
                    </div>                              
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="AKSES">Akses <span class="text-danger">*</span></label>
                            <select name="AKSES" id="AKSES" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Akses </option>
                                <option value="Admin" <?php if($AKSES == "Admin") { echo "selected"; } ?>>Admin</option>
                                <option value="Manajer" <?php if($AKSES == "Manajer") { echo "selected"; } ?>>Manajer</option>
                                <option value="Direktur" <?php if($AKSES == "Direktur") { echo "selected"; } ?>>Direktur</option>
                                <option value="HRD" <?php if($AKSES == "HRD") { echo "selected"; } ?>>HRD</option>
                            </select>
                        </div>                          
                    </div>
                    <?php
                    if (isset($_GET["KODE_USER"])) 
                    {
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="STATUS">Status</label>
                                    <select name="STATUS" id="STATUS" required="" class="form-control">
                                        <option value="">Pilih Status</option>
                                        <?php
                                        $result = GetData("STATUS","param");
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $row["STATUS"]; ?>"<?php if($STATUS == $row["STATUS"]) { echo "selected"; } ?>><?php echo $row["STATUS"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>                          
                            </div>
                        </div>
                        <?php
                    }
                    ?>    
                </div>
                <?php
            }
            ?> 
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp&nbsp&nbsp
                    <a href="user.php" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>