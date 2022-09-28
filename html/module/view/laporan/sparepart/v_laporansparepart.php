<?php
$KODE_PART = "";
$PERIODE   = date("Y-m-01");
$PERIODE2  = date("Y-m-t");

if (isset($_POST["KODE_PART"])) 
{
    $KODE_PART = $_POST["KODE_PART"];
    $PERIODE   = $_POST["PERIODE"];
    $PERIODE2  = $_POST["PERIODE2"];
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-file fa-lg"></i> Laporan Spare Part</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-file fa-lg"></i> Laporan Spare Part</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>

<form role="form" action="" method="post">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="PERIODE">Periode</label>
                <input type="text" class="form-control" name="PERIODE" id="datepicker1" value="<?php echo $PERIODE; ?>" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="PERIODE2" style="color: transparent;">.</label>
                <input type="text" class="form-control" name="PERIODE2" id="datepicker2" value="<?php echo $PERIODE2; ?>" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="KATEGORI">Spare Part</label>
                <select name="KODE_PART" id="selectize-customselect" class="form-control">
                    <option value="">Pilih Spare Part</option>
                    <?php
                    $result = GetQuery("select * from m_sparepart where STS_AKTIF = 0");
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?php echo $row["KODE_PART"]; ?>" <?php if($KODE_PART == $row["KODE_PART"]) { echo "selected"; } ?>><?php echo $row["NAMA_PART"]; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label style="color: transparent;">.</label><br>
            <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-search-plus fa-lg"></i> Cari</button>&nbsp;&nbsp;&nbsp;
            <a href="laporanmaintenance" type="button" class="btn btn-danger"><i class="fa fa-refresh fa-lg"></i> Clear</a>
        </div>       
    </div>
</form>
<br><br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Spare Part</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Kerusakan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Keterangan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Hasil Pemeliharaan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Spare Part</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $resultPart = "SELECT s.NAMA_PART,d.JUMLAH_PART FROM d_maintenance d, m_sparepart s WHERE d.KODE_PART = s.KODE_PART AND d.KODE_PERBAIKAN = '$KODE_PERBAIKAN'";
                    ?>
                    <tr>
                        <td align="center"><?php echo $KODE_PERBAIKAN; ?></td>
                        <td align="center"><?php echo $NAMA_PERUSAHAAN; ?></td>
                        <td align="center"><?php echo $NAMA_DEPARTEMEN; ?></td>
                        <td align="center"><?php echo $TGL_START; ?> <br> <?php echo $JAM_START; ?></td>
                        <td align="center"><?php echo $NAMA_BARANG; ?></td>
                        <td align="center"><?php echo $LAYANAN; ?></td>
                        <td align="left"><?php echo $KERUSAKAN; ?></td>
                        <td align="left"><?php echo $SOLUSI; ?></td>
                        <td align="center">
                            <?php
                            while ($rowPart = $resultPart->fetch(PDO::FETCH_ASSOC)) {
                                extract($rowPart);
                                echo $NAMA_PART;?><br><?php
                            }
                            ?>
                        </td>
                        <td align="center">
                            <?php
                            while ($rowQty = $resultPart->fetch(PDO::FETCH_ASSOC)) {
                                extract($rowQty);
                                echo $JUMLAH_PART;?><br><?php
                            }
                            ?>
                        </td>
                        ?>
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