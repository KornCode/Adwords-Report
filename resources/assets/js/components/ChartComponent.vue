<template>
<!-- CHECK POINT -->
    <div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title" style="font-size: 25px; margin-top: 5px;">Summary</h2>
                <div class="btn-group" style="float: right;">
                    <button type="button" class="btn btn-default" @click="changeDate(1)">Today</button>
                    <button type="button" class="btn btn-default" @click="changeDate(7)">1 Week</button>
                    <button type="button" class="btn btn-default" @click="changeDate(14)">2 Weeks</button>
                    <button type="button" class="btn btn-default" @click="changeDate(30)">1 Month</button>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <test-chart :chart-data="datacollection" :options="options" :height="400" />
            </div>
        </div>
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
                    radius: 2
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
                            return '฿' + label;
                        }
                    },
                }]
            }
        },
        config: 14
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
                .post('http://localhost:8000/test', {config: this.config})
                .then(response => {
                    let date = [];
                    let clicks = [];
                    let impressions = [];
                    let avgcpc = [];
                    let cost = [];
                    _.each(response.data, function(value, key) {
                        date.push(value.day);
                        clicks.push(parseInt(value.clicks));
                        // impressions.push(parseInt(value.impressions));
                        // avgcpc.push(parseInt(value.avgCPC)/1000000);
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

    function duration(length, range) {
        return length - range;
    }

</script>
