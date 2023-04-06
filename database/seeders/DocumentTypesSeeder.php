<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ins = array(
            array(
                'academic_id' => academicYearId(),
                'name' => 'Adhaar',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'academic_id' => academicYearId(),
                'name' => 'Pan Card',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'academic_id' => academicYearId(),
                'name' => 'Ration Card',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'academic_id' => academicYearId(),
                'name' => 'Driving License',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'academic_id' => academicYearId(),
                'name' => 'Voter ID',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'academic_id' => academicYearId(),
                'name' => 'Passport',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
            )
        );
        DB::table('document_types')->insert($ins);
    }
}
