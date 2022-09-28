<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Maintenance.xls");

    $KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
    $PERIODE         = $_GET["PERIODE"];
    $PERIODE2        = $_GET["PERIODE2"];
    $KODE_JENIS      = $_GET["KODE_JENIS"];

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
            d.KODE_BAGIAN",
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
            p.KODE_DEPARTEMEN = '$KODE_DEPARTEMEN' and 
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
            d.KODE_BAGIAN",
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
            p.KODE_DEPARTEMEN = '$KODE_DEPARTEMEN' 
           order by p.KODE_PERBAIKAN");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Maintenance </title>
    </head>
    <body>
        <style type="text/css">
        body{
            font-family: sans-serif;
        }
        table{
            margin: 20px auto;
            border-collapse: collapse;
        }
        table th,
        table td{
            border: 1px solid #3c3c3c;
            padding: 3px 8px;
     
        }
        a{
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
        </style>

        <center>
            <h2>Laporan Maintenance <br/><?php echo $PERIODE." sampai ".$PERIODE2; ?></h2>
        </center>
 
        <table border="1">
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Perusahaan</th>
                <th>Departemen</th>
                <th>Tanggal Pengajuan</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Kategori</th>
                <th>Kerusakan</th>
                <th>Keterangan</th>
                <th>Hasil Perbaikan</th>
                <th>Saran</th>
                <th>Teknisi</th>
            </tr>
            <?php
            $no = 1;
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

                $result3 = GetQuery(
                 "select t.NAMA_PART, p.JUMLAH_PART
                    from d_maintenance p,
                         m_sparepart t
                   where p.KODE_PART = t.KODE_PART and
                         p.KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

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
                <td align="center"><?php echo $no++;?></td>
                <td align="center"><?php echo $row["KODE_PERBAIKAN"]; ?></td>
                <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
                <td align="center"><?php echo $row["TGL_START"]; ?> <br> <?php echo $row["JAM_START"]; ?></td>
                <td align="center"><?php echo $row["NAMA_BARANG"]; ?><br><?php echo $row["IP_ADD"]; ?><br><?php echo $row["PEMILIK"]; ?></td>
                <td align="center"><?php echo $row["JUMLAH_BARANG"]; ?></td>
                <td align="center"><?php echo $row["NAMA_JENIS"]; ?> <br> <?php echo $row["BAGIAN"]; ?></td>
                <td align="left"><?php echo $row["KERUSAKAN"]; ?></td>
                <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
                <td align="center"><?php echo $row["TGL_END"]; ?> <br> <?php echo $row["JAM_END"]; ?></td>
                <td align="left"><?php echo $row["SOLUSI"]; ?></td>
                <td align="left"><?php echo $row["SARAN"]; ?></td>
                <td align="center" style="color:green;">
                    <p>
                    <?php
                    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) 
                    {
                        echo $row2["NAMA_TEKNISI"];
                    }
                    ?>
                </td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </body>
</html>