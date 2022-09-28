<?php
$KODE_JENIS = "";
$PERIODE    = date("Y-m-d");
$PERIODE2   = date("Y-m-d");

if (isset($_POST["KODE_JENIS"])) 
{
    $KODE_JENIS = $_POST["KODE_JENIS"];
    $PERIODE    = $_POST["PERIODE"];
    $PERIODE2   = $_POST["PERIODE2"];
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-file fa-lg"></i> Laporan Maintenance</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-file fa-lg"></i> Laporan Maintenance</li>
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
                <label for="KATEGORI">Kategori</label>
                <select name="KODE_JENIS" id="KODE_JENIS" class="form-control">
                    <option value="">Pilih Kategori</option>
                    <?php
                    $result = GetData("*","m_jenisbrg");
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?php echo $row["KODE_JENIS"]; ?>" <?php if($KODE_JENIS == $row["KODE_JENIS"]) { echo "selected"; } ?>><?php echo $row["NAMA_JENIS"]; ?></option>
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
<br>
<div class="row">
    <div class="col-md-12" align="center">
        <div class="btn-group" style="margin-bottom:5px;">
            <button type="button" class="btn btn-warning mb5 dropdown-toggle" data-toggle="dropdown" style="color: black;"><i class="fa fa-print fa-lg"></i> Export Laporan <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="module\view\laporan\maintenance\export_excel.php?KODE_JENIS=<?php echo $KODE_JENIS; ?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Excel</a></li>
                <!-- <li><a href="print_hasilkinerja?KODE_TEKNISI=<?php echo $KODE_TEKNISI; ?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">PDF</a></li> -->
            </ul>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Maintenance</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Kode</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Unit Barang</th>
                        <th>Lokasi</th>
                        <th>Jumlah Barang</th>
                        <th>Kategori</th>
                        <th>Kerusakan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Keterangan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <?php
                        if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0011") 
                        {
                            ?>
                            <th>Tanggal Perbaikan</th>
                            <th>Tanggal Selesai</th>
                            <th>Status Downtime</th>
                            <th>Downtime</th>
                            <th>Durasi Perbaikan</th>
                            <th>Sparepart &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <?php
                        } 
                        else 
                        {
                            ?>
                            <th>Tanggal Selesai</th>
                            <?php
                        }
                        ?>
                        <th>Hasil Pemeliharaan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        
                        <th>Saran &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Rating &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Verifikasi QC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SESSION["LOGINAKS_MT"] == "Administrator") {
                        include "group/laporan_admin.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
                        include "group/laporan_it.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") {
                        include "group/laporan_civil.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
                        include "group/laporan_mekanik.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0094") {
                        include "group/laporan_ga.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0090") {
                        include "group/laporan_qc.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0056") {
                        include "group/laporan_qsd.php";
                    }
                    else{
                        include "group/laporan_lain.php";
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