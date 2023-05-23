<?php

namespace Database\Seeders;

use App\Models\AttendanceManagement\LeaveHead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveHeadSeeder extends Seeder
{
   
    public function run()
    {
        $ins['academic_id'] = academicYearId();
        $ins['name'] = 'Casual Leave';
        $ins['code'] = 'CL';
        $ins['status'] = 'active';
        $ins['is_static'] = 'yes';
        $ins['sort_order'] = 1;

        LeaveHead::updateOrcreate(['code' => 'CL'], $ins);

        $ins = [];
        $ins['academic_id'] = academicYearId();
        $ins['name'] = 'Earned Leave';
        $ins['code'] = 'EL';
        $ins['status'] = 'active';
        $ins['is_static'] = 'yes';
        $ins['sort_order'] = 2;

        LeaveHead::updateOrcreate(['code' => 'EL'], $ins);

        $ins = [];
        $ins['academic_id'] = academicYearId();
        $ins['name'] = 'Maternity Leave';
        $ins['code'] = 'ML';
        $ins['status'] = 'active';
        $ins['is_static'] = 'yes';
        $ins['sort_order'] = 3;

        LeaveHead::updateOrcreate(['code' => 'ML'], $ins);

        $ins = [];
        $ins['academic_id'] = academicYearId();
        $ins['name'] = 'EOL';
        $ins['code'] = 'EOL';
        $ins['status'] = 'active';
        $ins['is_static'] = 'yes';
        $ins['sort_order'] = 4;

        LeaveHead::updateOrcreate(['code' => 'EOL'], $ins);


    }
}
