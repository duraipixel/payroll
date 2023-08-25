<?php

namespace App\Http\Controllers;

use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\User;
use Illuminate\Http\Request;

class CareerTransitionController extends Controller
{
    public function index(Request $request)
    {

        $page_type = $request->type;
        $title = ucwords(str_replace('_', ' ', $page_type));
        $breadcrums = array(
            'title' => ucwords(str_replace('_', ' ', $page_type)),
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => ucwords(str_replace('_', ' ', $page_type))
                ),
            )
        );

        return view('pages.career.index', compact('breadcrums', 'title', 'page_type'));
    }

    public function addEdit(Request $request) {

        $id = $request->id;
        $page_type = $request->page_type;
        $info = [];
        $title = 'Add '. ucfirst($page_type). ' Staff';
        $users = User::where('status', 'active')
                        ->where('verification_status', 'approved')
                        ->whereNull('is_super_admin')->get();
    
        if(isset($id) && !empty($id))
        {
            $info = StaffRetiredResignedDetail::find($id);
            $title = 'Update '. ucfirst($page_type). ' Staff';
        }
        $content = view('pages.career.add_edit_form',compact('info','title'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function save(Request $request) {

    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = StaffRetiredResignedDetail::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "Status Changed successfully!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = StaffRetiredResignedDetail::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new BankExport,'bank.xlsx');
    }
}
