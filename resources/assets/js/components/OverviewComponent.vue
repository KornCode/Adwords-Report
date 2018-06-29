<template>
    <div>
        <div class='col-md-12'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title" style="font-size: 25px; margin-top: 5px;">
                        รายงาน
                    </h2>
                    <div class="btn-group" style="float: right;">
                        <select v-model="config_date" class="selectpicker show-tick" data-width="200px">
                            <option v-for="selectOption in selectOptions" v-bind:value="selectOption.value">
                                {{ selectOption.text }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box box-default" v-if="this.config_date != 'today' && this.config_date != 'yesterday'">
                <div class="box-body">
                    <div v-if="is_loading_summary" class="text-center" style="padding: 4rem 0">
                        <i class="fa fa-refresh fa-spin fa-3x"></i>
                    </div>
                    <div v-if="!is_loading_summary">
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
    clicks: "",
    impressions: "",
    avgcpc: "",
    cost: "",
    config_date: "first day of this month", // default when loaded
    is_loading_summary: false,
    datacollection: null,
    selectOptions: [
        { text: "วันนี้", value: "today" },
        { text: "เมื่อวาน", value: "yesterday" },
        { text: "7 วันล่าสุด", value: "-7 days" },
        { text: "14 วันล่าสุด", value: "-14 days" },
        { text: "เดือนนี้", value: "first day of this month" },
        { text: "เดือนก่อนหน้า", value: "first day of last month" },
        { text: "6 เดือนล่าสุด", value: "-6 months" },
        { text: "1 ปีล่าสุด", value: "-12 months" },
        { text: "ทั้งหมด", value: "-120 months" }
    ],
    options: {
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
            display: false,
            color: "#FFFFFF"
        },
        scales: {
            yAxes: [
                {
                    id: "CLICK_AXIS",
                    type: "linear",
                    position: "left",
                    gridLines: {
                        display: false
                    }
                },
                {
                    id: "COST_AXIS",
                    type: "linear",
                    position: "right",
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        callback: function(label, index, labels) {
                            return "฿" + label;
                        }
                    }
                }
            ]
        }
    }
};

export default {
    data: () => {
        isOpen: false;
        return data;
    },
    methods: {
        getData: function() {
            let self = this;
            self.is_loading_summary = true;
            axios
                .post("/overview", { config_date: this.config_date })
                .then(response => {
                    let date = [];
                    let clicks = [];
                    let impressions = [];
                    let avgcpc = [];
                    let cost = [];

                    console.log(response.data[0]);

                    _.each(response.data[0], function(value, key) {
                        date.push(value.day);
                        clicks.push(parseInt(value.clicks));
                        impressions.push(parseInt(value.impressions));
                        avgcpc.push(parseInt(value.avgCPC) / 1000000);
                        cost.push(parseInt(value.cost) / 1000000);
                    });

                    /*
                        |-------------------------------------------
                        | Chart Mananagement
                        |-------------------------------------------
                        */
                    let click_dataset = {
                        label: "Clicks",
                        fill: false,
                        borderColor: "#0073b7",
                        borderWidth: 2,
                        data: clicks,
                        yAxisID: "CLICK_AXIS"
                    };
                    let impression_dataset = {
                        label: "Impressions",
                        fill: false,
                        hidden: true,
                        borderColor: "rgba(255, 44, 44, 1)",
                        borderWidth: 2,
                        data: impressions
                    };
                    let averageCPC_dataset = {
                        label: "AverageCPC",
                        fill: false,
                        hidden: true,
                        borderColor: "rgba(255, 155, 45, 1)",
                        borderWidth: 2,
                        data: avgcpc
                    };
                    let cost_dataset = {
                        label: "Cost",
                        fill: false,
                        borderColor: "#00a65a",
                        borderWidth: 2,
                        data: cost,
                        yAxisID: "COST_AXIS"
                    };
                    self.datacollection = {
                        labels: date,
                        datasets: [
                            click_dataset,
                            impression_dataset,
                            averageCPC_dataset,
                            cost_dataset
                        ]
                    };

                    /*
                        |-------------------------------------------
                        | Box Mananagement
                        |-------------------------------------------
                        */
                    self.clicks = clicks.reduce((sum, click) => {
                        return sum + click;
                    }, 0);
                    self.clicks = insertComma(self.clicks);

                    self.impressions = impressions.reduce((sum, impression) => {
                        return sum + impression;
                    }, 0);
                    self.impressions = insertComma(self.impressions);

                    self.avgcpc =
                        avgcpc.reduce((sum, avgcpc) => {
                            return sum + avgcpc;
                        }, 0) / avgcpc.length;
                    self.avgcpc = self.avgcpc.toFixed(2);
                    self.avgcpc = insertComma(self.avgcpc);

                    self.cost = cost.reduce((sum, cost) => {
                        return sum + cost;
                    }, 0);
                    self.cost = self.cost.toFixed(2);
                    self.cost = insertComma(self.cost);

                    self.is_loading_summary = false;
                })
                .catch(function(error) {
                    alert(
                        "Admin have not registered adwords key for this account. \nContact admin to view this page. \n088-990-8900"
                    );
                });
        }
    },
    watch: {
        config_date: function(newVal, oldVal) {
            if (newVal === oldVal) return;
            this.getData();
        }
    },
    mounted() {
        this.getData();
    }
};

function insertComma(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
</script>