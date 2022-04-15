@extends('layouts.master-layouts')
@section('title') {{ __('Notification list') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Notification List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Notification @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div data-simplebar>
                                    @forelse ($notification as $item)
                                        <a href="/notification/{{ $item->id }}" class="text-reset notification-item">
                                            <div class="media mb-3 p-2 {{ $item->read_at == null ? 'bg-light' : '' }}">
                                                <img src="@if ($item->user->profile_photo != ''){{ URL::asset('storage/images/users/' . $item->user->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" class="mr-3 rounded-circle avatar-xs"
                                                    alt="user-pic">
                                                <div class="media-body">
                                                    @if ($item->notification_type_id == 4)
                                                        <h6 class="mt-0 mb-1">
                                                            <a
                                                                href="{{ url('patient/' . $item->invoice_user->patient->id) }}">
                                                                {{  $role == 'patient' ? '' : $item->invoice_user->patient->first_name . ' ' . $item->invoice_user->patient->first_name . '`s ' }}
                                                            </a>
                                                            {{ $item->title }} by
                                                            @if ($item->user->roles[0]->slug == 'doctor')
                                                                <a
                                                                    href={{ url('doctor/' . $item->user->id) }}>{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>
                                                            @elseif ($item->user->roles[0]->slug == 'patient')
                                                                <a
                                                                    href={{ url('patient/' . $item->user->id) }}>{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>
                                                            @elseif ($item->user->roles[0]->slug == 'receptionist')
                                                                <a
                                                                    href={{ url('receptionist/' . $item->user->id) }}>{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>
                                                            @else
                                                                <a>{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>

                                                            @endif
                                                        </h6>
                                                        <div class="font-sixe-12">
                                                            <p class="mb-0">invoice date:
                                                                {{ $item->invoice_user->created_at }}</p>
                                                        </div>
                                                    @else
                                                        <h6 class="mt-0 mb-1">
                                                            <a
                                                                href="{{ url('patient/' . $item->appointment_user->patient->id) }}">
                                                                {{ $role == 'patient' ? '' : $item->appointment_user->patient->first_name . ' ' . $item->appointment_user->patient->last_name . '`s ' }}
                                                            </a>
                                                            {{ $item->title }} by
                                                            @if ($item->user->roles[0]->slug == 'doctor')
                                                                <a
                                                                    href={{ url('doctor/' . $item->user->id) }}>{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>
                                                            @elseif ($item->user->roles[0]->slug == 'patient')
                                                                <a
                                                                    href={{ url('patient/' . $item->user->id) }}>{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>
                                                            @elseif ($item->user->roles[0]->slug == 'receptionist')
                                                                <a
                                                                    href={{ url('receptionist/' . $item->user->id) }}>{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>
                                                            @else
                                                                <a
                                                                    href="#!">{{ $item->user->first_name . ' ' . $item->user->last_name }}</a>
                                                            @endif
                                                        </h6>
                                                        <div class="font-sixe-12">
                                                            <p class="mb-0">Apppointment date:
                                                                {{ $item->appointment_user->appointment_date . ', time: ' . $item->appointment_user->timeSlot->from . ' to ' . $item->appointment_user->timeSlot->to }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                            {{ $item->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <p>No matching records found</p>
                                    @endforelse
                                    <div class="col-md-12 text-center mt-3">
                                        <div class="d-flex justify-content-center">
                                            {{ $notification->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
    @endsection
