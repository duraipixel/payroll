<?php

namespace App\Http\Controllers\DocumentLocker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use App\Models\Master\Institution;
use App\Models\Master\Division;
use App\Models\Master\Designation;
use App\Models\Master\StaffCategory;
use App\Models\Master\Caste;

class DocumentLockerController extends Controller
{
    public function index(Request $request)
    {
       
        /*if ($request->ajax()) 
        {
            $data = User::where('is_super_admin', '=', null);
            $datatables =  Datatables::of($data)
                            ->addIndexColumn();
            return $datatables->make(true);
        }*/

        $institution=Institution::where('status','active')->get();
        $caste=Caste::where('status','active')->get();
        $designation=Designation::where('status','active')->get();
        $staffCategory=StaffCategory::where('status','active')->get();

        //dd($institution);
        
        return view('pages.document_locker.index',compact('institution','caste','designation','staffCategory')); 
    }
    public function autocompleteSearch(Request $request)
    {
          $search = $request->get('query');
          /*$filterResult = User::where('name', 'LIKE', '%'. $search. '%')->orwhere('emp_code', 'LIKE', '%'. $search. '%')->get();*/
          $filterResult = User::select("name", 'emp_code')->where('status', 'active')->where('is_super_admin', '=', null)
          ->where(function($query) use ($search){
              $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('emp_code', 'LIKE', '%'.$search.'%');
                  
          })->get();
          return response()->json($filterResult);
    } 
}
