@extends('layouts.master-layouts')
@section('title') {{ __('Appointment list') }} @endsection

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3">

                <a href="{{route('add_exam')}}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-plus font-size-16 align-middle mr-2"></i> {{ __('Add New Exam') }}
                    </button>
                </a>

            </div>

            <div class="col-lg-9 text-right">

                <form action="">
                    <div class="form-group d-inline-flex">
                        <input class="form-control mr-1" type="text" placeholder="Search AB" name="search_abbreviation"  />
                        <input class="form-control mr-1" type="text" placeholder="Search Name" name="search_name"  />
                        <button type="submit" value="" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>

        </div>


            <div class="card">
                <div class="card-body">
                    <div class="row">
            <div class="col-lg-12">
                <div class="detail_box">
                    <table class="table sislac_table table_form">
                        <thead>
                        <tr>
                            <th>Abbreviation</th>
                            <th>Exam Name</th>
                            <th>Category</th>
                            <th>Team</th>
                            <th>Destiny</th>
                            <th>Specialty</th>
                            <th>Options</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($exam as $key => $item)

                        <tr>
                            <th> {{ $item->abbreviation }} </th>
                            <th> {{ $item->name }} </th>
                            <th> {{ $item->category }} </th>
                            <th> {{ $item->team }} </th>
                            <th> {{ $item->destiny }} </th>
                            <th> {{ $item->label_group }} </th>
                            <th>
                                <a href="">
                                    <button type="button"
                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                            title="Update Profile">
                                        <i class="mdi mdi-lead-pencil"></i>
                                    </button>
                                </a>
                                <a href=" javascript:void(0) ">
                                    <button type="button"
                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                            title="Deactivate Profile"
                                            id="delete-doctor">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                </a>
                            </th>

                        </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
                </div>
            </div>
        </div>



@endsection
