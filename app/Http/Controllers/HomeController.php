<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Announcement\Announcement;
use App\Models\Leave\StaffLeave;
use App\Models\Master\Designation;
use App\Models\Master\NatureOfEmployment;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\User;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\Staff\StaffTransfer;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $dashboardRepository;
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->middleware('auth');
        $this->dashboardRepository = $dashboardRepository;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        // ->Academic()
        $from_date = date('Y-m-1');
        $to_date = date('Y-m-t');
        $month = date('m');
        $end = date('t');
        $current_date=date('Y-m-d');
        $resigned=StaffRetiredResignedDetail::where('last_working_date','<=',$current_date)->pluck('staff_id');
        $transfer=StaffTransfer::where('from_institution_id',session()->get('staff_institute_id'))->whereDate('effective_from','<=',$current_date)->where('status','approved')->pluck('staff_id');
        $user_count=User::where('status','active')->whereNotIn('id',$resigned)->whereNotIn('id',$transfer)->InstituteBased()->Academic()->count();
        $pending_user_count = User::where('verification_status','pending')->whereNotIn('id',$resigned)->whereNotIn('id',$transfer)->InstituteBased()->Academic()->count();
        $approved_user_count = User::where('verification_status','approved')->whereNotIn('id',$resigned)->whereNotIn('id',$transfer)->InstituteBased()->Academic()->count();
        $dob = StaffPersonalInfo::whereNotIn('staff_id',$resigned)->whereNotIn('staff_id',$transfer)->whereRaw("CONVERT(VARCHAR(5), dob, 110) >= '" . $month . "-01' and CONVERT(VARCHAR(5), dob, 110) <= '" . $month . "-" . $end . "'")
            ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })
            // ->Academic()
            // ->orderByRaw("CONVERT(VARCHAR(5), dob, 110)  > '".date('m')."-".date('d')."' desc")
            //     ->orderByRaw("CASE
            //     WHEN CONVERT(VARCHAR(5), dob, 110) > '".date('m')."-".date('d')."' THEN 1
            //     ELSE 0
            // END DESC;")
            ->orderByRaw("MONTH(dob), DAY(dob)")
            ->get();

        $anniversary = StaffPersonalInfo::whereNotIn('staff_id',$resigned)->whereNotIn('staff_id',$transfer)->whereRaw("CONVERT(VARCHAR(5), marriage_date, 110) >= '" . $month . "-01' and CONVERT(VARCHAR(5), marriage_date, 110) <= '" . $month . "-" . $end . "'")
            ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })
            // ->Academic()
            //             ->orderByRaw("CASE
            //     WHEN CONVERT(VARCHAR(5), marriage_date, 110) > '".date('m')."-".date('d')."' THEN 1
            //     ELSE 0
            // END DESC;")
            ->orderByRaw("MONTH(marriage_date), DAY(marriage_date)")
            ->get();

        $result_month_for = date('1 M, Y') . ' - ' . date('t M, Y');
    $last_user_added = User::orderBy('created_at', 'desc')->InstituteBased()->Academic()->first();
    $leave_approved = StaffLeave::where('staff_leaves.status', 'approved')
            ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
    ->get();
    $leave_pending = StaffLeave::where('staff_leaves.status', 'pending')
            ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
            ->get();
        $leave_approval = StaffLeave::where('staff_leaves.status', 'pending')
            ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
            ->get();

        $full_time = Announcement::where('announcement_type','Full Time')
            ->Academic()
            ->InstituteBased()->where('status','active')
            ->count();
        $sort_time = Announcement::where('announcement_type','Short Period')->where('to_date','>=',Carbon::now()->format('Y-m-d'))
            ->Academic()
            ->InstituteBased()->where('status','active')
            ->count();
          
            $announcement=$full_time+$sort_time;

        $document_approval = StaffDocument::where('staff_documents.verification_status', 'pending')
            ->join('users', 'users.id', '=', 'staff_documents.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })
            ->Academic()
            ->get();

        $gender_calculation = StaffPersonalInfo::whereNotIn('staff_id',$resigned)->whereNotIn('staff_id',$transfer)->select(
            DB::raw("SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS total_female"),
            DB::raw("SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS total_male"),
            DB::raw("SUM(CASE WHEN gender NOT IN ('Female', 'Male') THEN 1 ELSE 0 END) AS total_other")
        )
            ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })
            ->Academic()
            ->first();



        $nature_of_works = NatureOfEmployment::with(['appointments', 'appointments.staff_det'])
            ->whereHas('appointments.staff_det', function ($query) {
                $query->where('institute_id', session()->get('staff_institute_id'));
            })
            ->where('status', 'active')
            ->get();

        $designations = Designation::with('staffEnrollments')->where('status', 'active')->get();
         $announcement_list= Announcement::
            Academic()
            ->InstituteBased()->where('status','active')
            ->get();
           


        $params = array(
            'pending_user_count'=>$pending_user_count,
            'approved_user_count'=>$approved_user_count,
            'user_count' => $user_count,
            'last_user_added' => $last_user_added,
            'dob' => $dob,
            'result_month_for' => $result_month_for,
            'anniversary' => $anniversary,
            'leave_approval' => $leave_approval,
            'leave_approved' => $leave_approved,
            'leave_pending' => $leave_pending,
            'announcement' => $announcement,
            'document_approval' => $document_approval,
            'nature_of_works' => $nature_of_works,
            'designations' => $designations,
            'gender_calculation' => $gender_calculation,
            'announcement_list'=>$announcement_list,
            'top_ten_leave_taker' => $this->dashboardRepository->getTopTenLeaveTaker(),
            'age_json_data' => $this->dashboardRepository->getInstituteAgeWiseData(),
            'total_institution_staff' => $this->dashboardRepository->getTotalStaffCountByInstitutions(),
            'month_chart' => $this->dashboardRepository->monthlyGraphUser(),
            'retired' => $this->dashboardRepository->getStaffResingedRetiredList('retired'),
            'resigned' => $this->dashboardRepository->getStaffResingedRetiredList('resigned'),
            'leave_chart' => $this->dashboardRepository->leaveChartCount(),
            'financial_chart' => $this->dashboardRepository->financialChart()
        );

        return view('pages.dashboard.home', $params);
    }

    public function setAcademicYear(Request $request)
    {
        $id = $request->id;
        Session::put('academic_id', $id);
        return true;
    }

    public function setInstitution(Request $request)
    {
        $id = $request->id;
        Session::put('staff_institute_id', $id);
        return true;
    }

    public function getDashboardView(Request $request)
    {   
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $start_date = str_replace('/', '-', $start_date);
        $end_date = str_replace('/', '-', $end_date);

        $s_date = date('Y-m-d', strtotime($start_date));
        $e_date = date('Y-m-d', strtotime($end_date));
        $from_date = $s_date;
        $to_date = $e_date;
        $month = date('m', strtotime($s_date));
        $end_month = date('m', strtotime($e_date));
        $start_day = date('d', strtotime($s_date));
        $end = date('d', strtotime($e_date));
        $resigned=StaffRetiredResignedDetail::where('last_working_date','<=',$from_date)->pluck('staff_id');
        $transfer=StaffTransfer::where('from_institution_id',session()->get('staff_institute_id'))->whereDate('effective_from','<=',$from_date)->where('status','approved')->pluck('staff_id');
        $user_count=User::where('status','active')->whereNotIn('id',$resigned)->whereNotIn('id',$transfer)->InstituteBased()->Academic()->count();
        $pending_user_count = User::where('verification_status','pending')->whereNotIn('id',$resigned)->whereNotIn('id',$transfer)->InstituteBased()->Academic()->count();
        $approved_user_count = User::where('verification_status','approved')->whereNotIn('id',$resigned)->whereNotIn('id',$transfer)->InstituteBased()->Academic()->count();
        $dob = StaffPersonalInfo::whereNotIn('staff_id',$resigned)->whereNotIn('staff_id',$transfer)->whereRaw("CONVERT(VARCHAR(5), dob, 110) >= '" . $month . "-" . $start_day . "' and CONVERT(VARCHAR(5), dob, 110) <= '" . $end_month . "-" . $end . "'")
            ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
            // ->orderByRaw("CONVERT(VARCHAR(5), dob, 110)  > '".date('m')."-".date('d')."' desc")
            ->orderByRaw("CASE
                WHEN CONVERT(VARCHAR(5), dob, 110) > '" . $month . "-" . $start_day . "' THEN 1
                ELSE 0
            END ASC;")->get();

        $anniversary = StaffPersonalInfo::whereNotIn('staff_id',$resigned)->whereNotIn('staff_id',$transfer)->whereRaw("CONVERT(VARCHAR(5), marriage_date, 110) >= '" . $month . "-" . $start_day . "' and CONVERT(VARCHAR(5), marriage_date, 110) <= '" . $end_month . "-" . $end . "'")
            ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
            ->orderByRaw("CASE
                WHEN CONVERT(VARCHAR(5), marriage_date, 110) > '" . date('m') . "-" . date('d') . "' THEN 1
                ELSE 0
            END ASC;")->get();

        // $result_month_for = date('1 M, Y').' - '.date('t M, Y');
        $result_month_for = date('d M, Y', strtotime($s_date)) . ' - ' . date('d M, Y', strtotime($e_date));
        $last_user_added = User::orderBy('created_at', 'desc')->InstituteBased()->Academic()->first();

        $leave_approval = StaffLeave::where('staff_leaves.status', 'pending')
            ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
            ->get();
           $leave_approved = StaffLeave::where('staff_leaves.status', 'approved')
            ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
    ->get();
    $leave_pending = StaffLeave::where('staff_leaves.status', 'pending')
            ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })->Academic()
            ->get();
        $announcement = Announcement::whereRaw("CAST(created_at AS DATE) BETWEEN '" . $from_date . "' and '" . $to_date . "'")
            ->Academic()
            ->InstituteBased()
            ->count();
          $announcement_list= Announcement::
          whereRaw("CAST(created_at AS DATE) BETWEEN '" . $from_date . "' and '" . $to_date . "'")
             ->Academic()
            ->InstituteBased()
            ->where('status','active')
            ->get();

        $document_approval = StaffDocument::where('staff_documents.verification_status', 'pending')
            ->join('users', 'users.id', '=', 'staff_documents.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })
            ->Academic()
            ->get();

        $gender_calculation = StaffPersonalInfo::whereNotIn('staff_id',$resigned)->whereNotIn('staff_id',$transfer)->select(
            DB::raw("SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS total_female"),
            DB::raw("SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS total_male"),
            DB::raw("SUM(CASE WHEN gender NOT IN ('Female', 'Male') THEN 1 ELSE 0 END) AS total_other")
        )
            ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
            ->when(session()->get('staff_institute_id'), function ($q) {
                $q->where('users.institute_id', session()->get('staff_institute_id'));
            })
            ->Academic()
            ->first();

        $nature_of_works = NatureOfEmployment::with('appointments')->where('status', 'active')->get();

        $designations = Designation::with('staffEnrollments')->where('status', 'active')->get();

        $params = array(
            'pending_user_count'=>$pending_user_count,
            'approved_user_count'=>$approved_user_count,
            'user_count' => $user_count,
            'last_user_added' => $last_user_added,
            'dob' => $dob,
            'result_month_for' => $result_month_for,
            'anniversary' => $anniversary,
            'leave_approval' => $leave_approval,
            'leave_approved' => $leave_approved,
            'leave_pending' => $leave_pending,
            'announcement' => $announcement,
            'document_approval' => $document_approval,
            'announcement_list'=>$announcement_list,
            'nature_of_works' => $nature_of_works,
            'designations' => $designations,
            'gender_calculation' => $gender_calculation,
            'top_ten_leave_taker' => $this->dashboardRepository->getTopTenLeaveTaker($s_date, $e_date),
            'age_json_data' => $this->dashboardRepository->getInstituteAgeWiseData($s_date, $e_date),
            'total_institution_staff' => $this->dashboardRepository->getTotalStaffCountByInstitutions($s_date, $e_date),
            'month_chart' => $this->dashboardRepository->monthlyGraphUser($s_date, $e_date),
            'retired' => $this->dashboardRepository->getStaffResingedRetiredList('retired', $s_date, $e_date),
            'resigned' => $this->dashboardRepository->getStaffResingedRetiredList('resigned', $s_date, $e_date),
            'leave_chart' => $this->dashboardRepository->leaveChartCount($s_date, $e_date),
            'financial_chart' => $this->dashboardRepository->financialChart()
        );

        return view('pages.dashboard.dynamic_view', $params);
    }
}
