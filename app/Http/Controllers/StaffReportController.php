<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Master\Classes;
use App\Models\Master\DocumentType;
use App\Models\Master\Subject;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffReportController extends Controller
{
    function collection($request)
    {
        return User::when(!empty($request->name), function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->name . '%');
        })->whereHas('position.department', function ($q) use ($request) {
            if (!empty($request->department)) $q->where('id', '=', $request->department);
        })->select('*');
    }
    function staff_index(Request $request)
    {
        $users = $this->collection($request)->paginate(15);
        return view('pages.reports.staff.history.index', ['users' =>  $users]);
    }
    function export_collection($user)
    {
        $classes = Classes::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $joining = StaffAppointmentDetail::selectRaw('min(joining_date) as joining_date')->where('staff_id', $user->id)->first();

        $subject_handling = DB::select("SELECT 
                                    COUNT(*) AS subject_count,
                                    STUFF((
                                    SELECT ',' + CAST(subject_id AS VARCHAR(10))
                                    FROM staff_handling_subjects
                                    where staff_id = " . $user->id . "
                                    group by subject_id
                                    FOR XML PATH(''), TYPE
                                    ).value('.', 'NVARCHAR(MAX)'), 1, 1, '') AS concatenated_subjects
                                FROM staff_handling_subjects s ");

        if (isset($subject_handling[0]) && $subject_handling[0]->subject_count > 0) {

            $string_comes = $subject_handling[0]->concatenated_subjects;
            $string_comes = explode(",", $string_comes);
            $subject_details = Subject::whereIn('id', $string_comes)->get();
        }

        $class_handling = DB::select("SELECT 
                                    COUNT(*) AS class_count,
                                    STUFF((
                                    SELECT ',' + CAST(class_id AS VARCHAR(10))
                                    FROM staff_handling_subjects
                                    where staff_id = " . $user->id . "
                                    group by class_id
                                    FOR XML PATH(''), TYPE
                                    ).value('.', 'NVARCHAR(MAX)'), 1, 1, '') AS concatenated_subjects
                                FROM staff_handling_subjects s ");
        if (isset($class_handling[0]) && $class_handling[0]->class_count > 0) {

            $class_string = $class_handling[0]->concatenated_subjects;
            $class_string = explode(",", $class_string);
            $class_details = Classes::whereIn('id', $class_string)->get();
        }

        $params = array(
            'user' => $user,
            'joining' => $joining,
            'subjects' => $subjects,
            'classes' => $classes,
            'class_details' => $class_details ?? [],
            'subject_details' => $subject_details ?? []
        );
        $view = view('pages.reports.staff.history.export', $params);
        return "$view";
    }
    function staff_export(Request $request)
    {
        $users = $this->collection($request)->get();
        $temp  = "";
        foreach($users as $user) {
            $temp .= $this->export_collection($user);
        }
        return  Pdf::loadHTML($temp)->setPaper('a4')->stream();
    }
}