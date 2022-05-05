@extends('layouts.master-layouts')
@section('title') {{ __('List of Patients') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <div class="content">
            <div class="row">

                <div class="col-lg-12">
                    <h2>New Exam</h2>
                </div>

            </div>
            <div class="card">
                <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                    <div class="detail_box">
                        <form action="" name="doctorform" class="" method="post">
                            @csrf

                            <table class="exam_form">
                                <thead>
                                <tr>
                                    <th>Abbreviation</th>
                                    <th>Exam Name</th>
                                    <th>Category</th>
                                    <th>Team</th>
                                    <th>Destiny</th>
                                    <th>Label Group</th>
                                    <th>Quantity Label</th>
                                    <th>Kit</th>
                                    <th>Support</th>
                                    <th>Price R$</th>

                                </tr>
                                </thead>
                                <tbody>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                <td><input class="form-control" type="text" /></td>
                                </tbody>
                            </table>
                            <hr>
                            <br>
                            <p><b>REPORT EDITOR</b></p>
                            <p>To insert reference values: ##REFERENCE## <br>To omit an excerpt when printing the report, enclose the text in.
                            </p>
                            <br>
                            <textarea id="summery-ckeditor"></textarea>
                            <br>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>

                    </div>
                </div>

            </div>
                </div></div>
        </div>
    @endsection
    @section('script')
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script>
            CKEDITOR.replace('summery-ckeditor')
        </script>
@endsection
