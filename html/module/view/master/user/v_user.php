<?php
$KODE_BAGIAN = $_SESSION["LOGINBAG_MT"];
if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
{
    $result = GetData1(
       "u.*,
        p.NAMA_PERUSAHAAN,
        b.NAMA_BAGIAN,
        d.NAMA_DEPARTEMEN",
       "m_user u, 
        m_perusahaan p, 
        m_bagian b, 
        m_departemen d",
       "u.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        u.KODE_BAGIAN = b.KODE_BAGIAN and 
        u.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN");
}
elseif ($_SESSION["LOGINAKS_MT"] == "Manajer") 
{
    $result = GetData1(
       "u.*,
        p.NAMA_PERUSAHAAN,
        b.NAMA_BAGIAN,
        d.NAMA_DEPARTEMEN,
        j.NAMA_JABATAN",
       "m_user u, 
        m_perusahaan p, 
        m_bagian b, 
        m_departemen d, 
        m_jabatan j",
       "u.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        u.KODE_BAGIAN = b.KODE_BAGIAN and 
        u.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
        u.KODE_JABATAN = j.KODE_JABATAN and 
        u.AKSES != 'Administrator' and 
        u.KODE_BAGIAN = '$KODE_BAGIAN'");
}
else
{
    $result = GetData1(
       "u.*,
        p.NAMA_PERUSAHAAN,
        b.NAMA_BAGIAN,
        d.NAMA_DEPARTEMEN,
        j.NAMA_JABATAN",
       "m_user u, 
        m_perusahaan p, 
        m_bagian b, 
        m_departemen d, 
        m_jabatan j",
       "u.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        u.KODE_BAGIAN = b.KODE_BAGIAN and 
        u.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
        u.KODE_JABATAN = j.KODE_JABATAN and 
        u.AKSES != 'Administrator'");
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-group"></i> Master User</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="ico-group"></i> User</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_user" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah User</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar User</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Perusahaan</th>
                        <th>Divisi</th>
                        <th>Departemen</th>
                        <th>Nama</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_user?KODE_USER=<?php echo $row["KODE_USER"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a></td>
                            <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_BAGIAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
                            <td><?php echo $row["NAMA_USER"]; ?></span></td>
                            <td align="center"><?php echo $row["STATUS"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>