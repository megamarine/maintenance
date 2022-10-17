<?php include "module/controller/maintenance/pengajuanmt/t_pengajuanmt_new.php"; 

$result2 = GetQuery("select p.*,
                            t.NAMA_TEKNISI
                       from d_perbaikan p,
                            m_teknisi t
                      where p.KODE_TEKNISI = t.KODE_TEKNISI and
                            p.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and
                            p.STS_HAPUS = 0");

$result3 = GetQuery("select m.*,
                            s.NAMA_PART
                       from d_maintenance m,
                            m_sparepart s
                      where m.KODE_PART = s.KODE_PART and
                            m.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and
                            m.STS_HAPUS = 0");

$result4 = GetQuery("select *,
                            DATE_FORMAT(TGL_MULAI, '%d %M %Y') as TGL_PERBAIKAN,
                            DATE_FORMAT(TGL_MULAI, '%H:%i:%s') as JAM_PERBAIKAN
                       from d_progress
                      where KODE_PERBAIKAN = '$KODE_PERBAIKAN'
                   order by TGL_MULAI");
?>
<style>
    th.dt-center, 
    td.dt-center { text-align: center; }
    th.dt-right,
    td.dt-right {text-align: right;}
</style>
<script type="text/javascript">
    $(document).ready(function () {

        $('#perbaikan').hide();
        $('#save-perbaikan').hide();
       
        
        $('#STATUS_PERBAIKAN').change(function () {
            const status  = $(this).children("option:selected").val();
            if (status=='Belum'){
                $('#save-perbaikan').hide();
                $('#perbaikan').show();
            } else if (status=='Selesai') {
                $('#perbaikan').hide();
                $('#save-perbaikan').show();
            } else{
                $('#save-perbaikan').hide();
                $('#perbaikan').hide();
            }
        })

        // teknisi api
               var table = $('#user-table').DataTable({
                        ajax: {
                            url: 'api/api_mekanik',
                            dataType: "json",
                            type: "POST",
                            data: function (d) {
                                return $.extend( {}, d, {
                                    reload_user: true,
                                    kode_perbaikan: $('#kode_perbaikan').val(),
                                });
                            },
                        },
                        processing: true,
                        searching: false,
                        autoWidth: false,
                        columnDefs: [
                            { 
                            "className": "dt-center", 
                            "width": "200px",
                            "targets": [0],
                            "render": function ( data, type, row){
                                    return '<a data-id="'+row.action+'" id="deleteUsr" class="btn btn-rounded btn-danger" ><i class="fa fa-trash"></i></a>';
                                }
                            }
                        ],   
                        paging: false,
                        info: false,
                        serverSide: true,
                        columns: [
                            {data: 'action'},
                            {data: 'teknisi'},
                        ],                      
                    });

                    $(document).on('click', '#deleteUsr', function(event){
                        const teknisi = $(event.currentTarget).data('id');
                        $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                deleteUsr: true,
                                kode_perbaikan: $('#kode_perbaikan').val(),
                                kode_teknisi: teknisi,
                            },
                            success: function (data) {
                                table.ajax.reload();
                            }
                        });
                    })

                    $('#simpan_user').click(function (e) {
                        $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                save_user: true,
                                kode_perbaikan: $('#kode_perbaikan').val(),
                                kode_teknisi: $('#KODE_TEKNISI').val(),
                            },
                            success: function (data) {
                                table.ajax.reload();
                            }
                        });
                    });
                // sparepath    
                    var sparepart = $('#sparepart-table').DataTable({
                        ajax: {
                            url: 'api/api_mekanik',
                            dataType: "json",
                            type: "POST",
                            data: function (d) {
                                return $.extend( {}, d, {
                                    reload_sparepart: true,
                                    kode_perbaikan: $('#kode_perbaikan').val(),
                                });
                            },
                        },
                        processing: true,
                        searching: false,
                        autoWidth: false,
                        columnDefs: [
                            { 
                            "className": "dt-center", 
                            "width": "100px",
                            "targets": [0],
                            "render": function ( data, type, row){
                                    return '<a data-id="'+row.action+'" id="del_sparepart" class="btn btn-rounded btn-danger" ><i class="fa fa-trash"></i></a>';
                                }
                            },
                            { 
                                className: "dt-right",
                                targets: [2],
                                render: $.fn.dataTable.render.number(',', '.', 2, '')
                            }
                        ],   
                        paging: false,
                        info: false,
                        serverSide: true,
                        columns: [
                            {data: 'action'},
                            {data: 'name'},
                            {data: 'jumlah'},
                        ],                      
                    });

                    $('#save_sparepart').click(function (e) {
                        $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                save_sparepart: true,
                                JUMLAH_PART: $('#JUMLAH_PART').val(),
                                KODE_PART: $('#KODE_PART').val(),
                                KODE_PERBAIKAN: $('#kode_perbaikan').val(),
                            },
                            success: function (data) {
                               sparepart.ajax.reload();
                            }
                        });
                    });

                    $(document).on('click', '#del_sparepart', function(event){
                        const kode = $(event.currentTarget).data('id');
                        $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                delSparepart: true,
                                KODE_PART: kode,
                                KODE_PERBAIKAN: $('#kode_perbaikan').val(),
                            },
                            success: function (data) {
                                sparepart.ajax.reload();
                            }
                        });
                    })

                // perbaikan

                var repairing = $('#tbl-perbaikan').DataTable({
                        ajax: {
                            url: 'api/api_mekanik',
                            dataType: "json",
                            type: "POST",
                            data: function (d) {
                                return $.extend( {}, d, {
                                    reload_repairing: true,
                                    kode_perbaikan: $('#kode_perbaikan').val(),
                                });
                            },
                        },
                        processing: true,
                        searching: false,
                        autoWidth: false,
                        columnDefs: [
                            { 
                            className: "dt-center", 
                            width: "15%",
                            targets: [0],
                            render: function ( data, type, row){
                                    return '<a data-id="'+row.action+'" id="del-repair" class="btn btn-rounded btn-danger" ><i class="fa fa-trash"></i></a>';
                                }
                            },
                            { 
                                className: "dt-center",
                                width: "15%",
                                targets: [1],
                            },
                            { 
                                className: "dt-center",
                                width: "25%",
                                targets: [2],
                            },
                            { 
                                className: "dt-center",
                                width: "20%",
                                targets: [3],
                            },
                            { 
                                className: "dt-center",
                                width: "20%",
                                targets: [4],
                            },
                            { 
                                className: "dt-center",
                                width: "20%",
                                targets: [5],
                            }
                        ],   
                        paging: false,
                        info: false,
                        serverSide: true,
                        columns: [
                            {data: 'action'},
                            {data: 'teknisi'},
                            {data: 'date_from'},
                            {data: 'date_to'},
                            {data: 'durasi'},
                            {data: 'hasil'},
                        ],                      
                    });

                $('#add_task').click(function (e) {
                    e.preventDefault();
                    if ($('#KODE_TEKNISI').val() === ""){
                        alert("Teknisi Harus Diisi ");
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                tambahPerbaikan: true,
                                SOLUSI: $('#SOLUSI').val(),
                                SARAN: $('#SARAN').val(),
                                DURASI: $('#DURASI').val(),
                                KODE_TEKNISI: $('#KODE_TEKNISI').val(),
                                BAGIAN: $('#BAGIAN').val(),
                                TGL_START: $('#datepicker1').val()+' '+$('#time-picker').val(),
                                TGL_END: $('#datepicker2').val()+' '+$('#time-picker2').val(),
                                KODE_PERBAIKAN: $('#kode_perbaikan').val(),
                                
                            },
                            success: function (data) {
                                $('#SOLUSI').val("");
                                $('#SARAN').val("");
                                $('#DURASI').val("");
                                $('#BAGIAN').val("");
                                $('#datepicker1').val("");
                                $('#datepicker2').val("");
                                $('#time-picker').val("");
                                $('#time-picker2').val("");
                                repairing.ajax.reload();
                                table.ajax.reload();
                            }
                        });
                    }
                    });

                $(document).on('click', '#del-repair', function(event){
                        const kode = $(event.currentTarget).data('id');
                        $.ajax({
                            type: 'POST',
                            url: 'api/api_mekanik',
                            dataType: 'json',
                            data: {
                                delRepair: true,
                                KODE_DETAIL: kode,
                                KODE_PERBAIKAN: $('#kode_perbaikan').val(),
                            },
                            success: function (data) {
                                repairing.ajax.reload();
                            }
                        });
                    })

            //Save Form

            $("#form-perbaikan").submit(function(e) {

                    e.preventDefault(); // avoid to execute the actual submit of the form.
                    var form = $(this).serializeArray();
                    form.push({name: "simpan2", value: true});
                    $.ajax({
                        type: "POST",
                        url: 'api/api_mekanik',
                        data: $.param(form), // serializes the form's elements.
                    }).done(function(data) {
                        $.ajax({
                                type: 'POST',
                                url: 'api/api_mekanik',
                                data: {
                                    send_mail: true,
                                    KODE_PERBAIKAN: $('#kode_perbaikan').val(),
                                    STATE: "Selesai",
                                }
                            }).done(function(data){
                                console.log(data);
                                location.href = "v_mekanik";
                            }).fail(function (jqXHR, textStatus, error) {
                                // Handle error here
                                console.log(error);
                                location.href = "v_mekanik";
                            });
                        
                         // show response from the php script.
                    }).fail(function(){
                        alert("Failed, Please Try Again");
                    });

                });


        });

