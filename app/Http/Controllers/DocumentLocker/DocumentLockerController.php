<?php

namespace App\Http\Controllers\DocumentLocker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class DocumentLockerController extends Controller
{
    public function index(Request $request)
    {
       
        if ($request->ajax()) 
        {
            $data = User::where('is_super_admin', '=', null);
            $datatables =  Datatables::of($data)
                            ->addIndexColumn();
            return $datatables->make(true);
        }
        
        return view('pages.document_locker.index'); 
    }
    public function autocompleteSearch(Request $request)
    {
          $query = $request->get('query');
          $filterResult = User::where('name', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    } 
}
