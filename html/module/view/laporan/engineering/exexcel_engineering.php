<?php 
    require_once ("../../../../module/model/koneksi/koneksi.php");
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Perbaikan Mesin.xls");

    $PERIODE         = $_GET["PERIODE"];
    $PERIODE2        = $_GET["PERIODE2"];
    $date            = date_create("$PERIODE");
    $date2           = date_create("$PERIODE2");
    $KODE_BARANG     = "";
    $KODE_UNIT       = "";

    if($_GET["KODE_UNIT"] != '')
    {
        $KODE_BARANG = $_GET["KODE_BARANG"];
        $KODE_UNIT   = $_GET["KODE_UNIT"];
        $GO = "select X.KODE_UNIT,
                 X.KODE_BARANG, 
                 Y.NAMA_BARANG, 
                 Z.NAMA_UNIT,
                 SUM(JAM_OPR) AS JAM_OPR, 
                 SUM(FREK) AS FREK, 
                 SUM(DOWNTIME) AS DOWNTIME,
                 SUM(DURASI) AS DURASI,
                 CASE 
                   WHEN SUM(FREK) > 0 THEN (SUM(JAM_OPR)-SUM(DOWNTIME)) / SUM(FREK) 
                         ELSE 0
                 END AS MTBF, 
                 CASE 
                   WHEN SUM(FREK) > 0 THEN SUM(DOWNTIME)/SUM(FREK) 
                         ELSE 0 
                 END AS MTTR, 
                 CASE 
                   WHEN SUM(FREK) > 0 THEN ((SUM(JAM_OPR)-SUM(DOWNTIME)) / SUM(JAM_OPR))*100
                         ELSE 0 
                 END AS AVAIL 
        from (
              SELECT A1.KODE_UNIT,
                     A1.KODE_BARANG,
                     SUM(JAM_OPR) AS JAM_OPR,
                     0 AS FREK,
                     0 AS DURASI, 
                     0 AS DOWNTIME
               from  t_jamopr A1 
               WHERE A1.KODE_UNIT = '$KODE_UNIT' AND 
                     DATE_FORMAT(A1.TANGGAL,'%Y-%m-%d') BETWEEN '$PERIODE' AND '$PERIODE2'
            group BY A1.kode_barang
            UNION ALL
              SELECT KODE_UNIT,
                     KODE_BARANG,
                     0 AS JAM_OPR,
                     COUNT(KODE_PERBAIKAN) AS FREK,
                     SUM(TIMESTAMPDIFF(HOUR,TGL_PERBAIKAN, TGL_SELESAI)) AS DURASI,
                     0 AS DOWNTIME
                FROM t_perbaikan  
               WHERE KODE_UNIT = '$KODE_UNIT' AND
                     LAYANAN = 'PERBAIKAN' AND
                     date_format(TGL_START,'%Y-%m-%d') between '$PERIODE' AND '$PERIODE2'
            GROUP BY KODE_BARANG
            UNION ALL
              SELECT KODE_UNIT,
                     KODE_BARANG,
                     0 AS JAM_OPR,
                     0 AS FREK,
                     0 AS DURASI,
                     SUM(TIMESTAMPDIFF(HOUR,TGL_START, TGL_END)) AS DOWNTIME
                FROM t_perbaikan  
               WHERE KODE_UNIT = '$KODE_UNIT' AND
                     LAYANAN = 'PERBAIKAN' AND
                     STATUS_DOWNTIME = 'YA' AND
                     date_format(TGL_START,'%Y-%m-%d') between '$PERIODE' AND '$PERIODE2'
            GROUP BY KODE_BARANG
            ) X
        JOIN m_barang Y
          ON X.KODE_BARANG = Y.KODE_BARANG
        JOIN m_unit Z
          ON X.KODE_UNIT = Z.KODE_UNIT  
        group BY X.KODE_BARANG, Y.NAMA_BARANG, Z.NAMA_UNIT";

    }
    else
    {
        $KODE_BARANG = $_GET["KODE_BARANG"];
        $KODE_UNIT   = $_GET["KODE_UNIT"];
        $GO = "select X.KODE_BARANG, 
                     Y.NAMA_BARANG, 
                     SUM(JAM_OPR) AS JAM_OPR, 
                     SUM(FREK) AS FREK, 
                     SUM(DOWNTIME) AS DOWNTIME,
                     SUM(DURASI) AS DURASI,
                     CASE 
                       WHEN SUM(FREK) > 0 THEN (SUM(JAM_OPR)-SUM(DOWNTIME)) / SUM(FREK) 
                             ELSE 0
                     END AS MTBF, 
                     CASE 
                       WHEN SUM(FREK) > 0 THEN SUM(DOWNTIME)/SUM(FREK) 
                             ELSE 0 
                     END AS MTTR, 
                     CASE 
                       WHEN SUM(FREK) > 0 THEN ((SUM(JAM_OPR)-SUM(DOWNTIME)) / SUM(JAM_OPR))*100
                             ELSE 0 
                     END AS AVAIL 
            from (
                  SELECT A1.KODE_BARANG,SUM(JAM_OPR) AS JAM_OPR,
                         0 AS FREK,
                         0 AS DURASI, 
                         0 AS DOWNTIME
                   from  t_jamopr A1 
                   WHERE A1.KODE_BARANG = '$KODE_BARANG' AND 
                         DATE_FORMAT(A1.TANGGAL,'%Y-%m-%d') BETWEEN '$PERIODE' AND '$PERIODE2'
                group BY A1.kode_barang
            UNION ALL
                  SELECT KODE_BARANG,
                         0 AS JAM_OPR,
                         COUNT(KODE_PERBAIKAN) AS FREK,
                         SUM(TIMESTAMPDIFF(HOUR,TGL_PERBAIKAN, TGL_SELESAI)) AS DURASI,
                         0 AS DOWNTIME
                    FROM t_perbaikan  
                   WHERE KODE_BARANG = '$KODE_BARANG' AND
                         LAYANAN = 'PERBAIKAN' AND
                         date_format(TGL_START,'%Y-%m-%d') between '$PERIODE' AND '$PERIODE2'
                GROUP BY KODE_BARANG
            UNION ALL
                  SELECT KODE_BARANG,
                         0 AS JAM_OPR,
                         0 AS FREK,
                         0 AS DURASI,
                         SUM(TIMESTAMPDIFF(HOUR,TGL_START, TGL_END)) AS DOWNTIME
                    FROM t_perbaikan  
                   WHERE KODE_BARANG = '$KODE_BARANG' AND
                         LAYANAN = 'PERBAIKAN' AND
                         STATUS_DOWNTIME = 'YA' AND
                         date_format(TGL_START,'%Y-%m-%d') between '$PERIODE' AND '$PERIODE2'
                GROUP BY KODE_BARANG
            ) X
            JOIN m_barang Y
              ON X.KODE_BARANG = Y.KODE_BARANG
            group BY X.KODE_BARANG, Y.NAMA_BARANG";
    }
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
            <h3>Laporan Perbaikan Mesin <br/><?php echo date_format($date,'d F Y')." - ".date_format($date2,'d F Y'); ?></h3>
        </center>
 
        <table border="1">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <?php
                    if($KODE_UNIT != '')
                    { ?>
                        <th>Nama Unit</th>
                    <?php }
                ?>
                <th>Waktu Operational</th>
                <th>Frekwensi</th>
                <th>Durasi Downtime</th>
                <th>Durasi Perbaikan</th>
                <th>MTBF</th>
                <th>MTTR</th>
                <th>Availability </th>
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
                <td align="center"><?php echo $no++;?></td>
                <td><?php echo $row["NAMA_BARANG"];?></td>
                <?php 
                if($KODE_UNIT != '')
                {
                  ?>
                  <td><?php echo $row["NAMA_UNIT"];?></td>
                <?php
                }
                ?>
                <td><?php echo $row["JAM_OPR"]." jam";?></td>
                <td><?php echo $row["FREK"]." kali"; ?></td>
                <td><?php echo $row["DOWNTIME"]." jam"; ?></td>
                <td><?php echo $row["DURASI"]." jam"; ?></td>
                <td><?php echo round($row["MTBF"],3)." jam"; ?></td>
                <td><?php echo round($row["MTTR"],3)." jam"; ?></td>
                <td><?php echo round($row["AVAIL"],3)." %"; ?></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </body>
</html>