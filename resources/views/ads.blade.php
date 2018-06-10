@extends('layouts.app')

@section('content')

<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:16%;">
    <h2 style="margin-left: 15px; margin-top: 15px; font-weight: bold;">Header</h2>
    <hr>
    <sidebar-component></sidebar-component>
</div>

{{-- <div class="container" id="app" style="margin-left: 20%">
    <coin-add-component></coin-add-component>
    <chart-component></chart-component>
    <line-chart :data="{'2017-01-01': 11, '2017-01-02': 6}"></line-chart>
    <chart-component></chart-component>
</div> --}}

<div class="ads-container">
    <div class="chart-wrapper">
        <chart-component></chart-component>
    </div>

    <div class="ads-wrapper">
        <keywords-component></keywords-component>
        <searches-component></searches-component>
        <most-shown-ads-component></most-shown-ads-component>
        <devices-component></devices-component>
        <locations-component></locations-component>
        <networks-component></networks-component>
        <day-hour-component></day-hour-component>
    </div>
    {{-- <div class="row"> --}}
        
    {{-- </div> --}}
    {{-- <div class="row"> --}}
        
    {{-- </div> --}}
    {{-- <div class="row"> --}}
        
    {{-- </div> --}}
    {{-- <div class="row"> --}}
        
    {{-- </div> --}}
</div>

@endsection

