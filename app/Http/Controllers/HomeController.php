<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Doctor;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Controllers\ReportController;
use App\Invoice;
use App\InvoiceDetail;
use App\ReceptionListDoctor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Card;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Sentinel::getUser();
        $user_id = $user->id;
        $role = $user->roles[0]->slug;
        $today = Carbon::today()->format('Y/m/d');
        $time = date('H:i:s');
        if ($role == 'admin') {
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->orderBy('id', 'DESC')->where('is_deleted', 0)->limit(5)->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctors = $doctor_role->users()->with(['doctor'])->where('is_deleted', 0)->orderBy('id', 'DESC')->limit(5)->get();
            $receptionist_role = Sentinel::findRoleBySlug('receptionist');
            $receptionists = $receptionist_role->users()->with('roles')->orderBy('id', 'DESC')->where('is_deleted', 0)->limit(5)->get();
            $tot_patient = $patient_role->users()->with('roles')->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $tot_doctor = $doctor_role->users()->with('roles')->get();
            $tot_receptionist = $receptionist_role->users()->with('roles')->get();
            $appointments = Appointment::all();
            $revenue = InvoiceDetail::where('is_deleted',0)->sum('amount');

            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->where('is_deleted',0);
                $re->select(DB::raw('SUM(amount)'));
            }])->whereDate('created_at', Carbon::today())->pluck('id');
            // return $invoice;
            $daily_earning = InvoiceDetail::whereIn('invoice_id', $invoice)->where('is_deleted',0)->sum('amount');
            // return $daily_earning;
            $monthlyEarning = ReportController::getMonthlyEarning();
            $today_appointment = Appointment::with('timeSlot')->where('appointment_date', $today)->get();
            $tomorrow_appointment = Appointment::where('appointment_date', '=', Carbon::tomorrow())->get();

            $Upcoming_appointment = Appointment::where('appointment_date', '>', $today)->orWhere(function ($re) use ($today, $time) {
                $re->whereDate('appointment_date', $today);
                $re->whereTime('available_time', '>=', $time);
            })
                ->get();
            $data = [
                'total_doctors' => $tot_doctor->count(),
                'total_receptionists' => $tot_receptionist->count(),
                'total_patients' => $tot_patient->count(),
                'total_appointment' => $appointments->count(),
                'revenue' => $revenue,
                'today_appointment' => $today_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'patients', 'doctors', 'receptionists', 'data'));
        } elseif ($role == 'doctor') {
            $doctor_info = Doctor::where('user_id', '=', $user->id)->first();
            $appointments = Appointment::with('patient')
                ->where(function ($re) use ($user_id) {
                    $re->orWhere('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })
                ->whereDate('appointment_date', $today)
                ->orderby('id', 'desc')
                ->limit(5)
                ->get();
            $tot_appointment = Appointment::where(function ($re) use ($user_id) {
                $re->orWhere('appointment_with', $user_id);
                $re->orWhere('booked_by', $user_id);
            })->get();

            $doctor_count = ReceptionListDoctor::where('doctor_id', $user_id)->pluck('reception_id');
            $Invoice_Detail = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('created_by', $user_id)->orWhereIN('created_by', $doctor_count)->pluck('id');
            $revenue = InvoiceDetail::whereIn('invoice_id', $Invoice_Detail)->where('is_deleted',0)->sum('amount');
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('doctor_id', $user_id)
                ->whereDate('created_at', Carbon::today())->pluck('id');
            $daily_earning = InvoiceDetail::whereIn('invoice_id', $invoice)->where('is_deleted',0)->sum('amount');

            $monthlyEarning = ReportController::getMonthlyEarning();
            $today_appointment = Appointment::where(function ($re) use ($user_id) {
                $re->orWhere('booked_by', $user_id);
                $re->orWhere('appointment_with', $user_id);
            })->where(function ($re) use ($today) {
                $re->orWhere('appointment_date', $today);
            })->get();
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
                })
                ->get();
            $tomorrow_appointment = Appointment::with('patient', 'doctor')->where(function ($re) use ($user_id) {
                $re->orWhere('booked_by', $user_id);
                $re->orWhere('appointment_with', $user_id);
            })->where(function ($re) {
                $re->orWhere('appointment_date', Carbon::tomorrow()->format('Y/m/d'));
            })->get();
            $data = [
                'total_appointment' => $tot_appointment->count(),
                'today_appointment' => $today_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'revenue' => $revenue,
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'doctor_info', 'appointments', 'data'));
        } elseif ($role == 'receptionist') {
            $today = Carbon::today()->format('Y/m/d');
            $user_id = Sentinel::getUser();
            $userId = $user_id->id;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->where('is_deleted', 0)->orderBy('id', 'DESC')->limit(5)->get();
            $doctors = ReceptionListDoctor::with('doctor')->where('reception_id', $user_id->id)->orderby('id', 'DESC')->limit(5)->get();
            $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id->id)->pluck('doctor_id');
            $appointments = Appointment::with('patient', 'doctor')->where(function ($re) use ($userId, $receptionists_doctor_id) {
                $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                $re->orWhere('booked_by', $userId);
                $re->orWhereIN('booked_by', $receptionists_doctor_id);
            })->where(function ($re) use ($today) {
                $re->orWhere('appointment_date', $today);
                $re->Where('status', 0);
            })->get();
            $tot_appointment = Appointment::where(function ($re) use ($user_id, $receptionists_doctor_id) {
                $re->whereIN('appointment_with', $receptionists_doctor_id);
                $re->orWhereIN('booked_by', $receptionists_doctor_id);
                $re->orWhere('booked_by', $user_id);
            })->get();
            $tot_patient = $patient_role->users()->with('roles')->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $tot_doctor = ReceptionListDoctor::where('reception_id', $user_id->id)->get();
            $monthlyEarning = ReportController::getMonthlyEarning();
            $today_appointment = Appointment::with('patient', 'doctor')->where(function ($re) use ($userId, $receptionists_doctor_id) {
                $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                $re->orWhere('booked_by', $userId);
                $re->orWhereIN('booked_by', $receptionists_doctor_id);
            })->where(function ($re) use ($today) {
                $re->orWhere('appointment_date', $today);
            })->get();
            $appointments = Appointment::with('doctor', 'patient', 'timeSlot')
                ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $userId);
                })->where('appointment_date', Carbon::today())
                ->get();
            $tomorrow_appointment = Appointment::with('patient', 'doctor', 'timeSlot')->where(function ($re) use ($userId, $receptionists_doctor_id) {
                $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                $re->orWhere('booked_by', $userId);
                $re->orWhereIN('booked_by', $receptionists_doctor_id);
            })->where(function ($re) {
                $re->orWhere('appointment_date', Carbon::tomorrow()->format('Y/m/d'));
            })->get();
            $time = date('H:i:s');
            $Upcoming_appointment =  Appointment::with('patient', 'doctor', 'timeSlot')->where(function ($re) use ($userId, $receptionists_doctor_id) {
                $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                $re->orWhere('booked_by', $userId);
                $re->orWhereIN('booked_by', $receptionists_doctor_id);
            })
                ->whereDate('appointment_date', '>', $today)
                ->orWhere(function ($re) use ($today, $time) {
                    $re->whereDate('appointment_date', '=', $today);
                    $re->whereTime('available_time', '>=', $time);
                })
                ->get();
            $data = [
                'total_appointment' => $tot_appointment->count(),
                'total_patient' => $tot_patient->count(),
                'total_doctor' => $tot_doctor->count(),
                'today_appointment' => $today_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'patients', 'doctors', 'appointments', 'data', 'Upcoming_appointment'));
        } elseif ($role == 'patient') {
            $appointments = Appointment::with('doctor', 'timeSlot')->where('appointment_for', $user_id)->orderBy('id', 'DESC')->limit(5)->get();
            $tot_appointment = Appointment::where('appointment_for', $user_id)->get();
            $today_appointment = Appointment::where('appointment_for', $user_id)->whereDate('appointment_date', '=', $today)->get();
            $tomorrow_appointment = Appointment::where('appointment_for', $user_id)->whereDate('appointment_date', Carbon::tomorrow()->format('Y/m/d'))->get();
            $Upcoming_appointment = Appointment::with('doctor')
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
            $daily_earning = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('patient_id', $user_id)->pluck('id');
            $revenue = InvoiceDetail::whereIn('invoice_id', $daily_earning)->sum('amount');
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('patient_id', $user_id)->where('created_at', $today)->pluck('id');
            $daily_earning = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');
            $monthlyEarning = ReportController::getMonthlyEarning();
            $data = [
                'total_appointment' => $tot_appointment->count(),
                'today_appointment' => $today_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'revenue' => $revenue,
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'appointments', 'data'));
        }
    }

    public function per_page_item(Request $request)
    {
        if ($request->ajax()) {
            $page_limit = $request->page;
            $request->session()->put('page_limit', $page_limit);
            return response()->json([
                'isSuccess' => true,
                'Message' => "Successfully set default " .$page_limit. " items per page!",
            ],200);
        }
        else{
            return response()->json([
                'isSuccess'=> true,
                'Message' =>'Something went wrong! please try again',
            ],409);
        }
    }
}
