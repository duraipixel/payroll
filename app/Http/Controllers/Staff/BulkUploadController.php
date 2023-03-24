<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\BulkImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ToModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;    


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
        $validator=$this->validate($request, [
            'file' => 'required|mimes:xlsx, xls',     
           
        ],
        [
            'file.required' => 'You must need to upload the excel file!',    
           
        ]);  
            $exampleImport = new BulkImport;
            $excel_import=Excel::import($exampleImport, $request->file);
            if($excel_import)
            {
                return back()->with('success','Excel Uploaded successfully!');
            }
            else
            {
                return back()->with('error','Excel Not Uploaded. Please try again later !');
            }                   
    } 
}
