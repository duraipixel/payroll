<?php

namespace App\Http\Controllers;

use App\Models\ReportingManager;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

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
        $page_type = $request->type ?? '';
        $reporting_data = ReportingManager::where('is_top_level', 'yes')->first();
        $all = ReportingManager::with(['manager', 'reportee', 'havingStaffs', 'havingManagers'])
                ->get();

        return view('pages.reporting.index', compact('breadcrums', 'reporting_data', 'all', 'page_type'));
    }

    public function openTopLevelManagerModal(Request $request)
    {
        $title = 'Assign Top Level Manager';
        $managers = User::select('users.*')->join('staff_professional_datas', 'staff_professional_datas.staff_id', '=', 'users.id')
            ->join('designations', 'designations.id', '=', 'staff_professional_datas.designation_id')
            ->where('designations.can_assign_report_manager', 'yes')
            ->where('users.status', 'active')
            ->where(function ($query) {
                return $query->where('is_top_level', '!=', 'yes');
            })
            ->get();
        return view('pages.reporting.toplevel_form', compact('title', 'managers'));
    }

    public function assignTopLevelManager(Request $request)
    {

        $manager_id = $request->manager_id;

        if ($manager_id) {
            /** 
             * get top level manager
             */
            $id = '';
            $toplevel_manager = User::where('status', 'active')->where('is_top_level', 'yes')->first();
            $has_assigned_toplevel = ReportingManager::where('is_top_level', 'yes')->first();

            if ($has_assigned_toplevel) {

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

            ReportingManager::where('is_top_level', 'yes')->update(['is_top_level' => 'no']);

            User::where('status', 'active')->update(['is_top_level' => 'no']);

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
            ->where(function ($query) {
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
        $title = 'Change or Replace Managers';
        $reportee = ReportingManager::where('status', 'active')->get();
        return view('pages.reporting.change_form', compact('title', 'reportee'));
    }

    public function reportingList(Request $request)
    {
        $employees = ReportingManager::with('manager')->where('status', 'active')->get();
        $params = array(
            'employees' => $employees
        );
        if ($request->ajax()) {

            $staff_id = $request->get('staff_id');

            $data = User::with('reporting')->where('status', 'active')
                        ->whereNotNull('reporting_manager_id')
                        ->when($staff_id != '', function ($q) use ($staff_id) {
                            $q->where('reporting_manager_id', $staff_id);
                        });

            $datatables = Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return nationalityChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = commonDateFormat($row['created_at']);
                    return $created_at;
                })
                ->rawColumns(['status']);
            return $datatables->make(true);
        }
        return view('pages.reporting.staff_list.index', $params);
    }

    public function deleteManager( Request $request ) {

        $id = $request->id;
        $reporting_data = ReportingManager::with(['havingStaffs', 'havingManagers'])->find( $id );
        $error = 1;
        $message = 'Error occurred while deleting. Please contact administrator';
        if( $reporting_data ) {
            if( $reporting_data->havingStaffs->count() > 0 || $reporting_data->havingManagers->count() ) {
                $error = 1;
                $message = 'Cannot delete manager, Manager having assinged staff and managers. Please do transfer or contact administrator';
            } else {
                // do delete operation
                $reporting_data->delete();
                $error = 0;
                $message = 'Successfully deleted';
            }
        }

        return ['error' => $error, 'message' => $message ];

    }

    public function changeManager( Request $request ) {

        $from_id = $request->from_id;
        $to_id = $request->to_id;

        if( $from_id == $to_id ) {
            $error = 1;
            $message = 'Changing Manager and Takeover Manager should not same';
        } else {

            $from_manager = ReportingManager::where('manager_id', $from_id )->first();
            $to_manager = ReportingManager::where('manager_id', $to_id )->first();

            /**
             *  Case 1
             */
            if( $from_id == $to_manager->reportee_id ) {
                // assign from reportee id to to_manager reportee id
                $to_manager->reportee_id = $from_manager->reportee_id;
                $to_manager->save();
            } 

            $from_manager->reportee_id = $to_id;
            $from_manager->save();
            /**
             *  update reportee id for all assinged staffs
             */
            User::where('reporting_manager_id', $from_id)->update(['reporting_manager_id' => $to_id]);
            /**
             *  update reportee id for all assigned managers
             */
            ReportingManager::where('reportee_id', $from_id)->update(['reportee_id' => $to_id]);
            $error = 0;
            $message = 'Successfully Changed';
            
        }

        return [ 'error' => $error, 'message' => $message ];

    }
}
