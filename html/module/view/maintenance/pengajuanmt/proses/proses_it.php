<?php include "module/controller/maintenance/pengajuanmt/t_pengajuanmt.php"; 

$result2 = GetQuery("
    select p.*,
           t.NAMA_TEKNISI 
    from d_perbaikan p, 
         m_teknisi t 
    where p.KODE_TEKNISI = t.KODE_TEKNISI and 
          p.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and 
          p.STS_HAPUS = 0");

$result3 = GetQuery("
    select m.*,
           s.NAMA_PART 
    from d_maintenance m, 
         m_sparepart s 
    where m.KODE_PART = s.KODE_PART and 
          m.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and 
          m.STS_HAPUS = 0");

$result4 = GetQuery("
    select *,
           DATE_FORMAT(TGL_MULAI, '%d %M %Y') as TGL_PERBAIKAN,
           DATE_FORMAT(TGL_MULAI, '%H:%i:%s') as JAM_PERBAIKAN
      from d_progress
     where KODE_PERBAIKAN = '$KODE_PERBAIKAN'
  order by TGL_MULAI");
?>

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
        <h3>Detail Kerusakan</h3>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="NAMA_BARANG">Barang </label>
                    <input type="text" class="form-control" readonly="" id="NAMA_BARANG" name="NAMA_BARANG" value="<?php echo $NAMA_BARANG; ?>">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="NAMA_UNIT">Unit Barang </label>
                    <input type="text" class="form-control" readonly="" id="NAMA_UNIT" name="NAMA_UNIT" value="<?php echo $NAMA_UNIT; ?>">
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="LAYANAN">Jenis Layanan </label>
                    <input type="text" class="form-control" readonly="" id="LAYANAN" name="LAYANAN" value="<?php echo $LAYANAN; ?>">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="KERUSAKAN">Kerusakan</label>
                    <textarea class="form-control" readonly="" name="KERUSAKAN" id="KERUSAKAN" rows="6" placeholder="Detail Kerusakan"><?php echo $KERUSAKAN; ?></textarea>
                </div>                          
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="KETERANGAN">Keterangan</label>
                    <textarea class="form-control" readonly="" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan Lain"><?php echo $KETERANGAN; ?></textarea>
                </div>                          
            </div>
        </div>
        <h3>Hasil Perbaikan</h3>
        <hr>
        <form role="form" id="form" action="" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="KODE_TEKNISI">User yang memperbaiki / Teknisi <span class="text-danger">*</span></label>
                        <select name="KODE_TEKNISI" id="KODE_TEKNISI" class="form-control">
                            <option value="">Pilih Karyawan</option>
                            <?php
                            if ($KODE_JENIS == 2) {
                                $result = GetQuery("select * from m_teknisi where KODE_JENIS = '$KODE_JENIS' and KODE_PERUSAHAAN = '$KODE_PERUSAHAAN' and STS_AKTIF = 0 order by NAMA_TEKNISI");
                            } else {
                                $result = GetQuery("select * from m_teknisi where KODE_JENIS = '$KODE_JENIS' and STS_AKTIF = 0 order by NAMA_TEKNISI");
                            }
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KODE_TEKNISI"]; ?>"<?php if($KODE_TEKNISI == $row["KODE_TEKNISI"]) { echo "selected"; } ?>><?php echo $row["NAMA_TEKNISI"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                         
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label style="color:transparent">.</label><br>
                        <button type="submit" name="simpan3" class="btn btn-success"><i class="ico-plus2"></i> Tambah</button>
                    </div>         
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="KODE_PART">Kebutuhan Spare Part </label>
                        <select name="KODE_PART" id="selectize-customselect" class="form-control">
                            <option value="">Pilih Barang</option>
                            <?php
                            $result = GetQuery("select * from m_sparepart where KODE_JENIS = '$KODE_JENIS' order by NAMA_PART");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KODE_PART"]; ?>"<?php if($KODE_PART == $row["KODE_PART"]) { echo "selected"; } ?>><?php echo $row["NAMA_PART"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                          
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="JUMLAH_PART">Jumlah </label>
                        <input type="text" class="form-control" id="JUMLAH_PART" name="JUMLAH_PART" value="<?php echo $JUMLAH_PART; ?>">
                    </div>                      
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label style="color:transparent">.</label><br>
                        <button type="submit" name="simpan4" class="btn btn-success"><i class="ico-plus2"></i> Tambah</button>
                    </div>         
                </div>
            </div>
        </form>
        <hr>
        <form role="form" id="form" action="" method="post" data-parsley-validate>
            <?php
            if ($KODE_JENIS == 2) {
                ?>
                <h3>Jadwal Perbaikan</h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" autocomplete="off" required id="datepicker1" autofocus="off" name="TGL_PERBAIKAN" placeholder="Select a date" value="<?php echo $TGL_PERBAIKAN; ?>" data-parsley-required/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jam Mulai <span class="text-danger">*</span></label>
                            <input type="text" autocomplete="off" required class="form-control" id="time-picker" autofocus="off" name="JAM_PERBAIKAN" value="<?php echo $JAM_PERBAIKAN; ?>" placeholder="Select a time" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" autocomplete="off" required id="datepicker2" autofocus="off" name="TGL_SELESAI" placeholder="Select a date" value="<?php echo $TGL_SELESAI; ?>" data-parsley-required/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jam Selesai <span class="text-danger">*</span></label>
                            <input type="text" autocomplete="off" required class="form-control" id="time-picker2" autofocus="off" name="JAM_SELESAI" value="<?php echo $JAM_SELESAI; ?>" placeholder="Select a time" />
                        </div>
                    </div>
                </div>
                <hr>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="DURASI">Durasi Pengerjaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" autocomplete="off" required="" id="DURASI" name="DURASI" value="<?php echo $DURASI; ?>" data-parsley-required>
                    </div>
                </div>
                <?php
                if ($KODE_JENIS == 2) {
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="BAGIAN">Bagian <span class="text-danger">*</span></label>
                            <select name="BAGIAN" id="BAGIAN" class="form-control" required="" data-parsley-required>
                                <option value="">Pilih Bagian</option>
                                <?php
                                $result = GetQuery("select BAGIAN from param where BAGIAN != '' order by BAGIAN");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["BAGIAN"]; ?>"<?php if($BAGIAN == $row["BAGIAN"]) { echo "selected"; } ?>><?php echo $row["BAGIAN"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Status Pengerjaan <span class="text-danger">*</span></label>
                            <select name="STATUS_PERBAIKAN" id="STATUS_PERBAIKAN" class="form-control" required="" data-parsley-required>
                                <option value="">Pilih Status</option>
                                <?php
                                $result = GetQuery("select STATUS_PERBAIKAN from param where STATUS_PERBAIKAN != ''");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["STATUS_PERBAIKAN"]; ?>"<?php if($STATUS_PERBAIKAN == $row["STATUS_PERBAIKAN"]) { echo "selected"; } ?>><?php echo $row["STATUS_PERBAIKAN"]; ?></option>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="SOLUSI">Hasil Perbaikan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="SOLUSI" id="SOLUSI" rows="6" autocomplete="off" required placeholder="Detail Hasil" data-parsley-required><?php echo $SOLUSI; ?></textarea>
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="SARAN">Saran</label>
                        <textarea class="form-control" name="SARAN" id="SARAN" rows="6" autocomplete="off" placeholder="Input Saran"><?php echo $SARAN; ?></textarea>
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
                                                <td align="center"><?php echo $row["JUMLAH_PART"]; ?></td>
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
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
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
                                                <td align="center"><?php echo $row["TGL_MULAI"]; ?></td>
                                                <td align="center"><?php echo $row["TGL_SELESAI"]; ?></td>
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
            <br><br>
            <div class="row">
                <?php
                if ($_SESSION["LOGINAKS_MT"] == "Administrator") {
                    ?>
                    <div class="col-md-7" align="right">
                        <button type="submit" name="simpanDetail" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                        <a href="pengajuanmt" type="button" class="btn btn-danger"><i class="fa fa-times fa-lg"></i> Batal</a>
                    </div>
                    <div class="col-md-5" align="right">
                        <button type="submit" name="simpan2" class="btn btn-inverse"><i class="fa fa-check fa-lg"></i> Selesai</button>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-lg-12" align="center">
                        <button type="submit" name="simpan2" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                        <a href="pengajuanmt" type="button" class="btn btn-danger"><i class="fa fa-times fa-lg"></i> Batal</a>
                    </div> 
                    <?php
                }
                
                ?>                   
            </div>  
            <br><br>
        </form>   
    </div>
</div>
<script type="text/javascript">
    $('form').preventDoubleSubmission();
</script>