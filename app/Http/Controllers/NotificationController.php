<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use DataTables;
use Auth;
class NotificationController extends Controller
{
    public function list(Request $request)
    {
        $breadcrums = array(
            'title' => 'Notification',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Notification'
                ),
            )
        );
        $data=Notification::where('receiver_id',Auth::id())->get();
        if($request->ajax())
        {
            $datatables =  Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('sender',function ($row) {
                    return $row->staff->name;
            })->editColumn('read_status',function ($row) {
                    return ($row->is_read==1)?'Read':'un Read';
            });
           return  $datatables->make(true);
        }
       return view('pages.notification.index',compact('breadcrums'));
    }
     public function redirect(Request $request,$id)
    {
        
        $data=Notification::find($id);
        $data->is_read=1;
        if($data->update())
        {
           return redirect()->route('leaves.list');
        }
      
    }
}
