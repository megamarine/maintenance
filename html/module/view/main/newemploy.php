<script src="highcharts/code/highcharts.js"></script>
<script src="highcharts/code/modules/data.js"></script>
<script src="highcharts/code/modules/drilldown.js"></script>

<script type="text/javascript">

// Create the chart
Highcharts.chart('charts', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Karyawan Diterima per Tahun'
    },
    subtitle: {
        text: 'Klik untuk melihat detail'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total karyawan yang diterima'
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
        name: 'Tahun',
        colorByPoint: true,
        data: [
            <?php
            $query = "select year(TANGGAL_MASUK) as TANGGAL_MASUK,sum(JUMLAH) as JUMLAH from t_masuk group by year(TANGGAL_MASUK) limit 5";
            $result = mysql_query($query, $DB1);
            while($row = mysql_fetch_array($result))
            {
            ?>
                {
                    name: '<?php echo $row["TANGGAL_MASUK"]; ?>',
                    y: <?php echo $row["JUMLAH"]; ?>,
                    drilldown: '<?php echo $row["TANGGAL_MASUK"]; ?>',
                },
            <?php
            }
            ?>
        ]
    }],
    drilldown: {
        series: [{
            id: '2017',
            name: 'Animals',
            data: [{
                name: 'Cats',
                y: 4,
                drilldown: 'cats'
            }, ['Dogs', 2],
                ['Cows', 1],
                ['Sheep', 2],
                ['Pigs', 1],
            {
                name: 'Oww',
                y: 4,
                drilldown: 'cats'
            }, ['Dogs', 2],
                ['Cows', 1],
                ['Sheep', 2],
                ['Pigs', 1],
            
            ],
        }, 
        {
            id: '2016',
            name: 'Pets',
            data: [{
                name: 'Cats',
                y: 4,
                drilldown: 'cats'
            }, ['Dogs', 2],
                ['Cows', 1],
                ['Sheep', 2],
                ['Pigs', 1]
            ],
        }, 
        
        {
            name: 'test',
            id: 'cats',
            data: [1, 2, 3]
        },
        {
            name: 'test',
            id: 'Pigs',
            data: [1, 2, 3]
        }]
    }
});
</script>