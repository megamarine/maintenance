<?php
require_once ("module/model/koneksi/koneksi.php");

if(!isset($_SESSION["LOGINIDUS_MT"]))
{
    ?><script>alert('Silahkan login dahulu');</script><?php
    ?><script>document.location.href='index';</script><?php
    die(0);
}
if (isset($_GET["KODE_PERBAIKAN"])) {
    $KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
    $KODE_PERBAIKAN  = $_GET["KODE_PERBAIKAN"];
    $resultvalid = GetData1(
        "p.KODE_DEPARTEMEN, b.KODE_JENIS",
        "t_perbaikan p, m_barang b",
        "p.KODE_BARANG = b.KODE_BARANG and p.KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
    
    while ($rowValid = $resultvalid->fetch(PDO::FETCH_ASSOC)) {
        if ($_SESSION["LOGINAKS_MT"] == "Administrator") {
            # code...
        }
        elseif ($KODE_DEPARTEMEN == "DEPT-0033") {
            if ($rowValid["KODE_DEPARTEMEN"] != "DEPT-0033" and $rowValid["KODE_JENIS"] != 1) {
                http_response_code(404);
                die(0);
            }
        }
        elseif ($KODE_DEPARTEMEN == "DEPT-0040") {
            if ($rowValid["KODE_DEPARTEMEN"] != "DEPT-0040" and $rowValid["KODE_JENIS"] != 2) {
                http_response_code(404);
                die(0);
            }
        }
        elseif ($KODE_DEPARTEMEN == "DEPT-0094") {
            if ($rowValid["KODE_DEPARTEMEN"] != "DEPT-0094" and $rowValid["KODE_JENIS"] != 3) {
                http_response_code(404);
                die(0);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html class="backend">
    <!-- START Head -->
    <head>
        <!-- START META SECTION -->
        <?php include "module/model/head/head.php"; ?>
        <!-- END STYLESHEETS -->
    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
        <!-- START Template Header -->
        <header id="header" class="navbar">
            <?php include "module/model/header/header.php"; ?>
            <!--/ END Toolbar -->
        </header>
        <!--/ END Template Header -->

        <!-- START Template Sidebar (Left) -->
        <?php include "module/model/sidebar/sidebar.php"; ?>
        <!--/ END Template Sidebar (Left) -->

        <!-- START Template Main -->
        <section id="main" role="main">
            <!-- START Template Container -->
            <div class="container-fluid">
                <!-- START row -->
                <?php include "module/view/maintenance/pengajuanmt/v_prosespengajuanmt.php"; ?>
                <!--/ END row -->
            </div>
            <!--/ END Template Container -->

            <!-- START To Top Scroller -->
            <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->
        </section>
        <!--/ END Template Main -->
        <?php include "module/model/footer/footer.php"; ?>

        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Application and vendor script : mandatory -->
        <script type="text/javascript" src="../javascript/vendor.js"></script>
        <script type="text/javascript" src="../javascript/core.js"></script>
        <script type="text/javascript" src="../javascript/backend/app.js"></script>
        <!--/ Application and vendor script : mandatory -->

        <!-- Plugins and page level script : optional -->
		<script type="text/javascript" src="../javascript/pace.min.js"></script>
        <script type="text/javascript" src="../plugins/selectize/js/selectize.js"></script>
        <script type="text/javascript" src="../plugins/jquery-ui/js/jquery-ui.js"></script>
        <script type="text/javascript" src="../plugins/jquery-ui/js/addon/timepicker/jquery-ui-timepicker.js"></script>
        <script type="text/javascript" src="../plugins/jquery-ui/js/jquery-ui-touch.js"></script>
        <script type="text/javascript" src="../plugins/inputmask/js/inputmask.js"></script>
        <script type="text/javascript" src="../plugins/select2/js/select2.js"></script>
        <script type="text/javascript" src="../plugins/touchspin/js/jquery.bootstrap-touchspin.js"></script>
        <script type="text/javascript" src="../javascript/backend/forms/element.js"></script>
        
		<script type="text/javascript" src="../plugins/datatables/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../plugins/datatables/tabletools/js/dataTables.tableTools.js"></script>
        <script type="text/javascript" src="../plugins/datatables/js/datatables-bs3.js"></script>
        <script type="text/javascript" src="../javascript/backend/tables/datatable.js"></script>
        <!--/ Plugins and page level script : optional -->
        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!--/ END Body -->
</html>