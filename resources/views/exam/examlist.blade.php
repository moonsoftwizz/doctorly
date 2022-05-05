@extends('layouts.master-layouts')
@section('title') {{ __('Appointment list') }} @endsection

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <h2>List Exam</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="detail_box">
                    <table class="table sislac_table table_form">
                        <thead>
                        <tr>
                            <th>Abbreviation</th>
                            <th>Name</th>
                            <th>CRM</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Specialty</th>

                        </tr>
                        </thead>
                        <tbody>
                        <th>


                        </th>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



@endsection
