<?php 
    require_once ("../../../../module/model/koneksi/koneksi.php");
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Perawatan Barang.xls");

    $PERIODE         = $_GET["PERIODE"];
    $PERIODE2        = $_GET["PERIODE2"];
    $date            = date_create("$PERIODE");
    $date2           = date_create("$PERIODE2");
    $KODE_BARANG     = "";
    $KODE_UNIT       = "";

    if($_POST["KODE_UNIT"] != '')
    {
        $KODE_BARANG = $_GET["KODE_BARANG"];
        $KODE_UNIT   = $_GET["KODE_UNIT"];
        $GO = "select a.KODE_PERBAIKAN,
                      a.BAGIAN,
                      a.KERUSAKAN,
                      a.SOLUSI,
                      a.SARAN,
                      DATE_FORMAT(a.TGL_START, '%d %M %Y') as TGL_START,
                      DATE_FORMAT(a.TGL_START, '%H:%i:%s') as JAM_START,
                      a.JUMLAH_BARANG,
                      DATE_FORMAT(a.TGL_END, '%d %M %Y') as TGL_END,
                      DATE_FORMAT(a.TGL_END, '%H:%i:%s') as JAM_END,
                      a.LAYANAN,
                      a.KETERANGAN,
                      b.NAMA_BARANG,
                      c.NAMA_UNIT,
                      d.NAMA_PERUSAHAAN,
                      e.NAMA_DEPARTEMEN,
                      f.NAMA_USER
                 from t_perbaikan a
                 JOIN m_barang b ON a.KODE_BARANG = b.KODE_BARANG
                 JOIN m_unit c ON a.KODE_UNIT = c.KODE_UNIT
                 JOIN m_perusahaan d ON a.KODE_PERUSAHAAN = d.KODE_PERUSAHAAN
                 JOIN m_departemen e ON a.KODE_DEPARTEMEN = e.KODE_DEPARTEMEN
                 JOIN m_user f ON a.USER_REQ = f.KODE_USER
                WHERE a.kode_unit = '$KODE_UNIT' and
                      a.LAYANAN = 'PERAWATAN' and 
                      a.TGL_START BETWEEN '$PERIODE' AND '$PERIODE2'
             ORDER BY a.TGL_START asc";

    }
    else
    {
        $KODE_BARANG = $_GET["KODE_BARANG"];
        $KODE_UNIT   = $_GET["KODE_UNIT"];
        $GO = "select a.KODE_PERBAIKAN,
                      a.BAGIAN,
                      a.KERUSAKAN,
                      a.SOLUSI,
                      a.SARAN,
                      DATE_FORMAT(a.TGL_START, '%d %M %Y') as TGL_START,
                      DATE_FORMAT(a.TGL_START, '%H:%i:%s') as JAM_START,
                      a.JUMLAH_BARANG,
                      DATE_FORMAT(a.TGL_END, '%d %M %Y') as TGL_END,
                      DATE_FORMAT(a.TGL_END, '%H:%i:%s') as JAM_END,
                      a.LAYANAN,
                      a.KETERANGAN,
                      b.NAMA_BARANG,
                      c.NAMA_UNIT,
                      d.NAMA_PERUSAHAAN,
                      e.NAMA_DEPARTEMEN,
                      f.NAMA_USER
                 from t_perbaikan a
                 JOIN m_barang b ON a.KODE_BARANG = b.KODE_BARANG
                 JOIN m_unit c ON a.KODE_UNIT = c.KODE_UNIT
                 JOIN m_perusahaan d ON a.KODE_PERUSAHAAN = d.KODE_PERUSAHAAN
                 JOIN m_departemen e ON a.KODE_DEPARTEMEN = e.KODE_DEPARTEMEN
                 JOIN m_user f ON a.USER_REQ = f.KODE_USER
                WHERE a.kode_barang = '$KODE_BARANG' and
                      a.LAYANAN = 'PERAWATAN' and 
                      a.TGL_START BETWEEN '$PERIODE' AND '$PERIODE2'
             ORDER BY a.TGL_START asc";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Perawatan </title>
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
            <h3>Laporan Perawatan Mesin <br/><?php echo date_format($date,'d F Y')." - ".date_format($date2,'d F Y'); ?></h3>
        </center>
 
        <table border="1">
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Perusahaan</th>
                <th>Departemen</th>
                <th>Tanggal Pengajuan</th>
                <th>Nama Barang</th>
                <th>Nama Unit</th>
                <th>Qty</th>
                <th>Bagian</th>
                <th>Layanan</th>
                <th>Kerusakan</th>
                <th>Keterangan</th>
                <th>Tanggal Selesai</th>
                <th>Hasil Pemeliharaan</th>
            </tr>
            <?php
            $no = 1;
            $result = getQuery("$GO");
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                //MTBF = (waktu operational - durasi downtime) / frekwensi
                //MTTR = durasi downtime / frekwensi
                //Avail= (waktu operational - durasi downtime) / waktu operational
            ?>
            <tr>
                <td align="center"><?php echo $no++."."; ?></td>
                <td align="center"><?php echo $row["KODE_PERBAIKAN"]; ?></td>
                <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?></td>
                <td align="center"><?php echo $row["TGL_START"]."<br>".$row["JAM_START"]; ?></td>
                <td><?php echo $row["NAMA_BARANG"];?></td>
                <td><?php echo $row["NAMA_UNIT"];?></td>
                <td align="center"><?php echo $row["JUMLAH_BARANG"];?></td>
                <td><?php echo $row["BAGIAN"]; ?></td>
                <td><?php echo $row["LAYANAN"]; ?></td>
                <td><?php echo $row["KERUSAKAN"]; ?></td>
                <td><?php echo $row["KETERANGAN"]; ?></td>
                <td align="center"><?php echo $row["TGL_END"]."<br>".$row["JAM_END"]; ?></td>
                <td><?php echo $row["SOLUSI"]; ?></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </body>
</html>