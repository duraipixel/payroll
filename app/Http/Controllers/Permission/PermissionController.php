<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role\Role;
use App\Models\Role\Permission;

class PermissionController extends Controller
{
    public function index()
    {
      
        $role=Role::where('status','active')->get();       
        return view('pages.permission.index',compact('role')); 
    }
    public function menuList(Request $request)
    {
        if ($request->ajax()) {
        $data=array();
        $role_id=$request->role_id;
        $form_type='permission';
        $account = config('services.account');
        $authentication= config('services.authentication');
        $staff_management = config('services.staff_management');
        $document_locker = config('services.document_locker');
        $block_mapping = config('services.block_mapping');
        $attendance_management = config('services.attendance_management');
        $leave_management = config('services.leave_management');
        $payroll_management = config('services.payroll_management');
        $master_menu = config('services.master_menu');
        $account_select_all=permissionCheckAll($role_id,$account);
        $auth_select_all=permissionCheckAll($role_id,$authentication);
        $sm_select_all=permissionCheckAll($role_id,$staff_management);
        $dl_select_all=permissionCheckAll($role_id,$document_locker);
        $bm_select_all=permissionCheckAll($role_id,$block_mapping);
        $am_select_all=permissionCheckAll($role_id,$attendance_management);
        $lm_select_all=permissionCheckAll($role_id,$leave_management);
        $pm_select_all=permissionCheckAll($role_id,$payroll_management);
        $master_select_all=permissionCheckAll($role_id,$master_menu);
        $data=[
            'role_id'                   => $role_id,
            'form_type'                 => $form_type,
            'account'                   => $account,
            'authentication'            => $authentication,
            'staff_management'          => $staff_management,
            'document_locker'           => $document_locker,
            'block_mapping'             => $block_mapping,
            'attendance_management'     => $attendance_management,
            'leave_management'          => $leave_management,
            'payroll_management'        => $payroll_management,
            'master_menu'               => $master_menu,
            'account_select_all'        => $account_select_all,
            'auth_select_all'           => $auth_select_all,
            'sm_select_all'             => $sm_select_all,
            'dl_select_all'             => $dl_select_all,
            'bm_select_all'             => $bm_select_all,
            'am_select_all'             => $am_select_all,
            'lm_select_all'             => $lm_select_all,
            'pm_select_all'             => $pm_select_all,
            'master_select_all'         => $master_select_all,
        ];
        return view('pages.permission.permission_show', $data); 
        }
    }

