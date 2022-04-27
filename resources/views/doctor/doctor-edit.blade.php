@extends('layouts.master-layouts')
@section('title')
    {{ __('Update Doctor Details') }}
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
                        {{ __('Update Doctor Details') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('doctor') }}">{{ __('Doctors') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Update Doctor Details') }}
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
                        <a href="{{ url('doctor/' . $doctor->id) }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Profile') }}
                            </button>
                        </a>
                    @endif
                @else
                    <a href="{{ url('doctor') }}">
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

                        <form action="{{ url('doctor/' . $doctor->id) }}" method="post" enctype="multipart/form-data">
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
                                                   value="{{ old('full_name', $doctor->full_name) }}"
                                                   placeholder="{{ __('Enter Doctor Name') }}">
                                            @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">{{ __(' Sex ') }}<span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="user_sex">
                                                <option selected>{{ old('user_sex', $doctor->user_sex) }}</option>
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
                                                   value="{{ old('doc_CPF', $doctor_info->doc_CPF) }}"
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
                                                   value="{{ old('doc_CPF', $doctor_info->doc_CRM) }}"
                                                   placeholder="{{ __('') }}">



                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label class="control-label">{{ __(' Aadvice ') }}<span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="doc_Advice">
                                                <option selected>{{ old('doc_Advice', $doctor_info->doc_Advice) }}</option>
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
                                                <option selected>{{ old('doc_specialty', $doctor_info->doc_specialty) }}</option>
                                                <option>VET</option>
                                                <option>Doctor</option>
                                                <option>Nurse</option>
                                                <option>General Clinic</option>
                                            </select>

                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Email ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="email" class="form-control"
                                                   name="email" value="@if ($doctor && $doctor_info){{ $doctor->email }}@elseif(old('email')){{ old('email') }}@endif"
                                                   placeholder="{{ __('Enter Email') }}">
                                            {{--@error('email')--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                            {{--<strong>{{ $message }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@enderror--}}
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
                                                   name="zip_code" value="{{ old('zip_code', $doctor->zip_code) }}"
                                                   placeholder="{{ __('Zipcode') }}">

                                        </div>
                                        <div class="col-md-7 form-group">
                                            <label class="control-label">{{ __('Street/ Ave ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="user_address" value="{{ old('user_address', $doctor->user_address) }}"
                                                   placeholder="{{ __('Address') }}">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-7 form-group">
                                            <label class="control-label">{{ __('City ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="city"
                                                   value="{{ old('city', $doctor->city) }}"
                                                   placeholder="{{ __('city') }}">

                                        </div>

                                        <div class="col-md-5 form-group">
                                            <label class="control-label">{{ __('Phone ') }}<span
                                                        class="text-danger">*</span></label>
                                            <input type="tel" class="form-control"
                                                   name="mobile"
                                                   value="@if ($doctor && $doctor_info){{ $doctor->mobile }}@elseif(old('mobile')){{ old('mobile') }}@endif"
                                                   placeholder="{{ __('Phone') }}">

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-7 form-group">
                                            <label class="control-label">{{ __('Password ') }}</label>
                                            <input type="password" class="form-control"
                                                   name="password"
                                                   value="{{ old('password', $doctor->password) }}"
                                                   placeholder="{{ __('Enter your password') }}">

                                        </div>
                                    </div>
                                </div>


                            </div>


                            <!--my code end here-->





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
        <!-- form init -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script>
            // // Profile Photo
            // function triggerClick() {
            //     document.querySelector('#profile_photo').click();
            // }
            //
            // function displayProfile(e) {
            //     if (e.files[0]) {
            //         var reader = new FileReader();
            //         reader.onload = function(e) {
            //             document.querySelector('#profile_display').setAttribute('src', e.target.result);
            //         }
            //         reader.readAsDataURL(e.files[0]);
            //     }
            // }
            // // Time validation
            // var timecount = $('.timecount').length;
            // let cf = 0;
            // let error = 0;
            //
            // function valinput0() {
            //     var startTime = $('input[name="TimeSlot[0][from]"]').val();
            //     var endTime = $('input[name="TimeSlot[0][to]"]').val();
            //     var st = startTime.split(":");
            //     var et = endTime.split(":");
            //     var sst = new Date();
            //     sst.setHours(st[0]);
            //     sst.setMinutes(st[1]);
            //     var eet = new Date();
            //     eet.setHours(et[0]);
            //     eet.setMinutes(et[1]);
            //     if (sst > eet) {
            //         error = 1;
            //         $('.para').html('to value is bigger then from');
            //         $('.para').addClass('d-block');
            //     } else {
            //         error = 0;
            //         $('.para').removeClass('d-block');
            //     }
            // }
            //
            // function change() {
            //     cf++;
            //     setTimeout(function() {
            //         $(document).on('change', `input[name="TimeSlot[${cf}][to]"]`, function() {
            //             validate1();
            //         });
            //     }, 100);
            // }
            //
            // function validate1() {
            //     timecount = $('.timecount').length;
            //     for (let i = 0; i < timecount; i++) {
            //         var startTime = $('input[name="TimeSlot[' + i + '][from]"]').val();
            //         var endTime = $('input[name="TimeSlot[' + i + '][to]"]').val();
            //         currenttime = $(`input[name="TimeSlot[${cf}][from]"]`).val();
            //         currentto = $(`input[name="TimeSlot[${cf}][to]"]`).val();
            //         var st = startTime.split(":");
            //         var et = endTime.split(":");
            //         var ct = currenttime.split(":");
            //         var cft = currentto.split(":");
            //         var sst = new Date();
            //         sst.setHours(st[0]);
            //         sst.setMinutes(st[1]);
            //         var eet = new Date();
            //         eet.setHours(et[0]);
            //         eet.setMinutes(et[1]);
            //         var cct = new Date();
            //         cct.setHours(ct[0]);
            //         cct.setMinutes(ct[1]);
            //         var cff = new Date();
            //         cff.setHours(cft[0]);
            //         cff.setMinutes(cft[1]);
            //         if (cct < cff) {
            //             if (sst < cct && eet > cct) {
            //                 error = 1;
            //                 $('.para').html('Value not accepted');
            //                 $('.para').addClass('d-block');
            //                 break
            //             } else {
            //                 error = 0;
            //                 $('.para').removeClass('d-block');
            //             }
            //         } else {
            //             $('.para').html('to value is bigger then from');
            //             $('.para').addClass('d-block');
            //             break
            //         }
            //     }
            // }
            // // Checkbox value check
            // $('#inlineCheckbox1').on('change', function() {
            //     var inlineCheckbox1 = $('#inlineCheckbox1').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox1').val(inlineCheckbox1);
            // }).change();
            // $('#inlineCheckbox2').on('change', function() {
            //     var inlineCheckbox2 = $('#inlineCheckbox2').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox2').val(inlineCheckbox2);
            // }).change();
            // $('#inlineCheckbox3').on('change', function() {
            //     var inlineCheckbox3 = $('#inlineCheckbox3').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox3').val(inlineCheckbox3);
            // }).change();
            // $('#inlineCheckbox4').on('change', function() {
            //     var inlineCheckbox4 = $('#inlineCheckbox4').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox4').val(inlineCheckbox4);
            // }).change();
            // $('#inlineCheckbox5').on('change', function() {
            //     var inlineCheckbox5 = $('#inlineCheckbox5').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox5').val(inlineCheckbox5);
            // }).change();
            // $('#inlineCheckbox6').on('change', function() {
            //     var inlineCheckbox6 = $('#inlineCheckbox6').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox6').val(inlineCheckbox6);
            // }).change();
            // $('#inlineCheckbox7').on('change', function() {
            //     var inlineCheckbox7 = $('#inlineCheckbox7').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox7').val(inlineCheckbox7);
            // }).change();
        </script>
    @endsection
