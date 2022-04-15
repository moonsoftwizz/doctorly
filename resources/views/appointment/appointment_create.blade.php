@extends('layouts.master-layouts')
@section('title') {{ __('Book Appointment') }} @endsection
@section('css')
    <!-- Calender -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}">
@endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Book Appointment @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Booked Appointment @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('/appointment/create') }}"
                    class="btn btn-primary text-white waves-effect waves-light mb-4">
                    <i class="mdi mdi-arrow-left  font-size-16 align-middle mr-2"></i> {{ __('Back') }}
                </a>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Book Appointment') }}</blockquote>
                        <form action="{{ url('appointment-store') }}" id="" method="POST">
                            @csrf
                            @if ($role != 'patient')
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Patient ') }}<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('appointment_for') is-invalid @enderror"
                                            name="appointment_for" id="patient">
                                            <option disabled selected>{{ __('Select') }}</option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->first_name }}
                                                    {{ $patient->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('appointment_for')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="appointment_for" value="{{ $user->id }}">
                            @endif
                            @if ($role != 'doctor')
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Doctor ') }}<span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-control select2 sel-doctor @error('appointment_with') is-invalid @enderror"
                                            name="appointment_with" id="doctor">
                                            <option selected disabled>{{ __('Select') }}</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}"
                                                    {{ old('appointment_with') == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->first_name }}
                                                    {{ $doctor->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('appointment_with')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="appointment_with" value="{{ $user->id }}" id="doctor">
                            @endif
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="control-label">{{ __('Date ') }}<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
                                        <input type="text"
                                            class="form-control appointment-date @error('appointment_date') is-invalid @enderror"
                                            name="appointment_date" id="datepicker" data-provide="datepicker"
                                            data-date-autoclose="true" autocomplete="off"
                                            {{ old('appointment_date', date('Y-m-d')) }}>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                        @error('appointment_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if ($role !== 'doctor')
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="" class="d-block">{{ __("Available Time") }}<span
                                                class="text-danger">*</span></label>
                                        <div class="btn-group btn-group-toggle availble_time" data-toggle="buttons">


                                        </div>
                                        @error('available_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @if ($errors->has('available_time'))
                                            <div class="error " role="alert">
                                                {{ $errors->first('available_time') }}</div>
                                        @endif
                                    </div>
                                </div>

                            @elseif ($role == 'doctor')
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="" class="d-block">{{ __("Available Time") }} <span
                                                class="text-danger">*</span></label>
                                        <div class="btn-group btn-group-toggle availble_time" data-toggle="buttons">
                                            @foreach ($doctor_available_time as $item)
                                                <label class="btn btn-outline-secondary mr-2 ">
                                                    <input type="radio" name="available_time"
                                                        class="available-time @error('available_time') is-invalid @enderror"
                                                        value="{{ $item->id }}">
                                                    {{ $item->from . ' to ' . $item->to }}
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('available_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @if ($errors->has('available_time'))
                                            <div class="error " role="alert">
                                                {{ $errors->first('available_time') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="" class="d-block">{{ __("Available Slot") }}<span
                                            class="text-danger">*</span></label>
                                    <div class="btn-group btn-group-toggle availble_slot d-block" data-toggle="buttons">
                                        @error('available_slot')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @if ($errors->has('available_slot'))
                                            <div class="error " role="alert">
                                                {{ $errors->first('available_slot') }}</div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create Appointment') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')
        <!-- Calender Js-->
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
        <!-- Get App url in Javascript file -->
        <script type="text/javascript">
            var aplist_url ="{{ url('appointmentList') }}";
        </script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/appointment.js') }}"></script>
        <script>
            let datep = $('#datepicker');
            var roles = '{{ $role }}';
            if (roles == 'doctor') {
                var day_doctor = '{{ $dayArray }}';
                $(".datepickerdiv").prepend(datep);
                $('#datepicker').datepicker({
                    startDate: new Date(),
                    daysOfWeekDisabled: day_doctor
                });
            }
            function days(day) {
                $('#datepicker').remove();
                $(".datepickerdiv").prepend(datep);
                $('#datepicker').datepicker({
                    startDate: new Date(),
                    daysOfWeekDisabled: day
                });
            }
            $('.sel-doctor').change(function(e) {
                e.preventDefault();
                $('.day').removeClass('disabled disabled-date');
                $('.availble_time').empty();
                var doctorId = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "post",
                    url: "{{ route('doctor_by_day_time') }}",
                    data: {
                        doctor_id: doctorId,
                        _token: token,
                    },
                    success: function(response) {
                        var res_data = response.data[0];
                        var day = [];
                        if (res_data !== null) {
                            if (res_data.sun == 0)
                                day.push(0);
                            if (res_data.mon == 0)
                                day.push(1);
                            if (res_data.tue == 0)
                                day.push(2);
                            if (res_data.wen == 0)
                                day.push(3);
                            if (res_data.thu == 0)
                                day.push(4);
                            if (res_data.fri == 0)
                                day.push(5);
                            if (res_data.sat == 0)
                                day.push(6);
                            days(day);
                        }
                        var availble_time = response.data[1];
                        $.each(availble_time, function(key, value) {
                            $('.availble_time').append(
                                '<label class="btn btn-outline-secondary mr-2 "><input type="radio" name="available_time" class="available-time @error('available_time') is-invalid @enderror" value="' +
                                value.id + '" >' + value.from + ' to ' + value.to + '</label>');
                        });
                    },
                    error: function(response) {}
                });
            });
            // datepicker change
            $(document).on('change', '#datepicker', function() {
                $('.availble_slot').empty();
            });
            // doctor available time show
            $(document).on('click', '.available-time', function() {
                $('.availble_slot').empty();
                var token = $("input[name='_token']").val();
                var timeId = $(this).val();
                var dates = $('#datepicker').val();
                var doctorId = $("#doctor").val();
                $.ajax({
                    type: "post",
                    url: "{{ route('timeBySlot') }}",
                    data: {
                        timeId: timeId,
                        _token: token,
                        dates: dates,
                        doctorId: doctorId
                    },
                    success: function(response) {
                        var available_slot = response.data[0];
                        $.each(available_slot, function(key, value) {
                            if (value.appointment.length == 0) {
                                $('.availble_slot').append(
                                    '<label class="btn btn-outline-secondary m-2"><input type="radio" name="available_slot" class="available-slot"  value="' +
                                    value.id + '">' + value.from + ' to ' + value.to +
                                    '</label>');
                            } else {
                                $('.availble_slot').append(
                                    '<label class="btn alert-secondary m-2"><input type="radio" name="available_slot" class="available-slot"  value="' +
                                    value.id + '" disabled>' + value.from + ' to ' + value.to +
                                    '</label>');
                            }
                        });
                    },
                    error: function(error) {
                        console.log(error);
                        toastr.error('Something went wrong!', {
                            timeOut: 10000
                        });
                    }
                });
            });
        </script>
    @endsection
