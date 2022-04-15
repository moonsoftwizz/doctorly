<?php

namespace App\Http\Controllers;
use Exception;
use App\PaymentApi;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class PaymentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $razorpay = PaymentApi::where('gateway_type',1)->where('is_deleted',0)->first();
        $stripe = PaymentApi::where('gateway_type',2)->where('is_deleted',0)->first();
        return view('admin.payment-key',compact('user','role','razorpay','stripe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.create')) {
            if($request->gateway_type == 1){
                $validatedData = $request->validate([
                    'razorpay_key' => 'required',
                    'razorpay_secret' => 'required',
                ]);
                if($request->id == null){
                    $payment_api = new PaymentApi();
                }
                else{
                    $payment_api = PaymentApi::where('gateway_type',1)->where('is_deleted',0)->first();
                }
                $payment_api->key = $request->razorpay_key;
                $payment_api->secret = $request->razorpay_secret;
                $payment_api->gateway_type = 1;
            }
            else if($request->gateway_type == 2){
                $validatedData = $request->validate([
                    'stripe_key' => 'required',
                    'stripe_secrets' => 'required',
                ]);
                if($request->id == null){
                    $payment_api = new PaymentApi();

                }
                else{
                    $payment_api = PaymentApi::where('gateway_type',2)->where('is_deleted',0)->first();
                }
                $payment_api->key = $request->stripe_key;
                $payment_api->secret = $request->stripe_secrets;
                $payment_api->gateway_type = 2;
            }
            else{
                return redirect()->back()->with('error','Please enter valid details');
            }
            $payment_api->save();
            return redirect()->back()->with('success','Api key added successfully');
        }
        else{
            return view('error.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.delete')) {
            try {
                $paymentApi = PaymentApi::where('id',$request->id)->first();
                if ($paymentApi !=null) {
                    $paymentApi->is_deleted = 1;
                    $paymentApi->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Payment api deleted successfully.',
                        'data' => $paymentApi,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment api not found.',
                        'data' => [],
                    ], 409);
                }
            } catch (Exception $e) {
                return response()->json([
                    'success' =>false,
                    'message' => 'Something went wrong!!!'.$e->getMessage(),
                    'data' =>[],
                ],409);
            }
        } else {
            return response()->json([
                'success' =>false,
                'message'=>'You have no permission to delete Payment Api',
                'data'=>[],
            ],409);
        }
    }
}
