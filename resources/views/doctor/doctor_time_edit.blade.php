@extends('layouts.master-layouts')
@section('title') {{ __('Update Doctor Time Slot') }} @endsection
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
                        {{ __('Update Doctor Time Slot') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('doctor') }}">{{ __('Doctors') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Update Doctor Time Slot') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                @if ($role == 'doctor')
                    <a href="{{ url('/') }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Dashboard') }}
                        </button>
                    </a>
                @else
                    <a href="{{ url('doctor/' . $doctor->id) }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Profile') }}
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('time-update/' . $doctor->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $doctor->id }}" id="form_id" />
                            <input type="hidden" name="id" id="time_id" />
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Slots Time (In Minute) ') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('slot_time') is-invalid @enderror"
                                        name="slot_time" id="slot_time">
                                        <option value="" disabled selected>00</option>
                                        @for ($i = 1; $i <= 60; $i++)
                                            <option value="{{ $i }}"
                                                {{ $i == $doctor_info->slot_time ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('slot_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class='repeater mb-4'>
                                        <div data-repeater-list="TimeSlot" class="form-group">
                                            <label>{{ __('Available Time ') }}<span
                                                    class="text-danger">*</span></label>
                                            <div data-repeater-item class="mb-3 row">
                                                <div class="col-md-5 col-6">
                                                    <label class="label-control">From:</label>
                                                    <input type="time" name="from"
                                                        class="form-control timecount  @error('TimeSlot.*.from') is-invalid @enderror"
                                                        placeholder="{{ __('From time') }}" />
                                                    @error('TimeSlot.*')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <label class="label-control">To:</label>
                                                    <input type="time" name="to"
                                                        class="form-control  @error('TimeSlot.*.to') is-invalid @enderror"
                                                        placeholder="{{ __('To time') }}" onchange="valinput0()" />
                                                    @error('TimeSlot.*.to')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <input data-repeater-delete type="button" onclick="cf--"
                                                        class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner "
                                                        value="X" />
                                                </div>
                                            </div>
                                        </div>
                                        <p class="para error d-none"></p>
                                        <input data-repeater-create type="button" class="btn btn-primary" value="Add Time"
                                            onclick="change()" id="btn-x" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Update Time
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
        <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
        <!-- form init -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script>
            //  profile photo
            function triggerClick() {
                document.querySelector('#profile_photo').click();
            }
            function displayProfile(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#profile_display').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
            // time validation
            var timecount = $('.timecount').length
            let cf = 0;
            let error = 0;
            var id = $('#form_id').val();
            $.ajax({
                type: "get",
                url: "/time-update-ajax/" + id,
                success: function(response) {
                    var i = 0;
                    $.each(response.data, function(key, value) {
                        $("input[name='TimeSlot[" + i + "][from]']").val(value.from);
                        $("input[name='TimeSlot[" + i + "][to]']").val(value.to);
                        i++;
                        if (i != response.data.length)
                            $('#btn-x').click();
                    });
                },
                error: function(response) {}
            });
            function valinput0() {
                var startTime = $('input[name="TimeSlot[0][from]"]').val();
                var endTime = $('input[name="TimeSlot[0][to]"]').val();
                var st = startTime.split(":");
                var et = endTime.split(":");
                var sst = new Date();
                sst.setHours(st[0]);
                sst.setMinutes(st[1]);
                var eet = new Date();
                eet.setHours(et[0]);
                eet.setMinutes(et[1]);
                if (sst > eet) {
                    error = 1;
                    $('.para').html('to value is bigger then from');
                    $('.para').addClass('d-block');
                } else {
                    error = 0;
                    $('.para').removeClass('d-block');
                }
            }
            function change() {
                cf++;
                setTimeout(function() {
                    $(document).on('change', `input[name="TimeSlot[${cf}][to]"]`, function() {
                        validate1();
                    });
                }, 100);
            }
            function validate1() {
                timecount = $('.timecount').length;
                for (let i = 0; i < timecount; i++) {
                    var startTime = $('input[name="TimeSlot[' + i + '][from]"]').val();
                    var endTime = $('input[name="TimeSlot[' + i + '][to]"]').val();
                    currenttime = $(`input[name="TimeSlot[${cf}][from]"]`).val();
                    currentto = $(`input[name="TimeSlot[${cf}][to]"]`).val();
                    var st = startTime.split(":");
                    var et = endTime.split(":");
                    var ct = currenttime.split(":");
                    var cft = currentto.split(":");
                    var sst = new Date();
                    sst.setHours(st[0]);
                    sst.setMinutes(st[1]);
                    var eet = new Date();
                    eet.setHours(et[0]);
                    eet.setMinutes(et[1]);
                    var cct = new Date();
                    cct.setHours(ct[0]);
                    cct.setMinutes(ct[1]);
                    var cff = new Date();
                    cff.setHours(cft[0]);
                    cff.setMinutes(cft[1]);
                    if (cct < cff) {
                        if (sst < cct && eet > cct) {
                            error = 1;
                            $('.para').html('Value not accepted');
                            $('.para').addClass('d-block');
                            break;
                        } else {
                            error = 0;
                            $('.para').removeClass('d-block');
                        }
                    } else {
                        $('.para').html('to value is bigger then from');
                        $('.para').addClass('d-block');
                        break;
                    }
                }
            }
        </script>
    @endsection
