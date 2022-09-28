<?php
$query = "select * from m_jabatan";
$result = mysql_query($query, $DB1);
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="ico-tree5"></i> Master Jabatan</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="ico-tree5"></i> Jabatan</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_jabatan.php" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Jabatan</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Jabatan</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Nama Jabatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysql_fetch_array($result)) {
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_jabatan.php?KODE_JABATAN=<?php echo $row["KODE_JABATAN"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a></td>
                            <td align="center"><?php echo $row["NAMA_JABATAN"]; ?></td>
                            <td align="center"><?php echo $row["STATUS_JAB"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><input type="search" class="form-control hidden" name="search_engine" disabled=""></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Jabatan"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Status"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>