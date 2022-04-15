@extends('layouts.master-without-nav')

@section('title') {{ __("Default Credentials") }} @endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">{{ config('app.name'); }} - Patient Management System</h5>
                                        <p>Here is your new account credentials with {{ config('app.name'); }}.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="{{ url('/') }}">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('assets/images/logo.png') }}" alt=""
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <h4>{{ __("Hello,") }} {{ $user->first_name }} {{ $user->last_name }}</h4>
                                <p>{{ __("Your account default credentials are as below.") }}</p>
                                <p><b>{{ __("Username:") }}</b> {{ $user->email }}</p>
                                <p><b>{{ __("Password:") }}</b> doctorly</p>
                                <p>{{ __("You can change your default password from profile menu after login.") }}</p>
                                <p>{{ __("Thank you,") }}</p>
                                <p>{{ config('app.name'); }}.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© {{ date('Y') }} {{ config('app.name'); }}. Crafted with
                            <i class="mdi mdi-heart text-danger"></i> {{ __("by Themesbrand") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
