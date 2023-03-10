<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BankBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankBranchController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'branch_name' => 'required|string|unique:bank_branches,name,' . $id,
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['bank_id'] = $request->bank_id;
            $ins['name'] = $request->branch_name;
            $ins['ifsc_code'] = $request->code;
            $ins['address'] = $request->short_name;
            $ins['status'] = 'active';
            $data = BankBranch::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

            $branch_data = BankBranch::where('bank_id', $request->bank_id)->where('status', 'active')->get();

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data, 'branch_data' => $branch_data ?? []]);
    }

    public function getBankBranches(Request $request)
    {
        $bank_id = $request->bank_id;
        $branch_data = BankBranch::where('bank_id', $request->bank_id)->where('status', 'active')->get();

        return response()->json(['branch_data' => $branch_data ?? []]);
        
    }

}
