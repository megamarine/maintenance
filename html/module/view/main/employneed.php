<script src="highcharts/code/highcharts.js"></script>
<script src="highcharts/code/modules/data.js"></script>
<script src="highcharts/code/modules/drilldown.js"></script>

<script type="text/javascript">

// Create the chart
Highcharts.chart('highcharts', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Karyawan Dibutuhkan'
    },
    subtitle: {
        text: 'Klik untuk melihat detail'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total karyawan yang dibutuhkan'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
    },

    series: [{
        name: 'Company',
        colorByPoint: true,
        data: [
            <?php
            $query = "select p.NAMA_PERUSAHAAN,sum(t.SISA) as SISA from m_perusahaan p, t_ptk t where t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and t.APP_DIREKTUR1 = 1 group by t.KODE_PERUSAHAAN";
            $result = mysql_query($query, $DB1);
            while($row = mysql_fetch_array($result))
            {
            ?>
                {
                    name: '<?php echo $row["NAMA_PERUSAHAAN"]; ?>',
                    y: <?php echo $row["SISA"]; ?>,
                    drilldown: '<?php echo $row["NAMA_PERUSAHAAN"]; ?>',
                },
            <?php
            }
            ?>
        ]
    }],
    drilldown: {
        series: [
        <?php
        $query = "select p.NAMA_PERUSAHAAN,b.NAMA_BAGIAN,sum(t.SISA) as SISA from t_ptk t, m_bagian b, m_perusahaan p where t.KODE_BAGIAN = b.KODE_BAGIAN and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN group by t.KODE_BAGIAN";
        $result = mysql_query($query, $DB1);
        while ($row = mysql_fetch_array($result)) {
            $NAMA_PERUSAHAAN = $row["NAMA_PERUSAHAAN"];
            ?>
            {
                name: '<?php echo $NAMA_PERUSAHAAN; ?>',
                id: '<?php echo $NAMA_PERUSAHAAN; ?>',
                data: [
                    <?php
                    $query2 = "select d.NAMA_DEPARTEMEN,sum(t.SISA) as SISA from t_ptk t, m_departemen d, m_perusahaan p where t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and p.NAMA_PERUSAHAAN = '$NAMA_PERUSAHAAN' and t.SISA != 0 and t.APP_DIREKTUR1 = 1 group by t.KODE_DEPARTEMEN";
                    $result2 = mysql_query($query2);
                    while ($row2 = mysql_fetch_array($result2)) {
                        ?>
                        {
                            name: '<?php echo $row2["NAMA_DEPARTEMEN"]; ?>',
                            y: <?php echo $row2["SISA"]; ?>,
                            drilldown: '<?php echo $row2["NAMA_DEPARTEMEN"]; ?>',
                        },
                        <?php
                    }
                    ?>
                ]
            },
            <?php
            $query3 = "select p.NAMA_PERUSAHAAN,b.NAMA_BAGIAN,sum(t.SISA) as SISA from t_ptk t, m_bagian b, m_perusahaan p where t.KODE_BAGIAN = b.KODE_BAGIAN and t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and p.NAMA_PERUSAHAAN = '$NAMA_PERUSAHAAN' group by t.KODE_BAGIAN";
            $result3 = mysql_query($query3, $DB1);
            while ($row3 = mysql_fetch_array($result3)) {
                $NAMA_BAGIAN = $row3["NAMA_BAGIAN"];
                ?>
                {
                    name: '<?php echo $NAMA_BAGIAN; ?>',
                    id: '<?php echo $NAMA_BAGIAN; ?>',
                    data: [
                        <?php
                        $query4 = "select d.NAMA_DEPARTEMEN,sum(t.SISA) as SISA from t_ptk t, m_perusahaan p, m_bagian b, m_departemen d where t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and t.KODE_BAGIAN = b.KODE_BAGIAN and t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and p.NAMA_PERUSAHAAN = '$NAMA_PERUSAHAAN' and t.SISA != 0 and t.APP_DIREKTUR1 = 1 group by d.NAMA_DEPARTEMEN";
                        $result4 = mysql_query($query4);
                        while ($row4 = mysql_fetch_array($result4)) {
                            ?>
                            {
                                name: '<?php echo $row4["NAMA_DEPARTEMEN"]; ?>',
                                y: <?php echo $row4["SISA"]; ?>,
                                drilldown: '<?php echo $row4["NAMA_DEPARTEMEN"]; ?>',
                            },
                            <?php
                        }
                        ?>
                    ]
                },
                <?php
                $query9 = "select d.NAMA_DEPARTEMEN,sum(t.SISA) as SISA from t_ptk t, m_perusahaan p, m_bagian b, m_departemen d where t.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and t.KODE_BAGIAN = b.KODE_BAGIAN and t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and p.NAMA_PERUSAHAAN = '$NAMA_PERUSAHAAN' and t.SISA != 0 group by  NAMA_DEPARTEMEN";
                $result9 = mysql_query($query9);
                while($row9 = mysql_fetch_array($result9))
                {
                    $NAMA_DEPARTEMEN = $row9["NAMA_DEPARTEMEN"];
                ?>
                    {
                        name: '<?php echo $row9["NAMA_DEPARTEMEN"]; ?>',
                        id: '<?php echo $row9["NAMA_DEPARTEMEN"]; ?>',
                        data: [
                            <?php
                            $query21 = "select j.NAMA_JABATAN,sum(t.SISA) as SISA from t_ptk t, m_jabatan j, m_departemen d where t.KODE_JABATAN = j.KODE_JABATAN and t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and d.NAMA_DEPARTEMEN = '$NAMA_DEPARTEMEN' and t.SISA != 0 and t.APP_DIREKTUR1 = 1 group by t.KODE_JABATAN";
                            $result21 = mysql_query($query21);
                            while($rows = mysql_fetch_array($result21))
                            {
                            ?>
                                {
                                    name: '<?php echo $rows["NAMA_JABATAN"]; ?>',
                                    y: <?php echo $rows["SISA"]; ?>,
                                    drilldown: '<?php echo $rows["NAMA_JABATAN"]; ?>',
                                },
                                <?php
                            }
                            ?>
                        ]
                    },
                <?php
                }
            }
        }
        ?>
        ]
    }
});
</script>