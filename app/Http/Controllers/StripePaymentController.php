<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\PaymentApi;
use App\Transaction;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class StripePaymentController extends Controller
{
    public function store(Request $request,$id){
        $invoice_id = $id;
        $user = Sentinel::getUser();
        $user_id = $user->id;
        $email = $user->email;
        $invoice = Invoice::with('invoice_detail')->where('id', $id)->first();
        $sub_total=0;

        $stripe = PaymentApi::where('gateway_type',2)->where('is_deleted',0)->first();
        if($stripe){
            \Stripe\Stripe::setApiKey($stripe->secret);

            foreach ($invoice->invoice_detail as $item) {
                $sub_total += $item->amount;
                $tax = ($sub_total * 5) / 100;
                $sum=$sub_total + ($sub_total * 5) / 100;
            }
            $url = $request->getSchemeAndHttpHost();
            $session  = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Invoice',
                    ],
                    'unit_amount' => (float)round($sum,2)*100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $url.'/paymentComplete',
                'cancel_url' => $url.'/paymentComplete',
            ]);
            session()->forget('payment_intent');

            session()->push('payment_intent',[
                'payment' =>$session->payment_intent,
                'user_id'=>$user_id,
                'invoice_id' =>$invoice_id
            ]);
            return Redirect::to($session->url);
        }
        else{
            return redirect('/')->with('error','Stripe key not available! Please contact admin');
        }

    }

    public function payment_complete(Request $request){
        $stripe = PaymentApi::where('gateway_type',2)->where('is_deleted',0)->first();
        $stripe = new \Stripe\StripeClient($stripe->secret);
        if($stripe){
            $pay=$stripe->paymentIntents->retrieve(session()->get('payment_intent')[0]['payment'],[]);
            $user_id =session()->get('payment_intent')[0]['user_id'];
            $invoice_id= session()->get('payment_intent')[0]['invoice_id'];
            if($pay->status == 'succeeded'){
                $amount = $pay->amount/100;
                $data = [
                    'billing_name' => $pay->charges->data[0]->billing_details->name,
                    'user_id' =>$user_id,
                    'invoice_id'=>$invoice_id,
                    'order_id' =>$pay->charges->data[0]->id,
                    'transaction_no'=>$pay->charges->data[0]->payment_intent,
                    'amount'=>$pay->charges->data[0]->amount/100,
                    'payment_method' =>$pay->payment_method_types[0],
                ];
                $user = Sentinel::getUser();
                $invoice = Invoice::with('doctor', 'patient', 'invoice_detail', 'appointment', 'appointment.timeSlot','transaction')
                ->where('id', $data['invoice_id'])->first();
                $verify_mail = $invoice->patient->email;
                $app_name =  config('app.name');
                $admin_role = Sentinel::findRoleBySlug('admin');
                $admin_email = $admin_role->users()->with('roles')->pluck('email')->first();
                $transaction = new Transaction();
                $transaction->billing_name =$data['billing_name'];
                $transaction->user_id = $data['user_id'];
                $transaction->invoice_id = $data['invoice_id'];
                $transaction->order_id = $data['order_id'];
                $transaction->transaction_no = $data['transaction_no'];
                $transaction->amount = $data['amount'];
                $transaction->payment_method = $data['payment_method'];
                $transaction->save();
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
                return redirect('/')->with('error','Something went wrong! Payment failed');
            }
        }
        else{
            return redirect('/')->with('error','Stripe key not available! Please contact admin');

        }
    }
}
