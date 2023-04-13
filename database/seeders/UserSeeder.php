<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seededAdminEmail = 'payrolladmin@yopmail.com';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        $year = AcademicYear::where('is_current', true)->first();
        if ($user === null) {
            $user = User::create([
                'name'                          => 'Payroll Admin',
                'email'                         => $seededAdminEmail,
                'password'                      => Hash::make('password'),
                'is_super_admin'                => 1,
                'created_at'                    => date('Y-m-d H:i:s')
                // 'academic_id'                   => $year->id
            ]);
        }

        $ins = array(
            array(
                'name'                          => 'Regular Staff',
                'email'                         => 'regularstaff@yopmail.com',
                'password'                      => Hash::make('12345678'),
                'academic_id'                   => $year->id,
                'institute_id'                  => 1,
                'emp_code'                      => '202301',
                'created_at'                    => date('Y-m-d H:i:s')

            ),
            array(
                'name'                          => 'Data Entry Staff',
                'email'                         => 'dataentrystaff@yopmail.com',
                'password'                      => Hash::make('12345678'),
                'academic_id'                   => $year->id,
                'institute_id'                  => 1,
                'created_at'                    => date('Y-m-d H:i:s'),
                'emp_code'                      => '202302',
            ),
            array(
                'name'                          => 'Data Entry Staff1',
                'email'                         => 'dataentrystaff1@yopmail.com',
                'password'                      => Hash::make('12345678'),
                'academic_id'                   => $year->id,
                'institute_id'                  => 1,
                'created_at'                    => date('Y-m-d H:i:s'),
                'emp_code'                      => '202303',
            ),
            array(
                'name'                          => 'Data Entry Staff',
                'email'                         => 'dataentrystaff2@yopmail.com',
                'password'                      => Hash::make('12345678'),
                'academic_id'                   => $year->id,
                'institute_id'                  => 1,
                'created_at'                    => date('Y-m-d H:i:s'),
                'emp_code'                      => '202304',
            )
            
        );
        DB::table('users')->insert($ins);
    }
}
