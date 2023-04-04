<?php

namespace App\Http\Controllers\DocumentLocker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DocumentLockerController extends Controller
{
    public function index()
    {
        return view('pages.document_locker.index'); 
    }
    public function autocompleteSearch(Request $request)
    {
          $query = $request->get('query');
          $filterResult = User::where('name', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    } 
}
