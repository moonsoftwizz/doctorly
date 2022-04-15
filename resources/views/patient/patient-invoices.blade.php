@extends('layouts.master-layouts')
@section('title') {{ __('List of Invoices') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Invoice List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Invoice List @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr. No') }}</th>
                                    @if ($role != 'patient')
                                        <th>{{ __('Patient Name') }}</th>
                                    @endif
                                    <th>{{ __('Appointment Date') }}</th>
                                    <th>{{ __('Appointment Time') }}</th>
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
                                    $currentpage = $invoices->currentPage();
                                @endphp
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                        @if ($role != 'patient')
                                            <td>{{ $invoice->user->first_name }} {{ $invoice->user->last_name }}</td>
                                        @endif
                                        <td>{{ $invoice->appointment->appointment_date }}</td>
                                        <td>{{ $invoice->appointment->timeSlot->from . ' to ' . $invoice->appointment->timeSlot->to }}
                                        </td>
                                        <td>{{ $invoice->payment_status }}</td>
                                        <td>
                                            <a href="{{ url('invoice-view/' . $invoice->id) }}">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                    {{ __('View Details') }}
                                                </button>
                                            </a>
                                            {{-- @if ($invoice->payment_status == 'Unpaid')
                                                <div class="row justify-content-end">
                                                    <form id="chekout" method="POST" action="/razorpay-payment/{{ $invoice->id }}">
                                                        @csrf
                                                        <div class="">
                                                            <ul class="cart-total list-unstyled">
                                                                <li>
                                                                    <span>Total</span>
                                                                    <span class="cart-total__total">${{ $sum }}</span>
                                                                </li>
                                                            </ul><!-- /.cart-total -->
                                                            <div class="cart-page__buttons">
                                                                <button class="btn-success btn-sm btn-rounded waves-effect waves-light">
                                                                    <i class="btn-curve"></i>
                                                                    <span class="btn-title">Payment</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                @else
                                                    <span class="btn btn-success btn-sm btn-rounded waves-effect waves-light" style="display: inline;">Paid</span>
                                            @endif --}}
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
