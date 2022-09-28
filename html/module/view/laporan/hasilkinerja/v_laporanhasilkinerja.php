<?php
if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") { //it
    $KODE_JENIS = 1;
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") { //eng
    $KODE_JENIS = 2;
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") { //civil eng
    $KODE_JENIS = 4;
}
else{
    $KODE_JENIS = 3;
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-file fa-lg"></i> Laporan Hasil Kinerja</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-file fa-lg"></i> Laporan Hasil Kinerja</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Hasil Kinerja Karyawan</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Nama Perusahaan</th>
                        <th>Kode Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SESSION["LOGINAKS_MT"] == "Administrator") {
                        $result = GetQuery("select t.KODE_TEKNISI,t.NAMA_TEKNISI,p.NAMA_PERUSAHAAN,t.ID_KARYAWAN,t.JABATAN,sum(b.HASIL) / count(b.KODE_PERBAIKAN) as RATA from d_perbaikan d, m_teknisi t, m_perusahaan p, t_perbaikan b where d.KODE_TEKNISI = t.KODE_TEKNISI and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and d.KODE_PERBAIKAN = b.KODE_PERBAIKAN and d.STS_HAPUS = 0 and b.STATUS_HAPUS = 0 and b.HASIL is not null group by d.KODE_TEKNISI");
                    } else {
                        $result = GetQuery("select t.KODE_TEKNISI,t.NAMA_TEKNISI,p.NAMA_PERUSAHAAN,t.ID_KARYAWAN,t.JABATAN,sum(b.HASIL) / count(b.KODE_PERBAIKAN) as RATA from d_perbaikan d, m_teknisi t, m_perusahaan p, t_perbaikan b where d.KODE_TEKNISI = t.KODE_TEKNISI and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and d.KODE_PERBAIKAN = b.KODE_PERBAIKAN and d.STS_HAPUS = 0 and b.STATUS_HAPUS = 0 and b.HASIL is not null and t.KODE_JENIS = '$KODE_JENIS' group by d.KODE_TEKNISI");
                    }
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        ?>
                        <tr>
                            <td align="center"><a href="laporandetilkinerja?KODE_TEKNISI=<?php echo $KODE_TEKNISI; ?>" class="btn btn-rounded btn-success mb5"><i class="fa fa-edit fa-lg"></i></a></td>
                            <td align="center"><?php echo $NAMA_PERUSAHAAN; ?></td>
                            <td align="center"><?php echo $ID_KARYAWAN; ?></td>
                            <td align="center"><?php echo $NAMA_TEKNISI; ?></td>
                            <td align="center"><?php echo $JABATAN; ?></td>
                            <td align="center">
                                <?php
                                if ($RATA > 4) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png">
                                    <?php
                                } elseif ($RATA > 3) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png">
                                    <?php
                                } elseif ($RATA > 2) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                } elseif ($RATA > 1) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                }
                                elseif ($RATA > 0) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                } else {
                                    ?>
                                    <img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                }
                                ?>
                            </td>
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