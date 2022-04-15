@extends('layouts.master-layouts')
@section('title') {{ __('List of Transaction') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Transaction List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Transactions @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div></div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr. No') }}</th>
                                    <th>{{ __('Billing name') }}</th>
                                    <th>{{ __('Order id') }}</th>
                                    <th>{{ __('Transaction no') }}</th>
                                    <th>{{ __('Amount ($)') }}</th>
                                    <th>{{ __('Payment Method') }}</th>

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
                                    $currentpage = $transaction->currentPage();
                                @endphp
                                @foreach ($transaction as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 + $per_page * ($currentpage - 1) }} </td>
                                        <td> {{ $item->billing_name }}</td>
                                        <td> {{ $item->order_id }} </td>
                                        <td> {{ $item->transaction_no }} </td>
                                        <td> {{ $item->amount }} </td>
                                        <td> {{ $item->payment_method }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-flex justify-content-start">
                                Showing {{ $transaction->firstItem() }} to {{ $transaction->lastItem() }} of
                                {{ $transaction->total() }} entries
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $transaction->links() }}
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
