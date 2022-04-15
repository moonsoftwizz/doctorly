@extends('layouts.master-layouts')
@section('title') {{ __('Profile') }} @endsection
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
            @slot('title') Profile @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Profile @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">{{ __('Patient Information') }}</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="@if ($patient->profile_photo != null){{ URL::asset('storage/images/users/' . $patient->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="{{ $patient->first_name }}"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"> {{ $patient->first_name }}
                                    {{ $patient->last_name }}</h5>
                            </div>
                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-size-12">{{ __('Last Login:') }}</h5>
                                            <p class="text-muted mb-0"> {{ $patient->last_login }} </p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ url('profile-edit') }}"
                                            class="btn btn-primary waves-effect waves-light btn-sm">{{ __('Edit Profile ') }}<i
                                                class="mdi mdi-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('Personal Information') }}</h4>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ __('Full Name:') }}</th>
                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Contact No:') }}</th>
                                        <td> {{ $patient->mobile }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Email:') }}</th>
                                        <td> {{ $patient->email }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Age:') }}</th>
                                        <td> {{ $patient_info->age }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Gender:') }}</th>
                                        <td> {{ $patient_info->gender }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Address:') }}</th>
                                        <td> {{ $patient_info->address }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Appointments') }}</p>
                                        <h4 class="mb-0">{{ number_format($data['total_appointment']) }}</h4>
                                    </div>
                                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-check-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Pending Bills') }}</p>
                                        <h4 class="mb-0">{{ number_format($data['pending_bill']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Total Bill') }}</p>
                                        <h4 class="mb-0">${{ number_format($data['revenue'], 2) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-package font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Medical_info" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Medical Information') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#AppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Appointment List') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#PrescriptionList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Prescription List') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Invoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Invoices') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Medical_info" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">{{ __('Height') }}</th>
                                                <td> {{ $medical_Info->height }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Weight') }}</th>
                                                <td> {{ $medical_Info->weight }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Blood Group') }}</th>
                                                <td> {{ $medical_Info->b_group }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Blood Pressure') }}</th>
                                                <td> {{ $medical_Info->b_pressure }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Pulse') }}</th>
                                                <td> {{ $medical_Info->pulse }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Respiration') }}</th>
                                                <td> {{ $medical_Info->respiration }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Allergy') }}</th>
                                                <td> {{ $medical_Info->allergy }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Diet') }}</th>
                                                <td> {{ $medical_Info->diet }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="AppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
                                        </tr>
                                    </thead>
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
                                        $currentpage = $appointments->currentPage();
                                    @endphp
                                    @foreach ($appointments as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->doctor->first_name }} {{ $item->doctor->last_name }}</td>
                                            <td>{{ $item->appointment_date }}</td>
                                            <td>{{ $item->timeSlot->from . ' to ' . $item->timeSlot->to }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of
                                        {{ $appointments->total() }} entries
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $appointments->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="PrescriptionList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Doctor Name') }}</th>
                                            <th>{{ __('Date') }}</th>
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
                                        @foreach ($prescriptions as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 }} </td>
                                                <td>{{ $item->doctor->first_name }} {{ $item->doctor->last_name }}
                                                </td>
                                                <td>{{ date('d-m-Y') }}</td>
                                                <td>
                                                    <a href="{{ url('prescription-view/' . $item->id) }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            {{ __('View') }}
                                                        </button>
                                                    </a>
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
                            <div class="tab-pane" id="Invoices" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr. No') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Status') }}</th>
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
                                        @foreach ($invoices as $item)
                                            <tr>
                                                <td> {{ $loop->index + 1 }} </td>
                                                <td>{{ date('d-m-Y') }}</td>
                                                <td>{{ $item->payment_status }}</td>
                                                <td>
                                                    <a href="{{ url('invoice-view/' . $item->id) }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            {{ __('View') }}
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of
                                        {{ $invoices->total() }} entries
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $invoices->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <!-- flot plugins -->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <!-- Plugins js -->
        {{-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script> --}}
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        {{-- <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script> --}}
        <script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
    @endsection
