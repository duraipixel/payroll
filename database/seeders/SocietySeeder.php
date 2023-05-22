<?php

namespace Database\Seeders;

use App\Models\Master\Society;
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
        Society::updateOrcreate(['code' => 'AEWS'], $ins);
    }
}
