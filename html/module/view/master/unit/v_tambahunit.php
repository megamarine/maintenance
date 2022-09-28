<?php include "module/controller/master/unit/t_unit.php"; ?>
<script type="text/javascript">
function getKODE_BARANG(val) {
      $.ajax({
      type: "POST",
      url: "cek_unit2.php",
      data:'KODE_BARANG='+val,
      success: function(data){
        $("#DATA").html(data);
      }
      });
    }
</script>

<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-archive fa-lg"></i> Master Unit Barang</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="unit"><i class="fa fa-archive fa-lg"></i> Unit Barang </a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Unit Barang</li>
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
                        <label for="KODE_BARANG">Barang <span class="text-danger">*</span></label>
                        <select name="KODE_BARANG" id="KODE_BARANG" required="" onChange="getKODE_BARANG(this.value);"  class="form-control" data-parsley-required>
                            <option value="">Pilih Barang</option>
                            <?php
                            if($_SESSION["LOGINAKS_MT"] == "Administrator")
                            {
                                $where_clause = "";
                            }
                            elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
                            {
                                $where_clause = "and KODE_JENIS = 1";
                            }
                            elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
                            {
                                $where_clause = "and KODE_JENIS = 2";
                            }
                            else if ($_SESSION["LOGINDEP_MT"] == "DEPT-0111")  
                            {
                                $where_clause = "and KODE_JENIS = 3";
                            }
                            else
                            {
                                $where_clause = "and KODE_JENIS = 4";
                            }

                            $result = GetQuery("select * from m_barang where status = 0 $where_clause order by NAMA_BARANG asc");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KODE_BARANG"]; ?>"<?php if($KODE_BARANG == $row["KODE_BARANG"]) { echo "selected"; } ?>><?php echo $row["NAMA_BARANG"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                          
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="NAMA_UNIT">Nama Unit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" autocomplete="off" id="NAMA_UNIT" name="NAMA_UNIT" value="<?php echo $NAMA_UNIT; ?>" data-parsley-required>
                    </div>                          
                </div>     
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="LOKASI">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" autocomplete="off" id="LOKASI" name="LOKASI" value="<?php echo $LOKASI; ?>" data-parsley-required>
                    </div>                         
                </div>                
            </div>
            <?php 
                if(isset($_GET["KODE_UNIT"]) and $_GET["KODE_BARANG"] == "BRG/201803/00106" )
                {
            ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="IP_ADD">IP Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required="" id="IP_ADD" name="IP_ADD" value="<?php echo $IP_ADD; ?>" data-parsley-required onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode <= 57">
                        </div>                          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="MAC_ADD">MAC Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required="" id="MAC_ADD" name="MAC_ADD" value="<?php echo $MAC_ADD; ?>" data-parsley-required>
                        </div>                          
                    </div>
                </div>
            <?php
                }
            ?>

            <div class="row">
                <div id="DATA"></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="MERK">Merk</label>
                        <input type="text" class="form-control" autocomplete="off" id="MERK" name="MERK" value="<?php echo $MERK; ?>" data-parsley-required>
                    </div>                          
                </div>     
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="TYPE">Type</label>
                        <input type="text" class="form-control" autocomplete="off" id="TYPE" name="TYPE" value="<?php echo $TYPE; ?>" data-parsley-required>
                    </div>                          
                </div>
                 <div class="col-lg-3">
                    <div class="form-group">
                        <label for="SPEC">Spesifikasi</label><br>
                        <textarea class="form-control" name="SPEC" id="SPEC" rows="6" placeholder="Spesifikasi"><?php echo $SPEC; ?></textarea>
                    </div>
                </div>  
            </div>
            
            <div class="row">
                <div class="col-lg-3">
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
                    <a href="unit" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>