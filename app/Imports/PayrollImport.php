<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;

class PayrollImport implements ToCollection,
{
    public $collection;

    public function collection(Collection $rows)
    {
        dd($rows);
    }
  
}
