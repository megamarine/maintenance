<?php 
    require_once ("module/model/koneksi/koneksi.php");
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Pengajuan Perbaikan Barang.xls");


    $DEPARTEMENT     = $_SESSION["LOGINDEP_MT"];
    $PERIODE         = $_GET["PERIODE"];
    $PERIODE2        = $_GET["PERIODE2"];
    $date            = date_create("$PERIODE");
    $date2           = date_create("$PERIODE2");

    if ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") //eng
    {
        $KODE_JENIS = 2;
    }
    if ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") //civil eng
    {
        $KODE_JENIS = 4;
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
            (b.KODE_JENIS = '$KODE_JENIS' or p.KODE_DEPARTEMEN = '$KODE_DEPARTEMEN') and 
            date(p.TGL_START) between '$PERIODE' and '$PERIODE2' 
   order by p.KODE_PERBAIKAN desc");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Perbaikan </title>
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
            <h3>Laporan Pengajuan Perbaikan Barang <br/><?php echo date_format($date,'d F Y')." - ".date_format($date2,'d F Y'); ?></h3>
        </center>
 
        <table border="1">
            <tr>
                <th>No</th>
                <th>Status</th>
                <th>Kode</th>
                <th>Perusahaan</th>
                <th>Departemen</th>
                <th>Tanggal Pengajuan</th>
                <th>Nama Barang</th>
                <th>Unit Barang</th>
                <th>Qty</th>
                <th>Kategori</th>
                <th>Layanan</th>
                <th>Kerusakan</th>
                <th>Keterangan</th>
                <th>Tanggal Selesai</th>
                <th>Hasil Pemeliharaan</th>
            </tr>
            <?php
            $no = 1;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
            ?>
            <tr>
                <td align="center"><?php echo $no++;?></td>
                <?php
                if ($row["STATUS"] == 0) 
                {
                    ?>
                    <td align="center">In Progress</td>
                    <?php                    
                }
                else
                {
                    ?>
                    <td align="center">Done</td>
                    <?php
                }
                ?>
                <td align="center"><?php echo $row["KODE_PERBAIKAN"]; ?></td>
                <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
                <td align="center"><?php echo $row["NAMA_DEPARTEMEN"]; ?> / <?php echo $row["NAMA_USER"]; ?></td>
                <td align="center"><?php echo $row["TGL_START"]; ?> / <?php echo $row["JAM_START"]; ?></td>
                <td align="center"><?php echo $row["NAMA_BARANG"]; ?></td>
                <td align="center"><?php echo $row["NAMA_UNIT"]; ?></td>
                <td align="center"><?php echo $row["JUMLAH_BARANG"]; ?></td>
                <td align="center"><?php echo $row["NAMA_JENIS"]; ?> / <?php echo $row["BAGIAN"]; ?></td>
                <td align="center"><?php echo $row["LAYANAN"]; ?></td>
                <td align="left"><?php echo $row["KERUSAKAN"]; ?></td>
                <td align="left"><?php echo $row["KETERANGAN"]; ?></td>
                <td align="center"><?php echo $row["TGL_END"]; ?> / <?php echo $row["JAM_END"]; ?></td>
                <td align="left"><?php echo $row["SOLUSI"]; ?></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </body>
</html>