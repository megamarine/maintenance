<?php
$result = GetData1("count(KODE_PERBAIKAN) as COUNT","t_perbaikan","STATUS = 0 and STATUS_HAPUS = 0");
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
                <li class="active open" >
                    <a href="javascript:void(0);" data-toggle="submenu" data-target="#layout" data-parent=".topmenu">
                        <span class="figure"><i class="ico-grid"></i></span>
                        <span class="text">Master</span>
                        <span class="arrow"></span>
                    </a>
                <!-- START 2nd Level Menu -->
                <ul id="layout" class="submenu collapse ">
                    <li class="submenu-header ellipsis">Master</li>
                    <li>
                        <a href="user">
                            <span class="text">User</span>
                        </a>
                    </li>
                    <li >
                        <a href="perusahaan">
                            <span class="text">Perusahaan</span>
                            <span class="number"></span>
                        </a>
                    </li>
                    <li >
                        <a href="bagian">
                            <span class="text">Divisi</span>
                            <span class="number"></span>
                        </a>
                    </li>
                    <li >
                        <a href="departemen">
                            <span class="text">Departemen</span>
                        </a>
                    </li>
                    <li>
                        <a href="teknisi">
                            <span class="text">Teknisi</span>
                        </a>
                    </li>
                    <li>
                        <a href="barang">
                            <span class="text">Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="unit">
                            <span class="text">Unit Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="sparepart">
                            <span class="text">Spare Part</span>
                        </a>
                    </li>
                </ul>
                <!--/ END 2nd Level Menu -->
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="submenu" data-target="#administrasi" data-parent=".topmenu">
                    <span class="figure"><i class="fas fa-edit fa-lg"></i></span>
                    <span class="text">Administrasi</span>
                    <span class="arrow"></span>
                </a>
                <ul id="administrasi" class="submenu collapse ">                
                    <li >
                        <a href="jamoperational">
                            <span class="text">Input Jam Operational</span>
                        </a>
                    </li>
                    <li >
                        <a href="hasilproduksi">
                            <span class="text">Hasil Produksi</span>
                        </a>
                    </li>
                    <li >
                        <a href="pengajuanproyek">
                            <span class="text">Proyek Baru</span>
                        </a>
                    </li>
                    <li >
                        <a href="pengajuanmt" data-target="#maintenance" data-toggle="submenu" data-parent=".topmenu">
                            <span class="text">Maintenance</span>
                            <span class="number"><span class="label label-danger"><?php echo $COUNT; ?></span></span>
                        </a>
                        <!--/ END 2nd Level Menu -->
                    </li>
                </ul>
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
                        <a href="laporanengineering">
                            <span class="text">Engineering</span>
                        </a>
                    </li>
                    <li >
                        <a href="laporanmaintenance">
                            <span class="text">Maintenance</span>
                        </a>
                    </li>
                    <li >
                        <a href="laporanhasilkinerja">
                            <span class="text">Hasil Kinerja</span>
                        </a>
                    </li>
                    <li >
                        <a href="laporansparepart">
                            <span class="text">Spare Part</span>
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