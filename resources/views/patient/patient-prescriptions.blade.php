@extends('layouts.master-layouts')
@section('title') {{ __('List of Prescription') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
@endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Prescription List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Prescription @endslot
        @endcomponent
        <!-- end page title -->
        <div class="alert alert-warning" role="alert">
            You can not saw prescription without  invoice payment
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($role == 'doctor')
                            <a href=" {{ route('prescription.create') }} ">
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i>
                                    {{ __('Create Prescription') }}
                                </button>
                            </a>
                        @endif
                        <table class="table table-bordered dt-responsive nowrap "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr. No') }}</th>
                                    @if ($role == 'doctor')
                                        <th>{{ __('Patient Name') }}</th>
                                    @elseif($role == 'patient')
                                        <th>{{ __('Doctor Name') }}</th>
                                    @else
                                        <th>{{ __('Patient Name') }}</th>
                                        <th>{{ __('Doctor Name') }}</th>
                                    @endif
                                    <th>{{ __('Appointment Date') }}</th>
                                    <th>{{ __('Appointment Time') }}</th>
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
                                    $currentpage = $prescriptions_details->currentPage();
                                @endphp
                                @foreach ($prescriptions_details as $item)
                                        <tr>
                                            {{-- {{$item->appointment->prescription}} --}}
                                            <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                            @if ($role == 'receptionist')
                                                <td>{{ $item->patient->first_name . ' ' . $item->patient->first_name }}
                                                </td>
                                                <td>{{ $item->doctor->first_name . ' ' . $item->doctor->first_name }}
                                                </td>
                                            @elseif ($role == 'doctor')
                                                <td>{{ $item->patient->first_name }}
                                                    {{ $item->patient->last_name }}</td>
                                            @elseif ($role == 'patient')
                                                <td>{{ $item->doctor->first_name }}
                                                    {{ $item->doctor->last_name }}</td>
                                            @else
                                                <td>{{ $item->patient->first_name }}
                                                    {{ $item->patient->last_name }}</td>
                                                <td>{{ $item->doctor->first_name }}
                                                    {{ $item->doctor->last_name }}</td>
                                            @endif
                                            <td>{{ $item->appointment->appointment_date }}</td>
                                            <td>{{ $item->appointment->timeSlot->from . ' to ' . $item->appointment->timeSlot->to }}
                                            </td>
                                            <td>
                                                <a href="{{ url('prescription-view/' . $item->appointment->prescription->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                        title="View item">
                                                        <i class="mdi mdi-eye"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-flex justify-content-start">
                                Showing {{ $prescriptions_details->firstItem() }} to {{ $prescriptions_details->lastItem() }} of
                                {{ $prescriptions_details->total() }} entries
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $prescriptions_details->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection
    @section('script')
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
    @endsection

