@extends('layouts.master-layouts')
@section('title') {{ __('Payment Gateway Key') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Payment Gateway @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Payment Gateway @endslot
        @endcomponent
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Razorpay Information') }}</blockquote>
                        <form action="{{route('payment-key.store')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$razorpay != null?$razorpay->id:''}}" name="id">
                            <div class="col-12 mb-2">
                                <label for="payment_key"> Key</label>
                                <input name="razorpay_key" value="{{ $razorpay!=null? $razorpay->key:'' }}" class="form-control" placeholder="Enter Razorpay Key">
                                @error('razorpay_key')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-2" >
                                <label for="payment_key"> secret</label>
                                <input name="razorpay_secret" value="{{ $razorpay!=null? $razorpay->secret:'' }}" class="form-control" placeholder="Enter Razorpay Secret">
                                @error('razorpay_secret')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="gateway_type" value="1">
                            <div class="d-flex justify-content-between">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                                @if ($razorpay)
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)"  class="btn btn-danger" data-id="{{ $razorpay->id }}"
                                            id="delete-api">
                                            {{ __('Delete') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Stripe Information') }}</blockquote>
                        <form action="{{route('payment-key.store')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$stripe != null?$stripe->id:''}}" name="id">
                            <div class="col-12 mb-2">
                                <label for="payment_key"> Key</label>
                                <input name="stripe_key" value="{{ $stripe !=null? $stripe->key:'' }}" class="form-control" placeholder="Enter Stripe Key">
                                @error('stripe_key')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-2">
                                <label for="payment_key"> secret</label>
                                <input name="stripe_secrets" value="{{ $stripe!=null? $stripe->secret:'' }}" class="form-control" placeholder="Enter Stripe Secret">
                                @error('stripe_secrets')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="gateway_type" value="2">
                            <div class="d-flex justify-content-between">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                                @if ($stripe)
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)"  class="btn btn-danger" data-id="{{ $stripe->id }}" id="delete-api">
                                            {{ __('Delete') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
    @endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
    <script>
        $(document).on('click', '#delete-api', function() {
            console.log('click');
            var id = $(this).data('id');
            if (confirm('Are you sure want to delete key and scret?')) {
                $.ajax({
                    type: "DELETE",
                    url: 'payment-key/' + id,
                    data: {
                        _token: '{{ csrf_token() }}',
                        id:id,
                    },
                    beforeSend: function() {
                        $('#pageloader').show()
                    },
                    success: function(response) {
                        toastr.success(response.message, 'Success Alert', {
                            timeOut: 2000
                        });
                        location.reload();
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message,{
                            timeOut: 20000
                        });
                    },
                    complete: function() {
                        $('#pageloader').hide();
                    }
                });
            }
        });
    </script>
@endsection
