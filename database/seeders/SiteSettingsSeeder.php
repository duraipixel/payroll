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
        $data = DB::table('site_settings')->where('id', 1)->first();
        if($data){
            DB::table('site_settings')->where('id', 1)->update($ins);
        } else {
            DB::table('site_settings')->insert($ins);
        }
    }
}
