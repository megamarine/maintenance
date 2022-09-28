<?php
$KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];

$result = GetQuery(
    "select p.*,
            DATE_FORMAT(TGL_START, '%d %M %Y') as TGL_START,
            DATE_FORMAT(TGL_END, '%d %M %Y') as TGL_END,
            DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
            DATE_FORMAT(TGL_END, '%H:%i:%s') as JAM_END,
            p.TGL_START as TGL_STARTS,
            p.TGL_END as TGL_ENDS,
            h.NAMA_PERUSAHAAN,
            d.NAMA_DEPARTEMEN,
            b.NAMA_BARANG,
            i.NAMA_UNIT,
            j.NAMA_JENIS,
            d.KODE_BAGIAN,
            u.NAMA_USER
       FROM t_perbaikan p
       JOIN m_barang b ON p.KODE_BARANG = b.KODE_BARANG
  LEFT JOIN m_unit i ON p.KODE_UNIT = i.KODE_UNIT
       JOIN m_perusahaan h ON p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN
       JOIN m_departemen d ON p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN
       JOIN m_user u ON p.USER_REQ = u.KODE_USER
       JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
       JOIN m_bagian g ON d.KODE_BAGIAN = g.KODE_BAGIAN
      WHERE p.HASIL IS NULL and 
            p.STATUS_HAPUS = 0 and 
            g.KODE_BAGIAN between 'DIV-0029' and 'DIV-0031'
   order by p.KODE_PERBAIKAN desc");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if (isset($row["TGL_ENDS"])) {
        $DINO = $row["TGL_ENDS"];
    }
    else{
        $DINO=date("Y-m-d H:i:s");
    }

    $datetime1 = new DateTime($row["TGL_STARTS"]);
    $datetime2 = new DateTime($DINO);
    $interval = $datetime1->diff($datetime2);

    $date1 = new DateTime($row["TGL_STARTS"]);
    $date2 = new DateTime($DINO);
    $DATEZ  = $date2->diff($date1)->format('%a');
    ?>
    <tr>
        <td class="hidden"></td>
        <?php
        if ($row["STATUS"] == 0) {
            ?>
            <td>
                <div class="btn-group" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="tambah_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                        <li class="divider"></li>
                        <li><a href="hapus_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" onclick="return confirm('Hapus request ini ?')" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                    </ul>
                </div><!-- /btn-group -->
            </td>
            <?php
        }
        else{
            ?>
            <td>
                <div class="btn-group" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="tambah_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:black;"><i class="fa fa-search-plus fa-lg"></i> Lihat</a></li>
                    </ul>
                </div><!-- /btn-group -->
            </td>
            <?php
        }
        ?>
        <?php
        if ($row["STATUS"] == 0) {
            ?>
            <td align="center" style="color: black;">In Progress</td>
            <?php
        }
        else{
            if (!isset($row["HASIL"])) {
                ?>
                <td align="center" style="color: green;"><a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=1" ><img src="images/emptystar.png"></a>&nbsp;<a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=2" ><img src="images/emptystar.png"></a>&nbsp;<a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=3" ><img src="images/emptystar.png"></a>&nbsp;<a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=4" ><img src="images/emptystar.png"></a>&nbsp;<a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=5" ><img src="images/emptystar.png"></a></td>
                <?php
            }
            else{
                ?>
                <td align="center">
                    <?php
                    if ($row["HASIL"] == 1) {
                        ?>
                        <img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                        <?php
                    }
                    elseif ($row["HASIL"] == 2) {
                        ?>
                        <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                        <?php
                    }
                    elseif ($row["HASIL"] == 3) {
                        ?>
                        <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                        <?php
                    }
                    elseif ($row["HASIL"] == 4) {
                        ?>
                        <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png">
                        <?php
                    }
                    else {
                        ?>
                        <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png">
                        <?php
                    }
                    ?>
                </td>
                <?php
            }
        }
        ?>
        <td align="center"><?php echo $row["KODE_PERBAIKAN"]; ?></td>
        <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
        <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?><br><?php echo $row["NAMA_USER"]; ?></td>
        <td align="center"><?php echo $row["TGL_START"]; ?> <br> <?php echo $row["JAM_START"]; ?></td>
        <td align="center"><?php echo $row["NAMA_BARANG"]; ?><br><?php echo $row["IP_ADD"]; ?><br><?php echo $row["PEMILIK"]; ?></td>
        <td align="center"><?php echo $row["NAMA_UNIT"]; ?></td>
        <td align="center"><?php echo $row["JUMLAH_BARANG"]; ?></td>
        <td align="center"><?php echo $row["NAMA_JENIS"]; ?></td>
        <td align="center"><?php echo $row["NAMA_UNIT"]; ?></td>
        <td align="center"><?php echo $row["LAYANAN"]; ?></td>
        <td align="left"><?php echo $row["KERUSAKAN"]; ?></td>
        <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
        <td align="center"><?php echo $row["TGL_END"]; ?> <br> <?php echo $row["JAM_END"]; ?></td>
        <td align="left"><?php echo $row["SOLUSI"]; ?></td>
    </tr>
    <?php
}
?>