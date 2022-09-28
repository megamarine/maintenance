<script type="text/javascript" src="../plugins/highcharts/highcharts.js"></script>
<script type="text/javascript" src="../plugins/highcharts/exporting.js"></script>
<script type="text/javascript" src="../plugins/highcharts/export-data.js"></script>
<script src="highcharts/code/modules/drilldown.js"></script>

<script>
// Radialize the colors
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: "Jumlah perbaikan oleh teknisi tahun <?php echo $year; ?>"
    },
    subtitle: {
        text: 'Klik kategori untuk melihat detil maintenance'
    },
    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.2f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [
        {
            id: "toplevel",
            name: 'Bulan',
            data: [
                <?php
                $result = GetQuery("select count(KODE_PERBAIKAN) as COUNT,monthname(TGL_START) as BULAN from t_perbaikan where year(TGL_START) = '$year' and STATUS_HAPUS = 0 group by month(TGL_START)");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    {name: "<?php echo $row["BULAN"]; ?>", y: <?php echo $row["COUNT"]; ?>, drilldown: "<?php echo $row["BULAN"]; ?>"},
                    <?php
                }
                ?>
            ]
        }],
        drilldown: {
            series: [ 
                <?php
                $result = GetQuery("select count(KODE_PERBAIKAN) as COUNT,monthname(TGL_START) as BULAN from t_perbaikan where year(TGL_START) = '$year' and STATUS_HAPUS = 0 group by month(TGL_START)");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $BULAN = $row["BULAN"];
                    $result3 = GetQuery("select sum(STATUS) as SUM from t_perbaikan where monthname(TGL_START) = '$BULAN' and year(TGL_START) = '$year' and STATUS_HAPUS = 0");
                    while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
                        $SUM = $row3["SUM"];
                    }
                    ?>
                    { 
                        id: "<?php echo $row["BULAN"]; ?>",
                        name: "<?php echo $row["BULAN"]; ?>",
                        data: [
                            <?php
                            $result2 = GetQuery("select count(KODE_PERBAIKAN) as COUNT2,j.NAMA_JENIS from t_perbaikan p, m_barang b, m_jenisbrg j where p.KODE_BARANG = b.KODE_BARANG and b.KODE_JENIS = j.KODE_JENIS and p.STATUS = 1 and year(p.TGL_START) = '$year' and monthname(p.TGL_START) = '$BULAN' and p.STATUS_HAPUS = 0 group by j.NAMA_JENIS");
                            while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                                $PERCENT = $row2["COUNT2"] / $SUM * 100;
                                ?>
                                {name: "<?php echo $row2["NAMA_JENIS"]; ?>", y: <?php echo $PERCENT; ?>, drilldown: "<?php echo $row2["NAMA_JENIS"] . "-" .$BULAN; ?>"},
                                <?php
                            }
                            ?>
                        ] 
                    },
                    <?php
                }
                $result = GetQuery("select j.NAMA_JENIS,monthname(p.TGL_START) as BULAN from t_perbaikan p, m_barang b, m_jenisbrg j where p.KODE_BARANG = b.KODE_BARANG and b.KODE_JENIS = j.KODE_JENIS and p.STATUS_HAPUS = 0 group by month(p.TGL_START),j.NAMA_JENIS");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $NAMA_JENIS = $row["NAMA_JENIS"];
                    $BULAN = $row["BULAN"];
                    $result3 = GetQuery("select sum(p.STATUS) as SUM2 from t_perbaikan p, m_barang b, m_jenisbrg j where p.KODE_BARANG = b.KODE_BARANG and b.KODE_JENIS = j.KODE_JENIS and monthname(p.TGL_START) = '$BULAN' and year(p.TGL_START) = '$year' and j.NAMA_JENIS = '$NAMA_JENIS' and p.STATUS_HAPUS = 0");
                    while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
                        $SUM2 = $row3["SUM2"];
                    }
                    ?>
                    {                
                    id: "<?php echo $row["NAMA_JENIS"] . "-" . $row["BULAN"]; ?>",
                    name: "<?php echo $row["NAMA_JENIS"] . "-" . $row["BULAN"]; ?>",
                    data: [
                        <?php
                        $result2 = GetQuery("select count(p.KODE_PERBAIKAN) as COUNT3,b.NAMA_BARANG
                        from t_perbaikan p, m_barang b, m_jenisbrg j
                        where p.KODE_BARANG = b.KODE_BARANG and b.KODE_JENIS = j.KODE_JENIS and monthname(p.TGL_START) = '$BULAN' and year(p.TGL_START) = '$year' and j.NAMA_JENIS = '$NAMA_JENIS' and p.STATUS = 1 and p.STATUS_HAPUS = 0 group by b.NAMA_BARANG");
                        while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                            $PERCENT2 = $row2["COUNT3"] / $SUM2 * 100;
                            ?>
                            {name: "<?php echo $row2["NAMA_BARANG"]; ?>", y: <?php echo $PERCENT2; ?>, drilldown: "<?php echo $row2["NAMA_BARANG"]; ?>"},
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