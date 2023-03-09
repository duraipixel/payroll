<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
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
                'from_year' => '2016',
                'to_year' => '2017',
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => false,
                'order_by' => 1,
                'status' => 'active'
            ),
            array(
                'from_year' => '2017',
                'to_year' => '2018',
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => false,
                'order_by' => 1,
                'status' => 'active'
            ),
            array(
                'from_year' => '2018',
                'to_year' => '2019',
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => false,
                'order_by' => 1,
                'status' => 'active'
            ),
            array(
                'from_year' => '2019',
                'to_year' => '2020',
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => false,
                'order_by' => 1,
                'status' => 'active'
            ),
            array(
                'from_year' => '2020',
                'to_year' => '2021',
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => false,
                'order_by' => 1,
                'status' => 'active'
            ),
            array(
                'from_year' => '2021',
                'to_year' => '2022',
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => false,
                'order_by' => 1,
                'status' => 'active'
            ),
            array(
                'from_year' => '2022',
                'to_year' => '2023',
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => true,
                'order_by' => 1,
                'status' => 'active'
            ),
        );

        DB::table('academic_years')->insert($ins);
    }
}