    public function store(Request $request)
    {
        $role_check  = Permission::where('role_id',$request->role_id)->get();
        if(count($role_check))
        {
            foreach ($role_check as  $value) {
                $per= Permission::withTrashed()->where('id',$value->id)->first();
                $per->forceDelete();       
            }   
            $message='Menu Permission Updated Sucessfully'; 
        }
        else
        {
            $message='Menu Permission Assigned Sucessfully'; 
        }
        $permission_menu = array('add', 'delete', 'view', 'export');
        //Account Menu Permission Insert Start 
        if( isset( $request->account_menu_name ) && !empty( $request->account_menu_name ) ) {
            $account_menu_roles = [];
            foreach ($request->account_menu_name as $account_menu_item) {
                
                $account_tmp = [];
                foreach ($permission_menu as $account_per_value) {
                    $account_tmp[$account_per_value] = $_POST[$account_menu_item.'_'.$account_per_value] ?? 0;
                }
                $account_menu_roles[$account_menu_item] = $account_tmp;
            }
        }  
        foreach ($account_menu_roles as $key => $account_insert_value) {
            $accountInsertData=[];
            $accountInsertData['role_id']=$request->role_id;
            $accountInsertData['academic_id'] = academicYearId();
            $accountInsertData['route_name']=$key;
            $accountInsertData['add_edit_menu']=$account_insert_value['add'];
            $accountInsertData['view_menu']=$account_insert_value['view'];
            $accountInsertData['delete_menu']=$account_insert_value['delete'];
            $accountInsertData['export_menu']=$account_insert_value['export'];
            Permission::create($accountInsertData);
        }
        //Account Menu Permission Insert End
        
        //Authentication Menu Permission Insert Start 
        if( isset( $request->auth_menu_name ) && !empty( $request->auth_menu_name ) ) {
            $auth_menu_roles = [];
            foreach ($request->auth_menu_name as $auth_menu_item) {
                
                $auth_tmp = [];
                foreach ($permission_menu as $auth_per_value) {
                    $auth_tmp[$auth_per_value] = $_POST[$auth_menu_item.'_'.$auth_per_value] ?? 0;
                }
                $auth_menu_roles[$auth_menu_item] = $auth_tmp;
            }
        }  
        foreach ($auth_menu_roles as $key => $auth_insert_value) {
            $authInsertData=[];
            $authInsertData['role_id']=$request->role_id;
            $authInsertData['academic_id'] = academicYearId();
            $authInsertData['route_name']=$key;
            $authInsertData['add_edit_menu']=$auth_insert_value['add'];
            $authInsertData['view_menu']=$auth_insert_value['view'];
            $authInsertData['delete_menu']=$auth_insert_value['delete'];
            $authInsertData['export_menu']=$auth_insert_value['export'];
            Permission::create($authInsertData);
        }
        //Authentication Menu Permission Insert End

        //Staff Management Menu Permission Insert Start 
        if( isset( $request->staff_menu_name ) && !empty( $request->staff_menu_name ) ) {
            $staff_menu_roles = [];
            foreach ($request->staff_menu_name as $staff_menu_item) {
                
                $staff_tmp = [];
                foreach ($permission_menu as $staff_per_value) {
                    $staff_tmp[$staff_per_value] = $_POST[$staff_menu_item.'_'.$staff_per_value] ?? 0;
                }
                $staff_menu_roles[$staff_menu_item] = $staff_tmp;
            }
        }  
        foreach ($staff_menu_roles as $key => $staff_insert_value) {
            $staffInsertData=[];
            $staffInsertData['role_id']=$request->role_id;
            $staffInsertData['academic_id'] = academicYearId();
            $staffInsertData['route_name']=$key;
            $staffInsertData['add_edit_menu']=$staff_insert_value['add'];
            $staffInsertData['view_menu']=$staff_insert_value['view'];
            $staffInsertData['delete_menu']=$staff_insert_value['delete'];
            $staffInsertData['export_menu']=$staff_insert_value['export'];
            Permission::create($staffInsertData);
        }
        //Staff Management Menu Permission Insert End

        //Document Locker Menu Permission Insert Start 
        if( isset( $request->dl_menu_name ) && !empty( $request->dl_menu_name ) ) {
            $dl_menu_roles = [];
            foreach ($request->dl_menu_name as $dl_menu_item) {
                
                $dl_tmp = [];
                foreach ($permission_menu as $dl_per_value) {
                    $dl_tmp[$dl_per_value] = $_POST[$dl_menu_item.'_'.$dl_per_value] ?? 0;
                }
                $dl_menu_roles[$dl_menu_item] = $dl_tmp;
            }
        }  
        foreach ($dl_menu_roles as $key => $dl_insert_value) {
            $dlInsertData=[];
            $dlInsertData['role_id']=$request->role_id;
            $dlInsertData['academic_id'] = academicYearId();
            $dlInsertData['route_name']=$key;
            $dlInsertData['add_edit_menu']=$dl_insert_value['add'];
            $dlInsertData['view_menu']=$dl_insert_value['view'];
            $dlInsertData['delete_menu']=$dl_insert_value['delete'];
            $dlInsertData['export_menu']=$dl_insert_value['export'];
            Permission::create($dlInsertData);
        }
        //Document Locker Menu Permission Insert End

        //Block Mapping Menu Permission Insert Start 
        if( isset( $request->bm_menu_name ) && !empty( $request->bm_menu_name ) ) {
            $bm_menu_roles = [];
            foreach ($request->bm_menu_name as $bm_menu_item) {
                
                $bm_tmp = [];
                foreach ($permission_menu as $bm_per_value) {
                    $bm_tmp[$bm_per_value] = $_POST[$bm_menu_item.'_'.$bm_per_value] ?? 0;
                }
                $bm_menu_roles[$bm_menu_item] = $bm_tmp;
            }
        }  
        foreach ($bm_menu_roles as $key => $bm_insert_value) {
            $bmInsertData=[];
            $bmInsertData['role_id']=$request->role_id;
            $bmInsertData['academic_id'] = academicYearId();
            $bmInsertData['route_name']=$key;
            $bmInsertData['add_edit_menu']=$bm_insert_value['add'];
            $bmInsertData['view_menu']=$bm_insert_value['view'];
            $bmInsertData['delete_menu']=$bm_insert_value['delete'];
            $bmInsertData['export_menu']=$bm_insert_value['export'];
            Permission::create($bmInsertData);
        }
        //Block Mapping Menu Permission Insert End

        //Attendance Management Menu Permission Insert Start 
        if( isset( $request->att_man_menu_name ) && !empty( $request->att_man_menu_name ) ) {
            $att_menu_roles = [];
            foreach ($request->att_man_menu_name as $att_menu_item) {
                
                $att_tmp = [];
                foreach ($permission_menu as $att_per_value) {
                    $att_tmp[$att_per_value] = $_POST[$att_menu_item.'_'.$att_per_value] ?? 0;
                }
                $att_menu_roles[$att_menu_item] = $att_tmp;
            }
        }  
        foreach ($att_menu_roles as $key => $att_insert_value) {
            $attInsertData=[];
            $attInsertData['role_id']=$request->role_id;
            $attInsertData['academic_id'] = academicYearId();
            $attInsertData['route_name']=$key;
            $attInsertData['add_edit_menu']=$att_insert_value['add'];
            $attInsertData['view_menu']=$att_insert_value['view'];
            $attInsertData['delete_menu']=$att_insert_value['delete'];
            $attInsertData['export_menu']=$att_insert_value['export'];
            Permission::create($attInsertData);
        }
        //Attendance Management Menu Permission Insert End
        
        //Leave Management Menu Permission Insert Start 
        if( isset( $request->lm_menu_name ) && !empty( $request->lm_menu_name ) ) {
            $lm_menu_roles = [];
            foreach ($request->lm_menu_name as $lm_menu_item) {
                
                $lm_tmp = [];
                foreach ($permission_menu as $lm_per_value) {
                    $lm_tmp[$lm_per_value] = $_POST[$lm_menu_item.'_'.$lm_per_value] ?? 0;
                }
                $lm_menu_roles[$lm_menu_item] = $lm_tmp;
            }
        }  
        foreach ($lm_menu_roles as $key => $lm_insert_value) {
            $lmInsertData=[];
            $lmInsertData['role_id']=$request->role_id;
            $lmInsertData['academic_id'] = academicYearId();
            $lmInsertData['route_name']=$key;
            $lmInsertData['add_edit_menu']=$lm_insert_value['add'];
            $lmInsertData['view_menu']=$lm_insert_value['view'];
            $lmInsertData['delete_menu']=$lm_insert_value['delete'];
            $lmInsertData['export_menu']=$lm_insert_value['export'];
            Permission::create($lmInsertData);
        }
        //Leave Management Menu Permission Insert End  

         //Payroll Management Menu Permission Insert Start 
         if( isset( $request->prm_menu_name ) && !empty( $request->prm_menu_name ) ) {
            $prm_menu_roles = [];
            foreach ($request->prm_menu_name as $prm_menu_item) {
                
                $prm_tmp = [];
                foreach ($permission_menu as $prm_per_value) {
                    $prm_tmp[$prm_per_value] = $_POST[$prm_menu_item.'_'.$prm_per_value] ?? 0;
                }
                $prm_menu_roles[$prm_menu_item] = $prm_tmp;
            }
        }  
        foreach ($prm_menu_roles as $key => $prm_insert_value) {
            $prmInsertData=[];
            $prmInsertData['role_id']=$request->role_id;
            $prmInsertData['academic_id'] = academicYearId();
            $prmInsertData['route_name']=$key;
            $prmInsertData['add_edit_menu']=$prm_insert_value['add'];
            $prmInsertData['view_menu']=$prm_insert_value['view'];
            $prmInsertData['delete_menu']=$prm_insert_value['delete'];
            $prmInsertData['export_menu']=$prm_insert_value['export'];
            Permission::create($prmInsertData);
        }
        //Payroll Management Menu Permission Insert End  

        //Master Menu Permission Insert Start 
         if( isset( $request->menu_name ) && !empty( $request->menu_name ) ) {
            $master_menu_roles = [];
            foreach ($request->menu_name as $master_menu_item) {
                
                $master_tmp = [];
                foreach ($permission_menu as $master_per_value) {
                    $master_tmp[$master_per_value] = $_POST[$master_menu_item.'_'.$master_per_value] ?? 0;
                }
                $master_menu_roles[$master_menu_item] = $master_tmp;
            }
        }  
        foreach ($master_menu_roles as $key => $master_insert_value) {
            $masterInsertData=[];
            $masterInsertData['role_id']=$request->role_id;
            $masterInsertData['academic_id'] = academicYearId();
            $masterInsertData['route_name']=$key;
            $masterInsertData['add_edit_menu']=$master_insert_value['add'];
            $masterInsertData['view_menu']=$master_insert_value['view'];
            $masterInsertData['delete_menu']=$master_insert_value['delete'];
            $masterInsertData['export_menu']=$master_insert_value['export'];
            Permission::create($masterInsertData);
        }
        //Master Menu Permission Insert End 
        session()->flash('success', $message);
        return redirect()->back();
    } 
    public function checkPermission(Request $request)
    {
       
        $checkPermsisionData=Permission::where('role_id',$request->role_id)->get();
       return  json_encode($checkPermsisionData);
    }
}
