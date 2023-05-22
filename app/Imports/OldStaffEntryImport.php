<?php

namespace App\Imports;

use App\Models\Master\Institution;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OldStaffEntryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $school_code = $row['sch'];
        $name = $row['name'];
        $designation = $row['designation'];
        $aews_no = $row['aews_no'];
        $inst_emp_id = $row['inst_emp_id'];
        $old_emp_id = $row['old_emp_id'];

        $institution_details = Institution::where('code', $school_code)->first();

        if( $institution_details ) {

            $staff_info = User::where('emp_code', $old_emp_id)->where('institute_emp_code', $inst_emp_id)->first();
            $ins = [];
            $ins['name'] = $name;
            $ins['academic_id'] = academicYearId();
            $ins['society_emp_code'] = $aews_no;
            $ins['institute_emp_code'] = $inst_emp_id;
            $ins['emp_code'] = $old_emp_id;
            $ins['institute_id'] = $institution_details->id;
            $ins['status'] = 'active';
            
            if( $staff_info ) {
                User::where('id', $staff_info->id)->update($ins);
            } else {
                User::create($ins);
            }

        }
        
    }
}
