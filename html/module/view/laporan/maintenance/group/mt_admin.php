<?php
$KODE_BAGIAN = $_SESSION["LOGINBAG_MT"];
$result      = GetData1(
               "p.*,
                DATE_FORMAT(TGL_START, '%d %M %Y') as TGL_START,
                DATE_FORMAT(TGL_END, '%d %M %Y') as TGL_END,
                DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
                DATE_FORMAT(TGL_END, '%H:%i:%s') as JAM_END,
                p.TGL_START as TGL_STARTS,
                p.TGL_END as TGL_ENDS,
                h.NAMA_PERUSAHAAN,
                d.NAMA_DEPARTEMEN,
                b.NAMA_BARANG,
                j.NAMA_JENIS,
                d.KODE_BAGIAN",
               "t_perbaikan p, 
                m_barang b, 
                m_perusahaan h, 
                m_departemen d, 
                m_jenisbrg j",
               "p.KODE_BARANG = b.KODE_BARANG and 
                p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN and 
                p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
                b.KODE_JENIS = j.KODE_JENIS 
               order by p.KODE_PERBAIKAN desc");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
{
    if (isset($row["TGL_ENDS"])) 
    {
        $DINO = $row["TGL_ENDS"];
    }
    else
    {
        $DINO=date("Y-m-d H:i:s");
    }

    $datetime1 = new DateTime($row["TGL_STARTS"]);
    $datetime2 = new DateTime($DINO);
    $interval  = $datetime1->diff($datetime2);

    $date1 = new DateTime($row["TGL_STARTS"]);
    $date2 = new DateTime($DINO);
    $DATEZ = $date2->diff($date1)->format('%a');
    ?>
    <tr>
        <td>
            <div class="btn-group" style="margin-bottom:5px;">
                <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                    <li><a href="tambah_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                    <li class="divider"></li>
                    <li><a href="hapus_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" onclick="return confirm('Hapus request ini ?')"" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                </ul>
            </div><!-- /btn-group -->
        </td>
        <?php
        if ($row["STATUS_HAPUS"] == 1) {
            ?>
            <td align="center" style="color: red;">Deleted</td>
            <?php
        }
        elseif ($row["STATUS"] == 0) {
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
        <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
        <td align="center"><?php echo $row["TGL_START"]; ?> <br> <?php echo $row["JAM_START"]; ?></td>
        <td align="center"><?php echo $row["NAMA_BARANG"]; ?><br><?php echo $row["IP_ADD"]; ?><br><?php echo $row["PEMILIK"]; ?></td>
        <td align="left"><?php echo $row["JUMLAH_BARANG"]; ?></td>
        <td align="center"><?php echo $row["NAMA_JENIS"]; ?></td>
        <td align="left"><?php echo $row["KERUSAKAN"]; ?></td>
        <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
        <td align="center"><?php echo $row["TGL_END"]; ?> <br> <?php echo $row["JAM_END"]; ?></td>
        <td align="left"><?php echo $row["SOLUSI"]; ?></td>
    </tr>
    <?php
}
?>