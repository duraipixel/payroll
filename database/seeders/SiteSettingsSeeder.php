<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ins = array(
            'site_name' => 'AMALORPAVAM PAYROLL SYSTEM v1.0',
        );

        DB::table('site_settings')->insert($ins);
    }
}
