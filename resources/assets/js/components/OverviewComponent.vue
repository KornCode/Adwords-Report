<template>
    <div>
        <div class='col-md-12'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title" style="font-size: 25px; margin-top: 5px;">
                        <div v-if="config_date == 1">Summary - Today</div>
                        <div v-else-if="config_date == 2">Summary - Yesterday</div>
                        <div v-else-if="config_date == 3">Summary - Last 3 Days</div>
                        <div v-else-if="config_date == 7">Summary - Last 7 Days</div>
                        <div v-else-if="config_date == 14">Summary - Last 14 Days</div>
                        <div v-else-if="config_date == 30">Summary - Last 30 Days</div>
                        <div v-else-if="config_date == 90">Summary - Last 3 Months</div>
                        <div v-else-if="config_date == 180">Summary - Last 6 Months</div>
                        <div v-else-if="config_date == 1365">Summary - Last 1 Year</div>
                        <div v-else-if="config_date == 3650">Summary - All Time</div>
                    </h2>
                    <div class="btn-group" style="float: right;">
                        <select v-model="config_date" class="selectpicker show-tick" data-width="200px">
                            <option v-for="selectOption in selectOptionsDate" v-bind:value="selectOption.value">
                                {{ selectOption.text }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box box-default">
                <div class="box-body">
                    <div v-if="this.config_date === 1">
                        <div style="font-size: 20px;">
                            Chart do not show for selected date.
                        </div>
                    </div>
                    <div v-else>
                        <test-chart :chart-data="datacollection" :options="options" :height="420" />
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-hand-o-up"></i></span>
                <div class="info-box-content">
                    <div v-if="is_loading_summary">
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                    <div v-else>
                        <span class="info-box-text">Clicks</span>
                        <span class="info-box-number">{{ clicks }}</span>
                    </div>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-up"></i></span>

                <div class="info-box-content">
                    <div v-if="is_loading_summary">
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                    <div v-else>
                        <span class="info-box-text">Impressions</span>
                        <span class="info-box-number">{{ impressions }}</span>
                    </div>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-bar-chart"></i></span>
    
                <div class="info-box-content">
                    <div v-if="is_loading_summary">
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                    <div v-else>
                        <span class="info-box-text">Avg. Cost-Per-Click</span>
                        <span class="info-box-number">฿ {{ avgcpc }}</span>
                    </div>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>
    
                <div class="info-box-content">
                    <div v-if="is_loading_summary">
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                    <div v-else>
                        <span class="info-box-text">Costs</span>
                        <span class="info-box-number">฿ {{ cost }}</span>
                    </div>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>
</template>

<script>
    let data = {
        clicks: '',
        impressions: '',
        avgcpc: '',
        cost: '',
        config_date: 30, // default when loaded
        is_loading_summary: false,
        datacollection: null,
        selectOptionsDate: [
            { text: 'Today', value: 1 },
            { text: 'Yesterday', value: 2 },
            { text: 'Last 3 days', value: 3 },
            { text: 'Last 7 days', value: 7 },
            { text: 'Last 14 days', value: 14 },
            { text: 'Last 30 days', value: 30 },
            { text: 'Last 3 months', value: 90 },
            { text: 'Last 6 months', value: 180 },
            { text: 'Last 1 year', value: 365 },
            { text: 'All time', value: 3650 }
        ],
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
                }, 
                {
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
    }

    export default {
        data: () => {
            isOpen: false;
            return data;
        },
        methods: {
            // changeDate: function() {
            //     this.config = this.selectOptions.value;
            // },
            getData: function() {
                let self = this;
                self.is_loading_summary = true;
                axios
                    .post('http://localhost:8000/overview', {config: this.config_date})
                    .then(response => {

                        let date = [];
                        let clicks = [];
                        let impressions = [];
                        let avgcpc = [];
                        let cost = [];

                        _.each(response.data[0], function(value, key) {
                            date.push(value.day);
                            clicks.push(parseInt(value.clicks));
                            impressions.push(parseInt(value.impressions));
                            avgcpc.push(parseInt(value.avgCPC)/1000000);
                            cost.push(parseInt(value.cost)/1000000);
                        });

                        /*
                        |-------------------------------------------
                        | Chart Mananagement
                        |-------------------------------------------
                        */
                        let click_dataset = {
                            label: 'Clicks',
                            fill: false,
                            borderColor: '#0073b7',
                            borderWidth: 2,
                            data: clicks,
                            yAxisID: 'CLICK_AXIS',
                        }
                        let impression_dataset = {
                            label: 'Impressions',
                            fill: false,
                            hidden: true,
                            borderColor: 'rgba(255, 44, 44, 1)',
                            borderWidth: 2,
                            data: impressions
                        }
                        let averageCPC_dataset = {
                            label: 'AverageCPC',
                            fill: false,
                            hidden: true,
                            borderColor: 'rgba(255, 155, 45, 1)',
                            borderWidth: 2,
                            data: avgcpc
                        }
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
                                impression_dataset,
                                averageCPC_dataset,
                                cost_dataset
                            ]
                        }

                        /*
                        |-------------------------------------------
                        | Box Mananagement
                        |-------------------------------------------
                        */
                        data.clicks = clicks.reduce((sum, click) => {
                            return sum + click
                        }, 0);
                        data.clicks = insertComma(data.clicks);

                        data.impressions = impressions.reduce((sum, impression) => {
                            return sum + impression
                        }, 0);
                        data.impressions = insertComma(data.impressions);

                        data.avgcpc = avgcpc.reduce((sum, avgcpc) => {
                            return sum + avgcpc
                        }, 0) / avgcpc.length;
                        data.avgcpc = data.avgcpc.toFixed(2);
                        data.avgcpc = insertComma(data.avgcpc);

                        data.cost = cost.reduce((sum, cost) => {
                            return sum + cost
                        }, 0);
                        data.cost = data.cost.toFixed(2);
                        data.cost = insertComma(data.cost);
                        
                        self.is_loading_summary = false;
                    });
            }
        },
        watch: {
            config_date: function (newVal, oldVal) {
                if (newVal === oldVal) return;
                this.getData();
            },
        },
        mounted() {
            this.getData();
        }
    }

    function insertComma(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

</script>