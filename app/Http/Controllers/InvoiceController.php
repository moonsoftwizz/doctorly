<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceDetail;
use App\Notification;
use App\ReceptionListDoctor;
use App\Transaction;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Facades\Config;


class InvoiceController extends Controller
{
    protected $invoice, $invoice_detail, $InvoiceDetail;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->invoice = new Invoice;
        $this->middleware(function ($request, $next) {
            if (session()->has('page_limit')) {
                $this->limit = session()->get('page_limit');
            } else {
                $this->limit = Config::get('app.page_limit');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            if ($role == 'doctor') {
                $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $user_id)->pluck('reception_id');
                $invoices = Invoice::with('user')->where('doctor_id', $user_id)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $invoices = Invoice::with('appointment', 'appointment.timeSlot')->where('patient_id', $user_id)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role = 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $invoices = Invoice::with('user', 'appointment', 'appointment.timeSlot')->where('created_by', $user_id)->orWhereIn('created_by', $receptionists_doctor_id)->orderBy('id', 'DESC')->paginate($this->limit);
            } else{
                $invoices = Invoice::with('user')->paginate($this->limit);
            }
            return view('invoice.invoices', compact('user', 'role', 'invoices'));
        } else {
            return view('error.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.create')) {
            $role = $user->roles[0]->slug;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctor = $doctor_role->users()->with('roles')->get();
            return view('invoice.invoice-details', compact('user', 'role', 'patients', 'doctor'));
        } else {
            return view('error.403');
        }
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
        if ($user->hasAccess('invoice.create')) {
            $request->validate([
                'patient_id' => 'required',
                'appointment_id' => 'required',
                'payment_mode' => 'required',
                'payment_status' => 'required'
            ]);
            try {
                $user = Sentinel::getUser();
                if ($request->invoices[0]['title'] == null && $request->invoices[0]['amount'] == null) {
                    return redirect()->back()->with('error', 'Add at least one Invoice title and amount to create invoice!!!');
                } else {
                    $this->invoice->patient_id = $request->patient_id;
                    $this->invoice->payment_mode = $request->payment_mode;
                    $this->invoice->payment_status = $request->payment_status;
                    $this->invoice->appointment_id = $request->appointment_id;
                    if ($request->doctor_id !== Null) {
                        $this->invoice->doctor_id = $request->doctor_id;
                    } else {
                        $this->invoice->doctor_id = $request->created_by;
                    }
                    if ($request->created_by == Null) {
                        $this->invoice->created_by = $request->created_by;
                    } else {
                        $this->invoice->created_by = $request->created_by;
                    }
                    $this->invoice->created_by = $request->created_by;
                    $this->invoice->updated_by = $user->id;
                    $this->invoice->save();
                    foreach ($request->invoices as $item) {
                        $this->invoice_detail = new InvoiceDetail();
                        $this->invoice_detail->invoice_id = $this->invoice->id;
                        $this->invoice_detail->title = $item['title'];
                        $this->invoice_detail->amount = $item['amount'];
                        $this->invoice_detail->save();
                    }
                    // Invoice generated notification send
                    $notification = new Notification();
                    $notification->notification_type_id = 4;
                    $notification->title = 'New invoice Generated';
                    $notification->data = $this->invoice->id;
                    $notification->from_user = $this->invoice->created_by;
                    $notification->to_user = $this->invoice->patient_id;
                    $notification->save();
                    return redirect('invoice')->with('success', 'Invoice created successfully!');
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.show')) {
            $user = Sentinel::getUser();
            $role = $user->roles[0]->slug;
            $invoice_detail = Invoice::with('invoice_detail', 'patient', 'doctor', 'appointment', 'appointment.timeSlot','transaction')->where('id', $invoice->id)->first();
            // return $invoice_detail;
            return view('invoice.view-invoice', compact('user', 'role', 'invoice', 'invoice_detail'));
        } else {
            return view('error.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.edit')) {
            $user = Sentinel::getUser();
            $role = $user->roles[0]->slug;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->get();
            $invoice_detail = Invoice::with('invoice_detail','patient', 'doctor', 'appointment', 'appointment.timeSlot','appointment.doctor')->where('id',$id)->first();
            $patient_id = $invoice_detail->patient->id;
            $appointment = Appointment::where('appointment_for', $patient_id)->where('is_deleted', 0)->get();
            // return $invoice_detail;
            return view('invoice.edit-invoice', compact('user', 'role', 'invoice_detail','patients','appointment'));
        } else {
            return view('error.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.edit')) {
                $request->validate([
                    'patient_id' => 'required',
                    'appointment_id' => 'required',
                    'payment_mode' => 'required',
                    'payment_status' => 'required'
                ]);
                try {
                    $user = Sentinel::getUser();
                    if ($request->invoices[0]['title'] == null && $request->invoices[0]['amount'] == null) {
                        return redirect()->back()->with('error', 'Add at least one Invoice title and amount to create invoice!!!');
                    } else {
                        $invoice = Invoice::find($id);
                        $invoice->patient_id = $request->patient_id;
                        $invoice->payment_mode = $request->payment_mode;
                        $invoice->payment_status = $request->payment_status;
                        $invoice->appointment_id = $request->appointment_id;
                        if ($request->doctor_id !== Null) {
                            $invoice->doctor_id = $request->doctor_id;
                        } else {
                            $invoice->doctor_id = $request->created_by;
                        }
                        $invoice->updated_by = $user->id;
                        $invoice->save();
                        // old invoice_list details delete
                        $invoice_detail = InvoiceDetail::where('invoice_id', $invoice->id)->update(['is_deleted' => 1]);
                        foreach ($request->invoices as $item) {
                           $invoice_detail = new InvoiceDetail();
                           $invoice_detail->invoice_id = $invoice->id;
                           $invoice_detail->title = $item['title'];
                           $invoice_detail->amount = $item['amount'];
                           $invoice_detail->save();
                        }
                        return redirect('invoice')->with('success', 'Invoice updated successfully!');
                    }
                } catch (Exception $e) {
                    return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
        } else {
                return view('error.403');
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
    }
    public function patient_by_appointment(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.create')) {
            if ($request->ajax()) {
                $patient_id =  $request->patient_id;
                $user = Sentinel::getUser();
                $user_id = $user->id;
                $role = $user->roles[0]->slug;
                $doctor_role = Sentinel::findRoleBySlug('doctor');
                if ($role == 'doctor') {
                    $appointment = Appointment::where('id', $user_id)->orWhere('appointment_for', $patient_id)->where('appointment_with', $user_id)->where('status', 1)
                    ->orderBy('id', 'DESC')->pluck("appointment_date", "id")->all();
                } elseif ($role == 'receptionist') {
                    $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                    $appointment  = Appointment::where('appointment_for', $patient_id)->whereIN('appointment_with', $receptionists_doctor_id)->where('status', 1)
                        ->orderBy('id', 'DESC')->pluck("appointment_date", "id")->all();
                }
                $data = view('appointment.ajax-select-appointment', compact('appointment'))->render();
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Appointment select by Patient id!",
                    'options' => $data
                ]);
            }
        } else {
            return view('error.403');
        }
    }
    public function appointment_by_doctor(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.create')) {
            if ($request->ajax()) {
                $appointment_id =  $request->appointment_id;
                $user = Sentinel::getUser();
                $role = $user->roles[0]->slug;
                $doctor_role = Sentinel::findRoleBySlug('doctor');
                $appointment = Appointment::where('id', $appointment_id)->pluck('appointment_with');
                $doctors = $doctor_role->users()->where('id', $appointment)->select('first_name', 'last_name', 'id')->get();
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Appointment select by Patient id!",
                    'data' => $doctors
                ]);
            }
        } else {
            return view('error.403');
        }
    }
    public function invoice_list()
    {
        $user = Sentinel::getUser();
        $user_id = Sentinel::getUser()->id;
        $role = $user->roles[0]->slug;
        $invoices = Invoice::with('appointment', 'appointment.timeSlot')->where('patient_id', $user_id)->orderBy('id', 'DESC')->paginate($this->limit);
        return view('patient.patient-invoices', compact('user', 'role', 'invoices'));
    }
    public function invoice_view($id)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $invoice_detail = Invoice::with('invoice_detail', 'patient', 'doctor', 'appointment', 'appointment.timeSlot','transaction')->where('patient_id', $user->id)->where('id', $id)->first();
        // return $invoice_detail;
        if ($invoice_detail) {
            return view('patient.patient-invoice-view', compact('user', 'role', 'invoice_detail'));
        } else {
            return redirect()->back()->with('error', 'Invoice details not found');
        }
    }

    public function transaction(){
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $transaction = Transaction::paginate($this->limit);
        return view('admin.transaction',compact('transaction','user', 'role'));
    }
}
