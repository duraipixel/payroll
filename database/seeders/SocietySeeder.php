<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocietySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ins = array(
            'name' => 'Amalorpavam Educational Welfare Society',
            'code' => 'AEWS',
        );

        DB::table('societies')->insert($ins);
    }
}
