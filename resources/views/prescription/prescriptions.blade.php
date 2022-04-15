@extends('layouts.master-layouts')
@section('title') {{ __('List of Prescription') }} @endsection
@section('css')
    <style>
        #pageloader {
            background: rgba(255, 255, 255, 0.8);
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
            left: 0;
            right: 0;
            margin: auto;
            bottom: 0;
            top: 0;
        }

        #pageloader img {
            left: 50%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
        }

    </style>

@endsection

@section('body')

    <body data-topbar="dark" data-layout="horizontal">
        <div id="pageloader">
            <img src="{{ URL::asset('assets/images/loader.gif') }}" alt="processing..." />
        </div>
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Prescription List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Prescription @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($role == 'doctor')
                            <a href=" {{ route('prescription.create') }} ">
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i>
                                    {{ __('Create Prescription') }}
                                </button>
                            </a>
                        @endif
                        <table class="table table-bordered dt-responsive nowrap "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr. No') }}</th>
                                    @if ($role == 'doctor')
                                        <th>{{ __('Patient Name') }}</th>
                                    @elseif($role == 'patient')
                                        <th>{{ __('Doctor Name') }}</th>
                                    @else
                                        <th>{{ __('Patient Name') }}</th>
                                        <th>{{ __('Doctor Name') }}</th>
                                    @endif
                                    <th>{{ __('Appointment Date') }}</th>
                                    <th>{{ __('Appointment Time') }}</th>
                                    <th>{{ __('Option') }}</th>
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
                                    $currentpage = $prescriptions->currentPage();
                                @endphp
                                @foreach ($prescriptions as $prescription)
                                    <tr>
                                        <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                        @if ($role == 'receptionist')
                                            <td>{{ $prescription->patient->first_name . ' ' . $prescription->patient->first_name }}
                                            </td>
                                            <td>{{ $prescription->doctor->first_name . ' ' . $prescription->doctor->first_name }}
                                            </td>
                                        @elseif ($role == 'doctor')
                                            <td>{{ $prescription->patient->first_name }}
                                                {{ $prescription->patient->last_name }}</td>
                                        @elseif ($role == 'patient')
                                            <td>{{ $prescription->doctor->first_name }}
                                                {{ $prescription->doctor->last_name }}</td>
                                        @else
                                            <td>{{ $prescription->patient->first_name }}
                                                {{ $prescription->patient->last_name }}</td>
                                            <td>{{ $prescription->doctor->first_name }}
                                                {{ $prescription->doctor->last_name }}</td>
                                        @endif
                                        <td>{{ $prescription->appointment->appointment_date }}</td>
                                        <td>{{ $prescription->appointment->timeSlot->from . ' to ' . $prescription->appointment->timeSlot->to }}
                                        </td>
                                        <td>
                                            <a href="{{ url('prescription/' . $prescription->id) }}">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                    title="View Prescription">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                            </a>
                                            @if ($role == 'doctor')
                                                <a href="{{ url('prescription/' . $prescription->id . '/edit') }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                        title="Update Prescription">
                                                        <i class="mdi mdi-lead-pencil"></i>
                                                    </button>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                        title="Delete Prescription" data-id="{{ $prescription->id }}"
                                                        id="delete-prescription">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </button>
                                                </a>
                                            @endif
                                            @if ($role != 'patient')
                                                <a href="javascript:void(0)">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light
                                                                send-mail"
                                                        title="Send Email" data-id="{{ $prescription->id }}">
                                                        <i class="mdi mdi-email"></i>
                                                    </button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-flex justify-content-start">
                                Showing {{ $prescriptions->firstItem() }} to {{ $prescriptions->lastItem() }} of
                                {{ $prescriptions->total() }} entries
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $prescriptions->links() }}
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
            $(document).on('click', '#delete-prescription', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure want to delete prescription?')) {
                    $.ajax({
                        type: "DELETE",
                        url: 'prescription/' + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        beforeSend: function() {
                            $('#pageloader').show()
                        },
                        success: function(data) {
                            toastr.success(data.message, 'Success Alert', {
                                timeOut: 2000
                            });
                            location.reload();
                        },
                        error: function(data) {
                            toastr.error(response.responseJSON.message, {
                                timeOut: 20000
                            });
                        },
                        complete: function() {
                            $('#pageloader').hide();
                        }
                    });
                }
            });
            $('.send-mail').click(function() {
                var id = $(this).attr('data-id');
                if (confirm('Are you sure you want to send email?')) {
                    $.ajax({
                        type: "get",
                        url: "prescription-email/" + id,
                        beforeSend: function() {
                            $('#pageloader').show();
                        },
                        success: function(response) {
                            toastr.success(response.message);
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        },
                        complete: function() {
                            $('#pageloader').hide();
                        }
                    });
                }
            });
        </script>
    @endsection
