<template>
    <div id="app">
        <button @click="fillData()">Randomize</button>
        <test-chart :chart-data="datacollection" />
    </div>
</template>

<script>

    let data = {
        datacollection: null
    }

    export default {
        data: () => {
            return data;
        },
        methods: {
            fillData () {
                this.datacollection = {
                labels: [this.getRandomInt(), this.getRandomInt()],
                datasets: [
                {
                    label: 'Data One',
                    backgroundColor: '#f87979',
                    data: [this.getRandomInt(), this.getRandomInt()]
                }, {
                    label: 'Data One',
                    backgroundColor: '#f87979',
                    data: [this.getRandomInt(), this.getRandomInt()]
                }
              ]
            }
          },
          getRandomInt () {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5
          }
        },
        mounted() {
            let self = this;
            axios
                .post('http://localhost:8000/test')
                .then(response => {
                    let temp = {
                        clicks: [],
                        impressions: [],
                        avgcpc: [],
                        cost: []
                    }
                    let temp_return = [];
                    _.each(response.data, function(value, key) {
                        let day = String(value.day);
                        temp_return.push(parseInt(value.clicks));
                        // temp_return[day+" 00:00:00 -0800"] = parseInt(value.clicks);
                        // temp.impressions.push({value.day: value.impressions/1000000});
                        // temp.avgcpc.push({value.day: value.avgCPC});
                        // temp.cost.push({value.day: value.cost/1000000});
                    });
                    self.datacollection = {
                        datasets: [
                        {
                            label: 'Clicks',
                            backgroundColor: '#f87979',
                            data: temp_return
                        }]
                    } 
                    console.log(self.datacollection);
                });
            }
    }

    // console.log(info)
</script>



<!-- <script>
    import { Line, Bar } from 'vue-chartjs'

    export default {
        
        extends: Bar,
        mounted () {
        // Overwriting base render method with actual data.
        this.renderChart({
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'GitHub Commits',
                    backgroundColor: '#f87979',
                    data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
                },
                {
                    label: 'GitLab Commits',
                    backgroundColor: '#00FFFF',
                    data: [32, 80, 24, 62, 5, 44, 12, 46, 78, 30, 66, 54]
                }
            ]}, {responsive: true, maintainAspectRatio: false})
        }
    }
</script> -->

<!-- <template>

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
            <line-chart :data="chartData" curve="false" download="chart" refresh="60" legend="false"></line-chart>
        </div>
    </div>
</template> -->

<!-- <script>

    var data = {
        chartData: ''
    }
    data.chartData = [
        {name: 'Clicks', data: {'2017-01-01 00:00:00 -0800': 3, 
                                '2017-01-02 00:00:00 -0800': 4,
                                '2017-01-03 00:00:00 -0800': 1, 
                                '2017-01-04 00:00:00 -0800': 4,
                                '2017-01-05 00:00:00 -0800': 7, 
                                '2017-01-06 00:00:00 -0800': 4.5,
                                '2017-01-07 00:00:00 -0800': 2.2,
                                '2017-01-08 00:00:00 -0800': 6.7, 
                                '2017-01-09 00:00:00 -0800': 5.5
                                }},
        {name: 'Impressions', data: {'2017-01-01 00:00:00 -0800': 2, 
                                '2017-01-02 00:00:00 -0800': 5,
                                '2017-01-03 00:00:00 -0800': 1, 
                                '2017-01-04 00:00:00 -0800': 3,
                                '2017-01-05 00:00:00 -0800': 6, 
                                '2017-01-06 00:00:00 -0800': 2.5,
                                '2017-01-07 00:00:00 -0800': 3.5,
                                '2017-01-08 00:00:00 -0800': 3.3, 
                                '2017-01-09 00:00:00 -0800': 7.6
                                }}
    ]

    export default {
        data: () => {
            return data;
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script> -->

