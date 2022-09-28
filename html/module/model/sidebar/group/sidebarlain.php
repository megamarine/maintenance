<?php
$KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
$result = GetData1("count(KODE_PERBAIKAN) as COUNT","t_perbaikan","KODE_DEPARTEMEN = '$KODE_DEPARTEMEN' and STATUS = 0 and STATUS_HAPUS = 0");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $COUNT = $row["COUNT"];
}
?>
<aside class="sidebar sidebar-left sidebar-menu">
	<!-- START Sidebar Content -->
    <section class="content slimscroll">
		<!-- START Template Navigation/Menu -->
        <ul class="topmenu topmenu-responsive" data-toggle="menu">
            <li>
                <a href="menuutama" data-target="#dashboard" data-parent=".topmenu">
                    <span class="figure"><i class="ico-home2"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li >
                <a href="pengajuanmt" data-target="#maintenance" data-toggle="submenu" data-parent=".topmenu">
                    <span class="figure"><i class="fa fa-wrench fa-lg"></i></span>
                    <span class="text">Maintenance</span>
                    <span class="number"><span class="label label-danger"><?php echo $COUNT; ?></span></span>
                </a>
                <!--/ END 2nd Level Menu -->
            </li>
            <li >
                <a href="javascript:void(0);" data-target="#laporan" data-toggle="submenu" data-parent=".topmenu">
                    <span class="figure"><i class="fa fa-paste fa-lg"></i></span>
                    <span class="text">Laporan</span>
                    <span class="arrow"></span>
                </a>
                <!-- START 2nd Level Menu -->
                <ul id="laporan" class="submenu collapse ">
                    <li class="submenu-header ellipsis">Laporan</li>
                    <li >
                        <a href="laporanmaintenance">
                            <span class="text">Maintenance</span>
                        </a>
                    </li>
                </ul>
                <!--/ END 2nd Level Menu -->
            </li>
		</ul>
        <!--/ END Template Navigation/Menu -->
    </section>
    <!--/ END Sidebar Container -->
</aside>