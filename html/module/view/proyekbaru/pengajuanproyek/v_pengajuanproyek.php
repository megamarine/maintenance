<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
{
    $result = GetData1(
       "k.*,
        b.NAMA_BARANG,
        p.NAMA_PERUSAHAAN,
        DATE_FORMAT(k.TGL_MULAI, '%d %M %Y') as TGL_MULAI,
        DATE_FORMAT(k.TGL_SELESAI, '%d %M %Y') as TGL_SELESAI",
       "t_proyekbaru k, 
        m_barang b, 
        m_perusahaan p",
       "k.KODE_BARANG = b.KODE_BARANG and 
        k.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN");
} 
else
{
    if ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
    {
        $KATEGORI = 1;
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
    {
        $KATEGORI = 2;
    }
    else
    {
        $KATEGORI = 3;
    }

    $result = GetData1(
       "k.*,
        b.NAMA_BARANG,
        p.NAMA_PERUSAHAAN,
        DATE_FORMAT(k.TGL_MULAI, '%d %M %Y') as TGL_MULAI,
        DATE_FORMAT(k.TGL_SELESAI, '%d %M %Y') as TGL_SELESAI",
       "t_proyekbaru k, 
        m_barang b, 
        m_perusahaan p",
       "k.KODE_BARANG = b.KODE_BARANG and 
        k.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
        k.STATUS_HAPUS = 0 and 
        k.KATEGORI = '$KATEGORI'");
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-pallet fa-lg"></i> Pengajuan Proyek Baru</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fas fa-pallet fa-lg"></i> Pengajuan Proyek Baru</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <a href="tambah_pengajuanproyek" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Proyek</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Proyek Baru</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Status</th>
                        <th>No. Proyek</th>
                        <th>Perusahaan</th>
                        <th>Lokasi</th>
                        <th>Proyek</th>
                        <th>Keterangan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Petugas</th>
                        <th>Hambatan</th>
                        <th>Keterangan Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td>
                                <div class="btn-group" style="margin-bottom:5px;">
                                    <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php
                                        if ($row["STATUS"] == 0) {
                                            ?>
                                            <li><a href="proses_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                                            <li><a href="tambah_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                                            <li class="divider"></li>
                                            <li><a href="hapus_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" onclick="return confirm('Hapus request ini ?')"" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><a href="tambah_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Lihat</a></li>
                                            <?php
                                        }
                                        
                                        ?>
                                    </ul>
                                </div>
                            </td>
                            <?php
                            if ($row["STATUS_HAPUS"] == 1) {
                                ?>
                                <td align="center" style="color: red;">Deleted</td>
                                <?php
                            }
                            elseif ($row["STATUS"] == 0) {
                                ?>
                                <td align="center" style="color: black;">In Progress</td>
                                <?php
                            }
                            elseif ($row["STATUS"] == 1) {
                                ?>
                                <td align="center" style="color: green;">Complete</td>
                                <?php
                            }
                            ?>
                            <td align="center"><?php echo $row["KODE_PROYEK"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["LOKASI"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_BARANG"]; ?></td>
                            <td><?php echo $row["KETERANGAN"]; ?></td>
                            <td align="center"><?php echo $row["TGL_MULAI"]; ?></td>
                            <td align="center"><?php echo $row["TGL_SELESAI"]; ?></td>
                            <td align="center"><?php echo $row["PETUGAS"]; ?></td>
                            <td><?php echo $row["HAMBATAN"]; ?></td>
                            <td><?php echo $row["KETERANGAN_SELESAI"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>