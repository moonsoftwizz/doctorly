@extends('layouts.master-layouts')
@section('title') {{ __('Dashboard') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        @if ($role == 'admin')
            @include('layouts.admin-dashboard')
        @elseif ($role == 'doctor')
            @include('layouts.doctor-dashboard')
        @elseif ($role == 'receptionist')
            @include('layouts.receptionist-dashboard')
        @elseif ($role == 'patient')
            @include('layouts.patient-dashboard')
        @endif
    @endsection
    @section('script')
        <!-- Plugin Js-->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/dashboard.init.js') }}"></script>
    @endsection
