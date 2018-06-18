@extends('ads_dashboard')
{{-- ////////////// --}}
@section('content')
    <div class='row'>

        {{-- Chart --}}
        <div class='col-md-12'> 
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    {{-- <h3 class="box-title">Chart</h3> --}}
                    {{-- Dropdown Button --}}
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
                            {{-- <li class="divider"></li> --}}
                        </ul>
                    </div>

                    <button type="button" class="btn btn-info" style="width: 100px;">Click</button>
                    <button type="button" class="btn btn-danger" style="width: 100px;">Impression</button>
                    <button type="button" class="btn btn-warning" style="width: 100px;">Avg. CPC</button>
                    <button type="button" class="btn btn-success" style="width: 100px;">Cost</button>

                    {{-- Dropdown Button --}}
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
                    <chart-component></chart-component>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div><!-- /.row -->

    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-blue"><i class="fa fa-hand-o-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Clicks</span>
                    <span class="info-box-number"><click-component></click-component></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 75%; background-color: black;"></div>
                    </div>
                    <span class="progress-description">75% Increase in 30 Days</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Impression</span>
                    <span class="info-box-number"><impression-component></impression-component></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 90%; background-color: black;"></div>
                    </div>
                    <span class="progress-description">90% Increase in 30 Days</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-yellow"><i class="fa fa-bar-chart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Avg. Cost-Per-Click</span>
                    <span class="info-box-number"><avg-cpc-component></avg-cpc-component></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 50%; background-color: black;"></div>
                    </div>
                    <span class="progress-description">50% Increase in 30 Days</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Costs</span>
                    <span class="info-box-number"><cost-component></cost-component></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%; background-color: black;"></div>
                    </div>
                    <span class="progress-description">70% Increase in 30 Days</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>
@endsection












