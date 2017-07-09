<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div style="width: 1200px; display: inline-block;">
    <canvas id="chart-zar-arbitrage"></canvas>
</div>

<script src="/js/Chart.bundle.min.js"></script>
<script src="/js/jquery-3.2.1.min.js"></script>

<script>
    jQuery.ajax({
        'url': '/api/v1/current-rates',
        'success': function(data) {
            var exchanges = [], labels = [];

            for (i in data) {
                var rates = [];

                for(rate in data[i].current_rate) {
                    var key = data[i].current_rate[rate];
                    //console.log(key);
                    rates[rates.length] = {x: key.created_at, y: key.rate};
                    if ( jQuery.inArray( key.created_at, labels ) == -1 ) {
                        labels[labels.length] = key.created_at;
                    }
                }


                var dash = data[i].from_iso == 'ZAR' ? 5 : 0;
                exchanges[exchanges.length] = {
                    label: data[i].exchange.name + ' ' + data[i].from_iso + ':' + data[i].to_iso ,
                    yAxisID: 'y-axis-rand',
                    data: rates,
                    fill: false,
                    borderDash: [5, dash]
                };
            }

            new Chart(document.getElementById("chart-zar-arbitrage"), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: exchanges
                },
                options: {
                    elements: {
                        point: {
                            radius: 0,
                            hitRadius: 4,
                            hoverRadius: 4
                        }
                    },
                    scales: {
                        yAxes: [
                            {
                                position: 'left',
                                id: 'y-axis-rand'
                            },
                            {
                                position: 'right',
                                id: 'y-axis-percent'
                            }
                        ]
                    }
                }
            });
        }
    });
</script>
</body>
</html>