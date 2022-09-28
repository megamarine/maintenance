<?php include "module/controller/master/edit_profile/t_editprofile.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-user-circle"></i> Edit Profile</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-user-circle"></i> Edit Profile</a></li>
        </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="NAMA_USER">Nama</label>
                        <input type="text" class="form-control" required="" id="NAMA_USER" name="NAMA_USER" value="<?php echo $NAMA_USER; ?>">
                    </div>                          
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="PASSWORD">Password</label>
                        <input type="password" class="form-control" required="" id="PASSWORD" name="PASSWORD">
                    </div>                          
                </div>                                 
            </div>   
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp&nbsp&nbsp
                    <a href="menuutama" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>