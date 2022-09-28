<?php
$PERIODE     = $_GET["periode"];
$PERIODE2    = $_GET["periode2"];
$kode_barang = $_GET["kode_barang"];
$date        = date_create("$PERIODE");
$date2       = date_create("$PERIODE2");

if($_GET["kode_unit"] != '')
{   
    $kode_unit = $_GET["kode_unit"];
    $qw = getQuery("select nama_unit from m_unit where kode_unit = '$kode_unit'");
    while ($row3 = $qw->fetch(PDO::FETCH_ASSOC)) 
    {
        $nama_unit = $row3["nama_unit"];
    }  
}
else
{
    $kode_unit = "";
    $nama_unit = "";
}

$q = getQuery("select nama_barang from m_barang where kode_barang = '$kode_barang'");
while ($row2 = $q->fetch(PDO::FETCH_ASSOC)) 
{
    $nama_barang = $row2["nama_barang"];
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-folder-open fa-lg"></i> Detail Laporan Engineering</h4>
    </div>
    <div class="page-header-section">
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="laporanengineering"><i class="fa fa-file"></i> Laporan Engineering</a></li>
                <li class="active"><i class="fa fa-folder-open"></i> Detail Laporan Engineering</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" align="center">
        <div class="btn-group" style="margin-bottom:5px;">
            <button type="button" class="btn btn-warning mb5 dropdown-toggle" data-toggle="dropdown" style="color: black;"><i class="fa fa-print fa-lg"></i> Export Laporan<span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <?php 
                if($kode_unit != '')
                {
                ?>
                    <li><a href="module\view\laporan\engineering\exexcel_detailengineering.php?KODE_BARANG=<?php echo $kode_barang;?>&KODE_UNIT=<?php echo $kode_unit; ?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Excel</a></li>
                <?php
                }
                else
                {
                ?>
                    <li><a href="module\view\laporan\engineering\exexcel_detailengineering.php?KODE_BARANG=<?php echo $kode_barang;?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Excel</a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $nama_barang;?> / <?php echo $nama_unit;?> / <?php echo date_format($date,'d F Y')." - ".date_format($date2,'d F Y'); ?></h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Tgl Perbaikan</th>
                        <th>Kode Perbaikan</th>
                        <th style="width: 200px">Nama Mesin</th>
                        <?php
                            if($kode_unit != '')
                            { ?>
                                <th style="width: 200pX">Nama Unit</th>
                            <?php }
                        ?>
                        <th>Teknisi</th>
                        <th>Sparepart yang digunakan</th>
                        <th>Harga /pcs</th>
                        <th>Qty Sparepart</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        if($kode_unit != '')
                        {
                            $result = getQuery(
                            "select a.KODE_PERBAIKAN,
                                    a.TGL_PERBAIKAN,
                                    b.KODE_PART,
                                    b.JUMLAH_PART,
                                    b.HARGA_PART,
                                    c.NAMA_PART,
                                    d.KODE_TEKNISI,
                                    e.NAMA_BARANG,
                                    f.NAMA_TEKNISI,
                                    g.NAMA_UNIT
                               from t_perbaikan a
                                    JOIN d_maintenance b ON a.KODE_PERBAIKAN = b.KODE_PERBAIKAN
                                    JOIN m_sparepart c ON b.KODE_PART = c.KODE_PART
                                    JOIN d_perbaikan d ON a.KODE_PERBAIKAN = d.KODE_PERBAIKAN
                                    JOIN m_barang e ON a.KODE_BARANG = e.KODE_BARANG
                                    JOIN m_teknisi f ON d.KODE_TEKNISI = f.KODE_TEKNISI
                                    JOIN m_unit g ON a.KODE_UNIT = g.KODE_UNIT
                              where a.status_hapus = '0' AND 
                                    b.sts_hapus = '0' AND
                                    a.KODE_BARANG = '$kode_barang' AND
                                    a.KODE_UNIT = '$kode_unit' AND 
                                    date_format(a.tgl_start,'%Y-%m-%d') BETWEEN '$PERIODE' AND '$PERIODE2'");
                        }
                        else
                        {
                            $result = getQuery(
                                "select a.KODE_PERBAIKAN,
                                        a.TGL_PERBAIKAN,
                                        b.KODE_PART,
                                        b.JUMLAH_PART,
                                        b.HARGA_PART,
                                        c.NAMA_PART,
                                        d.KODE_TEKNISI,
                                        e.NAMA_BARANG,
                                        f.NAMA_TEKNISI
                                   from t_perbaikan a
                                        JOIN d_maintenance b ON a.KODE_PERBAIKAN = b.KODE_PERBAIKAN
                                        JOIN m_sparepart c ON b.KODE_PART = c.KODE_PART
                                        JOIN d_perbaikan d ON a.KODE_PERBAIKAN = d.KODE_PERBAIKAN
                                        JOIN m_barang e ON a.KODE_BARANG = e.KODE_BARANG
                                        JOIN m_teknisi f ON d.KODE_TEKNISI = f.KODE_TEKNISI
                                  where a.status_hapus = '0' AND
                                        b.sts_hapus = '0' AND 
                                        a.KODE_BARANG = '$kode_barang' AND 
                                        date_format(a.tgl_start,'%Y-%m-%d') BETWEEN '$PERIODE' AND '$PERIODE2'");
                        }

                        $grandtot = 0;
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                        {
                            $subtotal = $row["HARGA_PART"]*$row["JUMLAH_PART"];
                            $grandtot += $subtotal;
                            $tgl      = date_create($row["TGL_PERBAIKAN"]);

                        ?>
                            <tr>
                                <td><?php echo date_format($tgl,'d F Y');?></td>
                                <td><?php echo $row["KODE_PERBAIKAN"];?></td>
                                <td><?php echo $row["NAMA_BARANG"];?></td>
                                <?php
                                    if($kode_unit != '')
                                    { ?>
                                        <td><?php echo $row["NAMA_UNIT"];?></td>
                                    <?php }
                                ?>
                                <td><?php echo $row["NAMA_TEKNISI"];?></td>
                                <td><?php echo $row["NAMA_PART"];?></td>
                                <td align="right"><?php echo number_format($row["HARGA_PART"],0);?></td>
                                <td align="right"><?php echo $row["JUMLAH_PART"];?></td>
                                <td align="right"><?php echo number_format($subtotal,0);?></td>
                            </tr>
                        <?php
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <?php
                            if($kode_unit != '')
                            { ?>
                                <th></th>
                            <?php }
                        ?>
                        <th></th>
                        <th></th>
                        <th></th>
                        <td align="right"><b>Grand Total</b></td>
                        <td align="right"><b><?php echo number_format($grandtot,0);?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" align="center">
        <button onclick="window.location.href='laporanengineering'" type="button" class="btn btn-primary mb5" ><i class="fa fa-arrow-left fa-lg"></i> Kembali</button>
    </div>
</div>


<script>
    $(function(){
        $('#datepicker1').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>