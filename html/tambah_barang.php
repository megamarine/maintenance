<?php
require_once ("module/model/koneksi/koneksi.php");

if(!isset($_SESSION["LOGINIDUS_MT"]))
{
    ?><script>alert('Silahkan login dahulu');</script><?php
    ?><script>document.location.href='index';</script><?php
    die(0);
}
if ($_SESSION["LOGINAKS_MT"] != "Administrator" and $_SESSION["LOGINDEP_MT"] != "DEPT-0033" and $_SESSION["LOGINDEP_MT"] != "DEPT-0040" and $_SESSION["LOGINDEP_MT"] != "DEPT-0094" and $_SESSION["LOGINDEP_MT"] != "DEPT-0011" and $_SESSION["LOGINDEP_MT"] != "DEPT-0126") {
  http_response_code(404);
  die(0);
}
if (isset($_GET["KODE_BARANG"])) {
    $KODE_BARANG = $_GET["KODE_BARANG"];
    $result      = GetData1("*","m_barang","KODE_BARANG = '$KODE_BARANG'");
    while ($row  = $result->fetch(PDO::FETCH_ASSOC)) {
        $KODE_JENIS = $row["KODE_JENIS"];
    }
    if (($_SESSION["LOGINDEP_MT"] == "DEPT-0040"  and $KODE_JENIS != 2) or ($_SESSION["LOGINDEP_MT"] == "DEPT-0094"  and $KODE_JENIS != 3)) {
        http_response_code(404);
        die(0);
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
                <?php include "module/view/master/barang/v_tambahbarang.php"; ?>
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
        <script type="text/javascript" src="../plugins/parsley/js/parsley.js"></script>
        <script type="text/javascript" src="../javascript/backend/forms/element.js"></script>
        <!--/ Plugins and page level script : optional -->
        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!--/ END Body -->
</html>