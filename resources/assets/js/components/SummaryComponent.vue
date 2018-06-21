<template>
    <div>
        <div class='col-md-12'>
            <!-- <div class="callout callout-info" style="background-color: red;"> -->
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
            
            <!-- </div> -->
        </div>
    
        <div v-if="is_loading" class="text-center">
            <i class="fa fa-refresh fa-spin fa-fw fa-4x"></i>
        </div>

        <div v-if="!is_loading">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-hand-o-up"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">Clicks</span>
                        <span class="info-box-number">{{ clicks }}</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-up"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">Impression</span>
                        <span class="info-box-number">{{ impressions }}</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-bar-chart"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">Avg. Cost-Per-Click</span>
                        <span class="info-box-number">฿ {{ avgcpc }}</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">Costs</span>
                        <span class="info-box-number">฿ {{ cost }}</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
        </div>

    </div>
</template>

<script>

    let data = {
        clicks: '',
        impressions: '',
        avgcpc: '',
        cost: '',
        config: 1,
        is_loading: false,
    }

    export default {
        data: () => {
            return data;
        },
        methods: {
            changeDate: function(value) {
                this.config = value;
            },
            getData: function() {
                let self = this;
                self.is_loading = true;
                axios
                    .post('http://localhost:8000/test', {config: self.config})
                    .then(response => {

                        let clicks = [];
                        let impressions = [];
                        let avgcpc = [];
                        let cost = [];

                        _.each(response.data, function(value, key) {
                            clicks.push(parseInt(value.clicks));
                            impressions.push(parseInt(value.impressions));
                            avgcpc.push(parseInt(value.avgCPC)/1000000);
                            cost.push(parseInt(value.cost)/1000000);
                        });

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
                        
                        self.is_loading = false;
                    });
            }
        },
        watch: {
            config: function (newVal, oldVal) {
                if (newVal === oldVal) return;
                this.getData();
            }
        },
        mounted() {
            this.getData();
        }
    }

    function insertComma(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    
</script>


