<?php include "module/controller/master/barang/t_barang.php"; ?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-archive fa-lg"></i> Master Barang</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="barang"><i class="fa fa-archive fa-lg"></i> Barang </a></li>
                <li class="active"><i class="ico-plus2"></i> Tambah Barang</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form role="form" action="" method="post" data-parsley-validate>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="NAMA_BARANG">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="" id="NAMA_BARANG" name="NAMA_BARANG" autocomplete="off" value="<?php echo $NAMA_BARANG; ?>" data-parsley-required>
                    </div>                          
                </div>     
                <?php
                if ($_SESSION["LOGINAKS_MT"] == "Administrator" or $_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
                {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="KODE_JENIS">Jenis <span class="text-danger">*</span></label>
                            <select name="KODE_JENIS" id="KODE_JENIS" required="" class="form-control" data-parsley-required>
                                <option value="">Pilih Jenis</option>
                                <?php
                                $result = GetData("*","m_jenisbrg");
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["KODE_JENIS"]; ?>"<?php if($KODE_JENIS == $row["KODE_JENIS"]) { echo "selected"; } ?>><?php echo $row["NAMA_JENIS"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>                          
                    </div>  
                    <?php
                }
                ?>  
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ITEM_TYPE">Item Type <span class="text-danger">*</span></label>
                        <select name="ITEM_TYPE" id="ITEM_TYPE" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <?php
                            $result = GetData("*","m_itemtype");
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $row["ITEM_TYPE"]; ?>"<?php if($ITEM_TYPE == $row["ITEM_TYPE"]) { echo "selected"; } ?>><?php echo $row["KET"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>                          
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="KETERANGAN">Keterangan</label><br>
                        <textarea class="form-control" name="KETERANGAN" id="KETERANGAN" rows="6" placeholder="Keterangan"><?php echo $KETERANGAN; ?></textarea>
                    </div>
                </div>                     
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-12" align="center">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="ico-save"></i> Simpan</button>&nbsp;&nbsp;&nbsp;
                    <a href="barang" type="button" class="btn btn-danger"><i class="ico-close2"></i> Batal</a>
                </div>                    
            </div>
            <br><br>
        </form>
    </div>
</div>