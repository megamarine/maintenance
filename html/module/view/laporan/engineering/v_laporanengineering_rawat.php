<script type="text/javascript">
function getKODE_UNIT(val) {
      $.ajax({
      type: "POST",
      url: "cek_unit.php",
      data:'KODE_BARANG='+val,
      success: function(data){
        $("#KODE_UNIT").html(data);
      }
      });
    }
</script>

<?php
$KODE_JENIS    = "";
$KODE_BARANG   = "";
$KODE_UNIT     = "";
$GO            = "";
$PERIODE       = date("Y-m-01");
$PERIODE2      = date("Y-m-d");

if (isset($_POST["cari"])) 
{
    $PERIODE       = $_POST["PERIODE"];
    $PERIODE2      = $_POST["PERIODE2"];

    if($_POST["KODE_UNIT"] != '')
    {
        $KODE_BARANG = $_POST["KODE_BARANG"];
        $KODE_UNIT   = $_POST["KODE_UNIT"];
        $GO = "select a.KODE_PERBAIKAN,
                      a.BAGIAN,
                      a.KERUSAKAN,
                      a.SOLUSI,
                      a.SARAN,
                      DATE_FORMAT(a.TGL_START, '%d %M %Y') as TGL_START,
                      DATE_FORMAT(a.TGL_START, '%H:%i:%s') as JAM_START,
                      a.JUMLAH_BARANG,
                      DATE_FORMAT(a.TGL_END, '%d %M %Y') as TGL_END,
                      DATE_FORMAT(a.TGL_END, '%H:%i:%s') as JAM_END,
                      a.LAYANAN,
                      a.KETERANGAN,
                      b.NAMA_BARANG,
                      c.NAMA_UNIT,
                      d.NAMA_PERUSAHAAN,
                      e.NAMA_DEPARTEMEN,
                      f.NAMA_USER
                 from t_perbaikan a
                 JOIN m_barang b ON a.KODE_BARANG = b.KODE_BARANG
                 JOIN m_unit c ON a.KODE_UNIT = c.KODE_UNIT
                 JOIN m_perusahaan d ON a.KODE_PERUSAHAAN = d.KODE_PERUSAHAAN
                 JOIN m_departemen e ON a.KODE_DEPARTEMEN = e.KODE_DEPARTEMEN
                 JOIN m_user f ON a.USER_REQ = f.KODE_USER
                WHERE a.kode_unit = '$KODE_UNIT' and
                      a.LAYANAN = 'PERAWATAN' and 
                      a.TGL_START BETWEEN '$PERIODE' AND '$PERIODE2'
             ORDER BY a.TGL_START asc";

    }
    else
    {
        $KODE_BARANG = $_POST["KODE_BARANG"];
        $KODE_UNIT   = $_POST["KODE_UNIT"];
        $GO = "select a.KODE_PERBAIKAN,
                      a.BAGIAN,
                      a.KERUSAKAN,
                      a.SOLUSI,
                      a.SARAN,
                      DATE_FORMAT(a.TGL_START, '%d %M %Y') as TGL_START,
                      DATE_FORMAT(a.TGL_START, '%H:%i:%s') as JAM_START,
                      a.JUMLAH_BARANG,
                      DATE_FORMAT(a.TGL_END, '%d %M %Y') as TGL_END,
                      DATE_FORMAT(a.TGL_END, '%H:%i:%s') as JAM_END,
                      a.LAYANAN,
                      a.KETERANGAN,
                      b.NAMA_BARANG,
                      c.NAMA_UNIT,
                      d.NAMA_PERUSAHAAN,
                      e.NAMA_DEPARTEMEN,
                      f.NAMA_USER
                 from t_perbaikan a
                 JOIN m_barang b ON a.KODE_BARANG = b.KODE_BARANG
                 JOIN m_unit c ON a.KODE_UNIT = c.KODE_UNIT
                 JOIN m_perusahaan d ON a.KODE_PERUSAHAAN = d.KODE_PERUSAHAAN
                 JOIN m_departemen e ON a.KODE_DEPARTEMEN = e.KODE_DEPARTEMEN
                 JOIN m_user f ON a.USER_REQ = f.KODE_USER
                WHERE a.kode_barang = '$KODE_BARANG' and
                      a.LAYANAN = 'PERAWATAN' and 
                      a.TGL_START BETWEEN '$PERIODE' AND '$PERIODE2'
             ORDER BY a.TGL_START asc";
    }
   
}

?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-heartbeat fa-lg"></i> Laporan Perawatan Mesin</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-file"></i> Laporan Perawatan Mesin</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>

