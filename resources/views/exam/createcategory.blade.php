@extends('layouts.master-layouts')
@section('title') {{ __('Appointment list') }} @endsection

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Create Category</h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="detail_box">
                                <div class="detail_box">
                                    <form action="{{ route('StoreCategory') }}" name="doctorform" class="" method="post">
                                        @csrf

                                        <table class="table sislac_table table_form">
                                            <thead>
                                            <tr>
                                                <th>Abbreviation</th>
                                                <th>Name</th>


                                            </tr>
                                            </thead>
                                            <tbody>
                                            <th><input class="form-control" name="abbreviation" type="text" /></th>
                                            <th><input class="form-control" name="category_name" type="text" /></th>

                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
@endsection