</script>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-wrench fa-lg"></i> Permintaan Perbaikan Barang</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="pengajuanmt"><i class="fa fa-wrench fa-lg"></i> Permintaan Perbaikan Barang</a></li>
                <li class="active"><i class="ico-plus2"></i> Proses Permintaan</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <hr>
        <form id="form-perbaikan" method="POST">
            <input id="kode_perbaikan" name="kode_perbaikan" type="hidden" value="<?php echo $KODE_PERBAIKAN; ?>"
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KODE_PERUSAHAAN">Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" readonly="" id="NAMA_PERUSAHAAN" name="NAMA_PERUSAHAAN" value="<?php echo $NAMA_PERUSAHAAN; ?>">
                    </div>                          
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KODE_BAGIAN">Divisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" readonly="" id="NAMA_BAGIAN" name="NAMA_BAGIAN" value="<?php echo $NAMA_BAGIAN; ?>">
                    </div>                          
                </div>   
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="KODE_DEPARTEMEN">Departemen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" readonly="" id="NAMA_DEPARTEMEN" name="NAMA_DEPARTEMEN" value="<?php echo $NAMA_DEPARTEMEN; ?>">
                    </div>                          
                </div>                           
            </div>
            <h3>Detail Kerusakan</h3>
            <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="NAMA_BARANG">Barang </label>
                            <input type="text" class="form-control" readonly="" id="NAMA_BARANG" name="NAMA_BARANG" value="<?php echo $NAMA_BARANG; ?>">
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="NAMA_UNIT">Unit Barang </label>
                            <input type="text" class="form-control" readonly="" id="NAMA_UNIT" name="NAMA_UNIT" value="<?php echo $NAMA_UNIT; ?>">
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="JUMBAR">Jumlah Barang </label>
                            <input type="text" class="form-control" readonly="" id="JUMBAR" name="JUMBAR" value="<?php echo $JUMBAR; ?>">
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="LOKASI">Lokasi Mesin </label>
                            <input type="text" class="form-control" readonly="" id="LOKASI" name="LOKASI" value="<?php echo $LOKASI; ?>">
                        </div> 
                    </div>            
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="DOWNTIME">Status Downtime </label>
                            <input type="text" class="form-control" readonly="" id="STATUS_DOWNTIME" name="STATUS_DOWNTIME" value="<?php echo $STATUS_DOWNTIME; ?>">
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="LAYANAN">Jenis Layanan </label>
                            <input type="text" class="form-control" readonly="" id="LAYANAN" name="LAYANAN" value="<?php echo $LAYANAN; ?>">
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KERUSAKAN">Kerusakan</label>
                            <textarea class="form-control" readonly="" name="KERUSAKAN" id="KERUSAKAN" rows="6" placeholder="Detail Kerusakan"><?php echo $KERUSAKAN; ?></textarea>
                        </div>                          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KETERANGAN">Keterangan</label>
                            <textarea class="form-control" readonly="" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan Lain"><?php echo $KETERANGAN; ?></textarea>
                        </div>                          
                    </div>
                </div>
            
                    <h3>Jadwal Perbaikan</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div>
                                    <label for="KODE_TEKNISI">User yang memperbaiki / Teknisi <span class="text-danger">*</span></label>
                                    <select name="KODE_TEKNISI" class="form-control" id="KODE_TEKNISI" required>
                                        <option value="">Pilih Karyawan</option>
                                        <?php
                                        if ($KODE_JENIS == 2) {
                                            $result = GetQuery("select * from m_teknisi where KODE_JENIS = '$KODE_JENIS' and KODE_PERUSAHAAN = '$KODE_PERUSAHAAN' and STS_AKTIF = 0 order by NAMA_TEKNISI");
                                        } else {
                                            $result = GetQuery("select * from m_teknisi where KODE_JENIS = '$KODE_JENIS' and STS_AKTIF = 0 order by NAMA_TEKNISI");
                                        }
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $row["KODE_TEKNISI"]; ?>"<?php if($KODE_TEKNISI == $row["KODE_TEKNISI"]) { echo "selected"; } ?>><?php echo $row["NAMA_TEKNISI"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>                         
                            </div>
                                
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" required id="datepicker1" autofocus="off" name="TGL_PERBAIKAN" placeholder="Select a date" value="<?php echo $TGL_PERBAIKAN; ?>" data-parsley-required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jam Mulai <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" id="time-picker" autofocus="off" name="JAM_PERBAIKAN" value="<?php echo $JAM_PERBAIKAN; ?>" placeholder="Select a time" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" required id="datepicker2" autofocus="off" name="TGL_SELESAI" placeholder="Select a date" value="<?php echo $TGL_SELESAI; ?>" data-parsley-required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jam Selesai <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" id="time-picker2" autofocus="off" name="JAM_SELESAI" value="<?php echo $JAM_SELESAI; ?>" placeholder="Select a time" />
                            </div>
                        </div>
                    </div>
                    <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="DURASI">Durasi Pengerjaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" autocomplete="off" required="" id="DURASI" name="DURASI" value="<?php echo $DURASI; ?>" data-parsley-required>
                        </div>
                    </div>
                   
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="BAGIAN">Bagian <span class="text-danger">*</span></label>
                                <select name="BAGIAN" id="BAGIAN" class="form-control" required="" data-parsley-required>
                                    <option value="">Pilih Bagian</option>
                                    <?php
                                    $result = GetQuery("select BAGIAN from param where BAGIAN != '' order by BAGIAN");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?php echo $row["BAGIAN"]; ?>"<?php if($BAGIAN == $row["BAGIAN"]) { echo "selected"; } ?>><?php echo $row["BAGIAN"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Status Pengerjaan <span class="text-danger">*</span></label>
                                <select name="STATUS_PERBAIKAN" id="STATUS_PERBAIKAN" class="form-control" required="" data-parsley-required>
                                    <option value="">Pilih Status</option>
                                    <?php
                                    $result = GetQuery("select STATUS_PERBAIKAN from param where STATUS_PERBAIKAN != ''");
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?php echo $row["STATUS_PERBAIKAN"]; ?>"<?php if($STATUS_PERBAIKAN == $row["STATUS_PERBAIKAN"]) { echo "selected"; } ?>><?php echo $row["STATUS_PERBAIKAN"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>  
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="SOLUSI">Hasil Perbaikan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="SOLUSI" id="SOLUSI" rows="6" autocomplete="off" required placeholder="Detail Hasil" data-parsley-required><?php echo $SOLUSI; ?></textarea>
                        </div>                          
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="SARAN">Saran</label>
                            <textarea class="form-control" name="SARAN" autocomplete="off" id="SARAN" rows="6" placeholder="Input Saran"><?php echo $SARAN; ?></textarea>
                        </div>                          
                    </div>
                    <div id="perbaikan" class="col-md-4">
                        <div>
                            <label style="color:transparent">.</label><br>
                            <button type="button" id="add_task" name="add_task"  class="btn btn-success"><i class="ico-plus2"></i> Tambah Perbaikan</button>
                        </div>         
                    </div>
                    <div id="save-perbaikan" class="col-md-4">
                        <div class="col-lg-12" align="center">
                            <button type="submit" value="simpan2" name="simpan2" class="btn btn-primary"><i class="fa fa-save fa-lg"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                            <a href="pengajuanmt" type="button" class="btn btn-danger"><i class="fa fa-times fa-lg"></i> Batal</a>
                        </div> 
                    </div>
                </div>
        </form>
            <br />
            <!-- TAB PANEL -->
            <br />
            <br />
        <div class="row">
            <div class="col-md-12 center">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#tab1" data-toggle="tab">Daftar Pengerjaan Karyawan</a></li>
                    <li><a href="#tab2" data-toggle="tab">Daftar Kebutuhan Spare Part</a></li>
                    <li><a href="#tab3" data-toggle="tab">Detail Pengerjaan Perbaikan</a></li>
                </ul>
                <div class="tab-content panel">
                    <div class="tab-pane active" id="tab1">
                            
                            <br />
                            <div class="panel panel-default">
                                <table id="user-table">
                                    <thead>
                                        <tr>
                                            <th>Opsi</th>
                                            <th>Nama Karyawan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form role="form" id="form" action="" method="post">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="KODE_PART">Kebutuhan Spare Part</label>
                                            <select id="KODE_PART" name="KODE_PART" id="selectize-customselect" class="form-control">
                                                <option value="">Pilih Barang</option>
                                                <?php
                                                $result = GetQuery("select * from m_sparepart where KODE_JENIS = '$KODE_JENIS' order by NAMA_PART");
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?php echo $row["KODE_PART"]; ?>"<?php if($KODE_PART == $row["KODE_PART"]) { echo "selected"; } ?>><?php echo $row["NAMA_PART"]; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>                          
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="JUMLAH_PART">Jumlah </label>
                                            <input type="text" class="form-control" autocomplete="off" id="JUMLAH_PART" name="JUMLAH_PART" value="<?php echo $JUMLAH_PART; ?>">
                                        </div>                      
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label style="color:transparent">.</label><br>
                                            <button type="button" id="save_sparepart" name="save_part" class="btn btn-success"><i class="ico-plus2"></i> Tambah</button>
                                        </div>         
                                    </div>
                                </div>
                            </form>
                            <div class="panel panel-default">
                                <table id="sparepart-table">
                                    <thead>
                                        <tr>
                                            <th>Opsi</th>
                                            <th>Spare Part</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <div class="panel panel-default">
                                <table id="tbl-perbaikan">
                                    <thead>
                                        <tr>
                                            <th>Opsi</th>
                                            <th>Teknisi</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Durasi</th>
                                            <th>Hasil Perbaikan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
    </div>
    
</div>
