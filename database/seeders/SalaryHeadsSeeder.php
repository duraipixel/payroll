<?php

namespace Database\Seeders;

use App\Models\PayrollManagement\SalaryHead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryHeadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ins['academic_id'] = academicYearId();
        $ins['name'] = 'EARNINGS';
        $ins['description'] = 'EARNINGS';
        $ins['status'] = 'active';
        $ins['is_static'] = 'yes';
        $ins['added_by'] = 1;

        SalaryHead::updateOrcreate(['academic_id' => academicYearId(), 'name' => 'EARNINGS'], $ins);

        $ins['academic_id'] = academicYearId();
        $ins['name'] = 'DEDUCTIONS';
        $ins['description'] = 'DEDUCTIONS';
        $ins['status'] = 'active';
        $ins['is_static'] = 'yes';
        $ins['added_by'] = 1;

        SalaryHead::updateOrcreate(['academic_id' => academicYearId(), 'name' => 'DEDUCTIONS'], $ins);
    }
}
