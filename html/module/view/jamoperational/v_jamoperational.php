<?php

$PERIODE       = date("Y-m-01");
$PERIODE2      = date("Y-m-d");

if (isset($_POST["cari"])) 
{
    $PERIODE       = $_POST["PERIODE"];
    $PERIODE2      = $_POST["PERIODE2"];
}

$result = GetQuery("select a.*, 
                           b.NAMA_BARANG,
                           c.NAMA_UNIT 
                      from t_jamopr a 
                           LEFT JOIN m_barang b ON b.KODE_BARANG = a.KODE_BARANG
                           LEFT JOIN m_unit c ON c.KODE_BARANG = a.KODE_BARANG
                     where c.KODE_UNIT = a.KODE_UNIT AND 
                           a.TANGGAL between '$PERIODE' and '$PERIODE2'
                  order by a.KODE_TRANS desc");
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-cogs fa-lg"></i> Jam Operational Mesin</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-cogs fa-lg"></i> Jam Operational Mesin</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                    <a href="tambah_jamoperational" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Jam Operational</a>
            </div>                    
        </div>
        <br/>
    </div>
</div> -->

<form role="form" action="" method="post">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="PERIODE">Periode</label>
                <input type="text" class="form-control" name="PERIODE" id="datepicker1" value="<?php echo $PERIODE; ?>" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="PERIODE2" style="color: transparent;">.</label>
                <input type="text" class="form-control" name="PERIODE2" id="datepicker2" value="<?php echo $PERIODE2; ?>" />
            </div>
        </div>
        <div class="form-group">
            <label style="color: transparent;">.</label><br>
            <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-search-plus fa-lg"></i> Cari</button>&nbsp;&nbsp;&nbsp;
            <!-- <a href="laporanengineering" type="button" class="btn btn-danger"><i class="fa fa-refresh fa-lg"></i> Clear</a> -->
        </div>       
    </div>
</form>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Jam Operational Mesin</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Nama Unit</th>
                        <th>Jam Operational (*Jam)</th>
                        <!-- <th>Keterangan</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td align="center">
                                <a href="tambah_jamoperational?KODE_TRANS=<?php echo $row["KODE_TRANS"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a>&nbsp;
                                <a href="hapus_jamoperational?KODE_TRANS=<?php echo $row["KODE_TRANS"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus request ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                            <td align="left"><?php echo $row["TANGGAL"]; ?></td>
                            <td align="left"><?php echo $row["NAMA_BARANG"]; ?></td>
                            <td align="left"><?php echo $row["NAMA_UNIT"]; ?></td>
                            <td align="left"><?php echo $row["JAM_OPR"]; ?></td>
                            <!-- <td align="left"><?php echo $row["KETERANGAN"]; ?></td> -->
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><input type="search" class="form-control hidden" name="search_engine" disabled=""></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Tanggal"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Nama Barang"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Unit Barang"></th>
                        <th><input type="search" class="form-control" name="search_engine" placeholder="Jam Operational"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $(function(){
        // Find any date inputs and override their functionality
        $('#datepicker1').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>