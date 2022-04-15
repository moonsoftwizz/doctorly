<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\DoctorAvailableDay;
use App\DoctorAvailableSlot;
use App\DoctorAvailableTime;
use App\Notification;
use App\ReceptionListDoctor;
use App\User;
use Illuminate\Support\Facades\Mail;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class AppointmentController extends Controller
{
    protected $appointment;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->appointment = new Appointment();
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
        if ($user->hasAccess('appointment.create')) {
            return redirect('appointment/create');
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
        if ($user->hasAccess('appointment.create')) {
            $userId = $user->id;
            $role = $user->roles[0]->slug;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctors = $doctor_role->users()->with('roles')->get();
            if ($role == 'doctor') {
                $appointments = Appointment::with('patient', 'timeSlot')->where('appointment_with', $userId)->where('appointment_date', Carbon::today())->get();
            } elseif ($role == 'patient') {
                $appointments = Appointment::with('doctor', 'timeSlot')->where('appointment_for', $userId)->where('appointment_date', Carbon::today())->get();
            } else {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
                $appointments = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                        $re->whereIN('appointment_with', $receptionists_doctor_id);
                        $re->orWhereIN('booked_by', $receptionists_doctor_id);
                        $re->orWhere('booked_by', $userId);
                    })->where('appointment_date', Carbon::today())
                    ->get();
            }
            return view('appointment.appointment', compact('user', 'role', 'patients', 'doctors', 'appointments'));
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
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
    }
    /**
     * List of appointments based on specified date
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON response
     */
    public function appointment_list(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $userId = $user->id;
        if ($role == 'doctor') {
            $res = Appointment::with('patient', 'timeSlot')->where('appointment_with', $userId)->where('appointment_date', $request->date)->get();
        } elseif ($role == 'patient') {
            $res = Appointment::with('doctor', 'timeSlot')->where('appointment_for', $userId)->where('appointment_date', $request->date)->get();
        } else {
            $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
            $res = Appointment::with('patient', 'timeSlot', 'doctor')->where('appointment_date', $request->date)
                ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $userId);
                })
                ->get();
        }
        if (empty($res)) {
            $response = [
                'status' => 'error',
                'message' => 'No Appointments Found On '
            ];
        } else {
            $response = [
                'role' => $role,
                'appointments' => $res
            ];
        }
        return response()->json($response);
    }
    public function AppointmentList(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $user = Sentinel::getUser();
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id) {
                    $re->where('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->get();

                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id) {
                    $re->where('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->get();

                $Upcoming_appointment = Appointment::where(function ($re) use ($user_id) {
                    $re->orWhere('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->orWhere('appointment_with', $user_id);
                            $r->orWhere('booked_by', $user_id);
                        });
                    })->where('status', 0)
                    ->orderBy('id', 'DESC')->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($user_id) {
                        $re->where('appointment_with', $user_id);
                        $re->orWhere('booked_by', $user_id);
                    })->where('status', 2)
                    ->orderBy('id', 'DESC')->get();
            } elseif ($role == 'patient') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 0, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->get();
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 1, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->get();
                $Upcoming_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where('appointment_for', $user_id)
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->where('appointment_for', $user_id);
                        });
                    })->where('status', 0)
                    ->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 2, 'appointment_for' => $user_id])->get();
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->get();
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->get();
                $time = date('H:i:s');
                $Upcoming_appointment = Appointment::with('patient', 'doctor', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->Where('status', 0);
                    })->orderBy('id', 'DESC')->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })
                    ->where('status', 2)->orderBy('id', 'DESC')->get();
            } else {
                $pending_appointment = Appointment::with('doctor', 'patient')->where(['status' => 0])->orderBy('id', 'DESC')->get();
                $Complete_appointment = Appointment::with('doctor', 'patient')->where(['status' => 1])->orderBy('id', 'DESC')->get();
                $Upcoming_appointment = Appointment::with('doctor', 'patient')->where('appointment_date', '>', $today)->where('status', 0)->orderBy('id', 'DESC')->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient')->where('status', 2)->orderBy('id', 'DESC')->get();
            }
            return view('appointment.appointment-list', compact('user', 'role', 'pending_appointment', 'Upcoming_appointment', 'Complete_appointment', 'Cancel_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function appointment_status(Request $request, $id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.status')) {
            $role = $user->roles[0]->slug;
            $userId = $user->id;
            $appointment = Appointment::find($id);
            if ($appointment) {
                $appointment->status = $request->status;
                $appointment->save();
                // complete appointment notification send
                if ($request->status == 1) {
                    if ($role == 'doctor') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 2;
                            $notification->title = 'Appointment completed successfully';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                    } elseif ($role == 'receptionist') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('doctor_id');
                        $doctor_id = $appointment->appointment_with;
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 2;
                            $notification->title = 'Appointment completed successfully';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                    }
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Appointment Confirm successfully",
                        'data' => $appointment
                    ],200);
                }
                // cancel appointment mail send and
                // cancel appointment mail send
                elseif ($request->status == 2) {
                    $verify_mail = $user->email;
                    $app_name =  config('app.name');
                    $MailAppointment = Appointment::with('doctor','patient','BookedBy','timeSlot')->where('id',$appointment->id)->first();
                    $CancelBy = User::find($userId);
                    if ($role == 'doctor') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $reception_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $patient_email = User::where('id',$patient_id)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($reception_email);
                        $mailSend->push($patient_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' ' . 'Appointment cancel');
                        });

                    } elseif ($role == 'patient') {
                        $doctor_id = $appointment->appointment_with;
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($doctor_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $receptionists_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' ' . 'Appointment cancel');
                        });
                    } elseif ($role == 'admin') {
                        $patient_id = $appointment->appointment_for;
                        $doctor_id = $appointment->appointment_with;
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $fromId = collect();
                        $fromId->push($doctor_id);
                        $fromId->push($patient_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $receptionists_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $receptionists_patient_email = User::where('id', $patient_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend->push($receptionists_patient_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' ' . 'Appointment cancel');
                        });

                    } elseif ($role == 'receptionist') {
                        $doctor_id = $appointment->appointment_with;
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $receptionists_patient_email = User::where('id', $patient_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_patient_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' ' . 'Appointment cancel');
                        });
                    }
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Appointment cancel successfully",
                        'data' => $appointment
                    ],200);
                }
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Appointment not found",
                    'data' => '',
                ],409);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => "You have no permission to change appointment ",
                'data' => '',
            ],409);
        }
    }

    public function doctor_by_day_time(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.status')) {
            if ($request->ajax()) {
                $doctor_id = $request->doctor_id;
                $doctor_available_day = DoctorAvailableDay::where('doctor_id', $doctor_id)->first();
                $doctor_available_time = DoctorAvailableTime::where('doctor_id', $doctor_id)->where('is_deleted', 0)->get();
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Doctor availableTime successfully",
                    'data' => [$doctor_available_day, $doctor_available_time]
                ]);
            }
        } else {
            return view('error.403');
        }
    }

    public function appointment_create()
    {
        $user = Sentinel::getUser();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.create')) {
            $userId = $user->id;
            $doctor_available_day = '';
            $doctor_available_time = '';
            $role = $user->roles[0]->slug;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctors = $doctor_role->users()->with('roles')->where('is_deleted', 0)->get();
            if ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
                $doctors = $doctor_role->users()->with('roles')->whereIN('id', $receptionists_doctor_id)->where('is_deleted', 0)->get();
            }
            $dayArray = collect();
            if ($role == 'doctor') {
                $doctor_available_day = DoctorAvailableDay::where('doctor_id', $userId)->first()->toArray();
                if ($doctor_available_day['sun'] == 0) {
                    $dayArray->push(0);
                }
                if ($doctor_available_day['mon'] == 0) {
                    $dayArray->push(1);
                }
                if ($doctor_available_day['tue'] == 0) {
                    $dayArray->push(2);
                }
                if ($doctor_available_day['wen'] == 0) {
                    $dayArray->push(3);
                }
                if ($doctor_available_day['thu'] == 0) {
                    $dayArray->push(4);
                }
                if ($doctor_available_day['fri'] == 0) {
                    $dayArray->push(5);
                }
                if ($doctor_available_day['sat'] == 0) {
                    $dayArray->push(6);
                }
                $doctor_available_time = DoctorAvailableTime::where('doctor_id', $userId)->where('is_deleted', 0)->get();
            }
            return view('appointment.appointment_create', compact('user', 'role', 'patients', 'doctors', 'doctor_available_day', 'doctor_available_time', 'dayArray'));
        } else {
            return view('error.403');
        }
    }

    public function appointment_store(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $userId = $user->id;
        if ($user->hasAccess('appointment.create')) {
            $request->validate([
                'appointment_for' => 'required',
                'appointment_with' => 'required',
                'appointment_date' => 'required',
                'available_time' => 'required',
                'available_slot' => 'required',
            ]);
            try {
                if ($request->available_time == null && $request->available_slot == null) {
                    return redirect()->back()->with('error', 'The appointment time and appointment slot  field is required.');
                } else {
                    $verify_mail = $user->email;
                    $app_name =  config('app.name');
                    $date = $request->appointment_date;
                    $newDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
                    $appointment = new Appointment();
                    $appointment->appointment_for = $request->appointment_for;
                    $appointment->appointment_with = $request->appointment_with;
                    $appointment->appointment_date = $newDate;
                    $appointment->available_time = $request->available_time;
                    $appointment->available_slot  = $request->available_slot;
                    $appointment->booked_by    = $user->id;
                    $appointment->save();
                    // appointment create notification send and mail send
                    // Find Mail
                    $MailAppointment = Appointment::with('doctor','patient','BookedBy','timeSlot')->where('id',$appointment->id)->first();
                    if ($role == 'patient') {
                        $doctor_id = $appointment->appointment_with;
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($doctor_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 1;
                            $notification->title = 'Appointment Added';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $receptionists_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_create', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' ' . 'New appointment generated');
                        });
                    } elseif ($role == 'receptionist') {
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $patient_id = $appointment->appointment_for;
                        $doctor_id = $appointment->appointment_with;
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 1;
                            $notification->title = 'Appointment Added';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $receptionists_patient_email = User::where('id', $patient_id)->pluck('email');
                        // return $receptionists_patient_email;
                        $mailSend = collect();
                        $mailSend->push($receptionists_patient_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_create', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' ' . 'New appointment generated');
                        });

                    } elseif ($role == 'doctor') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 1;
                            $notification->title = 'Appointment Added';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $reception_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $patient_email = User::where('id',$patient_id)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $this->mailSend = collect();
                        $this->mailSend->push($reception_email);
                        $this->mailSend->push($patient_email);
                        $this->mailSend->push($admin_email);
                        $this->mailSend = $this->mailSend->flatten();
                        $mailArray = $this->mailSend->toarray();
                        Mail::send('emails.appointment_create', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' ' . 'New appointment generated');
                        });
                    }
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
            return redirect('appointment/create')->with('success', 'Appointment created successfully');
        } else {
            return view('error.403');
        }
    }

    public function time_by_slot(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.create')) {
            if ($request->ajax()) {
                $timeId = $request->timeId;
                $doctorId  = $request->doctorId;
                $date  = $request->dates;
                $dates = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');

                $appointment_slot = DoctorAvailableSlot::with(['appointment' => function ($re) use ($dates) {
                    $re->where('appointment_date', $dates);
                }])
                    ->where('doctor_available_time_id', $timeId)->get();
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Appointment slot find successfully",
                    'data' => [$appointment_slot, $dates, $doctorId]
                ]);
            }
        } else {
            return view('error.403');
        }
    }

    public function cal_appointment_show(Request $request)
    {
        if ($request->ajax()) {
            $user = Sentinel::getUser();
            $userId = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'doctor') {
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date',   '<=', $request->end)
                    ->groupBy(DB::raw('appointment_date'))->where('appointment_with', $user->id)->get();
            } elseif ($role == 'patient') {
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date',   '<=', $request->end)
                    ->groupBy(DB::raw('appointment_date'))->where('appointment_for', $user->id)->get();
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date',   '<=', $request->end)
                    ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                        $re->whereIN('appointment_with', $receptionists_doctor_id);
                        $re->orWhereIN('booked_by', $receptionists_doctor_id);
                        $re->orWhere('booked_by', $userId);
                    })
                    ->groupBy(DB::raw('appointment_date'))->get();
            }
            if (empty($appointment)) {
                $response = [
                    'status' => 'error',
                    'message' => 'No Appointments Found On '
                ];
            } else {
                $response = [
                    'role' => $role,
                    'appointments' => $appointment
                ];
            }
            return response()->json($response);
        }
    }

    public function pending_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id) {
                    $re->where('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 0, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $pending_appointment = Appointment::with('doctor', 'patient')->where(['status' => 0])->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.pending-appointment', compact('user', 'role', 'pending_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function upcoming_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $Upcoming_appointment = Appointment::where(function ($re) use ($user_id) {
                    $re->orWhere('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->orWhere('appointment_with', $user_id);
                            $r->orWhere('booked_by', $user_id);
                        });
                    })->where('status', 0)
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Upcoming_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where('appointment_for', $user_id)
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->where('appointment_for', $user_id);
                        });
                    })->where('status', 0)
                    ->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Upcoming_appointment = Appointment::with('patient', 'doctor', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->Where('status', 0);
                    })->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Upcoming_appointment = Appointment::where('appointment_date', '>', $today)->orWhere(function ($re) use ($today, $time) {
                    $re->whereDate('appointment_date', $today);
                    $re->whereTime('available_time', '>=', $time);
                })
                    ->paginate($this->limit);
            }
            return view('appointment.upcoming-appointment', compact('user', 'role', 'Upcoming_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function complete_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {

            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id) {
                    $re->where('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 1, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Complete_appointment = Appointment::with('doctor', 'patient')->where(['status' => 1])->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.complete-appointment', compact('user', 'role', 'Complete_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function cancel_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            $admin_role = Sentinel::findRoleBySlug('admin');
            $verify_mail = $user->email;
            $app_name =  config('app.name');
            if ($role == 'doctor') {
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($user_id) {
                        $re->where('appointment_with', $user_id);
                        $re->orWhere('booked_by', $user_id);
                    })->where('status', 2)
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 2, 'appointment_for' => $user_id])->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 2)->orderBy('id', 'DESC')->paginate($this->limit);

            } else {
                $Cancel_appointment = Appointment::with('doctor', 'patient')->where('status', 2)->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.cancel-appointment', compact('user', 'role', 'Cancel_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function today_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($user_id) {
                        $re->where('appointment_with', $user_id);
                        $re->orWhere('booked_by', $user_id);
                    })
                    ->whereDate('appointment_date', Carbon::today())
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['appointment_for' => $user_id])->whereDate('appointment_date', Carbon::today())->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->whereDate('appointment_date', Carbon::today())->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Today_appointment = Appointment::with('doctor', 'patient')->whereDate('appointment_date', Carbon::today())->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.today-appointment', compact('user', 'role', 'Today_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function patient_appointment()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('patient-appointment.list')) {
            $role = $user->roles[0]->slug;
            $user_id = Sentinel::getUser()->id;
            $appointment = Appointment::with('doctor', 'timeSlot')->where(['appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            return view('patient.patient-appointment', compact('appointment', 'user', 'role'));
        } else {
            return view('error.403');
        }
    }
}
