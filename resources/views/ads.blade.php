@extends('layouts.app')

@section('content')

<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:16%;">
    <div style="margin-left: 15px; margin-top: 15px;">
        <h2 style="font-weight: bold;">Header</h2>
    </div>
    <hr>
    <div style="margin-left: 15px; margin-top: 15px;">
        <sidebar-component></sidebar-component>
    </div>  
</div>

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
</div>

@endsection

