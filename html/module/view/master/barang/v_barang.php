<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
{
    $where_clause = "";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") //IT
{
    $where_clause = "and b.KODE_JENIS = 1";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") //MEKANIK
{
    $where_clause = "and b.KODE_JENIS = 2";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") //CIVIL ENG
{
    $where_clause = "and b.KODE_JENIS = 4";
}
else
{
    $where_clause = "and b.KODE_JENIS = 3";
}

$result = GetQuery("select b.*, 
                           j.NAMA_JENIS,
                           i.KET 
                      from m_barang b
                           LEFT JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
                           LEFT JOIN m_itemtype i ON b.ITEM_TYPE = i.ITEM_TYPE 
                     where b.STATUS = 0 
                           $where_clause 
                     order by b.NAMA_BARANG");

?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-archive fa-lg"></i> Master Barang</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-archive fa-lg"></i> Barang</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_barang" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Barang</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Barang</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Opsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Kode Barang ACTS</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Item Type</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_barang?KODE_BARANG=<?php echo $row["KODE_BARANG"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;&nbsp;<a href="hapus_barang?KODE_BARANG=<?php echo $row["KODE_BARANG"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus request ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                            <td align="left"><?php echo $row["KODE_ACTS"]; ?></td>
                            <td align="left"><?php echo $row["NAMA_BARANG"]; ?></td>
                            <td align="left"><?php echo $row["NAMA_JENIS"]; ?></td>
                            <td align="left"><?php echo $row["KET"]; ?></td>
                            <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>