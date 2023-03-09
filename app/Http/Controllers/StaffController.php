<?php

namespace App\Http\Controllers;

use App\Models\Master\Classes;
use App\Models\Master\Division;
use App\Models\Master\DocumentType;
use App\Models\Master\Institution;
use App\Models\Staff\StaffClass;
use App\Models\Staff\StaffDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function register(Request $request, $id = null)
    {
        $used_classes = [];
        if( $id ) {
            $staff_details = User::find($id);
            if(  isset($staff_details->staffClasses) && !empty(  $staff_details->staffClasses ) ) {
                foreach ( $staff_details->staffClasses as $items ) {
                    $used_classes[] = $items->class_id;
                }
            }
            


        }
        $institutions = Institution::where('status', 'active')->get();
        $reporting_managers = User::where('status', 'active')->where('is_super_admin', '!=', 1)->get();
        $divisions = Division::where('status', 'active')->get();
        $classes = Classes::where('status', 'active')->get();
        $params = array(
            'institutions' => $institutions,
            'reporting_managers' => $reporting_managers,
            'divisions' => $divisions,
            'classes' => $classes,
            'staff_details' => $staff_details ?? '',
            'used_classes' => $used_classes
        );
        return view('pages.staff.registration.index', $params);
    }

    public function insertPersonalData(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'institute_name' => 'required',
            'name' => 'required',
            'email' => 'required|string|unique:users,email,'.$id,
            'class_id' => 'required',
            'division_id' => 'required',
            'previous_code' => 'required',
            // 'previous_code' => 'required|string|unique:users,emp_code,'.$id,
        ]);

        if ($validator->passes()) {

            $academic_id = academicYearId();

            $ins['name'] = $request->name;
            $ins['email'] = $request->email;
            $ins['institute_id'] = $request->institute_name;
            $ins['academic_id'] = $academic_id;
            $ins['emp_code'] = $request->previous_code;
            $ins['first_name_tamil'] = $request->first_name_tamil;
            $ins['short_name'] = $request->short_name;
            $ins['division_id'] = $request->division_id;
            $ins['reporting_manager_id'] = $request->reporting_manager_id;
            $ins['status'] = 'active';

            $data = User::updateOrCreate(['emp_code' => $request->previous_code], $ins);
            if( $data ) {
                if( $request->class_id ) {
                    StaffClass::where('staff_id', $data->id)->delete();
                    foreach ( $request->class_id as $item ) {
                        $cls=[];
                        $cls['staff_id'] = $data->id;
                        $cls['academic_id'] = $academic_id;
                        $cls['class_id'] = $item;
                        StaffClass::create($cls);
                    }
                }
            }

            if( $request->aadhar_name && !empty( $request->aadhar_name ) ) {
                $aadhar_id = DocumentType::where('name', 'Adhaar')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $aadhar_id->id;
                $ins_aa['description'] = $request->aadhar_name;
                $ins_aa['doc_number'] = $request->aadhar_no ?? null;
                $ins_aa['verification_status'] = 'pending';
                
                /** 
                 *  check file is exists
                 */
                if( $request->hasFile('aadhar') ) {

                    $files = $request->file('aadhar');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file) {

                        $imageName = uniqid().Str::replace(' ', "-",$file->getClientOriginalName());


                        $directory              = 'staff/'.$request->previous_code.'/aadhar';
                        $filename               = $directory.'/'.$imageName;
                        
                        Storage::disk('public')->put($filename, File::get($file));

                        $imageIns[] = $filename;
                        $iteration++;
        
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;
                    
                    $ins_aa['multi_file'] = $file_name;
                }
                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $aadhar_id->id], $ins_aa);
            }   

            if( $request->pancard_name && !empty( $request->pancard_name ) ) {
                $pan_id = DocumentType::where('name', 'Pan Card')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $pan_id->id;
                $ins_aa['description'] = $request->pancard_name;
                $ins_aa['doc_number'] = $request->pancard_no ?? null;
                $ins_aa['verification_status'] = 'pending';
                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if( $request->hasFile('pancard') ) {

                    $files = $request->file('pancard');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file1) {

                        $imageName = uniqid().Str::replace(' ', "-",$file1->getClientOriginalName());


                        $directory              = 'staff/'.$request->previous_code.'/pancard';
                        $filename               = $directory.'/'.$imageName;
                        
                        Storage::disk('public')->put($filename, File::get($file1));

                        $imageIns[] = $filename;
                        $iteration++;
        
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;
                    
                    $ins_aa['multi_file'] = $file_name;
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $pan_id->id], $ins_aa);
                
            }

            if( $request->ration_card_name && !empty( $request->ration_card_name ) ) {
                $ration_id = DocumentType::where('name', 'Ration Card')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $ration_id->id;
                $ins_aa['description'] = $request->ration_card_name;
                $ins_aa['doc_number'] = $request->ration_card_number ?? null;
                $ins_aa['verification_status'] = 'pending';

                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if( $request->hasFile('ration_card') ) {

                    $files = $request->file('ration_card');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file2) {

                        $imageName = uniqid().Str::replace(' ', "-",$file2->getClientOriginalName());


                        $directory              = 'staff/'.$request->previous_code.'/ration_card';
                        $filename               = $directory.'/'.$imageName;
                        
                        Storage::disk('public')->put($filename, File::get($file2));

                        $imageIns[] = $filename;
                        $iteration++;
        
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;
                    
                    $ins_aa['multi_file'] = $file_name;
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $ration_id->id], $ins_aa);
                
            }

            if( $request->license_name && !empty( $request->license_name ) ) {
                $license_id = DocumentType::where('name', 'Driving License')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $license_id->id;
                $ins_aa['description'] = $request->license_name;
                $ins_aa['doc_number'] = $request->license_number ?? null;
                $ins_aa['verification_status'] = 'pending';

                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if( $request->hasFile('driving_license') ) {

                    $files = $request->file('driving_license');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file3) {

                        $imageName = uniqid().Str::replace(' ', "-",$file3->getClientOriginalName());


                        $directory              = 'staff/'.$request->previous_code.'/driving_license';
                        $filename               = $directory.'/'.$imageName;
                        
                        Storage::disk('public')->put($filename, File::get($file3));

                        $imageIns[] = $filename;
                        $iteration++;
        
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;
                    
                    $ins_aa['multi_file'] = $file_name;
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $license_id->id], $ins_aa);
                
            }

            if( $request->voter_name && !empty( $request->voter_name ) ) {
                $voter_id = DocumentType::where('name', 'Voter ID')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $voter_id->id;
                $ins_aa['description'] = $request->voter_name;
                $ins_aa['doc_number'] = $request->voter_number ?? null;
                $ins_aa['verification_status'] = 'pending';
                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if( $request->hasFile('voter') ) {

                    $files = $request->file('voter');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file4) {

                        $imageName = uniqid().Str::replace(' ', "-",$file4->getClientOriginalName());


                        $directory              = 'staff/'.$request->previous_code.'/voter';
                        $filename               = $directory.'/'.$imageName;
                        
                        Storage::disk('public')->put($filename, File::get($file4));

                        $imageIns[] = $filename;
                        $iteration++;
        
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;
                    
                    $ins_aa['multi_file'] = $file_name;
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $voter_id->id], $ins_aa);
                
            }

            if( $request->passport_name && !empty( $request->passport_name ) ) {
                $passport_id = DocumentType::where('name', 'Passport')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $passport_id->id;
                $ins_aa['description'] = $request->passport_name;
                $ins_aa['doc_number'] = $request->passport_number ?? null;
                $ins_aa['doc_date'] = $request->passport_valid_upto ? date('Y-m-d', strtotime($request->passport_valid_upto)) : null;
                $ins_aa['verification_status'] = 'pending';

                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if( $request->hasFile('passport') ) {

                    $files = $request->file('passport');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file5) {

                        $imageName = uniqid().Str::replace(' ', "-",$file5->getClientOriginalName());


                        $directory              = 'staff/'.$request->previous_code.'/passport';
                        $filename               = $directory.'/'.$imageName;
                        
                        Storage::disk('public')->put($filename, File::get($file5));

                        $imageIns[] = $filename;
                        $iteration++;
        
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;
                    
                    $ins_aa['multi_file'] = $file_name;
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $passport_id->id], $ins_aa);
                
            }

            $error = 0;
            $message = 'Added successfully';
            $id = $data->id ?? '';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'id' => $id ?? '']);

    }

    public function getStaffDraftData(Request $request)
    {
        $code  = $request->code;

        $staff_details = User::where('verification_status', $code)
                                ->where('emp_code', 'like', '%%')->get();
        dd( $staff_details );
    }


}
