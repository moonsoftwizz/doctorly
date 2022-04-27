@extends('layouts.master-layouts')
@section('title')
    @if ($doctor && $doctor_info)
        {{ __('Update Doctor Details') }}
    @else
        {{ __('Add New Doctor') }}
    @endif
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
@endsection
@section('css-bottom')
    <link rel="stylesheet" type="text/css"
          href="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}">
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
                        @if ($doctor && $doctor_info)
                            {{ __('Update Doctor Details') }}
                        @else
                            {{ __('Add New Doctor') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('doctor') }}">{{ __('Doctors') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($doctor && $doctor_info)
                                    {{ __('Update Doctor Details') }}
                                @else
                                    {{ __('Add New Doctor') }}
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                @if ($doctor && $doctor_info)
                    @if ($role == 'doctor')
                        <a href="{{ url('/') }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                        class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Dashboard') }}
                            </button>
                        </a>
                    @else
                        <a href="{{url('doctor/' . $doctor->id) }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                        class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Profile') }}
                            </button>
                        </a>
                    @endif
                @else
                    <a href="{{ url('doctor') }} ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Doctor List') }}
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form id="addtime" action="@if ($doctor && $doctor_info) {{ url('doctor/' . $doctor->id) }} @else {{ route('doctor.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($doctor && $doctor_info)
                                <input type="hidden" name="_method" value="PATCH" />
                        @endif

                        <!-- my code start here-->

                            <div class="row">

                                <div class="col-md-7">
                                    <blockquote>{{ __('Doctor Data') }}</blockquote>

                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label class="control-label">{{ __('Doctor Name ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="full_name" id=""
                                                   value="@if ($doctor && $doctor_info){{ $doctor->full_name }}@elseif(old('full_name')){{ old('full_name') }}@endif"
                                                   placeholder="{{ __('Enter Doctor Name') }}">
                                            {{--@error('full_name')--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                            {{--<strong>{{ $message }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@enderror--}}
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">{{ __(' Sex ') }}<span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="user_sex">
                                                <option selected disabled>Choose</option>
                                                <option>Male</option>
                                                <option>Female</option>

                                            </select>


                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label class="control-label">{{ __('CPF') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('doc_CPF') is-invalid @enderror"
                                                   name="doc_CPF" id="" tabindex="1"
                                                   value="@if ($doctor && $doctor_info){{ $doctor->doc_CPF }}@elseif(old('doc_CPF')){{ old('doc_CPF') }}@endif"
                                                   placeholder="{{ __('') }}">

                                            @error('doc_CPF')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label">{{ __(' CRM ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="doc_CRM" id="" tabindex="1"
                                                   value="@if ($doctor && $doctor_info){{ $doctor->doc_CRM }}@elseif(old('doc_CRM')){{ old('doc_CRM') }}@endif"
                                                   placeholder="{{ __('') }}">



                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label class="control-label">{{ __(' Aadvice ') }}<span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="doc_Advice">
                                                <option selected disabled>Choose</option>
                                                <option>01 - CRAS</option>
                                                <option>02 - COREN</option>
                                                <option>03 - CRF</option>
                                                <option>04 - CRFA</option>
                                                <option>05 - CREFITO</option>
                                                <option>06 - CRM</option>
                                                <option>07 - CRN</option>
                                                <option>08 - CRO</option>
                                                <option>09 - CRP</option>
                                                <option>10 - OUT</option>
                                                <option>99 - CRMV</option>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Specialty') }}<span
                                                        class="text-danger">*</span></label>

                                            <select class="form-control" name="doc_specialty">
                                                <option selected disabled>Choose</option>
                                                <option>VET</option>
                                                <option>Doctor</option>
                                                <option>Nurse</option>
                                                <option>General Clinic</option>
                                            </select>

                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Email ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   name="email" id="email" tabindex="3" value="@if ($doctor && $doctor_info){{ $doctor->email }}@elseif(old('email')){{ old('email') }}@endif"
                                                   placeholder="{{ __('Enter Email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <blockquote>{{ __('Address') }}</blockquote>
                                    <div class="row">
                                        <div class="col-md-5 form-group">
                                            <label class="control-label">{{ __('Zip Code ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="zip_code" id=""
                                                   placeholder="{{ __('Zipcode') }}">

                                        </div>
                                        <div class="col-md-7 form-group">
                                            <label class="control-label">{{ __('Street/ Ave ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="user_address" id=""
                                                   placeholder="{{ __('Address') }}">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-7 form-group">
                                            <label class="control-label">{{ __('City ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="user_city"
                                                   value="@if ($doctor && $doctor_info){{ $doctor->user_city }}@elseif(old('user_city')){{ old('user_city') }}@endif"
                                                   placeholder="{{ __('city') }}">

                                        </div>

                                        <div class="col-md-5 form-group">
                                            <label class="control-label">{{ __('Phone ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="tel" class="form-control"
                                                   name="mobile" id="patientMobile" tabindex="4"
                                                   value="@if ($doctor && $doctor_info){{ $doctor->mobile }}@elseif(old('mobile')){{ old('mobile') }}@endif"
                                                   placeholder="{{ __('Phone') }}">

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-7 form-group">
                                            <label class="control-label">{{ __('Password ') }}</label>
                                            <input type="password" class="form-control"
                                                   name="password"
                                                   placeholder="{{ __('Enter your password') }}">

                                        </div>
                                    </div>

                                </div>


                            </div>


                            <!--my code end here-->

                            <div class="row">

                                <div class="col-md-6">

                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label">{{ __('Email ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<input type="email" class="form-control @error('email') is-invalid @enderror"--}}
                                    {{--name="email" id="email" tabindex="3" value="@if ($doctor && $doctor_info){{ $doctor->email }}@elseif(old('email')){{ old('email') }}@endif"--}}
                                    {{--placeholder="{{ __('Enter Email') }}">--}}
                                    {{--@error('email')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label">{{ __('Title ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<input type="text" class="form-control @error('title') is-invalid @enderror"--}}
                                    {{--name="title" id="title" tabindex="5" value="@if ($doctor && $doctor_info){{ $doctor_info->title }}@elseif(old('title')){{ old('title') }}@endif"--}}
                                    {{--placeholder="{{ __('Enter Title') }}">--}}
                                    {{--@error('title')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label">{{ __('Experience ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<input type="text"--}}
                                    {{--class="form-control @error('experience') is-invalid @enderror"--}}
                                    {{--name="experience" tabindex="7" id="experience"--}}
                                    {{--value="@if ($doctor && $doctor_info){{ $doctor_info->experience }}@elseif(old('experience')){{ old('experience') }}@endif"--}}
                                    {{--placeholder="{{ __('Enter Experience') }}">--}}
                                    {{--@error('experience')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label d-block">{{ __("Doctor available days ") }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<div class="form-check form-check-inline">--}}
                                    {{--<input class="form-check-input" type="checkbox" id="inlineCheckbox1"--}}
                                    {{--value="1" name="sun" {{ old('sun') ? 'checked' : '' }}>--}}
                                    {{--<label class="form-check-label" for="inlineCheckbox1">Sun</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-check form-check-inline">--}}
                                    {{--<input class="form-check-input" type="checkbox" id="inlineCheckbox2"--}}
                                    {{--value="1" name="mon" {{ old('mon') ? 'checked' : '' }}>--}}
                                    {{--<label class="form-check-label" for="inlineCheckbox2">Mon</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-check form-check-inline">--}}
                                    {{--<input class="form-check-input" type="checkbox" id="inlineCheckbox3"--}}
                                    {{--value="1" name="tue" {{ old('tue') ? 'checked' : '' }}>--}}
                                    {{--<label class="form-check-label" for="inlineCheckbox3">Tue</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-check form-check-inline">--}}
                                    {{--<input class="form-check-input" type="checkbox" id="inlineCheckbox4"--}}
                                    {{--value="1" name="wen" {{ old('wen') ? 'checked' : '' }}>--}}
                                    {{--<label class="form-check-label" for="inlineCheckbox4">Wen</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-check form-check-inline">--}}
                                    {{--<input class="form-check-input" type="checkbox" id="inlineCheckbox5"--}}
                                    {{--value="1" name="thu" {{ old('thu') ? 'checked' : '' }}>--}}
                                    {{--<label class="form-check-label" for="inlineCheckbox5">Thu</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-check form-check-inline">--}}
                                    {{--<input class="form-check-input" type="checkbox" id="inlineCheckbox6"--}}
                                    {{--value="1" name="fri" {{ old('fri') ? 'checked' : '' }}>--}}
                                    {{--<label class="form-check-label" for="inlineCheckbox6">Fri</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-check form-check-inline">--}}
                                    {{--<input class="form-check-input" type="checkbox" id="inlineCheckbox7"--}}
                                    {{--value="1" name="sat" {{ old('sat') ? 'checked' : '' }}>--}}
                                    {{--<label class="form-check-label" for="inlineCheckbox7">Sat</label>--}}
                                    {{--</div>--}}
                                    {{--@error('mon')--}}
                                    {{--<span class="error d-block " role="alert">--}}
                                    {{--<strong>Select any one days</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-4 form-group">--}}
                                    {{--<label class="control-label">{{ __('Slots Time (In Minute) ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<select class="form-control select2 @error('slot_time') is-invalid @enderror"--}}
                                    {{--name="slot_time" id="slot_time">--}}
                                    {{--<option value="" disabled selected>00</option>--}}
                                    {{--@for ($i = 1; $i <= 60; $i++)--}}
                                    {{--<option value="{{ $i }}"--}}
                                    {{--{{ old('slot_time') == $i ? 'selected' : '' }}>--}}
                                    {{--{{ $i }}</option>--}}
                                    {{--@endfor--}}
                                    {{--</select>--}}
                                    {{--@error('slot_time')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12">--}}
                                    {{--<div class='repeater mb-4'>--}}
                                    {{--<div data-repeater-list="TimeSlot" class="form-group">--}}

                                    {{--<label>{{ __('Available Time ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<div data-repeater-item class="mb-3 row">--}}
                                    {{--<div class="col-md-5 col-6">--}}
                                    {{--<label class="label-control">From:</label>--}}
                                    {{--<div class="input-group">--}}
                                    {{--<input type="time" name="from"--}}
                                    {{--class="form-control timecount timepicker @error('TimeSlot.*.from') is-invalid @enderror"--}}
                                    {{--placeholder="{{ __('From time') }}" id="time_from" />--}}
                                    {{--@error('TimeSlot.*')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-5 col-6">--}}
                                    {{--<label class="label-control">To:</label>--}}
                                    {{--<div class="input-group">--}}
                                    {{--<input type="time" name="to"--}}
                                    {{--class="form-control  @error('TimeSlot.*.to') is-invalid @enderror"--}}
                                    {{--placeholder="{{ __('To time') }}"--}}
                                    {{--onchange="valinput0()" id="time_to" />--}}
                                    {{--@error('TimeSlot.*.to')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-2 col-4">--}}
                                    {{--<input data-repeater-delete type="button" onclick="cf--"--}}
                                    {{--class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"--}}
                                    {{--value="X" />--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<p class="para error d-none"></p>--}}
                                    {{--<input data-repeater-create type="button" class="btn btn-primary"--}}
                                    {{--value="Add Time" onclick="change()" />--}}

                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="col-md-6">
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label">{{ __('Last Name ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<input type="text"--}}
                                    {{--class="form-control @error('last_name') is-invalid @enderror"--}}
                                    {{--name="last_name" id="lastname" tabindex="2" value="@if ($doctor && $doctor_info){{ $doctor->last_name }}@elseif(old('last_name')){{ old('last_name') }}@endif"--}}
                                    {{--placeholder="{{ __('Enter Last Name') }}">--}}
                                    {{--@error('last_name')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label">{{ __('Degree ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<input type="text" class="form-control @error('degree') is-invalid @enderror"--}}
                                    {{--name="degree" id="degree" tabindex="6" value="@if ($doctor && $doctor_info){{ $doctor_info->degree }}@elseif(old('degree')){{ old('degree') }}@endif"--}}
                                    {{--placeholder="{{ __('Enter Degree') }}">--}}
                                    {{--@error('degree')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label">{{ __('Fees ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<input type="text" class="form-control @error('fees') is-invalid @enderror"--}}
                                    {{--name="fees" id="fees" tabindex="6" value="@if ($doctor && $doctor_info){{ $doctor_info->fees }}@elseif(old('fees')){{ old('fees') }}@endif"--}}
                                    {{--placeholder="{{ __('Enter Fees') }}">--}}
                                    {{--@error('fees')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="row">--}}
                                    {{--<div class="col-md-12 form-group">--}}
                                    {{--<label class="control-label">{{ __('Profile Photo ') }}<span--}}
                                    {{--class="text-danger">*</span></label>--}}
                                    {{--<img class="@error('profile_photo') is-invalid @enderror"--}}
                                    {{--src="@if ($doctor && $doctor_info && $doctor->profile_photo != 'noImage.png') {{ URL::asset('storage/images/users/' . $doctor->profile_photo) }}  @else {{ URL::asset('assets/images/users/noImage.png') }} @endif" id="profile_display" onclick="triggerClick()"--}}
                                    {{--data-toggle="tooltip" data-placement="top"--}}
                                    {{--title="Click to Upload Profile Photo" />--}}
                                    {{--<input type="file"--}}
                                    {{--class="form-control @error('profile_photo') is-invalid @enderror"--}}
                                    {{--tabindex="8" name="profile_photo" id="profile_photo" style="display:none;"--}}
                                    {{--onchange="displayProfile(this)">--}}
                                    {{--@error('profile_photo')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($doctor && $doctor_info)
                                            {{ __('Update Details') }}
                                        @else
                                            {{ __('Add New Doctor') }}
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
        <!-- form init -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    {{--<script>--}}
    {{--$('#addtime').submit(function(e) {--}}
    {{--if (error != 0) {--}}
    {{--e.preventDefault();--}}
    {{--}--}}
    {{--});--}}
    {{--// Profile photo--}}
    {{--function triggerClick() {--}}
    {{--document.querySelector('#profile_photo').click();--}}
    {{--}--}}

    {{--function displayProfile(e) {--}}
    {{--if (e.files[0]) {--}}
    {{--var reader = new FileReader();--}}
    {{--reader.onload = function(e) {--}}
    {{--document.querySelector('#profile_display').setAttribute('src', e.target.result);--}}
    {{--}--}}
    {{--reader.readAsDataURL(e.files[0]);--}}
    {{--}--}}
    {{--}--}}
    {{--// Time Validation--}}
    {{--var timecount = $('.timecount').length--}}
    {{--let cf = 0;--}}
    {{--let error = 0;--}}

    {{--function valinput0() {--}}
    {{--var startTime = $('input[name="TimeSlot[0][from]"]').val();--}}
    {{--var endTime = $('input[name="TimeSlot[0][to]"]').val();--}}
    {{--var st = startTime.split(":");--}}
    {{--var et = endTime.split(":");--}}
    {{--var sst = new Date();--}}
    {{--sst.setHours(st[0]);--}}
    {{--sst.setMinutes(st[1]);--}}
    {{--var eet = new Date();--}}
    {{--eet.setHours(et[0]);--}}
    {{--eet.setMinutes(et[1]);--}}
    {{--if (sst > eet) {--}}
    {{--error = 1;--}}
    {{--$('.para').html('to value is bigger then from');--}}
    {{--$('.para').addClass('d-block');--}}
    {{--} else {--}}
    {{--error = 0;--}}
    {{--$('.para').removeClass('d-block');--}}
    {{--}--}}
    {{--}--}}

    {{--function change() {--}}
    {{--cf++;--}}
    {{--setTimeout(function() {--}}
    {{--$(document).on('change', `input[name="TimeSlot[${cf}][to]"]`, function() {--}}
    {{--validate1();--}}
    {{--});--}}
    {{--}, 100);--}}
    {{--}--}}

    {{--function validate1() {--}}
    {{--timecount = $('.timecount').length;--}}
    {{--for (let i = 0; i < timecount; i++) {--}}
    {{--var startTime = $('input[name="TimeSlot[' + i + '][from]"]').val();--}}
    {{--var endTime = $('input[name="TimeSlot[' + i + '][to]"]').val();--}}
    {{--currenttime = $(`input[name="TimeSlot[${cf}][from]"]`).val();--}}
    {{--currentto = $(`input[name="TimeSlot[${cf}][to]"]`).val();--}}
    {{--var st = startTime.split(":");--}}
    {{--var et = endTime.split(":");--}}
    {{--var ct = currenttime.split(":");--}}
    {{--var cft = currentto.split(":");--}}
    {{--var sst = new Date();--}}
    {{--sst.setHours(st[0]);--}}
    {{--sst.setMinutes(st[1]);--}}
    {{--var eet = new Date();--}}
    {{--eet.setHours(et[0]);--}}
    {{--eet.setMinutes(et[1]);--}}
    {{--var cct = new Date();--}}
    {{--cct.setHours(ct[0]);--}}
    {{--cct.setMinutes(ct[1]);--}}
    {{--var cff = new Date();--}}
    {{--cff.setHours(cft[0]);--}}
    {{--cff.setMinutes(cft[1]);--}}
    {{--if (cct < cff) {--}}
    {{--if (sst < cct && eet > cct) {--}}
    {{--error = 1;--}}
    {{--$('.para').html('Value not accepted');--}}
    {{--$('.para').addClass('d-block');--}}
    {{--break--}}
    {{--} else {--}}
    {{--error = 0;--}}
    {{--$('.para').removeClass('d-block');--}}
    {{--}--}}
    {{--} else {--}}
    {{--$('.para').html('to value is bigger then from');--}}
    {{--$('.para').addClass('d-block');--}}
    {{--break--}}
    {{--}--}}
    {{--}--}}
    {{--}--}}

    {{--$('#inlineCheckbox1').on('change', function() {--}}
    {{--var inlineCheckbox1 = $('#inlineCheckbox1').is(':checked') ? '1' : '0';--}}
    {{--$('#inlineCheckbox1').val(inlineCheckbox1);--}}
    {{--}).change();--}}
    {{--$('#inlineCheckbox2').on('change', function() {--}}
    {{--var inlineCheckbox2 = $('#inlineCheckbox2').is(':checked') ? '1' : '0';--}}
    {{--$('#inlineCheckbox2').val(inlineCheckbox2);--}}
    {{--}).change();--}}
    {{--$('#inlineCheckbox3').on('change', function() {--}}
    {{--var inlineCheckbox3 = $('#inlineCheckbox3').is(':checked') ? '1' : '0';--}}
    {{--$('#inlineCheckbox3').val(inlineCheckbox3);--}}
    {{--}).change();--}}
    {{--$('#inlineCheckbox4').on('change', function() {--}}
    {{--var inlineCheckbox4 = $('#inlineCheckbox4').is(':checked') ? '1' : '0';--}}
    {{--$('#inlineCheckbox4').val(inlineCheckbox4);--}}
    {{--}).change();--}}
    {{--$('#inlineCheckbox5').on('change', function() {--}}
    {{--var inlineCheckbox5 = $('#inlineCheckbox5').is(':checked') ? '1' : '0';--}}
    {{--$('#inlineCheckbox5').val(inlineCheckbox5);--}}
    {{--}).change();--}}
    {{--$('#inlineCheckbox6').on('change', function() {--}}
    {{--var inlineCheckbox6 = $('#inlineCheckbox6').is(':checked') ? '1' : '0';--}}
    {{--$('#inlineCheckbox6').val(inlineCheckbox6);--}}
    {{--}).change();--}}
    {{--$('#inlineCheckbox7').on('change', function() {--}}
    {{--var inlineCheckbox7 = $('#inlineCheckbox7').is(':checked') ? '1' : '0';--}}
    {{--$('#inlineCheckbox7').val(inlineCheckbox7);--}}
    {{--}).change();--}}
    {{--</script>--}}
@endsection
