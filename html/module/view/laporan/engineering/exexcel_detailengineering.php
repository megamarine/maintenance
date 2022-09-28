<?php 
    require_once ("../../../../module/model/koneksi/koneksi.php");
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Detail Laporan Perbaikan Mesin.xls");

    $PERIODE         = $_GET["PERIODE"];
    $PERIODE2        = $_GET["PERIODE2"];
    $date            = date_create("$PERIODE");
    $date2           = date_create("$PERIODE2");
    $kode_barang     = $_GET["KODE_BARANG"];

    if($_GET["KODE_UNIT"] != '')
    {   
        $kode_unit = $_GET["KODE_UNIT"];
        $qw = getQuery("select nama_unit from m_unit where kode_unit = '$kode_unit'");
        while ($row3 = $qw->fetch(PDO::FETCH_ASSOC)) 
        {
            $nama_unit = $row3["nama_unit"];
        }  
    }
    else
    {
        $kode_unit = "";
        $nama_unit = "";
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////

    if($kode_unit != '')
    {
        $result = getQuery(
        "select a.KODE_PERBAIKAN,
                a.TGL_PERBAIKAN,
                b.KODE_PART,
                b.JUMLAH_PART,
                b.HARGA_PART,
                c.NAMA_PART,
                d.KODE_TEKNISI,
                e.NAMA_BARANG,
                f.NAMA_TEKNISI,
                g.NAMA_UNIT
           from t_perbaikan a
                JOIN d_maintenance b ON a.KODE_PERBAIKAN = b.KODE_PERBAIKAN
                JOIN m_sparepart c ON b.KODE_PART = c.KODE_PART
                JOIN d_perbaikan d ON a.KODE_PERBAIKAN = d.KODE_PERBAIKAN
                JOIN m_barang e ON a.KODE_BARANG = e.KODE_BARANG
                JOIN m_teknisi f ON d.KODE_TEKNISI = f.KODE_TEKNISI
                JOIN m_unit g ON a.KODE_UNIT = g.KODE_UNIT
          where a.status_hapus = '0' AND 
                b.sts_hapus = '0' AND
                a.KODE_BARANG = '$kode_barang' AND
                a.KODE_UNIT = '$kode_unit' AND 
                date_format(a.tgl_start,'%Y-%m-%d') BETWEEN '$PERIODE' AND '$PERIODE2'");
    }
    else
    {
        $result = getQuery(
        "select a.KODE_PERBAIKAN,
                a.TGL_PERBAIKAN,
                b.KODE_PART,
                b.JUMLAH_PART,
                b.HARGA_PART,
                c.NAMA_PART,
                d.KODE_TEKNISI,
                e.NAMA_BARANG,
                f.NAMA_TEKNISI
           from t_perbaikan a
                JOIN d_maintenance b ON a.KODE_PERBAIKAN = b.KODE_PERBAIKAN
                JOIN m_sparepart c ON b.KODE_PART = c.KODE_PART
                JOIN d_perbaikan d ON a.KODE_PERBAIKAN = d.KODE_PERBAIKAN
                JOIN m_barang e ON a.KODE_BARANG = e.KODE_BARANG
                JOIN m_teknisi f ON d.KODE_TEKNISI = f.KODE_TEKNISI
          where a.status_hapus = '0' AND 
                b.sts_hapus = '0' AND
                a.KODE_BARANG = '$kode_barang' AND 
                date_format(a.tgl_start,'%Y-%m-%d') BETWEEN '$PERIODE' AND '$PERIODE2'");
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Detail Laporan Perbaikan Mesin </title>
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
            <h3>Detail Laporan Perbaikan Mesin <br/><?php echo date_format($date,'d F Y')." - ".date_format($date2,'d F Y'); ?></h3>
        </center>
 
        <table border="1">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Perbaikan</th>
                <th>Nama Mesin</th>
                <?php
                if($kode_unit != '')
                {
                ?>
                    <th>Nama Unit</th>
                <?php
                }
                ?>
                <th>Teknisi</th>
                <th>Sparepart yang digunakan</th>
                <th>Harga /pcs</th>
                <th>Qty Sparepart</th>
                <th>Sub Total</th>
            </tr>

            <?php
            $no         = 1;
            $grandtot   = 0;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                $subtotal = $row["HARGA_PART"]*$row["JUMLAH_PART"];
                $grandtot += $subtotal;
                $tgl      = date_create($row["TGL_PERBAIKAN"]);
            ?>
                <tr>
                    <td align="center"><?php echo $no++;?></td>
                    <td><?php echo date_format($tgl,'d F Y');?></td>
                    <td><?php echo $row["KODE_PERBAIKAN"];?></td>
                    <td><?php echo $row["NAMA_BARANG"];?></td>
                    <?php
                        if($kode_unit != '')
                        { ?>
                            <td><?php echo $row["NAMA_UNIT"];?></td>
                        <?php }
                    ?>
                    <td><?php echo $row["NAMA_TEKNISI"];?></td>
                    <td><?php echo $row["NAMA_PART"];?></td>
                    <td align="right"><?php echo number_format($row["HARGA_PART"],0);?></td>
                    <td align="right"><?php echo $row["JUMLAH_PART"];?></td>
                    <td align="right"><?php echo number_format($subtotal,0);?></td>
                </tr>
              <?php
            }
            ?>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <?php
                if($kode_unit != '')
                { 
                ?>
                    <th></th>
                <?php 
                }
                ?>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <?php
                if($kode_unit != '')
                { 
                ?>
                    <th></th>
                <?php 
                }
                ?>
                <th></th>
                <th></th>
                <th></th>
                <td align="right"><b>Grand Total</b></td>
                <td align="right"><b><?php echo number_format($grandtot,0);?></b></td>
            </tr>
        </table>
    </body>
</html>