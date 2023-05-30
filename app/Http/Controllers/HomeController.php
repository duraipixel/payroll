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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_count = User::whereNull('is_super_admin')->InstituteBased()->Academic()->count();
        $from_date = date('Y-m-1');
        $to_date = date('Y-m-t');
        $month = date('m');
        $end = date('t');

        $dob = StaffPersonalInfo::whereRaw("DATE_FORMAT(dob, '%m-%d') >= '".$month."-01' and DATE_FORMAT(dob, '%m-%d') <= '".$month."-".$end."'")
                ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
                ->when(session()->get('staff_institute_id'), function($q) {
                    $q->where('users.institute_id', session()->get('staff_institute_id'));
                })->Academic()
                ->orderByRaw("DATE_FORMAT(dob, '%m-%d')  > '".date('m')."-".date('d')."' desc")
                ->get();

        $anniversary = StaffPersonalInfo::whereRaw("DATE_FORMAT(marriage_date, '%m-%d') >= '".$month."-01' and DATE_FORMAT(marriage_date, '%m-%d') <= '".$month."-".$end."'")
                        ->join('users', 'users.id', '=', 'staff_personal_info.staff_id')
                        ->when(session()->get('staff_institute_id'), function($q) {
                            $q->where('users.institute_id', session()->get('staff_institute_id'));
                        })->Academic()
                        ->orderByRaw("DATE_FORMAT(marriage_date, '%m-%d')  > '".date('m')."-".date('d')."' desc")
                        ->get();

        $result_month_for = date('1 M, Y').' - '.date('t M, Y');
        $last_user_added = User::orderBy('created_at', 'desc')->InstituteBased()->Academic()->first();

        $leave_approval = StaffLeave::where('staff_leaves.status', 'pending')
                            ->join('users', 'users.id', '=', 'staff_leaves.staff_id')
                            ->when(session()->get('staff_institute_id'), function($q) {
                                $q->where('users.institute_id', session()->get('staff_institute_id'));
                            })->Academic()
                            ->get();

        $announcement = Announcement::whereRaw("DATE(created_at) BETWEEN '".$from_date."' and '".$to_date."'")
                            ->Academic()
                            ->InstituteBased()
                            ->get();

        $document_approval = StaffDocument::where('staff_documents.verification_status', 'pending')
                            ->join('users', 'users.id', '=', 'staff_documents.staff_id')
                            ->when( session()->get('staff_institute_id'), function($q) {
                                $q->where('users.institute_id', session()->get('staff_institute_id'));
                            })
                            ->Academic()
                            ->get();
        
        $nature_of_works = NatureOfEmployment::with('appointments')->where('status', 'active')->get();

        $designations = Designation::with('staffEnrollments')->where('status', 'active')->get();
        
        $params = array(
            'user_count' => $user_count,
            'last_user_added' => $last_user_added,
            'dob' => $dob,
            'result_month_for' => $result_month_for,
            'anniversary' => $anniversary,
            'leave_approval' => $leave_approval,
            'announcement' => $announcement,
            'document_approval' => $document_approval,
            'nature_of_works' => $nature_of_works,
            'designations' => $designations
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
}
