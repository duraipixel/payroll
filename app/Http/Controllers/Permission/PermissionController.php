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
        $account = config('services.account');
        $authentication= config('services.authentication');
        $staff_management = config('services.staff_management');
        $document_locker = config('services.document_locker');
        $block_mapping = config('services.block_mapping');
        $attendance_management = config('services.attendance_management');
        $leave_management = config('services.leave_management');
        $payroll_management = config('services.payroll_management');
        $master_menu = config('services.master_menu');
        $role=Role::where('status','active')->get();
        $form_type='permission';
        return view('pages.permission.index',compact('account','authentication','staff_management','document_locker'
        ,'block_mapping','attendance_management','leave_management','payroll_management','master_menu','role','form_type')); 
    }
    public function store(Request $request)
    {
        $role_id=$request->role_id;
        $permission=array();
        
        foreach($request->account_menu_name as $acc_name)
        {
            $acc_add=$acc_name.'_account_add';
            $permission['route_name']=$acc_name;
            foreach($request->account_add as $acc_add_name)
            {
               // $permission['add_edit_menu']='';
                if($acc_add==$acc_add_name)
                {
                    $permission['add_edit_menu']='1';
                }
                else
                {
                    $permission['add_edit_menu']='0';
                }
            }
            $acc_view=$acc_name.'_account_view';
            foreach($request->account_view as $acc_view_name)
            {
                //$permission['view_menu']='';
                if($acc_view==$acc_view_name)
                {
                    $permission['view_menu']='1';
                }
                else
                {
                    $permission['view_menu']='0';
                }
            }
            $acc_delete=$acc_name.'_account_delete';           
            foreach($request->account_delete as $acc_delete_name)
            {
                //$permission['delete_menu']='';
                if($acc_delete==$acc_delete_name)
                {
                    $permission['delete_menu']='1';
                }
                else
                {
                    $permission['delete_menu']='0';
                }
            }
            $acc_export=$acc_name.'_account_export';
            foreach($request->account_export as $acc_export_name)
            {
                //$permission['export_menu']='';
                if($acc_export==$acc_export_name)
                {
                    $permission['export_menu']='1';
                }
                else
                {
                    $permission['export_menu']='0';
                }
            }
            $permission['role_id']=$role_id;
            //dd($permission);
           //$insert_data=Permission::create($permission);
        }
        dd( $permission);

      // foreach()
        
        
    }
}
