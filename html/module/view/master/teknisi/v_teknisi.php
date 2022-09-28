<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") {
    $result = GetQuery("select t.*,j.NAMA_JENIS, p.NAMA_PERUSAHAAN from m_teknisi t, m_jenisbrg j, m_perusahaan p where t.KODE_JENIS = j.KODE_JENIS and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN");
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") {
    $result = GetQuery("select t.*,j.NAMA_JENIS, p.NAMA_PERUSAHAAN from m_teknisi t, m_jenisbrg j, m_perusahaan p where t.KODE_JENIS = j.KODE_JENIS and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and t.KODE_JENIS = 2");
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") {
    $result = GetQuery("select t.*,j.NAMA_JENIS, p.NAMA_PERUSAHAAN from m_teknisi t, m_jenisbrg j, m_perusahaan p where t.KODE_JENIS = j.KODE_JENIS and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and t.KODE_JENIS = 4");
}
else{
    $result = GetQuery("select t.*,j.NAMA_JENIS, p.NAMA_PERUSAHAAN from m_teknisi t, m_jenisbrg j, m_perusahaan p where t.KODE_JENIS = j.KODE_JENIS and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and t.KODE_JENIS = 3");
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-address-card fa-lg"></i> Master Teknisi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fas fa-address-card fa-lg"></i></i> Teknisi</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_teknisi" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Teknisi</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Teknisi</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>ID Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Hari Kerja</th>
                        <th>Jam Kerja</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_teknisi?KODE_TEKNISI=<?php echo $row["KODE_TEKNISI"]; ?>" class="btn btn-teal mb5"><i class="fa fa-edit "></i></a>&nbsp;<a href="hapus_teknisi?KODE_TEKNISI=<?php echo $row["KODE_TEKNISI"]; ?>" class="btn btn-danger mb5" onclick="return confirm('Hapus data ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                            <td align="center"><?php echo $row["ID_KARYAWAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_TEKNISI"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_JENIS"]; ?></td>
                            <td align="center"><?php echo $row["JABATAN"]; ?></td>
                            <td align="center"><?php echo $row["HARI_KERJA"]; ?></td>
                            <td align="center"><?php echo $row["JAM_KERJA"]; ?></td>
                            <?php
                            if ($row["STS_AKTIF"] == 0) {
                                ?>
                                <td align="center">Aktif</td>
                                <?php
                            } else {
                                ?>
                                <td align="center">Tidak Aktif</td>
                                <?php
                            }
                            
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