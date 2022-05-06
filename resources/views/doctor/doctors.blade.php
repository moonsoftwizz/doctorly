@extends('layouts.master-layouts')
@section('title') {{ __('List of Doctors') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Doctor List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Doctors @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div></div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                @if ($role != 'patient' && $role != 'receptionist')
                                    <a href=" {{ route('doctor.create') }} ">
                                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> {{ __('New Doctor') }}
                                        </button>
                                    </a>
                                @endif
                            </div>

                            <div class="col-lg-9 text-right">

                                <form action="">
                                    <div class="form-group d-inline-flex">
                                        <input class="form-control mr-1" type="text" placeholder="Search CRM" name="search_crm" value="{{$searchCRM}}" />
                                        <input class="form-control mr-1" type="text" placeholder="Search Name" name="search_name" value="{{$search}}" />
                                        <button type="submit" value="" class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                            </div>

                        </div>


                        <table class="table table-bordered dt-responsive nowrap "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('Id') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('CRM') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    @if ($role != 'patient')
                                        <th>{{ __('Option') }}</th>
                                    @endif


                                </tr>
                            </thead>
                            <tbody>
                                @if (session()->has('page_limit'))
                                    @php
                                        $per_page = session()->get('page_limit');
                                    @endphp
                                @else
                                    @php
                                        $per_page = Config::get('app.page_limit');
                                    @endphp
                                @endif
                                @php
                                    $currentpage = $doctors->currentPage();
                                @endphp

                                @foreach ($doctors as $key => $item)
                                    <tr>

                                        <td>{{ $item->doctor['id'] }} </td>
                                        <td>
                                            {{ $item->full_name }}
                                        </td>

                                        <td> {{ $item->doctor['doc_CRM'] }} </td>
                                        <td> {{ $item->mobile }} </td>
                                        <td> {{ $item->email }} </td>
                                        @if ($role != 'patient')
                                            <td>
                                                {{--@if ($role == 'admin')--}}
                                                    {{--<a href="{{ url('doctor/' . $item->id) }}">--}}
                                                        {{--<button type="button"--}}
                                                            {{--class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"--}}
                                                            {{--title="View Profile">--}}
                                                            {{--<i class="mdi mdi-eye"></i>--}}
                                                        {{--</button>--}}
                                                    {{--</a>--}}
                                                {{--@elseif ($role == 'receptionist')--}}
                                                    {{--<a href="{{ url('doctor-view/' . $item->id) }}">--}}
                                                        {{--<button type="button"--}}
                                                            {{--class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"--}}
                                                            {{--title="View Profile">--}}
                                                            {{--<i class="mdi mdi-eye"></i>--}}
                                                        {{--</button>--}}
                                                    {{--</a>--}}
                                                {{--@endif--}}

                                                @if ($role != 'receptionist')
                                                    <a href="{{ url('doctor/' . $item->id . '/edit') }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="Update Profile">
                                                            <i class="mdi mdi-lead-pencil"></i>
                                                        </button>
                                                    </a>
                                                    <a href=" javascript:void(0) ">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="Deactivate Profile" data-id="{{ $item->id }}"
                                                            id="delete-doctor">
                                                            <i class="mdi mdi-trash-can"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-flex justify-content-start">
                                Showing {{ $doctors->firstItem() }} to {{ $doctors->lastItem() }} of
                                {{ $doctors->total() }} entries
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $doctors->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection
    @section('script')
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
        <script>
            // delete Coctor
            $(document).on('click', '#delete-doctor', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure want to delete doctor?')) {
                    $.ajax({
                        type: "DELETE",
                        url: 'doctor/' + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                            id:id,
                        },
                        beforeSend: function() {
                            $('#pageloader').show()
                        },
                        success: function(response) {
                            toastr.success(response.message, 'Success Alert', {
                                timeOut: 2000
                            });
                            location.reload();
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message,{
                                timeOut: 20000
                            });
                        },
                        complete: function() {
                            $('#pageloader').hide();
                        }
                    });
                }
            });
        </script>
    @endsection
