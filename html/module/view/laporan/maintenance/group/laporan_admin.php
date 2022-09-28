<?php 
if (isset($_POST["cari"])) 
{
    $PERIODE    = $_POST["PERIODE"];
    $PERIODE2   = $_POST["PERIODE2"];
    $KODE_JENIS = $_POST["KODE_JENIS"];

    if ($KODE_JENIS != "")
    {
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
          WHERE p.STATUS_HAPUS = 0 and 
                b.KODE_JENIS = '$KODE_JENIS' and
                date(p.TGL_START) between '$PERIODE' and '$PERIODE2' 
       order by p.KODE_PERBAIKAN desc");

    }
    else
    {
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
          WHERE p.STATUS_HAPUS = 0 and 
                date(p.TGL_START) between '$PERIODE' and '$PERIODE2' 
       order by p.KODE_PERBAIKAN desc");
    }
}
else
{
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
      WHERE p.STATUS_HAPUS = 0 and 
            date(p.TGL_START) between '$PERIODE' and '$PERIODE2' 
   order by p.KODE_PERBAIKAN desc");
}
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if (isset($row["TGL_ENDS"])) {
        $DINO = $row["TGL_ENDS"];
    }
    else{
        $DINO=date("Y-m-d H:i:s");
    }

    $datetime1 = new DateTime($row["TGL_STARTS"]);
    $datetime2 = new DateTime($DINO);
    $interval  = $datetime1->diff($datetime2);

    $date1  = new DateTime($row["TGL_STARTS"]);
    $date2  = new DateTime($DINO);
    $DATEZ  = $date2->diff($date1)->format('%a');
    ?>
    <tr>
        <td align="center">
            <div class="btn-group" style="margin-bottom:5px;">
                <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="print_laporanmaintenance?id=<?php echo $row["KODE_PERBAIKAN"]; ?>" target="_blank" style="color:brown;"><i class="fa fa-print fa-lg"></i> Cetak</a></li>
                </ul>
            </div>
        </td>
        <td align="center"><?php echo $row["KODE_PERBAIKAN"]; ?></td>
        <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
        <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
        <td align="center"><?php echo $row["TGL_START"]; ?> <br> <?php echo $row["JAM_START"]; ?></td>
        <td align="center"><?php echo $row["NAMA_BARANG"]; ?><br><?php echo $row["IP_ADD"]; ?><br><?php echo $row["PEMILIK"]; ?></td>
        <td align="left"><?php echo $row["NAMA_UNIT"]; ?></td>
        <td align="left"><?php echo $row["LOKASI"]; ?></td>
        <td align="left"><?php echo $row["JUMLAH_BARANG"]; ?></td>
        <td align="center"><?php echo $row["NAMA_JENIS"]; ?></td>
        <td align="left"><?php echo $row["KERUSAKAN"]; ?></td>
        <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
        <td align="center"><?php echo $row["TGL_END"]; ?> <br> <?php echo $row["JAM_END"]; ?></td>
        <td align="left"><?php echo $row["SOLUSI"]; ?></td>
        <td align="left"><?php echo $row["SARAN"]; ?></td>
        <?php
        if ($row["HASIL"] == 1) {
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
                <td align="center" style="color: green;">Complete <br> <i class="far fa-star fa-lg" style="color:gold;"></i><i class="far fa-star fa-lg" style="color:gold;"></i><i class="far fa-star fa-lg" style="color:gold;"></i><i class="far fa-star fa-lg" style="color:gold;"></i><i class="far fa-star fa-lg" style="color:gold;"></i></td>
                <?php
            }
            else{
                ?>
                <td align="center" style="color:green;">
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
        if ($row["STATUS_VER"] == 1) {
            ?>
            <td align="center"><i class="fas fa-check-circle fa-lg fa-2x success" style="color:green;"></i>
            <?php
        } elseif ($row["STATUS_VER"] == 2) {
            ?>
            <td>
                <i class="fas fa-times-circle fa-lg fa-2x danger" style="color:red;">
            </td>
            <?php
        } else {
            ?>
            <td align="center"><i class="fas fa-clock fa-lg fa-2x"></i></td>
            <?php
        }
        ?>
    </tr>
    <?php
}
?>