<?php
$KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];

if (isset($_POST["cari"])) {
    $PERIODE  = $_POST["PERIODE"];
    $PERIODE2 = $_POST["PERIODE2"];
}

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
      WHERE p.HASIL IS NULL and 
            p.STATUS_HAPUS = 0 and 
            (b.KODE_JENIS = 4 or p.KODE_DEPARTEMEN = '$KODE_DEPARTEMEN') and 
            date(p.TGL_START) between '$PERIODE' and '$PERIODE2' 
   order by p.KODE_PERBAIKAN desc");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
{
    $KODE_PERBAIKAN      = $row["KODE_PERBAIKAN"];
    $KODE_PERBAIKAN_AWAL = $row["KODE_PERBAIKAN"];

    $result2 = GetQuery(
        "select t.NAMA_TEKNISI 
        from d_perbaikan p, m_teknisi t 
        where p.KODE_TEKNISI = t.KODE_TEKNISI and p.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and p.STS_HAPUS = 0");

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
    $date1     = new DateTime($row["TGL_STARTS"]);
    $date2     = new DateTime($DINO);
    $DATEZ     = $date2->diff($date1)->format('%a');
    ?>
    <tr>
        <td class="hidden"></td>
        <?php
        //jika user = Pak Mubin / 412412...
        if ($_SESSION["LOGINIDUS_MT"] == "412412") 
        {
            ?>
            <td>
                <div class="btn-group" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                        <li><a href="tambah_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                        <li><a data-toggle="modal" data-id="<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:brown;" data-toggle="modal" title="Add this item" class="open-AddBookDialog2" href="#addBookDialog2"><i class="fa fa-hourglass-half fa-lg"></i> Pending</a></li>
                        <li class="divider"></li>
                        <li><a data-toggle="modal" data-id="<?php echo $row["KODE_PERBAIKAN"]; ?>" data-toggle="modal" title="Add this item" class="open-AddBookDialog" href="#addBookDialog"><i class="fa fa-times fa-lg"></i> Tolak</a></li>
                        <li><a href="hapus_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" onclick="return confirm('Hapus request ini ?')" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                        <li class="divider"></li>
                        <li><a href="print_spk?id=<?php echo $row["KODE_PERBAIKAN"]; ?>" target="_blank" style="color:brown;"><i class="fa fa-print fa-lg"></i> Cetak SPK</a></li>
                    </ul>
                </div>
            </td>
            <?php
        }
        //jika user = civil BB / MMP 
        elseif ($row["KODE_BAGIAN"] == "DIV-0048" or $row["KODE_BAGIAN"] == "DIV-0051") 
        {
            ?>
            <td>
                <div class="btn-group" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                        <li><a href="tambah_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                        <li><a href="hapus_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" onclick="return confirm('Hapus request ini ?')" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                        <li class="divider"></li>
                        <li><a href="print_spk?id=<?php echo $row["KODE_PERBAIKAN"]; ?>" target="_blank" style="color:brown;"><i class="fa fa-print fa-lg"></i> Cetak SPK</a></li>
                    </ul>
                </div>
            </td>
            <?php
        }
        //jika kode departemen tidak sama dengan kode departemen di database...
        elseif ($KODE_DEPARTEMEN != $row["KODE_DEPARTEMEN"]) 
        {
            ?>
            <td>
                <div class="btn-group" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                        <li><a data-toggle="modal" data-id="<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:brown;" data-toggle="modal" title="Add this item" class="open-AddBookDialog2" href="#addBookDialog2"><i class="fa fa-hourglass-half fa-lg"></i> Pending</a></li>
                        <li><a data-toggle="modal" data-id="<?php echo $row["KODE_PERBAIKAN"]; ?>" data-toggle="modal" title="Add this item" class="open-AddBookDialog" href="#addBookDialog"><i class="fa fa-times fa-lg"></i> Tolak</a></li>
                        <li class="divider"></li>
                        <li><a href="print_spk?id=<?php echo $row["KODE_PERBAIKAN"]; ?>" target="_blank" style="color:brown;"><i class="fa fa-print fa-lg"></i> Cetak</a></li>
                    </ul>
                </div>
            </td>
            <?php
        }
        else
        {
            if ($row["NAMA_JENIS"] != "Civil Engineering") 
            {
                ?>
                <td>
                    <div class="btn-group" style="margin-bottom:5px;">
                        <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
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
                            <li><a href="proses_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                            <li><a href="tambah_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                            <li class="divider"></li>
                            <li><a href="hapus_pengajuanmt?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>" onclick="return confirm('Hapus request ini ?')" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                            <li><a href="print_spk?id=<?php echo $row["KODE_PERBAIKAN"]; ?>" target="_blank" style="color:brown;"><i class="fa fa-print fa-lg"></i> Cetak</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                </td>
                <?php
            }
        }
        ?>
        <?php
        if ($row["STATUS"] == 0) {
            if ($row["STATUS_READ"] == 0) {
                ?>
                <td align="center" style="color: black;">In Progress</td>
                <?php
            } else {
                ?>
                <td align="center" style="color: black;">In Progress <img src="images/usrcek2.png"> <br> <b style="color:red;"><?php echo $row["KETERANGAN2"]; ?></b></td>
                <?php
            }
        }
        else{
            if (!isset($row["HASIL"])) {
                if ($KODE_DEPARTEMEN == $row["KODE_DEPARTEMEN"]) {
                    ?>
                    <td align="center" style="color: green;">
                        <p>
                        <?php
                        while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                            echo $row2["NAMA_TEKNISI"] . ",<br>";
                        }
                        ?>
                        </p>
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=1" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=2" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=3" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=4" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=5" ><img src="images/emptystar.png"></a>
                    </td>
                    <?php
                }
                elseif ($row["KODE_BAGIAN"] == "DIV-0048" or $row["KODE_BAGIAN"] == "DIV-0051") {
                    ?>
                    <td align="center" style="color: green;">
                    <p>
                    <?php
                    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                        echo $row2["NAMA_TEKNISI"] . ",<br>";
                    }
                    ?>
                        </p>
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=1" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=2" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=3" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=4" ><img src="images/emptystar.png"></a>&nbsp;
                        <a href="tambah_hasil?KODE_PERBAIKAN=<?php echo $row["KODE_PERBAIKAN"]; ?>&HASIL=5" ><img src="images/emptystar.png"></a>
                    </td>
                    <?php
                }
                else
                {
                    ?>
                    <td align="center" style="color: green;">
                        <p>
                        <?php
                        while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                            echo $row2["NAMA_TEKNISI"] . ",<br>";
                        }
                        ?>
                        </p>
                        <img src="images/emptystar.png">
                        <img src="images/emptystar.png">
                        <img src="images/emptystar.png">
                        <img src="images/emptystar.png">
                        <img src="images/emptystar.png">
                    </td>
                    <?php
                }
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
        <td align="center"><?php echo $row["NAMA_BARANG"]; ?></td>
        <td align="center"><?php echo $row["NAMA_UNIT"]; ?></td>
        <td align="center"><?php echo $row["LOKASI"]; ?></td>
        <td align="center"><?php echo $row["JUMLAH_BARANG"]; ?></td>
        <td align="center"><?php echo $row["NAMA_JENIS"]; ?> <br> <?php echo $row["BAGIAN"]; ?></td>
        <td align="center"><?php echo $row["LAYANAN"]; ?></td>
        <td align="left"><?php echo $row["KERUSAKAN"]; ?></td>
        <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
        <!-- <?php
        if ($row["TGL_SELESAI"] == "") {
            ?>
            <td align="center"><?php echo $row["TGL_END"]; ?> <br> <?php echo $row["JAM_END"]; ?></td>
            <?php
        } else {
            ?>
            <td align="center"><?php echo $row["TGL_SELESAI"]; ?> <br> <?php echo $row["JAM_SELESAI"]; ?></td>
            <?php
        }
        ?> -->
        <td align="center"><?php echo $row["TGL_END"]; ?> <br> <?php echo $row["JAM_END"]; ?></td>
        <td align="left"><?php echo $row["SOLUSI"]; ?></td>
    </tr>
    <?php
}
?>