@extends('layouts.master-layouts')
@section('title') {{ __('Book Appointment') }} @endsection
@section('css')
    <!-- Calender -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/fullcalendar/fullcalendar.min.css') }}">
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Book Appointment @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Appointment @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('/appointment-create') }}"
                    class="btn btn-primary text-white waves-effect waves-light mb-4">
                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i> {{ __('New Appointment') }}
                </a>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('Appointment List') }} | <label
                                id="selected_date"><?php echo date('d M, Y'); ?></label>
                        </h4>
                        <div id="appointment_list">
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Sr.No.') }}</th>
                                        @if ($role == 'patient')
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Doctor Number') }}</th>
                                        @elseif($role == 'doctor')
                                            <th>{{ __('Patient Name') }}</th>
                                            <th>{{ __('Patient Number') }}</th>
                                        @else
                                            <th>{{ __('Patient Name') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Patient Number') }}</th>

                                        @endif
                                        <th>{{ __('Time') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @if ($role == 'receptionist')
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td> {{ $i }} </td>
                                                <td>{{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}
                                                </td>
                                                <td>{{ $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name }}
                                                </td>
                                                <td>{{ $appointment->patient->mobile }}</td>
                                                <td>
                                                    {{ $appointment->timeSlot->from . ' to ' . $appointment->timeSlot->to }}
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @elseif ($role == 'doctor')
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td> {{ $i }} </td>
                                                <td>{{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}
                                                </td>
                                                <td>{{ $appointment->patient->mobile }}</td>
                                                <td>
                                                    {{ $appointment->timeSlot->from . ' to ' . $appointment->timeSlot->to }}
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @elseif ($role == 'patient')
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td> {{ $i }} </td>
                                                <td>{{ $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name }}
                                                </td>
                                                <td>{{ $appointment->doctor->mobile }}</td>
                                                <td>
                                                    {{ $appointment->timeSlot->from . ' to ' . $appointment->timeSlot->to }}
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="new_list" style="display : none"></div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection
    @section('script')
        <!-- Calender Js-->
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/fullcalendar/fullcalendar.min.js') }}"></script>
        <!-- Get App url in Javascript file -->
        <script type="text/javascript">
            var aplist_url = "{{ url('appointmentList') }}";
        </script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/calendar-init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/appointment.js') }}"></script>
    @endsection
