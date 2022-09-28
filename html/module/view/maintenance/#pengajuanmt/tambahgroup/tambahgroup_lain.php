<?php include "module/controller/maintenance/pengajuanmt/t_pengajuanmt.php";

$result2 = GetQuery(
   "select p.*,
    t.NAMA_TEKNISI 
   from d_perbaikan p, 
    m_teknisi t 
   where p.KODE_TEKNISI = t.KODE_TEKNISI and 
    p.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and 
    p.STS_HAPUS = 0");

$result3 = GetQuery(
   "select m.*,
    s.NAMA_PART 
   from d_maintenance m, 
    m_sparepart s 
   where m.KODE_PART = s.KODE_PART and 
    m.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and 
    m.STS_HAPUS = 0");

$result4 = GetQuery(
   "select *,
    DATE_FORMAT(TGL_PERBAIKAN, '%d %M %Y') as TGL_PERBAIKAN,
    DATE_FORMAT(TGL_PERBAIKAN, '%H:%i:%s') as JAM_PERBAIKAN 
   from d_progress 
   where KODE_PERBAIKAN = '$KODE_PERBAIKAN' 
   order by TGL_PERBAIKAN");
?>
<script type="text/javascript">
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
    function getKODE_JENIS(val) {
      $.ajax({
      type: "POST",
      url: "cek_jenis.php",
      data:'KODE_JENIS='+val,
      success: function(data){
        $("#KODE_BARANG").html(data);
      }
      });
    }
    function getKODE_JENIS2(val) {
      $.ajax({
      type: "POST",
      url: "cek_bagian2.php",
      data:'KODE_JENIS='+val,
      success: function(data){
        $("#BAGIAN").html(data);
      }
      });
    }
    function getKODE_JENIS3(val) {
      $.ajax({
      type: "POST",
      url: "cek_bagian3.php",
      data:'KODE_JENIS='+val,
      success: function(data){
        $("#JUMBAR").html(data);
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
        <form role="form" action="" method="post" data-parsley-validate>
            <h3>Spefisikasi Kerusakan</h3>
            <hr>
            <?php
            if (isset($_GET["KODE_PERBAIKAN"])) 
            {
                if ($_SESSION["LOGINBAG_MT"] == "DIV-0026") 
                {
                    $KODE_BAGIAN = $_SESSION["LOGINBAG_MT"];
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                                <select name="KODE_DEPARTEMEN" id="KODE_DEPARTEMEN" required="" class="form-control" data-parsley-required>
                                    <option value="">Pilih Departemen</option>
                                    <?php
                                    $result = GetQuery("select * from m_departemen where KODE_BAGIAN = '$KODE_BAGIAN' and STATUS = '1' order by NAMA_DEPARTEMEN");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                                    {
                                        ?>
                                        <option value="<?php echo $row["KODE_DEPARTEMEN"]; ?>"<?php if($KODE_DEPARTEMEN == $row["KODE_DEPARTEMEN"]) { echo "selected"; } ?>><?php echo $row["NAMA_DEPARTEMEN"]; ?></option>
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
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_JENIS">Tujuan Perbaikan <span class="text-danger">*</span></label>
                            <select name="KODE_JENIS" id="KODE_JENIS" required="" class="form-control" onChange="getKODE_JENIS(this.value);getKODE_JENIS2(this.value);getKODE_JENIS3(this.value);" data-parsley-required>
                                <option value="">Pilih Tujuan</option>
                                <?php
                                $result = GetQuery("select * from m_jenisbrg order by NAMA_JENIS");
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
                    <?php
                        if ($KODE_JENIS == 2) 
                        {
                            ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="BAGIAN">Bagian <span class="text-danger">*</span></label>
                                    <select name="BAGIAN" id="BAGIAN" required="" class="form-control" data-parsley-required>
                                        <option value="">Pilih Bagian</option>
                                        <?php
                                        $result = GetQuery("select BAGIAN from param where BAGIAN != ''");
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <option value="<?php echo $row["BAGIAN"]; ?>"<?php if($BAGIAN == $row["BAGIAN"]) { echo "selected"; } ?>><?php echo $row["BAGIAN"]; ?></option>
                                            <?php
                                        }
                                        ?>
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
                            <label for="KODE_BARANG">Barang <span class="text-danger">*</span></label>
                            <select name="KODE_BARANG" id="KODE_BARANG" autofocus="" required="" class="form-control" onChange="getKODE_BARANG(this.value);getKODE_UNIT(this.value);" data-parsley-required>
                                <option value="">Pilih Barang</option>
                                <?php
                                $result = GetQuery("select * from m_barang where KODE_JENIS = '$KODE_JENIS'");
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
                    if ($KODE_JENIS == 2) {
                        ?>
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label for="JUMBAR">Jumlah Barang <span class="text-danger">*</span></label><br/>
                                    <?php
                                    $result = GetQuery("select * from t_perbaikan where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <input type="number" class="form-control" min="1" value="<?php echo $row["JUMLAH_BARANG"];?>" required="" name="JUMBAR" id="JUMBAR" data-parsley-required>
                                    <?php
                                }
                                ?>
                                </div>                          
                        </div>
                        <?php
                    }
                    
                    if ($KODE_BARANG == "BRG/201803/00106") {
                        ?>
                        <div id="DATA">
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
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <?php
            } 
            else 
            {
                if ($_SESSION["LOGINBAG_MT"] == "DIV-0026") {
                    $KODE_BAGIAN = $_SESSION["LOGINBAG_MT"];
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                                <select name="KODE_DEPARTEMEN" id="KODE_DEPARTEMEN" required="" class="form-control" data-parsley-required>
                                    <option value="">Pilih Departemen</option>
                                    <?php
                                    $result = GetQuery("select * from m_departemen where KODE_BAGIAN = '$KODE_BAGIAN' order by NAMA_DEPARTEMEN");
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
                                $result = GetQuery("select * from m_jenisbrg order by NAMA_JENIS");
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
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_BARANG">Barang <span class="text-danger">*</span></label>
                            <select name="KODE_BARANG" id="KODE_BARANG" autofocus="" required="" class="form-control" onChange="getKODE_BARANG(this.value);getKODE_UNIT(this.value);" data-parsley-required>
                                <option value="">Pilih Barang</option>
                            </select>
                        </div>                          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_UNIT">Unit Barang <span class="text-danger">*</span></label>
                            <select name="KODE_UNIT" id="KODE_UNIT" autofocus="" required="" class="form-control" onChange="getLOKASI(this.value);" data-parsley-required>
                                <option value="">Pilih Unit Barang</option>
                            </select>
                        </div>                          
                    </div>
                    <div id="JUMBAR"></div>
                    <div id="LOKASI"></div>                                                            
                </div>
                <div id="DATA"></div> <!-- JIKA BARANG = KOMPUTER, MUNCULKAN FIELD IP ADDRESS !-->
                <?php
            }
            ?>
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
            <hr>
            <?php
            if ($SOLUSI != "") {
                ?>
                <h3>Hasil Perbaikan Teknisi</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="DURASI">Durasi Pengerjaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" readonly="" id="DURASI" name="DURASI" value="<?php echo $DURASI; ?>" data-parsley-required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="TGL_END">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" readonly id="datepicker1" name="TGL_END" placeholder="Select a date" value="<?php echo $TGL_END; ?>" data-parsley-required/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="BAGIAN">Bagian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" readonly id="BAGIAN" name="BAGIAN" value="<?php echo $BAGIAN; ?>" data-parsley-required/>
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="SOLUSI">Hasil Pemeliharaan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="SOLUSI" id="SOLUSI" rows="6" readonly placeholder="Detail Hasil" data-parsley-required><?php echo $SOLUSI; ?></textarea>
                        </div>                          
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="SARAN">Saran</label>
                            <textarea class="form-control" name="SARAN" id="SARAN" readonly rows="6" placeholder="Input Saran"><?php echo $SARAN; ?></textarea>
                        </div>                          
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 center">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#tab1" data-toggle="tab">Daftar Pengerjaan Karyawan</a></li>
                            <li><a href="#tab2" data-toggle="tab">Daftar Kebutuhan Spare Part</a></li>
                            <li><a href="#tab3" data-toggle="tab">Detail Pengerjaan Perbaikan</a></li>
                        </ul>
                        <div class="tab-content panel">
                            <div class="tab-pane active" id="tab1">
                                <div class="panel panel-default">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Opsi</th>
                                                <th>Nama Karyawan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result2->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td align="center"><a href="hapus_dteknisi?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&KODE_TEKNISI=<?php echo $row["KODE_TEKNISI"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus data ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                                                    <td align="center"><?php echo $row["NAMA_TEKNISI"]; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="panel panel-default">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Opsi</th>
                                                <th>Spare Part</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result3->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td align="center"><a href="hapus_dpart?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&KODE_PART=<?php echo $row["KODE_PART"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus data ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                                                    <td align="center"><?php echo $row["NAMA_PART"]; ?></td>
                                                    <td align="right"><?php echo $row["JUMLAH_PART"]; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="panel panel-default">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Opsi</th>
                                                <th>Tanggal</th>
                                                <th>Durasi</th>
                                                <th>Hasil Perbaikan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result3->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td align="center"><a href="hapus_dprogress?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&KODE_DETAIL=<?php echo $row["KODE_DETAIL"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus data ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                                                    <td align="center"><?php echo $row["TGL_PERBAIKAN"] . " " . $row["JAM_PERBAIKAN"]; ?></td>
                                                    <td align="center"><?php echo $row["DURASI"]; ?></td>
                                                    <td align="left"><?php echo $row["HASIL_PERBAIKAN"]; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
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
