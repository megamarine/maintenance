<?php
$result = GetData("*","m_perusahaan");
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-office"></i> Master Perusahaan</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="ico-office"></i> Perusahaan</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_perusahaan" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Perusahaan</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Perusahaan</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_perusahaan?KODE_PERUSAHAAN=<?php echo $row["KODE_PERUSAHAAN"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a></td>
                            <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["ALAMAT_PERUSAHAAN"]; ?></td>
                            <td align="center"><?php echo $row["NO_TELP"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><input type="search" class="form-control hidden" name="search_engine" disabled=""></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Nama"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Alamat"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="No. Telp"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>