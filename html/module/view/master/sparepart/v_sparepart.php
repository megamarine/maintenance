<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
{
    $whereclause = "";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
{   
    $whereclause = "and KODE_JENIS = '1'";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
{   
    $whereclause = "and KODE_JENIS = '2'";
}
else
{   
    $whereclause = "and KODE_JENIS = '3'";
}

$result = GetQuery("select * from m_sparepart where STS_AKTIF = 0 $whereclause");
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fas fa-cogs fa-lg"></i> Master Spare Part</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fas fa-cogs fa-lg"></i> Spare Part</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <a href="tambah_sparepart" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Spare Part</a>
            </div>                    
        </div>
        <br/>
    </div>
</div>
<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINAKS_MT"] == "Manajer") 
{
?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Spare Part</h3>
                </div>
                <table class="table table-striped table-bordered" id="table-tools">
                    <thead>
                        <tr>
                            <th>Opsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Spare Part</th>
                            <!-- <th>Umur</th> -->
                            <th>Stok</th>
                            <!-- <th>Stok Minimal</th> -->
                            <th>Harga Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            ?>
                            <tr>
                                <td align="center"><a href="tambah_sparepart?KODE_PART=<?php echo $row["KODE_PART"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;&nbsp;<a href="hapus_part?KODE_PART=<?php echo $row["KODE_PART"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus request ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                                <td align="left"><?php echo $NAMA_PART; ?></td>
                                <!-- <td align="center"><?php echo $LIFETIME_PART . " Hari"; ?></td> -->
                                <td align="center"><?php echo $STOK_PART; ?></td>
                                <!-- <td align="center"><?php echo $STOKMIN_PART; ?></td> -->
                                <td align="right"><?php echo number_format($HARGA_PART); ?></td>
                                <td><?php echo $KETERANGAN; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
} 
else 
{
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Spare Part</h3>
                </div>
                <table class="table table-striped table-bordered" id="table-tools">
                    <thead>
                        <tr>
                            <th>Opsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Spare Part</th>
                            <!-- <th>Umur</th> -->
                            <!-- <th>Stok</th> -->
                            <!-- <th>Stok Minimal</th> -->
                            <th>Harga Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                        {
                            extract($row);
                            ?>
                            <tr>
                                <td align="center"><a href="tambah_sparepart?KODE_PART=<?php echo $row["KODE_PART"]; ?>" class="btn btn-rounded btn-teal mb5"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;&nbsp;<a href="hapus_part?KODE_PART=<?php echo $row["KODE_PART"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus request ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                                <td align="left"><?php echo $NAMA_PART; ?></td>
                                <!-- <td align="center"><?php echo $LIFETIME_PART . " Hari"; ?></td> -->
                                <!-- <td align="center"><?php echo $STOK_PART; ?></td> -->
                                <!-- <td align="center"><?php echo $STOKMIN_PART; ?></td> -->
                                <td align="right"><?php echo number_format($HARGA_PART); ?></td>
                                <td><?php echo $KETERANGAN; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
}
?>