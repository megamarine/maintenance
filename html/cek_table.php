<?php
	require_once("module/model/koneksi/koneksi.php");
	?>
	<?php
	if(!empty($_POST["KODE_BARANG"])) {
		$KODE_BARANG = $_POST["KODE_BARANG"];
        $result = GetData1("s.*,b.NAMA_BARANG","m_sparepart s, m_barang b","s.KODE_BARANG = b.KODE_BARANG and s.KODE_BARANG = '$KODE_BARANG'");
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Daftar Spare Part</h3>
                    </div>
                    <table class="table table-striped table-bordered" id="column-filtering">
                        <thead>
                            <tr>
                                <th>Opsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Barang</th>
                                <th>Spare Part</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                ?>
                                <tr>
                                    <td align="center"><a href="hapus_part?KODE_PART=<?php echo $row["KODE_PART"]; ?>" class="btn btn-rounded btn-danger mb5" onclick="return confirm('Hapus request ini ?')"><i class="fa fa-trash fa-lg"></i></a></td>
                                    <td align="center"><?php echo $NAMA_BARANG; ?></td>
                                    <td align="center"><?php echo $NAMA_PART; ?></td>
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
		while ($rowz = $result->fetch(PDO::FETCH_ASSOC)) {
			?>
				<option value="<?php echo $rowz["KODE_BAGIAN"]; ?>"><?php echo $rowz["NAMA_BAGIAN"]; ?></option>
			<?php
		}
	}
?>