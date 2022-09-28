<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
{
    $result = GetQuery(
       "select h.*,
        t.ID_KARYAWAN,
        t.NAMA_TEKNISI,
        t.JABATAN,
        j.NAMA_JENIS,
        p.NAMA_PERUSAHAAN,
        DATE_FORMAT(h.TANGGAL, '%d %M %Y') as TANGGAL 
        from t_kehadiran h, 
        m_teknisi t, 
        m_perusahaan p, 
        m_jenisbrg j 
       where h.KODE_TEKNISI = t.KODE_TEKNISI and 
        t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        t.KODE_JENIS = j.KODE_JENIS and 
        h.STATUS_ABSENSI = 0 
       order by h.TANGGAL desc");
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
{
    $result = GetQuery(
       "select h.*,
        t.ID_KARYAWAN,
        t.NAMA_TEKNISI,
        t.JABATAN,
        j.NAMA_JENIS,
        p.NAMA_PERUSAHAAN,
        DATE_FORMAT(h.TANGGAL, '%d %M %Y') as TANGGAL 
       from t_kehadiran h, 
        m_teknisi t, 
        m_perusahaan p, 
        m_jenisbrg j 
       where h.KODE_TEKNISI = t.KODE_TEKNISI and 
        t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        t.KODE_JENIS = j.KODE_JENIS and 
        t.KODE_JENIS = 2 and 
        h.STATUS_ABSENSI = 0 
       order by h.TANGGAL desc");
}
else
{
    $result = GetQuery(
       "select h.*,
        t.ID_KARYAWAN,
        t.NAMA_TEKNISI,
        t.JABATAN,
        j.NAMA_JENIS,
        p.NAMA_PERUSAHAAN,
        DATE_FORMAT(h.TANGGAL, '%d %M %Y') as TANGGAL 
       from t_kehadiran h, 
        m_teknisi t, 
        m_perusahaan p, 
        m_jenisbrg j 
       where h.KODE_TEKNISI = t.KODE_TEKNISI and 
        t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        t.KODE_JENIS = j.KODE_JENIS and 
        t.KODE_JENIS = 3 and 
        h.STATUS_ABSENSI = 0 
       order by h.TANGGAL desc");
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-user-circle fa-lg"></i> Kehadiran Teknisi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-user-circle fa-lg"></i></i> Kehadiran Teknisi</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_kehadiran" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Absensi</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Absensi Teknisi</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th class="hidden"></th>
                        <th>Opsi</th>
                        <th>ID Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Tanggal</th>
                        <th>Absensi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td class="hidden"></td>
                            <td align="center"><a href="tambah_kehadiran?KODE_HADIR=<?php echo $row["KODE_HADIR"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a><br><a href="hapus_kehadiran?KODE_HADIR=<?php echo $row["KODE_HADIR"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus data ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                            <td align="center"><?php echo $row["ID_KARYAWAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_TEKNISI"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_JENIS"]; ?></td>
                            <td align="center"><?php echo $row["JABATAN"]; ?></td>
                            <td align="center"><?php echo $row["TANGGAL"]; ?></td>
                            <td align="center"><?php echo $row["ABSENSI"]; ?></td>
                            <td><?php echo $row["KETERANGAN"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>