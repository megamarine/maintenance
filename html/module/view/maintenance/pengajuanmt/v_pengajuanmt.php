<?php
$DINO       = date('Y-m-d H:i:s');
$ID_USER1   = $_SESSION["LOGINIDUS_MT"];
$IP_ADDRESS = $_SESSION["IP_ADDRESS_MT"];
$PC_NAME    = $_SESSION["PC_NAME_MT"];

$KETERANGAN = "";
if (isset($_POST["cari"])) 
{
    $PERIODE  = $_POST["PERIODE"];
    $PERIODE2 = $_POST["PERIODE2"];
}
else
{
    $PERIODE  = date("Y-m-d");
    $PERIODE2 = date("Y-m-d");
}
if (isset($_POST["simpan"])) {
    $KETERANGAN     = $_POST["KETERANGAN"];
    $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];

    GetQuery(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tolak Maintenance','User Menolak Maintenance dengan Kode $KODE_PERBAIKAN')");

    GetQuery(
        "update t_perbaikan 
        set STATUS_HAPUS = 1, SOLUSI = 'Alasan Penolakan : $KETERANGAN', PROGRESS = 100 where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

    ?><script>document.location.href='pengajuanmt';</script><?php
    die(0);
}

if (isset($_POST["simpan2"])) {
    $KETERANGAN2    = $_POST["KETERANGAN2"];
    $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];

    GetQuery(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Pending Maintenance','User Pending Maintenance dengan Kode $KODE_PERBAIKAN')");

    GetQuery(
        "update t_perbaikan 
        set KETERANGAN2 = '$KETERANGAN2', STATUS_READ = 1 
        where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

    ?><script>document.location.href='pengajuanmt';</script><?php
    die(0);
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-wrench fa-lg"></i> Pengajuan Perbaikan Barang</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-wrench fa-lg"></i> Pengajuan Perbaikan Barang</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-9">
                <a href="tambah_pengajuanmt" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Pengajuan</a>
            </div>                    
        <?php
        if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0011") 
        {
        ?>

            <div class="col-lg-3" align="right">
                <a href="export_pengajuanmt.php?PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" class="btn btn-warning" style="color: black;"><i class="fa fa-print fa-lg"></i> Export Excel</a>
            </div>                    

        <?php 
        }
        ?>
        </div>
        <br/>
    </div>
</div>
<?php
if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or $_SESSION["LOGINDEP_MT"] == "DEPT-0011") {
    ?>
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
            <div class="form-group">
                <label style="color: transparent;">.</label><br>
                <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-search-plus fa-lg"></i> Cari</button>&nbsp;&nbsp;&nbsp;
                <a href="pengajuanmt" type="button" class="btn btn-danger"><i class="fa fa-refresh fa-lg"></i> Clear</a>
            </div>       
        </div>
    </form>
    <?php
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Maintenance</h3>
            </div>
            <!-- <?php
            if ($_SESSION["LOGINDEP_MT"] == "DEPT-0094") {
                ?>
                <table class="table table-striped table-bordered" id="table-tools">
                <?php
            }
            else{
                ?>
                <table class="table table-striped table-bordered" id="zero-configuration">
                <?php
            }
            ?> -->
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th class="hidden"></th>
                        <th style="white-space:nowrap">Opsi</th>
                        <th style="white-space:nowrap">Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th style="white-space:nowrap">Kode</th>
                        <th style="white-space:nowrap">Perusahaan</th>
                        <th style="white-space:nowrap">Departemen</th>
                        <th style="white-space:nowrap">Tgl Pengajuan</th>
                        <th style="white-space:nowrap">Nama Barang</th>
                        <th style="white-space:nowrap">Unit Barang</th>
                        <th style="white-space:nowrap">Lokasi</th>
                        <th style="white-space:nowrap">Qty</th>
                        <th style="white-space:nowrap">Kategori</th>
                        <th style="white-space:nowrap">Layanan</th>
                        <th style="white-space:nowrap">Kerusakan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th style="white-space:nowrap">Keterangan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th style="white-space:nowrap">Tgl Selesai</th>
                        <th style="white-space:nowrap">Hasil Pemeliharaan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SESSION["LOGINAKS_MT"] == "Administrator") {
                        include "group/mt_admin.php";
                    }
                    // elseif ($_SESSION["LOGINAKS_MT"] == "QC") {
                    //     include "group/mt_qc.php";
                    // }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") {
                        include "group/mt_civil.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
                        include "group/mt_it.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
                        include "group/mt_mekanik.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0029") {
                        include "group/mt_ga.php";
                    }
                    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0056") {
                        include "group/mt_qsd.php";
                    }
                    else{
                        include "group/mt_lain.php";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- START modal-sm -->
<div id="addBookDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form role="form" action="" method="post" data-parsley-validate>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3 class="semibold modal-title text-success">Tolak Permintaan</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="KETERANGAN">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" required="" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Alasan Penolakan" data-parsley-required><?php echo $KETERANGAN; ?></textarea>
                    </div>  
                    <div class="form-group hidden">
                        <input type="text" class="form-control" required="" id="KODE_PERBAIKAN" name="KODE_PERBAIKAN" value="<?php echo $KODE_PERBAIKAN; ?>" data-parsley-required>
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo fa-lg"></i> Batal</button>
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--/ END modal-sm -->

<!-- START modal-sm -->
<div id="addBookDialog2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form role="form" action="" method="post" data-parsley-validate>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3 class="semibold modal-title text-success">Waiting List</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="KETERANGAN2">Keterangan <span class="text-danger">*</span></label>
                        <select name="KETERANGAN2" id="KETERANGAN2" required="" class="form-control" data-parsley-required>
                            <option value="">Pilih Keterangan</option>
                            <?php
                            $result = GetQuery("select KETERANGANMT from param where KETERANGANMT is not null");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["KETERANGANMT"]; ?>"><?php echo $row["KETERANGANMT"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>  
                    <div class="form-group hidden">
                        <input type="text" class="form-control" required="" id="KODE_PERBAIKAN" name="KODE_PERBAIKAN" value="<?php echo $KODE_PERBAIKAN; ?>" data-parsley-required>
                    </div>   
                    <br><br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo fa-lg"></i> Batal</button>
                    <button type="submit" name="simpan2" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--/ END modal-sm -->


<script type="text/javascript">
// // Add Source JavaScript

$(document).on("click", ".open-AddBookDialog", function () {
     var myBookId = $(this).data('id');
     $(".modal-body #KODE_PERBAIKAN").val( myBookId );
});
$(document).on("click", ".open-AddBookDialog2", function () {
     var myBookId2 = $(this).data('id');
     $(".modal-body #KODE_PERBAIKAN").val( myBookId2 );
});
</script>