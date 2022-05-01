@extends('layouts.master-layouts')
@section('title') {{ __('List of Patients') }} @endsection
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
                        <form action="" name="doctorform" class="" method="post">
                            @csrf

                            <table class="table sislac_table table_form">
                                <thead>
                                <tr>
                                    <th>Abbreviation</th>
                                    <th>Exam Name</th>
                                    <th>Category</th>
                                    <th>Deadline</th>
                                    <th>Destiny</th>
                                    <th>Label Group</th>
                                    <th>Quantity Label</th>
                                    <th>Kit</th>
                                    <th>Support</th>
                                    <th>Price R$</th>

                                </tr>
                                </thead>
                                <tbody>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                <td><input type="text" /></td>
                                </tbody>
                            </table>
                            <hr>
                            <textarea id="summery-ckeditor"></textarea>
                            <br>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    @endsection
    @section('script')
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script>
            CKEDITOR.replace('summery-ckeditor')
        </script>
@endsection
