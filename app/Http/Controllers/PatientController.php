<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Invoice;
use App\InvoiceDetail;
use App\Patient;
use App\User;
use App\MedicalInfo;
use App\Prescription;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\File;


class PatientController extends Controller
{
    protected $patient_info, $medical_info, $MedicalInfo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->patient_info = new Patient();
        $this->medical_info = new MedicalInfo();
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
    public function index(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('patient.list')) {
            $role = $user->roles[0]->slug;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with(['roles'])->where('is_deleted', 0)->orderByDesc('id')->paginate($this->limit);

            $search = $request['search_name'] ? : "";
            $searchCRM = $request['search_crm'] ? : "";

            if ($search != '' OR $searchCRM != '') {
                $patients = $patient_role->users()->with(['roles', 'patient'])
                    ->join('patients','patients.user_id','=','users.id')
                    ->where('full_name', $search)->orWhere('patients.patient_CPF', $searchCRM)->orderByDesc('id')->paginate($this->limit);
            }


            return view('patient.patients', compact('user', 'role', 'patients', 'search', 'searchCRM'));
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
        if ($user->hasAccess('patient.create')) {
            $role = $user->roles[0]->slug;
            $patient = null;
            $patient_info = null;
            $medical_info = null;
            return view('patient.patient-details', compact('user', 'role', 'patient', 'patient_info', 'medical_info'));
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
        if ($user->hasAccess('patient.create')) {
            $validatedData = $request->validate([
                'full_name' => '',
                'user_sex'=>'',
                'zip_code'=>'',
                'user_address'=>'',
                'city'=>'',
                'patient_dob'=>'',
                'patient_Age'=>'',
                'patient_rg'=>'',
                'patient_CPF'=>'',
                'patient_responsible'=>'',
                'patient_health'=>'',
                'patient_company'=>'',
                'patient_enrollment'=>'',
                'patient_plan'=>'',
                'patient_observation'=>'',
                'patient_social_name'=>'',

                'mobile' => '',
                'email' => '',

                'height' => '',
                'b_group' => '',
                'pulse' => '',
                'allergy' => '',
                'weight' => '',
                'b_pressure' => '',
                'respiration' => '',
                'diet' => '',
                'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500'
            ]);
//            if ($request->profile_photo != null) {
//                $request->validate([
//                    'profile_photo' => 'image'
//                ]);
//                $fileName = now()->timestamp . '.' . $request->file('profile_photo')->extension();
//                $request->profile_photo->storeAs('images/users', $fileName, 'public');
//                $validatedData['profile_photo'] = $fileName;
//            }
            try {
                $user = Sentinel::getUser();
                // Set Default Password for Doctor
                $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
                $validatedData['created_by'] = $user->id;
                $validatedData['updated_by'] = $user->id;
                //Create a new user
                $patient = Sentinel::registerAndActivate($validatedData);
                //Attach the user to the role
                $role = Sentinel::findRoleBySlug('patient');
                $role->users()
                    ->attach($patient);
                //$validatedData['user_id'] = $patient->id;

                $patient_details = new Patient();

                $patient_details->user_id = $patient->id;

                $patient_details->patient_dob = $validatedData['patient_dob'];
                $patient_details->patient_Age = $validatedData['patient_Age'];
                $patient_details->patient_rg = $validatedData['patient_rg'];
                $patient_details->patient_CPF = $validatedData['patient_CPF'];

                $patient_details->patient_responsible = $validatedData['patient_responsible'];
                $patient_details->patient_health = $validatedData['patient_health'];
                $patient_details->patient_company = $validatedData['patient_company'];
                $patient_details->patient_enrollment = $validatedData['patient_enrollment'];

                $patient_details->patient_plan = $validatedData['patient_plan'];
                $patient_details->patient_observation = $validatedData['patient_observation'];
                $patient_details->patient_social_name = $validatedData['patient_social_name'];


                $patient_details->save();



                $this->patient_info->create($validatedData);
                $this->medical_info->create($validatedData);
                return redirect('patient')->with('success', 'Patient created successfully!');
            } catch (Exception $e) {
                return redirect('patient')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('patient.view')) {
            $role = $user->roles[0]->slug;
            $patient = $user::whereHas('roles',function($rq){
                $rq->where('slug','patient');
            })->where('id', $patient->id)->where('is_deleted', 0)->first();
            if ($patient) {
                $patient_info = Patient::where('user_id', '=', $patient->id)->first();
                if ($patient_info) {
                    $medical_Info = MedicalInfo::where('user_id', '=', $patient->id)->first();
                    $patient_role = Sentinel::findRoleBySlug('patient');
                    $patients = $patient_role->users()->with('roles')->get();
                    $appointments = Appointment::with('doctor')->where('appointment_for', $patient->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'appointment');
                    $prescriptions = Prescription::with('doctor')->where('patient_id', $patient->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                    $invoices = Invoice::where('patient_id', $patient->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'invoice');
                    $tot_appointment = Appointment::where('appointment_for', $patient->id)->get();
                    $invoice = Invoice::where('patient_id', $patient->id)->pluck('id');
                    $revenue = InvoiceDetail::whereIn('invoice_id',$invoice)->sum('amount');
                    $pending_bill = Invoice::where(['patient_id' => $patient->id, 'payment_status' => 'Unpaid'])->count();
                    $data = [
                        'total_appointment' => $tot_appointment->count(),
                        'revenue' => $revenue,
                        'pending_bill' => $pending_bill
                    ];
                    return view('patient.patient-profile', compact('user', 'role', 'patient', 'patient_info', 'medical_Info', 'data', 'appointments', 'prescriptions', 'invoices'));
                } else {
                    return redirect('/')->with('error', 'Patient information  not found, update patient information');
                }
            } else {
                return redirect('/')->with('error', 'Patient not found');
            }
        } else {
            return view('error.403');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(User $patient)
    {
        $user = Sentinel::getUser();
        $patient = $user::whereHas('roles',function($rq){
            $rq->where('slug','patient');
        })->where('id', $patient->id)->where('is_deleted', 0)->first();
        if($patient){
            if ($user->hasAccess('patient.update')) {
                $role = $user->roles[0]->slug;
                $patient_info = Patient::where('user_id', '=', $patient->id)->first();
                $medical_info = MedicalInfo::where('user_id', '=', $patient->id)->first();
                return view('patient.patient-details', compact('user', 'role', 'patient', 'patient_info', 'medical_info'));
            } else {
                return view('error.403');
            }
        }
        else{
            return redirect('/')->with('error', 'Patient not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $patient)
    {
        // return $request;
        $user = Sentinel::getUser();
        if ($user->hasAccess('patient.update')) {
            $validatedData = $request->validate([
                'full_name' => '',
                'user_sex'=>'',
                'zip_code'=>'',
                'user_address'=>'',
                'city'=>'',
                'patient_dob'=>'',
                'patient_Age'=>'',
                'patient_rg'=>'',
                'patient_CPF'=>'',
                'patient_responsible'=>'',
                'patient_health'=>'',
                'patient_company'=>'',
                'patient_enrollment'=>'',
                'patient_plan'=>'',
                'patient_observation'=>'',
                'patient_social_name'=>'',

                'mobile' => '',
                'email' => '',
            ]);
            try {
                $user = Sentinel::getUser();
                $role = $user->roles[0]->slug;
                if ($request->hasFile('profile_photo')) {
                    $des = 'app/public/images/users/.' . $patient->profile_photo;
                    if (File::exists($des)) {
                        File::delete($des);
                    }
                    $file = $request->file('profile_photo');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(storage_path('app/public/images/users'), $imageName);
                    $patient->profile_photo = $imageName;
                }


              //  $patient_details->save();

                $patient->full_name = $validatedData['full_name'];
                $patient->user_sex = $validatedData['user_sex'];
                $patient->zip_code = $validatedData['zip_code'];
                $patient->user_address = $validatedData['user_address'];
                $patient->city = $validatedData['city'];
                $patient->mobile = $validatedData['mobile'];
                $patient->email = $validatedData['email'];
                $patient->updated_by = $user->id;
                $patient->save();
                $patient_info= Patient::where('user_id', '=', $patient->id)->first();
                    if($patient_info == null){
                        $patient_info = new Patient();
                        $patient_info->patient_dob = $request->patient_dob;
                        $patient_info->patient_Age = $request->patient_Age;
                        $patient_info->patient_rg = $request->patient_rg;

                        $patient_info->patient_CPF = $request->patient_CPF;
                        $patient_info->patient_responsible = $request->patient_responsible;
                        $patient_info->patient_health = $request->patient_health;
                        $patient_info->patient_company = $request->patient_company;
                        $patient_info->patient_enrollment = $request->patient_enrollment;

                        $patient_info->patient_plan = $request->patient_plan;
                        $patient_info->patient_observation = $request->patient_observation;
                        $patient_info->patient_social_name = $request->patient_social_name;

                        $patient_info->user_id = $patient->id;
                        $patient_info->save();
                    }
                    else{

                        $patient_info->patient_dob = $request->patient_dob;
                        $patient_info->patient_Age = $request->patient_Age;
                        $patient_info->patient_rg = $request->patient_rg;

                        $patient_info->patient_CPF = $request->patient_CPF;
                        $patient_info->patient_responsible = $request->patient_responsible;
                        $patient_info->patient_health = $request->patient_health;
                        $patient_info->patient_company = $request->patient_company;
                        $patient_info->patient_enrollment = $request->patient_enrollment;

                        $patient_info->patient_plan = $request->patient_plan;
                        $patient_info->patient_observation = $request->patient_observation;
                        $patient_info->patient_social_name = $request->patient_social_name;

                        $patient_info->user_id = $patient->id;
                        $patient_info->save();
                    }
//                    $medical_info = MedicalInfo::where('user_id', '=', $patient->id)->first();
//                    if($medical_info == null){
//                        $medical_info = new MedicalInfo();
//                        $medical_info->height = $request->height;
//                        $medical_info->b_group = $request->b_group;
//                        $medical_info->pulse = $request->pulse;
//                        $medical_info->allergy = $request->allergy;
//                        $medical_info->weight = $request->weight;
//                        $medical_info->b_pressure = $request->b_pressure;
//                        $medical_info->respiration = $request->respiration;
//                        $medical_info->diet = $request->diet;
//                        $medical_info->user_id = $patient->id;
//                        $medical_info->save();
//                    }
//                    else{
//                        $medical_info->height = $request->height;
//                        $medical_info->b_group = $request->b_group;
//                        $medical_info->pulse = $request->pulse;
//                        $medical_info->allergy = $request->allergy;
//                        $medical_info->weight = $request->weight;
//                        $medical_info->b_pressure = $request->b_pressure;
//                        $medical_info->respiration = $request->respiration;
//                        $medical_info->diet = $request->diet;
//                        $medical_info->user_id = $patient->id;
//                        $medical_info->save();
//                    }
                if ($role == 'patient') {
                    return redirect('/')->with('success', 'Profile updated successfully!');
                } else {
                    return redirect('patient')->with('success', 'Patient Profile updated successfully!');
                }
            } catch (Exception $e) {
                return redirect('patient')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Sentinel::getUser();
        $patient = $user::whereHas('roles',function($rq){
            $rq->where('slug','patient');
        })->where('id', $request->id)->where('is_deleted', 0)->first();
        if($patient){
            if ($user->hasAccess('patient.delete')) {
                try {
                    $User = User::where('id',$request->id)->first();
                    if ($User != Null) {
                        $User->is_deleted = 1;
                        $User->save();
                        return response()->json([
                            'success' => true,
                            'message' => 'Patient deleted successfully.',
                            'data' => $User,
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Patient not found.',
                            'data' => [],
                        ], 409);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'success' =>false,
                        'message' => 'Something went wrong!!!' . $e->getMessage(),
                        'data' => [],
                    ],409);
                }
            }
            else {
                return response()->json([
                    'success' =>false,
                    'message' =>'You have no permission to delete patient',
                    'data'=> [],
                ],409);
            }
        }else{
            return redirect('/')->with('error', 'Patient not found');
        }
    }
}
