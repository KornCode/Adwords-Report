@extends('ads_dashboard')
{{-- ////////////// --}}
@section('content')
    <div class='row'>

        {{-- Chart --}}
        <div class='col-md-12'> 
            <chart-component></chart-component>
        </div>

    </div><!-- /.row -->

    <div class="row">
        <summary-component></summary-component>
    </div>
@endsection












