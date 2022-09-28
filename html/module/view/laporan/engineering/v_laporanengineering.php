<script type="text/javascript">
function getKODE_UNIT(val) {
      $.ajax({
      type: "POST",
      url: "cek_unit.php",
      data:'KODE_BARANG='+val,
      success: function(data){
        $("#KODE_UNIT").html(data);
      }
      });
    }
</script>

<?php
$KODE_JENIS    = "";
$KODE_BARANG   = "";
$KODE_UNIT     = "";
$GO            = "";
$PERIODE       = date("Y-m-01");
$PERIODE2      = date("Y-m-d");

if (isset($_POST["cari"])) 
{
    $PERIODE       = $_POST["PERIODE"];
    $PERIODE2      = $_POST["PERIODE2"];

    if($_POST["KODE_UNIT"] != '')
    {
        $KODE_BARANG = $_POST["KODE_BARANG"];
        $KODE_UNIT   = $_POST["KODE_UNIT"];
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
        $KODE_BARANG = $_POST["KODE_BARANG"];
        $KODE_UNIT   = $_POST["KODE_UNIT"];
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
   
}

?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-cogs fa-lg"></i> Laporan Perbaikan Mesin</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-file"></i> Laporan Perbaikan Mesin</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>

<form role="form" action="" method="post">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="KODE_BARANG">Nama Barang <span class="text-danger">*</span></label>
                <select name="KODE_BARANG" id="KODE_BARANG" required="" class="form-control" onChange="getKODE_UNIT(this.value);" data-parsley-required>
                    <option value="">Pilih Barang</option>
                    <?php
                    $result = GetData1("*","m_barang","ITEM_TYPE='MC' and STATUS='0' and KODE_JENIS='2' order by NAMA_BARANG asc");
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?php echo $row["KODE_BARANG"]; ?>"<?php if($KODE_BARANG == $row["KODE_BARANG"]) { echo "selected"; } ?>><?php echo $row["NAMA_BARANG"]; ?></option>
                                <?php
                    }
                    ?>
                </select>
            </div>                          
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="KODE_UNIT">Nama Unit <span class="text-danger">*</span></label>
                <select name="KODE_UNIT" id="KODE_UNIT" class="form-control">
                    <option value="">Pilih Unit Barang</option>
                    <?php
                    $result      = GetQuery("select * from m_unit where KODE_BARANG = '$KODE_BARANG' and STATUS = '0' order by KODE_UNIT asc");
                    while ($rowz = $result->fetch(PDO::FETCH_ASSOC)) 
                    {
                        ?>
                            <option value="<?php echo $rowz["KODE_UNIT"]; ?>"<?php if($KODE_UNIT == $rowz["KODE_UNIT"]) { echo "selected"; } ?>><?php echo $rowz["NAMA_UNIT"]; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>                          
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="PERIODE">Periode</label>
                <input type="text" class="form-control" name="PERIODE" id="datepicker1" value="<?php echo $PERIODE; ?>" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="PERIODE2" style="color: transparent;">.</label>
                <input type="text" class="form-control" name="PERIODE2" id="datepicker2" value="<?php echo $PERIODE2; ?>" />
            </div>
        </div>
        <div class="form-group">
            <label style="color: transparent;">.</label><br>
            <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-search-plus fa-lg"></i> Cari</button>&nbsp;&nbsp;&nbsp;
            <!-- <a href="laporanengineering" type="button" class="btn btn-danger"><i class="fa fa-refresh fa-lg"></i> Clear</a> -->
        </div>       
    </div>
</form>
<br>
<div class="row">
    <div class="col-md-12" align="center">
        <div class="btn-group" style="margin-bottom:5px;">
            <button type="button" class="btn btn-warning mb5 dropdown-toggle" data-toggle="dropdown" style="color: black;"><i class="fa fa-print fa-lg"></i> Export Laporan <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">

                <?php 
                if ($KODE_UNIT != '')
                {
                ?>
                    <li>
                        <a href="module\view\laporan\engineering\exexcel_engineering.php?KODE_BARANG=<?php echo $KODE_BARANG;?>&KODE_UNIT=<?php echo $KODE_UNIT; ?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Excel</a>
                    </li>
                <?php
                }
                else
                {
                ?>
                    <li>
                        <a href="module\view\laporan\engineering\exexcel_engineering.php?KODE_BARANG=<?php echo $KODE_BARANG;?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Excel</a>
                    </li>
                <?php
                }
                ?>

                
            </ul>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                    if(isset($_POST["KODE_BARANG"]))
                    {
                    ?>
                        <h3 class="panel-title">Laporan Engineering </h3>
                    <?php
                    }
                    ?>

            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Opsi</th>
                        <th>Nama Barang</th>
                        <?php
                            if($KODE_UNIT != '')
                            { ?>
                                <th>Nama Unit</th>
                            <?php }
                        ?>
                        <th>Waktu Operational</th>
                        <th>Frekwensi Kerusakan</th>
                        <th>Durasi Downtime</th>
                        <th>Durasi Perbaikan</th>
                        <th>MTBF</th>
                        <th>MTTR</th>
                        <th>Availability </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = getQuery("$GO");
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                        {
                            //MTBF = (waktu operational - durasi downtime) / frekwensi
                            //MTTR = durasi downtime / frekwensi
                            //Avail= (waktu operational - durasi downtime) / waktu operational
                        ?>
                            <tr>
                                <?php
                                    if($KODE_UNIT != '')
                                    { 
                                    ?>
                                        <td align="center"><a href="lap_engineeringdetail.php?kode_barang=<?php echo $row['KODE_BARANG'];?>&kode_unit=<?php echo $row['KODE_UNIT']; ?>&periode=<?php echo $PERIODE; ?>&periode2=<?php echo $PERIODE2?>" class="btn btn-rounded btn-success mb5"><i class="fa fa-folder-open fa-lg"></i> Detail</a></td>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <td align="center"><a href="lap_engineeringdetail.php?kode_barang=<?php echo $row['KODE_BARANG'];?>&periode=<?php echo $PERIODE; ?>&periode2=<?php echo $PERIODE2?>" class="btn btn-rounded btn-success mb5"><i class="fa fa-folder-open fa-lg"></i> Detail</a></td>
                                    <?php
                                    }
                                ?>
                                <td><?php echo $row["NAMA_BARANG"];?></td>
                                <?php
                                    if($_POST["KODE_UNIT"] != '')
                                    { ?>
                                        <td><?php echo $row["NAMA_UNIT"];?></td>
                                    <?php }
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
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function(){
        // Find any date inputs and override their functionality
        $('#datepicker1').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>