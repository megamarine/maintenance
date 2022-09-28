<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
{
    $result = GetQuery("select a.*,
                               b.NAMA_BARANG,
                               b.KODE_JENIS
                          from m_unit a, 
                               m_barang b 
                         where a.KODE_BARANG = b.KODE_BARANG AND 
                               a.STATUS = '0'");
}
// IT
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
{
    $result = GetQuery("select a.*,
                               b.NAMA_BARANG,
                               b.KODE_JENIS
                          from m_unit a, 
                               m_barang b 
                         where a.KODE_BARANG = b.KODE_BARANG AND 
                               a.STATUS = '0' AND
                               b.KODE_JENIS = '1'");
}
// MEKANIK
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
{
    $result = GetQuery("select a.*,
                               b.NAMA_BARANG,
                               b.KODE_JENIS
                          from m_unit a, 
                               m_barang b 
                         where a.KODE_BARANG = b.KODE_BARANG AND 
                               a.STATUS = '0' AND
                               b.KODE_JENIS = '2'");
}
// CIVIL
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") 
{
    $result = GetQuery("select a.*,
                               b.NAMA_BARANG,
                               b.KODE_JENIS
                          from m_unit a, 
                               m_barang b 
                         where a.KODE_BARANG = b.KODE_BARANG AND 
                               a.STATUS = '0' AND
                               b.KODE_JENIS = '4'");
}
else
{
    $result = GetQuery("select a.*,
                               b.NAMA_BARANG,
                               b.KODE_JENIS
                          from m_unit a, 
                               m_barang b 
                         where a.KODE_BARANG = b.KODE_BARANG AND 
                               a.STATUS = '0' AND
                               b.KODE_JENIS = '3'");
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-archive fa-lg"></i> Master Unit Barang</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-archive fa-lg"></i> Unit Barang</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_unit" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Unit Barang</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Unit Barang</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Nama Barang</th>
                        <th>Nama Unit</th>
                        <th>Merk</th>
                        <th>Type</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_unit?KODE_UNIT=<?php echo $row["KODE_UNIT"]; ?>&KODE_BARANG=<?php echo $row["KODE_BARANG"];?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;&nbsp;<a href="hapus_unit?KODE_UNIT=<?php echo $row["KODE_UNIT"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus unit ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                            <td align=""><?php echo $row["NAMA_BARANG"]; ?></td>
                            <td align=""><?php echo $row["NAMA_UNIT"]; ?></td>
                            <td align=""><?php echo $row["MERK"]; ?></td>
                            <td align=""><?php echo $row["TYPE"]; ?></td>
                            <td align=""><?php echo $row["LOKASI"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>