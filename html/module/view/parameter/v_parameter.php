<?php
include "module/controller/parameter/t_parameter.php"; 

$PERIODE    = date("Y-m-d");
$PERIODE2   = date("Y-m-d");

$result = GetQuery("select *,DATE_FORMAT(tanggal, '%d %M %Y') as tanggals from nonaktif_jamopr where tanggal >= '$PERIODE' order by tanggal desc");
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-share-alt fa-lg"></i> Tanggal Jam Operational Tidak Aktif</li></h4>
    </div>
    <div class="page-header-section">
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama.php"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-share-alt fa-lg"></i> Tanggal Jam Operational Tidak Aktif</a></li>
            </ol>
        </div>
    </div>
</div>

<h4 class="title semibold" align="center">Non Aktif-kan Penginputan Jam Operational Otomatis pada tanggal :</h4>

<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post" data-parsley-validate>
            <div class="row" >
                <div class="col-md-2">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="PERIODE">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="PERIODE" id="datepicker1" value="<?php echo $PERIODE; ?>" />
                    </div>                           
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="PERIODE2">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="PERIODE2" id="datepicker2" value="<?php echo $PERIODE2; ?>" />
                    </div>                           
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp&nbsp&nbsp
                    <a href="menuutama.php" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">List Jam Operational Tidak Aktif</h3>
            </div>            
                <table class="table table-striped table-bordered" id="table-tools">            
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                    {
                    ?>
                    <tr>
                        <td>
                            <a href="hapus_nonaktifjamopr?TANGGAL=<?php echo $row["tanggal"]; ?>" class="btn btn-danger mb5" onclick="return confirm('Hapus request ini ?')"><i class="fa fa-trash fa-lg"></i></a>
                        </td>
                        <td><?php echo $row["tanggals"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
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