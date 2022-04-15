<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\DoctorAvailableDay;
use App\DoctorAvailableTime;
use App\Invoice;
use App\InvoiceDetail;
use Illuminate\Http\Request;
use App\Patient;
use App\MedicalInfo;
use App\Prescription;
use App\ReceptionListDoctor;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{

    protected $patient, $medical_info, $MedicalInfo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->patient = new Patient();
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
    public function index()
    {
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Sentinel::check()) {
            return redirect('/');
        } else {
            return view('profile-details');
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
        $validation = $request->validate([
            'age' => 'required|numeric',
            'address' => 'required',
            'gender' => 'required',
            'profile_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:500',
            'height' => 'required',
            'b_group' => 'required',
            'pulse' => 'required',
            'allergy' => 'required',
            'weight' => 'required',
            'b_pressure' => 'required',
            'respiration' => 'required',
            'diet' => 'required'
        ]);
        try {
            $user = Sentinel::getUser();
            $patient = Sentinel::getUser();
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
            $patient->save();
            // patient details save
            $patient_id = $patient->id;
            $patient_Details = new Patient();
            $patient_Details->user_id = $patient_id;
            $patient_Details->age = $request->age;
            $patient_Details->gender = $request->gender;
            $patient_Details->address = $request->address;
            $patient_Details->save();
            return $patient_Details;
            // medical info save
            $medical_info = new MedicalInfo();
            $medical_info->user_id = $patient_id;
            $medical_info->height = $request->height;
            $medical_info->b_group = $request->b_group;
            $medical_info->pulse = $request->pulse;
            $medical_info->allergy = $request->allergy;
            $medical_info->weight = $request->weight;
            $medical_info->b_pressure = $request->b_pressure;
            $medical_info->respiration = $request->respiration;
            $medical_info->diet = $request->diet;
            $medical_info->save();
            return redirect('/')->with('success', 'Register Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('profile.update')) {
            $userId = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin') {
                return view('admin.admin-edit', compact('user', 'role'));
            } elseif ($role == 'doctor') {
                $doctor = Sentinel::getUser();
                $doctor_info = Doctor::where('user_id', '=', $doctor->id)->first();
                if ($doctor_info) {
                    $availableDay = DoctorAvailableDay::where('doctor_id', $doctor->id)->first();
                    $availableTime = DoctorAvailableTime::where('doctor_id', $doctor->id)->get();
                    return view('doctor.doctor-profile-edit', compact('user', 'role', 'doctor', 'doctor_info', 'availableDay', 'availableTime'));
                } else {
                    return redirect('/')->with('error', 'Doctor details not found');
                }
            } elseif ($role == 'receptionist') {
                $receptionist = Sentinel::getUser();
                $role = $user->roles[0]->slug;
                $doctor_role = Sentinel::findRoleBySlug('doctor');
                $doctors = $doctor_role->users()->with(['roles', 'doctor'])->where('is_deleted', 0)->get();
                $receptionist_doctor = ReceptionListDoctor::where('reception_id', $receptionist->id)->where('is_deleted', 0)->pluck('doctor_id');
                $doctor_user = User::whereIn('id', $receptionist_doctor)->pluck('id')->toArray();
                return view('receptionist.receptionist-profile-edit', compact('user', 'role', 'receptionist', 'doctors', 'doctor_user'));
            } elseif ($role == 'patient') {
                $patient = Sentinel::getUser();
                $patient_info = Patient::where('user_id', '=', $patient->id)->first();
                $medical_info = MedicalInfo::where('user_id', '=', $patient->id)->first();
                // return $patient;
                return view('patient.patient-edit', compact('user', 'role', 'patient', 'patient_info', 'medical_info'));
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('profile.update')) {
            $role = $user->roles[0]->slug;
            if ($role == 'admin') {
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'required|alpha',
                    'mobile' => 'required|numeric|digits:10',
                    'email' => 'required|email',
                    'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                ]);
                try {
                    $userId = $user->id;
                    if ($request->hasFile('profile_photo')) {
                        $des = 'app/public/images/users/.' . $user->profile_photo;
                        if (File::exists($des)) {
                            File::delete($des);
                        }
                        $file = $request->file('profile_photo');
                        $extension = $file->getClientOriginalExtension();
                        $imageName = time() . '.' . $extension;
                        $file->move(storage_path('app/public/images/users'), $imageName);
                        $user->profile_photo = $imageName;
                    }
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->last_name = $request->last_name;
                    $user->mobile = $request->mobile;
                    $user->updated_by = $userId;
                    $user->save();
                    return redirect('/')->with('success', 'Profile updated successfully!');
                } catch (Exception $e) {
                    return redirect('/')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            } elseif ($role == 'doctor') {
                $doctor = Sentinel::getUser();
                $user = Sentinel::getUser();
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'required|alpha',
                    'mobile' => 'required|numeric|digits:10',
                    'email' => 'required|email',
                    'title' => 'required',
                    'fees' => 'required',
                    'degree' => 'required',
                    'experience' => 'required',
                    'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                    'mon' => 'required_without_all:tue,wen,thu,fri,sat,sun',
                    'tue' => 'required_without_all:mon,wen,thu,fri,sat,sun',
                    'wen' => 'required_without_all:mon,tue,thu,fri,sat,sun',
                    'thu' => 'required_without_all:mon,wen,tue,fri,sat,sun',
                    'fri' => 'required_without_all:wen,tue,mon,thu,sat,sun',
                    'sat' => 'required_without_all:wen,tue,mon,thu,fri,sun',
                    'sun' => 'required_without_all:wen,tue,mon,thu,fri,sat',
                ]);
                try {
                    $user = Sentinel::getUser();
                    $role = $user->roles[0]->slug;
                    if ($request->hasFile('profile_photo')) {
                        $des = 'app/public/images/users/.' . $doctor->profile_photo;
                        if (File::exists($des)) {
                            File::delete($des);
                        }
                        $file = $request->file('profile_photo');
                        $extention = $file->getClientOriginalExtension();
                        $imageName = time() . '.' . $extention;
                        $file->move(storage_path('app/public/images/users'), $imageName);
                        $doctor->profile_photo = $imageName;
                    }
                    $doctor->first_name = $validatedData['first_name'];
                    $doctor->last_name = $validatedData['last_name'];
                    $doctor->mobile = $validatedData['mobile'];
                    $doctor->email = $validatedData['email'];
                    $doctor->updated_by = $user->id;
                    $doctor->save();
                    Doctor::where('user_id', $doctor->id)
                        ->update([
                            'title' => $validatedData['title'],
                            'degree' => $validatedData['degree'],
                            'experience' => $validatedData['experience'],
                            'fees' => $validatedData['fees'],
                        ]);
                    $availableDay = DoctorAvailableDay::where('doctor_id', $doctor->id)->first();
                    $availableDay->doctor_id = $doctor->id;
                    if ($availableDay->mon = $request->mon !== Null) {
                        $availableDay->mon = $request->mon;
                    }
                    if ($availableDay->tue = $request->tue !== Null) {
                        $availableDay->tue = $request->tue;
                    }
                    if ($availableDay->wen = $request->wen !== Null) {
                        $availableDay->wen = $request->wen;
                    }
                    if ($availableDay->thu = $request->thu !== Null) {
                        $availableDay->thu = $request->thu;
                    }
                    if ($availableDay->fri = $request->fri !== Null) {
                        $availableDay->fri = $request->fri;
                    }
                    if ($availableDay->sat = $request->sat !== Null) {
                        $availableDay->sat = $request->sat;
                    }
                    if ($availableDay->sun = $request->sun !== Null) {
                        $availableDay->sun = $request->sun;
                    }
                    $availableDay->save();
                    if ($role == 'doctor') {
                        return redirect('/')->with('success', 'Profile updated successfully!');
                    } else {
                        return redirect('doctor')->with('success', 'Profile updated successfully!');
                    }
                } catch (Exception $e) {
                    return redirect('doctor')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            } elseif ($role == 'receptionist') {
                $receptionist = Sentinel::getUser();
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'required|alpha',
                    'mobile' => 'required|numeric|digits:10',
                    'email' => 'required|email',
                    'doctor' => 'required',
                    'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
                ]);
                try {
                    $user = Sentinel::getUser();
                    $role = $user->roles[0]->slug;
                    if ($request->hasFile('profile_photo')) {
                        $des = 'app/public/images/users/.' . $receptionist->profile_photo;
                        if (File::exists($des)) {
                            File::delete($des);
                        }
                        $file = $request->file('profile_photo');
                        $extention = $file->getClientOriginalExtension();
                        $imageName = time() . '.' . $extention;
                        $file->move(storage_path('app/public/images/users'), $imageName);
                        $receptionist->profile_photo = $imageName;
                    }
                    $receptionist->first_name = $validatedData['first_name'];
                    $receptionist->last_name = $validatedData['last_name'];
                    $receptionist->mobile = $validatedData['mobile'];
                    $receptionist->email = $validatedData['email'];
                    $receptionist->updated_by = $user->id;

                    $old_doctor = ReceptionListDoctor::where('reception_id', $receptionist->id)->pluck('doctor_id')->toArray();
                    $new_doctor = $request->doctor;
                    $numArray = array_map('intval', $new_doctor);
                    // remove doctor
                    $differenceArray1 = array_diff($old_doctor, $numArray);
                    // add doctor
                    $differenceArray2 = array_diff($numArray, $old_doctor);
                    $receptionistDoctor = ReceptionListDoctor::where('reception_id', $receptionist->id)->pluck('doctor_id');
                    if ($differenceArray1 && $differenceArray2) {
                        // add and remove both doctor
                        if ($differenceArray1) {
                            $receptionistDoctor = ReceptionListDoctor::whereIn('doctor_id', $differenceArray1)->delete();
                        }
                        if ($differenceArray2) {
                            foreach ($differenceArray2 as $item) {
                                $receptionistDoctor = new ReceptionListDoctor();
                                $receptionistDoctor->doctor_id = $item;
                                $receptionistDoctor->reception_id = $receptionist->id;
                                $receptionistDoctor->save();
                            }
                        }
                    } elseif ($differenceArray1) {
                        // only remove doctor
                        $receptionistDoctor = ReceptionListDoctor::whereIn('doctor_id', $differenceArray1)->delete();
                    } elseif ($differenceArray2) {
                        // only add doctor
                        foreach ($differenceArray2 as $item) {
                            $receptionistDoctor = new ReceptionListDoctor();
                            $receptionistDoctor->doctor_id = $item;
                            $receptionistDoctor->reception_id = $receptionist->id;
                            $receptionistDoctor->save();
                        }
                    }
                    $receptionist->save();
                    if ($role == 'receptionist') {
                        return redirect('/')->with('success', 'Profile updated successfully!');
                    } else {
                        return redirect('receptionist')->with('success', 'Profile updated successfully!');
                    }
                } catch (Exception $e) {
                    return redirect('receptionist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            } elseif ($role == 'patient') {
                $patient = Sentinel::getUser();
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'required|alpha',
                    'mobile' => 'required|numeric|digits:10',
                    'email' => 'required|email',
                    'age' => 'required|numeric',
                    'address' => 'required',
                    'gender' => 'required',
                    'height' => 'required',
                    'b_group' => 'required',
                    'pulse' => 'required',
                    'allergy' => 'required',
                    'weight' => 'required',
                    'b_pressure' => 'required',
                    'respiration' => 'required',
                    'diet' => 'required',
                    'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
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
                    $patient->first_name = $request->first_name;
                    $patient->last_name = $request->last_name;
                    $patient->mobile = $request->mobile;
                    $patient->email = $request->email;
                    $patient->updated_by = $user->id;
                    $patient->save();
                    $patient_info= Patient::where('user_id', '=', $user->id)->first();
                    if($patient_info == null){
                        $patient_info = new Patient();
                        $patient_info->age = $request->age;
                        $patient_info->gender = $request->gender;
                        $patient_info->address = $request->address;
                        $patient_info->user_id = $user->id;
                        $patient_info->save();
                    }
                    else{
                        $patient_info->age = $request->age;
                        $patient_info->gender = $request->gender;
                        $patient_info->address = $request->address;
                        $patient_info->user_id = $user->id;
                        $patient_info->save();
                    }
                    $medical_info = MedicalInfo::where('user_id', '=', $patient->id)->first();
                    if($medical_info == null){
                        $medical_info = new MedicalInfo();
                        $medical_info->height = $request->height;
                        $medical_info->b_group = $request->b_group;
                        $medical_info->pulse = $request->pulse;
                        $medical_info->allergy = $request->allergy;
                        $medical_info->weight = $request->weight;
                        $medical_info->b_pressure = $request->b_pressure;
                        $medical_info->respiration = $request->respiration;
                        $medical_info->diet = $request->diet;
                        $medical_info->user_id = $user->id;
                        $medical_info->save();
                    }
                    else{
                        $medical_info->height = $request->height;
                        $medical_info->b_group = $request->b_group;
                        $medical_info->pulse = $request->pulse;
                        $medical_info->allergy = $request->allergy;
                        $medical_info->weight = $request->weight;
                        $medical_info->b_pressure = $request->b_pressure;
                        $medical_info->respiration = $request->respiration;
                        $medical_info->diet = $request->diet;
                        $medical_info->user_id = $user->id;
                        $medical_info->save();
                    }
                    if ($role == 'patient') {
                        return redirect('/')->with('success', 'Profile updated successfully!');
                    } else {
                        return redirect('patient')->with('success', 'Profile updated successfully!');
                    }
                } catch (Exception $e) {
                    return redirect('patient')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
    public function profile_view()
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($role == 'patient') {
            $patient = Sentinel::getUser();
            $patient_info = Patient::where('user_id', '=', $patient->id)->first();
            if ($patient) {
                $medical_Info = MedicalInfo::where('user_id', '=', $patient->id)->first();
                $patient_role = Sentinel::findRoleBySlug('patient');
                $patients = $patient_role->users()->with('roles')->get();
                $appointments = Appointment::with('doctor')->where('appointment_for', $patient->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'appointment');
                $prescriptions = Prescription::with('doctor')->where('patient_id', $patient->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'prescription');
                $invoices = Invoice::where('patient_id', $patient->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'invoice');
                $tot_appointment = Appointment::where('appointment_for', $patient->id)->get();
                $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                    $re->select(DB::raw('SUM(amount)'));
                }])->where('patient_id', $patient->id)->pluck('id');
                $revenue = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');
                $pending_bill = Invoice::where(['patient_id' => $patient->id, 'payment_status' => 'Unpaid'])->count();
                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue,
                    'pending_bill' => $pending_bill
                ];
                return view('patient.patient-profile-view', compact('user', 'role', 'patient', 'patient_info', 'medical_Info', 'data', 'appointments', 'prescriptions', 'invoices'));
            } else {
                return redirect('/')->with('error', 'Patient not found');
            }
        } elseif ($role == 'doctor') {
            $doctor = Sentinel::getUser();
            $doctor_id = $doctor->id;
            $role = $user->roles[0]->slug;
            $doctor_info = Doctor::where('user_id', '=', $doctor->id)->first();
            if ($doctor_info) {
                $appointments = Appointment::where(function ($re) use ($doctor_id) {
                    $re->orWhere('appointment_with', $doctor_id);
                    $re->orWhere('booked_by', $doctor_id);
                })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointments');
                $prescriptions = Prescription::with('patient')->where('created_by', $doctor->id)->orderby('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                $invoices = Invoice::with('user')->where('invoices.created_by', '=', $doctor->id)->orderby('id', 'desc')->get();
                $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $doctor_id)->pluck('reception_id');
                $invoices = Invoice::with('user')->where('doctor_id', $doctor_id)->paginate($this->limit, '*', 'invoices');
                $tot_appointment = Appointment::where(function ($re) use ($doctor_id) {
                    $re->orWhere('appointment_with', $doctor_id);
                    $re->orWhere('booked_by', $doctor_id);
                })->get();
                $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                    $re->select(DB::raw('SUM(amount)'));
                }])->where('doctor_id', $doctor_id)->pluck('id');
                $revenue = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');

                $pending_bill = Invoice::where(['doctor_id' => $doctor_id, 'payment_status' => 'Unpaid'])->count();

                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue,
                    'pending_bill' => $pending_bill
                ];
                $availableDay = DoctorAvailableDay::where('doctor_id', $doctor->id)->first();
                $availableTime = DoctorAvailableTime::where('doctor_id', $doctor->id)->where('is_deleted', 0)->get();
                return view('doctor.doctor-profile-view', compact('user', 'role', 'doctor', 'doctor_info', 'data', 'appointments', 'availableTime', 'prescriptions', 'invoices', 'availableDay'));
            } else {
                return redirect('/')->with('error', 'Doctors details not found');
            }
        } elseif ($role == 'receptionist') {
            $receptionist = Sentinel::getUser();
            $user_id = $receptionist->id;
            $role = $user->roles[0]->slug;
            $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
            $tot_appointment = Appointment::where(function ($re) use ($user_id, $receptionists_doctor_id) {
                $re->whereIN('appointment_with', $receptionists_doctor_id);
                $re->orWhereIN('booked_by', $receptionists_doctor_id);
                $re->orWhere('booked_by', $user_id);
            })->get();

            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                $re->orWhereIN('created_by', $receptionists_doctor_id);
                $re->orWhere('created_by', $user_id);
            })->pluck('id');
            $revenue = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');

            $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                ->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('doctor_id', $receptionists_doctor_id);
                    $re->orWhere('created_by', $user_id);
                })->count();
            $data = [
                'total_appointment' => $tot_appointment->count(),
                'revenue' => $revenue,
                'pending_bill' => $pending_bill
            ];
            $appointments = Appointment::where(function ($re) use ($user_id, $receptionists_doctor_id) {
                $re->whereIN('appointment_with', $receptionists_doctor_id);
                $re->orWhereIN('booked_by', $receptionists_doctor_id);
                $re->orWhere('booked_by', $user_id);
            })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointments');
            $invoices = Invoice::with('user')
                ->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('doctor_id', $receptionists_doctor_id);
                    $re->orWhere('created_by', $user_id);
                })->paginate($this->limit, '*', 'invoice');
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctors = $doctor_role->users()->with(['roles', 'doctor'])->where('is_deleted', 0)->get();
            $receptionist_doctor = ReceptionListDoctor::where('reception_id', $receptionist->id)->where('is_deleted', 0)->pluck('doctor_id');
            $doctor_user = User::whereIn('id', $receptionist_doctor)->get();
            return view('receptionist.receptionist-profile-view', compact('user', 'role', 'receptionist', 'data', 'appointments', 'invoices', 'doctor_user'));
        } else {
            return redirect('/')->with('error', 'role not found');
        }
    }
}
