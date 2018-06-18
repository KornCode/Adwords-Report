<template>
    <div>
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
                    <span class="info-box-number">{{ avgCPC }}</span>
                </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>
    
                <div class="info-box-content">
                    <span class="info-box-text">Costs</span>
                    <span class="info-box-number">{{ cost }}</span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
        </div>
    </div>
</template>

<script>
    var data = {
        clicks: '93,139',
        impressions: '93,139',
        avgCPC: '93,139',
        cost: '93,139'
    }

    export default {
        data: () => {
            return data;
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
