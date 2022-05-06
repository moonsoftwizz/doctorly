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
                        <form action="{{route('StoreExam')}}" name="examform" class="" method="post">
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
                                    <tr>
                                    <td><input class="form-control" type="text" name="abbreviation" /></td>
                                    <td><input class="form-control" type="text" name="name" /></td>
                                    <td><input class="form-control" type="text" name="category" /></td>
                                    <td><input class="form-control" type="text" name="team" /></td>
                                    <td><input class="form-control" type="text" name="destiny" /></td>
                                    <td><input class="form-control" type="text" name="label_group" /></td>
                                    <td><input class="form-control" type="text" name="quantity_label" /></td>
                                    <td><input class="form-control" type="text" name="exam_kit" /></td>
                                    <td><input class="form-control" type="text" name="exam_support" /></td>
                                    <td><input class="form-control" type="text" name="exam_price" /></td>

                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <br>
                            <p><b>REPORT EDITOR</b></p>
                            <p>To insert reference values: ##REFERENCE## <br>To omit an excerpt when printing the report, enclose the text in.
                            </p>
                            <br>
                            <textarea id="summery-ckeditor" name="exam_editor"></textarea>
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
