<template>
    <!-- check point -->
    <div>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="btn-group">
                    <button type="button" class="btn btn-default">Chart</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Line</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Bar</a></li>
                    </ul>
                </div>

                <button type="button" class="btn btn-info" style="width: 100px;">Click</button>
                <button type="button" class="btn btn-danger" style="width: 100px;">Impression</button>
                <button type="button" class="btn btn-warning" style="width: 100px;">Avg. CPC</button>
                <button type="button" class="btn btn-success" style="width: 100px;">Cost</button>

                <div class="btn-group" style="float: right;">
                    <button type="button" class="btn btn-default">Time</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">7 Days</a></li>
                        <li class="divider"></li>
                        <li><a href="#">2 Weeks</a></li>
                        <li class="divider"></li>
                        <li><a href="#">1 Month</a></li>
                    </ul>
                </div>

            </div>
            <div class="box-body">
                <test-chart :chart-data="datacollection" :options="options" :height="400" />
                <button class="btn btn-success" @click="testButton">Test Button</button>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</template>

<script>

    let data = {
        datacollection: null,
        options:{
            responsive: true,
            maintainAspectRatio: false,
            elements: {
                point: {
                    radius: 0
                },
                line: {
                    tension: 0
                }
            },
            gridLines: {
                display: false ,
                color: "#FFFFFF"
            },
            scales: {
                yAxes: [{
                    id: 'CLICK_AXIS',
                    type: 'linear',
                    position: 'left',
                    gridLines: {
                        display: false
                    },
                }, {
                    id: 'COST_AXIS',
                    type: 'linear',
                    position: 'right',
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        callback: function(label, index, labels) {
                            return '฿'+label;
                        }
                    },
                }]
            }
        },
    }

    export default {
        data: () => {
            isOpen: false;
            return data;
        },
        methods: {
            testButton() {
                this.options.elements.point.radius = 5;
            }
        },
        mounted() {
            let self = this;
            axios
                .post('http://localhost:8000/test')
                .then(response => {
                    let data_obj = {
                        date: [],
                        clicks: [],
                        impressions: [],
                        avgcpc: [],
                        cost: []
                    }
                    let date = [];
                    let clicks = [];
                    let impressions = [];
                    let avgcpc = [];
                    let cost = [];
                    _.each(response.data, function(value, key) {
                        // let day = String(value.day);
                        date.push(value.day);
                        clicks.push(parseInt(value.clicks));
                        // impressions.push(parseInt(value.impressions));
                        // avgcpc.push(parseInt(value.avgCPC)/10000);
                        cost.push(parseInt(value.cost)/1000000);
                    });
                    let click_dataset = {
                        label: 'Clicks',
                        fill: false,
                        borderColor: '#0073b7',
                        borderWidth: 2,
                        data: clicks,
                        yAxisID: 'CLICK_AXIS',
                    }
                    // let impression_dataset = {
                    //     label: 'Impressions',
                    //     fill: false,
                    //     borderColor: 'rgba(255, 44, 44, 1)',
                    //     data: impressions
                    // }
                    // let averageCPC_dataset = {
                    //     label: 'AverageCPC',
                    //     fill: false,
                    //     bordercolor: '#DC143C',
                    //     borderColor: 'rgba(255, 155, 45, 1)',
                    //     data: avgcpc
                    // }
                    let cost_dataset = {
                        label: 'Cost',
                        fill: false,
                        borderColor: '#00a65a',
                        borderWidth: 2,
                        data: cost,
                        yAxisID: 'COST_AXIS',
                    }
                    self.datacollection = {
                        labels: date,
                        datasets: [
                            click_dataset,
                            // impression_dataset,
                            // averageCPC_dataset,
                            cost_dataset
                        ]
                    }
                });
        }
    }

</script>
