<?php
require_once ("module/model/koneksi/koneksi.php");

if(!isset($_SESSION["LOGINIDUS_MT"]))
{
    ?><script>alert('Silahkan login dahulu');</script><?php
    ?><script>document.location.href='index';</script><?php
    die(0);
}

header("Refresh:600");
if (isset($_POST["cari"])) 
{
    $PERIODE  = $_POST["PERIODE"];
    $PERIODE2 = $_POST["PERIODE2"];
} else {
    $PERIODE = "";
    $PERIODE2 = "";
}


?>
<!DOCTYPE html>
<html class="backend">
    <!-- START Head -->
    <head>
        <?php include "module/model/head/head.php"; ?>    
        <style>
            .state {
                border: none;
                color: white;
                width: 50px;
                padding-top: 3px;
                padding-bottom: 2px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 8px;
                margin: 4px 2px;
                cursor: pointer;
                align-items: center;
            }
            .state1 {background-color: #008CBA;} /* Blue */
            .state2 {background-color: #f44336;} /* Red */ 
            .state3 {background-color: #e7e7e7; color: black;} /* Gray */ 
        </style>
    </head>
    <!--/ END Head -->
    <!-- START Body -->
    <body>
        <!-- START Template Header -->
        <header id="header" class="navbar">
            <?php include "module/model/header/header.php"; ?>
        </header>
        <!--/ END Template Header -->

        <!-- START Template Sidebar (Left) -->
        <?php include "module/model/sidebar/sidebar.php"; ?>
        <!--/ END Template Sidebar (Left) -->
        <!-- START Template Container -->
        
        
<!--/ END modal-sm -->
        <!--/ END modal-sm -->
        <link rel="stylesheet" type="text/css" href="../plugins/DataTables-1.12.1/css/jquery.dataTables.min.css" ></link>
        <section id="main" role="main">
            <div class="page-header page-header-block">
                <div class="page-header-section">
                    <h4 class="title semibold"><i class="fa fa-wrench fa-lg"></i> Pengajuan Perbaikan Barang</h4>
                </div>
                <div class="page-header-section">
                    <!-- Toolbar -->
                    <div class="toolbar">
                        <ol class="breadcrumb breadcrumb-transparent nm">
                            <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                            <li class="active"><i class="fa fa-wrench fa-lg"></i> Pengajuan Perbaikan Barang</li>
                        </ol>
                    </div>
                    <!--/ Toolbar -->
                </div>
            </div>
            <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9">
                        <a href="tambah_pengajuanmt_new" type="button" class="btn btn-success"><i class="ico-plus2"></i> Tambah Pengajuan</a>
                    </div>
                    <div class="col-lg-3" align="right">
                        <a href="export_pengajuanmt.php?PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" class="btn btn-warning" style="color: black;"><i class="fa fa-print fa-lg"></i> Export Excel</a>
                    </div>                  
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-3">
                        <label for="PERIODE">Periode</label>
                        <input type="text" class="form-control" name="PERIODE" id="datepicker1" value="<?php echo $PERIODE; ?>" />
                </div>
                <div class="col-md-3">
                        <label for="PERIODE2" style="color: transparent;">.</label>
                        <input type="text" class="form-control" name="PERIODE2" id="datepicker2" value="<?php echo $PERIODE2; ?>" />
                </div>
                <div class="form-group">
                    <label style="color: transparent;">.</label><br>
                    <button type="button" id="cari" name="cari" class="btn btn-primary"><i class="fa fa-search-plus fa-lg"></i> Cari</button>
                </div>
            </div>       
        </div>
       
        <!-- START modal-sm -->
        <div id="addBookDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form id="form-tolak" role="form" action="" method="post" data-parsley-validate>
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3 class="semibold modal-title text-success">Tolak Permintaan</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="KETERANGAN">Alasan Penolakan <span class="text-danger">*</span></label>
                                <textarea class="form-control" required="" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Alasan Penolakan" data-parsley-required></textarea>
                            </div>  
                            <div class="form-group hidden">
                                <input type="text" class="form-control" required="" id="KODE_PERBAIKAN" name="KODE_PERBAIKAN" value="<?php echo $KODE_PERBAIKAN; ?>" data-parsley-required>
                            </div>   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo fa-lg"></i> Batal</button>
                            <button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- START modal-sm -->
        <div id="addBookDialog2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form id="form-reject" role="form" action="" method="post" data-parsley-validate>
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3 class="semibold modal-title text-success">Waiting List</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="KETERANGAN2">Keterangan <span class="text-danger">*</span></label>
                                <select name="KETERANGAN2" id="KETERANGAN2" required="" class="form-control" data-parsley-required>
                                    <option value="">Pilih Keterangan</option>
                                    <?php
                                    $result = GetQuery("select KETERANGANMT from param where KETERANGANMT is not null");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?php echo $row["KETERANGANMT"]; ?>"><?php echo $row["KETERANGANMT"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estimasi">Estimasi <span class="text-danger">*</span></label>
                                <textarea class="form-control"  name="ESTIMASI" id="ESTIMASI" rows="6" placeholder="Estimasi"></textarea>
                            </div>  
                            <div class="form-group hidden">
                                <input type="text" class="form-control" required="" id="KODE_PERBAIKAN" name="KODE_PERBAIKAN" data-parsley-required>
                            </div>   
                            <br><br><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo fa-lg"></i> Batal</button>
                            <button type="submit" name="save-reject" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--/ END modal-sm -->
        <div class="container-fluid">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                        <th>Kode</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Tgl Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Opsi</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                        <th>Kode</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Tgl Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         <!-- START To Top Scroller -->
         <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->
        </section>
        <?php include "module/model/footer/footer.php"; ?>

        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Application and vendor script : mandatory -->
        <script type="text/javascript" src="../javascript/vendor.js"></script>
        <script type="text/javascript" src="../javascript/core.js"></script>
        <script type="text/javascript" src="../javascript/backend/app.js"></script>
        
        <!--/ Application and vendor script : mandatory -->

        <!-- Plugins and page level script : optional -->
		<script type="text/javascript" src="../javascript/pace.min.js"></script>
        <script type="text/javascript" src="../plugins/selectize/js/selectize.js"></script>
        <script type="text/javascript" src="../plugins/jquery-ui/js/jquery-ui.js"></script>
        <script type="text/javascript" src="../plugins/jquery-ui/js/addon/timepicker/jquery-ui-timepicker.js"></script>
        <script type="text/javascript" src="../plugins/jquery-ui/js/jquery-ui-touch.js"></script>
        <script type="text/javascript" src="../plugins/inputmask/js/inputmask.js"></script>
        <script type="text/javascript" src="../plugins/select2/js/select2.js"></script>
        <script type="text/javascript" src="../plugins/touchspin/js/jquery.bootstrap-touchspin.js"></script>
        <script type="text/javascript" src="../javascript/backend/forms/element.js"></script>
		<script type="text/javascript" src="../plugins/DataTables-1.12.1/js/jquery.dataTables.min.js"></script>
        
        <script type="text/javascript">
            

            $(document).ready(function () {
               var table = $('#example').DataTable({
                        ajax: {
                            url: 'api/api_maintenance',
                            dataType: "json",
                            type: "POST",
                            data: function (d) {
                                return $.extend( {}, d, {
                                    awal: $("#datepicker1").val(),
                                    akhir : $("#datepicker2").val(),
                                });
                            }
                        },
                        processing: true,
                        search: {
                            return: true,
                        },
                        serverSide: true,
                        scrollX: true, 
                        columns: [
                            {
                                data: 'action',
                            },
                            {data: 'state'},
                            {data: 'teknisi'},
                            {data: 'code'},
                            {data: 'company'},
                            {data: 'department'},
                            {data: 'start'},
                            {data: 'item'},
                            {data: 'lokasi'},
                            {data: 'jenis'},
                        ],                      
                    });
                
                $("#cari").click(function() {
                    table.ajax.reload();               
                });
            //reject Form        
                $( "#form-reject" ).submit(function( event ) {
                    event.preventDefault();
                    $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                reject: true,
                                KETERANGAN2: $('#KETERANGAN2').val(),
                                ESTIMASI: $('#ESTIMASI').val(),
                                KODE_PERBAIKAN: $('#KODE_PERBAIKAN').val(),
                            }
                        }).done(function(data) {
                            table.ajax.reload();
                            $('#addBookDialog2').modal('hide');
                            $.ajax({
                                type: 'POST',
                                url: 'api/api_mekanik',
                                data: {
                                    send_mail: true,
                                    KODE_PERBAIKAN: $('#KODE_PERBAIKAN').val(),
                                    STATE: "Pending",
                                }
                            }).done(function(data){
                                console.log(data);
                            }).fail(function (jqXHR, textStatus, error) {
                                // Handle error here
                                console.log(error);
                            });
                        });
                });

            //tolak Form    
                $("#form-tolak").submit(function(event) {
                    event.preventDefault();
                    $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                tolak: true,
                                KETERANGAN: $('#KETERANGAN').val(),
                                KODE_PERBAIKAN: $('#KODE_PERBAIKAN').val(),
                            }
                        }).done(function(data) {
                            table.ajax.reload();
                            $('#addBookDialog').modal('hide');
                        });
                })
                
                $(document).on("click", ".refprint", function () {
                    table.ajax.reload();    
                });
                
                $(document).on("click", ".open-AddBookDialog", function () {
                    var myBookId = $(this).data('id');
                    $(".modal-body #KODE_PERBAIKAN").val( myBookId );
                });
                $(document).on("click", ".open-AddBookDialog2", function () {
                    var myBookId2 = $(this).data('id');
                    const ket2 = $(this).data('ket2').replace(/\u00a0/g, " ");
                    const est = $(this).data('est');
                    $(".modal-body #KODE_PERBAIKAN").val( myBookId2 );
                    $("#addBookDialog2 #KETERANGAN2").val(ket2);
                    $("#addBookDialog2 #ESTIMASI").val( $(this).data('est'));
                });
            })

            function refresh() {    
                setTimeout(function () {
                    location.reload()
                }, 100);
            }     
        
        </script>
        <!--/ Plugins and page level script : optional -->
        <!--/ END JAVASCRIPT SECTION -->
    </body>
</html>