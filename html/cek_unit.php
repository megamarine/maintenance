<?php
    require_once("module/model/koneksi/koneksi.php");
    
    ?>
        <option value="">Pilih Unit Barang</option>
        <option value="-">None</option>
    <?php
    if(!empty($_POST["KODE_BARANG"])) 
    {
        $KODE_BARANG   = $_POST["KODE_BARANG"];
        $result        = GetQuery("select * from m_unit where KODE_BARANG = '$KODE_BARANG' and STATUS = '0' order by NAMA_UNIT asc");
        ?> 
        <?php
        while ($rowz   = $result->fetch(PDO::FETCH_ASSOC)) 
        {
            ?>
                <option value="<?php echo $rowz["KODE_UNIT"]; ?>"><?php echo $rowz["NAMA_UNIT"]; ?></option>
            <?php
        }
    }
?>