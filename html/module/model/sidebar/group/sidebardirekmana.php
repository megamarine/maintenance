<?php
$GROUP_MANAGEMENT = $_SESSION["LOGINGRP_MT"];
$query = "select count(p.KODE_PTK) as COUNT from t_ptk p, m_bagian b where p.KODE_BAGIAN = b.KODE_BAGIAN and p.APP_DIREKTUR1 = 0 and b.GROUP_MANAGEMENT = '$GROUP_MANAGEMENT'";
$result = mysql_query($query, $DB1);
while ($row = mysql_fetch_array($result)) {
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
            <li class="active open">
                <a href="javascript:void(0);" data-target="#components" data-toggle="submenu" data-parent=".topmenu">
                    <span class="figure"><i class="ico-users5"></i></span>
                    <span class="text">Rekrutmen</span>
                    <span class="number"><span class="label label-danger"><?php echo $COUNT; ?></span></span>
                    <span class="arrow"></span>
                </a>
                <!-- START 2nd Level Menu -->
                <ul id="components" class="submenu collapse ">
                    <li class="submenu-header ellipsis">Rekrutmen</li>
                    <li >
                        <a href="pengajuanptk.php">
                            <span class="text">Permintaan <br> Tenaga Kerja (PTK)</span>
                            <span class="number"><span class="label label-success"><?php echo $COUNT; ?></span></span>
                        </a>
                    </li>
                </ul>
                <!--/ END 2nd Level Menu -->
            </li>
            <li >
                <a href="javascript:void(0);" data-target="#maintenance" data-toggle="submenu" data-parent=".topmenu">
                    <span class="figure"><i class="fa fa-wrench fa-lg"></i></span>
                    <span class="text">Maintenance</span>
                    <span class="number"><span class="label label-danger">5</span></span>
                    <span class="arrow"></span>
                </a>
                <!-- START 2nd Level Menu -->
                <ul id="maintenance" class="submenu collapse ">
                    <li class="submenu-header ellipsis">Maintenance</li>
                    <li >
                        <a href="pengajuanmt">
                            <span class="text">Permintaan <br> Perbaikan Barang</span>
                            <span class="number"><span class="label label-success">5</span></span>
                        </a>
                    </li>
                </ul>
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
                        <a href="laporanptk.php">
                            <span class="text">Permintaan <br> Tenaga Kerja (PTK)</span>
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