<form role="form" action="" method="post">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="KODE_BARANG">Nama Barang <span class="text-danger">*</span></label>
                <select name="KODE_BARANG" id="KODE_BARANG" required="" class="form-control" onChange="getKODE_UNIT(this.value);" data-parsley-required>
                    <option value="">Pilih Barang</option>
                    <?php
                    $result = GetData1("*","m_barang","ITEM_TYPE='MC' and STATUS='0' and KODE_JENIS='2' order by NAMA_BARANG asc");
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
                <label for="KODE_UNIT">Nama Unit <span class="text-danger">*</span></label>
                <select name="KODE_UNIT" id="KODE_UNIT" class="form-control">
                    <option value="">Pilih Unit Barang</option>
                    <?php
                    $result        = GetQuery("select * from m_unit where KODE_BARANG = '$KODE_BARANG' and STATUS = '0' order by KODE_UNIT asc");
                    while ($rowz   = $result->fetch(PDO::FETCH_ASSOC)) 
                    {
                        ?>
                            <option value="<?php echo $rowz["KODE_UNIT"]; ?>"<?php if($KODE_UNIT == $rowz["KODE_UNIT"]) { echo "selected"; } ?>><?php echo $rowz["NAMA_UNIT"]; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>                          
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="PERIODE">Periode</label>
                <input type="text" class="form-control" name="PERIODE" id="datepicker1" value="<?php echo $PERIODE; ?>" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="PERIODE2" style="color: transparent;">.</label>
                <input type="text" class="form-control" name="PERIODE2" id="datepicker2" value="<?php echo $PERIODE2; ?>" />
            </div>
        </div>
        <div class="form-group">
            <label style="color: transparent;">.</label><br>
            <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-search-plus fa-lg"></i> Cari</button>&nbsp;&nbsp;&nbsp;
            <!-- <a href="laporanengineering" type="button" class="btn btn-danger"><i class="fa fa-refresh fa-lg"></i> Clear</a> -->
        </div>       
    </div>
</form>
<br>
<div class="row">
    <div class="col-md-12" align="center">
        <div class="btn-group" style="margin-bottom:5px;">
            <button type="button" class="btn btn-warning mb5 dropdown-toggle" data-toggle="dropdown" style="color: black;"><i class="fa fa-print fa-lg"></i> Export Laporan <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">

                <?php 
                if($_POST["KODE_UNIT"] != '')
                {
                ?>
                    <li><a href="module\view\laporan\engineering\exexcel_engineering_rawat.php?KODE_BARANG=<?php echo $KODE_BARANG;?>&KODE_UNIT=<?php echo $KODE_UNIT; ?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Excel</a></li>
                <?php
                }
                else
                {
                ?>
                    <li><a href="module\view\laporan\engineering\exexcel_engineering_rawat.php?KODE_BARANG=<?php echo $KODE_BARANG;?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Excel</a></li>
                <?php
                }
                ?>

                
            </ul>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                    if(isset($_POST["KODE_BARANG"]))
                    {
                    ?>
                        <h3 class="panel-title">Laporan Perawatan Mesin </h3>
                    <?php
                    }
                    ?>

            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Nama Unit</th>
                        <th>Qty</th>
                        <th>Bagian</th>
                        <th>Layanan</th>
                        <th>Kerusakan</th>
                        <th>Keterangan</th>
                        <th>Tanggal Selesai</th>
                        <th>Hasil Pemeliharaan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        $result = getQuery("$GO");
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                        {
                        ?>
                            <tr>
                                <td align="center"><?php echo $no++."."; ?></td>
                                <td align="center"><?php echo $row["KODE_PERBAIKAN"]; ?></td>
                                <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                                <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
                                <td align="center"><?php echo $row["TGL_START"]."<br>".$row["JAM_START"]; ?></td>
                                <td><?php echo $row["NAMA_BARANG"];?></td>
                                <td><?php echo $row["NAMA_UNIT"];?></td>
                                <td align="center"><?php echo $row["JUMLAH_BARANG"];?></td>
                                <td><?php echo $row["BAGIAN"]; ?></td>
                                <td><?php echo $row["LAYANAN"]; ?></td>
                                <td><?php echo $row["KERUSAKAN"]; ?></td>
                                <td><?php echo $row["KETERANGAN"]; ?></td>
                                <td align="center"><?php echo $row["TGL_END"]."<br>".$row["JAM_END"]; ?></td>
                                <td><?php echo $row["SOLUSI"]; ?></td>
                            </tr>
                        <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function(){
        // Find any date inputs and override their functionality
        $('#datepicker1').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>