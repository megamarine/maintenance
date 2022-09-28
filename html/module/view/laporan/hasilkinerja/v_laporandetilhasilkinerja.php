<?php
$KODE_TEKNISI = $_GET["KODE_TEKNISI"];
$PERIODE      = date("Y-m-01");
$PERIODE2     = date("Y-m-d");

$result       = GetQuery("select * from m_teknisi where KODE_TEKNISI = '$KODE_TEKNISI'");
while ($row   = $result->fetch(PDO::FETCH_ASSOC)) 
{
    extract($row);
}
if (isset($_POST["cari"])) 
{
    $PERIODE  = $_POST["PERIODE"];
    $PERIODE2 = $_POST["PERIODE2"];
}

$result2 = GetQuery(
    "select p.KODE_PERBAIKAN,
     b.NAMA_BARANG,
     p.IP_ADD,
     p.LAYANAN,
     p.KERUSAKAN,
     p.SOLUSI,
     DATE_FORMAT(TGL_START, '%d %M %Y') as TGL_START,
     DATE_FORMAT(TGL_SELESAI, '%d %M %Y') as TGL_END,
     DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
     DATE_FORMAT(TGL_SELESAI, '%H:%i:%s') as JAM_END,
     p.TGL_START as TGL_STARTS,
     p.TGL_END as TGL_ENDS,
     p.DURASI,
     p.HASIL,
     e.NAMA_DEPARTEMEN,
     t.NAMA_TEKNISI 
    from d_perbaikan d, 
     t_perbaikan p, 
     m_barang b, 
     m_departemen e, 
     m_teknisi t 
    where d.KODE_PERBAIKAN = p.KODE_PERBAIKAN and 
     p.KODE_BARANG = b.KODE_BARANG and 
     p.KODE_DEPARTEMEN = e.KODE_DEPARTEMEN and 
     d.KODE_TEKNISI = t.KODE_TEKNISI and 
     date(p.TGL_SELESAI) between '$PERIODE' and '$PERIODE2' and 
     d.KODE_TEKNISI = '$KODE_TEKNISI' and 
     d.STS_HAPUS = 0 and 
     p.STATUS_HAPUS = 0 and 
     p.HASIL is not null 
    group by p.KODE_PERBAIKAN");

$result3 = GetQuery(
   "select sum(p.DURASI) as DURASI2, 
    avg(p.HASIL) as HASIL2,
    t.HARI_KERJA,
    t.JAM_KERJA 
   from t_perbaikan p, 
    d_perbaikan d, 
    m_teknisi t 
   where p.KODE_PERBAIKAN = d.KODE_PERBAIKAN and 
    d.KODE_TEKNISI = t.KODE_TEKNISI and 
    d.KODE_TEKNISI = '$KODE_TEKNISI' and 
    date(p.TGL_SELESAI) between '$PERIODE' and '$PERIODE2' and 
    d.STS_HAPUS = 0 and 
    p.STATUS_HAPUS = 0 and 
    p.HASIL is not null");

while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) 
{
    extract($row3);
    $HASIL2 = round($HASIL2);
}

// Get Total Weekday
$resultWork = GetQuery(
    "select 5 * (DATEDIFF('$PERIODE2', '$PERIODE') DIV 7) + MID('0123444401233334012222340111123400012345001234550', 7 * WEEKDAY('$PERIODE') + WEEKDAY('$PERIODE2') + 1, 1) as WORKDAY");
while ($rowWork = $resultWork->fetch(PDO::FETCH_ASSOC)) 
{
    extract($rowWork);
}
// End Get Total Weekday

$resultLembur = GetQuery(
    "select count(KODE_HADIR) as TOTAL_LEMBUR 
    from t_kehadiran 
    where TANGGAL between '$PERIODE' and '$PERIODE2' and 
     STATUS_ABSENSI = 0 and 
     KODE_TEKNISI = '$KODE_TEKNISI' and ABSENSI = 'Lembur' and weekday(TANGGAL) between 5 and 6");
while ($rowLembur = $resultLembur->fetch(PDO::FETCH_ASSOC)) 
{
    extract($rowLembur);
}

$resultCuti = GetQuery(
    "select count(KODE_HADIR) as TOTAL_CUTI 
    from t_kehadiran 
    where TANGGAL between '$PERIODE' and '$PERIODE2' and STATUS_ABSENSI = 0 and 
     KODE_TEKNISI = '$KODE_TEKNISI' and 
     ABSENSI = 'Cuti'");
while ($rowCuti = $resultCuti->fetch(PDO::FETCH_ASSOC)) 
{
    extract($rowCuti);
}

$TOTAL_KERJA       = ($WORKDAY + $TOTAL_LEMBUR - $TOTAL_CUTI) * $JAM_KERJA;
$TOTAL_HASIL_KERJA = ($DURASI2 / $TOTAL_KERJA) * 50;

$TOTAL_HASIL_NILAI = ($HASIL2 / 5) * 50;
$TOTAL_KERJA_NILAI = $TOTAL_HASIL_KERJA + $TOTAL_HASIL_NILAI;

if ($TOTAL_KERJA_NILAI > 100) {
    $TOTAL_KERJA_NILAI = 100;
}

if ($TOTAL_KERJA_NILAI > 90) {
    $HURUF_NILAI = "A";
} elseif ($TOTAL_KERJA_NILAI > 80) {
    $HURUF_NILAI = "B";
} elseif ($TOTAL_KERJA_NILAI > 70) {
    $HURUF_NILAI = "C";
} else {
    $HURUF_NILAI = "D";
}
?>
<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><i class="fa fa-edit fa-lg"></i> Laporan Detil Hasil Kinerja <?php echo $NAMA_TEKNISI; ?></h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="menuutama"><i class="ico-home2"></i> Dashboard</a></li>
                <li><a href="laporanhasilkinerja"><i class="fa fa-file fa-lg"></i> Laporan Hasil Kinerja</a></li>
                <li class="active"><i class="fa fa-edit fa-lg"></i> Laporan Detil Hasil Kinerja</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>
<form role="form" action="" method="post">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="PERIODE">Periode</label>
                <input type="text" class="form-control" name="PERIODE" id="datepicker1" value="<?php echo $PERIODE; ?>" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="PERIODE2" style="color: transparent;">.</label>
                <input type="text" class="form-control" name="PERIODE2" id="datepicker2" value="<?php echo $PERIODE2; ?>" />
            </div>
        </div>
        <div class="form-group">
            <label style="color: transparent;">.</label><br>
            <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-search-plus fa-lg"></i> Cari</button>&nbsp;&nbsp;&nbsp;
            <a href="laporandetilkinerja?KODE_TEKNISI=<?php echo $KODE_TEKNISI; ?>" type="button" class="btn btn-danger"><i class="fa fa-refresh fa-lg"></i> Clear</a>
        </div>       
    </div>
</form>
<div class="row">
    <div class="col-md-12" align="right">
        <div class="btn-group" style="margin-bottom:5px;">
            <button type="button" class="btn btn-rounded btn-warning mb5 dropdown-toggle" data-toggle="dropdown" style="color: black;"><i class="fa fa-print fa-lg"></i> Cetak Laporan <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="print_kpi?KODE_TEKNISI=<?php echo $KODE_TEKNISI; ?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Cetak Laporan KPI</a></li>
                <li><a href="print_hasilkinerja?KODE_TEKNISI=<?php echo $KODE_TEKNISI; ?>&PERIODE=<?php echo $PERIODE; ?>&PERIODE2=<?php echo $PERIODE2; ?>" type="button" style="color: black;" target="_blank">Cetak Laporan Detail</a></li>
            </ul>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Hasil Kinerja Karyawan</h3>
            </div>
            <table class="table table-striped table-bordered" id="table-tools">
                <thead>
                    <tr>
                        <th>Kode Perbaikan</th>
                        <th>Departemen</th>
                        <th>Teknisi</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Selesai</th>
                        <th>Nama Barang</th>
                        <th>Layanan</th>
                        <th>Kerusakan</th>
                        <th>Solusi</th>
                        <th>Durasi</th>
                        <th>Hasil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="9" class="text-center" style="color: black;">Total Durasi dan Rata-rata Nilai</th>
                        <th class="text-center text-primary"><?php echo $DURASI2; ?></th>
                        <th>
                            <?php
                            if ($HASIL2 > 4) {
                                ?>
                                <img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/fullstar2.png">
                                <?php
                            } elseif ($HASIL2 > 3) {
                                ?>
                                <img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/emptystar.png">
                                <?php
                            } elseif ($HASIL2 > 2) {
                                ?>
                                <img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                <?php
                            } elseif ($HASIL2 > 1) {
                                ?>
                                <img src="images/fullstar2.png"><img src="images/fullstar2.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                <?php
                            }
                            elseif ($HASIL2 > 0) {
                                ?>
                                <img src="images/fullstar2.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                <?php
                            } else {
                                ?>
                                <img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                <?php
                            }
                            ?>
                        </th>
                    </tr>
                    <?php
                    if ($KODE_JENIS == 2) {
                        ?>
                        <tr>
                            <th colspan="9" class="text-center" style="color: black;">Total Skor dan Nilai</th>
                            <th class="text-center text-danger"><b><?php echo round($TOTAL_KERJA_NILAI) . " %"; ?></b></th>
                            <th class="text-center text-danger"><b><?php echo $HURUF_NILAI; ?></b></th>
                        </tr>
                        <?php
                    }
                    ?>
                </tfoot>
                <tbody>
                    <?php
                    while ($row = $result2->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        ?>
                        <tr>
                            <td align="center"><?php echo $KODE_PERBAIKAN; ?></td>
                            <td align="center"><?php echo $NAMA_DEPARTEMEN; ?></td>
                            <td align="center"><?php echo $NAMA_TEKNISI; ?></td>
                            <td align="center"><?php echo $TGL_START; ?> <br> <?php echo $JAM_START; ?></td>
                            <td align="center"><?php echo $TGL_END; ?> <br> <?php echo $JAM_END; ?></td>
                            <td align="center"><?php echo $NAMA_BARANG; ?> <br> <?php echo $IP_ADD; ?></td>
                            <td align="center"><?php echo $LAYANAN; ?></td>
                            <td><?php echo $KERUSAKAN; ?></td>
                            <td><?php echo $SOLUSI; ?></td>
                            <td align="center"><?php echo $DURASI; ?></td>
                            <td align="center">
                                <?php
                                if ($HASIL > 4) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png">
                                    <?php
                                } elseif ($HASIL > 3) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png">
                                    <?php
                                } elseif ($HASIL > 2) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                } elseif ($HASIL > 1) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                }
                                elseif ($HASIL > 0) {
                                    ?>
                                    <img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                } else {
                                    ?>
                                    <img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">
                                    <?php
                                }
                                ?>
                            </td>
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