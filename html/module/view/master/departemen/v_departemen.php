<?php
$result = GetData1("d.*,p.NAMA_PERUSAHAAN,b.NAMA_BAGIAN","m_departemen d, m_perusahaan p, m_bagian b","d.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and d.KODE_BAGIAN = b.KODE_BAGIAN and d.STATUS = '1'");
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-cube3"></i> Master Departemen</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="ico-cube3"></i> Departemen</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_departemen" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Departemen</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Departemen</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Perusahaan</th>
                        <th>Divisi</th>
                        <th>Nama Departemen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_departemen?KODE_DEPARTEMEN=<?php echo $row["KODE_DEPARTEMEN"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a></td>
                            <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_BAGIAN"]; ?></td>
                            <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><input type="search" class="form-control hidden" name="search_engine" disabled=""></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Perusahaan"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Divisi"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Departemen"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>