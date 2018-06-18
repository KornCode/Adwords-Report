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
                <test-chart :chart-data="datacollection" />
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</template>

<script>

    let data = {
        datacollection: null
    }

    export default {
        data: () => {
            isOpen: false;
            return data;
        },
        option:{
            responsive: true,
            maintainAspectRatio: true,
        },
        methods: {

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
                        impressions.push(parseInt(value.impressions));
                        avgcpc.push(parseInt(value.avgCPC)/10000);
                        cost.push(parseInt(value.cost)/1000000);
                    });
                    let click_dataset = {
                        label: 'Clicks',
                        fill: false,
                        backgroundColor: 'rgba(41, 181, 255, 0.6)',
                        data: clicks
                    }
                    let impression_dataset = {
                        label: 'Impressions',
                        fill: false,
                        backgroundColor: 'rgba(255, 44, 44, 0.6)',
                        data: impressions
                    }
                    let averageCPC_dataset = {
                        label: 'AverageCPC',
                        fill: false,
                        bordercolor: '#DC143C',
                        backgroundColor: 'rgba(255, 155, 45, 0.6)',
                        data: avgcpc
                    }
                    let cost_dataset = {
                        label: 'Cost',
                        fill: false,
                        backgroundColor: 'rgba(255, 155, 45, 0.6)',
                        bordercolor: '#DC143C',
                        data: cost
                    }
                    self.datacollection = {
                        labels: date,
                        datasets: [
                            click_dataset,
                            impression_dataset,
                            averageCPC_dataset,
                            cost_dataset
                        ]
                    }
                });
        }
    }

</script>
