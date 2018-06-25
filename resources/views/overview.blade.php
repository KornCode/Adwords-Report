@extends('ads_dashboard')

@section('content')
    <div class='row'>
        @if (Auth::user()->hasRole('admin'))
            <admin-overview-component></admin-overview-component>
        @else
            <overview-component></overview-component>
        @endif
    </div>
@endsection












