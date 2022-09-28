<?php
$year = date("Y");

$resultMonth = GetQuery("select monthname(TGL_START) as BULAN from t_perbaikan where year(TGL_START) = '$year' and STATUS_HAPUS = 0 group by month(TGL_START)");
 
?>

<script type="text/javascript" src="../plugins/highcharts/highcharts.js"></script>
<script src="highcharts/code/modules/data.js"></script>
<script type="text/javascript" src="../plugins/highcharts/exporting.js"></script>
<script type="text/javascript" src="../plugins/highcharts/export-data.js"></script>
<script src="highcharts/code/modules/drilldown.js"></script>

<script>
   Highcharts.chart('rating', {
        chart: {
            type: 'column'
        },
        title: {
            text: "Rata-rata nilai perbaikan teknisi tahun <?php echo $year; ?>"
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Poin Penilaian',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Poin'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            id: 'toplevel',
            name: '<?php echo $year; ?>',
            colorByPoint: true,
            data: [
                <?php
                $resultAvg = GetQuery("select monthname(TGL_START) as BULAN,avg(HASIL) as AVG from t_perbaikan where year(TGL_START) = '$year' and HASIL is not null group by month(TGL_START)");  
                while ($row = $resultAvg->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    ?>
                    {
                        name: '<?php echo $row["BULAN"]; ?>',
                        y: <?php echo round($row["AVG"]); ?>,
                        drilldown: '<?php echo $row["BULAN"]; ?>',
                    },
                    <?php
                }
                ?>
            ]
        }],
        drilldown: {
            series: [
                <?php
                $result2 = GetQuery("select monthname(TGL_START) as BULAN,avg(HASIL) as AVG from t_perbaikan where year(TGL_START) = '$year' and HASIL is not null group by month(TGL_START)");
                while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                    extract($row2)
                    ?>
                    { 
                        id: "<?php echo $BULAN; ?>",
                        name: "<?php echo $BULAN; ?>",
                        colorByPoint: true,
                        data: [
                            <?php
                            $result21 = GetQuery("select avg(p.HASIL) as AVG2,j.NAMA_JENIS from t_perbaikan p, m_jenisbrg j, m_barang b where p.KODE_BARANG = b.KODE_BARANG and b.KODE_JENIS = j.KODE_JENIS and year(TGL_START) = '$year' and monthname(TGL_START) = '$BULAN' and HASIL is not null group by j.KODE_JENIS");
                            while ($row21 = $result21->fetch(PDO::FETCH_ASSOC)) {
                                extract($row21);
                                ?>
                                {
                                    name: "<?php echo $NAMA_JENIS; ?>",
                                    y: <?php echo round($AVG2); ?>,
                                    drilldown: "<?php echo $NAMA_JENIS . "-" . $BULAN; ?>"
                                },
                                <?php
                            }
                            ?>
                        ] 
                    },
                    <?php
                }
                $result3 = GetQuery("select monthname(TGL_START) as BULAN,floor(avg(HASIL)) as AVG,j.NAMA_JENIS from t_perbaikan p, m_barang b, m_jenisbrg j where p.KODE_BARANG = b.KODE_BARANG and b.KODE_JENIS = j.KODE_JENIS and year(TGL_START) = '$year' and HASIL is not null group by month(TGL_START),j.NAMA_JENIS");
                while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
                    extract($row3)
                    ?>
                    { 
                        id: "<?php echo $NAMA_JENIS . "-" . $BULAN; ?>",
                        name: "<?php echo $NAMA_JENIS . "-" . $BULAN; ?>",
                        colorByPoint: true,
                        data: [
                            <?php
                            $result31 = GetQuery("select t.NAMA_TEKNISI,avg(p.HASIL) as AVG3 from t_perbaikan p, d_perbaikan d, m_jenisbrg j, m_barang b, m_teknisi t where p.KODE_PERBAIKAN = d.KODE_PERBAIKAN and d.KODE_TEKNISI = t.KODE_TEKNISI and p.KODE_BARANG = b.KODE_BARANG and b.KODE_JENIS = j.KODE_JENIS and year(TGL_START) = '$year' and monthname(TGL_START) = '$BULAN' and j.NAMA_JENIS = '$NAMA_JENIS' and HASIL is not null group by d.KODE_TEKNISI");
                            while ($row31 = $result31->fetch(PDO::FETCH_ASSOC)) {
                                extract($row31);
                                ?>
                                {
                                    name: "<?php echo $NAMA_TEKNISI; ?>",
                                    y: <?php echo round($AVG3); ?>,
                                },
                                <?php
                            }
                            ?>
                        ] 
                    },
                    <?php
                }
                ?>
            ]
        }
    });
</script>