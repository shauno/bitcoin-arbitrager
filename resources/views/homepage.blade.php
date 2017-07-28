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
    function convertObjToArray(obj, labels) {
        var array = [];

        for(date in labels) {
            array[array.length] = typeof obj[date] === 'undefined' ? null : obj[date];
        }

        return array;
    }

    jQuery.ajax({
        'url': '/api/v1/current-rates',
        'success': function(data) {
            var exchanges = [], labels = {}, buy = {}, sell = {};

            for(var exchange in data) {
                var rates = {};
                for(rate in data[exchange].current_rate) {
                    var current_rate = data[exchange].current_rate[rate]; //just a shorter var name

                    //set lall the labels
                    labels[current_rate.created_at] = current_rate.created_at;

                    //set the rate for this exchange
                    rates[current_rate.created_at] = current_rate.rate;

                    //check if this buy rate is better than any before
                    if(data[exchange].from_iso === 'XBT') {
                        if (typeof buy[current_rate.created_at] === "undefined" || current_rate.rate < buy[current_rate.created_at]) {
                            buy[current_rate.created_at] = current_rate.rate;
                        }
                    }

                    //check if this sell rate is better than any before
                    if(data[exchange].from_iso === 'ZAR') {
                        if (typeof sell[current_rate.created_at] === "undefined" || current_rate.rate > sell[current_rate.created_at]) {
                            sell[current_rate.created_at] = current_rate.rate;
                        }
                    }
                }

                //add the exchange line (the rates object needs to be converted to an array still)
                var dash = data[exchange].from_iso === 'ZAR' ? 5 : 0; // 5 = dash (sell), 0 = solid (buy)
                exchanges[exchanges.length] = {
                    label: data[exchange].exchange.name + ' ' + data[exchange].from_iso + ':' + data[exchange].to_iso ,
                    yAxisID: 'y-axis-rand',
                    data: rates, //we can't convert it to array yet because we might not have all the label keys yet
                    fill: false,
                    borderDash: [5, dash],
                    borderColor: '#216C2A', //todo, exchange related colours
                    backgroundColor: '#216C2A'
                };
            }

            //sort the labels. If some exchanges are missing dates the labels can get added with the odd point out of order
            Object.keys(labels).sort().forEach(function(key) {
                var value = labels[key];
                delete labels[key];
                labels[key] = value;
            });

            //convert each exchanges data object to array
            for(var i=0; i<exchanges.length; i++) {
                exchanges[i].data = convertObjToArray(exchanges[i].data, labels);
            }

            //work out the best arbitrage gap (if we have both buy and sell data for each date)
            var gap = {};
            for(date in labels) {
                if(typeof buy[date] !== "undefined" && typeof sell[date] !== "undefined") {
                    gap[date] = ((sell[date] - buy[date]) / sell[date]) * 100;
                }else{
                    gap[date] = null;
                }
            }

            //add the arbitrage line to the graph
            exchanges[exchanges.length] = {
                label: 'Arbitrage gap',
                yAxisID: 'y-axis-percent',
                data: convertObjToArray(gap, labels),
                fill: false
            };

            //make it so
            new Chart(document.getElementById("chart-zar-arbitrage"), {
                type: 'line',
                data: {
                    labels: convertObjToArray(labels, labels),
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