<?php
require_once ("module/model/koneksi/koneksi.php");
include "module/controller/login/login.php";
?>
<!DOCTYPE html>
<html class="backend">
    <head>
        <?php include "module/model/head/head.php"; ?>
    </head>
    <body>
        <section id="main" role="main">
            <section class="container">
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4">
                        <form class="panel" method="post" action="">
                            <div class="panel-body">
                                <h3 align="center" style="font-weight: bold;">Maintenance - Ticketing System</h3>
                                <div align="center">
                                    <img src="../image/images/logommp3.png" width="65%">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>ID Karyawan</label>
                                    <input class="form-control" type="text" name="username" placeholder="ID Karyawan">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal -->
                <!-- <script type="text/javascript">
                    $(window).on('load', function() {
                        $('#myModal').modal('show');
                    });
                </script>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color:#df4759;color: white;">
                        <h4 class="modal-title"><b>Pengumuman</b></h4>
                      </div>
                      <div class="modal-body">
                            Password user telah diupdate / diganti, sesuai dengan pengumuman yang disampaikan sebelumnya. Dan informasi mengenai password yang baru sudah disampaikan kepada user <br><br> Jika ada kesulitan / perlu bantuan, silahkan menghubungi Departement IT. Terimakasih.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary fa fa-times" style="background-color:#df4759;color: white;" data-dismiss="modal" title="Close"></button>
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- End of modal -->
            </section>
        </section>
        <script type="text/javascript" src="../javascript/vendor.js"></script>
        <script type="text/javascript" src="../javascript/core.js"></script>
        <script type="text/javascript" src="../javascript/backend/app.js"></script>
        <script type="text/javascript" src="../javascript/pace.min.js"></script>
		<script type="text/javascript" src="../plugins/parsley/js/parsley.js"></script>
        <script type="text/javascript" src="../javascript/backend/pages/login.js"></script>
    </body>
</html>