<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Master\Board;
use App\Models\Master\ProfessionType;
use App\Models\Master\Subject;
use App\Models\Staff\StaffEducationDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StaffEducationController extends Controller
{
    public function save(Request $request)
    {
        
        $id = $request->course_id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
                                'course_name' => 'required',
                                'course_completed_year' => 'required|date_format:Y-m-d',
                                'main_subject_id' => 'required',
                                'ancillary_subject_id' => 'required',
                                'course_certificate_no' => 'required',
                                'course_submitted_date' => 'required|date_format:Y-m-d',
                                'staff_id' => 'required',
                                'course_certificate_no' => 'required|integer',
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;
            $staff_info = User::find($staff_id);
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['course_name'] = $request->course_name;
            $ins['course_completed_year'] = date('Y-m-d', strtotime($request->course_completed_year));
            $ins['board_id'] = $request->board_id;
            $ins['main_subject_id'] = $request->main_subject_id;
            $ins['ancillary_subject_id'] = $request->ancillary_subject_id;
            $ins['certificate_no'] = $request->course_certificate_no;
            $ins['submitted_date'] = date('Y-m-d', strtotime($request->course_submitted_date));
            $ins['education_type'] = $request->course_professional_type;

            if ($request->hasFile('course_file')) {
    
                $files = $request->file('course_file');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/course';
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['doc_file'] = $filename;
            }
            
            $ins['status'] = 'active';
            $data = StaffEducationDetail::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added Successfully';
           
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function list(Request $request)
    {
        $staff_id = $request->staff_id;
        $course_details = StaffEducationDetail::where('status', 'active')
                                ->where('staff_id', $staff_id)                                
                                ->get();
        $params = array('course_details' => $course_details);

        return view('pages.staff.registration.education.course', $params);
    }

    public function formContent(Request $request)
    {
        $staff_id = $request->staff_id;
        $course_id = $request->course_id;
        $boards = Board::where('status', 'active')->get();
        $types = ProfessionType::where('status', 'active')->get();
        $course_details = StaffEducationDetail::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        
        $course_info = StaffEducationDetail::where('staff_id', $staff_id)->where('id', $course_id)->first();

        $params = array(
            'course_info' => $course_info,
            'course_details' => $course_details,
            'types' => $types,
            'boards' => $boards,
            'subjects' => $subjects
        );
        return view('pages.staff.registration.education.course_form_content', $params );
    }

    public function deleteStaffCourse(Request $request)
    {
        $course_id = $request->course_id;
        StaffEducationDetail::where('id', $course_id)->delete();
        return response()->json(['error' => 1]);
    }

}
