<?php
$KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
if (isset($_POST["cari"])) 
{
    $PERIODE = $_POST["PERIODE"];
    $PERIODE2 = $_POST["PERIODE2"];
    $KODE_JENIS = $_POST["KODE_JENIS"];

    if ($KODE_JENIS != "") 
    {
        $result = GetData1(
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
            d.KODE_BAGIAN,
            p.DOWNTIME,
            DATE_FORMAT(TGL_PERBAIKAN, '%d %M %Y') as TGL_PERBAIKAN,
            DATE_FORMAT(TGL_PERBAIKAN, '%H:%i:%s') as JAM_PERBAIKAN,
            DATE_FORMAT(TGL_SELESAI, '%d %M %Y') as TGL_SELESAI,
            DATE_FORMAT(TGL_SELESAI, '%H:%i:%s') as JAM_SELESAI",
           "t_perbaikan p, 
            m_barang b, 
            m_perusahaan h, 
            m_departemen d, 
            m_jenisbrg j",
           "p.KODE_BARANG = b.KODE_BARANG and 
            p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN and 
            p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
            b.KODE_JENIS = j.KODE_JENIS and 
            date(p.TGL_START) between '$PERIODE' and '$PERIODE2' and 
            p.STATUS_HAPUS = 0 and 
            (b.KODE_JENIS = 2 or p.KODE_DEPARTEMEN = '$KODE_DEPARTEMEN') and 
            b.KODE_JENIS = '$KODE_JENIS' 
           order by p.KODE_PERBAIKAN");
    } 
    else 
    {
        $result = GetData1(
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
            d.KODE_BAGIAN,
            p.DOWNTIME,
            DATE_FORMAT(TGL_PERBAIKAN, '%d %M %Y') as TGL_PERBAIKAN,
            DATE_FORMAT(TGL_PERBAIKAN, '%H:%i:%s') as JAM_PERBAIKAN,
            DATE_FORMAT(TGL_SELESAI, '%d %M %Y') as TGL_SELESAI,
            DATE_FORMAT(TGL_SELESAI, '%H:%i:%s') as JAM_SELESAI",
           "t_perbaikan p, 
            m_barang b, 
            m_perusahaan h, 
            m_departemen d, 
            m_jenisbrg j",
           "p.KODE_BARANG = b.KODE_BARANG and 
            p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN and 
            p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
            b.KODE_JENIS = j.KODE_JENIS and 
            date(p.TGL_START) between '$PERIODE' and '$PERIODE2' and 
            p.STATUS_HAPUS = 0 and 
            (b.KODE_JENIS = 2 or p.KODE_DEPARTEMEN = '$KODE_DEPARTEMEN') 
           order by p.KODE_PERBAIKAN");
    }
}
else
{
    $PERIODE  = date("Y-m-01");
    $PERIODE2 = date("Y-m-t");
    $result   = GetData1(
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
        d.KODE_BAGIAN,
        p.DOWNTIME,
        DATE_FORMAT(TGL_PERBAIKAN, '%d %M %Y') as TGL_PERBAIKAN,
        DATE_FORMAT(TGL_PERBAIKAN, '%H:%i:%s') as JAM_PERBAIKAN,
        DATE_FORMAT(TGL_SELESAI, '%d %M %Y') as TGL_SELESAI,
        DATE_FORMAT(TGL_SELESAI, '%H:%i:%s') as JAM_SELESAI",
       "t_perbaikan p, 
        m_barang b, 
        m_perusahaan h, 
        m_departemen d, 
        m_jenisbrg j",
       "p.KODE_BARANG = b.KODE_BARANG and 
        p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN and 
        p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
        b.KODE_JENIS = j.KODE_JENIS and 
        date(p.TGL_START) between '$PERIODE' and '$PERIODE2' and 
        p.STATUS_HAPUS = 0 and 
        (b.KODE_JENIS = 2 or p.KODE_DEPARTEMEN = '$KODE_DEPARTEMEN') 
       order by p.KODE_PERBAIKAN");
}
while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
{
    $KODE_PERBAIKAN = $row["KODE_PERBAIKAN"];

    $result2 = GetQuery(
        "select t.NAMA_TEKNISI 
        from d_perbaikan p, 
             m_teknisi t 
        where p.KODE_TEKNISI = t.KODE_TEKNISI and 
        p.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and 
        p.STS_HAPUS = 0");

    if (isset($row["TGL_STARTS"])) 
    {
        $DINO = $row["TGL_ENDS"];
    }
    else
    {
        $DINO = date("Y-m-d H:i:s");
    }

    $datetime1 = new DateTime($row["TGL_STARTS"]);
    $datetime2 = new DateTime($DINO);
    $interval  = $datetime1->diff($datetime2);

    $date1 = new DateTime($row["TGL_STARTS"]);
    $date2 = new DateTime($DINO);
    $DATEZ = $date2->diff($date1)->format('%a');
    ?>
    <tr>
        <td align="center">
        <?php
        if ($row["SOLUSI"] != "") {
            ?>
            <div class="btn-group" style="margin-bottom:5px;">
                <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="print_laporanmaintenance?id=<?php echo $row["KODE_PERBAIKAN"]; ?>" target="_blank" style="color:brown;"><i class="fa fa-print fa-lg"></i> Cetak</a></li>
                </ul>
            </div><!-- /btn-group -->
            <?php
        }
        ?>
        </td>
        <td align="center"><?php echo $row["KODE_PERBAIKAN"]; ?></td>
        <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
        <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
        <td align="center"><?php echo $row["TGL_START"]; ?> <br> <?php echo $row["JAM_START"]; ?></td>
        <td align="center"><?php echo $row["NAMA_BARANG"]; ?><br><?php echo $row["IP_ADD"]; ?><br><?php echo $row["PEMILIK"]; ?></td>
        <td align="center"><?php echo $row["NAMA_JENIS"]; ?> <br> <?php echo $row["BAGIAN"]; ?></td>
        <td align="left"><?php echo $row["KERUSAKAN"]; ?></td>
        <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
        <td align="center"><?php echo $row["TGL_PERBAIKAN"]; ?> <br> <?php echo $row["JAM_PERBAIKAN"]; ?></td>
        <td align="center"><?php echo $row["TGL_SELESAI"]; ?> <br> <?php echo $row["JAM_SELESAI"]; ?></td>
        <td align="center"><?php echo $row["DOWNTIME"]; ?></td>
        <td align="center"><?php echo $row["DURASI"]; ?></td>
        <td align="left"><?php echo $row["SOLUSI"]; ?></td>
        <td align="left"><?php echo $row["SARAN"]; ?></td>
        <td align="center" style="color:green;">
            <p>
            <?php
            while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                echo $row2["NAMA_TEKNISI"] . ",<br>";
            }
            ?>
            </p>
            <?php
            if ($row["HASIL"] == 0) {
                ?>
                <p>In Progress<br> <b style="color:red;"><?php echo $row["KETERANGAN2"]; ?></b></p>
                <?php
            }
            elseif ($row["HASIL"] == 1) {
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