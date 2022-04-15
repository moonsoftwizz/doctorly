@extends('layouts.master-layouts')
@section('title')
    {{ __('Update prescription') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        {{ __('Update prescription') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('prescription') }}">{{ __('Prescription') }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ __('Update prescription') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Prescription Details') }}</blockquote>
                        <form class="outer-repeater" action="{{ url('prescription/' . '' . $prescription->id) }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH" />
                            <input type="hidden" name="id" value="{{ $prescription->id }}" id="form_id" />

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Patient ') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="form-control select2 sel_patient @error('patient_id') is-invalid @enderror"
                                        name="patient_id" id="patient">
                                        <option disabled selected>{{ __('Select Patient') }}</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                {{ $patient->id == $prescription->patient->id ? 'selected' : '' }}>
                                                {{ $patient->first_name }} {{ $patient->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Appointment :') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="form-control select2 sel_appointment @error('appointment_id') is-invalid @enderror"
                                        name="appointment_id" id="appointment">
                                        <option disabled selected>{{ __('Select Appointment') }}</option>
                                        @foreach ($appointment as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $prescription->appointment->id ? 'selected' : '' }}>
                                                {{ $item->appointment_date }}</option>
                                        @endforeach
                                    </select>
                                    @error('appointment_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <input type="hidden" name="created_by" value="{{ $user->id }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Symptoms ') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('symptoms') is-invalid @enderror" name="symptoms"
                                        id="symptoms" placeholder="{{ __('Add Symptoms') }}"
                                        rows="3">@if (old('symptoms')){{ old('symptoms') }}@endif {{ $prescription->symptoms }}</textarea>
                                    @error('symptoms')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Diagnosis ') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis"
                                        id="diagnosis" placeholder="{{ __('Add Diagnosis') }}"
                                        rows="3">@if (old('diagnosis')){{ old('diagnosis') }}@endif{{ $prescription->diagnosis }}</textarea>
                                    @error('diagnosis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <blockquote>{{ __('Medication & Test Reports Details') }}</blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class='repeater mb-4'>
                                        <div data-repeater-list="medicines" class="form-group">
                                            <label>{{ __('Medicines ') }}<span class="text-danger">*</span></label>
                                            @foreach ($medicines as $item)
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="medicine" class="form-control"
                                                            placeholder="{{ __('Medicine Name') }}"
                                                            value="{{ $item->name }}" />
                                                    </div>
                                                    <div class="col-md-5 col-6">
                                                        <textarea type="text" name="notes" class="form-control"
                                                            placeholder="{{ __('Notes...') }}">{{ $item->notes }}</textarea>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <input data-repeater-delete type="button"
                                                            class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                            value="X" />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-primary"
                                            value="Add Medicine" />
                                    </div>
                                </div>
                                @if ($test_reports->count() == 0)
                                    <div class="col-md-6">
                                        <div class='repeater mb-4'>
                                            <div data-repeater-list="test_reports" class="form-group">
                                                <label>{{ __('Test Reports ') }}<span
                                                        class="text-danger">*</span></label>
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="test_report" class="form-control"
                                                            placeholder="{{ __('Test Report Name') }}" />
                                                    </div>
                                                    <div class="col-md-5 col-6">
                                                        <textarea type="text" name="notes" class="form-control"
                                                            placeholder="{{ __('Notes...') }}"></textarea>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <input data-repeater-delete type="button"
                                                            class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                            value="X" />
                                                    </div>
                                                </div>
                                            </div>
                                            <input data-repeater-create type="button" class="btn btn-primary"
                                                value="Add Test Report" />
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class='repeater mb-4'>
                                            <div data-repeater-list="test_reports" class="form-group">
                                                <label>{{ __('Test Reports ') }}<span
                                                        class="text-danger">*</span></label>
                                                @foreach ($test_reports as $item)
                                                    <div data-repeater-item class="mb-3 row">
                                                        <div class="col-md-5 col-6">
                                                            <input type="text" name="test_report" class="form-control"
                                                                placeholder="{{ __('Test Report Name') }}"
                                                                value="{{ $item->name }}" />
                                                        </div>
                                                        <div class="col-md-5 col-6">
                                                            <textarea type="text" name="notes" class="form-control"
                                                                placeholder="{{ __('Notes...') }}">{{ $item->notes }}</textarea>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <input data-repeater-delete type="button"
                                                                class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                                value="X" />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input data-repeater-create type="button" class="btn btn-primary"
                                                value="Add Test Report" />
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Prescription') }}
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
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <!-- form mask -->
        <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
        <!-- form init -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
        <script>
            $('.sel_patient').change(function(e) {
                e.preventDefault();
                $('.sel_appointment').empty();
                var patientId = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('patient_by_appointment') }}",
                    data: {
                        patient_id: patientId,
                        _token: token,
                    },
                    success: function(res) {
                        $('.sel_appointment').html('');
                        $('.sel_appointment').html(res.options);
                    },
                    error: function(res) {
                        console.log(res);
                    }
                });
            });
        </script>
    @endsection
