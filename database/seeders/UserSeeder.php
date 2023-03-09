<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
                'is_super_admin'                => 1
                // 'academic_id'                   => $year->id
            ]);
        }
    }
}
