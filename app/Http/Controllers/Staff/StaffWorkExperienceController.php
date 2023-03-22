<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Master\Designation;
use App\Models\Master\OtherSchool;
use App\Models\Staff\StaffWorkExperience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class StaffWorkExperienceController extends Controller
{
    public function save(Request $request)
    {
        
        $id = $request->experience_id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
                                'experience_institute_name' => 'required',
                                'experience_designation' => 'required',
                                'experience_from' => 'required',
                                'experience_to' => 'required',
                                'experince_institute_address' => 'required',
                                'salary_drawn' => 'required',
                                'experience_year' => 'required',
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;
            $staff_info = User::find($staff_id);
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['from'] = date('Y-m-d', strtotime($request->experience_from));
            $ins['to'] = date('Y-m-d', strtotime($request->experience_to));
            $ins['institue_id'] = $request->experience_institute_name;
            $ins['designation_id'] = $request->experience_designation;
            $ins['address'] = $request->experince_institute_address;
            $ins['salary_drawn'] = $request->salary_drawn;
            $ins['experience_year'] = $request->experience_year;
            $ins['remarks'] = $request->experience_remarks;
            $ins['status'] = 'active';

            if ($request->hasFile('experince_file')) {
    
                $files = $request->file('experince_file');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/experience';
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['doc_file'] = $filename;
            }

            $data = StaffWorkExperience::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';
           
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function formContent(Request $request)
    {
        
        $experience_id = $request->experience_id;
        $info = StaffWorkExperience::find($experience_id);
        $other_schools = OtherSchool::where('status', 'active')->get();
        $designation = Designation::where('status', 'active')->get();

        $params = array(
                'experience_info' => $info,
                'other_schools' => $other_schools,
                'designation' => $designation
            );
        
        return view('pages.staff.registration.education.experience_form_content', $params);

    }

    public function getStaffExperienceList(Request $request)
    {
        $staff_id = $request->staff_id;
        $experience_details = StaffWorkExperience::where('status', 'active')
                                ->where('staff_id', $staff_id)->get();
        $params = array('experience_details' => $experience_details);

        return view('pages.staff.registration.education.experience_list', $params);
    }

    public function deleteStaffExperience(Request $request)
    {
        $experience_id = $request->experience_id;
        StaffWorkExperience::where('id', $experience_id)->delete();
        return response()->json(['error' => 1]);
    }
}
