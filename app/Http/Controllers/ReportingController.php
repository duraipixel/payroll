<?php

namespace App\Http\Controllers;

use App\Models\ReportingManager;
use App\Models\User;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Reporting Manager',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Reporting Manager'
                ),
            )
        );
        
        $reporting_data = ReportingManager::where('is_top_level', 'yes')->first();

        return view('pages.reporting.index',compact('breadcrums', 'reporting_data'));
    }

    public function openTopLevelManagerModal(Request $request)
    {
        $title = 'Assign Top Level Manager';
        $managers = User::select('users.*')->join('staff_professional_datas', 'staff_professional_datas.staff_id', '=', 'users.id')
                    ->join('designations', 'designations.id', '=', 'staff_professional_datas.designation_id')
                    ->where('designations.can_assign_report_manager', 'yes')
                    ->where('users.status', 'active')
                    ->where(function($query) {
                        return $query->where('is_top_level', '!=', 'yes');
                    })
                    ->get();
        return view('pages.reporting.toplevel_form', compact('title', 'managers'));
    }

    public function assignTopLevelManager(Request $request)
    {

        $manager_id = $request->manager_id;

        if( $manager_id ) {
            /** 
             * get top level manager
             */
            $id = '';
            $toplevel_manager = User::where('status', 'active')->where('is_top_level', 'yes')->first();
            $has_assigned_toplevel = ReportingManager::where('is_top_level', 'yes')->first();
            
            if( $has_assigned_toplevel ) {

                $id = $has_assigned_toplevel->id;
                // $has_assigned_toplevel->is_top_level = 'no';
                // $has_assigned_toplevel->update();
                ReportingManager::where('manager_id', $manager_id)->delete();
                ReportingManager::where('reportee_id', $has_assigned_toplevel->reportee_id)->update(['reportee_id' => $manager_id]);
                $ins = [];
                $ins['academic_id'] = academicYearId();
                $ins['reportee_id'] = $manager_id;
                $ins['manager_id'] = $has_assigned_toplevel->reportee_id;
                $ins['assigned_date'] = date('Y-m-d');
                $ins['status'] = 'active';
                
                ReportingManager::create($ins);   

            }

            ReportingManager::where('is_top_level','yes')->update(['is_top_level' => 'no']);

            User::where('status','active')->update(['is_top_level' => 'no']);

            $user_info = User::find($manager_id);
            $user_info->is_top_level = 'yes';
            $user_info->save();
            $ins = [];
            $ins['academic_id'] = academicYearId();
            $ins['reportee_id'] = $manager_id;
            $ins['manager_id'] = $manager_id;
            $ins['assigned_date'] = date('Y-m-d');
            $ins['status'] = 'active';
            $ins['is_top_level'] = 'yes';
            ReportingManager::updateOrCreate(['id' => $id], $ins);            

        }

        $response = array('error' => 0, 'message' => 'Assigned successfully');
        return $response;

    }

    public function openManagerModal(Request $request)
    {
        $title = 'Assign Top Level Manager';
        $managers = User::select('users.*')->join('staff_professional_datas', 'staff_professional_datas.staff_id', '=', 'users.id')
                    ->join('designations', 'designations.id', '=', 'staff_professional_datas.designation_id')
                    ->where('designations.can_assign_report_manager', 'yes')
                    ->where('users.status', 'active')
                    ->where(function($query) {
                        return $query->where('is_top_level', '!=', 'yes');
                    })
                    // ->whereNotExists(function($query) {
                    //     $query->select('*')->from('reporting_managers')->whereRaw('reporting_managers.manager_id = user.id');
                    // })
                    ->doesntHave('reporting_managers')
                    ->get();
        // dd( $managers );
        $reportee = ReportingManager::where('status', 'active')->get();
        
        return view('pages.reporting.assign_form', compact('title', 'managers', 'reportee'));
    }

    public function assignManager(Request $request)
    {
        
        $reportee_id = $request->reportee_id;
        $manager_id = $request->manager_id;
        
        $ins['academic_id'] = academicYearId();
        $ins['reportee_id'] = $reportee_id;
        $ins['manager_id'] = $manager_id;
        $ins['assigned_date'] = date('Y-m-d');
        $ins['status'] = 'active';
        $ins['is_top_level'] = 'no';
        ReportingManager::updateOrCreate(['reportee_id' => $reportee_id, 'manager_id' => $manager_id], $ins);

        /** 
         * change reporting id in user data
         **/
        $user_info = User::find($manager_id);
        $user_info->reporting_manager_id = $reportee_id;
        $user_info->update();

        $response = array('error' => 0, 'message' => 'Assigned successfully');
        return $response;

    }

    public function openChangeManagerModal(Request $request)
    {
        $title = 'Assign Top Level Manager';
        $managers = User::select('users.*')->join('staff_professional_datas', 'staff_professional_datas.staff_id', '=', 'users.id')
                    ->join('designations', 'designations.id', '=', 'staff_professional_datas.designation_id')
                    ->where('designations.can_assign_report_manager', 'yes')
                    ->where('users.status', 'active')
                    ->where(function($query) {
                        return $query->where('is_top_level', '!=', 'yes');
                    })
                    ->doesntHave('reporting_managers')
                    ->get();
        // dd( $managers );
        $reportee = ReportingManager::where('status', 'active')->get();
        
        return view('pages.reporting.change_form', compact('title', 'managers', 'reportee'));
    }


}
