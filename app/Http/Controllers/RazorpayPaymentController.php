<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\PaymentApi;
use App\Transaction;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class RazorpayPaymentController extends Controller
{
    //}

    public function store(Request $request , $id){
        $user = Sentinel::getUser();
        $email = $user->email;
        $invoice = Invoice::with('invoice_detail')->where('id', $id)->first();
        $receiptId = Str::random(20);
        $sub_total=0;
        $razorpay = PaymentApi::where('gateway_type',1)->where('is_deleted',0)->first();
        if($razorpay){
            $api = new Api($razorpay->key, $razorpay->secret);
            foreach ($invoice->invoice_detail as $item) {

                $sub_total += (float)$item->amount;
                $tax = ($sub_total * 5) / 100;
                $sum=$sub_total + ($sub_total * 5) / 100;
            }
            $order = $api->order->create(
                array('receipt' => $receiptId,
                'amount' => round($sum,2)*100,
                'currency' => 'USD')
            );
            // return $order->amount;
            session()->push('invoice_id',$id);
            $response = [
                'orderId' => $order['id'],
                'razorpayId' => $razorpay->key,
                'amount' => $sum,
                'email' =>$email,
                'name' => 'Doctorly Invoice',
                'currency' => 'USD',
            ];
            return view('payment.razorpayView',compact('response'));
        }
        else{
            return redirect('/')->with('error','Razorpay key not available! Please contact admin');
        }

    }

    public function payment_complete(Request $request){
        $user = Sentinel::getUser();
        $signatureStatus = $this->SignatureVerify(
            $request->signature,
            $request->paymentId,
            $request->orderId,
        );
        $admin_role = Sentinel::findRoleBySlug('admin');
        $admin_email = $admin_role->users()->with('roles')->pluck('email')->first();
        // return $admin_email;
        // dd();
        if($signatureStatus == true){
            $sub_total=0;
            $cart =session()->get('invoice_id');
            // return $cart;
            $invoice = Invoice::with('doctor', 'patient', 'invoice_detail', 'appointment', 'appointment.timeSlot','transaction')->where('id', $cart)->first();
            $verify_mail = $invoice->patient->email;
            $app_name =  config('app.name');

            foreach ($invoice->invoice_detail as $item) {

                $sub_total += $item->amount;
                $tax = ($sub_total * 5) / 100;
                $sum=$sub_total + ($sub_total * 5) / 100;
            }
            $transaction = new Transaction();
            $transaction->billing_name =$user->first_name .' '.$user->last_name;
            $transaction->user_id = $user->id;
            $transaction->invoice_id = $invoice->id;
            $transaction->order_id = $request->orderId;
            $transaction->transaction_no = $request->paymentId;
            $transaction->amount = $sum;
            $transaction->signature = $request->signature;
            $transaction->save();

            session()->forget('invoice_id');
            // invoice  status change
            $invoice->payment_status = 'Paid';
            $invoice->updated_by = $user->id;
            $invoice->save();

            Mail::send('emails.payment', ['invoice' => $invoice, 'email' => $verify_mail], function ($message) use ($verify_mail, $app_name) {
                $message->to($verify_mail);
                $message->subject($app_name . ' ' . 'Payment complete successfully');
            });
            Mail::send('emails.payment',['invoice'=>$invoice,'email'=>$admin_email], function ($message) use ($admin_email, $app_name){
                $message->to($admin_email);
                $message->subject($app_name.' '.'Payment complete successfully');
            });
            return  redirect('/')->with('success', 'Your payment has made successfully please check your email.');
        }
        else{
            return  redirect('/')->with('error', 'Your payment is failed');
        }
    }
    private function SignatureVerify($_signature,$_paymentId,$_orderId){
        try{
            $razorpay = PaymentApi::where('gateway_type',1)->where('is_deleted',0)->first();
            $api = new Api($razorpay->key, $razorpay->secret);
            $attributes  = array('razorpay_signature'  => $_signature,  'razorpay_payment_id'  => $_paymentId ,  'razorpay_order_id' => $_orderId);
            $order  = $api->utility->verifyPaymentSignature($attributes);
            return true;
        }catch(\Exception $e)
        {
            return false;
        }
    }
}
