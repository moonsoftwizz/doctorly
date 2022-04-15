<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Invoice;
use App\ReceptionListDoctor;
use Exception;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

class ReceptionistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session()->has('page_limit')) {
                $this->limit = session()->get('page_limit');
            } else {
                $this->limit = Config::get('app.page_limit');
            }
            return $next($request);
        });
        $this->middleware('sentinel.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $receptionist_role = Sentinel::findRoleBySlug('receptionist');
        $receptionists = $receptionist_role->users()->with('roles')->where('is_deleted', 0)->orderByDesc('id')->paginate($this->limit);
        if($role == 'doctor'){
            $receptionist_doctor = ReceptionListDoctor::where('doctor_id',$user->id)->pluck('reception_id');
            $receptionists = User::with('roles')->whereIn('id',$receptionist_doctor)->paginate($this->limit);
        }
        return view('receptionist.receptionists', compact('user', 'role', 'receptionists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.create')) {
            $role = $user->roles[0]->slug;
            $receptionist = null;
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctors = $doctor_role->users()->with(['roles', 'doctor'])->where('is_deleted', 0)->get();
            return view('receptionist.receptionist-details', compact('user', 'role', 'receptionist', 'doctors'));
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
        if ($user->hasAccess('receptionist.create')) {
            $doctor_id =  $request->doctor;
            $validatedData = $request->validate([
                'first_name' => 'required|alpha',
                'last_name' => 'required|alpha',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email|unique:users',
                'doctor' => 'required',
                'profile_photo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
            ]);
            if ($request->profile_photo != null) {
                $request->validate([
                    'profile_photo' => 'image'
                ]);
                $fileName = now()->timestamp . '.' . $request->file('profile_photo')->extension();
                $request->profile_photo->storeAs('images/users', $fileName, 'public');
                $validatedData['profile_photo'] = $fileName;
            }
            try {
                $user = Sentinel::getUser();
                // Set Default Password for Doctor
                $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
                $validatedData['created_by'] = $user->id;
                $validatedData['updated_by'] = $user->id;
                //Create a new user
                $receptionist = Sentinel::registerAndActivate($validatedData);
                //Attach the user to the role
                $role = Sentinel::findRoleBySlug('receptionist');
                $role->users()
                    ->attach($receptionist);
                foreach ($doctor_id as $item) {
                    $receptionistDoctor  = new ReceptionListDoctor();
                    $receptionistDoctor->doctor_id = $item;
                    $receptionistDoctor->reception_id = $receptionist->id;
                    $receptionistDoctor->save();
                }
                return redirect('receptionist')->with('success', 'Receptionist created successfully!');
            } catch (Exception $e) {
                return redirect('receptionist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function show(User $receptionist)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.view')) {
            $user_id = $receptionist->id;
            $receptionist = $user::whereHas('roles',function($rq){
                $rq->where('slug','receptionist');
            })->where('id', $receptionist->id)->where('is_deleted', 0)->first();
            if ($receptionist) {
                $role = $user->roles[0]->slug;
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $tot_appointment = Appointment::where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->get();

                $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$receptionist->id]);
                $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                    ->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                        $re->whereIN('doctor_id', $receptionists_doctor_id);
                        $re->orWhere('created_by', $user_id);
                    })->count();
                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue[0]->total,
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
                return view('receptionist.receptionist-profile', compact('user', 'role', 'receptionist', 'data', 'appointments', 'invoices', 'doctor_user'));
            } else {
                return redirect('/')->with('error', 'Receptionist not found');
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function edit(User $receptionist)
    {
        $user = Sentinel::getUser();
        $receptionist = $user::whereHas('roles',function($rq){
            $rq->where('slug','receptionist');
        })->where('id', $receptionist->id)->where('is_deleted', 0)->first();
        if($receptionist){

            if ($user->hasAccess('receptionist.update')) {
                $role = $user->roles[0]->slug;
                $doctor_role = Sentinel::findRoleBySlug('doctor');
                // return $doctor_role;
                $doctors = $doctor_role->users()->with(['roles', 'doctor'])->where('is_deleted', 0)->get();
                $receptionist_doctor = ReceptionListDoctor::where('reception_id', $receptionist->id)->where('is_deleted', 0)->pluck('doctor_id');
                $doctor_user = User::whereIn('id', $receptionist_doctor)->pluck('id')->toArray();
                return view('receptionist.receptionist-edit', compact('user', 'role', 'receptionist', 'doctors', 'doctor_user'));
            } else {
                return view('error.403');
            }
        }
        else{
            return redirect('/')->with('error', 'Receptionist not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $receptionist)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.update')) {
            $validatedData = $request->validate([
                'first_name' => 'required|alpha',
                'last_name' => 'required|alpha',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'doctor' => 'required',
                'profile_photo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
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
                    $extension = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extension;
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
                // remove old Doctor
                $differenceArray1 = array_diff($old_doctor, $numArray);
                // add New Doctor
                $differenceArray2 = array_diff($numArray, $old_doctor);
                $receptionistDoctor = ReceptionListDoctor::where('reception_id', $receptionist->id)->pluck('doctor_id');
                if ($differenceArray1 && $differenceArray2) {
                    // Add and remove both Doctor
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
                    // only remove Doctor
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
                    return redirect('receptionist')->with('success', 'Receptionist Profile updated successfully!');
                }
            } catch (Exception $e) {
                return redirect('receptionist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.delete')) {
        try {
            $receptionist = User::where('id',$request->id)->first();
                if ($receptionist != Null) {
                    $receptionist->is_deleted = 1;
                    $receptionist->save();
                    return response()->json([
                        'isSuccess' => true,
                        'message' => 'Receptionist deleted successfully.',
                        'data' => $receptionist,
                    ], 200);
                } else {
                    return response()->json([
                        'isSuccess' => false,
                        'message' => 'Receptionist not found.',
                        'data' => [],
                    ], 409);
                }
            } catch (Exception $e) {
                return response()->json([
                    'isSuccess' =>false,
                    'message' =>'Something went wrong!!!' .$e->getMessage(),
                    'data' => [],
                ],409);
            }
        } else {
            return response()->json([
                'isSuccess' =>false,
                'message' =>'You have no permission to delete Receptionist',
                'data'=> [],
            ],409);
        }
    }
    public function receptionist_view($id){
        $user = Sentinel::getUser();
            $user_id = $id;
            $receptionist_doctor = ReceptionListDoctor::where('doctor_id',$user->id)->pluck('reception_id');
            $receptionist = $user::where('id', $id)->where('is_deleted', 0)->WhereIn('id',$receptionist_doctor)->first();
            if ($receptionist) {
                $role = $user->roles[0]->slug;
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $tot_appointment = Appointment::where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->get();
                $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$receptionist->id]);
                $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                    ->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                        $re->whereIN('doctor_id', $receptionists_doctor_id);
                        $re->orWhere('created_by', $user_id);
                    })->count();
                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue[0]->total,
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
                return view('receptionist.receptionist-profile', compact('user', 'role', 'receptionist', 'data', 'appointments', 'invoices', 'doctor_user'));
            } else {
                return redirect('/')->with('error', 'receptionist not found');
            }
    }
}
