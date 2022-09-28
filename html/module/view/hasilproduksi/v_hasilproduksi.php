<?php
$result = GetQuery("select *,DATE_FORMAT(TANGGAL_HPROD, '%d %M %Y') as TANGGAL_HPROD from t_hprod where STS_AKTIF = 0");
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-balance-scale fa-lg"></i> Hasil Produksi</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fas fa-balance-scale fa-lg"></i> Hasil Produksi</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <a href="tambah_hasilproduksi" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Hasil Produksi</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Hasil Produksi</h3>
            </div>
            <table class="table table-striped table-bordered" id="column-filtering">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Tanggal</th>
                        <th>Bagian</th>
                        <th>Hasil Per Bagian</th>
                        <th>Total Produksi</th>
                        <th>Defect Mesin</th>
                        <th>Listrik (kWh)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        ?>
                        <tr>
                            <td align="center"><a href="tambah_hasilproduksi?ID_HPROD=<?php echo $row["ID_HPROD"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a><br><a href="hapus_hasilproduksi?ID_HPROD=<?php echo $row["ID_HPROD"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus request ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                            <td align="center"><?php echo $TANGGAL_HPROD; ?></td>
                            <td align="center"><?php echo $BAGIAN; ?></td>
                            <td align="center"><?php echo $HASIL; ?></td>
                            <td align="center"><?php echo $TOTAL_PROD; ?></td>
                            <td align="center"><?php echo $DEFECT; ?></td>
                            <td align="center"><?php echo $LISTRIK; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>