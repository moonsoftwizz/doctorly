@extends('layouts.master-layouts')
@section('title') {{ __('Invoice Details') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Invoice Details @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Invoice List @endslot
            @slot('li_3') Invoice Details @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="{{ url('invoice-list') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Invoice List') }}
                    </button>
                </a>
                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-right font-size-16">{{ __('Invoice #') }} {{ $invoice_detail->id }}</h4>
                            <div class="mb-4">
                                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="logo" height="20" />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">
                                <address>
                                    <strong>{{ __('Patient Details') }}</strong><br>
                                    {{ $invoice_detail->patient->first_name . ' ' . $invoice_detail->patient->last_name }}<br>
                                    <i class="mdi mdi-phone"></i> {{ $invoice_detail->patient->mobile }}<br>
                                    <i class="mdi mdi-email"></i> {{ $invoice_detail->patient->email }}<br>
                                </address>
                            </div>
                            <div class="col-3">
                                <address>
                                    <strong>{{ __('Doctor Details') }}</strong><br>
                                    {{ $invoice_detail->doctor->first_name . ' ' . $invoice_detail->doctor->last_name }}<br>
                                    <i class="mdi mdi-phone"></i> {{ $invoice_detail->doctor->mobile }}<br>
                                    <i class="mdi mdi-email"></i> {{ $invoice_detail->doctor->email }}<br>
                                </address>
                            </div>
                            <div class="col-3">
                                <address>
                                    <strong>{{ __('Payment Details') }}</strong><br>
                                    {{ __('Payment Mode :') }} {{ $invoice_detail->payment_mode }}<br>
                                    {{ __('Payment Status :') }} {{ $invoice_detail->payment_status }}<br>
                                    @if ($invoice_detail->transaction != null)
                                        {{ __('Order Id :') }} {{ $invoice_detail->transaction->order_id }}<br>
                                        {{ __('Transaction No:') }} {{ $invoice_detail->transaction->transaction_no }}<br>
                                        {{ __('Payment Method:') }} {{ $invoice_detail->transaction->payment_method }}<br>
                                    @endif
                                </address>
                            </div>
                            <div class="col-3 pull-right">
                                <address>
                                    <strong>{{ __('Invoice date: ') }}</strong>{{ $invoice_detail->created_at }}<br>
                                    <strong>{{ __('Appointment date: ') }}</strong>{{ $invoice_detail->appointment->appointment_date . ' ' . $invoice_detail->appointment->timeSlot->from . ' to ' . $invoice_detail->appointment->timeSlot->to }}
                                </address>
                            </div>
                        </div>
                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 font-weight-bold">{{ __('Invoice summary') }}</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">{{ __('No.') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th class="text-right">{{ __('Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sub_total = 0;
                                    @endphp

                                    @foreach ($invoice_detail->invoice_detail as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td class="text-right">${{ $item->amount }}</td>
                                        </tr>
                                        @php
                                            $sub_total += $item->amount;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="text-right">{{ __('Sub Total') }}</td>
                                        <td class="text-right">${{ $sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-right">
                                            <strong>{{ __('Tax (5%)') }}</strong>
                                        </td>
                                        <td class="border-0 text-right">${{ ($sub_total * 5) / 100 }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-right">
                                            <strong>{{ __('Total') }}</strong>
                                        </td>
                                        <td class="border-0 text-right">
                                            <h4 class="m-0">${{ $sub_total + ($sub_total * 5) / 100 }}</h4>
                                            @php $sum=$sub_total + ($sub_total * 5) / 100 @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-right">
                                            @if ($invoice_detail->payment_status == 'Unpaid')
                                                <div class="row justify-content-end">
                                                    {{-- <form id="chekout" method="POST" action="/razorpay-payment/{{ $invoice_detail->id }}"> --}}
                                                    {{-- <form id="chekout" method="POST" action="/stripe/{{ $invoice_detail->id }}">
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
                                                    </form> --}}
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                        Payment
                                                    </button>
                                                </div>
                                                @else
                                                    <span class="btn btn-success btn-sm btn-rounded waves-effect waves-light" style="display: inline;">Paid</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Choose payment Method</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                        <form id="chekout" method="POST" action="/stripe/{{ $invoice_detail->id }}">
                            @csrf
                            <div class="">
                                <ul class="cart-total list-unstyled d-none">
                                    <li>
                                        <span>Total</span>
                                        <span class="cart-total__total">${{ $sum }}</span>
                                    </li>
                                </ul>
                                <div class="cart-page__buttons text-center">
                                    <button class="btn btn-primary btn-lg btn-block">
                                        <i class="btn-curve"></i>
                                        <span class="btn-title">Stripe</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form id="chekout" method="POST" action="/razorpay-payment/{{ $invoice_detail->id }}">
                            @csrf
                            <div class="mt-2">
                                <ul class="cart-total list-unstyled d-none">
                                    <li>
                                        <span>Total</span>
                                        <span class="cart-total__total">${{ $sum }}</span>
                                    </li>
                                </ul>
                                <div class="cart-page__buttons text-center">
                                    <button class="btn btn-primary btn-lg btn-block">
                                        <i class="btn-curve"></i>
                                        <span class="btn-title">Razorpay</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        <!-- end row -->
    @endsection
        @section('script')
            {{-- <script>
                $('#payment').click(function (e) {
                    e.preventDefault();
                    console.log('click');
                    var URL =window.location.pathname;
                    console.log('url:',URL);
                    $.ajax({
                        type: "get",
                        url: URL,
                        success: function (response) {
                            console.log(response);
                        }
                    });
                });
            </script> --}}
        @endsection
