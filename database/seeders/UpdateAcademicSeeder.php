<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateAcademicSeeder extends Seeder
{

    public function run()
    {
        $d1 = new DateTime('2016-03-12');
        $d2 = new DateTime('1983-03-09');

        $diff = $d2->diff($d1);
        
        $count_year = $diff->y;
        $main_date = '2016-05-01';
        $count = 9;
        for ($i = 1; $i < $count_year; $i++) {
            $from_year =  date('Y-m-d', strtotime($main_date . ' - ' . $i . ' years'));
            $to_year = date('Y-m-d', strtotime($from_year.' + 1 years'));
            $ins = array(
                'from_year' => date('Y', strtotime($from_year)),
                'to_year' => date('Y', strtotime($to_year)),
                'from_month' => '4',
                'to_month' => '3',
                'is_current' => 0,
                'order_by' => $count,
                'status' => 'active'
            );

            $count++;
            // dd( $ins );
            AcademicYear::updateOrcreate(['from_year' => $from_year, 'to_year' => $to_year], $ins);
        }
    }
}
