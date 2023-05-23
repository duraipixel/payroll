<?php

namespace Database\Seeders;

use App\Models\ProfessionalTaxSlab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionalTaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ins['from_amount'] = '0.00';
        $ins['to_amount'] = '100000.00';
        $ins['tax_fee'] = '0';
        $ins['status'] = 'active';
        ProfessionalTaxSlab::updateOrcreate(['from_amount' => '0.00', 'to_amount' => '100000.00'], $ins);

        $ins = [];
        $ins['from_amount'] = '100000.00';
        $ins['to_amount'] = '200000.00';
        $ins['tax_fee'] = '250';
        $ins['status'] = 'active';
        ProfessionalTaxSlab::updateOrcreate(['from_amount' => '100000.00', 'to_amount' => '200000.00'], $ins);

        $ins = [];
        $ins['from_amount'] = '200000.00';
        $ins['to_amount'] = '300000.00';
        $ins['tax_fee'] = '500';
        $ins['status'] = 'active';
        ProfessionalTaxSlab::updateOrcreate(['from_amount' => '200000.00', 'to_amount' => '300000.00'], $ins);

        $ins = [];
        $ins['from_amount'] = '300000.00';
        $ins['to_amount'] = '400000.00';
        $ins['tax_fee'] = '750';
        $ins['status'] = 'active';
        ProfessionalTaxSlab::updateOrcreate(['from_amount' => '300000.00', 'to_amount' => '400000.00'], $ins);

        $ins = [];
        $ins['from_amount'] = '400000.00';
        $ins['to_amount'] = '500000.00';
        $ins['tax_fee'] = '1000';
        $ins['status'] = 'active';
        ProfessionalTaxSlab::updateOrcreate(['from_amount' => '400000.00', 'to_amount' => '500000.00'], $ins);

        $ins = [];
        $ins['from_amount'] = '500000.00';
        $ins['to_amount'] = '0.00';
        $ins['tax_fee'] = '1250';
        $ins['status'] = 'active';
        ProfessionalTaxSlab::updateOrcreate(['from_amount' => '500000.00', 'to_amount' => '0.00'], $ins);
    }
}
