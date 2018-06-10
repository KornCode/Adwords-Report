<template>
    <div class="chart-column" style="background-color:#aaa;">
        <line-chart :data="chartData" curve="false" download="chart" refresh="60" legend="false" height="300px"></line-chart>
    </div>
</template>

<script>

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
</script>
