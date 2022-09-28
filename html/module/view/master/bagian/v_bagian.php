<?php
$result = GetData1("b.*,p.NAMA_PERUSAHAAN","m_bagian b, m_perusahaan p","b.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and b.STATUS = '1'");
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-cube4"></i> Master Divisi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="ico-cube4"></i> Divisi</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_bagian" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Divisi</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Divisi</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Perusahaan</th>
                        <th>Grup Manajemen</th>
                        <th>Divisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_bagian?KODE_BAGIAN=<?php echo $row["KODE_BAGIAN"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a></td>
                            <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["GROUP_MANAGEMENT"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_BAGIAN"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><input type="search" class="form-control hidden" name="search_engine" disabled=""></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Perusahaan"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Manajemen"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Divisi"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>