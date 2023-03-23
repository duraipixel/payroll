<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\BulkImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ToModel;    


class BulkUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('pages.bulk_upload.index'); 
    }
    public function store(Request $request)
    {
        Excel::import(new BulkImport, $request->file);
       
    } 
}
