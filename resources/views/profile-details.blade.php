@extends('layouts.master-without-nav')
@section('title') {{ __('Complete Profile') }} @endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="card overflow-hidden">
                            <div class="bg-soft-primary">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">{{ __('Registration') }}</h5>
                                            <p>Complete your {{ config('app.name') }} account first.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form method="POST" class="form-horizontal mt-4" action="{{ url('user') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <blockquote>{{ __('Basic Information') }}</blockquote>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Age ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('age') is-invalid @enderror" name="age"
                                                        id="patientAge" value="{{ old('age') }}"
                                                        placeholder="{{ __('Enter Age') }}">
                                                    @error('age')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Current Address ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <textarea id="formmessage" name="address"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        value="{{ old('address') }}" rows="3"
                                                        placeholder="{{ __('Enter Current Address') }}"></textarea>
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="formmessage">{{ __('Gender ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control @error('gender') is-invalid @enderror"
                                                        name="gender">
                                                        <option>{{ __('-- Select Gender --') }}</option>
                                                        <option value="Male">{{ __('Male') }}</option>
                                                        <option value="Female">{{ __('Female') }}</option>
                                                        <option value="Other">{{ __('Other') }}</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Profile Photo ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <img class="@error('profile_photo') is-invalid @enderror"
                                                        src="{{ URL::asset('assets/images/users/noImage.png') }}"
                                                        id="profile_display" onclick="triggerClick()" data-toggle="tooltip"
                                                        data-placement="top" title="Click to Upload Profile Photo" />
                                                    <input type="file"
                                                        class="form-control @error('profile_photo') is-invalid @enderror"
                                                        name="profile_photo" id="profile_photo" style="display:none;"
                                                        onchange="displayProfile(this)">
                                                    @error('profile_photo')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <blockquote>{{ __('Medical Information') }}</blockquote>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Height ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('height') is-invalid @enderror"
                                                        name="height" value="{{ old('height') }}" id="patientHeight"
                                                        placeholder="{{ __('Enter Height') }}">
                                                    @error('height')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="formmessage">{{ __('Blood Group ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control @error('b_group') is-invalid @enderror"
                                                        name="b_group">
                                                        <option>{{ __('-- Select Blood Group --') }}</option>
                                                        <option value="A+">{{ __('A+') }}</option>
                                                        <option value="A-">{{ __('A-') }}</option>
                                                        <option value="B+">{{ __('B+') }}</option>
                                                        <option value="B-">{{ __('B-') }}</option>
                                                        <option value="O+">{{ __('O+') }}</option>
                                                        <option value="O-">{{ __('O-') }}</option>
                                                        <option value="AB+">{{ __('AB+') }}</option>
                                                        <option value="AB-">{{ __('AB-') }}</option>
                                                    </select>
                                                    @error('b_group')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Pulse ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('pulse') is-invalid @enderror"
                                                        name="pulse" value="{{ old('pulse') }}" id="patientPulse"
                                                        placeholder="{{ __('Enter Pulse') }}">
                                                    @error('pulse')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Allergy ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('allergy') is-invalid @enderror"
                                                        name="allergy" id="patientAllergy" value="{{ old('allergy') }}"
                                                        placeholder="{{ __('Enter Allergy Symptoms') }}">
                                                    @error('allergy')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Weight ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('weight') is-invalid @enderror"
                                                        name="weight" id="patientWeight" value="{{ old('weight') }}"
                                                        placeholder="{{ __('Enter Weight') }}">
                                                    @error('weight')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Blood Pressure ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('b_pressure') is-invalid @enderror"
                                                        name="b_pressure" id="blood_pressure"
                                                        value="{{ old('b_pressure') }}"
                                                        placeholder="{{ __('Enter Blood Pressure') }}">
                                                    @error('b_pressure')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Respiration ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('respiration') is-invalid @enderror"
                                                        name="respiration" id="patientRespiration"
                                                        value="{{ old('respiration') }}"
                                                        placeholder="{{ __('Enter Respiration') }}">
                                                    @error('respiration')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Diet ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control @error('diet') is-invalid @enderror"
                                                        name="diet">
                                                        <option>{{ __('-- Select Diet --') }}</option>
                                                        <option value="Vegetarian">{{ __('Vegetarian') }}</option>
                                                        <option value="Non-vegetarian">{{ __('Non-vegetarian') }}
                                                        </option>
                                                        <option value="Vegan">{{ __('Vegan') }}</option>
                                                    </select>
                                                    @error('diet')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit"
                                                class="btn btn-primary form-control">{{ __('Save Profile') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            // Profile Photo
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
        </script>
    @endsection
