<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\DoctorAvailableDay;
use App\DoctorAvailableSlot;
use App\DoctorAvailableTime;
use App\Invoice;
use App\Prescription;
use App\ReceptionListDoctor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    protected $doctor_details;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->doctor_details = new Doctor();
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
        if ($user->hasAccess('doctor.list')) {
            $role = $user->roles[0]->slug;
            $user = Sentinel::getUser();
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            if ($role == 'receptionist') {
                $prescriptions_doctor = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $doctors = User::whereIN('id', $prescriptions_doctor)->where('is_deleted', 0)->paginate($this->limit);
            } else {
                $doctors = $doctor_role->users()->with(['roles', 'doctor'])->where('is_deleted', 0)->orderByDesc('id')->paginate($this->limit);
            }
            return view('doctor.doctors', compact('user', 'role', 'doctors'));
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
        if ($user->hasAccess('doctor.create')) {
            $role = $user->roles[0]->slug;
            $doctor = null;
            $doctor_info = null;
            return view('doctor.doctor-details', compact('user', 'role', 'doctor', 'doctor_info'));
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
        if ($user->hasAccess('doctor.create')) {
            $slot_time = $request->slot_time;
            $validatedData = $request->validate(
                [
                    'first_name' => 'required|alpha',
                    'last_name' => 'required|alpha',
                    'mobile' => 'required|numeric|digits:10',
                    'email' => 'required|email|unique:users',
                    'title' => 'required',
                    'fees' => 'required',
                    'degree' => 'required',
                    'experience' => 'required',
                    'slot_time' => 'required',
                    'mon' => 'required_without_all:tue,wen,thu,fri,sat,sun',
                    'tue' => 'required_without_all:mon,wen,thu,fri,sat,sun',
                    'wen' => 'required_without_all:mon,tue,thu,fri,sat,sun',
                    'thu' => 'required_without_all:mon,wen,tue,fri,sat,sun',
                    'fri' => 'required_without_all:wen,tue,mon,thu,sat,sun',
                    'sat' => 'required_without_all:wen,tue,mon,thu,fri,sun',
                    'sun' => 'required_without_all:wen,tue,mon,thu,fri,sat',
                    'TimeSlot.*.from' => 'required',
                    'TimeSlot.*.to' => 'required',
                    'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500'
                ],
            );

            if ($request->profile_photo != null) {
                $request->validate([
                    'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500'
                ]);
                $fileName = now()->timestamp . '.' . $request->file('profile_photo')->extension();
                $request->profile_photo->storeAs('images/users', $fileName, 'public');
                $validatedData['profile_photo'] = $fileName;
            }
            try {
                $user = Sentinel::getUser();
                if ($request->TimeSlot[0]['from'] == null && $request->TimeSlot[0]['to'] == null) {
                    return redirect()->back()->with('error', 'Add available time');
                } else {
                    $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
                    $validatedData['created_by'] = $user->id;
                    $validatedData['updated_by'] = $user->id;
                    //Create a new user
                    $doctor = Sentinel::registerAndActivate($validatedData);
                    //Attach the user to the role
                    $role = Sentinel::findRoleBySlug('doctor');
                    $role->users()->attach($doctor);
                    $doctor_details = new Doctor();
                    $doctor_details->user_id = $doctor->id;
                    $doctor_details->title = $request->title;
                    $doctor_details->degree = $request->degree;
                    $doctor_details->experience = $request->experience;
                    $doctor_details->fees = $request->fees;
                    $doctor_details->slot_time = $request->slot_time;
                    $doctor_details->save();
                    // Doctor Available day record add
                    $availableDay = new DoctorAvailableDay();
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
                    foreach ($request->TimeSlot as $key => $item) {
                        $availableTime = new DoctorAvailableTime();
                        $availableTime->doctor_id = $doctor->id;
                        $availableTime->from = $item['from'];
                        $availableTime->to = $item['to'];
                        $availableTime->save();
                        $start_datetime = Carbon::parse($item['from'])->format('H:i:s');
                        $end_datetime = Carbon::parse($item['to'])->format('H:i:s');
                        $start_datetime_carbon = Carbon::parse($item['from']);
                        $end_datetime_carbon = Carbon::parse($item['to']);
                        $totalDuration = $end_datetime_carbon->diffInMinutes($start_datetime_carbon);
                        $totalSlots = $totalDuration / $slot_time;
                        for ($a = 0; $a <= $totalSlots; $a++) {
                            $slot_time_start_min = $a * $slot_time;
                            $slot_time_end_min = $slot_time_start_min + $slot_time;
                            $slot_time_start = Carbon::parse($start_datetime)->addMinute($slot_time_start_min)->format('H:i:s');
                            $slot_time_end = Carbon::parse($start_datetime)->addMinute($slot_time_end_min)->format('H:i:s');
                            if ($slot_time_end <= $end_datetime) {
                                // add time slot here
                                $time = $slot_time_start . '<=' . $slot_time_end . '<br>';
                                $availableSlot = new DoctorAvailableSlot();
                                $availableSlot->doctor_id = $doctor->id;
                                $availableSlot->doctor_available_time_id = $availableTime->id;
                                $availableSlot->from = $slot_time_start;
                                $availableSlot->to = $slot_time_end;
                                $availableSlot->save();
                            }
                        }
                    }
                    return redirect('doctor')->with('success', 'Doctor created successfully!');
                }
            } catch (Exception $e) {
                return redirect('doctor')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(User $doctor)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.view')) {
            $doctor_id = $doctor->id;
            $role = $user->roles[0]->slug;
            $doctor = $user::whereHas('roles',function($rq){
                $rq->where('slug','doctor');
            })->where('id', $doctor_id)->where('is_deleted', 0)->first();
            if ($doctor) {
                $doctor_info = Doctor::where('user_id', '=', $doctor->id)->orWhere('is_deleted', 0)->first();
                if ($doctor_info) {
                    $appointments = Appointment::where(function ($re) use ($doctor_id) {
                        $re->orWhere('appointment_with', $doctor_id);
                        $re->orWhere('booked_by', $doctor_id);
                    })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointment');
                    $prescriptions = Prescription::with('patient')->where('created_by', $doctor->id)->orderby('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                    $invoices = Invoice::with('user')->where('invoices.created_by', '=', $doctor->id)->orderby('id', 'desc')->get();
                    $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $doctor_id)->pluck('reception_id');
                    $invoices = Invoice::with('user')->where('doctor_id', $doctor_id)->paginate($this->limit, '*', 'invoice');

                    $tot_appointment = Appointment::where(function ($re) use ($doctor_id) {
                        $re->orWhere('appointment_with', $doctor_id);
                        $re->orWhere('booked_by', $doctor_id);
                    })->get();
                    $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$doctor->id]);
                    $pending_bill = DB::select("SELECT COUNT(*) AS total FROM invoices WHERE invoices.payment_status = 'Unpaid' AND created_by = ?", [$doctor->id]);
                    $data = [
                        'total_appointment' => $tot_appointment->count(),
                        'revenue' => $revenue[0]->total,
                        'pending_bill' => $pending_bill[0]->total
                    ];
                    $availableDay = DoctorAvailableDay::where('doctor_id', $doctor->id)->first();
                    $availableTime = DoctorAvailableTime::where('doctor_id', $doctor->id)->where('is_deleted', 0)->get();
                    return view('doctor.doctor-profile', compact('user', 'role', 'doctor', 'doctor_info', 'data', 'appointments', 'availableTime', 'prescriptions', 'invoices', 'availableDay'));
                } else {
                    return redirect('/')->with('error', 'Doctors details not found');
                }
            } else {
                return redirect('/')->with('error', 'Doctors details not found');
            }
        } else {
            return view('error.403');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(User $doctor)
    {
        $user = Sentinel::getUser();
        $doctor_id = $doctor->id;
        $doctor = $user::whereHas('roles',function($rq){
            $rq->where('slug','doctor');
        })->where('id', $doctor_id)->where('is_deleted', 0)->first();
        if($doctor){
            if ($user->hasAccess('doctor.update')) {
                $role = $user->roles[0]->slug;
                $doctor_info = Doctor::where('user_id', '=', $doctor->id)->first();
                if ($doctor_info) {
                    $availableDay = DoctorAvailableDay::where('doctor_id', $doctor->id)->first();
                    $availableTime = DoctorAvailableTime::where('doctor_id', $doctor->id)->get();
                    return view('doctor.doctor-edit', compact('user', 'role', 'doctor', 'doctor_info', 'availableDay', 'availableTime'));
                } else {
                    return redirect('/')->with('error', 'Doctor details not found');
                }
            } else {
                return view('error.403');
            }
        }else{
            return redirect('/')->with('error', 'Doctors details not found');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $doctor)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.update')) {
            $validatedData = $request->validate([
                'first_name' => 'required|alpha',
                'last_name' => 'required|alpha',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'title' => 'required',
                'fees' => 'required',
                'degree' => 'required',
                'experience' => 'required',
                'mon' => 'required_without_all:tue,wen,thu,fri,sat,sun',
                'tue' => 'required_without_all:mon,wen,thu,fri,sat,sun',
                'wen' => 'required_without_all:mon,tue,thu,fri,sat,sun',
                'thu' => 'required_without_all:mon,wen,tue,fri,sat,sun',
                'fri' => 'required_without_all:wen,tue,mon,thu,sat,sun',
                'sat' => 'required_without_all:wen,tue,mon,thu,fri,sun',
                'sun' => 'required_without_all:wen,tue,mon,thu,fri,sat',
                'profile_photo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
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
                    return redirect('doctor')->with('success', 'Doctor Profile updated successfully!');
                }
            } catch (Exception $e) {
                return redirect('doctor')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.delete')) {
            try {
                $doctor = User::where('id',$request->id)->first();
                if ($doctor !=null) {
                    $doctor->is_deleted = 1;
                    $doctor->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Doctor deleted successfully.',
                        'data' => $doctor,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Doctor not found.',
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
                'message'=>'You have no permission to delete doctor',
                'data'=>[],
            ],409);
        }
    }

    public function time_edit($id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.time_edit')) {
            $role = $user->roles[0]->slug;
            $doctor = User::find($id);
            $doctor_info = Doctor::where('user_id', '=', $id)->first();
            if ($doctor_info) {
                $availableDay = DoctorAvailableDay::where('doctor_id', $id)->first();
                $availableTime = DoctorAvailableTime::where('doctor_id', $id)->get();
                return view('doctor.doctor_time_edit', compact('user', 'role', 'doctor', 'doctor_info', 'availableDay', 'availableTime'));
            } else {
                return redirect('/')->with('error', 'Doctor details not found');
            }
        } else {
            return view('error.403');
        }
    }
    public function time_update(Request $request, $id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.time_edit')) {
            $validatedData = $request->validate([
                'slot_time' => 'required',
                'TimeSlot.*.from' => 'required',
                'TimeSlot.*.to' => 'required',
            ]);
            $role = $user->roles[0]->slug;
            $slot_time = $request->slot_time;
            $doctor = Doctor::where('user_id', $id)->first();
            $doctor->slot_time = $slot_time;
            $doctor->save();
            $availableTime = DoctorAvailableTime::where('doctor_id', $id)->update(['is_deleted' => 1]);
            $availableSlot = DoctorAvailableSlot::where('doctor_id', $id)->update(['is_deleted' => 1]);
            $validatedData = $request->validate([
                'slot_time' => 'required',
            ]);
            foreach ($request->TimeSlot as $key => $item) {
                $availableTime = new DoctorAvailableTime();
                $availableTime->doctor_id = $id;
                $availableTime->from = $item['from'];
                $availableTime->to = $item['to'];
                $availableTime->save();
                $start_datetime = Carbon::parse($item['from'])->format('H:i:s');
                $end_datetime = Carbon::parse($item['to'])->format('H:i:s');
                $start_datetime_carbon = Carbon::parse($item['from']);
                $end_datetime_carbon = Carbon::parse($item['to']);
                $totalDuration = $end_datetime_carbon->diffInMinutes($start_datetime_carbon);
                $totalSlots = $totalDuration / $slot_time;
                for ($a = 0; $a <= $totalSlots; $a++) {
                    $slot_time_start_min = $a * $slot_time;
                    $slot_time_end_min = $slot_time_start_min + $slot_time;
                    $slot_time_start = Carbon::parse($start_datetime)->addMinute($slot_time_start_min)->format('H:i:s');
                    $slot_time_end = Carbon::parse($start_datetime)->addMinute($slot_time_end_min)->format('H:i:s');
                    if ($slot_time_end <= $end_datetime) {
                        // add time slot here
                        $time = $slot_time_start . '<=' . $slot_time_end . '<br>';
                        $availableSlot = new DoctorAvailableSlot();
                        $availableSlot->doctor_id = $id;
                        $availableSlot->doctor_available_time_id = $availableTime->id;
                        $availableSlot->from = $slot_time_start;
                        $availableSlot->to = $slot_time_end;
                        $availableSlot->save();
                    }
                }
            }
            if ($role == 'doctor') {
                return redirect('/')->with('success', 'Profile updated successfully!');
            } else {
                return redirect('doctor')->with('success', 'Doctor Profile updated successfully!');
            }
        } else {
            return view('error.403');
        }
    }
    public function time_update_ajax($id)
    {
        $availableTime = DoctorAvailableTime::where('doctor_id', $id)->where('is_deleted', 0)->get();
        if ($availableTime) {
            return response()->json([
                'isSuccess' => true,
                'Message' => "Doctor Available Time Get Successfully",
                'data' => $availableTime
            ]);
        }
        return response()->json([
            'isSuccess' => false,
            'Message' => "Doctor availableTime not found",
        ]);
    }
    public function doctor_view($id){
        {
            $user = Sentinel::getUser();
            if ($user->hasAccess('doctor.view')) {
                $doctor_id = $id;
                $role = $user->roles[0]->slug;
                $receptionist_doctor = ReceptionListDoctor::where('reception_id',$user->id)->pluck('doctor_id');
                $doctor = $user::where('id', $doctor_id)->whereIn('id',$receptionist_doctor)->where('is_deleted', 0)->first();
                if ($doctor) {
                    $doctor_info = Doctor::where('user_id', '=', $doctor->id)->orWhere('is_deleted', 0)->first();
                    if ($doctor_info) {
                        $appointments = Appointment::where(function ($re) use ($doctor_id) {
                            $re->orWhere('appointment_with', $doctor_id);
                            $re->orWhere('booked_by', $doctor_id);
                        })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointment');
                        $prescriptions = Prescription::with('patient')->where('created_by', $doctor->id)->orderby('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                        $invoices = Invoice::with('user')->where('invoices.created_by', '=', $doctor->id)->orderby('id', 'desc')->get();
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $doctor_id)->pluck('reception_id');
                        $invoices = Invoice::with('user')->where('doctor_id', $doctor_id)->paginate($this->limit, '*', 'invoice');

                        $tot_appointment = Appointment::where(function ($re) use ($doctor_id) {
                            $re->orWhere('appointment_with', $doctor_id);
                            $re->orWhere('booked_by', $doctor_id);
                        })->get();
                        $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$doctor->id]);
                        $pending_bill = DB::select("SELECT COUNT(*) AS total FROM invoices WHERE invoices.payment_status = 'Unpaid' AND created_by = ?", [$doctor->id]);
                        $data = [
                            'total_appointment' => $tot_appointment->count(),
                            'revenue' => $revenue[0]->total,
                            'pending_bill' => $pending_bill[0]->total
                        ];
                        $availableDay = DoctorAvailableDay::where('doctor_id', $doctor->id)->first();
                        $availableTime = DoctorAvailableTime::where('doctor_id', $doctor->id)->where('is_deleted', 0)->get();
                        return view('doctor.doctor-profile', compact('user', 'role', 'doctor', 'doctor_info', 'data', 'appointments', 'availableTime', 'prescriptions', 'invoices', 'availableDay'));
                    } else {
                        return redirect('/')->with('error', 'Doctors details not found');
                    }
                } else {
                    return redirect('/')->with('error', 'Doctors details not found');
                }
            } else {
                return view('error.403');
            }
        }
    }
}
