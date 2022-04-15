<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{$response['razorpayId']}}",
        "amount": "{{$response['amount']}}",
        "currency": "{{$response['currency']}}",
        "name": "{{$response['name']}}",
        "order_id": "{{$response['orderId']}}",
        "handler": function (response){
            console.log(response);
            document.getElementById('paymentid').value = response.razorpay_payment_id;
            document.getElementById('orderid').value = response.razorpay_order_id;
            document.getElementById('signature').value = response.razorpay_signature;
            document.getElementById('paymentresponse').click();
        },
        "prefill": {
            "name": "{{$response['name']}}",
            "email":"{{ $response['email'] }}",
            "mobile": "9865986598",
        },
        "modal": {
        "ondismiss": function(){
            window.location.href=document.referrer
        }
    }
    };
    var rzp1 = new Razorpay(options);
    window.onload = function(){
        rzp1.open();
    };
</script>

<form action="{{url('/payment-complete')}}" method="POST" hidden>
    @csrf
    <input type="text" class="form-control" id="paymentid"  name="paymentId">
    <input type="text" class="form-control" id="orderid" name="orderId">
    <input type="text" class="form-control" id="signature" name="signature">
    <button type="submit" id="paymentresponse" class="btn btn-primary">Submit</button>
</form>
