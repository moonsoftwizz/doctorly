@extends('layouts.master-layouts')
@section('title') {{ __('Appointment list') }} @endsection
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}">
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Appointment List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Appointment @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#PendingAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Pending Appointment List') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#UpcomingAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Upcoming Appointment List') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#ComplateAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Complete Appointment List') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#CancelAppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Cancel Appointment List') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="PendingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Patient Name') }}</th>
                                            <th>{{ __('Patient Contact No') }}</th>
                                            <th>{{ __('Patient Email') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
                                            <th>{{ __('Status') }}</th>
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
                                            $currentpage = $pending_appointment->currentPage();
                                        @endphp
                                        @foreach ($pending_appointment as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ $item->doctor->first_name . ' ' . $item->doctor->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td> {{ $item->patient->email }} </td>
                                                <td>{{ $item->appointment_date }}</td>
                                                <td>{{ $item->timeSlot->from . ' to ' . $item->timeSlot->to }}</td>
                                                <td>
                                                    @if ($role == 'doctor' || $role == 'receptionist')
                                                        <button type="button" class="btn btn-success complete"
                                                            data-id="{{ $item->id }}">Complete</button>
                                                    @endif
                                                    <button type="button" class="btn btn-danger cancel"
                                                        data-id="{{ $item->id }}">Cancel</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="UpcomingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Patient Name') }}</th>
                                            <th>{{ __('Patient Contact No') }}</th>
                                            <th>{{ __('Patient Email') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
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
                                            $currentpage = $Upcoming_appointment->currentPage();
                                        @endphp
                                        @foreach ($Upcoming_appointment as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ $item->doctor->first_name . ' ' . $item->doctor->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td>{{ $item->patient->email }}</td>
                                                <td>{{ $item->appointment_date }}</td>
                                                <td>{{ $item->timeSlot->from . ' to ' . $item->timeSlot->to }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="ComplateAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Patient Name') }}</th>
                                            <th>{{ __('Patient Contact No') }}</th>
                                            <th>{{ __('Patient Email') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
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
                                            $currentpage = $Complete_appointment->currentPage();
                                        @endphp
                                        @foreach ($Complete_appointment as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ $item->doctor->first_name . ' ' . $item->doctor->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td>{{ $item->patient->email }}</td>
                                                <td>{{ $item->appointment_date }}</td>
                                                <td>{{ $item->timeSlot->from . ' to ' . $item->timeSlot->to }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="CancelAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap datatable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Patient Name') }}</th>
                                            <th>{{ __('Patient Contact No') }}</th>
                                            <th>{{ __('Patient Email') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
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
                                            $currentpage = $Cancel_appointment->currentPage();
                                        @endphp
                                        @foreach ($Cancel_appointment as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 + $per_page * ($currentpage - 1) }} </td>
                                                <td> {{ $item->doctor->first_name . ' ' . $item->doctor->last_name }}
                                                </td>
                                                <td> {{ $item->patient->first_name . ' ' . $item->patient->last_name }}
                                                </td>
                                                <td> {{ $item->patient->mobile }} </td>
                                                <td>{{ $item->patient->email }}</td>
                                                <td>{{ $item->appointment_date }}</td>
                                                <td>{{ $item->timeSlot->from . ' to ' . $item->timeSlot->to }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
    @endsection
    @section('script-bottom')
        <script>
            // complete appointment
            $('.complete').click(function(e) {
                var id = $(this).data('id');
                var token = $("input[name='_token']").val();
                var status = 1;
                if (confirm('Are you sure you want to confirm appointment?')) {
                    $.ajax({
                        type: "post",
                        url: "appointment-status/" + id,
                        data: {
                            'appointment_id': id,
                            '_token': token,
                            'status': status
                        },
                        beforeSend: function() {
                            $('#preloader').show()
                        },
                        success: function(response) {
                            toastr.success(reponse.Message);
                            location.reload();
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        },
                        complete: function() {
                            $('#preloader').hide();
                        }
                    });
                }
            });
            // cancel appointment
            $('.cancel').click(function(e) {
                var id = $(this).data('id');
                var token = $("input[name='_token']").val();
                var status = 2;
                if (confirm('Are you sure you want to cancel appointment?')) {
                    $.ajax({
                        type: "post",
                        url: "appointment-status/" + id,
                        data: {
                            'appointment_id': id,
                            '_token': token,
                            'status': status
                        },
                        beforeSend: function() {
                            $('#preloader').show()
                        },
                        success: function(response) {
                            toastr.success(reponse.Message);
                            location.reload();
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        },
                        complete: function() {
                            $('#preloader').hide();
                        }
                    });
                }
            });
            // active tab
            if (window.location.href) {
                var url = window.location.href;
                var activeTab = url.substring(url.indexOf("#") + 1);
                var URL = document.location.origin;
                if (url.substring(url.indexOf("#") + 1) == URL + '/appointment-list') {
                    $("#PendingAppointmentList").addClass("active in");
                } else {
                    $(".tab-pane").removeClass("active in");
                    $("#" + activeTab).addClass("active in");
                    $('a[href="#' + activeTab + '"]').tab('show')
                }
            }
        </script>
    @endsection
